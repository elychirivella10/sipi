<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_pgendevreg.php";


$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n  de Devoluciones de Registro a Publicar para Ventura');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fecha:');
$smarty->assign('campod','Desde:');
$smarty->assign('campoh','Hasta:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campo3','Bolet&iacute;n:');
$smarty->assign('varfocus','gendevreg.fecsold'); 
$smarty->display('m_gendevreg.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
