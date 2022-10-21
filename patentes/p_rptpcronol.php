<?php

// Programa de Cronologia de patentes
// Realizado por: Ing. Karina Perez

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "p_rptpcronol.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Cronologia Administrativa');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('campo1','Nro. Solicitud:');
$smarty->assign('campo2','Nro. Registro:');
$smarty->assign('varfocus','forcronol.vsol1'); 
$smarty->display('p_rptpcronol.tpl');
$smarty->display('pie_pag.tpl');
?>
