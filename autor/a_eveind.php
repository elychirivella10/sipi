<?php
// *************************************************************************************
// Programa: a_eveind.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2008 
// Modificado Año: II Sem. 2009 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo  = "a_eveind.php";

// Obtencion de variables de los campos del tpl
$conx   = $_GET['conx'];
$nconex = $_GET['nconex'];
$salir  = $_GET['salir'];

$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************
// Control de acceso: Entrada y Salida al Modulo
if ($conx==0) {
  $smarty->assign('n_conex',$nconex);      }
else {
  $opra='I';
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez
$smarty->assign('submitbutton','submit');
$smarty->assign('varfocus','forevind1.vsol1');
$smarty->assign('vmodo','');

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Titulo:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Evento:');
$smarty->assign('varfocus','forevind1.vsol1');
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);

$smarty->display('a_eveind.tpl');
$smarty->display('pie_pag.tpl');
?>
