<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpobscon.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Solicitudes Observadas sin Contestaci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Carga el tipo de marca para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='MARCA DE PRODUCTO';
 $arraytipo[2]='NOMBRE COMERCIAL';
 $arraytipo[3]='LEMA COMERCIAL';
 $arraytipo[4]='MARCA DE SERVICIO';
 $arraytipo[5]='MARCA COLECTIVA';
 $arraytipo[6]='DENOMINACION DE ORIGEN';
 

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
$smarty->assign('campo2','Bolet&iacute;n:');
$smarty->assign('campo3','Tipo de Marca:');

$smarty->assign('varfocus','forobscon.vsol1'); 

$smarty->display('m_rptobscon.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
