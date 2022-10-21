<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Comienzo del Programa por los encabezados del reporte
define('FPDF_FONTPATH',$root_path.'/font/');
include ("$include_path/fpdf.php");
ob_start();

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Auditor&iacute;a de Entrega de Logos');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Modo de Env&iacute;o:');

$smarty->assign('arrayplus',array('N','T','I','C'));
$smarty->assign('arraydesplus',array('','TODAS','IMPRESORA','CORREO'));
$smarty->assign('varfocus','formarcas2.desdec'); 

$smarty->display('m_rptlogent.tpl'); 
$smarty->display('pie_pag.tpl');

?>
