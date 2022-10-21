<?php
// *************************************************************************************
// Programa: z_infoclave.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2010 II Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
//include ("z_includes.php");

//Para trabajar con Operaciones de Bases de Datos
include ("setting.inc.php");
//Para trabajar con Smarty 
//require ("$root_path/include.php");
//Para trabajar con sessiones
//require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
include ("$include_lib/library.php");

//if (($_SERVER['HTTP_REFERER']=="")) {
//   echo "Acceso Denegado..."; exit();}

//Variables
//$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Clave');
//$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
//$smarty->display('encabezado1.tpl');

$vopc = 4;

$smarty->assign('vopc',$vopc);
$smarty->display('z_infoclave.tpl');
//$smarty->display('pie_pag.tpl');
?>
