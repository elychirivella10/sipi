<?php
// ************************************************************************************* 
// Programa: z_rptpetiweb.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Año: 2017 I Semestre BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();
$modulo= "z_rptpetiweb.php";

$smarty->assign('titulo','Sistema de Marcas/Patentes');
$smarty->assign('subtitulo','Reporte de Busqueda Peticionario WEBPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('campo1','Referencia Nro.:');
$smarty->assign('campo2','Peticionario Nro.:');
$smarty->assign('varfocus','forcronol.referencia'); 
$smarty->display('z_rptpetiweb.tpl');
$smarty->display('pie_pag.tpl');
?>
