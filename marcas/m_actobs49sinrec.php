<?php
// *************************************************************************************
// Programa: m_actobs49sinrec.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2015 I Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizacion a Solicitadas Observadas Inadmisible Art 49 Lopa Notificadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

mensajenew('AVISO: Opci&oacute;n del sistema Bloqueada una vez ejecutado el proceso ...!!!','../index1.php','N');
$smarty->display('pie_pag.tpl'); exit();

//Paso de asignacion de variables de encabezados
$smarty->display('m_actobs49sinrec.tpl');
$smarty->display('pie_pag.tpl');
?>
