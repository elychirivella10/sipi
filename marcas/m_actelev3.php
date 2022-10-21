<?php
// *************************************************************************************
// Programa: m_actelev3.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// *************************************************************************************

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$sql   = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzevtrd";
$tbname_3 = "stmliaor";
$tbname_4 = "stzcaded";
$tbname_5 = "stzottid";
$tbname_6 = "stzsolic";
$tbname_7 = "stzderec";
$tbname_8 = "stzotrde";
$tbname_9 = "stzantma";
$tbname_10= "stmforfon";
$tbname_11= "stmdtforfon";
$tbname_12= "stzsoldev";
$tbname_13= "stzotrode";


$login = $_SESSION['usuario_login'];
$fecha = fechahoy();

//Verificando conexion
$sql->connection($login);

//Validacion de Entrada
$vder=$_POST["vder"];
$anno=$_POST["anno"];
$numero=$_POST["numero"];
$fecha_solic=$_POST["fecha_solic"];
$tipo_marca=$_POST["tipo_marca"];
$modalidad=$_POST["modalidad"];
$nombre=$_POST["nombre"];
$clase=$_POST["clase"];
$ind_claseni=$_POST["ind_claseni"];
$registro=$_POST['registro'];
$estatus=$_POST["estatus"];
$descripcion=$_POST["descripcion"];
$fecha_venci=$_POST["fecha_venci"];
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
$titular=$_POST['titular'];
$tnombre=$_POST['tnombre'];
$tdomicilio=$_POST['tdomicilio'];
$input2=$_POST['input2'];
$solicitud = $anno."-".$numero;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Marcas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$actderec = true;
$actmarca = true;
$instram  = true;
$acttram  = true;
$deltram  = true;
$delnega  = true;
$deldevo  = true;
$delreno  = true;  
$deldev1  = true;

