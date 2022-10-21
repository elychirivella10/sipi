<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar);// Linea Modificada
$smarty->assign('subtitulo','Auditoria de Busquedas Graficas Internas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->display('m_rptpaubin.tpl');
$smarty->display('pie_pag.tpl');
?>
