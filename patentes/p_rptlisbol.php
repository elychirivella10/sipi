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
if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Listados para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$fecpub=$_POST["fecpub"];
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];
$nconex = $_POST['nconex'];

$varsold=trim(sprintf("%04d-%06d",$varsol1,$varsol2));
$varsolh=trim(sprintf("%04d-%06d",$varsol1h,$varsol2h));

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("varsold","varsolh","fecpub","boletin","tipo");
  $valores = array($varsold,$varsolh,$fecpub,$boletin,$tipo);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

if ($varsolh <$varsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
$titulo='';
$titul='';

// Armando el query segun las opciones

if ($tipo=='SOLICITADAS') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2006'
			AND c.tipo = 'P'
			AND b.estatus = '2006'
			ORDER BY b.solicitud");	
	$est_fin= '8';
	$tipo_plazo= 'H';
	$plazo='30';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."SOLICITADAS" ; 
	$titul=$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='CONCEDIDAS') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2101'
			AND c.tipo = 'P'
			AND b.estatus = '2101'
			ORDER BY b.solicitud");	   
	$est_fin= '400';
	$tipo_plazo= 'H';
	$plazo='30';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."CONCEDIDAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='DEVUELTAS FORMA') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2200'
			AND c.tipo = 'P'
			AND b.estatus = '2200'
			ORDER BY b.solicitud");	   
	$est_fin= '202';
	$tipo_plazo= 'H';
	$plazo='60';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."DEVUELTAS POR FORMA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='DEVUELTAS FONDO') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2103'
			AND c.tipo = 'P'
			AND b.estatus = '2103'
			ORDER BY b.solicitud");	 
	$est_fin= '118';
	$tipo_plazo= 'H';
	$plazo='60';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."DEVUELTAS POR FONDO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='PRIORIDAD EXTINGUIDA') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2025'
			AND c.tipo = 'P'
			AND b.estatus = '2025'
			ORDER BY b.solicitud");	   
	$est_fin= '600';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."PRIORIDAD EXTINGUIDA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}


if ($tipo=='PRIORIDAD EXT. PRENSA EXTEMP.') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2023'
			AND c.tipo = 'P'
			AND b.estatus = '2023'
			ORDER BY b.solicitud");	   
	$est_fin= '601';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."PRIORIDAD EXTINGUIDA PUBLICADA EN PRENSA EXTEMPORANEA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='PRIORIDAD EXT. PRENSA DEFECT.') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2024'
			AND c.tipo = 'P'
			AND b.estatus = '2024'
			ORDER BY b.solicitud");	   
	$est_fin= '602';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."PRIORIDAD EXTINGUIDA PUBLICADA EN PRENSA DEFECTUOSA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='PERIMIDAS X NO PUBLICACION PRENSA') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2030'
			AND c.tipo = 'P'
			AND b.estatus = '2030'
			ORDER BY b.solicitud");	   
	$est_fin= '651';
	$tipo_plazo= 'H';
	$plazo='0';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."PERIMIDAS X NO PUBLICACION EN PRENSA" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}


if ($tipo=='DESISTIDAS') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2910'
			AND c.tipo = 'P'
			AND b.estatus = '2910'
			ORDER BY b.solicitud");		   
	$est_fin= '911';
	$tipo_plazo= 'H';
	$plazo='';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."DESISTIDAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='DESISTIDAS X REGISTRO') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2915'
			AND c.tipo = 'P'
			AND b.estatus = '2915'
			ORDER BY b.solicitud");	
	$est_fin= '916';
	$tipo_plazo= 'H';
	$plazo='';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."DESISTIDAS X REGISTRO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='NEGADAS') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2102'
			AND c.tipo = 'P'
			AND b.estatus = '2102'
			ORDER BY b.solicitud");	  
	$est_fin= '500';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
   $titulo = $titulo."NEGADAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='DENEGADAS') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2119'
			AND c.tipo = 'P'
			AND b.estatus = '2119'
			ORDER BY b.solicitud");	   
	$est_fin= '502';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo);   
        $titulo = $titulo."DENEGADAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='ABANDONADAS') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2090'
			AND c.tipo = 'P'
			AND b.estatus = '2090'
			ORDER BY b.solicitud");	   
	$est_fin= '91';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
        $titulo = $titulo."ABANDONADAS" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='ABANDONADAS X NO PAGO') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2750'
			AND c.tipo = 'P'
			AND b.estatus = '2750'
			ORDER BY b.solicitud");	   
	$est_fin= '751';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
        $titulo = $titulo."ABANDONADAS X NO PAGO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}


if ($tipo=='OPOSICIONES') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2009'
			AND c.tipo = 'P'
			AND b.estatus = '2009'
			ORDER BY b.solicitud");	   
	$est_fin= '';
	$tipo_plazo= 'H';
	$plazo='';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
        $titulo = $titulo."OPOSICIONES" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2917'
			AND c.tipo = 'P'
			AND b.estatus = '2917'
			ORDER BY b.solicitud");	   
	$est_fin= '919';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
   $titulo = $titulo."SIN EFECTO POR FALTA DE PAGO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='SIN EFECTO POR VENCIMIENTO') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2918'
			AND c.tipo = 'P'
			AND b.estatus = '2918'
			ORDER BY b.solicitud");	   
	$est_fin= '920';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
   $titulo = $titulo."SIN EFECTO POR FALTA DE PAGO" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

if ($tipo=='SIN EFECTO POR FALTA DE PAGO DE CONCESION') { 
     $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.estatus,b.fecha_solic
			FROM  stzderec b, stztmpbo c
			WHERE (c.solicitud between '$varsold' and '$varsolh')
			AND c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND c.estatus = '2752'
			AND c.tipo = 'P'
			AND b.estatus = '2752'
			ORDER BY b.solicitud");	   
	$est_fin= '753';
	$tipo_plazo= 'H';
	$plazo='15';
	$fecha_venc = calculo_fechas($fecpub,$plazo,$tipo_plazo); 
   $titulo = $titulo."SIN EFECTO POR FALTA DE PAGO DE CONCESION" ;
	$titul =$titul." Entre la solicitud:"." $varsold"." y la:"." $varsolh";
}

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','p_rptplisbol.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','p_rptplisbol.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;
$filas_found=pg_numrows($resultado); 

$titul1= $boletin;

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= Utf8_decode("Listado para el Boletín");
$titulo= $titulo.' Boletin: '.$titul1;

//Incio de la Clase 
$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
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
		$header_type[$i]['WIDTH'] = 100;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Inicial");
		$header_type[$i]['WIDTH'] = 16;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Final");
		$header_type[$i]['WIDTH'] = 16;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc");
		$header_type[$i]['WIDTH'] = 20;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 55;
		
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
   $vder = $registro['nro_derecho'];
   //Agregado 05/05/2010 por RM por Orden del Ministro 
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad,stzottid.domicilio
       		FROM stzottid, stzsolic,stppatee 
       		WHERE stzottid.nro_derecho='$vder'
              AND stppatee.nro_derecho=stzottid.nro_derecho
              AND stzsolic.titular=stzottid.titular");
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
	//Arreglando el formato de la fecha	
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = utf8_decode(substr(trim($registro['nombre']),0,50));
	$data[3]['TEXT'] = $registro['estatus'];
	$data[4]['TEXT'] = $est_fin;
	$data[5]['TEXT'] = $fecha_venc;
	$data[6]['TEXT'] = $titular;

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
ob_end_clean(); 
$sql->disconnect();
$pdf->Output();
?>
