<?php
// *************************************************************************************
// Programa: p_rptpubpat.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2017 I Semestre
// *************************************************************************************
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
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Auditor&iacute;a de Publicaciones Patentes en Prensa Digital SAPI');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$hastac   = $_POST["hastac"];

//Query para buscar las opciones deseadas
$where=""; 
$titulo='';
$from = ' stppagopren ';

if (empty($vsede)) { $vsede="0"; } 
 
if(empty($hastac)) {  
   $smarty->display('encabezado1.tpl');
   Mensajenew('ERROR: Debe colocar la Fecha de Publicacion ...!!!','javascript:history.back();','N');    
   ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   $smarty->display('pie_pag.tpl'); 
   $sql->disconnect(); exit(); 
}

if(!empty($hastac)) {
  if(empty($where)) {
    $where = $where." (stppagopren.fecha_publi='$hastac')";
    $titulo= $titulo." Con Fecha de Publicacion el: "."$hastac"; }
  else {
    $where = $where." AND (stppagopren.fecha_publi='$hastac')";
    $titulo= $titulo." Con Fecha de Publicacion el: "."$hastac"; }
}

$where = $where." ORDER BY 4"; 
$res_pedido=pg_exec("SELECT factura,fecha_fac,nro_derecho,solicitud,boletin,estatus,usuario,fecha_carga,hora_carga,fecha_publi,fecha_gene,hora_gene,sede FROM $from WHERE $where ");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  Mensajenew('AVISO: No existen Datos Asociados ...!!!','p_rptpubpat.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Publicaciones: ".$filasfound; 
$encab_principal = "Sistema de Patentes";
$encabezado = "Servicio de Publicaciones en Prensa";
$titulo = "Auditoria de Publicaciones Taquilla/Webpi";

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

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
		$header_type[$i]['TEXT'] = utf8_decode("Factura ");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Factura ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Boletin");
		$header_type[$i]['WIDTH'] = 15;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 20;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 20;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Carga");
		$header_type[$i]['WIDTH'] = 22;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Hora Carga");
		$header_type[$i]['WIDTH'] = 20;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Publicación");
		$header_type[$i]['WIDTH'] = 24;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Vía del Tramite");
		$header_type[$i]['WIDTH'] = 24;

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

$total_taq = 0;
$total_web = 0;
//Dibujando la Tabla para el pdf
 $regef = pg_fetch_array($res_pedido);
 for($cont=0;$cont<$filasfound;$cont++) {
   $recibo     =trim($regef['factura']);
   $fecharec   =$regef['fecha_fac'];
   $solicitud  =trim($regef['solicitud']);
   $nboletin   =trim($regef['boletin']);
   $vusuario   =trim($regef['usuario']);
   $fcarga     =$regef['fecha_carga'];
   $hcarga     =$regef['hora_carga'];
   $fpubli     =$regef['fecha_publi'];
   $tipotram   =$regef['sede'];


   if ($tipotram=="3") { $total_web = $total_web + 1; $origentram="Webpi"; }
   else { $total_taq = $total_taq + 1; $origentram="Taquilla"; }

   $data = Array();
   $data[0]['TEXT'] = $recibo;
   $data[0]['T_ALIGN'] = "C";
   $data[1]['TEXT'] = $fecharec;
   $data[1]['T_ALIGN'] = "C";
   $data[2]['TEXT'] = $nboletin;
   $data[2]['T_ALIGN'] = "C";
   $data[3]['TEXT'] = $solicitud;
   $data[3]['T_ALIGN'] = "C";
   $data[4]['TEXT'] = $vusuario;
   $data[5]['TEXT'] = $fcarga;	
   $data[5]['T_ALIGN'] = "C";
   $data[6]['TEXT'] = $hcarga;	
   $data[6]['T_ALIGN'] = "C";
   $data[7]['TEXT'] = $fpubli;	
   $data[7]['T_ALIGN'] = "C";
   $data[8]['TEXT'] = $origentram;
   $regef = pg_fetch_array($res_pedido);
   $pdf->Draw_Data($data);
  }

$pdf->SetX(10);
$pdf->Cell(0,8,"                Total Publicaciones Taquilla: ".$total_taq."                      Total Publicaciones WEBPI: ".$total_web."                     Total Publicaciones: ".$filasfound,0,1);

$pdf->Draw_Table_Border();
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
