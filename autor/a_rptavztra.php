<?php
// Reporte de consulta avanzada por criterio DNDA
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

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de Pantallas
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Derecho de Autor";
$encabezado= "Listado de Transacciones";

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$desde=$_POST["desdec"];
$hasta=$_POST["hastac"];
$desdet=$_POST["desdet"];
$hastat=$_POST["hastat"];
$evento=$_POST["evento"];
$usuario=$_POST["usuario"];
$orden = $_POST["orden"];

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desde) and !empty($hasta)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stdevtrd.fecha_trans >= '$desde') and (stdevtrd.fecha_trans <='$hasta'))";
	   $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stdevtrd.fecha_trans >= '$desde') and (stdevtrd.fecha_trans <='$hasta'))";
      $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
}

$esmayor=compara_fechas($desdet,$hastat);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desdet) and !empty($hastat)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stdevtrd.fecha_event >= '$desdet') and (stdevtrd.fecha_event <='$hastat'))";
	   $titulo= $titulo." Fec Evento: "."$desdet"." al: "."$hastat";
	}
	else { 
		$where = $where." ((stdevtrd.fecha_event >= '$desdet') and (stdevtrd.fecha_event <='$hastat'))";
      $titulo= $titulo." Fec Evento: "."$desdet"." al: "."$hastat";
	}
}
if(!empty($evento)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento: "."$evento";
	}
	else { 
		$where = $where." (stdevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento: "."$evento";
	}
}
if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdevtrd.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario: "."$usuario";  
	}
	else { 
		$where = $where." (stdevtrd.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario: "."$usuario";
	}
}

//  Armando el query
//  Borrado del query a peticion de nelson DISTINCT ON(stdobras.solicitud)
//  Se condiciono el select y el order by porque cuando no se indica un evento
//  se trae todos los eventos de stdevtrd. 

//if (empty($evento)) {$select = "SELECT DISTINCT ON (stdobras.solicitud) ";
//                     $orderby= "stdobras.solicitud"; }
//else {$select = "SELECT ";
//      $orderby= "stdevtrd.documento, stdobras.solicitud"; }

$select = "SELECT ";
if ($orden=="solicitud") { 
  $orderby = "stdobras.solicitud";
  if (empty($evento)) { $select = "SELECT DISTINCT ON (stdobras.solicitud) "; }   
}
else {
  if ($orden=="fecha_event") { 
    $orderby = "6,1";
  }
  else {
    if ($orden=="fecha_trans") { 
      $orderby = "7,1"; 
    }
  }
}

$resultado=pg_exec($select."stdobras.solicitud, stdobras.titulo_obra,stdobras.tipo_obra,stdevtrd.evento,stdevtrd.estat_ant, stdevtrd.fecha_event,
stdevtrd.fecha_trans,stdobras.estatus
						FROM  stdobras, stdevtrd 
						WHERE $where 
						AND stdevtrd.nro_derecho = stdobras.nro_derecho 
						ORDER BY ".$orderby);	
 
//stmevtrd.evento,stmevtrd.fecha_event, stmmarce.solicitud,

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!','javascript:history.back();','N');
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
		$header_type[$i]['WIDTH'] = 16;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titulo");
		$header_type[$i]['WIDTH'] = 100;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 9;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 13;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Previo");
		$header_type[$i]['WIDTH'] = 12;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Evt.");
		$header_type[$i]['WIDTH'] = 18;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans");
		$header_type[$i]['WIDTH'] = 18;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Actual");
		$header_type[$i]['WIDTH'] = 13;
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
	$data[1]['TEXT'] = trim(utf8_decode($registro['titulo_obra']));
	$data[2]['TEXT'] = $registro['tipo_obra'];
	$data[3]['TEXT'] = $registro['evento'];
	$data[4]['TEXT'] = $registro['estat_ant'];
	$data[5]['TEXT'] = $registro['fecha_event'];
	$data[6]['TEXT'] = $registro['fecha_trans'];
	$data[7]['TEXT'] = $registro['estatus'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
