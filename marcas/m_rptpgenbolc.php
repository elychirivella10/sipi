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
$smarty->assign('subtitulo','Generaci&oacute;n  de las Concedidas para la Emisi&oacute;n del Bolet&iacute;n');
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
 $arraytipo[1]='MARCA DE PRODUCTO';
 $arraytipo[2]='NOMBRE COMERCIAL';
 $arraytipo[3]='LEMA COMERCIAL';
 $arraytipo[4]='MARCA DE SERVICIO';
 $arraytipo[5]='MARCA COLECTIVA';
 $arraytipo[6]='DENOMINACION DE ORIGEN'; 
 $arraytipo[7]='RECLASIFICADAS MARCA DE PRODUCTO';
 $arraytipo[8]='RECLASIFICADAS NOMBRE COMERCIAL';
 $arraytipo[9]='RECLASIFICADAS LEMA COMERCIAL';
 $arraytipo[10]='RECLASIFICADAS MARCA DE SERVICIO';
 $arraytipo[11]='RECLASIFICADAS MARCA COLECTIVA';
 $arraytipo[12]='RECLASIFICADAS DENOMINACION DE ORIGEN';
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
$smarty->display('m_rptpgenbolc.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
