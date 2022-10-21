<?php
// *************************************************************************************
// Programa: m_rptm400bol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2016 II Semestre 
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
$smarty->assign('subtitulo','Reporte de Marcas Concedidas por Bolet&iacute;n con Datos amplios del Titular');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='saissami') || ($usuario=='rmendoza') || ($usuario=='jvelasquez') || ($usuario=='ngonzalez') || ($usuario=='jrrodriguez')) { }
else {
  Mensajenew("ERROR: Usuario NO tiene Permiso a este Reporte ...!!!","m_rptm400bol.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 
$smarty->display('m_rptm400bol.tpl');
$smarty->display('pie_pag.tpl');
?>
