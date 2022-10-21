<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpcronol.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Cronologia Administrativa');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

 //Verifica si el progrma esta en mantenimiento
// $manphp = vman_php("m_rptpcronol.php");
// if ($manphp==1) {
   //$sql->disconnect(); $smarty->display('encabezado1.tpl');
   MensageError('Modulo en Mantenimiento, usar la Consulta Interna ...!!!','N');
   $smarty->display('pie_pag.tpl'); exit();
 //}      

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

$smarty->assign('campo1','Nro. Solicitud:');
$smarty->assign('campo2','Nro. Registro:');
$smarty->assign('varfocus','forcronol.vsol1'); 
$smarty->display('m_rptpcronol.tpl');
$smarty->display('pie_pag.tpl');
?>
