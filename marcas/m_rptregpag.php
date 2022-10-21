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

$login = trim($_SESSION['usuario_login']);
$role  = $_SESSION['usuario_rol'];
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
$recibo  = $_GET['vfac'];
$usuario = $_GET['vusr'];
//echo " $recibo, $usuario ";

//Query para buscar las opciones deseadas
$where="sede='1' "; 
$titulo='Sede: SAPI, ';
$from = ' stmbusqueda ';

$vsede="1";
//if (empty($vsede)) { $vsede="0"; } 
//   $smarty->display('encabezado1.tpl');
//   mensajenew('Error: No escogio la Sede ...!!!','javascript:history.back();','N');    
//   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.usuario='$usuario')";
     $titulo= $titulo." por Usuario: "."$usuario".",";  }
}

$lrif = substr($recibo,0,1);

if(!empty($recibo)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmbusqueda.nro_recibo='$recibo')";
     if ($lrif!='E') { 
       $titulo= $titulo." Factura No: "."$recibo";  }
     else  { 
       $titulo= $titulo." Exoneracion No: "."$recibo";  }
  }
}

//$where = $where." and (tipo='E')"." order by pedido,fecha,hora";
$where = $where." ORDER BY 1,3"; 

//echo "SELECT f_pedido,hora_c,stmbusqueda.nro_pedido,nro_recibo,solicitante,tipobusq,identificacion,indole,telefono,usuario,denominacion,clase,sede,f_transac FROM $from WHERE $where";
//exit();

$res_pedido=pg_exec("SELECT f_pedido,hora_c,stmbusqueda.nro_pedido,nro_recibo,solicitante,tipobusq,identificacion,indole,telefono,usuario,denominacion,clase,sede,f_transac FROM $from WHERE $where");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  mensajenew('AVISO: No existen Datos Asociados ...!!!','m_ingfacfon1.php?vopc=1','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Planillas: ".$filasfound; 
$encab_principal = "Sistema de Marcas";
$encabezado = "Busqueda Fonetica";
$titulo = "Auditoria de Planillas Foneticas Cargadas";
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
  		$header_type[$i]['TEXT'] = utf8_decode("Factura "); 
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("de Fecha ");
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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Denominación");
		$header_type[$i]['WIDTH'] = 50;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 11;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 16;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Prior");
		$header_type[$i]['WIDTH'] = 9;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Sede");
		$header_type[$i]['WIDTH'] = 10;
		$i=10;
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

$total_nor = 0;
$total_hab = 0; 
$regef = pg_fetch_array($res_pedido);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filasfound;$cont++) {
  
   $npedido    =trim($regef['nro_pedido']);
   $recibo     =trim($regef['nro_recibo']);
   $fecharec   =$regef['f_pedido'];
   $solicitante=trim($regef['solicitante']);
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

   if ($tipoprio=="A") { $tipo="Hab."; $total_hab = $total_hab + 1; } else { $tipo="Nor."; $total_nor = $total_nor + 1; } 

   $nplanilla = 0;
   $obj_query = $sql->query("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$npedido'");
   $filas_found=$sql->nums('',$obj_query);
   if ($filas_found!=0) {
     $objs = $sql->objects('',$obj_query);
     $nplanilla=$objs->cod_planilla; } 

	$data = Array();
	$data[0]['TEXT'] = $recibo;
	$data[1]['TEXT'] = $fecharec;
	$data[2]['TEXT'] = $nplanilla;
	$data[3]['TEXT'] = $npedido;
	$data[4]['TEXT'] = utf8_decode($solicitante);
	$data[5]['TEXT'] = utf8_decode($vmarca);
	$data[6]['TEXT'] = $vclase;
	$data[7]['TEXT'] = $vusuario;
	$data[8]['TEXT'] = $tipo;
	$data[9]['TEXT'] = $ubicacion;
	$data[10]['TEXT'] = $fcarga;	

	$regef = pg_fetch_array($res_pedido);
	$pdf->Draw_Data($data);
  }

$pdf->SetX(12);
$pdf->Cell(0,8,"Total Planillas Cargadas: ".$filasfound."                    Total Planillas Habilitadas Cargadas: ".$total_hab."                   Total Planillas Normales Cargadas: ".$total_nor,0,1);

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
