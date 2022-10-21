<?php
// *************************************************************************************
// Programa: m_lisdevreg.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_lisdevreg.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listado de Devoluciones a Notas Marginales a Publicar');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();


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
$smarty->assign('campo1','Fecha:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Usuario:');
$smarty->assign('varfocus','devreg.vsol1'); 
$smarty->assign('arrayvtrami',array(B,C,F,L,N,O,R));
$smarty->assign('arrayttrami',array('','Cesi&oacute;n','Fusi&oacute;n','Licencia de Uso','Cambio de Nombre','Cambio de Domicilio','Renovaci&oacute;n'));
$smarty->assign('ltramite','Tipo Anotaci&oacute;n:');    
$smarty->display('m_lisdevreg.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();
?>

