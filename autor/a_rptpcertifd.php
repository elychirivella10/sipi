<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();
$modulo= "a_rptpcertifd.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];

//Conexion
$sql = new mod_db();
$sql->connection();

//Encabezados
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud Inicial:');
$smarty->assign('campo2','Solicitud   Final:');
$smarty->assign('varfocus','forcertif.vsold'); 
$smarty->display('a_rptpcertifd.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
