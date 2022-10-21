<?php
// ************************************************************************************* 
// Programa: m_rptpaudmod.php 
// Realizado por el Analista de Sistema PIII Ing. Romulo Mendoza 
// Direccion de Sistemas y Tecnologias de la informacion / SAPI / MPPCN
// Desarrollo Año: 2021 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo  = "m_rptpaudmod.php";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reporte de Auditoria de Solicitudes Modificadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Solicitud:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('varfocus','foravzcri.vsol1');
 
$smarty->display('m_rptpaudmod.tpl');
$smarty->display('pie_pag.tpl');
?>
