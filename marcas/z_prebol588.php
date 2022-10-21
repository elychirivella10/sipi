<?php
// *************************************************************************************
// Programa: z_prebol588.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Año: 2019 II Semestre 
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
$smarty->assign('subtitulo','Botetin Extraordinario Perencion de Recursos y Acciones por NO Ratificacion por Publicar, Cont. Bol. 588');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

mensajenew('AVISO: Opci&oacute;n del sistema Bloqueada por ya haberse ejecutado, contactar al Administrador ...!!!','../index1.php','N');
$smarty->display('pie_pag.tpl'); exit();

$smarty ->assign('lboletin','Bolet&iacute;n:'); 
$smarty->display('z_prebol588.tpl');
$smarty->display('pie_pag.tpl');

?>
