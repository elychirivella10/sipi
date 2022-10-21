<?php
// *************************************************************************************
// Programa: m_reselimsol2.php 
// Realizado por el Analista de Sistema Ing. Maryury Bonilla
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Fecha: 23/04/2010 
// maryurybonilla20@gmail.com
// *************************************************************************************

//Llamo al editor enrriquesido
include("../editor/fckeditor.php") ;
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit();
}
//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$sql -> connection($usuario);
$fecha   = fechahoy();
$modulo  = "m_reselimsol2.php";

//Encabezado
$substmar="Subsistema de Resoluciones";
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Resoluciones de Marcas/Nueva Resoluci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


$id=$_POST['vistosnew'];
$est=$_GET['est'];
echo "VISTOS:<br>".$id;




//Campos
$smarty->assign('tvistos','VISTOS:');
$smarty->assign('campo1','Resoluci&oacute;n:');

//Valores
$smarty->assign('vistoAct',$vistoAct);
$smarty->assign('form',$form); 

//Dispaly 
$smarty->display('m_reselimsol2.tpl');
$smarty->display('pie_pag1.tpl');
?>
