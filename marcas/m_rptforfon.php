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

//Variable de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = trim($_SESSION['usuario_login']);
//$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Decision de Forma/Fondo');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$desde=$_POST["desdec"];
$hasta=$_POST["hastac"];
$estatus=$_POST["estatus"];
$tipo_decision=$_POST['tipo_decision'];

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado";

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); exit(); }

if(!empty($desde) and !empty($hasta)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stmforfon.fecha_trans >= '$desde') and (stmforfon.fecha_trans <='$hasta'))";
	   $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stmforfon.fecha_trans >= '$desde') and (stmforfon.fecha_trans <='$hasta'))";
      $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
}

if(!empty($estatus) and ($estatus!='0')) {
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
           $estatus1=$estatus-1000;
  	   $titulo= $titulo." Estatus Actual:"."$estatus1";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
           $estatus1=$estatus-1000;
  	   $titulo= $titulo." Estatus Actual:"."$estatus1";
	}
}

 //echo "$tipo_decision";
 switch ($tipo_decision) {
     case "C":
       $estado = " stmforfon.estado = 'C' ";
       $subtitulo = " Evaluada como Concedida ";
       break;
     case "D":
       $estado = " stmforfon.estado = 'D' ";
       $subtitulo = " Evaluada como Detenida ";
       break;
     case "F":
       $estado = " stmforfon.estado is null ";
       $subtitulo = " Sin Decision Alguna Cargada";
       break;
     case "B":
       $estado = " stmforfon.estado = '' ";
       $subtitulo = " Sin Decision Alguna Cargada";
       break;
 }       

if(!empty($tipo_decision) and $tipo_decision<>'V') { 
	if(!empty($where)) {
	   $where = $where." and ".$estado;
  	   $titulo= $titulo." Tipo:"." $subtitulo ";  
	}
	else { 
	   $where = $where.$estado;
 	   $titulo= $titulo." Tipo:"." $subtitulo ";
	}
}

//Conexion 
$sql = new mod_db();
$sql->connection($login);

//  Armando el query
//  Borrado del query a peticion de nelson DISTINCT ON(stmmarce.solicitud)
//  Se condiciono el select y el order by porque cuando no se indica un evento
//  se trae todos los eventos de stmevtrd. 

//  Borrado del query por problema en los eventos cargados por sandra DISTINCT ON(stmmarce.solicitud) 25/07/2013
//if (empty($evento)) {$select = "SELECT DISTINCT ON (stzderec.solicitud) ";
//                     $orderby= "stzderec.solicitud"; }

$select = "SELECT ";
if (empty($orden)) { 
  $orderby = "stzderec.solicitud";
  $select = "SELECT DISTINCT ON (stzderec.solicitud) ";   
}

$qquery = "SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.nombre,stmmarce.modalidad,stmmarce.clase,stmmarce.ind_claseni,stzderec.estatus,stmforfon.evento,stmforfon.estado,stmforfon.fecha_trans 
FROM stzderec,stmforfon, stmmarce
WHERE $where
 AND  $estado
 AND stzderec.nro_derecho=stmforfon.nro_derecho
 AND stzderec.nro_derecho=stmmarce.nro_derecho
 AND stzderec.tipo_mp = 'M' 
ORDER BY estatus, stzderec.solicitud";
	
//echo "$qquery"; exit();
				
$resultado=pg_exec($qquery);	

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

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filas_resultado;

//Incio de la Clase de PDF para generar los reportes

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 99;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("M");
		$header_type[$i]['WIDTH'] = 5;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 11;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus Actual");
		$header_type[$i]['WIDTH'] = 16;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Decision Evento");
		$header_type[$i]['WIDTH'] = 14;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Decision");
		$header_type[$i]['WIDTH'] = 16;

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

//Dibujando la Tabla 
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[2]['TEXT'] = $registro['modalidad'];
	$data[3]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[4]['TEXT'] = $registro['estatus']-1000; 
	$data[5]['TEXT'] = $registro['evento']-1000;
	$data[6]['TEXT'] = $registro['fecha_trans'];
	$registro = pg_fetch_array($resultado);

	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
