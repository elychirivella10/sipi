<?php
// *************************************************************************************
// Programa: p_rptdevam.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2011
// *************************************************************************************

//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido"; exit();
}

$login = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "p_rptdevam.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','SubSistema de Patentes');
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n Anotaciones Marginales');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($login);

//Asignación de variables para pasarlas a Smarty
$camposquery= "solicitud,registro,nombre,evento,fecha_event,documento,comentario";
$camposname = "Solicitud,Registro,Nombre,Evento,Fecha Evento,Documento,Comentario";
$tablas     = "stptmpam";
$condicion  = "evento=2502";
$orden      = "1";
$modo       = "Imprimir";
$modoabr    = "Sel.";
$vurl       = "p_rptdevam.php";
$new_windows= "N";
   
$smarty->assign('camposquery',$camposquery);
$smarty->assign('camposname',$camposname);
$smarty->assign('tablas',$tablas);
$smarty->assign('condicion',$condicion);
$smarty->assign('orden',$orden); 
$smarty->assign('modo',$modo); 
$smarty->assign('modoabr',$modoabr); 
$smarty->assign('vurl',$vurl);
$smarty->assign('new_windows',$new_windows);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Solicitud:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('varfocus','forsolpre.fecsold'); 
$smarty->display('p_rptdevam.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();
?>
