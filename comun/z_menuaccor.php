<?php
// ************************************************************************************* 
// Programa: z_adminis.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//include ("../setting.inc.php");
//Para trabajar con sessiones
//require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
//include ("$include_lib/library.php");
//Para trabajar con Smarty 
//require ("$root_path/include.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login  = trim($_SESSION['usuario_login']);
$nivel  = $_SESSION['usuario_nivel'];
$tbname_1 = "stzusuar";

$fecha  = fechahoy();
$modulo = "z_adminis.php";

//Verificando conexion SIPI
//$sql = new mod_db();
//$sql->connection();

//$obj_usr = $sql->query("SELECT * FROM $tbname_1 WHERE usuario='$login'");
//$objsusr = $sql->objects('',$obj_usr);
//$nombre  = strtoupper(trim($objsusr->nombres)." ".trim($objsusr->apellidos));

$smarty->assign('titulo',$titulo);
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
//$smarty->assign('boletinvigente',$boletinvigente);
//$smarty->assign('fechatopepago30',$fechatopepago30);
$smarty->display('encabezado1.tpl');
//$smarty->assign('nivel',$nivel);
//$smarty->assign('nombre',$nombre);

$smarty->display('z_menuaccor.tpl');
$smarty->display('pie_pag1.tpl');
?>
