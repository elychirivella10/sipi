<?php
// *************************************************************************************
// Programa: m_rptingraf.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año 2013 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
ob_start();
include ("../z_includes.php");
//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
//Class Extention for header and footer	
//require_once("$include_lib/header_footer.inc");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";	
  exit();
}

$login = $_SESSION['usuario_login'];
$vsede = $_SESSION['usuario_sede'];
$fecha  = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de Planillas B&uacute;squedas Graficas Cargadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$recibo  = $_GET['vfac'];
$usuario = $_GET['vusr'];

//Query para buscar las opciones deseadas
$where = "sede='$vsede' "; 
$titulo= 'Sede: SAPI, ';
$from  = ' stmcntrl ';
//$vsede = "1";

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcntrl.usuario='$usuario')";
     $titulo= $titulo." por Usuario: "."$usuario".",";  }
}

$lrif = substr($recibo,0,1);

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcntrl.recibo='$recibo')";
     if ($lrif!='E') { 
       $titulo= $titulo." Factura No: "."$recibo";  }
     else  { 
       $titulo= $titulo." Exoneracion No: "."$recibo";  }
  }
}

$where = $where." ORDER BY 1,3"; 

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Auditoria Control Planillas Graficas Cargadas";
$linea="_________________________________________________________________________________________________";

class pdf_usage extends fpdf_table
{
   public function Header()
   {
	global $encab_principal;
	global $encabezado;
	global $titulo;
	global $total;

	//Title
	$this->SetFont('Arial','',15);
	$this->Image("../imagenes/gob.jpg",10,7,30,29,'JPG');
	$this->Cell(0,6,$encab_principal,0,1,'C');
	$this->Cell(0,6,$encabezado,0,1,'C');
	$this->SetFont('Arial','',10);
	$this->Cell(0,7,$titulo,0,1,'C');
	$this->Cell(0,7,"Total ".$total,0,1,'C');
	$this->SetX(18);
	//$this->SetFont('Arial','',9);

	$this->SetFont('','B',8);

	$this->Ln(2);
	$x = $this->Getx();
	$y = $this->Gety();
	$this->line($x,($y+1),203,($y+1));
	if ($lrif!='E') {   
	  $this->Cell(20,8,'Factura',0,0,'C'); }
	else {   
	  $this->Cell(20,8,'Exoneracion',0,0,'C'); }
	$this->Cell(15,8,'de Fecha',0,0,'C'); 
	$this->Cell(21,8,'Prioridad',0,0,'C'); 
	$this->Cell(12,8,'Pedido',0,0,'C'); 
	$this->Cell(13,8,'Clase',0,0,'C');
	$this->Cell(20,8,'Planilla',0,0,'C');
	$this->Cell(20,8,'Solicitante',0,0,'C'); 
	$this->Cell(45,8,'',0,0,'C'); 
	$this->Cell(32,8,'Logotipo',0,1,'C'); 

	//$this->Cell(20,8,'Recibo',0,0,'C'); 
	///$this->Cell(16,8,'de Fecha',0,0,'C'); 
	//$this->Cell(28,8,'Prioridad',0,0,'C'); 
	//$this->Cell(4,8,'Pedido',0,0,'C'); 
	//$this->Cell(27,8,'Clase',0,0,'C'); 
	//$this->Cell(20,8,'Recibido en Fecha',0,0,'C'); 
	//$this->Cell(45,8,'Fecha y Recibido por',0,0,'C'); 
	//$this->Cell(32,8,'Logotipo',0,1,'C'); 

	//$x = $this->Getx();
	//$y = $this->Gety();
	//$this->line($x,($y+1),203,($y+1));  
   //$this->SetFont('','',8);
        $this->SetFont('Arial','',9);
   }	
	
   public function Footer()
   {
    	//Posición: a 2,0 cm del final
    	$this->SetY(-20);
    	//Arial italic 8
    	$this->SetFont('Arial','I',7);
	//Número de página
    	$this->Cell(0,27,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    	$this->Text(10,273,"Fecha:");
    	$this->text(20,273,date('d/m/y'),0,1); 
    	$this->Text(185,273,"Hora:");
    	$this->text(192,273,date('h:i A'),0,1); 
   }
} 
//distinct on(fecha,pedido)
//$res_pedido=pg_exec("SELECT distinct on (fecha,pedido) fecha,pedido,hora,usuario,clase,tipo FROM stmaudef WHERE $where ");
$res_pedido=pg_exec("SELECT * FROM $from WHERE $where");
$total=pg_numrows($res_pedido);

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
//$pdf->SetFillColor(142,165,188);
//$pdf->SetTextColor(0);
//$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('','B',9);

//$header=array('# Recibo','de Fecha','Prioridad','Pedido','Clase','Recibido en Fecha','Fecha y Recibido por','Logotipo');

//Cabecera
//$w=array(20,20,20,20,15,30,30,30);
$w=array(19,16,22,15,12,18,18,30,30);
//$pdf->Ln();
$blanco='';   

//Restauración de colores y fuentes
//$pdf->SetFillColor(255,255,255);
//$pdf->SetTextColor(0);
//$pdf->SetFont('','B',8);

//$x = $pdf->Getx();
//$y = $pdf->Gety();
//$pdf->line($x,($y+1),203,($y+1));  
//$pdf->Cell(20,8,'Recibo',0,0,'C'); 
//$pdf->Cell(16,8,'de Fecha',0,0,'C'); 
//$pdf->Cell(28,8,'Prioridad',0,0,'C'); 
//$pdf->Cell(4,8,'Pedido',0,0,'C'); 
//$pdf->Cell(27,8,'Clase',0,0,'C'); 
//$pdf->Cell(20,8,'Recibido en Fecha',0,0,'C'); 
//$pdf->Cell(45,8,'Fecha y Recibido por',0,0,'C'); 
//$pdf->Cell(32,8,'Logotipo',0,1,'C'); 
//$x = $pdf->Getx();
//$y = $pdf->Gety();
//$pdf->line($x,($y+1),203,($y+1));  
//$pdf->SetFont('','',8);
	
