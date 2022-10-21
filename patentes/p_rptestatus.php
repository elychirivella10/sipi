<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
	
//Class Extention for header and footer	
require_once("$include_lib/header_footer.inc");

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Listado de Estatus del Sistema";

//Conexion
$login = $_SESSION['usuario_login'];
$modulo= "p_rptestatus.php";

$nconexion = insconex($usuario,$modulo,'C');
//Conexion
$sql = new mod_db();
$sql->connection($login);

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

// Tablas para estatus
//load the table default definitions DEFAULT!!!
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron
	require("$include_path/tablas_def.inc");

	$columns = 3; //number of Columns	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	
	$aSimpleHeader = array();
	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Estatus ";
		$aSimpleHeader[$i]['WIDTH'] = 20;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Descripción ");
		$aSimpleHeader[$i]['WIDTH'] = 150;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Publicable ";
		$aSimpleHeader[$i]['WIDTH'] = 20;
             
	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

$resultado=pg_exec("select * from stzstder where tipo_mp ='P' order by estatus");
$logout = salirconx($nconexion);

$registro = pg_fetch_array($resultado);
$filas_found=pg_numrows($resultado); 

	for ($j=0; $j<$filas_found; $j++)
	{
		$data = Array();
		$data[0]['TEXT'] = ($registro['estatus']-2000);
		$data[1]['TEXT'] = trim($registro['descripcion']);
		$data[2]['TEXT'] = trim($registro['publicable']);
		$pdf->tbDrawData($data);
		$registro = pg_fetch_array($resultado);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->Ln(6);

$sql->disconnect();
ob_end_clean(); 
$pdf->Output();

?>
