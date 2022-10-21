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
$smarty->assign('subtitulo','Auditor&iacute;a de Facturas B&uacute;squedas Foneticas Cargadas');
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
$recibo  = trim($_POST['recibo']);
$vplus  = trim($_POST['vplus']);
$tipobus = trim($_POST['tipobus']);
$fecharec  = $_POST["fecharec"];

//Query para buscar las opciones deseadas
$where=""; 
$titulo='';
$from = ' stmbusdia ';

if (empty($vsede)) { $vsede="0"; } 
 
if ((empty($desde) AND empty($hasta)) AND (empty($desdec) AND empty($hastac))) {  
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
    $where = $where." (stmbusdia.fecha_factura >='$desde' AND stmbusdia.fecha_factura <='$hasta')";
    $titulo= $titulo." Desde: "."$desde"." Hasta: "."$hasta"; }
}

if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stmbusdia.fecha_recibido>='$desdec' AND stmbusdia.fecha_recibido<='$hastac')";
    $titulo= $titulo." Recibido: "."$desdec"." Hasta: "."$hastac"; }
  else {
    $where = $where." AND (stmbusdia.fecha_recibido>='$desdec' AND stmbusdia.fecha_recibido<='$hastac')";
    $titulo= $titulo." Recibido: "."$desdec"." Hasta: "."$hastac"; }
  
}

if ($vplus=='I') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.envio_correo='N')";
     $titulo= $titulo." Envio x: Impresora";  }
}

if ($vplus=='C') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.envio_correo='S')";
     $titulo= $titulo." Envio x: Correo";  }
}

if ($tipobus=='F') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.tipo_busqueda='F')";
     $titulo= $titulo." Tipo: Fonetica";  }
}

if ($tipobus=='G') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.tipo_busqueda='G')";
     $titulo= $titulo." Tipo: Grafica";  }
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.usuario='$usuario')";
     $titulo= $titulo." Usuario: "."$usuario";  }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.nro_factura='$recibo')";
     $titulo= $titulo." Factura No: "."$recibo";  }
}

if(!empty($vsede)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusdia.sede='$vsede')";
     $titulo= $titulo." Sede: "."$vsede";  }
}

if(!empty($fecharec)) {
  $where = $where." AND (stmbusdia.fecha_carga='$fecharec')";
  $titulo= $titulo." Cargado: "."$fecharec"; }

$where = $where." ORDER BY nro_busdia"; 
//echo " $where "; exit();

$res_pedido=pg_exec("SELECT nro_busdia,nro_factura,fecha_factura,solicitante,cantidad_fon,cantidad_gra,fecha_recibido,hora_recibida,tipo_busqueda,envio_correo,usuario,sede FROM $from WHERE $where");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  Mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptbusdia.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Facturas: ".$filasfound; 
$encab_principal = "Sistema de Marcas";
$encabezado = "Busqueda Fonetica/Grafica";
$titulo = "Auditoria de Facturas Foneticas/Graficas Diarias x Informacion";
//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
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
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Recibido ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Hora Carga ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Factura ");
		$header_type[$i]['WIDTH'] = 15;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Factura ");
		$header_type[$i]['WIDTH'] = 17;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante");
		$header_type[$i]['WIDTH'] = 64;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 16;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 10;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Correo");
		$header_type[$i]['WIDTH'] = 12;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 18;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Sede");
		$header_type[$i]['WIDTH'] = 10;
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

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filasfound;$cont++) {
   $factura    =trim($regef['nro_factura']);  
   $fecharec   =$regef['fecha_factura'];
   $solicitante=trim($regef['solicitante']);
   $cantfon    =$regef['cantidad_fon'];
   $cantgra    =$regef['cantidad_gra'];
   $tipobusq   =$regef['tipo_busqueda'];
   $envio      =$regef['envio_correo'];
   $vusuario   =trim($regef['usuario']);
   $fcarga     =$regef['fecha_recibido'];
   $hora       =$regef['hora_recibida'];
   $ubicacion  =$regef['sede'];
   
   if ($envio=="N") { $tipoenv="I"; $total_imp = $total_imp + 1; } else { $tipoenv="C"; $total_cor = $total_cor + 1; }
   if ($cantfon!=0) { $cantidad=$cantfon; }
   if ($cantgra!=0) { $cantidad=$cantgra; }
       
	$data = Array();
	$data[0]['TEXT'] = $fcarga;
   $data[0]['T_ALIGN'] = "C";
	$data[1]['TEXT'] = $hora;
   $data[1]['T_ALIGN'] = "C";
	$data[2]['TEXT'] = $factura;
   $data[2]['T_ALIGN'] = "C";
	$data[3]['TEXT'] = $fecharec;
   $data[3]['T_ALIGN'] = "C";
	$data[4]['TEXT'] = utf8_decode($solicitante);
	$data[5]['TEXT'] = $cantidad;
   $data[5]['T_ALIGN'] = "C";
	$data[6]['TEXT'] = $tipobusq;
   $data[6]['T_ALIGN'] = "C";
	$data[7]['TEXT'] = $envio;	
   $data[7]['T_ALIGN'] = "C";
	$data[8]['TEXT'] = $vusuario;
   $data[8]['T_ALIGN'] = "C";
	$data[9]['TEXT'] = $ubicacion;
   $data[9]['T_ALIGN'] = "C";
	$regef = pg_fetch_array($res_pedido);
	$pdf->Draw_Data($data);
  }

$pdf->SetX(10);
$pdf->Cell(0,8,"  Total Facturas Cargadas: ".$filasfound."                      Total Facturas por Impresora: ".$total_imp."               Total Facturas por Correo: ".$total_cor,0,1);

$pdf->Draw_Table_Border();
$indole = "Correo: S -> SI,    N -> NO        /       Tipo: F -> Fonetica,    G -> Grafica";
$pdf->Cell(0,8,$indole,0,1);
$pdf->Cell(0,8,"Sede: 1->SAPI,      2->El Chorro,      3->Sistema En Linea WEBPI",0,1);
$pdf->Cell(0,8,"Exonerada-> Solicitante: ____________________________________________________________________ Cant:______ Fon/Gra:____ Ced/Rif: __________________________",0,1);
$pdf->Cell(0,8,"Exonerada-> Solicitante: ____________________________________________________________________ Cant:______ Fon/Gra:____ Ced/Rif: __________________________",0,1);
$pdf->Cell(0,8,"Exonerada-> Solicitante: ____________________________________________________________________ Cant:______ Fon/Gra:____ Ced/Rif: __________________________",0,1);
$pdf->Cell(0,8,"Exonerada-> Solicitante: ____________________________________________________________________ Cant:______ Fon/Gra:____ Ced/Rif: __________________________",0,1);
$pdf->Cell(0,8,"Exonerada-> Solicitante: ____________________________________________________________________ Cant:______ Fon/Gra:____ Ced/Rif: __________________________",0,1);
$pdf->Cell(0,8,"Exonerada-> Solicitante: ____________________________________________________________________ Cant:______ Fon/Gra:____ Ced/Rif: __________________________",0,1);

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
