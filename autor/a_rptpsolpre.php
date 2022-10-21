<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "a_rptpsolpre.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Reporte de Solicitudes Presentadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  $opra='C'; 
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

//Carga el tipo de marca para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='LITERARIAS';
 $arraytipo[2]='ARTE VISUAL';
 $arraytipo[3]='ESCENICAS';
 $arraytipo[4]='MUSICALES';
 $arraytipo[5]='AUDIOVISUALES Y RADIOFONICAS';
 $arraytipo[6]='PROGRAMAS DE COMPUTACION Y BASE DE DATOS';
 $arraytipo[7]='PRODUCIONES FONOGRAFICAS'; 
 $arraytipo[8]='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';
 $arraytipo[9]='ACTOS Y CONTRATOS';

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Fecha de Solicitud:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo3','Tipo de Obra:');

$smarty->assign('varfocus','foravzcri.vsol1'); 
//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->display('a_rptpsolpre.tpl');
$smarty->display('pie_pag.tpl');

?>
