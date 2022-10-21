<?php
// *************************************************************************************
// Programa: m_actelev.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Expediente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('vopc',$vopc);
$smarty->display('p_infosol_cualquierestatus.tpl');
$smarty->display('pie_pag.tpl');
?>
