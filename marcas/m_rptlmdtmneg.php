<?php
// *************************************************************************************
// Programa: m_rptlmdtmneg.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza PIII 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCPN
// Creado Año: 2018 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = trim($_SESSION['usuario_login']);
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reporte de Lemas Detenidos con Marcas asociadas Negadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='saissami') || ($usuario=='rmendoza') || ($usuario=='ngonzalez')) { }
else {
  Mensajenew("ERROR: Usuario NO tiene Permiso a este Reporte ...!!!","m_rptlmdtmneg.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}

//Paso de asignacion de variables de encabezados
$smarty->display('m_rptlmdtmneg.tpl');
$smarty->display('pie_pag.tpl');
?>
