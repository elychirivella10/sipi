<?php
// *************************************************************************************
// Programa: m_rptconlog1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010
// *************************************************************************************
ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Comienzo del Programa por los encabezados del reporte
define('FPDF_FONTPATH',$root_path.'/font/');
include ("$include_path/fpdf.php");
//ob_start();

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditoria Externa de Planillas Figuartivas Cargadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$desde = $_POST["desde"];
$hasta = $_POST["hasta"];
$desdec = $_POST["desdec"]; 
$hastac = $_POST["hastac"];
$usuario=trim($_POST["usuario"]);
$vsede  = trim($_POST['options']);

//Query para buscar las opciones deseadas
$where='';
$titulo='';

if (empty($vsede)) { $vsede="0"; } 


if(empty($desde) AND empty($hasta) AND empty($desdec) AND empty($hastac)) {  
   $smarty->display('encabezado1.tpl');
   mensajenew('Error: Alguna Fecha Vacia ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desde) && !empty($hasta)) {
  $esmayor=compara_fechas($desde,$hasta);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('Error: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
  if(empty($where)) {
    $where = $where." (stmcntrl.fecharec>='$desde' AND stmcntrl.fecharec<='$hasta')";
    $titulo= $titulo." Desde el: "."$desde"." Hasta: "."$hasta"; }
}

if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('Error: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stmcntrl.fechaing>='$desdec' AND stmcntrl.fechaing<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  else {
    $where = $where." AND (stmcntrl.fechaing>='$desdec' AND stmcntrl.fechaing<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcntrl.usuario='$usuario')";
     $titulo= $titulo." por el Usuario: "."$usuario";  }
}

if(!empty($vsede)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcntrl.sede='$vsede')";
     $titulo= $titulo." de la Sede: "."$vsede";  }
}

//$where = $where." and (tipo='E')"." order by pedido,fecha,hora";
$where = $where." ORDER BY 1,3"; 

//echo "where= $where ";

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
   $this->Image("../imagenes/sapi.jpg",10,5,25,25,'JPG');
   $this->Cell(0,6,'Sistema de Marcas',0,1,'C');
   $this->Cell(0,6,'Elementos Figurativos',0,1,'C');
   //$this->Image("../imagenes/milco1.jpg",160,5,40,10,'JPG');
   $this->SetFont('Arial','BU',10);
   $this->Cell(0,7,'Auditoria de Planillas Cargadas',0,1,'C');
   $this->SetFont('Arial','',8);
   $this->ln(1);

   $this->SetFont('Arial','B',10);
   $this->Cell(0,8,$titulo,0,1,'C');
   $this->SetFont('Arial','',8);
   $this->ln(2);
   $this->SetLineWidth(0.1);

   $this->Cell(17,8,'F. Recibo',1,0,'C'); 
   $this->Cell(18,8,'Hora',1,0,'C'); 
   $this->Cell(12,8,'Recibo',1,0,'C'); 
   $this->Cell(11,8,'Pedido',1,0,'C'); 
   $this->Cell(55,8,'Solicitante',1,0,'C');
   $this->Cell(21,8,'Ced/Rif',1,0,'C');
   $this->Cell(22,8,'Indole',1,0,'C'); 
   $this->Cell(21,8,'Telefono',1,0,'C'); 
   $this->Cell(18,8,'Prioridad',1,1,'C'); 

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

  //$pdf->ln(1);
  //$pdf->SetFont('Arial','B',10);
  //$pdf->Cell(0,8,$titulo,0,1,'C');
  //$pdf->SetFont('Arial','',8);
  //$pdf->ln(2);
  //$pdf->SetLineWidth(0.1);

  //$pdf->Cell(17,8,'F. Recibo',1,0,'C'); 
  //$pdf->Cell(18,8,'Hora',1,0,'C'); 
  //$pdf->Cell(12,8,'Recibo',1,0,'C'); 
  //$pdf->Cell(11,8,'Pedido',1,0,'C'); 
  //$pdf->Cell(55,8,'Solicitante',1,0,'C');
  //$pdf->Cell(23,8,'Ced/Rif',1,0,'C');
  //$pdf->Cell(20,8,'Indole',1,0,'C'); 
  //$pdf->Cell(18,8,'Telefono',1,0,'C'); 
  //$pdf->Cell(18,8,'Prioridad',1,1,'C'); 

  $res_pedido=pg_exec("SELECT fecharec,hora,pedido,recibo,solicitant,prioridad,identificacion,indole,telefono,usuario FROM stmcntrl WHERE $where ");
  $filasfound=pg_numrows($res_pedido);
  $total=$filasfound;
  echo "total= $total ";
  if ($filasfound==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptconlog.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $regef = pg_fetch_array($res_pedido);
  for($cont=0;$cont<$filasfound;$cont++)   { 
     $npedido    =trim($regef['pedido']);
     $recibo     =$regef['recibo'];
     $fecharec   =$regef['fecharec'];
     $solicitante=trim($regef['solicitant']);
     $tipoprio   =$regef['prioridad'];
     $cedrif     =$regef['identificacion'];
     $tipindole  =$regef['indole'];
     $telf       =$regef['telefono'];
     $hora       =$regef['hora'];
     if ($tipoprio=="L") { $tipo="Habilitada"; } else { $tipo="Normal"; }

     switch ($tipindole) {
       case "G":
         $indole = "Sector Publico";
         break;
       case "C":
         $indole = "Cooperativa";
         break;
       case "O":
         $indole = "Comunal";         
         break;
       case "P":
         $indole = "Persona Juridica";
         break;
       case "N":
         $indole = "Persona Natural";
         break;
     }       
     $pdf->ln(2);
     $pdf->Cell(17,8,$fecharec,0,0); 
     $pdf->Cell(18,8,$hora,0,0);
     $pdf->Cell(12,8,$recibo,0,0);
     $pdf->Cell(11,8,$npedido,0,0);
     $pdf->Cell(55,8,substr($solicitante,0,50),0,0);
     $pdf->Cell(20,8,$cedrif,0,0);
     $pdf->Cell(23,8,$indole,0,0);
     $pdf->Cell(23,8,$telf,0,0);
     $pdf->Cell(12,8,$tipo,0,1);

     $regef = pg_fetch_array($res_pedido);
  }
  $pdf->ln(1);
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->Cell(25,8,"Total Cargadas: ".$total,0,1);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
