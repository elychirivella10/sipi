<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();

include ("../z_includes.php");

//Variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido"; exit();
}

$login = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "m_rptdevam.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n Anotaciones Marginales');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection();

//Asignación de variables para pasarlas a Smarty
$camposquery= "solicitud,registro,nombre,clase,ind_claseni,fecha_event,documento,comentario";
$camposname = "Solicitud,Registro,Nombre,Clase,Fecha Evento,Documento,Comentario";
$tablas     = "stmtmpam";
$condicion  = "evento=1502";
$orden      = "2";
$modo       = "Imprimir";
$modoabr    = "Sel.";
$vurl       = "m_rptdevam.php";
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
$smarty->assign('campo1','Fecha de Transacci&oacute;n:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('varfocus','forsolpre.vsol1'); 
$smarty->display('m_rptdevam.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();
?>
