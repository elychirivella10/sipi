<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_tablesep.php");
require("$include_lib/jlpdf.php");
//Comienzo del Programa por los encabezados del reporte

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n  de de Orden de Publicaci&oacute;n en Prensa para la Emisi&oacute;n del Bolet&iacute;n');
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
if ($tipo=='SOLICITADAS') { 
     $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stmmarce.clase, stzderec.nro_derecho
		FROM  stmmarce, stztmpbo, stzderec
		WHERE stztmpbo.boletin = '$boletin'
		AND stztmpbo.nro_derecho = stzderec.nro_derecho 
		AND stzderec.nro_derecho = stmmarce.nro_derecho 
		AND stzderec.estatus = '1002'
		AND stztmpbo.tipo = 'M'
		ORDER BY stzderec.solicitud");
		$titulo='ORDEN DE PUBLICACIÓN EN PRENSA';
} 	


//verificando que consiguio los datos necesarios
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('No existe el Numero de Boletin ...!!!','m_rptpgenbord.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos asociados para Generar ...!!!','m_rptpgenbord.php','N');
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
      $pdf->MultiCell(190,5,utf8_decode($titulo),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en el artículo 76 de la Ley de la Propiedad Industrial, se ordena la publicación de las marcas, que a continuación se especifican en los diarios de circulación nacional VEA o ULTIMAS NOTICIAS. De no consignarse ante la unidad de receptoria de este Servicio Autónomo de la Propiedad Intelectual y mediante escrito la mencionada publicación en prensa dentro de dos (2) meses a partir de la vigencia del presente Boletín, quedará perimida la solicitud, según lo establecido en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
      $pdf->ln(4); 


$pdf->Table_Init(4);
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
				'WIDTH' => 80,
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
				'TEXT' => 'NOMBRE ',
				),
			3=>array(
				'WIDTH' => 80,
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

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
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
