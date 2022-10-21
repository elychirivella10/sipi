<?php
// *************************************************************************************
// Programa: m_devconbol1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2009 II Semestre 
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
$smarty->assign('subtitulo','Listado de Marcas Devueltas Publicadas Con Escrito de Contestaci&oacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$boletin=$_POST["boletin"];
$nconex = $_POST['nconex'];
$estatus=1113;

if ($modal=='DENOMINATIVA') {$modal='D';}
if ($modal=='GRAFICA') {$modal='G';}
if ($modal=='MIXTA') {$modal='M';}

if (empty($boletin)) {
  Mensajenew('Error en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
$where='estatus=1113 ';
$titulo='Boletin '.$boletin;

// Armando el query

$resultado=pg_exec("SELECT DISTINCT ON(stzderec.solicitud) stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stmmarce.modalidad,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzsolic.nombre as titular 
                   FROM stzderec,stzevtrd,stmmarce,stzottid,stzsolic 
                   WHERE stzderec.nro_derecho = stzevtrd.nro_derecho
                   AND stmmarce.nro_derecho=stzderec.nro_derecho
                   AND stmmarce.nro_derecho=stzottid.nro_derecho
                   AND stzsolic.titular = stzottid.titular    
                   AND stzderec.tipo_mp='M'
                   AND stzderec.estatus=1113 
                   AND stzevtrd.evento IN (1156,1122) 
                   AND stzevtrd.documento=$boletin
                   AND stzderec.solicitud in 
                       (SELECT stzderec.solicitud from stzderec,stzevtrd 
                        WHERE stzderec.nro_derecho = stzevtrd.nro_derecho 
                        AND stzderec.tipo_mp='M'
                        AND stzderec.estatus=1113 
                        AND stzevtrd.evento=1020)
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

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= utf8_decode('Devueltas Publicadas Con Escrito de Contestacion');
$titulo= 'Estatus: 113, Boletin: '.$boletin;

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
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = utf8_decode(trim($registro['nombre']));
	$data[3]['TEXT'] = $registro['modalidad'];
	$data[4]['TEXT'] = $registro['clase']." ".$registro['ind_claseni']."  ";
	$data[5]['TEXT'] = $registro['tipo_derecho'];
	$data[6]['TEXT'] = utf8_decode(trim($registro['titular']));
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 
$pdf->Output();
?>
