<?php
// *************************************************************************************
// Programa: m_gperimida.php 
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
$tbname_7 = "stzderec";

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

$solicitud = $anno."-".$numero;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Cambio de Perimida a Recepción de Prensa');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$actderec = true;
$acttram  = true;
//echo "$vder, $anno, $numero"; exit();

//Actualizo en Maestra de Derecho y Marcas 
$update_str = "estatus='1005'";
$actderec = $sql->update("$tbname_7","$update_str","nro_derecho='$vder' AND tipo_mp='M'");

//Actualizo en Tramite
$update_str = "evento=1022, desc_evento='RECEPCION DE PUBLICACION EN PRENSA'"; 
$acttram = $sql->update("$tbname_2","$update_str","nro_derecho='$vder' and evento=1033");

if ($actderec AND $acttram) {
   pg_exec("COMMIT WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();
   
   Mensajenew('DATOS ACTUALIZADOS CORRECTAMENTE!!!','m_cperimida.php','S');
   $smarty->display('pie_pag.tpl'); exit();
}
else {
   pg_exec("ROLLBACK WORK");
   //Desconexion de la Base de Datos
   $sql->disconnect();

   Mensajenew("ERROR: Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N"); 
   $smarty->display('pie_pag.tpl'); exit();
}

?>
