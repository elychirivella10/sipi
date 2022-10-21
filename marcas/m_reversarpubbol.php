<?php
// *************************************************************************************
// Programa: m_reversarnegbol.php 
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

//Verificando conexion 
//$sql = new mod_db();
//$sql->connection($usuario);

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Eliminaci&oacute;n de Solicitadas Extranjeras por Bolet&iacute;n 599 mal actualizada');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 

mensajenew('AVISO: Opci&oacute;n del sistema Bloqueada una vez ejecutado el proceso de reversión ...!!!','javascript:history.back();','N');
$smarty->display('pie_pag.tpl'); exit();

$smarty->display('m_reversarpubbol.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();

?>
