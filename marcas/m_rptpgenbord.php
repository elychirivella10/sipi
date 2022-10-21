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
$smarty->assign('subtitulo','Generaci&oacute;n  de Orden de Publicaci&oacute;n en Prensa para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Conexion
$sql = new mod_db();
//Verificando conexion
$sql->connection();

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='SOLICITADAS';
 
//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Nro. Bolet&iacute;n:');
$smarty->assign('campo2','Tipo:');
$smarty->assign('campo3','A&ntilde;os de Independecia y Federaci&oacute;n:');
$smarty->assign('campo4','Fecha de Publicaci&oacute;n del Bolet&iacute;n:');
$smarty->assign('campo5','Nro. Resoluci&oacute;n:');
$smarty->assign('varfocus','forgenbol.boletin'); 
$smarty->display('m_rptpgenbord.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
