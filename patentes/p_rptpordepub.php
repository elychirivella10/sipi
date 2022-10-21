<?php
//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");


if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "p_rptpsolpre.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
//Encabezados
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Listado de Orden de Publicaci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='INVENCION';
 $arraytipo[2]='MEJORA';
 $arraytipo[3]='MODELO INDUSTRIAL';
 $arraytipo[4]='DISENO INDUSTRIAL';
 $arraytipo[5]='DE INTRODUCCION';
 $arraytipo[6]='DIBUJO INDUSTRIAL';
 $arraytipo[7]='MODELO DE UTILIDAD'; 
 $arraytipo[8]='VARIEDADES VEGETALES'; 

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

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



//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Nro. Boletin:');
$smarty->assign('campo4','Tipo de Patente:');
$smarty->assign('varfocus','forordpub.vsol1'); 
$smarty->display('p_rptpordepub.tpl');
$smarty->display('pie_pag.tpl');

?>
