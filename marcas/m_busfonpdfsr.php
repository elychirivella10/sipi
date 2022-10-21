<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de generar el Archivos PDF sin Antecedentes ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_busfonpdfsr.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollo: II Semestre 2014
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_lib/PDF_tablesbfsrweb.php");
require ("$include_lib/PDF_tablesbfsr.php");

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
$tbname_1 = "stmbusqueda";
$tbname_2 = "stzusuar";
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

$smarty->assign('subtitulo','GENERACION DE ARCHIVOS BUSQUEDAS PDF SIN ANTECEDENTE');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('campo1','Nro. de Pedido:');

if ($vopc==1) {
  $smarty->assign('varfocus','forsolpre.pedido'); 
}

if ($vopc==2) {
 //Verificando conexion SIPI
 $sql = new mod_db();
 $sql->connection();

 //Validacion de Entrada
 $npedido  = $_POST["pedido"];

 if(empty($npedido)) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: N&uacute;mero de Pedido vacio ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
 }

 // Obtencion de los Registros o Filas   
 $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_pedido='$npedido'");
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   Mensajenew("ERROR: No hay archivos que generar ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $numerror  = 0;
 $fecha_hoy = hoy();
 $hora_bus = Hora();

 // Comienzo de Transaccion   
 $objs = $sql->objects('',$obj_query);
 $factura = trim($objs->nro_recibo);
 $solici  = trim($objs->solicitante);
 $nropedido = trim($objs->nro_pedido);
 $denomi  = "Denominacion:   ".trim($objs->denominacion);
 $clase   = "en la Clase:  ".$objs->clase;
 $fecha_bus = trim($objs->f_pedido);
  
 $vruta="/home/fonetica/pdfext/fonetica/";
 $vruta1="/var/www/apl/sipi/documentos/busquedas/pdfext/fonetica/"; 
 $filepdf = $vruta.trim($nropedido).".pdf";
 $filepdf1 = $vruta1.trim($nropedido).".pdf";
 $recibo = $factura;
 $pedido = $nropedido;          
 $solicitante = "Solicitado por:  ".$solici;  

 //cambio de estatus de la busqueda 
 $update_str = "pagina=1,f_proceso='$fecha_hoy',hora_proceso='$hora_bus'";
 $act_user = $sql->update("$tbname_1","$update_str","nro_pedido='$pedido'");

 //Inicio del PDF
 $pdf=new PDF_Table('P','mm','Letter');
 $pdf->Open();
 $pdf->AddPage();
 $pdf->AliasNbPages();
 $pdf->SetFont('Arial','',8);

 //draw the first header
 $pdf->Draw_Header();
    
 $pdf->ln(3);  
 $pdf->SetFont('Arial','B',8);             
 $pdf->MultiCell(196,3,'ANTECEDENTES DE SEMEJANZA EN LA CLASE SOLICITADA  ',0,'J',0); 
 $pdf->ln(3);  
 $pdf->MultiCell(196,3,'NO HAY ANTECEDENTES DE SEMEJANZA EN LA CLASE SOLICITADA  ',0,'J',0); 
 $pdf->SetFont('Arial','',8);              
 $pdf->ln(6); 
 $pdf->MultiCell(196,4,'----------------------------------------------------------------------------> Venezuela FIN DE ANTECEDENTES <-----------------------------------------------------------------------',0,'J',0);   
      
 $pdf->Output($filepdf);  
 $pdf->Output($filepdf1);
 $pdf->Close();

 echo "<br>";
 Mensajenew('PROCESO DE GENERACION ARCHIVO PDF TERMINADO !!!','../index1.php','S'); 
 echo "<br>";
 $smarty->display('pie_pag.tpl'); exit();
 
 //Desconexion de la Base de Datos
 $sql->disconnect();   
}

$smarty->display('m_busfonpdfsr.tpl');
$smarty->display('pie_pag.tpl');
?>
</body>
</html>
