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
$smarty->assign('subtitulo','Auditor&iacute;a de Planillas B&uacute;squedas Foneticas Cargadas');
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

if ($orden=='Pedido') { $orderby = "stmbusqueda.nro_pedido"; }
else { $orderby = "stmbusqueda.nro_recibo"; }

//Query para buscar las opciones deseadas
$where=""; 
$titulo='';
$from = ' stmbusqueda ';

if (empty($vsede)) { $vsede="0"; } 
//   $smarty->display('encabezado1.tpl');
//   mensajenew('Error: No escogio la Sede ...!!!','javascript:history.back();','N');    
//   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
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
    $where = $where." (stmbusqueda.f_pedido >='$desde' AND stmbusqueda.f_pedido <='$hasta')";
    $titulo= $titulo." Desde el: "."$desde"." Hasta: "."$hasta"; }
}

if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  else {
    $where = $where." AND (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  
}

if ($prioridad!='T') { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.tipobusq='$prioridad')";
     $titulo= $titulo." Prioridad: "."$prioridad";  }
}

if ($vplus=='I') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.envio='N')";
     $titulo= $titulo." Envio por: Impresora";  }
}

if ($vplus=='C') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.envio='S')";
     $titulo= $titulo." Envio por: Correo";  }
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.usuario='$usuario')";
     $titulo= $titulo." por el Usuario: "."$usuario";  }
}

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.nro_recibo='$recibo')";
     $titulo= $titulo." Factura No: "."$recibo";  }
}

if(!empty($planilla)) { 
  if(!empty($where)) {
     $from = ' stmbusqueda,stmbusplan ';
     $where = $where." AND"." stmbusqueda.nro_pedido=stmbusplan.nro_pedido AND (stmbusplan.cod_planilla='$planilla')";
     $titulo= $titulo." Planilla No: "."$planilla";  }
}

if(!empty($vsede)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.sede='$vsede')";
     $titulo= $titulo." de la Sede: "."$vsede";  }
}

if ($procesada=='S') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.f_proceso is not null) ";
  }
}

if ($procesada=='N') {
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.f_proceso is null) ";
  }
}

$where = $where." ORDER BY ".$orderby; 

