<?php
// *************************************************************************************
// Programa: p_rptpubpat.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2017 I Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Auditor&iacute;a de Publicaciones Prensa Patentes x Taquilla/Webpi');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha Publicaci&oacute;n:');

$smarty->assign('varfocus','formarcas2.hastac'); 
$smarty->display('p_rptpubpat.tpl');
$smarty->display('pie_pag.tpl');
?>
