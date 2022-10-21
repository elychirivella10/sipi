<?php
// ************************************************************************************* 
// Programa: m_elimtmp.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$sql   = new mod_db();
$fecha = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Eliminaci&oacute;n de Temporales de Elemento Figurativo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

//Borra tablas temporales creadas en la base de datos 
delri_tmpef();

$smarty->display('m_elimtmp.tpl');
$smarty->display('pie_pag.tpl');
?>
