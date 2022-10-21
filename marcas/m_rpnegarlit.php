<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "m_rpnegarlit.php";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reporte de Negadas por Art&iacute;culo,Literal por Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Transaccion:');
$smarty->assign('campo1','Rango de Solicitudes:');
$smarty->assign('campo2','Articulo:');
$smarty->assign('campo3','Literal:');
$smarty->assign('campo4','Bolet&iacute;n:');
$smarty->assign('campo5','DESDE:');
$smarty->assign('campo6','HASTA:');
$smarty->assign('varfocus','forgenbol.desdet'); 
$smarty->display('m_rpnegarlit.tpl');
$smarty->display('pie_pag.tpl');

?>
