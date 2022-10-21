<?php
include ("../setting.inc.php");
//Comienzo del Programa por los encabezados del reporte
define('FPDF_FONTPATH',$root_path.'/font/');
include ("$include_path/fpdf.php");
ob_start();

// *************************************************************************************
// Programa: m_rpt1bexsr.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$sql  = new mod_db();
$fecha   = fechahoy();

//Validacion de Entrada
$npedido = $_GET["vped"];
$usuario = $_GET["vusr"]; 

//Conexion
$sql->connection($usuario);

//Query para buscar las opciones deseadas
if(!empty($npedido)) {
   $respedido=pg_exec("SELECT * FROM stmcntrl WHERE pedido= '$npedido'"); }

//verificando los resultados
if (!$respedido)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($respedido); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$reg = pg_fetch_array($respedido);
$npedido=$reg[pedido];
$recibo=$reg[recibo];
$fecharec=$reg[fecharec];
$solicitante=$reg[solicitant];
$sede  = $reg[sede];
$envio = $reg[envio];

$planilla = "";
$resulplan =pg_exec("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$npedido'");
$filas_plan=pg_numrows($resulplan);
if ($filas_plan!=0) {
  $reg1 = pg_fetch_array($resulplan);
  $planilla = trim($reg1[cod_planilla]); }
else {
  $planilla = 0; }

if ($sede==1) {
  $rutafinal = '/home/fonetica/pdfext/grafica/'; 
  $archivo   = $rutafinal.trim($npedido).".pdf";
}
if ($sede==3) {
  $rutafinal = '/apl/webpi/graficas/'; 
  //$archivo   = $rutafinal.trim($recibo).".pdf";
  $archivo   = $rutafinal.trim($npedido).".pdf";
  
  if (!empty($npedido)) {
    $resbusweb=pg_exec("SELECT * FROM stmbusweb WHERE nro_pedido='$npedido' AND tipo_busq='G'");
    $filas_web=pg_numrows($resbusweb); 
    if ($filas_web!=0) {
      $regweb = pg_fetch_array($resbusweb);
      $nrefbus= $regweb[ref_busq];
    }  
  }
  $recibo = $recibo." - ".$nrefbus;  
}  

if(!empty($npedido)) {
   $resaudef=pg_exec("SELECT * FROM stmaudef WHERE pedido='$npedido' and estatus!='P'"); }

//verificando los resultados
if (!$resaudef)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resaudef); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','m_pbexfigu.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$reg = pg_fetch_array($resaudef);
$clase=$reg[clase];
$vc1=$reg[vc1];
$vc2=$reg[vc2];
$vc3=$reg[vc3];
$vc4=$reg[vc4];
$vc5=$reg[vc5];
$vc6=$reg[vc6];
$vc7=$reg[vc7];
$vc8=$reg[vc8];

$fechahoy = hoy();
$horactual = Hora();
$update_str = "estado='2',fecha_proceso='$fechahoy',hora_proceso='$horactual',user_proceso='$usuario'";
$recibo=trim($recibo);
$act_ref = $sql->update("stmbusweb","$update_str","tipo_busq='G' AND nro_pedido='$npedido'"); 
//$act_ref = pg_exec("UPDATE stmbusweb SET estado='2' WHERE tipo_busq='G' AND ref_busq=$recibo");

//Incio de la Clase de PDF para generar los reportes
class PDF_Table extends FPDF
{
var $tb_columns; 		//number of columns of the table
var $tb_header_type; 	//array which contains the header characteristics and texts
var $tb_data_type; 		//array which contains the data characteristics (only the characteristics)
var $tb_table_type; 	//array which contains the table charactersitics
var $table_startx, $table_starty;	//the X and Y position where the table starts

//returns the width of the page in user units

function PageWidth(){
	return (int) $this->w-$this->rMargin-$this->lMargin;
}

function Header()
{
    global $titulo;
    global $total;
    //Title
    $this->SetFont('Arial','',14);
    $this->Image("../imagenes/sapi.jpg",10,5,15,15,'JPG');
    $this->Cell(0,6,'Sistema de Marcas',0,1,'C');
    $this->Cell(0,6,'Elementos Figurativos',0,1,'C');
    //$this->Image("../imagenes/milco1.jpg",160,5,40,10,'JPG');
    $this->SetFont('Arial','BU',10);
    $this->Cell(0,7,'Busqueda Externa de Antecedente',0,1,'C');
    $this->SetFont('Arial','',8);
    $this->ln(4);
    //Ensure table header is output
    parent::Header();
}

//Pie de página
function Footer()
{
    //Posición: a 2,0 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    $this->Text(10,270,"Fecha:");
    $this->text(20,270,date('d/m/y'),0,1); 
    $this->Text(185,270,"Hora:");
    $this->text(192,270,date('h:i A'),0,1); 
 }

    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

}//end of PDF_Table class
error_reporting(E_ALL);

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

