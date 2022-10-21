<?php
//Reporte de Listado de Boletin Orden de Publicacion
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy(); 

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= utf8_decode('Listado de Orden de Publicación');

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listado de Marcas de Orden de Publicación');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$boletin=$_POST["boletin"];

$varsold=($varsol1.'-'.$varsol2);
$varsolh=($varsol1h.'-'.$varsol2h);

//verifica si estan los campos vacios
  $req_fields = array("varsold","varsolh","boletin");
  $valores = array($varsold,$varsolh,$boletin);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

// Query 
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, a.clase,c.fecha_carga,c.hora_carga
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = $boletin
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1002'
			AND c.tipo = 'M'
			AND b.estatus = '1002'
			ORDER BY b.solicitud");	
 
//verificando los resultados
if (!$resultado)    { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

//Subtitulos de encabezados de reportes totales
$total= 'Total de Solicitudes: '.$filas_resultado;
$titulo= utf8_decode(' Boletín: ').$boletin;

$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 4 columns
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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre de las Marcas ");
		$header_type[$i]['WIDTH'] = 75;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante");
		$header_type[$i]['WIDTH'] = 78;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Generado el");
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

//Carga de datos en la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = trim($registro['nombre']);

    //busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       			FROM stzottid, stzsolic,stmmarce 
			WHERE stzottid.nro_derecho='$registro[nro_derecho]'
			AND stmmarce.nro_derecho=stzottid.nro_derecho
                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	//for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	//	if ($cont1=='0'){
	//      	    $titular= $titular.trim(sprintf($regt['nombre'])); }
	//      	else { $titular= $titular.", ".trim(sprintf($regt['nombre'])); }                
	//      	$regt = pg_fetch_array($res_titular);
	//} 
        for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	}
        //
	$data[3]['TEXT'] = $titular;
	$data[4]['TEXT'] = $registro['fecha_carga']." ".$registro['hora_carga'];

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
