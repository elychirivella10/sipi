<?php
// *************************************************************************************
// Programa: m_rptctrlcer1.php 
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
$role  = $_SESSION['usuario_rol'];
$fecha = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de Control de Certificados de Marcas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();
$tbname_1 = "stmceraut";

//Validacion de Entrada
$desdec = $_POST["desdec"]; 
$hastac = $_POST["hastac"];
$usuario= trim($_POST["usuario"]);
$vsede  = trim($_POST['options']);
$prioridad = $_POST['prioridad'];
$control  = trim($_POST['control']);

//Query para buscar las opciones deseadas
$where=" stmcertif.control=stmregcer.control AND stmregcer.nro_derecho=stzderec.nro_derecho AND stzderec.nro_derecho=stmmarce.nro_derecho ";
$titulo='';
$from = ' stmcertif,stmregcer,stzderec,stmmarce ';

if (empty($vsede)) { $vsede="0"; } 
//   $smarty->display('encabezado1.tpl');
//   mensajenew('Error: No escogio la Sede ...!!!','javascript:history.back();','N');    
//   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
if(empty($desdec) || empty($hastac)) {  
   $smarty->display('encabezado1.tpl');
   mensajenew('Error: Alguna Fecha Vacia ...!!!','javascript:history.back();','N');    
   ?>
      <br><br><br><br><br><br><br><br><br><br><br><br>
   <?php
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    $smarty->display('encabezado1.tpl');
    mensajenew('Error: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stmcertif.fecha_trans>='$desdec' AND stmcertif.fecha_trans<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  else {
    $where = $where." AND (stmcertif.fecha_trans>='$desdec' AND stmcertif.fecha_trans<='$hastac')";
    $titulo= $titulo." Cargado el: "."$desdec"." Hasta: "."$hastac"; }
  
}

if ($prioridad!='T') { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcertif.accion='$prioridad')";
     $titulo= $titulo." Accion: "."$prioridad";  }
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcertif.usuario='$usuario')";
     $titulo= $titulo." por el Usuario: "."$usuario";  }
}

if(!empty($control)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcertif.control='$control')";
     $titulo= $titulo." Control No: "."$control";  }
}

if(!empty($vsede)) { 
  if(!empty($where)) {
     $where = $where." AND"." (stmcertif.sede='$vsede')";
     $titulo= $titulo." de la Sede: "."$vsede";  }
}

//$where = $where." and (tipo='E')"." order by pedido,fecha,hora";
$where = $where." ORDER BY 1,8"; 

//echo "SELECT f_pedido,hora_c,stmbusqueda.nro_pedido,nro_recibo,solicitante,tipobusq,identificacion,indole,telefono,usuario,denominacion,clase,sede,f_transac FROM $from WHERE $where";
//exit();

//select a.control,a.accion,a.fecha_pedido,a.solicitante,a.ci_solicitante,a.autorizado,a.ci_autorizado,c.registro,c.nombre,d.clase from stmcertif a,stmregcer b,stzderec c,stmmarce d
//where a.control=b.control
//  and b.nro_derecho=c.nro_derecho
//  and c.nro_derecho=d.nro_derecho
//order by 1,8

$res_pedido=pg_exec("SELECT stmcertif.control,stmcertif.accion,stmcertif.fecha_pedido,stmcertif.solicitante,stmcertif.ci_solicitante,stmcertif.usuario,stmcertif.fecha_trans,stzderec.registro,stzderec.nombre,stmmarce.clase FROM $from WHERE $where");
$filasfound=pg_numrows($res_pedido);

if ($filasfound==0)  {
  $smarty->display('encabezado1.tpl');
  mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptctrlcer.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$total=$titulo.". Total de Certificados: ".$filasfound; 
$encab_principal = "Sistema de Marcas";
$encabezado = "Control de Certificados";
$titulo = "Auditoria de Registros para Firmar/Corregir";
//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
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
		$header_type[$i]['TEXT'] = utf8_decode("Control ");
		$header_type[$i]['WIDTH'] = 13;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Accion");
		$header_type[$i]['WIDTH'] = 13;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Pedido ");
		$header_type[$i]['WIDTH'] = 16;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante");
		$header_type[$i]['WIDTH'] = 43;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula Solicita");
		$header_type[$i]['WIDTH'] = 17;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Autorizado(s)");
		$header_type[$i]['WIDTH'] = 60;
		//$i=6;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Cedula Autoriza");
		//$header_type[$i]['WIDTH'] = 17;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 14;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Marca");
		$header_type[$i]['WIDTH'] = 44;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cl");
		$header_type[$i]['WIDTH'] = 6;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 16;
		$i=10;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("F. Carga ");
		$header_type[$i]['WIDTH'] = 15;

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
  
   $ncontrol   =$regef['control'];
   $accion     =$regef['accion'];
   $fechasol   =$regef['fecha_pedido'];
   $solicitante=trim($regef['solicitante']);
   $cisolicita =$regef['ci_solicitante'];
   $autorizado =trim($regef['autorizado']);
   $ciautorizado=$regef['ci_autorizado'];
   $registro   =trim($regef['registro']);
   $vmarca     =trim($regef['nombre']);
   $vclase     =$regef['clase'];
   //$ubicacion  =$regef['sede'];
   $vusuario   =trim($regef['usuario']);
   $fechacarga =$regef['fecha_trans'];

   if ($accion=="F") { $tipo="Firmar"; } else { $tipo="Corregir"; }
   
   $autorizado="";
   // Tabla de Autorizados
   $obj_query = $sql->query("SELECT * FROM $tbname_1 where control='$ncontrol'");
   $filas_res_aut=$sql->nums('',$obj_query);
   $objreg = $sql->objects('',$obj_query);
   for($i=0;$i<$filas_res_aut;$i++) {
     $cdaut = $objreg->ci_autorizado;
     $nbaut = trim($objreg->autorizado);
     $nbaut = str_replace("'","Ž",$nbaut);
     if (empty($autorizado)) { $autorizado = $nbaut." CI.: ".$cdaut; }
     else { $autorizado = $autorizado.", ".$nbaut." CI.: ".$cdaut; }
     $objreg = $sql->objects('',$obj_query);
   } 

   $data = Array();
   $data[0]['TEXT'] = $ncontrol;
   $data[1]['TEXT'] = $tipo;
   $data[2]['TEXT'] = $fechasol;
   $data[3]['TEXT'] = utf8_decode($solicitante);
   $data[4]['TEXT'] = $cisolicita;
   $data[5]['TEXT'] = utf8_decode($autorizado);
   //$data[6]['TEXT'] = $ciautorizado;$vclase;
   $data[6]['TEXT'] = $registro;
   $data[7]['TEXT'] = utf8_decode($vmarca);
   $data[8]['TEXT'] = $vclase;
   $data[9]['TEXT'] = $vusuario;	
   $data[10]['TEXT'] = $fechacarga;

   $regef = pg_fetch_array($res_pedido);
   $pdf->Draw_Data($data);
  }

$pdf->SetX(12);
$pdf->Cell(0,8,"Total Certificados a procesar: ".$filasfound,0,1);

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
