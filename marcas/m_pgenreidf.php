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
$modulo= "m_pgenreidf.php";


$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n de Reingresos de Devoluciones de Forma (Notas Marginales) para Ventura');
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
$smarty->assign('campo3','Bolet&iacute;n:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('varfocus','genreidf.fecsold'); 
$smarty->display('m_genreidf.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
