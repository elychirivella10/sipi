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

//Variable de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = trim($_SESSION['usuario_login']);
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones por Solicitud');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$boletin1=trim($_POST["boletin1"]);
$boletin2=trim($_POST["boletin2"]);
if (empty($boletin2)) { $boletin2=$boletin1; }
$orden = $_POST["orden"];

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado de Solicitudes en Estatus 8 por Evaluar";

//Query para buscar las opciones deseadas
$where='';
$titulo='';

//$select  = "SELECT DISTINCT ON (stzderec.solicitud) ";
$select  = "SELECT ";
$where   = " stzderec.estatus= 1008 AND stzderec.tipo_mp = 'M' AND evento IN (1072,1078,1093,1095,1121,1124,1168,1888,1927,1983,1985,1990,1997) ";
$orderby = " stzevtrd.documento,stzderec.solicitud";

if(!empty($boletin1)) { 
  if(!empty($where)) {
    $where = $where." AND stzderec.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento IN (1072,1078,1093,1095,1121,1124,1168,1888,1927,1983,1985,1990,1997) AND (stzevtrd.documento >= '$boletin1' AND stzevtrd.documento <= '$boletin2'))";
    $titulo= $titulo." Sin Boletin(es): "."$boletin1"." al: "."$boletin2";
  }
}
else {
 $titulo= " Todos los Boletines";
}

//Conexion 
$sql = new mod_db();
$sql->connection($login);

//  Armando el query
//  Borrado del query a peticion de nelson DISTINCT ON(stmmarce.solicitud)
//  Se condiciono el select y el order by porque cuando no se indica un evento
//  se trae todos los eventos de stmevtrd. 

//  Borrado del query por problema en los eventos cargados por sandra DISTINCT ON(stmmarce.solicitud) 25/07/2013
//if (empty($evento)) {$select = "SELECT DISTINCT ON (stzderec.solicitud) ";
//                     $orderby= "stzderec.solicitud"; }


$qquery = "$select
 stzderec.solicitud,stzderec.nro_derecho,fecha_solic,nombre,modalidad,stmmarce.clase,stmmarce.ind_claseni,stzevtrd.evento-1000 as evento,stzevtrd.documento,stzderec.estatus-1000 as estatus
FROM stmmarce, stzevtrd, stzderec
WHERE $where
AND stzevtrd.nro_derecho = stzderec.nro_derecho
AND stzderec.nro_derecho=stmmarce.nro_derecho
AND stzderec.nro_derecho NOT IN (select nro_derecho from stmforfon) 
ORDER BY $orderby";

/*
$qquery = "$select stzderec.solicitud, stzderec.registro,stzderec.nombre,stmmarce.modalidad,stzevtrd.evento,stzevtrd.estat_ant,stzevtrd.fecha_event,stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento,stzevtrd.comentario 
						FROM  stmmarce, stzevtrd, stzderec
						WHERE $where 
						AND stzevtrd.nro_derecho = stzderec.nro_derecho
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp = 'M'
						ORDER BY $orderby";
*/

//echo " $qquery  "; 
//exit();
						
$resultado=pg_exec($select." stzderec.solicitud,stzderec.nro_derecho,fecha_solic,nombre,modalidad,stmmarce.clase,stmmarce.ind_claseni,stzevtrd.evento-1000 as evento,stzevtrd.documento,stzderec.estatus-1000 as estatus
FROM stmmarce, stzevtrd, stzderec
WHERE $where
AND stzevtrd.nro_derecho = stzderec.nro_derecho
AND stzderec.nro_derecho=stmmarce.nro_derecho
AND stzderec.nro_derecho NOT IN (select nro_derecho from stmforfon) 
						ORDER BY ".$orderby);	
 
//stmevtrd.evento,stmevtrd.fecha_event, stmmarce.solicitud,

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;

//Incio de la Clase de PDF para generar los reportes

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(8);
$columns=8;

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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 17;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 116;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("M");
		$header_type[$i]['WIDTH'] = 5;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 10;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Even");
		$header_type[$i]['WIDTH'] = 9;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Doc.");
		$header_type[$i]['WIDTH'] = 10;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus");
		$header_type[$i]['WIDTH'] = 14;

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

//Dibujando la Tabla 
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[3]['TEXT'] = $registro['modalidad'];
	$data[4]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[5]['TEXT'] = $registro['evento'];
	$data[6]['TEXT'] = $registro['documento'];
	$data[7]['TEXT'] = $registro['estatus'];
	$registro = pg_fetch_array($resultado);
	
	$pdf->Draw_Data($data);

  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
