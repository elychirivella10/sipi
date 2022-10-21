<script language="Javascript"> 

 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<?php
// ************************************************************************************* 
// Programa: z_estatus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$tbname_1 = "stzstder";
$fecha    = fechahoy();

$vopc    = $_GET['vopc'];
$accion  = $_POST['accion'];
$estatus = $_POST['estatus'];
$nombre  = $_POST['nombre'];
$estatus2 = $_POST['estatus2'];
$publica = $_POST['publica'];
$vstring= $_POST['vstring'];
$campos = $_POST['campos'];
$tipomp = $_POST['tipoder'];

$smarty->assign('titulo','Sistema de Marcas / Patentes');
$smarty->assign('subtitulo','Mantenimiento de Estatus'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Estatus / Ingreso'); }
if ($vopc==4 || $vopc==1) {
  $smarty->assign('subtitulo','Mantenimiento de Estatus / Modificacion'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

//Opcion de Modificacion
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('subtitulo','Mantenimiento de Estatus / Modificacion'); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmstatus2.nombre');

  //Verificando conexion
  $sql->connection();

  if (empty($tipomp)) {
    Mensajenew("No introdujo a que derecho se aplicara el Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($tipomp=='M') { $estatus = $estatus + 1000; }
  else { $estatus = $estatus + 2000; }  
  
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE estatus='$estatus'");
  if (!$resultado) { 
    mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $estatus=$reg[estatus];
  $nombre=trim($reg[descripcion]);
  $publica=$reg[publicable];

  if ($tipomp=='M') { $estatus = $estatus - 1000; }
  else { $estatus = $estatus - 2000; }  

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($nombre,$publica);
  $campos = "descripcion|publicable";
  $vstring = bitacora_fields();

  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('nombre',$nombre);
  $smarty->assign('publica',$publica);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);

}

if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Estatus / Ingreso'); 
  $smarty->assign('varfocus','frmstatus1.estatus');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
  $smarty->assign('aplica','V');
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Estatus / Modificacion'); 
  $smarty->assign('varfocus','frmstatus1.estatus'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('modo',''); 
  $smarty->assign('modo2','disabled'); 

  //Verificando conexion
  $sql->connection();

  if ($accion==1) { 
    $valor_edo=$estatus2; }
  else {
    $valor_edo=$estatus; }

  //Validacion del Numero de Evento
  if (empty($valor_edo)) {
    mensajenew("No introdujo ningún valor en Estatus ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($tipomp)) {
    Mensajenew("No introdujo a que derecho se aplicara el Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($nombre) || $publica=="V") {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
  if ($tipomp=='M') { $valor_edo = $valor_edo + 1000; }
  else { $valor_edo = $valor_edo + 2000; }  

  //al Incluir
  $insesta = true;  
  if ($accion==1) {
    $resultado=pg_exec("SELECT * FROM stzstder WHERE estatus='$valor_edo'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      Mensajenew("Codigo de Estatus YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
    $insert_str = "$valor_edo,'$nombre','$publica','$tipomp'";
    $insesta = $sql->insert("$tbname_1","","$insert_str","");
  }

  //al Modificar
  $actesta = true;  
  if ($accion==2) {
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Eventos
    pg_exec("LOCK TABLE stzstder IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "descripcion='$nombre',publicable='$publica'";
    $actesta = $sql->update("$tbname_1","$update_str","estatus='$valor_edo'");
  }
  
  if ($accion==1) {
    if ($insesta) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_estatus.php?vopc=3','S');
      $smarty->display('pie_pag.tpl'); exit(); }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }   
  }
  else {
    if ($actesta) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_estatus.php?vopc=4','S');
      $smarty->display('pie_pag.tpl'); exit(); }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    } 
  }    

}

$smarty->assign('apli_inf',array(V,S,N));
$smarty->assign('apli_def',array('','Si','No'));
$smarty->assign('tipo_der',array(M,P));
$smarty->assign('dere_def',array('Marcas','Patentes')); 

$smarty->assign('campo1','Estatus:');
$smarty->assign('campo2','Descripcion:');
$smarty->assign('campo3','Publicable:');
$smarty->assign('campo4','Aplica para Derecho:');

$smarty->assign('varfocus','frmstatus1.estatus'); 
$smarty->assign('vopc',$vopc);
$smarty->assign('estatus',$estatus);
$smarty->assign('tipoder',$tipomp);

$smarty->display('z_estatus.tpl');
$smarty->display('pie_pag.tpl');
?>
