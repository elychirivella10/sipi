<?php
// *************************************************************************************
// Programa: m_rptobscon.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado: II Semestre 2009 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listado de Solicitudes Observadas sin Contestar');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];
$nconex = $_POST['nconex'];

$vsold=trim(sprintf("%04d-%06d",$varsol1,$varsol2));
$vsolh=trim(sprintf("%04d-%06d",$varsol1h,$varsol2h));
$where='stzderec.estatus = 1120';
$from='stmmarce, stzottid, stzsolic, stzderec';
$titulo='';

$tipo=tipo_marcac($tipo);

if ($vsolh <$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$punt=0;
if ($vsold == '-') { $punt=1; }
if ($vsolh == '-') { $punt=1; }

if (($punt!=0) and (!empty($vsold) and !empty($vsolh))) { 
 
	if(!empty($where)) {
	   $where = $where." AND"."(stzderec.solicitud between '$vsold' AND '$vsolh')";
	   $titulo= $titulo." Desde Solictud:"." $vsold"." Hasta:"." $vsolh";
	}
	else { 
		$where = $where." (stzderec.solicitud between '$vsold' AND '$vsolh')";
      $titulo= $titulo." Desde Solicitud:"." $vsold"." Hasta:"." $vsolh";
	}
}

if(!empty($boletin)) { 
	if(!empty($where)) {
	   $from = $from.", stzevtrd";    
	   $where = $where." AND"." (stzevtrd.documento = '$boletin')"." AND (stzevtrd.nro_derecho = stzderec.nro_derecho) AND stzevtrd.evento=1122";
  	   $titulo= $titulo." Boletin:"."$boletin";
	}
	else { 
	   $from = $from.", stzevtrd"; 
	   $where = $where." (stzevtrd.documento = '$boletin')";
  	   $titulo= $titulo." Boletin:"."$boletin";
	}
}

if(!empty($tipo)) { 
	if(!empty($where)) {
	   $where = $where." AND"." (stzderec.tipo_derecho = '$tipo')";
  	   $titulo= $titulo." Tipo:"." $tipo";  
	}
	else { 
		$where = $where." (stzderec.tipo_derecho = '$tipo')";
 	   $titulo= $titulo." Tipo:"." $tipo";
	}
}

//Query para buscar las opciones deseadas
$resultado=pg_exec("SELECT DISTINCT ON(stzderec.solicitud) stzderec.nro_derecho, stzderec.solicitud, stzderec.fecha_solic, stzderec.nombre, stmmarce.modalidad,stmmarce.clase,stzderec.tipo_derecho,stzsolic.nombre as titular,stzottid.nacionalidad,stzottid.domicilio
		FROM $from
		WHERE $where 
		AND stzderec.nro_derecho=stmmarce.nro_derecho
		AND stzderec.nro_derecho=stzottid.nro_derecho
		AND stzsolic.titular = stzottid.titular
          AND stzderec.nro_derecho NOT IN (SELECT distinct nro_derecho FROM stzevtrd WHERE evento=1048)
		ORDER BY stzderec.solicitud ");	

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;
$filas_found=pg_numrows($resultado); 

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= utf8_decode('Listado de Observadas sin Contestar - Estatus 120');
$titulo= $titulo;

$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(6);
$columns=6;

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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 24;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 20;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 10;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 13;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 60;


	  
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
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = substr(trim($registro['nombre']),0,50);
	$data[3]['TEXT'] = $registro['clase'];
	$data[4]['TEXT'] = $registro['tipo_derecho'];
	//$data[5]['TEXT'] = trim(utf8_decode($registro['titular']));
	$data[5]['TEXT'] = $nbtitular;
	
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);

  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
ob_end_clean(); 
$sql->disconnect();
$pdf->Output();
?>
