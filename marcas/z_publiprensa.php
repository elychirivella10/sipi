<?php
// *************************************************************************************
// Programa: z_publiprensa.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPIPN
// Creado Año: 2014
// Modificado Año 2018 BD Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "z_publiprensa.php";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitudes a Publicar en Prensa Digital SAPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Carga de Publicaci&oacute;n:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('varfocus','foravzcri.vsol1'); 
$smarty->display('z_publiprensa.tpl');
$smarty->display('pie_pag.tpl');

?>
