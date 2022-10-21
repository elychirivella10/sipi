<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");


if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
//$smarty->assign('titulo','Sistema de Marcas, Patentes y DNDA');
$smarty->assign('subtitulo','Mantenimiento de Colores del Sistema');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Paso de asignacion de variables de encabezados
$smarty->assign('campo0','Coloque el N&uacute;mero Correspondiente al Color Deseado');
$smarty->assign('campo1','Color de Fondo:');
$smarty->assign('campo2','Color de Letras:');
$smarty->assign('campo3','Color de Tabla Izquierda:');
$smarty->assign('campo4','Color de Letras Tabla Izq:');
$smarty->assign('campo5','Color de Tabla Derecha:');
$smarty->assign('varfocus','forconfcol.vsol1'); 
$smarty->display('m_pconfcol.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
