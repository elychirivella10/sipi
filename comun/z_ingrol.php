<script language="javascript">
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: z_ingrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo  = "z_ingrol.php";

$conx     = $_GET['conx'];
$salir    = $_GET['salir'];
$nconex   = $_GET['nconex'];
$na_conex = $_GET['na_conex'];

$smarty->assign('titulo',$substacc);
$smarty->assign('subtitulo','Mantenimiento de Roles / Ingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($conx==0) { 
  $smarty->assign('n_conex',$nconex); 
  $smarty->assign('na_conex',$na_conex); }
else {
    $res_conex = insconex($usuario,$modulo,'I');
    $smarty->assign('n_conex',$res_conex); }
  
if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
}

$smarty->assign('campo1','Codigo');
$smarty->assign('campo2','Nombre:');
$smarty->assign('varfocus','forrole.codigo'); 
$smarty->assign('login',$usuario);
$smarty->assign('na_conex',$na_conex);

$smarty->display('z_ingrol.tpl');
$smarty->display('pie_pag.tpl');
?>
