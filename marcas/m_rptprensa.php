<?php
// *************************************************************************************
// Programa: m_rptprensa.php 
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
$smarty->assign('subtitulo','Listado de Orden de Publicaci&oacute;n x Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$tipo=$_POST["tipo_id"];
$modal=$_POST["modal_id"];
$boletin=$_POST["boletin"];
$nconex = $_POST['nconex'];
$estatus=5;
$evento=22;

$vsold=sprintf("%04d-%06d",$vsol1,$vsol2);
$vsolh=sprintf("%04d-%06d",$vsol1h,$vsol2h);

$tipo =tipo_marcac($tipo);

if ($modal=='DENOMINATIVA') {$modal='D';}
if ($modal=='GRAFICA') {$modal='G';}
if ($modal=='MIXTA') {$modal='M';}

//Query para buscar las opciones deseadas
$where='estatus=1005 ';
$titulo='';
//$from='stmmarce';
if ($vsolh<$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$punt=0;
if ($vsold == '0000-000000') { $punt=1; }
if ($vsolh == '0000-000000') { $punt=1; }

if (($punt!=1) and (!empty($vsold) and !empty($vsolh))) { 

	if(!empty($where)) {
	   $where = $where." AND"." (stzderec.solicitud between '$vsold' AND '$vsolh')";
	   $titulo= $titulo." Desde Solictud:"." $vsold"." Hasta:"." $vsolh";
	}
	else { 
		$where = $where." (stzderec.solicitud between '$vsold' AND '$vsolh')"; 
      $titulo= $titulo." Desde Solicitud:"." $vsold"." Hasta:"." $vsolh";
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

if(!empty($modal)) { 
	if(!empty($where)) {
	   $where = $where." AND"." (stmmarce.modalidad = '$modal')";
  	   $titulo= $titulo." Tipo:"." $modal";  
	}
	else { 
		$where = $where." (stmmarce.modalidad = '$modal')";
 	   $titulo= $titulo." Tipo:"." $modal";
	}
}

// Armando el query
//echo " Wherew= $where boletin=$boletin";
//exit();

$resultado=pg_exec("SELECT DISTINCT ON(stzderec.solicitud) stzderec.solicitud, stzderec.fecha_solic, stzderec.nombre, stzderec.tipo_derecho, stmmarce.modalidad,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_mp,stzsolic.nombre as titular,stzottid.nacionalidad,stzottid.domicilio
						FROM  stmmarce, stzottid, stzsolic, stzderec
						WHERE $where 
						AND stmmarce.nro_derecho=stzderec.nro_derecho
						AND stmmarce.nro_derecho=stzottid.nro_derecho
						AND stzsolic.titular = stzottid.titular
                  AND stzderec.nro_derecho in (SELECT distinct nro_derecho FROM stzevtrd WHERE evento=1201 AND documento=$boletin)
						ORDER BY stzderec.solicitud ");	
	 
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
$encabezado= utf8_decode('Listado de Solicitudes con Publicacion en Prensa');
$titulo= 'Estatus: 5, Boletin: '.$boletin;

$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 20;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fec.Sol");
		$header_type[$i]['WIDTH'] = 17;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 65;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mod");
		$header_type[$i]['WIDTH'] = 9;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 13;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 12;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 65;

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
	$data[2]['TEXT'] = trim($registro['nombre']);
	$data[3]['TEXT'] = $registro['modalidad'];
	$data[4]['TEXT'] = $registro['clase']." ".$registro['ind_claseni']."  ";
	$data[5]['TEXT'] = $registro['tipo_derecho'];
	//$data[6]['TEXT'] = trim($registro['titular']);
	$data[6]['TEXT'] = $nbtitular;
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 
$pdf->Output();
?>