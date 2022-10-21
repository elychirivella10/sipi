<?php
// *************************************************************************************
// Programa: m_rptconlog.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010
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
$smarty->assign('subtitulo','Auditor&iacute;a de B&uacute;squedas Fon&eacute;ticas/Gr&aacute;ficas Pendientes por Procesar');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha Tope de Factura Carga:');
$smarty->assign('campo2','Tipo de B&uacute;squeda:');
$smarty->assign('campo3','Estatus del Pedido:');
$smarty->assign('campo4','N&uacute;mero de Factura:');
$smarty->assign('campo5','Ordenado por No.:');
$smarty->assign('arraytipob',array('G','F','T'));
$smarty->assign('arraynotip',array('GRAFICA','FONETICA','AMBAS'));
$smarty->assign('arrayplus',array('1','2'));
$smarty->assign('arraydesplus',array('Por Procesar','Procesada por Enviar'));

$smarty->assign('varfocus','formarcas2.hastac'); 

$smarty->display('m_rptbuspen.tpl');
$smarty->display('pie_pag.tpl');
?>
