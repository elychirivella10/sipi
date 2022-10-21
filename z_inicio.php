<?php
// *************************************************************************************
// Programa: z_inicio.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2016 I Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("setting.inc.php");
include ("$include_lib/library.php");

//Variables
$fecha   = fechahoy();
$smarty->assign('fechahoy',$fecha);

$smarty->display('z_inicio.tpl');
?>
