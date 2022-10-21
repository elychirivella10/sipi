<?php
// *************************************************************************************
// Programa: m_rpttasa.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado por Karina Perez Año 2009 I Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();

include ("../z_includes.php");

include ("$include_path/librepor.php");

//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
	
//Class Extention for header and footer	
require_once("$include_lib/header_footer.inc");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role  = $_SESSION['usuario_rol'];
$usrsede = $_SESSION['usuario_sede'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Control de Pagos de Derechos / Marca Concedida');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$desde  = $_POST["desdec"];
$hasta  = $_POST["hastac"];
$evento = $_POST["evento"];
$usuario= $_POST["usuario"];
$boletin= $_POST["boletin"];
$recibo = trim($_POST['recibo']);
$sede   = $_POST["sede"];

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
if ($evento==65) { $encabezado= "Control de Pagos de Tasas / Marca Concedida"; }
else { $encabezado= "Control de Pagos de Derechos / Marca Concedida" ;}

if (($evento==65) || ($evento==66)) { }
else {
   mensajenew('Error: Solamente se permiten los eventos 65 y 66 ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$evento = $evento+1000;

//Query para buscar las opciones deseadas
//$where=" stzderec.nro_derecho=stzevtrd.nro_derecho AND stzderec.nro_derecho=stmmarce.nro_derecho AND stzderec.tipo_mp='M' AND stzevtrd.evento-1000 in (122) AND stzevtrd.estat_ant-1000 in (101) ";
$where =" stzderec.nro_derecho=stmmarce.nro_derecho AND stzderec.nro_derecho=stzevtrd.nro_derecho AND ";
$where1=" (SELECT stzderec.nro_derecho FROM stzderec,stzevtrd WHERE stzderec.nro_derecho=stzevtrd.nro_derecho AND stzderec.tipo_mp='M' AND stzevtrd.evento-1000 in (122,97) AND stzevtrd.estat_ant-1000 in (101,27) AND stzevtrd.documento='$boletin')"; 
$titulo='';

//Conexion
$sql = new mod_db();
$sql->connection($login);

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("desde","hasta","evento");
  $valores = array($desde,$hasta,$evento);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
   mensajenew('Error: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desde) and !empty($hasta)) { 
     if(!empty($where)) {
       $where = $where." (stzevtrd.fecha_trans>='$desde' and stzevtrd.fecha_trans<='$hasta')";
       $titulo= $titulo." Desde: "."$desde"." Hasta: "."$hasta".", "; }
}

if(empty($boletin)) { 
   mensajenew("ERROR: Valor de Boletin esta Vacio ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); }
else { $titulo= $titulo." Boletin: ".$boletin; }

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzevtrd.usuario='$usuario')";
     $titulo= $titulo.", Cargado por: "."$usuario";  }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzevtrd.documento='$recibo')";
     $titulo= $titulo.", Factura No: "."$recibo";  }
}

if(!empty($evento)) { 
  if(!empty($where)) {
  	 $where = $where." AND"." (stzevtrd.evento=$evento) AND"." stzderec.nro_derecho in ".$where1; 
  	 //$where = $where." AND"." stzderec.nro_derecho in (select nro_derecho from stzevtrd where evento=$evento AND stzevtrd.fecha_trans>='$desde' AND stzevtrd.fecha_trans<='$hasta') ";
    //$where = $where." AND"." (stzevtrd.evento-1000 =$evento)";
    $titulo= "Evento: ".($evento-1000).", ".$titulo;  } 
}


$where = $where." order by 2,3,4,5";

//echo "Q= "."SELECT evento,fecha_trans,fecha_event,documento,stzderec.solicitud,comentario,stzderec.nombre,stmmarce.clase 
//      FROM stzevtrd,stzderec,stmmarce WHERE $where";
//exit();

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

//Comienzo del pdf
$pdf->SetFont('Arial','',7);

//Tabla coloreada
//Colores, ancho de línea y fuente en negrita
    $pdf->SetFillColor(142,165,188);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFont('','B',10);

    $header=array('Fecha Transaccion','# Recibo','Fecha Evento','','');
 
    //Cabecera
    $w=array(40,25,30,50,50);
    $pdf->Ln();
   
     //Restauración de colores y fuentes
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('','B',8);
  
  $res_pedido=pg_exec("SELECT evento,fecha_trans,fecha_event,documento,stzderec.solicitud,comentario,stzderec.nombre,stmmarce.clase
                       FROM stzevtrd,stzderec,stmmarce WHERE $where");

  //$res_pedido=pg_exec("SELECT evento,fecha_trans,fecha_event,documento,stzderec.solicitud,comentario,stzderec.nombre,stmmarce.clase
  //                     FROM stzevtrd,stzderec,stmmarce WHERE $where");

                       
  $filasfound=pg_numrows($res_pedido);
  //$total=$filasfound;
  if ($filasfound==0)    {
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N'); 
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
  $regef = pg_fetch_array($res_pedido);
  $valor=$regef['documento'];
  $blanco='';
  $indc=1;

  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->Cell(25,8,'F. TRANSACCION',0,0,'C'); 
  $pdf->Cell(19,8,'# FACTURA',0,0,'C'); 
  $pdf->Cell(25,8,'FECHA FACTURA',0,1,'C'); 
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->SetFont('','',8);

  for($cont=0;$cont<$filasfound;$cont++)   { 
	if (($valor!= $regef['documento']) or ($indc==1)) {
    
	    $pdf->Cell(24,8,$regef['fecha_trans'],0,0);
  	    $pdf->Cell(20,8,$regef['documento'],0,0);
 	    $pdf->Cell(21,8,$regef['fecha_event'],0,0);
 	    $pdf->SetFont('','B',8);
       $pdf->Cell(40,8,"Solicitud(es)    Nombre                                                                                      Clase",0,1);
       $pdf->SetFont('','',8);
       $x = $pdf->Getx();
       $y = $pdf->Gety();
       $pdf->line($x,($y+1),203,($y+1));  
    	 $pdf->Cell($w[0],8,$blanco,0,0,'C',1);
   	 $pdf->Cell($w[1],8,$blanco,0,0,'L',1);
       $pdf->Cell(20,8,$regef['solicitud'],0,0);  
       $pdf->Cell(80,8,utf8_decode(substr($regef['nombre'],0,47)),0,0);  
       $pdf->Cell(6,8,$regef['clase'],0,1);         
       $indc=0;
   }
   else {
    	 $pdf->Cell($w[0],8,$blanco,0,0,'C',1);
   	 $pdf->Cell($w[1],8,$blanco,0,0,'L',1);
       $pdf->Cell(20,8,$regef['solicitud'],0,0);  
       $pdf->Cell(80,8,substr($regef['nombre'],0,47),0,0);  
       $pdf->Cell(6,8,$regef['clase'],0,1);         
   }
   $regef = pg_fetch_array($res_pedido);
   if ($valor!= $regef['documento']) { $valor= $regef['documento']; $indc=1; }
  }
  
  $pdf->ln(1);
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->SetFont('','B',8);
  $pdf->Cell(25,8,"Total efectuadas: ".$filasfound,0,1);
  $pdf->SetFont('','',8);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
