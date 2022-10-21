<?php
// *************************************************************************************
// Programa: m_actestbusweb.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Creado Año: 2017 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Cambio de Estatus a Tramite B&uacute;squeda Webpi para Reenvio');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Tramite:');
$smarty->assign('varfocus','forcaduca.tramite'); 
$smarty->display('m_actestbusweb.tpl');
$smarty->display('pie_pag.tpl');
?>
