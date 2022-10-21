<?php
// *************************************************************************************
// Programa: z_rptconpet1.php 
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

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de B&uacute;squedas Peticionario WEBPI Cargadas');
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
$prioridad = $_POST['prioridad'];
$recibo  = trim($_POST['recibo']);
$planilla  = trim($_POST['planilla']);
$vplus  = trim($_POST['vplus']);
$orden = $_POST['orden'];
$procesada = $_POST['procesada'];

if ($orden=='Pedido') { $orderby = "stzbuspet.nro_pedido"; }
else { $orderby = "stzbuspet.nro_tramite"; }

//Query para buscar las opciones deseadas
$where=""; 
$titulo='';
$from = ' stzbuspet ';

if (empty($vsede)) { $vsede="0"; } 
 
if(empty($desde) AND empty($hasta) AND empty($desdec) AND empty($hastac)) {  
   $smarty->display('encabezado1.tpl');
   Mensajenew('ERROR: Debe colocar alguna Fecha ...!!!','javascript:history.back();','N');    
   ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if($vplus=='N') {  
   $smarty->display('encabezado1.tpl');
   Mensajenew('ERROR: Debe seleccionar el Modo de Env&iacute;o ...!!!','javascript:history.back();','N');    
   ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desde) && !empty($hasta)) {
  $esmayor=compara_fechas($desde,$hasta);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    Mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>    
    <?php
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
  if(empty($where)) {
    $where = $where." (stzbuspet.fecha_bus >='$desde' AND stzbuspet.fecha_bus <='$hasta')";
    $titulo= $titulo." Desde el: "."$desde"." Hasta: "."$hasta"; }
}

if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stzbuspet.fecha_carga>='$desdec' AND stzbuspet.fecha_carga<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  else {
    $where = $where." AND (stzbuspet.fecha_carga>='$desdec' AND stzbuspet.fecha_carga<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  
}

if ($prioridad!='T') { 
  if(!empty($where)) {
     $where = $where." AND"." (stzbuspet.tipobusq='$prioridad')";
     $titulo= $titulo." Prioridad: "."$prioridad";  }
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzbuspet.usuario='$usuario')";
     $titulo= $titulo." por el Usuario: "."$usuario";  }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stzbuspet.nro_tramite='$recibo')";
     $titulo= $titulo." Tramite No: "."$recibo";  }
}

//if(!empty($vsede)) { 
//  if(!empty($where)) {
//     $where = $where." AND"." (stzbuspet.sede='$vsede')";
//     $titulo= $titulo." de la Sede: "."$vsede";  }
//}

if ($procesada=='S') {
  if(!empty($where)) {
     $where = $where." AND"." (stzbuspet.fecha_proceso is not null) ";
  }
}

if ($procesada=='N') {
  if(!empty($where)) {
     $where = $where." AND"." (stzbuspet.fecha_proceso is null) ";
  }
}

$where = $where." ORDER BY ".$orderby; 

$res_pedido=pg_exec("SELECT * FROM $from WHERE $where");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  Mensajenew('AVISO: No existen Datos Asociados ...!!!','z_rptconpet.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Peticionarios: ".$filasfound; 
$encab_principal = "Sistema de Marcas/Patentes";
$encabezado = "Busqueda Peticionario WEBPI";
$titulo = "Auditoria de Peticionarios Solicitados";
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
		$header_type[$i]['TEXT'] = utf8_decode("Referencia");
		$header_type[$i]['WIDTH'] = 18;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Pedido");
		$header_type[$i]['WIDTH'] = 12;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario - Correo");
		$header_type[$i]['WIDTH'] = 80;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 10;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Peticionario o Titular a Buscar:");
		$header_type[$i]['WIDTH'] = 75;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F Carga");
		$header_type[$i]['WIDTH'] = 16;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("H Carga");
		$header_type[$i]['WIDTH'] = 17;
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

$total_nor = 0;
$total_hab = 0; 
$total_cor = 0;
$total_imp = 0;
$total_nat = 0;
$total_jur = 0;
$total_gob = 0;
$total_cop = 0; 
$total_com = 0; 
$regef = pg_fetch_array($res_pedido);

//$totcorreos=1;
$totcorreos=0;
if($vplus=="C") { $totcorreos=1; }
//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filasfound;$cont++) {

   $npedido    =trim($regef['nro_pedido']);
   $recibo     =trim($regef['nro_tramite']);
   $fecharec   =$regef['fecha_bus'];
   $solicitante=trim($regef['solicitante']);
   $tipobus    =$regef['tipo_busq'];
   $refbusq    =trim($regef['ref_busq']);
   $horac      =$regef['hora_carga'];
   $vmarca     =trim($regef['peticionario']);
   $vusuario   =trim($regef['usuario']);
   $fcarga     =$regef['fecha_carga'];
   
   $factura="T0".trim($regef['nro_tramite']);

	$data = Array();
	$data[0]['TEXT'] = $factura;
	$data[1]['TEXT'] = $fecharec;
   $data[1]['T_ALIGN'] = "C";
	$data[2]['TEXT'] = $refbusq;
   $data[2]['T_ALIGN'] = "C";
	$data[3]['TEXT'] = $npedido;
   $data[3]['T_ALIGN'] = "C";
	$data[4]['TEXT'] = utf8_decode($vusuario." / ".$solicitante);
	$data[5]['TEXT'] = $tipobus;	
   $data[5]['T_ALIGN'] = "C";
	$data[6]['TEXT'] = utf8_decode($vmarca);
	$data[7]['TEXT'] = $fcarga;	
   $data[7]['T_ALIGN'] = "C";
	$data[8]['TEXT'] = $horac;	
   $data[8]['T_ALIGN'] = "C";
	$regef = pg_fetch_array($res_pedido);
	$pdf->Draw_Data($data);
  }

$pdf->SetX(10);
$pdf->Cell(0,8,"  Total Peticionarios Cargados: ".$filasfound,0,1);

$pdf->Draw_Table_Border();
//$indole = "I= Indole: N-> Persona Natural,     P-> Persona Juridica,     G-> Sector Gobierno,     C-> Cooperativa,     O-> Comunal    - / -    P=Prioridad: H -> Habilitada,    N -> Normal    - / -    E=Envio: I -> Impresora,    C -> Correo ";
//$pdf->Cell(0,8,$indole,0,1);
//$pdf->Cell(0,8,"U=Sede: 1->SAPI,      2->El Chorro,      3->Sistema En Linea WEBPI,      4->San Cristobal,      5->Maracaibo.",0,1);
//$pdf->Cell(0,8,"Total Natural: ".$total_nat."        Total Juridico: ".$total_jur."        Total Gobierno: ".$total_gob."        Total Cooperativa: ".$total_cop."        Total Comunal: ".$total_com,0,1);
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
