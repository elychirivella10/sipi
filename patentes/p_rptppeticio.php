<?php
// Programa de peticionario de patentes (reporte)
// Realizado por: Ing. Karina Perez

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();
$modulo= "p_rptppeticio.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Reporte de Peticionario de Patentes');
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

$smarty->assign('campo1','Recibo Nro.:');
$smarty->assign('campo2','Fecha:');
$smarty->assign('campo3','Peticionario Nro.:');
$smarty->assign('campo4','Titular:');
$smarty->assign('campo5','Nombre Solicitante:');
$smarty->assign('campo6','Tipo de Peticionario (A-Linea/B-Normal):');
$smarty->assign('varfocus','forcronol.desde1'); 
$smarty->display('p_rptppeticio.tpl');
$smarty->display('pie_pag.tpl');
?>
