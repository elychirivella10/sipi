<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n  de las Solicitadas para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Verificando conexion
$sql = new mod_db();
$sql->connection();



//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Nro. Bolet&iacute;n:');
$smarty->assign('campo2','A&ntilde;os de Independecia y Federaci&oacute;n:');
$smarty->assign('campo3','Mes de Publicaci&oacute;n del Bolet&iacute;n:');
$smarty->assign('campo4','Nro. Resoluci&oacute;n:');
$smarty->assign('varfocus','forgenbol.boletin'); 
$smarty->display('m_rptpgenbol.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
