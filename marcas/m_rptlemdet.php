<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reporte de Lemas Detenidos con Marcas asociadas Concedidas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$vopc = $_GET['vopc'];

if ($vopc==2) {
 //PDF Encabezados
 $encab_principal= "Sistema de Marcas";
 $encabezado= "Reporte de Lemas Detenidos asociadas a Marcas Concedidas";

 //Query para buscar las opciones deseadas
 $where="stzderec.nro_derecho IN (SELECT stmlemad.nro_derecho FROM stmlemad,stzderec
                 WHERE stmlemad.nro_derecho=stzderec.nro_derecho
                   AND stzderec.estatus=1104 AND trim(solicitud_aso)!='' 
                   AND solicitud_aso IN (SELECT solicitud FROM stzderec WHERE tipo_mp='M' AND estatus = 1555))";
 $titulo='';

 $where = $where." and stzderec.nro_derecho=stmmarce.nro_derecho";
 $where = $where." and stzderec.nro_derecho=stzottid.nro_derecho";
 $where = $where." and stmmarce.nro_derecho=stzottid.nro_derecho";
 $where = $where." and stzsolic.titular = stzottid.titular";
 $where = $where." and stzderec.tipo_mp='M' ";	

//Conexion a la base de datos  
$sql = new mod_db();
$sql->connection($login);

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,stzderec.poder,stmmarce.modalidad,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad,stzottid.pais_domicilio
 FROM  stmmarce, stzottid, stzsolic, stzderec
 WHERE $where  ORDER BY 2"); 

//echo "SELECT stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,stzderec.poder,stmmarce.modalidad,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.pais_domicilio
// FROM  stmmarce, stzottid, stzsolic, stzderec
// WHERE $where  ORDER BY 1";
 
//verificando los resultados
if (!$resultado)    { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_rptlmdtmcon.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('ERROR: No existen Datos Asociados ...!!!','m_rptlmdtmcon.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

$cantidad=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.fecha_solic,stzderec.nombre,stzderec.tramitewebpi,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,stzderec.poder,stmmarce.modalidad,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad,stzottid.pais_domicilio
 FROM  stmmarce, stzottid, stzsolic, stzderec
 WHERE $where "); 

$filas_res=pg_numrows($cantidad); 
$total='Total de Solicitudes: '.$filas_res;

//echo " $total ";
//exit();


//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ln(2);

//initialize the table with columns
$pdf->Table_Init(8);
$columns=8;

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
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 70;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol");
		$header_type[$i]['WIDTH'] = 16;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cl ");
		$header_type[$i]['WIDTH'] = 7;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("T");
		$header_type[$i]['WIDTH'] = 5;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("M");
		$header_type[$i]['WIDTH'] = 5;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante/Poder/Agente ");
		$header_type[$i]['WIDTH'] = 60;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular/Solicitante ");
		$header_type[$i]['WIDTH'] = 80;

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
	$data[1]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['clase'].'- '.$registro['ind_claseni'];
	$data[4]['TEXT'] = $registro['tipo_derecho'];
	$data[5]['TEXT'] = $registro['modalidad'];
   $nagen  = $registro['agente'];
   $npoder = trim($registro['poder']);
	$tram   = agente_tramp($nagen,$registro['tramitante'],$npoder);
	if (empty($npoder)) { 
	  $data[6]['TEXT'] = trim(utf8_decode($tram)); $data[6]['T_SIZE'] = 6; }
	else {
	  $data[6]['TEXT'] = trim(utf8_decode("Poder: ".$npoder.", ".$tram)); $data[6]['T_SIZE'] = 6; }
	$solwebpi = trim($registro['tramitewebpi']);
	if($solwebpi=="S") { $pais_nombre=pais($registro['pais_domicilio']); $codpais=trim($registro['pais_domicilio']); }
	else { $pais_nombre=pais($registro['nacionalidad']); $codpais=trim($registro['nacionalidad']); }
	$data[7]['TEXT'] = trim(utf8_decode($registro['ntitular'])).", Domicilio: ".trim(utf8_decode($registro['domicilio'])).utf8_decode(", País: ").$codpais."-".utf8_decode($pais_nombre);
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

}

?>
