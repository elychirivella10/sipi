<?
require('include.php');
$smarty->assign('titulop','');
$smarty->assign('titulo','');
$smarty->display('encabezado.tpl');

require ('index_acc.php');
$smarty->display('pie_pag.tpl');
?>
