<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();

include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Listado de Peticionarios');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$desde=$_POST["desde"];
$hasta=$_POST["hasta"];
$desdet=$_POST["desdet"];
$hastat=$_POST["hastat"];
$tipo=$_POST["tipo"];
$usuario=$_POST["usuario"];
$nconex = $_POST['nconex'];

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$esmayor=compara_fechas($desdet,$hastat);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desdet) and !empty($hastat)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzpetit.f_carga >= '$desdet') and (stzpetit.f_carga <='$hastat'))";
	   $titulo= $titulo." Fecha de Carga:"."$desdet"." al: "."$hastat";
	}
	else { 
		$where = $where." ((stzpetit.f_carga >= '$desdet') and (stzpetit.f_carga <='$hastat'))";
      $titulo= $titulo." Fecha de Carga:"."$desdet"." al: "."$hastat";
	}
}

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desde) and !empty($hasta)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzpetit.f_recibo >= '$desde') and (stzpetit.f_recibo <='$hasta'))";
	   $titulo= $titulo." Fecha de Recibo:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stzpetit.f_recibo >= '$desde') and (stzpetit.f_recibo <='$hasta'))";
      $titulo= $titulo." Fecha de Recibo:"."$desde"." al: "."$hasta";
	}
}
if(!empty($tipo)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzpetit.modo = '$tipo')";
 	   $titulo= $titulo." Tipo A/B:"."$tipo";
	}
	else { 
		$where = $where." (stzpetit.modo = '$tipo')";
 	   $titulo= $titulo." Tipo A/B:"."$tipo";
	}
}
if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzpetit.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stzpetit.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

// Armando el query

$resultado=pg_exec("SELECT *
			FROM  stzpetit 
			WHERE $where 
			ORDER BY  stzpetit.tipo, stzpetit.f_carga, stzpetit.f_recibo");	
 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);  
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

//initialize all the variables that we use
function Table_Init($col_no = 0){
	$this->tb_columns = $col_no;
	$this->tb_header_type = Array();
	$this->tb_data_type = Array();
	$this->tb_type = Array();
	$this->table_startx = 0;
	$this->table_starty = 0;
	
}

//Sets the number of columns of the table
function Set_Table_Columns($nr){
	$this->tb_columns = $nr;
}


function Set_Header_Type($type_arr){
	$this->tb_header_type = $type_arr;
}

function Set_Data_Type($type_arr){
	$this->tb_data_type = $type_arr;
}

function Set_Table_Type($type_arr){
	$this->tb_table_type = $type_arr;
	if (isset($type_arr['TB_COLUMNS']))
		$this->tb_columns = $type_arr['TB_COLUMNS'];		
}

//this function draws the exterior table border
function Draw_Table_Border(){
/*				"BRD_COLOR"=> array (120,120,120), //border color
				"BRD_SIZE"=>5), //border line width
				"TB_COLUMNS"=>5), //the number of columns
				"TB_ALIGN"=>"L"), //the align of the table, possible values = L, R, C equivalent to Left, Right, Center
*/
	//set the colors
	list($r, $g, $b) = $this->tb_table_type['BRD_COLOR'];
	$this->SetDrawColor($r, $g, $b);

	//set the line width
	$this->SetLineWidth($this->tb_table_type['BRD_SIZE']);

	//draw the border
	$this->Rect(
		$this->table_startx,
		$this->table_starty,
		$this->Get_Table_Width(),
		$this->GetY()-$this->table_starty);

}

//returns the table width in user units
function Get_Table_Width()
{
	//calculate the table width
	$tb_width = 0;
	for ($i=0; $i < $this->tb_columns; $i++){
		$tb_width += $this->tb_header_type[$i]['WIDTH'];
	}
	return $tb_width;
}

//aligns the table to C, L or R (default is L)
function Table_Align(){
	//check if the table is aligned
	if (isset($this->tb_table_type['TB_ALIGN']))
		$tb_align = $this->tb_table_type['TB_ALIGN'];
	else
		$tb_align='';

	//set the table align
	switch($tb_align){
		case 'C':
			$this->SetX($this->lMargin + ($this->PageWidth() - $this->Get_Table_Width())/2);
			break;
		case 'R':
			$this->SetX($this->lMargin + ($this->PageWidth() - $this->Get_Table_Width()));
			break;
		default:
			$this->SetX($this->lMargin);
			break;
	}
}

