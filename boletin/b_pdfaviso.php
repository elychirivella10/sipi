<?php
// *************************************************************************************
// Programa: b_genbol.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("b_funcionm.php");
include ("b_funcionp.php");
include ("b_resolucm.php");
include ("$include_lib/jlpdf.php");
require ("$include_lib/PDF_tablebol.php");
require("$include_lib/MPDF45/mpdf.php");
//require("$include_lib/rotation.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "b_pdfaviso.php";

// Definicion de Tablas 
$tbname_1 = "stzavisos";
$tbname_2 = "stztmpav";

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];

// ************************************************************************************
$smarty->assign('titulo',$substbol);
$smarty->assign('subtitulo','Generación de Avisos para el Boletín ');

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************  
//Verificando conexion
 $sql->connection($usuario);

// ************************************************************************************
if ($vopc==4) {
  $smarty->assign('varfocus','forboletin1.nbol');
}

// ************************************************************************************
if ($vopc==4) {
  $accion = "I";
  $nbol   = $_POST['nbol'];
  $boletin=$nbol;

  $nconex = $_POST['nconex'];
  if (empty($nbol)) {
    mensajenew("AVISO: No introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 
  //busco el nro-boletin en la tabla
  $res_boletin = pg_exec("select * from $tbname_1 a,$tbname_2 b where boletin='$nbol' and a.nro_aviso = b.nro_aviso");
  $filas_found = pg_numrows($res_boletin);
  if ($filas_found==0) {
      mensajenew("ERROR: Número de Boletín $nbol no existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); } 
  else {  
       //Inicio del Pdf
       $mpdf=new mPDF();
       for ($j=0; $j<$filas_found; $j++) {
           $reg_bol = pg_fetch_array($res_boletin);
	   $mpdf->ln(6); 
           $mpdf->WriteHTML($reg_bol['texto']); 
           if  ($j+1!=$filas_found) {$mpdf->AddPage();}
       }
       ob_end_clean(); 
       $sql->disconnect();
     //  $mpdf->Output("../../boletin/boletin_avisos.pdf");
       $mpdf->Output();
       // Despligue de mensajes  
       //echo "<H3><p> $msj </p></H3>"; 
       //Mensajenew('BOLETIN GENERADO CORRECTAMENTE !!!','b_pdfaviso.php?vopc=5','S'); 
       //$smarty->display('pie_pag1.tpl'); exit();
  }

} // final de $vopc==4

// ************************************************************************************ 

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Generar Avisos del Boletin No.:');
$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('varfocus','forboletin1.nbol'); 
$smarty->display('b_pdfaviso.tpl');
$smarty->display('pie_pag1.tpl');

?>
