<script language="Javascript"> 

 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<?php
// *************************************************************************************
// Programa: m_viena.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año 2006 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$sql      = new mod_db();
$tbname_1 = "stmviena";
$fecha    = fechahoy();

$vopc    = $_GET['vopc'];
$accion  = $_POST['accion'];
$ccv     = $_POST['ccv'];
$nombre  = $_POST['nombre'];
$ccv2    = $_POST['ccv2'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Codigos de Viena'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Codigos de Viena / Ingreso'); }
if ($vopc==4 || $vopc==1) {
  $smarty->assign('subtitulo','Mantenimiento de Codigos de Viena / Modificacion'); }
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
  $sql->connection($usuario);

  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE ccv='$ccv'");
  if (!$resultado) { 
    Mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $ccv=$reg[ccv];
  $nombre=trim($reg[descripcion]);

  //Paso a Smarty los Valores
  $smarty->assign('ccv',$ccv);
  $smarty->assign('nombre',$nombre);
}

if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Codigo de Viena / Ingreso'); 
  $smarty->assign('varfocus','frmstatus1.ccv');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
  $smarty->assign('aplica','V');
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Codigo de Viena / Modificacion'); 
  $smarty->assign('varfocus','frmstatus1.ccv'); 
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
  $sql->connection($usuario);

  if ($accion==1) { 
    $valor_edo=$ccv2; }
  else {
    $valor_edo=$ccv; }

  //Validacion del Numero de Evento
  if (empty($valor_edo)) {
    Mensajenew("ERROR: No introdujo ningún valor en Viena ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($nombre)) {
    mensajenew("ERROR: Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $insccv = true;
  $actccv = true;
  //al Incluir
  if ($accion==1) {
    $resultado=pg_exec("SELECT * FROM stmviena WHERE ccv='$ccv2'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      Mensajenew("ERROR: Codigo de Viena YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } 

    pg_exec("BEGIN WORK");
    $insert_str = "'$ccv2','$nombre',0";
    $insccv = $sql->insert("$tbname_1","","$insert_str","");
  }

  //al Modificar
  if ($accion==2) {
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Viena 
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmviena IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "descripcion='$nombre'";
    $actccv = $sql->update("$tbname_1","$update_str","ccv='$ccv'");
  }
  
  if ($insccv==true AND $actccv==true) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect(); }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
  }  

  if ($accion==1) {
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_viena.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_viena.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

$smarty->assign('campo1','C&oacute;digo:');
$smarty->assign('campo2','Descripci&oacute;n:');
$smarty->assign('varfocus','frmstatus1.ccv'); 
$smarty->assign('vopc',$vopc);
$smarty->assign('ccv',$ccv);
$smarty->assign('nombre',$nombre);

$smarty->display('m_viena.tpl');
$smarty->display('pie_pag.tpl');
?>
