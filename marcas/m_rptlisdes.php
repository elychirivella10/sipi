<?php
// *************************************************************************************
// Programa: m_rptlisdes.php 
// Realizado por Ing. Karina Perez  
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado: II Semestre 2009
// Modificado: I Semestre 2010, Ing. Romulo Mendoza, por orden Ministerio  
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

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listado de Solicitudes Desistidas de Anotaciones Marginales');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];
$nconex = $_POST['nconex'];

//Conexion
$sql = new mod_db();
$sql->connection($login);

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("boletin","tipo");
  $valores = array($boletin,$tipo);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("AVISO: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Query para buscar las opciones deseadas

if ($tipo=='RENOVACIONES') { 
     $resultado=pg_exec("SELECT b.registro, b.nombre,b.nro_derecho,b.estatus,b.fecha_regis,a.clase
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1701'
			AND c.tipo = 'M'
			ORDER BY b.solicitud");	
	$titulo = $titulo."Listado de Solicitudes Desistidas de Renovaciones";
	$est_fin= '557';
	$tipo_plazo= 'N';
	$plazo='0';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
	$titul =$titul." Del Boletín: ".$boletin;
}

if ($tipo=='CESIONES') { 
     $resultado=pg_exec("SELECT b.registro, b.nombre,b.nro_derecho,b.estatus,b.fecha_regis,a.clase
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1702'
			AND c.tipo = 'M'
			ORDER BY b.solicitud");	
	$titulo = $titulo."Listado de Solicitudes Desistidas de Cesiones";
	$est_fin= '558';
	$tipo_plazo= 'N';
	$plazo='0';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
	$titul =$titul." Del Boletín: ".$boletin;
}

if ($tipo=='FUSION') { 
     $resultado=pg_exec("SELECT b.registro, b.nombre,b.nro_derecho,b.estatus,b.fecha_regis,a.clase
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1703'
			AND c.tipo = 'M'
			ORDER BY b.solicitud");	
	$titulo = $titulo."Listado de Solicitudes Desistidas de Fusiones";
	$est_fin= '559';
	$tipo_plazo= 'N';
	$plazo='0';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
	$titul =$titul." Del Boletín: ".$boletin;
}

if ($tipo=='LICENCIAS') { 
     $resultado=pg_exec("SELECT b.registro, b.nombre,b.nro_derecho,b.estatus,b.fecha_regis,a.clase
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1704'
			AND c.tipo = 'M'
			ORDER BY b.solicitud");	
	$titulo = $titulo."Listado de Solicitudes Desistidas de Licencias";
	$est_fin= '560';
	$tipo_plazo= 'N';
	$plazo='0';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
	$titul =$titul." Del Boletín: ".$boletin;
}

if ($tipo=='CAMBIO DE NOMBRE') { 
     $resultado=pg_exec("SELECT b.registro, b.nombre,b.nro_derecho,b.estatus,b.fecha_regis,a.clase
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1705'
			AND c.tipo = 'M'
			ORDER BY b.solicitud");	
	$titulo = $titulo."Listado de Solicitudes Desistidas de Cambio de Nombre";
	$est_fin= '561';
	$tipo_plazo= 'N';
	$plazo='0';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
	$titul =$titul." Del Boletín: ".$boletin;
}

if ($tipo=='CAMBIO DE DOMICILIO') { 
     $resultado=pg_exec("SELECT b.registro, b.nombre,b.nro_derecho,b.estatus,b.fecha_regis,a.clase
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1706'
			AND c.tipo = 'M'
			ORDER BY b.solicitud");	
	$titulo = $titulo."Listado de Solicitudes Desistidas de Cambio de Domicilio";
	$est_fin= '562';
	$tipo_plazo= 'N';
	$plazo='0';
	//$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
	$titul =$titul." Del Boletín: ".$boletin;
}

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;
$filas_found=pg_numrows($resultado); 

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= utf8_decode('Anotaciones Marginales');
$titulo= $titulo;

$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(5);
$columns=5;

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
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Reg.");
		$header_type[$i]['WIDTH'] = 20;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 8;
		//$i=4;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Status Incial");
		//$header_type[$i]['WIDTH'] = 15;
		//$i=5;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Status Final");
		//$header_type[$i]['WIDTH'] = 15;
		//$i=6;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc.");
		//$header_type[$i]['WIDTH'] = 15;
		$i=4;		$header_type[$i] = $table_default_header_type;		$header_type[$i]['TEXT'] = utf8_decode("Titular");		$header_type[$i]['WIDTH'] = 55;
	  
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
	//busqueda del titular y sus datos
   //Agregado 05/05/2010 por RM por Orden del Ministro 
	$titular='';
	$nderec = $registro['nro_derecho'];
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
       		      FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			          AND stmmarce.nro_derecho=stzottid.nro_derecho
                   AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	  $pais_nombre=pais($regt['nacionalidad']);
 	  if ($cont1=='0'){
	    $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	  else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
  	  $regt = pg_fetch_array($res_titular);
	} 
   
	$data = Array();
	$data[0]['TEXT'] = $registro['registro'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = utf8_decode(trim($registro['nombre']));
	$data[3]['TEXT'] = $registro['clase'];
	//$data[4]['TEXT'] = $registro['estatus']-1000;
	//$data[5]['TEXT'] = $est_fin;
	//$data[6]['TEXT'] = $fecha_venc;
	$data[4]['TEXT'] = utf8_decode($titular);
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
ob_end_clean(); 
$sql->disconnect();
$pdf->Output();
?>
