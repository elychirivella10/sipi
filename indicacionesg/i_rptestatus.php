<?php

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

//PDF Encabezados
$encab_principal= "Sistema de Indicaciones Geograficas";
$encabezado= "Listado de Estatus del Sistema";

$usuario = $_SESSION['usuario_login'];
$modulo= "i_rptestatus.php";

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 3 columns
$pdf->Table_Init(3);

//set table style
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
$header_type = array(
			0=>array(
				'WIDTH' => 20,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 12,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255, 249, 204),
				'BRD_COLOR' => array(0,92,177),
				'BRD_SIZE' => 0.2,
				'BRD_TYPE' => '1',
				'TEXT' => 'Estatus',
				),
			1=>array(
				'WIDTH' => 140,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 12,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255, 249, 204),
				'BRD_COLOR' => array(0,92,177),
				'BRD_SIZE' => 0.2,
				'BRD_TYPE' => '1',
				'TEXT' => 'Descripcion',
				),
			2=>array(
				'WIDTH' => 25,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 12,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255, 249, 204),
				'BRD_COLOR' => array(0,92,177),
				'BRD_SIZE' => 0.2,
				'BRD_TYPE' => '1',
				'TEXT' => 'Publicable',
				)
	  );

$pdf->Set_Header_Type($header_type);

//set data style
$data_type = array (
		0=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,92,177),
			'BRD_SIZE' => 0.1,
			'BRD_TYPE' => '1',
			),
		1=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,92,177),
			'BRD_SIZE' => 0.1,
			'BRD_TYPE' => '1',
			),
		2=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(0,92,177),
			'BRD_SIZE' => 0.1,
			'BRD_TYPE' => '1',
			),
	  );

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();
$tsize = 5;
$rr = 255;

$sql = new mod_db();
$sql->connection();


$resultado=pg_exec("select * from stzstder where tipo_mp ='I' order by estatus");
$logout = salirconx($nconexion);

ob_end_clean(); 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['estatus']-3000;
	$data[1]['TEXT'] = $registro['descripcion'];
	$data[2]['TEXT'] = $registro['publicable'];
	$registro = pg_fetch_array($resultado);
	
	$pdf->Draw_Data($data);

  }

$pdf->Draw_Table_Border();

$sql->disconnect();

header('Content-type: application/pdf');
$pdf->Output();

?>
