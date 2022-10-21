<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de verificar los Archivos PDF faltantes ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_verificapdf.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2010
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

$smarty->assign('subtitulo','VERIFICACION DE ARCHIVOS BUSQUEDAS PDF WEBPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
 //Verificando conexion SIPI
 $sql = new mod_db();
 $sql->connection();

 // Obtencion de los Registros o Filas   
 $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE estado IN ('1','2') AND tipo_busq='F' ORDER BY nro_tramite,tipo_busq,ref_busq");
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   Mensajenew("ERROR: No hay archivos que transferir ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $numerror  = 0;
 $fecha_hoy = hoy();

 // Comienzo de Transaccion   
 $objs = $sql->objects('',$obj_query);
 $usrant = trim($objs->usuario);
 $tramant = trim($objs->nro_tramite);
 $indc = 1;
 for($cont=0;$cont<$filas_found;$cont++) {
   $cuenta  = trim($objs->usuario);
   $tramite = trim($objs->nro_tramite);
   $tipo    = trim($objs->tipo_busq);
   $refbusq = trim($objs->ref_busq);
   $nropedido = trim($objs->nro_pedido);
   $denomi  = "Denominacion:   ".trim($objs->nombre);
   $clase   = "en la Clase:  ".$objs->clase;
   $fecha_bus = trim($objs->fecha_bus);
   $factura = "T".str_pad($tramite,7,'0',STR_PAD_LEFT);
   
   $solici  = trim($objs->solicitante);
   if ($tipo=="F") { $vruta="/home/fonetica/webpi/"; }
   if ((($usrant!=$cuenta) || ($tramant!=$tramite)) || ($indc==1)) {
     //$filepdf = $vruta.trim($refbusq).".pdf";
     $filepdf = $vruta.trim($nropedido).".pdf";
     if (file_exists($filepdf)) { //echo " archivo $filepdf existe !=<br/ >"; 
     } 
     else { //echo " archivo $filepdf NO EXISTE <br/ >";
       //$recibo = $refbusq;
       //$pedido = $tramite." de fecha ".$fecha_bus;
       $recibo = $factura." - ".$refbusq;
       $pedido = $nropedido;          
       $hora_bus = Hora();
       $solicitante = "Solicitado por:  ".$solici;  

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
       $pdf->Close();
     } 
     $indc = 0;
   }
   else {
     //echo " misma cuenta = $cuenta, con $tramite y $refbusq ";
     //$filepdf = $vruta.trim($refbusq).".pdf";
     $filepdf = $vruta.trim($nropedido).".pdf";
     if (file_exists($filepdf)) { //echo " archivo $filepdf existe ==<br/ >"; 
     } 
     else { //echo " archivo $filepdf NO EXISTE <br/ >"; 
       //$recibo = $refbusq;
       //$pedido = $tramite." de fecha ".$fecha_bus;
       $recibo = $factura." - ".$refbusq;
       $pedido = $nropedido;          
       $hora_bus = Hora();
       $solicitante = "Solicitado por:  ".$solici;  

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
       $pdf->Close();
     }
     
   }
   //cambio de estatus de la busqueda 
   $update_str = "estado='2',fecha_proceso='$fecha_hoy',hora_proceso='$hora_bus',user_proceso='$usuario',user_carga='$usuario'";
   $act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite='$tramite' AND ref_busq='$refbusq'");
   
   $objs = $sql->objects('',$obj_query);
   if ($usrant!=trim($objs->usuario) || $tramant!=trim($objs->nro_tramite)) {  
     $usrant = trim($objs->usuario); $indc = 1; 
     $tramant = trim($objs->nro_tramite);
   }  
 }

 if ($numerror==0) { 
   echo "<br>";
   Mensajenew('PROCESO DE VERIFICACION TERMINADA !!!','../index1.php','S'); 
   echo "<br>";
   $smarty->display('pie_pag.tpl'); exit();
 }
 
 //Desconexion de la Base de Datos
 $sql->disconnect();   
}

$smarty->display('z_verificapdf.tpl');
$smarty->display('pie_pag.tpl');
?>
</body>
</html>
