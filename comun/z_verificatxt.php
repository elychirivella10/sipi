<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de verificar los Archivos TXT de Busquedas a Convertir a PDF ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_verificatxt.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Año: II Semestre 201/
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/PDF_tablesbfsrweb.php");

?>
<html>
<head>
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head> 

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables 
$usuario  = $_SESSION['usuario_login'];
$tbname_1 = "stmbusweb";
$tbname_2 = "stzusuar";
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

$smarty->assign('subtitulo','VERIFICACION DE ARCHIVOS BUSQUEDAS TXT WEBPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


if ($vopc==2) {
  $total_archivos = count(glob("/home/fonetica/webpi/{d*}",GLOB_BRACE));
  //echo "total_imagenes = ".$total_archivos;

  if ($total_archivos>0) {
    Mensajenew("AVISO: Hola ".$usuario." ten paciencia. Aun hay archivos que siguen convirtiendose en PDF. No dejes de verificar de nuevo ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else {
	 Mensajenew("AVISO: Enhorabuena ".$usuario.", NO hay archivo(s) que siga(n) convirtiendose en PDF. Ya puedes enviarlo(s) por correo. ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
}

$smarty->display('z_verificatxt.tpl');
$smarty->display('pie_pag.tpl');
?>
</body>
</html>
