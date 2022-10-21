<?php

// Programa de Cronologia de patentes
// Realizado por: Ing. Karina Perez

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "p_iniciopdf.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Documentos PDF');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// Control de acceso: Entrada y Salida al Modulo 
//if ($conx==0) { 
//  $smarty->assign('n_conex',$nconex);      }
//else {
//  $opra='C'; 
//  $res_conex = insconex($usuario,$modulo,$opra);
//  $smarty->assign('n_conex',$res_conex);   }

//if (($salir==0) && ($nconex>0)) {
//  $logout = salirconx($nconex);
//}

$smarty->assign('campo1','Nro. Solicitud:');
$smarty->assign('campo2','Tipo (Ejp.A1,A2,...):');
$smarty->assign('varfocus','forinicio.vsol1'); 
$smarty->display('inicio.tpl');
$smarty->display('pie_pag.tpl');
?>
