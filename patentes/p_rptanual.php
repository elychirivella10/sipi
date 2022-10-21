<?php
// *************************************************************************************
// Programa: p_rptanual.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2009 II Semestre BD - Relacional 
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

//Variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Pantalla titulos
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Reporte de Anualidades');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Listado de Anualidades";

//Conexion
$sql = new mod_db();
$sql->connection($usuario);
  
//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];
$v2 = $_POST['v2'];
$nconex = $_POST['nconex'];

//Query para buscar las opciones deseadas 
$where="stpanual.nro_derecho=stzderec.nro_derecho AND stzderec.nro_derecho= stppatee.nro_derecho AND stzderec.tipo_mp='P'";
$titulo='';

if ($v2!="T") { $where = $where." AND "."stzderec.tipo_derecho='$v2'"; }
 
// Verificacion de que los campos requeridos esten llenos... 
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificacion del rango de fechas
$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }


if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." AND"." (stpanual.fecha_trans>='$fecsold' AND stpanual.fecha_trans <='$fecsolh')";
	   $titulo= $titulo." Desde:"." $fecsold"." Hasta:"." $fecsolh";
	}
	else { 
		$where = $where." (stpanual.fecha_trans >= '$fecsold' AND stpanual.fecha_trans <='$fecsolh')";
      $titulo= $titulo." Fecha Transaccion:".$fecsold." Hasta:".$fecsolh;
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." AND"." (stpanual.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stpanual.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

// Armando el query
 $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.registro,stzderec.tipo_derecho,
                    stzderec.estatus,stpanual.fecha_anual,stpanual.anualidad,stpanual.monto,stpanual.planilla,
                    stpanual.tasa,stpanual.fecha_trans,stpanual.usuario,stpanual.hora
 FROM stpanual, stppatee, stzderec
 WHERE $where 
 ORDER BY 11,1"); 
 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','p_rptpanual.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','p_rptpanual.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 11 columns
$pdf->Table_Init(9); 
$columns=9; 

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro ");
		$header_type[$i]['WIDTH'] = 17;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo ");
		$header_type[$i]['WIDTH'] = 10;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans.");
		$header_type[$i]['WIDTH'] = 18;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Anual.");
		$header_type[$i]['WIDTH'] = 19;
		$i=5; 
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Anual.");
		$header_type[$i]['WIDTH'] = 18;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Planilla");
		$header_type[$i]['WIDTH'] = 19;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tasa");
		$header_type[$i]['WIDTH'] = 19;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Monto");
		$header_type[$i]['WIDTH'] = 11;

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

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['registro'];
	$data[2]['TEXT'] = $registro['tipo_derecho'];
	$data[3]['TEXT'] = $registro['fecha_trans'];
	$data[4]['TEXT'] = $registro['anualidad'];
	$data[5]['TEXT'] = $registro['fecha_anual'];
	$data[6]['TEXT'] = $registro['planilla'];
	$data[7]['TEXT'] = $registro['tasa'];
	$data[8]['TEXT'] = $registro['monto'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
