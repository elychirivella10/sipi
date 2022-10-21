<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptppoder.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];

$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Listado de Poderes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  $opra='C'; 
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

$smarty->assign('campo1','Nro. Poder Desde:');
$smarty->assign('campo2','Rango de Fecha Transaccion:');
$smarty->assign('campod','Desde:');
$smarty->assign('campoh','Hasta:');
$smarty->assign('varfocus','forpoder.desde1'); 
$smarty->display('m_rptppoder.tpl');
$smarty->display('pie_pag.tpl');
?>
