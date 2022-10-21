<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpcertifd.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];

//Conexion
//$sql = new mod_db();
//$sql->connection($login);

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Registro Inicial:');
$smarty->assign('campo2','Registro Final:');
$smarty->assign('varfocus','forcertif.vreg1d'); 
$smarty->display('m_rptpcertifd.tpl');
$smarty->display('pie_pag.tpl');

//$sql->disconnect();
?>
