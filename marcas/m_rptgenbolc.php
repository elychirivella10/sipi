<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");
require("$include_lib/jlpdf.php");
//Comienzo del Programa por los encabezados del reporte
ob_start();


if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n  de las Concedidas para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection();

//Validacion de Entrada
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];
$numero=$_POST["numero"];
$fechab=$_POST["fechab"];
$resolucion=$_POST["resolucion"];

$indrec=0;

if ($boletin=='' || $tipo=='') {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
// Armando el query segun las opciones
if ($tipo=='MARCA DE PRODUCTO') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 

	ORDER BY b.solicitud");	
	$titulo='MARCAS COMERCIALES CONCEDIDAS (PRODUCTOS)';		
} //	
if ($tipo=='NOMBRE COMERCIAL') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='N' 
	ORDER BY b.solicitud");	
	$titulo='MARCAS COMERCIALES CONCEDIDAS (NOMBRES)';
}
if ($tipo=='LEMA COMERCIAL') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='L' 
	ORDER BY b.solicitud");		
	$titulo='MARCAS COMERCIALES CONCEDIDAS (LEMAS)';
}
if ($tipo=='MARCA DE SERVICIO') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='S' 
	ORDER BY b.solicitud");	
	$titulo='MARCAS COMERCIALES CONCEDIDAS (SERVICIOS)';	
}
if ($tipo=='MARCA COLECTIVA') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='C' 
	ORDER BY b.solicitud");	
	$titulo='MARCAS COMERCIALES CONCEDIDAS (COLECTIVA)';	
}

if ($tipo=='DENOMINACION DE ORIGEN') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='D' 
	ORDER BY b.solicitud");	
	$titulo='MARCAS COMERCIALES CONCEDIDAS (DENOMINACION DE ORIGEN)';
}
if ($tipo=='RECLASIFICADAS MARCA DE PRODUCTO') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1390'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='M' 
	ORDER BY b.solicitud");	
	$titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS (PRODUCTOS)';
	$indrec=1;
}
if ($tipo=='RECLASIFICADAS NOMBRE COMERCIAL') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1390'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='N' 
	ORDER BY b.solicitud");	
	$titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS (NOMBRES)';
	$indrec=1;	
}
if ($tipo=='RECLASIFICADAS LEMA COMERCIAL') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1390'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='L' 
	ORDER BY b.solicitud");	
	$titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS (LEMAS)';
	$indrec=1;	
}
if ($tipo=='RECLASIFICADAS MARCA DE SERVICIO') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1390'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='S' 
	ORDER BY b.solicitud");	
	$titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS (SERVICIOS)';
	$indrec=1;	
}
if ($tipo=='RECLASIFICADAS MARCA COLECTIVA') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1390'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='C' 
	ORDER BY b.solicitud");	
	$titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS (COLECTIVA)';	
	$indrec=1;	
}

if ($tipo=='RECLASIFICADAS DENOMINACION DE ORIGEN') { 
        $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1390'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho='D' 
	ORDER BY b.solicitud");	
	$titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS (DENOMINACION DE ORIGEN)';
	$indrec=1;	
}

//verificando que consiguio los datos necesarios
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('No existe el Numero de Boletin ...!!!','m_rptpgenbolc.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos asociados para Generar ...!!!','m_rptpgenbolc.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$cantreg=$filas_resultado;
//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.$fechab,0,'J',0);     $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,utf8_decode($numero),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N· '.$resolucion),0,'J',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,$titulo,0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Cumplidos como han sido los extremos legales exigidos, este despacho acuerda el registro de las Marcas Comerciales (prodcutos) que a continuación se mencionan.'),0,'J',0);
      $pdf->ln(4); 

//si no son reclasificadas
if ($indrec==0){
$pdf->Table_Init(5);
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,0,102) ,
						'BRD_SIZE' => 0.4
					));

//set header style
$header_type = array(			0=>array(
				'WIDTH' => 18,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'SOLICITUD',
			   ),
			1=>array(
				'WIDTH' => 14,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'CLASE',
				),
			2=>array(
				'WIDTH' => 70,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'NOMBRE DE LAS MARCAS',
				),
			3=>array(
				'WIDTH' => 50,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'TITULAR',
				),
			4=>array(
				'WIDTH' => 40,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'TRAMITANTE',
				)
);
	  
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = array (
		0=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 3,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		1=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 3,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		2=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 3,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		3=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 3,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		4=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 3,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			)
);

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();
$tsize = 5;
$rr = 255;

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = utf8_decode($titular);	
	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 


	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}

//si son reclasificadas
if ($indrec==1){	
$pdf->Table_Init(6);
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,0,102) ,
						'BRD_SIZE' => 0.4
					));

//set header style
$header_type = array(			0=>array(
				'WIDTH' => 15,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'SOLICITUD',
			   ),
			1=>array(
				'WIDTH' => 15,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'CLASE(N)',
				),
			2=>array(
				'WIDTH' => 60,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'NOMBRE',
				),
			3=>array(
				'WIDTH' => 50,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'TITULAR',
				),
			4=>array(
				'WIDTH' => 40,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'TRAMITANTE',
				),
			5=>array(
				'WIDTH' => 15,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'CLASE(I)',
				)
);
	  
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = array (
		0=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		1=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		2=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		3=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		4=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		5=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			)
);

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();
$tsize = 6;
$rr = 255;
//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	

      $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = trim($registro['nombre']);
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	   
	$data[3]['TEXT'] = $titular;

	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
        
        $blanco='';
	$data[5]['TEXT'] = $blanco;
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
  
}

    // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$cantreg,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(20); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(25); 
       $pdf->MultiCell(190,5,utf8_decode('MARGARITA VILATIMÓ RIVERO'),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode('Registradora de la Propiedad Industrial'),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode('Resolución N·0178 de Fecha 14/06/06'),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode('Gaceta Oficial No.38.458 de Fecha 14/06/06'),0,'C',0);    
       
       
//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 

//Salida del Reporte
$pdf->Output();

?>
