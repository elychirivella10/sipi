<script language="Javascript"> 

 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }

 function habilinf(vtipo,vcampo,vcampo1)
 {
   if (vtipo.value == "A") {
      vcampo.disabled = false;
      vcampo1.disabled = false;
      }
   if (vtipo.value == "N") {
      vcampo.value = ""; 
      vcampo.disabled = true;
      vcampo1.value = ""; 
      vcampo1.disabled = true;
      }
   if (vtipo.value == "D") {
      vcampo1.value = ""; 
      vcampo1.disabled = true;
      vcampo.disabled = false;
      }
   if (vtipo.value == "C") {
      vcampo.value = ""; 
      vcampo.disabled = true;
      vcampo1.disabled = false;
      }
 }

 function habilplz(vtipo,vcampo)
 {
   if (vtipo.value == "N") {
      vcampo.value = 0; 
      vcampo.disabled = true;
      }
   else { vcampo.value = "";
          vcampo.disabled = false; 
          }

 }
</script>

<?php
// ************************************************************************************* 
// Programa: z_evento.php 
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
$tbname_1 = "stzevder";
$tbname_2 = "stzbitac";
$fecha   = fechahoy();

$vopc   = $_GET['vopc'];
$accion = $_POST['accion'];
$evento = $_POST['evento'];
$nombre = $_POST['nombre'];
$tipo_evento  = $_POST['tipo_evento'];
$inf_adicional= $_POST['inf_adicional'];
$mensa_automatico = $_POST['mensa_automatico'];
$tipo_plazo= $_POST['tipo_plazo'];
$plazo_ley = $_POST['plazo_ley'];
$evento2 = $_POST['evento2'];
$documento  = $_POST['documento'];
$comentario = $_POST['comentario'];
$aplica = $_POST['aplica'];
$vstring= $_POST['vstring'];
$campos = $_POST['campos'];
$tipomp = $_POST['tipoder'];

