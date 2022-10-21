<?php
// *************************************************************************************
// Programa: m_rptconfon1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010
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

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de B&uacute;squedas Fon&eacute;ticas/Gr&aacute;ficas Pendientes por Procesar');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$hastac   = $_POST["hastac"];
$tipobusq = trim($_POST["tipobusq"]);
$vplus    = trim($_POST['vplus']);
$recibo   = trim($_POST['recibo']);
$vsede    = trim($_POST['options']);

//Query para buscar las opciones deseadas
$where=""; 
$titulo='';
$from = ' stmbusweb ';

if (empty($vsede)) { $vsede="0"; } 
 
if(empty($hastac)) {  
   $smarty->display('encabezado1.tpl');
   Mensajenew('ERROR: Debe colocar la Fecha Tope ...!!!','javascript:history.back();','N');    
   ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   $smarty->display('pie_pag.tpl'); 
   $sql->disconnect(); exit(); 
}

if(!empty($hastac)) {
  if(empty($where)) {
    $where = $where." (stmbusweb.fecha_carga<='$hastac')";
    $titulo= $titulo." Cargado hasta el: "."$hastac"; }
  else {
    $where = $where." AND (stmbusweb.fecha_carga<='$hastac')";
    $titulo= $titulo." Cargado hasta el: "."$hastac"; }
}

if ($tipobusq!='T') { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusweb.tipo_busq='$tipobusq')";
     $titulo= $titulo." Tipo Busqueda: "."$tipobusq";  }
}

if ($vplus=='1') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusweb.estado='1')";
     $titulo= $titulo." Por Procesar";  }
}

if ($vplus=='2') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusweb.estado='2')";
     $titulo= $titulo." Procesado por Enviar";  }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusweb.nro_tramite='$recibo')";
     $titulo= $titulo." Factura No: "."$recibo";  }
}

$where = $where." ORDER BY 1,2"; 
$res_pedido=pg_exec("SELECT nro_tramite,nro_pedido,tipo_busq,fecha_bus,nombre,clase,fecha_carga,usuario,solicitante FROM $from WHERE $where ");
$filasfound=pg_numrows($res_pedido);

//echo " SELECT nro_tramite,nro_pedido,tipo_busq,fecha_bus,nombre,clase,fecha_carga,usuario,solicitante FROM $from WHERE $where "; exit();


if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  Mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptbuspen.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Pedidos: ".$filasfound; 
$encab_principal = "Sistema de Marcas";
$encabezado = "Servicio de Tramites de Busquedas";
$titulo = "Auditoria de Busquedas Cargadas por Procesar/Enviar";

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
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
		$header_type[$i]['TEXT'] = utf8_decode("Tramite ");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Tramite ");
		$header_type[$i]['WIDTH'] = 17;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Pedido");
		$header_type[$i]['WIDTH'] = 12;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tp");
		$header_type[$i]['WIDTH'] = 6;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 72;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cl");
		$header_type[$i]['WIDTH'] = 6;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 58;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante");
		$header_type[$i]['WIDTH'] = 55;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F Carga");
		$header_type[$i]['WIDTH'] = 16;

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

$total_fon = 0;
$total_gra = 0;
//Dibujando la Tabla para el pdf
 $regef = pg_fetch_array($res_pedido);
 for($cont=0;$cont<$filasfound;$cont++) {
   $npedido    =trim($regef['nro_pedido']);
   $recibo     =trim($regef['nro_tramite']);
   $fecharec   =$regef['fecha_bus'];
   $solicitante=trim($regef['solicitante']);
   $vusuario   =trim($regef['usuario']);
   $tipobusq   =$regef['tipo_busq'];
   $nombre     =trim($regef['nombre']);
   $clase      =$regef['clase'];
   $fcarga     =$regef['fecha_carga'];

   if ($tipobusq=="F") { $total_fon = $total_fon + 1; } 
   if ($tipobusq=="G") { $total_gra = $total_gra + 1; } 

   $data = Array();
   $data[0]['TEXT'] = $recibo;
   $data[1]['TEXT'] = $fecharec;
   $data[1]['T_ALIGN'] = "C";
   $data[2]['TEXT'] = $npedido;
   $data[2]['T_ALIGN'] = "C";
   $data[3]['TEXT'] = $tipobusq;	
   $data[3]['T_ALIGN'] = "C";
   $data[4]['TEXT'] = utf8_decode($nombre);
   $data[5]['TEXT'] = $clase;
   $data[6]['TEXT'] = utf8_decode($vusuario);
   $data[7]['TEXT'] = utf8_decode($solicitante);
   $data[8]['TEXT'] = $fcarga;	
   $data[8]['T_ALIGN'] = "C";
   $regef = pg_fetch_array($res_pedido);
   $pdf->Draw_Data($data);
  }

$pdf->SetX(10);
$pdf->Cell(0,8,"  Total Busquedas Foneticas: ".$total_fon."                      Total Busquedas Graficas: ".$total_gra."                     Total Busquedas: ".$filasfound,0,1);

$pdf->Draw_Table_Border();
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
