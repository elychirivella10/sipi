<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

//Variables de sesion
$login = $_SESSION['usuario_login'];
$modulo= "m_rptevento.php";

$nconexion = insconex($usuario,$modulo,'C');

//PDF Encabezados
$encab_principal= "Sistema de Indicaciones Geograficas";
$encabezado= "Listado de Eventos del Sistema";

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(10);
$columns=10;

//set table style
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Descripción ");
		$header_type[$i]['WIDTH'] = 70;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 10;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Inf. Adc ");
		$header_type[$i]['WIDTH'] = 15;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mensaje ");
		$header_type[$i]['WIDTH'] = 52;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Plazo ");
		$header_type[$i]['WIDTH'] = 12;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo Plz");
		$header_type[$i]['WIDTH'] = 20;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Comentario ");
		$header_type[$i]['WIDTH'] = 30;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Docmt");
		$header_type[$i]['WIDTH'] = 20;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Aplicable ");
		$header_type[$i]['WIDTH'] = 20;

$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Conexion
$sql = new mod_db();
$sql->connection($login);

$resultado=pg_exec("select * from stzevder where tipo_mp ='I' order by evento");
$logout = salirconx($nconexion);

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = ($registro['evento']-3000);
	$data[1]['TEXT'] = $registro['descripcion'];
	$data[2]['TEXT'] = $registro['tipo_evento'];
	$data[3]['TEXT'] = $registro['inf_adicional'];
	$data[4]['TEXT'] = $registro['mensa_automatico'];
	$data[5]['TEXT'] = $registro['plazo_ley'];
	$data[6]['TEXT'] = $registro['tipo_plazo'];
	$data[7]['TEXT'] = $registro['tit_comenta'];
	$data[8]['TEXT'] = $registro['tit_nro_doc'];
	$data[9]['TEXT'] = $registro['aplica'];
	$registro = pg_fetch_array($resultado);
	
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();
  
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean();
$pdf->Output();

?>
