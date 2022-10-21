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
$modulo= "m_prevpro.php";

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
//$smarty->assign('subtitulo','Listado de Marcas Presentadas Mensual');
$smarty->assign('subtitulo','Listado de Marcas Publicadas Mensual');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='ENERO';
 $arraytipo[2]='FEBRERO';
 $arraytipo[3]='MARZO';
 $arraytipo[4]='ABRIL';
 $arraytipo[5]='MAYO';
 $arraytipo[6]='JUNIO'; 
 $arraytipo[7]='JULIO';
 $arraytipo[8]='AGOSTO';
 $arraytipo[9]='SEPTIEMBRE';
 $arraytipo[10]='OCTUBRE';
 $arraytipo[11]='NOVIEMBRE';
 $arraytipo[12]='DICIEMBRE';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo2','Boletin:');
//$smarty->assign('campo1','Mes:');
//$smarty->assign('campo2','Ano:');
$smarty->assign('varfocus','foravztra.desdet'); 
$smarty->display('m_revpro.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