if ($botonname=="Guardar") {
  if (empty($fecha_event) || empty($fecha_trans)) {
    mensajenew('La Fecha del Evento o de Transaccion esta vacia ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  $fechahoy = hoy();

  //$esmayor=compara_fechas($fechaeve,$fechahoy);
  $esmayor=compara_fechas($fecha_event,$fechahoy);
  if ($esmayor==1) {
     mensajenew('NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 
  //$esmayor=compara_fechas($solfecha,$fechaeve);
  $esmayor=compara_fechas($fecha_solic,$fecha_event);
  if ($esmayor==1) {
     mensajenew('NO se puede ejecutar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 
  
  //Actualizo en Maestra de Derecho y Marcas 
  if (!empty($estatus)) {
    $estatus = $estatus + 1000;
    $update_str = "nombre='$nombre',estatus='$estatus',tipo_derecho='$tipo_marca',tramitante='$tramitante'";
    if (empty($fecha_venci) or empty($fecha_regis)) 
      { //$update_str = "estatus='$estatus', fecha_venc=null"; 
      }
    else 
      { $update_str = $update_str.", fecha_venc='$fecha_venci', fecha_regis='$fecha_regis'"; }
    $actderec = $sql->update("$tbname_7","$update_str","nro_derecho='$vder'");
    $update_str = "modalidad='$modalidad',clase='$clase',ind_claseni='$ind_claseni'";
    $actmarca = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");
  }
  else {
     mensajenew('El estatus de la Marca esta en blanco ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  $comentario = str_replace("'","´",$comentario);
  $horactual=hora();

  $evento   = $evento + 1000;
  $esta_ant = $esta_ant + 1000;  
  if ($secuencial==0 ) { 
    //Inserto en Tramite 
    if (empty($fecha_venc)) {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder',$evento,'$fecha_event',nextval('stmevtrd_secuencial_seq'),$esta_ant,$documento,'$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
    }
    else {
      $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_str = "'$vder',$evento,'$fecha_event',nextval('stmevtrd_secuencial_seq'),$esta_ant,'$fecha_venc',$documento,'$fechahoy','$usuario','$mensa_automatico','$comentario','$horactual'";
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
 //Actualizo en Marcas 
 if (!empty($estatus)) {
    $estatus = $estatus + 1000;
    $evento = $evento + 1000;
    $update_str = "nombre='$nombre',estatus='$estatus',tipo_derecho='$tipo_marca',tramitante='$tramitante'";
    //if (empty($fecha_venci)) 
    //  { $update_str = "estatus='$estatus', fecha_venc=null"; }
    //else 
    //  { $update_str = "estatus='$estatus', fecha_venc='$fecha_venci'"; }
    //echo " $update_str $solicitud ";
    $actderec = $sql->update("$tbname_7","$update_str","nro_derecho='$vder'"); 
    $update_str = "modalidad='$modalidad'";
    $actmarca = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'"); 
 }
 else {
    mensajenew('El estatus de la Marca esta en blanco ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
 if ($evento==1200) {
    mensajenew('Evento No puede Eliminarse ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
 else {
   $deltram = $sql->del("$tbname_2","nro_derecho='$vder' AND secuencial=$secuencial"); }
   
 if ($evento==1225) {
   $delnega = $sql->del("$tbname_3","nro_derecho='$vder'");
   $delforma = $sql->del("$tbname_10","nro_derecho='$vder'"); 
 }

//Modificado por Romulo Mendoza Noviembre-2015
 if ($evento==1021) {
   $delforma = $sql->del("$tbname_10","nro_derecho='$vder'"); 
   $delforma1= $sql->del("$tbname_11","nro_derecho='$vder'"); 
 }

 //Anotaciones marginales
 if (($evento==1204) || ($evento==1205) || ($evento==1206) || ($evento==1207) || ($evento==1208) || ($evento==1209)) {
    $delreno = $sql->del("$tbname_9","nro_derecho='$vder' AND nanota='$documento'");     } 

 //Eventos de Devolucion 
 if (($evento==1500) || ($evento==1053)) {
   $deldevo = $sql->del("$tbname_4","nro_derecho='$vder'"); 
   $deldevo = $sql->del("$tbname_8","nro_derecho='$vder'");
   $deldevo = $sql->del("$tbname_12","nro_derecho='$vder'");
   $deldevo = $sql->del("$tbname_13","nro_derecho='$vder'");
   if ($evento==1500) {
     $deldev1 = $sql->del("$tbname_2","nro_derecho='$vder' AND evento=1053 AND fecha_event='$fecha_event' AND usuario='$usuario'"); }
   if ($evento==1053) {
     $deldev1 = $sql->del("$tbname_2","nro_derecho='$vder' AND evento=1500 AND fecha_event='$fecha_event' AND usuario='$usuario'"); }
 } 

 if ($evento==1795) {
    $update_str = "registro='',fecha_regis=null, fecha_venc=null";
    $actmarca = $sql->update("$tbname_7","$update_str","nro_derecho='$vder'"); }
}

$actsoli = true;
$acttitu = true;
//Actualizar Titular
$update_str = "nombre='$tnombre'"; 
$actsoli = $sql->update("$tbname_6","$update_str","titular='$titular'");
$update_str = "nacionalidad='$input2',domicilio='$tdomicilio'";
$acttitu = $sql->update("$tbname_5","$update_str","titular='$titular' and nro_derecho='$vder'");

if ($actderec AND $actmarca AND $instram AND $acttram AND $delreno AND
    $deltram AND $delnega AND $deldevo AND $deldev1 AND $actsoli AND $acttitu) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();
   
   Mensajenew('DATOS ACTUALIZADOS Y/O ELIMINADOS CORRECTAMENTE!!!','m_actelev.php','S');
   $smarty->display('pie_pag.tpl'); exit();
}
else {
   pg_exec("ROLLBACK WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();

   if (!$actderec) { $error_der  = " - Maestra de Derecho "; }
   if (!$actmarca) { $error_mar  = " - Maestra de Marcas "; }
   if (!$instram)  { $error_tra  = " - Tr&aacute;mite "; }
   if (!$acttram)  { $error_tra  = " - Tr&aacute;mite "; }
   if (!$deltram)  { $error_tra  = " - Tr&aacute;mite "; }
   if (!$delnega)  { $error_neg  = " - Literales de Negaci&oacute;n "; }
   if (!$deldevo)  { $error_dev  = " - Causales de Devoluci&oacute;n "; }
   if (!$actsoli)  { $error_sol  = " - Maestra de Solicitantes "; }
   if (!$acttitu)  { $error_tit  = " - Detalles del Solicitante "; }
   if (!$delreno)  { $error_tit  = " - Detalles del Solicitante "; }

   Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_der $error_mar $error_tra $error_neg $error_dev $error_sol $error_tit ...!!!","javascript:history.back();","N"); 
   $smarty->display('pie_pag.tpl'); exit();
}

?>
