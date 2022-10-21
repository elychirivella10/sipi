<?
require('aut_verifica.inc.php');
require('include.php');
$smarty->assign('titulop','');
$smarty->assign('titulo','');

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$login= $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$smarty->display('encabezado.tpl');

require ('example-hormenu.php');
$smarty->display('cuerpo.tpl');

$smarty->display('pie_pag.tpl');
?>
