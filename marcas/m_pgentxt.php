<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_pgentxt.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];
//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n  de las Negadas para Ventura');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Solicitudes:');
$smarty->assign('campo2','Articulo:');
$smarty->assign('campo3','Literal:');
$smarty->assign('campo4','Bolet&iacute;n:');
$smarty->assign('varfocus','forgenbol.vsol1'); 
$smarty->display('m_gentxt2.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
