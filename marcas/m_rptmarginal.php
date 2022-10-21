<?php
//header('Content-type: application/pdf'); 
// *************************************************************************************
// Programa: m_rptmarginal.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2009 I Semestre BD - Relacional 
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
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reporte de Anotaciones Marginales');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado de Anotaciones Marginales";

//Conexion
$sql = new mod_db();
$sql->connection($usuario);
  
//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];
$boletin=$_POST['boletin'];
$v2 = $_POST['v2'];
$nconex = $_POST['nconex'];

//Query para buscar las opciones deseadas 
$where="stzmargibol.verificado='S' and stzderec.nro_derecho= stzmargibol.nro_derecho and stzderec.nro_derecho= stmmarce.nro_derecho and stzderec.tipo_mp = 'M'";
$titulo='';

 $vtipo = "T";
 switch ($v2) {
   case 209:
     $vtipo = "N"; 
     break;
   case 208:
     $vtipo = "D"; 
     break;
   case 207:
     $vtipo = "L"; 
     break;
   case 206:
     $vtipo = "F"; 
     break;
   case 205:
     $vtipo = "C"; 
     break;
   case 204:
     $vtipo = "R"; 
     break;
 }       
  
if ($v2!=0) { $where = $where." AND "."stzmargibol.tipo_tramite='$vtipo'"; }

// Verificacion de que los campos requeridos esten llenos... 
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  
  if (!$vacios AND empty($usuario) AND empty($boletin)) { 
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
	   $where = $where." AND"." (stzmargibol.fecha_trans>='$fecsold' AND stzmargibol.fecha_trans <='$fecsolh')";
	   $titulo= $titulo." Desde:"." $fecsold"." Hasta:"." $fecsolh";
	}
	else { 
		$where = $where." (stzmargibol.fecha_trans >= '$fecsold' AND stzmargibol.fecha_trans <='$fecsolh')";
      $titulo= $titulo." Fecha Sol.:".$fecsold." Hasta:".$fecsolh;
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." AND"." (stzmargibol.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stzmargibol.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

if (!empty($boletin)) {
     $where = $where." AND stzmargibol.boletin = '$boletin'"; 
     $titulo= $titulo." Boletin: "."$boletin"; } 


//$where = $where." AND (stzmargibol.solicitud=stmmarce.solicitud)";

// Armando el query
$resultado=pg_exec("SELECT stzmargibol.nro_anotacion,stzmargibol.tipo_tramite,stzmargibol.fecha_trans,stzderec.registro,stzderec.solicitud,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,
                    stzderec.estatus,stzmargibol.nro_docum,stzmargibol.vencimiento,stzmargibol.tramitante,stzmargibol.agente,stzmargibol.codtit1,stzmargibol.titular1,stzmargibol.codtit2,
                    stzmargibol.titular2,stzmargibol.domicilio_ant,stzmargibol.domicilio,stzmargibol.pais,stzmargibol.publicado,stzmargibol.boletin,stzmargibol.documento,
                    stzderec.tipo_derecho,stzmargibol.usuario,stzmargibol.hora,stzmargibol.verificado
 FROM stzmargibol, stmmarce, stzderec
 WHERE $where 
 ORDER BY 1,3"); 
 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','m_rptpmarginal.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','m_rptpmarginal.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes:'.$filas_resultado;

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','legal');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 11 columns
$pdf->Table_Init(12); 
$columns=12;

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
		$header_type[$i]['TEXT'] = utf8_decode("Anotacion ");
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
		$header_type[$i]['TEXT'] = utf8_decode("Documento");
		$header_type[$i]['WIDTH'] = 19;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Vencim. Renovacion");
		$header_type[$i]['WIDTH'] = 18;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular Anterior");
		$header_type[$i]['WIDTH'] = 45;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular Nuevo ");
		$header_type[$i]['WIDTH'] = 45;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio Anterior");
		$header_type[$i]['WIDTH'] = 45;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio Nuevo");
		$header_type[$i]['WIDTH'] = 45;
		$i=10;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nac.");
		$header_type[$i]['WIDTH'] = 10;
		$i=11;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 45;

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
	$data[0]['TEXT'] = $registro['nro_anotacion'];
	$data[1]['TEXT'] = $registro['registro'];
	$data[2]['TEXT'] = $registro['tipo_tramite'];
	$data[3]['TEXT'] = $registro['fecha_trans']." / ".$registro['hora'];
	$data[4]['TEXT'] = $registro['nro_docum'];
	$data[5]['TEXT'] = $registro['vencimiento'];
	$data[6]['TEXT'] = utf8_decode(trim($registro['titular1']));
	$data[7]['TEXT'] = utf8_decode(trim($registro['titular2']));
	$data[8]['TEXT'] = utf8_decode(trim($registro['domicilio_ant']));
	$data[9]['TEXT'] = utf8_decode(trim($registro['domicilio']));
//	$data[9]['TEXT'] = trim($registro['ntitular']).", Domicilio: ".trim($registro['domicilio']).", Nacionalidad: ".$registro['nacionalidad'];
	$data[10]['TEXT'] = $registro['pais'];
	$data[11]['TEXT'] = utf8_decode(trim($registro['tramitante']));
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
