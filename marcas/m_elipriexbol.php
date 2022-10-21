<?php
// *************************************************************************************
// Programa: m_elipriexbol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2016 I Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Verificando conexion 
//$sql = new mod_db();
//$sql->connection($usuario);

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Eliminaci&oacute;n de Prioridad Extinguida por Bolet&iacute;n mal actualizada a publicar en Bolet&iacute;n pr&oacute;ximo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 

$smarty->display('m_elipriexbol.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();

?>