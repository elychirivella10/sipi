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
$smarty->assign('subtitulo','Certificados de Patentes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Nro. Solicitud:');
$smarty->assign('campo2','Nro. Registro :');
$smarty->assign('varfocus','forcronol.vsol1'); 
$smarty->display('p_rptpcertp.tpl');
$smarty->display('pie_pag.tpl');

//$sql->disconnect();
?>
