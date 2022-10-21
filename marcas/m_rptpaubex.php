<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Comienzo del Programa por los encabezados del reporte
define('FPDF_FONTPATH',$root_path.'/font/');
include ("$include_path/fpdf.php");
ob_start();

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar); // Linea Modificada
$smarty->assign('subtitulo','Auditor&iacute;a de B&uacute;squeda Gr&aacute;ficas Externa');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

$contobji=0;
$vcodsede[$contobji] = '';
$vnomsede[$contobji] = '';
$objquery = $sql->query("SELECT * FROM stzsede ORDER BY sede");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodsede[$contobji] = $objs->sede;
  $vnomsede[$contobji] = trim(sprintf("%02d",$objs->sede)." ".trim($objs->nombre));
  $objs = $sql->objects('',$objquery); }	  

$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 

//Desconexion de la Base de Datos
$sql->disconnect();

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Sede:');
$smarty->assign('varfocus','formarcas2.desdec');
 
$smarty->display('m_rptpaubex.tpl'); // Dayana: $smarty->display('/templates/m_rptpaubex.tpl');
$smarty->display('pie_pag.tpl');

?>
