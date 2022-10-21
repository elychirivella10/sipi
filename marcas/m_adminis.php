<?php
// ************************************************************************************* 
// Programa: m_adminis.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login  = $_SESSION['usuario_login'];
$fecha  = fechahoy();
$sql    = new mod_db();
$modulo = "m_adminis.php";
$fechahoy = hoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Administraci&oacute;n de B&uacute;squeda Fon&eacute;tica');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$sql->connection($login);

// Obtencion de Estadisticas
$objquery = $sql->query("SELECT count(*) AS total FROM stmbusqueda WHERE envio='S'");
$objs = $sql->objects('',$objquery);
$totcorreo = $objs->total;

$objquery = $sql->query("SELECT count(*) AS total FROM stmbusqueda WHERE envio='N'");
$objs = $sql->objects('',$objquery);
$totimpres = $objs->total;

$objquery = $sql->query("SELECT count(*) AS total FROM stmbusqueda WHERE envio='S' AND estatus_envio='N'");
$objs = $sql->objects('',$objquery);
$totcorsenv = $objs->total;

$objquery = $sql->query("SELECT count(*) AS total FROM stmbusqueda WHERE envio='S' AND estatus_envio='N' AND f_transac='$fechahoy'");
$objs = $sql->objects('',$objquery);
$totcorhoy = $objs->total;

//Desconexion de la Base de Datos
$sql->disconnect();

$smarty->assign('tcorreo',$totcorreo);
$smarty->assign('timpresora',$totimpres);
$smarty->assign('tsinenviar',$totcorsenv);
$smarty->assign('tcorreohoy',$totcorhoy);
$smarty->assign('modo','disabled'); 

$smarty->display('m_adminis.tpl');
$smarty->display('pie_pag.tpl');
?>
