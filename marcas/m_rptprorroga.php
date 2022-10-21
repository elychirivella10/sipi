<?php
// *************************************************************************************
// Programa: m_rptprorroga.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$usuario = $_SESSION['usuario_login'];
$sql  = new mod_db();
$fecha   = fechahoy();
$modulo= "m_rptpoficio.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Prorrogas Otorgadas para Reingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud Inicial:');
$smarty->assign('campo2','Solicitud Final:');
$smarty->assign('varfocus','forofcfor.vsol1'); 
$smarty->display('m_rptprorroga.tpl');
$smarty->display('pie_pag.tpl');
?>
