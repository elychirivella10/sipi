<?php
// *************************************************************************************
// Programa: m_rptplisbolr.php 
// Modificado por el Analista de Sistema Romulo Mendoza 
// A partir de m_rptplisbol.php creado por Ing. Karina Perez 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptplisbolr.php";
//Conexion
$sql = new mod_db();

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listados de RPI para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Verificando conexion
$sql->connection();

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='CONCEDIDAS'; 
 $arraytipo[2]='CONCEDIDAS RECLASIF.';
 $arraytipo[3]='NEGADAS';
 $arraytipo[4]='CADUCAS';
 $arraytipo[5]='PRIORIDAD EXTINGUIDA';
 //$arraytipo[9]='PRIORIDAD EXT.PRENSA EXTEMPORANEA';
 //$arraytipo[10]='PRIORIDAD EXT.PRENSA DEFECTUOSA';
 //$arraytipo[11]='PERIMIDAS X NO PUBLICACION EN PRENSA';
 $arraytipo[6]='CAMBIO DE NOMBRE';
 $arraytipo[7]='CAMBIO DE DOMICILIO';
 $arraytipo[8]='CESIONES';
 $arraytipo[9]='FUSIONES';
 $arraytipo[10]='LICENCIAS'; 
 $arraytipo[11]='RENOVACIONES';
 //$arraytipo[12]='ORDEN DE PUBLICACION';
 //$arraytipo[13]='OBSERVADAS DESISTIDAS DE OFICIO'; 
 //$arraytipo[14]='CADUCAS POR NO RENOVACION'; 
 $arraytipo[12]='REGISTROS NO RENOVADOS'; 
  
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
//$smarty->assign('campo2','Fecha Publicaci&oacute;n:');
$smarty->assign('campo4','Tipo de Listado:');
$smarty->assign('campo3','Nro. Bolet&iacute;n:');
$smarty->assign('varfocus','forlisbol.vsol1'); 
$smarty->display('m_rptplisbolr.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
