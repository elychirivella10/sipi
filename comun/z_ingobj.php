<script language="javascript">
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: z_ingobj.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substacc);
$smarty->assign('subtitulo','Mantenimiento del Menu / Ingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('campo1','Codigo:');
$smarty->assign('campo2','Nombre:');
$smarty->assign('campo3','Nivel:');
$smarty->assign('campo4','Nomenclatura:');

$smarty->assign('varfocus','forobjeto.codigo');
$smarty->assign('login',$usuario);

$smarty->display('z_ingobj.tpl');
$smarty->display('pie_pag.tpl');
?>