$res_pedido=pg_exec("SELECT f_pedido,hora_c,stmbusqueda.nro_pedido,nro_recibo,solicitante,tipobusq,identificacion,indole,telefono,usuario,denominacion,clase,envio,sede,f_transac,email FROM $from WHERE $where");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  Mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptconfon.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Planillas: ".$filasfound; 
$encab_principal = "Sistema de Marcas";
$encabezado = "Busqueda Fonetica";
$titulo = "Auditoria de Planillas Foneticas Cargadas";
//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(14);
$columns=14;

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
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Factura ");
		$header_type[$i]['WIDTH'] = 17;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Planilla ");
		$header_type[$i]['WIDTH'] = 13;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Pedido");
		$header_type[$i]['WIDTH'] = 12;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante / Correo");
		$header_type[$i]['WIDTH'] = 62;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("I");
		$header_type[$i]['WIDTH'] = 5;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Denominación");
		$header_type[$i]['WIDTH'] = 62;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cl");
		$header_type[$i]['WIDTH'] = 6;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 18;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("P");
		$header_type[$i]['WIDTH'] = 5;
		$i=10;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("U");
		$header_type[$i]['WIDTH'] = 5;
		$i=11;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("E");
		$header_type[$i]['WIDTH'] = 5;
		$i=12;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F Carga");
		$header_type[$i]['WIDTH'] = 16;
		$i=13;
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
 $factura    =trim($regef['nro_recibo']);
 for($cont=0;$cont<$filasfound;$cont++) {

   $npedido    =trim($regef['nro_pedido']);
   $recibo     =trim($regef['nro_recibo']);
   $fecharec   =$regef['f_pedido'];
   $solicitante=trim($regef['solicitante']);
   $email      =trim($regef['email']);
   $tipoprio   =$regef['tipobusq'];
   $cedrif     =$regef['identificacion'];
   $tipindole  =$regef['indole'];
   $telf       =trim($regef['telefono']);
   $hora       =$regef['hora_c'];
   $vmarca     =trim($regef['denominacion']);
   $vclase     =$regef['clase'];
   $vusuario   =trim($regef['usuario']);
   $fcarga     =$regef['f_transac'];
   $ubicacion  =$regef['sede'];
   $envio      =$regef['envio'];
   
   if($cont==0) {
     if ($tipindole=="N") { $total_nat = $total_nat + 1; } 
     if ($tipindole=="P") { $total_jur = $total_jur + 1; } 
     if ($tipindole=="G") { $total_gob = $total_gob + 1; } 
     if ($tipindole=="O") { $total_com = $total_com + 1; } 
     if ($tipindole=="C") { $total_cop = $total_cop + 1; } 
   }
   if ($recibo!=$factura) { 
     if ($envio=="S") { $totcorreos=$totcorreos+1; } 
     //$totcorreos=$totcorreos+1; 
     $factura=trim($regef['nro_recibo']);

     if ($tipindole=="N") { $total_nat = $total_nat + 1; } 
     if ($tipindole=="P") { $total_jur = $total_jur + 1; } 
     if ($tipindole=="G") { $total_gob = $total_gob + 1; } 
     if ($tipindole=="O") { $total_com = $total_com + 1; } 
     if ($tipindole=="C") { $total_cop = $total_cop + 1; } 
     
   }
   
   if ($tipoprio=="A") { $tipo="H"; $total_hab = $total_hab + 1; } else { $tipo="N"; $total_nor = $total_nor + 1; } 
   if ($envio=="N") { $tipoenv="I"; $total_imp = $total_imp + 1; } else { $tipoenv="C"; $total_cor = $total_cor + 1; }
   
   $nplanilla = 0;
   $obj_query = $sql->query("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$npedido' AND tipo_busq='F'");
   $filas_found=$sql->nums('',$obj_query);
   if ($filas_found!=0) {
     $objs = $sql->objects('',$obj_query);
     $nplanilla=$objs->cod_planilla; } 

	$data = Array();
	$data[0]['TEXT'] = $recibo;
	$data[1]['TEXT'] = $fecharec;
   $data[1]['T_ALIGN'] = "C";
	$data[2]['TEXT'] = $nplanilla;
   $data[2]['T_ALIGN'] = "C";
	$data[3]['TEXT'] = $npedido;
   $data[3]['T_ALIGN'] = "C";
	$data[4]['TEXT'] = utf8_decode($solicitante." / ".$email);
	$data[5]['TEXT'] = $tipindole;	
   $data[5]['T_ALIGN'] = "C";
	$data[6]['TEXT'] = utf8_decode($vmarca);
	$data[7]['TEXT'] = $vclase;
	$data[8]['TEXT'] = $vusuario;
	$data[9]['TEXT'] = $tipo;
   $data[9]['T_ALIGN'] = "C";
	$data[10]['TEXT'] = $ubicacion;
   $data[10]['T_ALIGN'] = "C";
	$data[11]['TEXT'] = $tipoenv;	
   $data[11]['T_ALIGN'] = "C";
	$data[12]['TEXT'] = $fcarga;	
   $data[12]['T_ALIGN'] = "C";
	$data[13]['TEXT'] = $hora;	
   $data[13]['T_ALIGN'] = "C";
	$regef = pg_fetch_array($res_pedido);
	$pdf->Draw_Data($data);
  }

$pdf->SetX(10);
$pdf->Cell(0,8,"  Total Planillas Cargadas: ".$filasfound."                      Total Planillas Habilitadas: ".$total_hab."                     Total Planillas Normales: ".$total_nor."               Total Archivos por Impresora: ".$total_imp."               Total Archivos por Correo: ".$total_cor."       Total Correos enviados: ".$totcorreos,0,1);

$pdf->Draw_Table_Border();
$indole = "I= Indole: N-> Persona Natural,     P-> Persona Juridica,     G-> Sector Gobierno,     C-> Cooperativa,     O-> Comunal    - / -    P=Prioridad: H -> Habilitada,    N -> Normal    - / -    E=Envio: I -> Impresora,    C -> Correo ";
$pdf->Cell(0,8,$indole,0,1);
$pdf->Cell(0,8,"U=Sede: 1->SAPI,      2->El Chorro,      3->Sistema En Linea WEBPI,      4->San Cristobal,      5->Maracaibo.",0,1);
$pdf->Cell(0,8,"Total Natural: ".$total_nat."        Total Juridico: ".$total_jur."        Total Gobierno: ".$total_gob."        Total Cooperativa: ".$total_cop."        Total Comunal: ".$total_com,0,1);
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