 //$res_pedido=pg_exec("SELECT fecha,pedido,hora,usuario,clase,tipo FROM stmaudef WHERE $where ");
 $total=pg_numrows($res_pedido);
 if ($total==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptlogent.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $regef = pg_fetch_array($res_pedido);
  for($cont=0;$cont<$total;$cont++)   { 
    $npedido=trim($regef['pedido']);
    $clase=$regef['clase'];
    $proceso=$regef['fecha'];

    $planilla="";
    $resplanilla=pg_exec("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$npedido' AND tipo_busq='G'");
    $filas_found=pg_numrows($resplanilla); 
    if ($filas_found!=0) {
      $regplan = pg_fetch_array($resplanilla);
      $planilla= trim($regplan[cod_planilla]); }

    $existe_img = 0;
    $buscaimage ="../graficos/logbext/".$npedido.".jpg";
    if (file_exists($buscaimage)) {
      $existe_img = 1;
    }
    if ($existe_img==0) {
      $buscaimage ="../graficos/planblog/".$planilla.".jpg"; 
      if (file_exists($buscaimage)) {
        $existe_img = 1;
      }
    }
    
    //$buscaimage ="../graficos/logbext/".$npedido.".jpg";
    if(!empty($npedido)) {
      $respedido=pg_exec("SELECT * FROM stmcntrl WHERE pedido=$npedido"); }

    //verificando los resultados
    if (!$respedido)    { 
        $smarty->display('encabezado1.tpl');
        mensajenew('Error: Problema en Base de Datos  ...!!!','m_rptlogent.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($respedido); 
    if ($filas_found==0)    {
        $smarty->display('encabezado1.tpl');
        mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptlogent.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $reg = pg_fetch_array($respedido);
    $recibo      = $reg['recibo'];
    $fecharec    = $reg['fecharec'];
    $solicitante = $reg['solicitant'];
    $tipoprio    = $reg['prioridad'];
    
    if ($tipoprio=="L") { $tipo="Habilitada"; } else { $tipo="Normal"; }
    $y = $pdf->Gety();
    if ($y>=226) {
      $pdf->AddPage(); $pdf->Ln(); }
    //else {
      //$pdf->Cell($w[0],8,$recibo,0,0,'C',0);
      //$pdf->Cell($w[1],8,$fecharec,0,0,'L',0);
      //$pdf->Cell($w[2],8,$tipo,0,0,'C',0);
      //$pdf->Cell($w[3],8,$npedido,0,0,'L',0);
      //$pdf->Cell($w[4],8,$clase,0,0,'L',0);
      //$pdf->Cell($w[5],8,$proceso,0,0,'L',0);      
      $pdf->Cell($w[0],8,$recibo,0,0,'C',0);
      $pdf->Cell($w[1],8,$fecharec,0,0,'L',0);
      $pdf->Cell($w[2],8,$tipo,0,0,'C',0);
      $pdf->Cell($w[3],8,$npedido,0,0,'L',0);
      $pdf->Cell($w[4],8,$clase,0,0,'L',0);
      $pdf->Cell($w[5],8,$planilla,0,0,'L',0);
      $pdf->Cell($w[6],8,$solicitante,0,0,'L',0);      
      $x = $pdf->Getx();
      $y = $pdf->Gety();
      $pdf->Image("$buscaimage",170,$y+2,30,25,'JPG');
      $pdf->ln(30);
      $pdf->line(10,($y+1),203,($y+1)); 
      $pdf->ln(2);
    //}
    $regef = pg_fetch_array($res_pedido);
  } 

  $pdf->ln(6);
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->SetFont('','B',8);
  $pdf->ln(6);
  $pdf->Cell(25,8,"Total procesadas: ".$total,0,1);
  $pdf->SetFont('','',8);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
