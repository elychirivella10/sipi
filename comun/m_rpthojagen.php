<?php
// *************************************************************************************
// Programa: m_rpthojagen.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2016 I Semestre
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
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Hoja de Acta de Agentes Cargados');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas de Carga:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campo3','HASTA:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Rango de Agentes:');
$smarty->assign('varfocus','formarcas2.fechfon1'); 

$smarty->display('m_rpthojagen.tpl');
$smarty->display('pie_pag.tpl');
?>
