<script language="Javascript"> 

 function pregunta() { 
   return confirm('Estas seguro de actualizar la Informacion ?'); }
   
</script>

<?php
// *************************************************************************************
// Programa: m_actdevfondo.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2014 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Devueltas de Fondo Publicadas en Bolet&iacute;n sin Contestaci&oacute;n a Extinguir');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Paso de asignacion de variables de encabezados
$smarty->assign('campo6','Boletin:');
$smarty->assign('varfocus','forcaduca.boletin'); 
$smarty->display('m_actdevfondo.tpl');
$smarty->display('pie_pag.tpl');
?>
