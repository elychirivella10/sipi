<?php
// *************************************************************************************
// Programa: p_peribol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
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
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Perenci&oacute;n de Patentes por NO Consignar Publicaci&oacute;n en Prensa x Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 
$smarty->display('p_peribol.tpl');
$smarty->display('pie_pag.tpl');
?>
