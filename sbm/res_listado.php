<?php 
// Programa PHP. Busqueda de Lista de Resultados de Consulta Avanzada
// (Lis_compleja.php por Consulta Avanzada)
// Realizado Por Ing. Romulo Mendoza Julio 2008 

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

include ("lib/template.inc.php");	// taken from PHPLib
include ("inc/constantes.inc");
include ("lis_funcion.php");

//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Reporte de Busqueda Tecnica');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Reporte de de Busqueda Tecnica";

//Conexion con la base de datos SAPI
require ("inc/NormalizaParametros.inc");
$sql = new mod_db();

//Verificando conexion
$sql->connection();

// Realizando Consulta por Busqueda Avanzada
$opcion1 = $_GET["opcion1"];
$opcion1 = normaliza_texto($opcion1);
$opcion2 = $_GET["opcion2"];
$opcion2 = normaliza_texto($opcion2);
$opcion3 = $_GET["opcion3"];
$opcion3 = normaliza_texto($opcion3);
$opcion4 = $_GET["opcion4"];
$opcion4 = normaliza_texto($opcion4);
$opcion5 = $_GET["opcion5"];
$opcion5 = normaliza_texto($opcion5);
$opcion6 = $_GET["opcion6"];
$opcion6 = normaliza_texto($opcion6);
$opcion7 = $_GET["opcion7"];
$opcion7 = normaliza_texto($opcion7);
$opcion8 = $_GET["opcion8"];
$opcion8 = normaliza_texto($opcion8);
$opcion9 = $_GET["opcion9"];
$opcion9 = normaliza_texto($opcion9);

$modocon1= $_GET["modocon1"];
$modocon2= $_GET["modocon2"];
$modocon3= $_GET["modocon3"];
$modocon4= $_GET["modocon4"];
$modocon5= $_GET["modocon5"];
$modocon6= $_GET["modocon6"];
$modocon7= $_GET["modocon7"];
$modocon8= $_GET["modocon8"];
$modocon9= $_GET["modocon9"];
$modo1   = $_GET["modo1"];
$modo2   = $_GET["modo2"];
$modo3   = $_GET["modo3"];
$modo4   = $_GET["modo4"];
$modo5   = $_GET["modo5"];
$modo6   = $_GET["modo6"];
$modo7   = $_GET["modo7"];
$modo8   = $_GET["modo8"];
$modo9   = $_GET["modo9"];
$modover = $_GET["modover"];

//Creando tabla temporal
pg_exec("CREATE TEMPORARY TABLE consulta (solicitud char(11))");
pg_exec("CREATE TEMPORARY TABLE consulta3 (solicitud char(11), cant char(3))");
pg_exec("CREATE TEMPORARY TABLE consulta4 (solicitud char(11), cant char(3))");

$ind=0;
if(!empty($opcion1)) {
  $ind=$ind+1;
  $criterio=$criterio.$modo1.": ".$opcion1." "; 
  $resulopc1 = sqlcompara($modo1,$modocon1,$opcion1);  
}  

if(!empty($opcion2)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo2.": ".$opcion2." "; 
  $resulopc1 = sqlcompara($modo2,$modocon2,$opcion2);
}

if(!empty($opcion3)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo3.": ".$opcion3." "; 
  $resulopc1 = sqlcompara($modo3,$modocon3,$opcion3);
}

if(!empty($opcion4)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo4.": ".$opcion4." "; 
  $resulopc1 = sqlcompara($modo4,$modocon4,$opcion4);
}

if(!empty($opcion5)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo5.": ".$opcion5." "; 
  $resulopc1 = sqlcompara($modo5,$modocon5,$opcion5);
}

if(!empty($opcion6)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo6.": ".$opcion6." "; 
  $resulopc1 = sqlcompara($modo6,$modocon6,$opcion6);
}

if(!empty($opcion7)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo7.": ".$opcion7." "; 
  $resulopc1 = sqlcompara($modo7,$modocon7,$opcion7);
}

if(!empty($opcion8)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo8.": ".$opcion8." "; 
  $resulopc1 = sqlcompara($modo8,$modocon8,$opcion8);
}

if(!empty($opcion9)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo9.": ".$opcion9." "; 
  $resulopc1 = sqlcompara($modo9,$modocon9,$opcion9);
}

$titulo= "Criterio de Busqueda: ".$criterio;

// Seleccionar resultado de los diferentes select
$cantidad = pg_exec("INSERT INTO consulta3 SELECT solicitud,count(*)
			    FROM consulta GROUP BY solicitud ORDER BY solicitud "); 
			    
$respuesta= pg_exec("INSERT INTO consulta4 SELECT solicitud FROM consulta3 WHERE cant='$ind'");

$where = $where." consulta4.solicitud=stzderec.solicitud";
$where = $where." AND stzderec.nro_derecho=stppatee.nro_derecho";
$where = $where." AND stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stppatee.nro_derecho=stzottid.nro_derecho";
$where = $where." AND stzsolic.titular = stzottid.titular";
$where = $where." AND stzderec.tipo_mp='P'";

$resultado=pg_exec("SELECT DISTINCT ON (consulta4.solicitud) consulta4.solicitud, stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,stzderec.estatus,stzderec.tramitante,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad FROM consulta4, stppatee, stzottid, stzsolic, stzderec WHERE $where ORDER BY 1");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total = "Total: ".$filas_resultado;

//Incio de la Clase de PDF para generar los reportes
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 90;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 19;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo ");
		$header_type[$i]['WIDTH'] = 10;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Est. ");
		$header_type[$i]['WIDTH'] = 10;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular ");
		$header_type[$i]['WIDTH'] = 110;

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

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = utf8_decode(trim($registro['nombre']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['tipo_derecho'];
	$data[4]['TEXT'] = $registro['estatus']-2000;
   $data[4]['ALIGN'] = "L";
	$data[5]['TEXT'] = utf8_decode(trim($registro['ntitular'])).", Domicilio: ".utf8_decode(trim($registro['domicilio'])).", Nacionalidad: ".$registro['nacionalidad'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>


