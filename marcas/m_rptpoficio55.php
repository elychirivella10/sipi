<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$usuario = trim($_SESSION['usuario_login']);
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo  = "m_rptpoficio.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n Ley 55 Formato Viejo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$vusuario=$_GET['vuser'];
$vrol=$_GET['vrol'];

//if ($usuario!='rmendoza') {
//  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud Inicial:');
$smarty->assign('campo2','Solicitud Final:');
$smarty->assign('campo3','Usuario:');
$smarty->assign('campo4','Oficio(s) como:');
$smarty->assign('campo5','Cargados hasta el d&iacute;a:');

$smarty->assign('varfocus','forofcfor.vsol1');
$smarty->assign('arraytipod',array('D','T'));
$smarty->assign('arraydescd',array('Solo Devuelta(s)','En cualquier Estatus'));

 
$smarty->display('m_rptpoficio55.tpl');
$smarty->display('pie_pag.tpl');
?>
