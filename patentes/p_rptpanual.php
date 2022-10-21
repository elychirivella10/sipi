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

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Reporte de Anualidades');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Solicitud:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('ltipo','Tipo de Patente:');
$smarty->assign('arrayvmodal',array(T,A,B,C,D,E,F,G)); 
$smarty->assign('arraytmodal',array("Todas","Invenci&oacute;n","Dibujo Industrial","De Mejora","De Introducci&oacute;n","Modelo Industrial","Modelo de Utilidad","Dise&ntilde;o Industrial"));
 
$smarty->assign('varfocus','foravzcri.vsol1'); 
$smarty->display('p_rptpanual.tpl');
$smarty->display('pie_pag.tpl');

?>