//Draws the Header
function Draw_Header(){

	$this->Table_Align();

	$this->table_startx = $this->GetX();
	$this->table_starty = $this->GetY();

	$nb = 0;
	$ln = 0;
	$xx = Array();

	//calculate the maximum height of the cells
	for($i=0;$i<$this->tb_columns;$i++)
	{
		#print_r($this->tb_header_type[$i]);
		$this->SetFont(	$this->tb_header_type[$i]['T_FONT'],
						$this->tb_header_type[$i]['T_TYPE'],
						$this->tb_header_type[$i]['T_SIZE']);
		$xx[$i] = $this->NbLines($this->tb_header_type[$i]['WIDTH'],$this->tb_header_type[$i]['TEXT']);
		$ln = max($ln, $this->tb_header_type[$i]['LN_SIZE']);
		$nb = max($nb,$xx[$i]);
	}

	//this is the maximum cell height
	$h = $ln * $nb;

	//Draw the cells of the row
	for($i=0;$i<$this->tb_columns;$i++)
	{
		//border size BRD_SIZE
		$this->SetLineWidth($this->tb_header_type[$i]['BRD_SIZE']);

		//fill color = BG_COLOR
		list($r, $g, $b) = $this->tb_header_type[$i]['BG_COLOR'];
		$this->SetFillColor($r, $g, $b);

		//Draw Color = BRD_COLOR
		list($r, $g, $b) = $this->tb_header_type[$i]['BRD_COLOR'];
		$this->SetDrawColor($r, $g, $b);

		//Text Color = T_COLOR
		list($r, $g, $b) = $this->tb_header_type[$i]['T_COLOR'];
		$this->SetTextColor($r, $g, $b);

		//Set the font, font type and size
		$this->SetFont(	$this->tb_header_type[$i]['T_FONT'],
						$this->tb_header_type[$i]['T_TYPE'],
						$this->tb_header_type[$i]['T_SIZE']);

		$w=$this->tb_header_type[$i]['WIDTH'];

		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();

		//Print the text
		$this->MultiCell(
				$w, $h / $xx[$i],
				$this->tb_header_type[$i]['TEXT'],
				$this->tb_header_type[$i]['BRD_TYPE'],
				$this->tb_header_type[$i]['T_ALIGN'],
				1);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}

	//Go to the next line
	$this->Ln($ln*$nb);
}

//this function Draws the data's from the table
//have to call this function after the table initialization, after the table, header and data
//types are set and after the header is drawn
function Draw_Data($data){

	$nb = 0;
	$ln = 0;
	$xx = Array();
	$tt = Array();

	$this->SetX($this->table_startx);

	//calculate the maximum height of the cells
	for($i=0;$i<$this->tb_columns;$i++)
	{
		if (!isset($data[$i]['T_FONT']))
			$data[$i]['T_FONT'] = $this->tb_data_type[$i]['T_FONT'];
		if (!isset($data[$i]['T_TYPE']))
			$data[$i]['T_TYPE'] = $this->tb_data_type[$i]['T_TYPE'];
		if (!isset($data[$i]['T_SIZE']))
			$data[$i]['T_SIZE'] = $this->tb_data_type[$i]['T_SIZE'];
		if (!isset($data[$i]['T_COLOR']))
			$data[$i]['T_COLOR'] = $this->tb_data_type[$i]['T_COLOR'];
		if (!isset($data[$i]['T_ALIGN']))
			$data[$i]['T_ALIGN'] = $this->tb_data_type[$i]['T_ALIGN'];
		if (!isset($data[$i]['LN_SIZE']))
			$data[$i]['LN_SIZE'] = $this->tb_data_type[$i]['LN_SIZE'];
		if (!isset($data[$i]['BRD_SIZE']))
			$data[$i]['BRD_SIZE'] = $this->tb_data_type[$i]['BRD_SIZE'];
		if (!isset($data[$i]['BRD_COLOR']))
			$data[$i]['BRD_COLOR'] = $this->tb_data_type[$i]['BRD_COLOR'];
		if (!isset($data[$i]['BRD_TYPE']))
			$data[$i]['BRD_TYPE'] = $this->tb_data_type[$i]['BRD_TYPE'];
		if (!isset($data[$i]['BG_COLOR']))
			$data[$i]['BG_COLOR'] = $this->tb_data_type[$i]['BG_COLOR'];

		$this->SetFont(	$data[$i]['T_FONT'],
						$data[$i]['T_TYPE'],
						$data[$i]['T_SIZE']);
		$xx[$i] = $this->NbLines($this->tb_header_type[$i]['WIDTH'],$data[$i]['TEXT']);
		$ln = max($ln, $data[$i]['LN_SIZE']);
		$nb = max($nb,$xx[$i]);
	}

	//this is the maximum cell height
	$h = $ln * $nb;

	$this->CheckPageBreak($h);

	//Draw the cells of the row
	for($i=0;$i<$this->tb_columns;$i++)
	{
		//border size = BRD_SIZE
		$this->SetLineWidth($data[$i]['BRD_SIZE']);

		//fill color = BG_COLOR
		list($r, $g, $b) = $data[$i]['BG_COLOR'];
		$this->SetFillColor($r, $g, $b);

		//Draw Color = BRD_COLOR
		list($r, $g, $b) = $data[$i]['BRD_COLOR'];
		$this->SetDrawColor($r, $g, $b);

		//Text Color = T_COLOR
		list($r, $g, $b) = $data[$i]['T_COLOR'];
		$this->SetTextColor($r, $g, $b);

		//Set the font, font type and size
		$this->SetFont(	$data[$i]['T_FONT'],
						$data[$i]['T_TYPE'],
						$data[$i]['T_SIZE']);

		$w=$this->tb_header_type[$i]['WIDTH'];

		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();

		//Print the text
		$this->MultiCell(
				$w, $h / $xx[$i],
				$data[$i]['TEXT'],
				$data[$i]['BRD_TYPE'],
				$data[$i]['T_ALIGN'],
				1);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}

	//Go to the next line
	$this->Ln($ln*$nb);
}

