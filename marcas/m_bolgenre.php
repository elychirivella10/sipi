<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

//Variables
$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "m_bolgenre.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Anotaciones Marginales para el Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='DEVOLUCION ANOTACION MARGINAL';
 $arraytipo[2]='DESISTIMIENTO RENOVACIONES';
 $arraytipo[3]='DESISTIMIENTO CAMBIO DE NOMBRE';
 $arraytipo[4]='DESISTIMIENTO CAMBIO DE DOMICILIO';
 $arraytipo[5]='DESISTIMIENTO CESIONES';
 $arraytipo[6]='DESISTIMIENTO FUSIONES';
 $arraytipo[7]='DESISTIMIENTO LICENCIAS';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fecha de Transacci&oacute;n:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campo3','HASTA:');
$smarty->assign('campo4','Nro. Bolet&iacute;n:');
$smarty->assign('campo5','Tipo de Anotaci&oacute;n Marginal:');
$smarty->assign('varfocus','forlisbol.vsol1'); 
$smarty->display('m_bolgenre.tpl');
$smarty->display('pie_pag.tpl');

?>
