<?php
ob_start();
// *************************************************************************************
// Programa: p_actelev3.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$sql   = new mod_db();
$tbname_1 = "stppatee";
$tbname_2 = "stzevtrd";
$tbname_3 = "stzotrde";
$tbname_4 = "stzcaded";
$tbname_5 = "stzottid";
$tbname_6 = "stzsolic";
$tbname_7 = "stzderec";

$login = $_SESSION['usuario_login'];
$fecha = fechahoy();

//Validacion de Entrada
$vder=$_POST["vder"]; 
$anno=$_POST["anno"];
$numero=$_POST["numero"];
$fecha_solic=$_POST["fecha_solic"];
$tipo_paten=$_POST["tipo_paten"];
$nombre=$_POST["nombre"];
$estatus=$_POST["estatus"];
$descripcion=$_POST["descripcion"];
$fecha_venci=$_POST["fecha_venci"];
$registro=$_POST['registro'];
$fecha_regis=$_POST["fecha_regis"];
$fecha_publi=$_POST["fecha_publi"];
$tramitante=$_POST["tramitante"];
$poder=$_POST["poder"];
$agente=$_POST["agente"];

$evento=$_POST["evento"];
$esta_ant=$_POST["esta_ant"];
$fecha_event=$_POST["fecha_event"];
$fecha_venc=$_POST["fecha_venc"];
$fecha_trans=$_POST["fecha_trans"];
$documento=$_POST["documento"];
$comentario=$_POST["comentario"];
$usuario=$_POST['usuario'];
$secuencial=$_POST['secuencial'];
$botonname=$_POST['botonname'];
$solicitud = $anno."-".$numero;
$titular=$_POST['titular'];
$tnombre=$_POST['tnombre'];
$tdomicilio=$_POST['tdomicilio'];
$input2=$_POST['input2'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Patentes');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$actprim = true;
$instram = true;
$acttram = true;
$deltram = true;
$deldevo = true; 
$delreg  = true;

//Verificando conexion
$sql->connection($login);

if ($botonname=="Guardar") {
  if (empty($fecha_event) || empty($fecha_trans)) {
    mensajenew('La Fecha del Evento o de Transaccion esta vacia ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  $fechahoy = hoy();
  $esmayor=compara_fechas($fecha_event,$fechahoy);
  if ($esmayor==1) {
     mensajenew('NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 
  $esmayor=compara_fechas($fecha_solic,$fecha_event);
  if ($esmayor==1) {
     mensajenew('NO se puede ejecutar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 

  //Comienzo de transaccion 
  pg_exec("BEGIN WORK");

  //Actualizo en Maestra  
  if (!empty($estatus)) {
    $estatus = $estatus + 2000;
    $update_str = "estatus='$estatus',tipo_derecho='$tipo_paten',tramitante='$tramitante'";
   if (empty($fecha_venci) or empty($fecha_regis)) 
      { //$update_str = "estatus='$estatus', fecha_venc=null"; 
      }
    else 
      { $update_str = $update_str.", fecha_venc='$fecha_venci', fecha_regis='$fecha_regis'"; }
    $actprim = $sql->update("$tbname_7","$update_str","nro_derecho='$vder'"); 
  }
  else {
     mensajenew('El estatus de la Patente esta en blanco ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();
  }

  $comentario = str_replace("'","´",$comentario);
  $horactual=hora();

  $evento   = $evento + 2000; 
  $esta_ant = $esta_ant + 2000;  
  if ($secuencial==0 ) {
  
    //Inserto en Tramite 
    if (empty($fecha_venc)) {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder',$evento,'$fecha_event',nextval('stzevtrd_secuencial_seq'),$esta_ant,$documento,'$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    }
    else {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder',$evento,'$fecha_event',nextval('stzevtrd_secuencial_seq'),$esta_ant,'$fecha_venc',$documento,'$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    }  
    $instram = $sql->insert("$tbname_2","$col_campos","$insert_str",""); }
  else {
    //Actualizo en Tramite
    $update_str = "usuario='$usuario', estat_ant='$esta_ant', fecha_trans='$fecha_trans', fecha_event='$fecha_event', documento='$documento', comentario='$comentario'"; 
    if (empty($fecha_venc)) {
      $update_str = $update_str.", fecha_venc=null"; }
    else {  
      $update_str = $update_str.", fecha_venc='$fecha_venc'"; }
    $acttram = $sql->update("$tbname_2","$update_str","nro_derecho='$vder' and secuencial=$secuencial");
  }
}

if ($botonname=="Eliminar") {
  //Comienzo de transaccion 
  pg_exec("BEGIN WORK");
 
 //Actualizo en Patentes
 if (!empty($estatus)) {
    $estatus = $estatus + 2000;
    $update_str = "estatus='$estatus'";
    //if (empty($fecha_venci)) 
    //  { $update_str = "estatus='$estatus', fecha_venc=null"; }
    //else 
    //  { $update_str = "estatus='$estatus', fecha_venc='$fecha_venci'"; }
    $actprim = $sql->update("$tbname_7","$update_str","nro_derecho='$vder'");
 }
 else {
    mensajenew('El estatus de la Patente esta en blanco ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit();
 }

 if ($evento==2200) {
    mensajenew('Evento No puede Eliminarse ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
 else {
   $deltram = $sql->del("$tbname_2","nro_derecho='$vder' AND secuencial=$secuencial"); }

 if ($evento==500) {
   $deldevo = $sql->del("$tbname_4","nro_derecho='$vder'");
 } 

 if ($evento==795) {
    $update_str = "registro='',fecha_regis=null, fecha_venc=null";
    $delreg = $sql->update("$tbname_7","$update_str","nro_derecho='$vder'"); }

}

$actsoli = true;
$acttitu = true;
//Actualizar Titular
$update_str = "nombre='$tnombre'"; 
$actsoli = $sql->update("$tbname_6","$update_str","titular='$titular'");
$update_str = "nacionalidad='$input2',domicilio='$tdomicilio'";
$acttitu = $sql->update("$tbname_5","$update_str","titular='$titular' AND nro_derecho='$vder'");

if ($actprim AND $instram AND $acttram AND $delreg AND  
    $deltram AND $deldevo AND $actsoli AND $acttitu) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();
   
   Mensajenew('DATOS ACTUALIZADOS Y/O ELIMINADOS CORRECTAMENTE!!!','p_actelev.php','S');
   $smarty->display('pie_pag.tpl'); exit();
}
else {
   pg_exec("ROLLBACK WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();

   if (!$actprim)  { $error_der  = " - Maestra de Derecho "; }
   if (!$instram)  { $error_tra  = " - Tr&aacute;mite "; }
   if (!$acttram)  { $error_tra  = " - Tr&aacute;mite "; }
   if (!$deltram)  { $error_tra  = " - Tr&aacute;mite "; }
   if (!$deldevo)  { $error_dev  = " - Causales de Devoluci&oacute;n "; }
   if (!$actsoli)  { $error_sol  = " - Maestra de Solicitantes "; }
   if (!$acttitu)  { $error_tit  = " - Detalles del Solicitante "; }

   Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_der $error_tra $error_dev $error_sol $error_tit ...!!!","javascript:history.back();","N"); 
   $smarty->display('pie_pag.tpl'); exit();
}

?>