if ($sede==3) {
  $tipoimg = 1;
  $buscaimage ="../graficos/logbext/".$npedido.".jpg";
}
else {
  //$buscaimage ="../graficos/logbext/".$npedido.".jpg";
  //$buscaimage = $img_virtual."/logbext/".$npedido.".jpg";
  $buscaimage = $img_virtual."/planblog/".$planilla.".jpg";
  if (file($buscaimage)) { $tipoimg = 1; }
  else {
    //$buscaimage ="../graficos/logbext/".$npedido.".png";
    //$buscaimage = $img_virtual."/logbext/".$npedido.".png";
    $buscaimage = $img_virtual."/planblog/".$planilla.".png";
    $tipoimg = 2;
  }
}

if (file($buscaimage)) { 
  $pdf->SetFillColor(192);
  $pdf->RoundedRect(160,25,46,30,5,'', '13');
  $pdf->Image("$buscaimage",162,27,43,25,'JPG');
}

  $pdf->Cell(20,8,'Pedido Nro.:',0,0); 
  $pdf->Cell(84,8,$npedido,0,0);
  $pdf->Cell(27,8,'Fecha de Recibo:',0,0);
  $pdf->Cell(100,8,$fecharec,0,1);
  $pdf->Cell(20,8,'Solicitante:',0,0);
  $pdf->Cell(84,8,$solicitante,0,0);
  $pdf->Cell(20,8,'Recibo Nro:',0,0);
  $pdf->Cell(100,8,$recibo,0,1);  

  $pdf->Cell(28,8,'Planilla Control Nro: ',0,0);  
  $pdf->Cell(76,8,$planilla,0,0);  
  $pdf->Cell(10,8,'Clase:',0,0);
  $pdf->Cell(20,8,$clase,0,1);    

  $pdf->Cell(20,8,'Cod. Viena:',0,0);
  $pdf->Cell(10,8,$vc1,0,0);    
  $pdf->Cell(10,8,$vc2,0,0); 
  $pdf->Cell(10,8,$vc3,0,0);    
  $pdf->Cell(10,8,$vc4,0,0);    
  $pdf->Cell(10,8,$vc5,0,0);    
  $pdf->Cell(10,8,$vc6,0,0);    
  $pdf->Cell(10,8,$vc7,0,0);    
  $pdf->Cell(14,8,$vc8,0,1);    

  $pdf->Cell(20,8,'Usuario:',0,0);
  $pdf->Cell(20,8,$usuario,0,1);  
    
  $pdf->ln(6);
  $pdf->SetFont('Arial','BU',11);
  $pdf->Cell(0,8,'POSIBLES PARECIDOS GRAFICOS',0,1,'C');
  $pdf->SetFont('Arial','B',12);
  $pdf->ln(1);
  $pdf->SetLineWidth(0.1);
  $pdf->line(11,58,208,58);  
  $pdf->Cell(0,8,'NO SE ENCONTRARON ANTECEDENTES GRAFICOS',0,1,'C');

  $update_str = "estatus='P'";
  $sql->update("stmaudef","$update_str","pedido='$npedido' and estatus='S'");

//cambio estatus de procesamiento de busqueda 
$update_str = "estatus='2'";
$act_ref = $sql->update("stmcntrl","$update_str","pedido='$npedido'"); 

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean();
if (($sede==1) && ($envio=='S')) {
  $pdf->Output($archivo); 
  //Desconexion a la base de datos
  $sql->disconnect();
  $smarty->display('encabezado1.tpl');
  mensajenew('Archivo Resultado Generado en SAPI para enviar por Correo ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}   
if ($sede==3) {
  $fechahoy = hoy();
  $horactual = Hora();
  $update_str = "estado='2',fecha_proceso='$fechahoy',hora_proceso='$horactual',user_proceso='$usuario'";
  $recibo=trim($recibo);
  $act_ref = $sql->update("stmbusweb","$update_str","tipo_busq='G' AND nro_pedido='$npedido'"); 
  $pdf->Output($archivo); 
  //Desconexion a la base de datos
  $sql->disconnect();
  $smarty->display('encabezado1.tpl');
  mensajenew('Archivo Resultado Generado via Webpi ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}   
else { $pdf->Output(); }
?>
