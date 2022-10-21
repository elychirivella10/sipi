<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$modulo= "a_rptmigest.php";

//PDF Encabezados
$encab_principal= "Sistema de Derecho de Autor";
$encabezado= utf8_decode("Listado de Migración de Estatus");

$nconexion = insconex($usuario,$modulo,'C');

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 

$pdf->Table_Init(6);
$columns=6;
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
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento ");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mig.Desde ");
		$header_type[$i]['WIDTH'] = 22;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mig.Hasta");
		$header_type[$i]['WIDTH'] = 22;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento ");
		$header_type[$i]['WIDTH'] = 64;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mig.Desde ");
		$header_type[$i]['WIDTH'] = 66;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mig.Hasta ");
		$header_type[$i]['WIDTH'] = 66;

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

$sql = new mod_db();
$sql->connection($login);

pg_exec(" CREATE TEMPORARY TABLE tabla (evento,desc_eve,estatus_ini,desc_ini,estatus_fin,desc_fin) as 
  select x1.evento ,x1.descripcion ,x0.estatus_ini ,x2.descripcion,x0.estatus_fin ,x3.descripcion 
    from stdmigrr x0,stdevobr x1 ,stdstobr x2 ,stdstobr x3 
    where ((((x2.estatus = x0.estatus_ini ) AND (x3.estatus= x0.estatus_fin ) )
            AND (x1.evento = x0.evento ) ) AND (1 = 1 ) ) ;  ");
    
$resultado=pg_exec("select * from tabla order by evento");
$logout = salirconx($nconexion);     

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['evento'];
	$data[1]['TEXT'] = $registro['estatus_ini'];
	$data[2]['TEXT'] = $registro['estatus_fin'];
	$data[3]['TEXT'] = trim($registro['desc_eve']);
	$data[4]['TEXT'] = trim($registro['desc_ini']);
	$data[5]['TEXT'] = trim($registro['desc_fin']);
	$registro = pg_fetch_array($resultado);	
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

$sql->disconnect();
ob_end_clean(); 
$pdf->Output();

?>
