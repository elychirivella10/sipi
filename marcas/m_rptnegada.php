<?php
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

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();

$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Listado de Marcas Negadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado de Marcas Negadas";

//Query para buscar las opciones deseadas
$evento='1225';
$estatus='1102';
$where='';
$titulo='Listado de Marcas Negadas, ';
$titulo= $titulo." Evento: 225 Estatus: 102";

// Armando el query

$resultado1=pg_exec("select solicitud,a.nro_derecho,nombre,estatus,fecha_solic,b.comentario
 into temp temporal from stzderec a, stzevtrd b
where a.nro_derecho=b.nro_derecho and evento=1225 and estatus=1102");

$resultado=pg_exec("SELECT a.solicitud,a.nombre,a.estatus,a.fecha_solic,b.clase,b.modalidad,a.comentario,
c.articulo,c.literal
 FROM  temporal a, stmmarce b, stmliaor c
WHERE a.nro_derecho = b.nro_derecho and
      a.nro_derecho = c.nro_derecho
order by c.articulo,c.literal,a.solicitud");


//$resultado=pg_exec("SELECT a.clase,a.modalidad,b.nro_derecho,b.solicitud,b.nombre,b.estatus, b.fecha_solic, c.evento, d.articulo, d.literal
//		FROM  stmmarce a, stzderec b, stzevtrd c, stmliaor d
//		WHERE $where 
//		AND b.tipo_mp='M' 
//		AND c.nro_derecho = a.nro_derecho
//		AND c.nro_derecho = b.nro_derecho
  //             	AND a.nro_derecho = d.nro_derecho
	//	ORDER BY  d.articulo, d.literal, b.solicitud");	
 
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
$total='Total de Solicitudes:'.$filas_resultado;

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(8);
$columns=11;
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
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 86;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mod.");
		$header_type[$i]['WIDTH'] = 9;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 13;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status");
		$header_type[$i]['WIDTH'] = 13;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 18;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Art.");
		$header_type[$i]['WIDTH'] = 13;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Lit.");
		$header_type[$i]['WIDTH'] = 10;

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
$tsize = 5;
$rr = 255;

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[2]['TEXT'] = $registro['modalidad'];
	$data[3]['TEXT'] = $registro['clase'];
	$data[4]['TEXT'] = ($registro['estatus']-1000);
	$data[5]['TEXT'] = $registro['fecha_solic'];
	$data[6]['TEXT'] = $registro['articulo'];
	$data[7]['TEXT'] = $registro['literal'];
	$registro = pg_fetch_array($resultado);
	
	$pdf->Draw_Data($data);

  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
