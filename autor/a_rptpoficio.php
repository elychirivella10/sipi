<?php
// *************************************************************************************
// Programa: a_rptpoficio.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza 
// Dirección de Sistemas y Tecnologias de la Información / SAPI / MPPCN
// Año: 2008 - 2009
// Modificado Año 2022 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$usuario = trim($_SESSION['usuario_login']);
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo  = "a_rptpoficio.php";

//Encabezados
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//$vusuario=$_GET['vuser'];
//$vrol=$_GET['vrol'];

/*
if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {	 
    Mensajenew("ERROR: Modulo en Mantenimiento, Por favor comunicarse con el Administrador del Sistema ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}  
*/

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud Inicial:');
$smarty->assign('campo2','Solicitud Final:');
$smarty->assign('varfocus','forofcfor.vsol1'); 
$smarty->display('a_rptoficio.tpl');
$smarty->display('pie_pag.tpl');

?>

