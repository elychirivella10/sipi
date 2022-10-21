<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Estad&iacute;sticas de DNDA por Personas Naturales o Jur&iacute;dicas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='NATURAL';
 $arraytipo[2]='JURIDICA';
 
//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de A&ntilde;os:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo4','Tipo de Personas:');
$smarty->assign('varfocus','forestanu.anod'); 
$smarty->display('a_rptpnatj.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
