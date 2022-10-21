<?php
// *************************************************************************************
// Programa: m_lisdevreg1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado en Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");
ob_start();

include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}
//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listado de Devoluciones Notas Marginales de Registro a Publicar');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

  
//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$tipdev=$_POST["tramite"];
$usuario=$_POST["usuario"];
$nconex = $_POST['nconex'];

$titulo= '';
$where='';

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Query para buscar las opciones deseadas
//verifica si estan los campos vacios
$req_fields = array("fecsold","fecsolh");
$valores = array($fecsold,$fecsolh);
$vacios = check_empty_fields();
if (!$vacios) { 
  mensajenew("AVISO: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }
else {
  $titulo= $titulo." Fecha Trans:"."$fecsold"." al: "."$fecsolh"; }  

$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($usuario)) { 
     $where = $where."AND ( stzevtrd.usuario = '$usuario')";
	  $titulo= $titulo." Usuario:"."$usuario"; }

if(empty($tipdev) or $tipdev=='B') {
  $querytipo=''; }
else {
  $querytipo=" AND substr(stzevtrd.comentario,1,1) = '$tipdev' ";
}

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud, stzderec.nombre, stmmarce.clase, 
         stzderec.registro, stzsolic.nombre as titular, stzderec.agente, 
         trim(tramitante) as tramitante, stzottid.nacionalidad, stzottid.domicilio,
         stzevtrd.comentario,stzevtrd.documento
			FROM  stmmarce, stzottid, stzsolic, stzderec, stzevtrd		
			WHERE  stzevtrd.evento = '1502' $where
			AND stzevtrd.fecha_trans >='$fecsold' and stzevtrd.fecha_trans <='$fecsolh'
			AND stzevtrd.nro_derecho = stzderec.nro_derecho $querytipo
			AND stzevtrd.nro_derecho = stmmarce.nro_derecho 
			AND stmmarce.nro_derecho=stzottid.nro_derecho
			AND stzsolic.titular = stzottid.titular
        	ORDER BY stzderec.registro");	
	 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= utf8_decode('Listado de Devoluciones a Notas Marginales de Registro a Publicar ');
$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 12;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante");
		$header_type[$i]['WIDTH'] = 45;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 60;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Trámite");
		$header_type[$i]['WIDTH'] = 45;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nro. Control");
		$header_type[$i]['WIDTH'] = 20;
		

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

//Cargando los datos en la Tabla
 for($cont=0;$cont<$filas_resultado;$cont++) {
 	$pais_nombre = pais($registro['nacionalidad']);
   $nbtitular   = trim($registro['titular']).'.'.trim($registro['domicilio']).','.trim($pais_nombre); 
  
	$data = Array();
	$data[0]['TEXT'] = $registro['registro'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = utf8_decode(trim($registro['nombre']));
   $tram = agente_tram($registro['agente'],$registro['tramitante'],($ind='1'));
	$data[3]['TEXT'] = utf8_decode(trim($tram));
	//$data[4]['TEXT'] = utf8_decode(trim($registro['titular']));
	$data[4]['TEXT'] = utf8_decode($nbtitular);
	$data[5]['TEXT'] = utf8_decode(trim($registro['comentario']));
	$data[6]['TEXT'] = $registro['documento'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 
$pdf->Output();
?>
