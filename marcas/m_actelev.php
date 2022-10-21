<?php
// *************************************************************************************
// Programa: m_actelev.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = trim($_SESSION['usuario_login']);
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Marcas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario!='rmendoza') AND ($usuario!='ngonzalez') AND ($usuario!='buseche')) {	 
    Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}  
 
// mensajenew('Nelson ya modifique en m_actelev3.php para eliminar de las tablas el nuevo procedimiento forma/fondo, quita este mensaje en m_actelev.php.  ...!!!','javascript:history.back();','N');
// $smarty->display('pie_pag.tpl'); exit();
        
//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','forevind1.vsol1');
$smarty ->assign('vmodo',''); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Nombre:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('varfocus','forevind1.vsol1'); 

$smarty->display('m_actelev.tpl');
$smarty->display('pie_pag.tpl');
?>
