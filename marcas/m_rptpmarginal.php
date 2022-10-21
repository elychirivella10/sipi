<?php

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "m_rptpsolpre.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Reporte de Anotaciones Marginales para Boletin');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Solicitud:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campo3','Bolet&iacute;n:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('ltipo','Tipo de Anotacion:');
$smarty->assign('arrayvmodal',array(0,209,208,207,206,205,204));
$smarty->assign('arraytmodal',array("Todas","Cambios de Titular","Cambios de Domicilio","Licencias de Uso","Fusiones","Cesiones","Renovaciones"));
 
$smarty->assign('varfocus','foravzcri.vsol1'); 
$smarty->display('m_rptpmarginal.tpl');
$smarty->display('pie_pag.tpl');

?>
