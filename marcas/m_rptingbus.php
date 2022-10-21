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
$fecha = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de Planillas B&uacute;squedas Cargadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$recibo  = $_GET['vfac'];
$usuario = $_GET['vusr'];
$nbusfon = $_GET['nfon'];
$nbusgra = $_GET['ngra'];

//Query para buscar las opciones deseadas
if ($vsede=='1') { $titulo= 'Sede: SAPI, '; }
if ($vsede=='2') { $titulo= 'Sede: SAPI-TAQUILLA UNICA, '; }
//$titulo= 'Sede: SAPI, ';
//$vsede = "1";
$from  = ' stmbusqueda ';
$from1 = ' stmcntrl ';
$lrif  = substr($recibo,0,1);

if(!empty($usuario)) { 
  $titulo= $titulo." por Usuario: "."$usuario".",";  }

if ($lrif!='E') { 
  $titulo= $titulo." Factura No: "."$recibo";  }
else  { 
  $titulo= $titulo." Exoneracion No: "."$recibo";  }

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Auditoria Control Planillas Busquedas Cargadas";
$linea="_________________________________________________________________________________________________";

class pdf_usage extends fpdf_table
{
   public function Header()
   {
	global $encab_principal;
	global $encabezado;
	global $titulo;
	global $total;
        global $lrif;

	//Title
	$this->SetFont('Arial','',15);
	$this->Image("../imagenes/gob.jpg",10,7,30,29,'JPG');
	$this->Cell(0,6,$encab_principal,0,1,'C');
	$this->SetFont('Arial','',13);
	$this->Cell(0,6,$encabezado,0,1,'C');
	$this->SetFont('Arial','',10);
	$this->Cell(0,7,$titulo,0,1,'C');
	$this->Cell(0,7,"Total Planillas: ".$total,0,1,'C');
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
	$this->Cell(23,8,'Denominacion/Logotipo',0,1,'C'); 

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

$total=($nbusfon+ $nbusgra);

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

//Comienzo del pdf
$pdf->SetFont('','B',9);
//Cabecera
$w=array(19,16,22,15,12,18,51,30);
$blanco='';   

//Busquedas Foneticas Solicitadas 
if ($nbusfon>0) {
//$where = "sede='1' "; 
$where = "sede='$vsede'";
//echo " $where ";      
if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.usuario='$usuario')"; }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.nro_recibo='$recibo')"; }
}

$where = $where." ORDER BY 1,3"; 

  $respedido=pg_exec("SELECT * FROM $from WHERE $where");
  $regef = pg_fetch_array($respedido);
  for($cont=0;$cont<$nbusfon;$cont++)   { 
    $npedido=trim($regef['nro_pedido']);
    $clase=$regef['clase'];
    $proceso=$regef['f_proceso'];
    $email = $regef['email'];
    
    $planilla="";
    $resplanilla=pg_exec("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$npedido' AND tipo_busq='F'");
    $filas_found=pg_numrows($resplanilla); 
    if ($filas_found!=0) {
      $regplan = pg_fetch_array($resplanilla);
      $planilla= trim($regplan[cod_planilla]); }

    $recibo      = $regef['nro_recibo'];
    $fecharec    = $regef['f_pedido'];
    $solicitante = trim(substr($regef['solicitante'],0,22));
    $tipoprio    = $regef['tipobusq'];
    $denominacion= trim(substr($regef['denominacion'],0,24));

    if ($tipoprio=="A") { $tipo="Habilitada"; } else { $tipo="Normal"; }
    $y = $pdf->Gety();
    if ($y>=226) { $pdf->AddPage(); $pdf->Ln(); }
    $pdf->Cell($w[0],8,$recibo,0,0,'C',0);
    $pdf->Cell($w[1],8,$fecharec,0,0,'L',0);
    $pdf->Cell($w[2],8,$tipo,0,0,'C',0);
    $pdf->Cell($w[3],8,$npedido,0,0,'L',0);
    $pdf->Cell($w[4],8,$clase,0,0,'L',0);
    $pdf->Cell($w[5],8,$planilla,0,0,'L',0);
    $pdf->Cell($w[6],8,utf8_decode($solicitante),0,0,'L',0);      
    $pdf->Cell($w[7],8,utf8_decode($denominacion),0,0,'L',0);      
    $x = $pdf->Getx();
    $y = $pdf->Gety();
    $pdf->ln(30);
    $pdf->line(10,($y+1),203,($y+1)); 
    $pdf->ln(2);
    $regef = pg_fetch_array($respedido);
  } 
}

//Busquedas Gráficas Solicitadas 
if ($nbusgra>0) {
$where = "sede='1' "; 

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcntrl.usuario='$usuario')"; }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcntrl.recibo='$recibo')"; }
}

$where = $where." ORDER BY 1,3"; 

  $res_pedido=pg_exec("SELECT * FROM $from1 WHERE $where");
  $regef = pg_fetch_array($res_pedido);
  for($cont=0;$cont<$nbusgra;$cont++)   { 
    $npedido=trim($regef['pedido']);
    $clase=$regef['clase'];
    $proceso=$regef['fecha'];
    $email = $regef['email'];

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
    
    $recibo      = $regef['recibo'];
    $fecharec    = $regef['fecharec'];
    $solicitante = trim(substr($regef['solicitant'],0,22));
    $tipoprio    = $regef['prioridad'];
    
    if ($tipoprio=="L") { $tipo="Habilitada"; } else { $tipo="Normal"; }
    $y = $pdf->Gety();
    if ($y>=226) { $pdf->AddPage(); $pdf->Ln(); }
    $pdf->Cell($w[0],8,$recibo,0,0,'C',0);
    $pdf->Cell($w[1],8,$fecharec,0,0,'L',0);
    $pdf->Cell($w[2],8,$tipo,0,0,'C',0);
    $pdf->Cell($w[3],8,$npedido,0,0,'L',0);
    $pdf->Cell($w[4],8,$clase,0,0,'L',0);
    $pdf->Cell($w[5],8,$planilla,0,0,'L',0);
    $pdf->Cell($w[6],8,utf8_decode($solicitante),0,0,'L',0);      
    $x = $pdf->Getx();
    $y = $pdf->Gety();
    $pdf->Image("$buscaimage",170,$y+2,30,25,'JPG');
    $pdf->ln(30);
    $pdf->line(10,($y+1),203,($y+1)); 
    $pdf->ln(2);
    $regef = pg_fetch_array($res_pedido);
  } 
}

$pdf->ln(6);
$x = $pdf->Getx();
$y = $pdf->Gety();
$pdf->line($x,($y+1),203,($y+1));  
$pdf->SetFont('','B',8);
$pdf->ln(6);
$pdf->Cell(25,8,"Correo para enviar resultados: ".$email,0,1);
$pdf->Cell(25,8,"Total Cargadas: ".$total,0,1);
$pdf->Cell(25,8,utf8_decode("Para las cuentas gmail.com debe revisar si los resultados están en la carpeta RECIBIDOS o en la carpeta SPAM al hacer click en Más."),0,1);
$pdf->Cell(25,8,utf8_decode("Para las cuentas hotmail.com debe revisar si los resultados están en la carpeta BANDEJA DE ENTRADA o en la carpeta CORREO NO DESEADO."),0,1);
$pdf->ln(4);
$pdf->Cell(0,8,"Firman estando Conforme con lo solicitado y cargado al Sistema: ",0,1); 
$pdf->Cell(0,8,"                                                                ",0,1); 
$pdf->Cell(0,8,"                                               El Solicitante: ________________________ el Funcionario: _________________________",0,1); 
$pdf->SetFont('','',8);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