$smarty->assign('titulo','Sistema de Marcas / Patentes');
$smarty->assign('subtitulo','Mantenimiento de Eventos'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Ingreso'); }
if ($vopc==4 || $vopc==1) {
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Modificacion'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','button');
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
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Modificaci&oacute;n'); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','forevento2.nombre');

  //Verificando conexion
  $sql->connection();

  if (empty($tipomp)) {
    Mensajenew("No introdujo a que derecho se aplicara el Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($tipomp=='M') { $evento = $evento + 1000; }
  else { $evento = $evento + 2000; }  

  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE evento='$evento'");
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
  $evento=$reg[evento];
  $descripcion=trim($reg[descripcion]);
  $tipo_evento=$reg[tipo_evento];
  $inf_adicional=$reg[inf_adicional];
  $mensa_automatico=trim($reg[mensa_automatico]);
  $plazo_ley=$reg[plazo_ley];
  $tipo_plazo=$reg[tipo_plazo];
  $tit_comenta=trim($reg[tit_comenta]);
  $tit_nro_doc=trim($reg[tit_nro_doc]);
  $aplica=$reg[aplica];
  $tipomp=$reg[tipo_mp];

  if ($tipomp=='M') { $evento = $evento - 1000; }
  else { $evento = $evento - 2000; }  

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($descripcion,$tipo_evento,$inf_adicional,$mensa_automatico,$tipo_plazo,$plazo_ley,$tit_comenta,$tit_nro_doc,$aplica);
  $campos = "descripcion|tipo_evento|inf_adicional|mensa_automatico|tipo_plazo|plazo_ley|tit_comenta|tit_nro_doc|aplica";
  $vstring = bitacora_fields();

  //Paso a Smarty los Valores
  $smarty->assign('evento',$evento);
  $smarty->assign('nombre',$descripcion);
  $smarty->assign('tipo_evento',$tipo_evento);
  $smarty->assign('inf_adicional',$inf_adicional);
  $smarty->assign('mensa_automatico',$mensa_automatico);
  $smarty->assign('tipo_plazo',$tipo_plazo);
  $smarty->assign('plazo_ley',$plazo_ley);
  $smarty->assign('documento',$tit_nro_doc);
  $smarty->assign('comentario',$tit_comenta);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
}

if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Ingreso'); 
  $smarty->assign('varfocus','forevento1.evento');
  $smarty->assign('vmodo',''); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
  $smarty->assign('inf_adicional','V');
  $smarty->assign('tipo_plazo','V');
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Modificaci&oacute;n'); 
  $smarty->assign('varfocus','forevento1.evento'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('modo',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('submitbutton','submit'); 
  $smarty->assign('submitbutton3','button');

  //Verificando conexion
  $sql->connection();

  if ($accion==1) { 
    $valor_even=$evento2; }
  else {
    $valor_even=$evento; }

  //Validacion del Numero de Evento
  if (empty($valor_even)) {
    mensajenew("No introdujo ningún valor en Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($tipomp)) {
    Mensajenew("No introdujo a que derecho se aplicara el Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($tipo_evento=="N") { $tipo_plazo="N"; $plazo_ley=0; }
  switch ($inf_adicional) {
     case "N":
         $documento=""; $comentario="";
         break;
     case "D":
         $comentario="";
         break;
     case "C":
         $documento="";
         break;
  }

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($nombre) || empty($tipo_evento) || empty($inf_adicional) || 
    empty($mensa_automatico) || empty($tipo_plazo)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
  if ($tipomp=='M') { $valor_even = $valor_even + 1000; }
  else { $valor_even = $valor_even + 2000; }  
  
  //al Incluir
  $inseven = true;
  if ($accion==1) {
    $resultado=pg_exec("SELECT * FROM stzevder WHERE evento='$valor_even'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      mensajenew("Codigo de Evento YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
    $escritoasoc="N";
    $insert_str = "$valor_even,'$nombre','$tipo_evento','$inf_adicional','$mensa_automatico',$plazo_ley,'$tipo_plazo','$comentario','$documento','$aplica','$tipomp','$escritoasoc'";
    $inseven = $sql->insert("$tbname_1","","$insert_str","");
  }

  //al Modificar
  $acteven = true;
  if ($accion==2) {
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Eventos
    pg_exec("LOCK TABLE stzevder IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "descripcion='$nombre',tipo_evento='$tipo_evento',inf_adicional='$inf_adicional',mensa_automatico='$mensa_automatico',plazo_ley='$plazo_ley',tipo_plazo='$tipo_plazo',tit_comenta='$comentario',tit_nro_doc='$documento',aplica='$aplica'";
    $acteven = $sql->update("$tbname_1","$update_str","evento='$valor_even'");
  }

  if ($accion==1) {
    if ($inseven) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_evento.php?vopc=3','S');
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
    if ($acteven) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','z_evento.php?vopc=4','S');
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

$smarty->assign('tipo_eve',array(N,M,C));
$smarty->assign('even_def',array('No Migrable','Migrable','Cableado'));
$smarty->assign('tipo_inf',array(V,N,A,D,C));
$smarty->assign('info_def',array('','Ninguno','Ambos','Documento','Comentario'));
$smarty->assign('tipo_plz',array(V,N,H,M,A));
$smarty->assign('plazo_def',array('','Ninguno','Habiles','Mensual','Anual'));
$smarty->assign('apli_inf',array(T,R,A));
$smarty->assign('apli_def',array('Tramite','Registro','Ambos'));
$smarty->assign('tipo_der',array(M,P));
$smarty->assign('dere_def',array('Marcas','Patentes')); 

$smarty->assign('campo1','Evento:');
$smarty->assign('campo2','Descripcion:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Informacion Adicional:');
$smarty->assign('campo5','Mensaje Automatico:');
$smarty->assign('campo6','Tipo Plazo:');
$smarty->assign('campo7','Plazo de Ley:');
$smarty->assign('campo8','Titulo de Documento:');
$smarty->assign('campo9','Titulo de Comentario:');
$smarty->assign('campo10','Aplica a:');
$smarty->assign('campo11','Aplica para Derecho:');
$smarty->assign('varfocus','forevento1.evento'); 
$smarty->assign('vopc',$vopc);
$smarty->assign('evento',$evento);
$smarty->assign('tipoder',$tipomp);

$smarty->display('z_evento.tpl');
$smarty->display('pie_pag.tpl');
?>
