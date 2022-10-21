<?php
// ************************************************************************************* 
// Programa: p_actelev.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año 2006 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = trim($_SESSION['usuario_login']);
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Patentes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='rmendoza') || ($usuario=='ngonzalez') || ($usuario=='buseche')) { }	 
else {
    Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}  

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty->assign('submitbutton','submit'); 
$smarty->assign('varfocus','forevind1.vsol1');
$smarty->assign('vmodo',''); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro:');

$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Nombre:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('varfocus','forevind1.vsol1'); 

$smarty->display('p_actelev.tpl');
$smarty->display('pie_pag.tpl');
?>
