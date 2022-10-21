<?php
// *************************************************************************************
// Programa: m_rptplanbus1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2014
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

//ob_start();
//Para trabajar con Operaciones de Bases de Datos
//include ("../z_includes.php");
//Comienzo del Programa por los encabezados del reporte
//define('FPDF_FONTPATH',$root_path.'/font/');
//include ("$include_path/fpdf.php");
//ob_start();

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de Planillas B&uacute;squedas Foneticas Generadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$desde  = $_POST["fechfon1"];
$hasta  = $_POST["fechfon2"];
$desdec = $_POST["desdec"]; 
$hastac = $_POST["hastac"];
$usuario= trim($_POST["usuario"]);
$vsede  = trim($_POST['options']);
$recibo = trim($_POST['recibo']);
$planilla = trim($_POST['planilla']);

//Query para buscar las opciones deseadas
$where=""; 
$titulo='';
$from = ' stzplanfac ';

if (empty($vsede)) { $vsede="0"; } 
//   $smarty->display('encabezado1.tpl');
//   mensajenew('Error: No escogio la Sede ...!!!','javascript:history.back();','N');    
//   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
if(empty($desde) AND empty($hasta) AND empty($desdec) AND empty($hastac)) {  
   $smarty->display('encabezado1.tpl');
   mensajenew('ERROR: Es Obligatorio indicar alguna Fecha ...!!!','javascript:history.back();','N');    
   ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }


if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stzplanfac.fecha_gen>='$desdec' AND stzplanfac.fecha_gen<='$hastac')";
    $titulo= $titulo." Desde el: "."$desdec"." Hasta: "."$hastac"; }
  else {
    $where = $where." AND (stzplanfac.fecha_gen>='$desdec' AND stzplanfac.fecha_gen<='$hastac')";
    $titulo= $titulo." Desde el: "."$desdec"." Hasta: "."$hastac"; }
  
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzplanfac.usuario='$usuario')";
     $titulo= $titulo." por el Usuario: "."$usuario";  }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzplanfac.nro_factura='$recibo')";
     $titulo= $titulo." Factura No: "."$recibo";  }
}

if(!empty($planilla)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzplanfac.nplanilla2>=$planilla)";
     $titulo= $titulo." Planilla No: "."$planilla";  }
}

//if(!empty($vsede)) { 
//  if(!empty($where)) {
//     $where = $where." AND"." (stmbusqueda.sede='$vsede')";
//     $titulo= $titulo." de la Sede: "."$vsede";  }
//}

$where = $where." ORDER BY 1,3"; 

$res_pedido=pg_exec("SELECT nro_factura,cant_plan,nplanilla1,nplanilla2,fecha_gen,hora_gen,usuario FROM $from WHERE $where");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptplanbus.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo; 
//$total=$titulo.". Total de Planillas: ".$filasfound; 
$encab_principal = "Sistema de Marcas";
$encabezado = "Busqueda Fonetica/Grafica/Peticionario";
$titulo = "Auditoria de Planillas Generadas";

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(7);
$columns=7;

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
		$header_type[$i]['TEXT'] = utf8_decode("Factura No.");
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad ");
		$header_type[$i]['WIDTH'] = 15;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Planilla Inicial ");
		$header_type[$i]['WIDTH'] = 25;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Planilla Final");
		$header_type[$i]['WIDTH'] = 24;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Gen");
		$header_type[$i]['WIDTH'] = 24;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Hora Gen");
		$header_type[$i]['WIDTH'] = 20;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
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

$totalplan = 0; 
$regef = pg_fetch_array($res_pedido);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filasfound;$cont++) {
  
   $recibo     =trim($regef['nro_factura']);
   $cantidad   =trim($regef['cant_plan']);
   $planillai   =trim($regef['nplanilla1']);
   $planillaf   =trim($regef['nplanilla2']);
   $fechagen   =$regef['fecha_gen'];
   $horagen    =$regef['hora_gen'];
   $vusuario   =trim($regef['usuario']);

	$data = Array();
	$data[0]['TEXT'] = $recibo;
	$data[0]['T_ALIGN'] = "C";
	$data[1]['TEXT'] = $cantidad;
	$data[2]['TEXT'] = $planillai;
	$data[2]['T_ALIGN'] = "C";
	$data[3]['TEXT'] = $planillaf;
	$data[3]['T_ALIGN'] = "C";
	$data[4]['TEXT'] = $fechagen;
	$data[4]['T_ALIGN'] = "C";
	$data[5]['TEXT'] = $horagen;
	$data[5]['T_ALIGN'] = "C";
	$data[6]['TEXT'] = $vusuario;
   $totalplan = $totalplan + $cantidad; 
	$regef = pg_fetch_array($res_pedido);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();
$pdf->SetX(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,"Total Planillas Generadas: ".$totalplan,0,1);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
