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
$smarty->assign('subtitulo','Relacion de Derechos de Registros Cancelados');
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
$totalpag= $_GET['tpag'];

//echo " $recibo, $usuario ";
  
echo " $recibo, $totalpag ";


//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Relacion de Derechos de Registros Cancelados";

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$select = "SELECT ";
$orderby= "stzderec.registro"; 

$resultado=pg_exec($select."stzderec.solicitud, stzderec.registro, stzderec.nombre,stzderec.tipo_derecho,stmmarce.modalidad,stzevtrd.evento, stzevtrd.fecha_event, stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzderec.fecha_regis
						FROM  stmmarce, stzderec, stmpagocon, stzevtrd
						WHERE stmpagocon.factura = '$recibo' 
                  AND stzevtrd.evento = 1795
						AND stzderec.nro_derecho = stmmarce.nro_derecho 
						AND stmmarce.nro_derecho = stzevtrd.nro_derecho
						AND stmmarce.nro_derecho = stmpagocon.nro_derecho 
		 	         AND stzderec.tipo_mp= 'M'
						ORDER BY ".$orderby);	

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$reg = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
//$total='Total de Derechos Cancelados: '.$filas_resultado;

//Incio de la Clase de PDF para generar los reportes

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(11);
$columns=11;

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
		$header_type[$i]['WIDTH'] = 20;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 55;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 9;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mod");
		$header_type[$i]['WIDTH'] = 9;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 13;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Actual");
		$header_type[$i]['WIDTH'] = 13;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 18;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Reg.");
		$header_type[$i]['WIDTH'] = 18;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc");
		$header_type[$i]['WIDTH'] = 18;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 13;
		$i=10;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans");
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
	$data[6]['TEXT'] = $reg['registro'];
	$data[7]['TEXT'] = $reg['fecha_regis'];
	$data[8]['TEXT'] = $reg['fecha_venc'];
	$data[9]['TEXT'] = $reg['evento']-1000;
	$data[10]['TEXT'] = $reg['fecha_trans'];

	//if (!empty($evento)) {
	//  $data[10]['TEXT'] = $registro['documento']; }
   //     else {
	//  $data[10]['TEXT'] = ' '; }
	$reg = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
 //$pdf->SetX(12);
 $pdf->Cell(0,8,"Solicitante: ".$solicitante.", CI/Rif: ".$identif."        Total Derechos Cancelados: ".$filas_resultado,0,1);
 $pdf->Cell(0,8,"Recibo No.: ".$recibo."       de Fecha: ".$fechafac."    ".$totalpag." ".$ftotal,0,1); 

 $pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
