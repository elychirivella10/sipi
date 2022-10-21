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
$modulo= "p_rptpoficio.php";

 //Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$vusuario=$_GET['vuser'];
$vrol=$_GET['vrol'];

//Verificando conexion
$sql->connection();
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];

//Carga el tipo de marca para mostrarlo en el combo
$blanco='';
$arraytipo[0]='';
$arraytipo[1]='200';
$arraytipo[2]='202';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud Inicial:');
$smarty->assign('campo2','Solicitud Final:');
$smarty->assign('campo3','Estatus del Oficio:');
$smarty->assign('campo4','Usuario:');

$smarty->assign('varfocus','forofcfor.vsol1');
$smarty->display('p_rptpoficio.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();
?>
