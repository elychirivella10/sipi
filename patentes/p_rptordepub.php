<?php
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

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();
//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Listado de Orden de Publicación');
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

$varsold=trim(sprintf("%04d-%06d",$varsol1,$varsol2));
$varsolh=trim(sprintf("%04d-%06d",$varsol1h,$varsol2h));

$vtip=tipo_patentec($tipo);

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= utf8_decode('Listado de Orden de Publicación');

// Conexion
$sql = new mod_db();
$sql->connection();
  
// Armando el query
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2002'
			AND c.tipo = 'P'
			AND b.estatus = '2002'
			ORDER BY b.solicitud");	
 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','p_rptpordepub.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','p_rptpordepub.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$tipop=$tipo;
//Subtitulos de encabezados de reportes totales
$total= 'Total de Solicitudes: '.$filas_resultado;
$titulo= 'Tipo de Patentes: '. $tipop;

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 4 columns
$pdf->Table_Init(4);
$columns=4;
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
		$header_type[$i]['TEXT'] = utf8_decode("Titulo ");
		$header_type[$i]['WIDTH'] = 80;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante ");
		$header_type[$i]['WIDTH'] = 40;
		$i=3;
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

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
        $nderec=$registro['nro_derecho'];
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim($registro['nombre']);
        $ind=1;
        $tram = agente_tram($registro['agente'],$registro['tramitante'],$ind);
	$data[2]['TEXT'] = $tram;

    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
      $pais_nombre=pais($regt['nacionalidad']);
 		if ($cont1=='0'){
     	  $titular= $titular.trim(sprintf($regt['nombre'])).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim(sprintf($regt['nombre'])).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	   $regt = pg_fetch_array($res_titular);
	}	 

	$data[3]['TEXT'] = $titular;
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
