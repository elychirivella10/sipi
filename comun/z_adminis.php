<?php
// ************************************************************************************* 
// Programa: z_adminis.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//$nombre_session = "contadorconx";
//session_name($nombre_session);
//session_start();
//unset($_SESSION['conexion']);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login  = $_SESSION['usuario_login'];
$fecha  = fechahoy();
$modulo = "z_adminis.php";

$salir  = $_GET['salir'];
$nconex = $_GET['nconex'];

$smarty->assign('titulo','M&oacute;dulo de Configuraci&oacute;n');
$smarty->assign('subtitulo','Administraci&oacute;n del Sistema');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
}

$res_conex = insconex($login,$modulo,'A');
$smarty->assign('n_conex',$res_conex);

$smarty->display('z_adminis.tpl');
$smarty->display('pie_pag.tpl');
?>