//if the table is bigger than a page then it jumps to next page and draws the header
function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger){
		$this->Draw_Table_Border();
		$this->AddPage($this->CurOrientation);
		$table_startx = $this->GetX();
		$table_starty = $this->GetY();
		$this->Draw_Header();
	}

	//align the table
	$this->Table_Align();
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function Header()
{
	global $titulo;
	global $total;
	//Title
	$this->SetFont('Arial','',15);
	$this->Image("../imagenes/sapi.jpg",10,3,30,29,'JPG');
	$this->Cell(0,6,'Sistema de Marcas',0,1,'C');
	$this->Cell(0,6,'Listado',0,1,'C');
	//$this->Image("imagenes/milco1.jpg",160,5,40,10,'JPG');
	$this->SetFont('Arial','',10);
        $this->Cell(0,7,$titulo,0,1,'C');
  	$this->SetFont('Arial','',9);
  	$this->Cell(0,6,'Total de Peticionarios:'.$total,0,1,'C');
	   
	//Ensure table header is output
	parent::Header();
}

//Pie de página
function Footer()
{
    //Posición: a 2,0 cm del final
    $this->SetY(-20);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	 $this->Text(10,265,"Fecha:");
	 $this->text(20,265,date('d/m/y'),0,1); 
	 $this->Text(185,265,"Hora:");
	 $this->text(192,265,date('h:i A'),0,1); 
	 	 
 }

}//end of PDF_Table class

error_reporting(E_ALL);

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 9 columns
$pdf->Table_Init(9);

//set table style
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,0,102) ,
						'BRD_SIZE' => 0.5
					));

//set header style
$header_type = array(
			0=>array(
				'WIDTH' => 14,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Pedido',
				),
			1=>array(
				'WIDTH' => 14,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Recibo',
				),
			2=>array(
				'WIDTH' => 20,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Fec.Recibo',
				),
			3=>array(
				'WIDTH' => 9,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Tipo',
				),
			4=>array(
				'WIDTH' => 50,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Denominacion',
				),
			5=>array(
				'WIDTH' => 40,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Solicitante',
				),
			6=>array(
				'WIDTH' => 18,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Fec.Carga',
				),
			7=>array(
				'WIDTH' => 20,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Hora',
				),
			8=>array(
				'WIDTH' => 18,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 9,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(142,165,188),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => 'Usuario',
				)

	  );
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = array (
		0=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		1=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		2=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		3=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		4=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		5=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		6=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			//'LN_SPACE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		7=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		8=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),		
	  );

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();
$tsize = 5;
$rr = 255;

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['pedido'];
	$data[1]['TEXT'] = $registro['recibo'];
	$data[2]['TEXT'] = $registro['f_recibo'];
	$data[3]['TEXT'] = $registro['modo'];
	$data[4]['TEXT'] = trim($registro['denominacion']);
	$data[5]['TEXT'] = trim($registro['solicitante']);
	$data[6]['TEXT'] = $registro['f_carga'];
	$data[7]['TEXT'] = $registro['hora'];
	$data[8]['TEXT'] = $registro['usuario'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);

  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
