<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
//Conexion
//$sql = new mod_db();
//$sql->connection();

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Continuaci&oacute;n de Titulares, Distingues y Etiquetas de Certificados');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Registro Inicial:');
$smarty->assign('campo2','Registro Final:');
$smarty->assign('varfocus','forcertif.vreg1d'); 
$smarty->display('m_rptpconcert.tpl');
$smarty->display('pie_pag.tpl');

//$sql->disconnect();
?>
