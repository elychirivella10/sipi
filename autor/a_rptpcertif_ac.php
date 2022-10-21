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
$modulo= "a_rptpcertif_ac.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];
$egc  = $_GET['egc'];

//Conexion
$sql = new mod_db();
$sql->connection();

//Encabezados
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados de Actos y Contratos');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud Inicial:');
$smarty->assign('campo2','Solicitud   Final:');
$smarty->assign('varfocus','forcertif.vsold'); 
$smarty->assign('egc',$egc); 
$smarty->display('a_rptpcertif_ac.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
