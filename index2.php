<?
//Para trabajar con Operaciones de Bases de Datos de Produccion
include ("setting.inc.php");
require('include.php');
//Para trabajar con sessiones
//require("aut_verifica.inc.php");

//Para trabajar con Operaciones de Bases de Datos
//include ("z_includes.php");

//if (($_SERVER['HTTP_REFERER']=="")) {
//   echo "Acceso Denegado..."; exit();}

//Variables
//$usuario = $_SESSION['usuario_login'];

$smarty->assign('titulop','');
$smarty->assign('titulo','');
$smarty->display('encabezado.tpl');

require ('index_acc.php');

$smarty->display('pie_pag.tpl');
?>
