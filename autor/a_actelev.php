<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = trim($_SESSION['usuario_login']);
$fecha   = fechahoy();

$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Autor');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='rmendoza') || ($usuario=='ngonzalez')) { }	 
else {
    Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}  

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','forevind1.vsol2');
$smarty ->assign('vmodo',''); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Titulo:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('varfocus','forevind1.vsol2'); 

$smarty->display('a_actelev.tpl');
$smarty->display('pie_pag.tpl');
?>
