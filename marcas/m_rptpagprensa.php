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

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Relacion de Pagos de Solicitudes a Publicar en Prensa');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$recibo  = $_GET['vfac'];
$fechafac= $_GET['vfec'];
$usuario = $_GET['vusr'];
$identif = $_GET['viden'];
$ftotal  = $_GET['ftot'];
$solicitante = $_GET['vsol'];

//PDF Encabezados
$encab_principal= "Sistema de Marcas/Patentes";
$encabezado= "Relacion de Pagos de Solicitudes a Publicar en Prensa";

//Incio de la Clase de PDF para generar los reportes
//Inicio del Pdf
header('Content-type: application/pdf'); 
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//$select = "SELECT ";
//$resulprensa=pg_exec($select."factura,nro_derecho,solicitud,boletin,fecha_carga,hora_carga
//		     FROM stmpagopren WHERE stmpagopren.factura='$recibo'");	
//$filasprensam=pg_numrows($resulprensa); 

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$select = "SELECT ";
$orderby= "stzderec.solicitud"; 

$resultado=pg_exec($select."stzderec.solicitud, stzderec.nombre,stzderec.tipo_derecho,stmmarce.modalidad,stmmarce.clase,stmmarce.ind_claseni,stzderec.estatus,stmpagopren.boletin,
stmpagopren.fecha_carga,stmpagopren.hora_carga,stmpagopren.fecha_publi
		  FROM stmmarce, stzderec, stmpagopren
		  WHERE stmpagopren.factura = '$recibo' 
		  AND stzderec.nro_derecho = stmmarce.nro_derecho 
		  AND stmmarce.nro_derecho = stmpagopren.nro_derecho 
		  AND stzderec.tipo_mp= 'M'
		  ORDER BY ".$orderby);	

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_foundm=pg_numrows($resultado); 
//if ($filas_foundm==0)    {
//     $smarty->display('encabezado1.tpl');
//     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
//     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if ($filas_foundm!=0) {
$reg = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

$pdf->Setfont('Arial','B',14);
$pdf->MultiCell(0,5,'MARCAS A PUBLICAR EN PRENSA:',0,'J',0);
$pdf->Setfont('Arial','B',8);

//initialize the table 
$pdf->Table_Init(9);
$columns=9;

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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 78;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 8;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mod");
		$header_type[$i]['WIDTH'] = 8;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 11;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus Actual");
		$header_type[$i]['WIDTH'] = 13;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Bol");
		$header_type[$i]['WIDTH'] = 9;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Carga");
		$header_type[$i]['WIDTH'] = 32;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Publicación");
		$header_type[$i]['WIDTH'] = 18;

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
	$data[0]['TEXT'] = $reg['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($reg['nombre']));
	$data[2]['TEXT'] = $reg['tipo_derecho'];
	$data[3]['TEXT'] = $reg['modalidad'];
	$data[4]['TEXT'] = $reg['clase'].'-'.$reg['ind_claseni'];
	$data[5]['TEXT'] = $reg['estatus']-1000;
	$data[6]['TEXT'] = $reg['boletin'];
	$data[7]['TEXT'] = $reg['fecha_carga']." / ".$reg['hora_carga'];
	$data[8]['TEXT'] = $reg['fecha_publi'];

	$reg = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
 }
 //$pdf->SetX(12);

 $pdf->Draw_Table_Border();
 $pdf->ln(2); 
 $pdf->Setfont('Arial','B',9);
 $pdf->Cell(0,8,"Total Marcas a Publicar: ".$filas_resultado,0,1);
 $pdf->ln(6); 
}

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$select = "SELECT ";
$orderby= "stzderec.solicitud"; 

$resultado=pg_exec($select."stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho,stzderec.estatus,stppagopren.boletin,
stppagopren.fecha_carga,stppagopren.hora_carga,nro_publica,stppagopren.fecha_publi
		  FROM stzderec, stppagopren
		  WHERE stppagopren.factura = '$recibo' 
		  AND stzderec.nro_derecho = stppagopren.nro_derecho 
		  AND stzderec.tipo_mp= 'P'
		  ORDER BY ".$orderby);	

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_foundp=pg_numrows($resultado); 
//if ($filas_foundp==0)    {
//     $smarty->display('encabezado1.tpl');
//     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
//     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if ($filas_foundp!=0)    {
$reg = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

 $pdf->Setfont('Arial','B',14);
 $pdf->MultiCell(0,5,'PATENTES A PUBLICAR EN PRENSA:',0,'J',0);
 $pdf->Setfont('Arial','B',8);

//Incio de la Clase de PDF para generar los reportes
//Inicio del Pdf
//header('Content-type: application/pdf'); 
//$pdf=new PDF_Table('P','mm','Letter');
//$pdf->Open();
//$pdf->AddPage();
//$pdf->AliasNbPages();

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

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titulo ");
		$header_type[$i]['WIDTH'] = 84;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 9;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus Actual");
		$header_type[$i]['WIDTH'] = 13;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Bol");
		$header_type[$i]['WIDTH'] = 8;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Carga");
		$header_type[$i]['WIDTH'] = 32;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Publicación");
		$header_type[$i]['WIDTH'] = 18;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Publicación");
		$header_type[$i]['WIDTH'] = 18;

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
	$data[0]['TEXT'] = $reg['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($reg['nombre']));
	$data[2]['TEXT'] = $reg['tipo_derecho'];
	$data[3]['TEXT'] = $reg['estatus']-2000;
	$data[4]['TEXT'] = $reg['boletin'];
	$data[5]['TEXT'] = $reg['fecha_carga']." / ".$reg['hora_carga'];
	$data[6]['TEXT'] = $reg['nro_publica'];
	$data[7]['TEXT'] = $reg['fecha_publi'];

	$reg = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
 }
 //$pdf->SetX(12);

 $pdf->Draw_Table_Border();

 $pdf->ln(2); 
 $pdf->Setfont('Arial','B',9);
 $pdf->Cell(0,8,"Total Patentes a Publicar: ".$filas_resultado,0,1);
 $pdf->ln(4); 
}

 $pdf->Setfont('Arial','B',10);
 $pdf->Cell(0,8,"Solicitante: ".$solicitante.", CI/Rif: ".$identif,0,1);
 $pdf->Cell(0,8,"Factura No.: ".$recibo."     de Fecha: ".$fechafac.",    Total Bolivares: ".$ftotal,0,1); 


 $pdf->Cell(0,8,"Firman estando Conforme con lo solicitado y cargado al Sistema: ",0,1); 
 $pdf->Cell(0,8,"                                                                ",0,1); 
 $pdf->Cell(0,8,"                                               El Solicitante: ________________________ el Funcionario: _________________________",0,1); 


//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
