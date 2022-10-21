<?php
// *************************************************************************************
// Programa: p_eveind.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado Año 2009 BD Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','forevind1.vsol1');
$smarty ->assign('vmodo',''); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro:');

$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Titulo:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Evento:');
$smarty->assign('varfocus','forevind1.vsol1'); 
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);

$smarty->display('p_eveind.tpl');
$smarty->display('pie_pag.tpl');
?>
