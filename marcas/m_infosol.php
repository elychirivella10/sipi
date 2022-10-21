<?php
// *************************************************************************************
// Programa: m_infosol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = trim($_SESSION['usuario_login']);
$role    = trim($_SESSION['usuario_rol']);
$fecha   = fechahoy();
$vopc    = $_GET['vopc'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Expediente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($usuario);

//Verifica si el progrma esta en mantenimiento
$manphp = vman_php("m_infosol.php");
if (($manphp==1) AND ($role!="ADMIN")) {
  MensageError('AVISO: Modulo en Mantenimiento temporalmente ...!!!','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$smarty->assign('vopc',$vopc);
$smarty->display('m_infosol.tpl');
$smarty->display('pie_pag.tpl');
?>
