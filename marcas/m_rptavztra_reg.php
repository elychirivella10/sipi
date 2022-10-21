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

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones por Registro');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

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
$tipo=$_POST["tipo"];
$orden = $_POST["orden"];

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado";

$tipo=tipo_marcac($tipo);

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
	   $where = $where." and"." ((stzevtrd.fecha_trans >= '$desde') and (stzevtrd.fecha_trans <='$hasta'))";
	   $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stzevtrd.fecha_trans >= '$desde') and (stzevtrd.fecha_trans <='$hasta'))";
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
	   $where = $where." and"." ((stzevtrd.fecha_event >= '$desdet') and (stzevtrd.fecha_event <='$hastat'))";
	   $titulo= $titulo." Fec Evento:"."$desdet"." al: "."$hastat";
	}
	else { 
		$where = $where." ((stzevtrd.fecha_event >= '$desdet') and (stzevtrd.fecha_event <='$hastat'))";
      $titulo= $titulo." Fec Evento:"."$desdet"." al: "."$hastat";
	}
}
if(!empty($evento)) { 
	$evento1=$evento-1000;
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento:"."$evento1";
	}
	else { 
		$where = $where." (stzevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento:"."$evento1";
	}
}
if(!empty($tipo)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.tipo_derecho = '$tipo')";
  	   $titulo= $titulo." Tipo:"." $tipo";  
	}
	else { 
		$where = $where." (stzderec.tipo_derecho = '$tipo')";
 	   $titulo= $titulo." Tipo:"." $tipo";
	}
}
if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stzevtrd.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

$select = "SELECT ";
if (empty($orden)) { 
  $orderby = "stzderec.registro";
  if (!empty($evento)) { $select = "SELECT DISTINCT ON (stzderec.registro) "; }   
}
else {
 if ($orden=="fecha_event") { $orderby = "7,2"; }
 else { 
   if ($orden=="documento") { $orderby = "13"; }
   else { $select = "SELECT DISTINCT ON (stzderec.registro) "; $orderby = "stzderec.registro"; }
 }   
}

// Armando el query

$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.registro, stzderec.nombre,stmmarce.modalidad,stzevtrd.evento,stzevtrd.estat_ant, stzevtrd.fecha_event,stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento
			FROM  stmmarce, stzevtrd, stzderec 
			WHERE $where 
			AND stzderec.registro !='' 
			AND stzevtrd.nro_derecho = stzderec.nro_derecho
			AND stzderec.nro_derecho=stmmarce.nro_derecho 
		   AND stzderec.tipo_mp= 'M'
			ORDER BY $orderby ");	

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

//initialize the table 
$pdf->Table_Init(12);
$columns=12;
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
		$header_type[$i]['TEXT'] = utf8_decode("Registro ");
		$header_type[$i]['WIDTH'] = 16;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 20;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 50;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mod");
		$header_type[$i]['WIDTH'] = 8;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 11;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 13;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Previo");
		$header_type[$i]['WIDTH'] = 12;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Evt.");
		$header_type[$i]['WIDTH'] = 17;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc");
		$header_type[$i]['WIDTH'] = 17;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans");
		$header_type[$i]['WIDTH'] = 17;
		$i=10;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Actual");
		$header_type[$i]['WIDTH'] = 12;
		$i=11;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Doc.");
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

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['registro'];
	$data[1]['TEXT'] = $registro['solicitud'];
	$data[2]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[3]['TEXT'] = $registro['modalidad'];
	$data[4]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[5]['TEXT'] = $registro['evento']-1000;
	$data[6]['TEXT'] = $registro['estat_ant']-1000;
	$data[7]['TEXT'] = $registro['fecha_event'];
	$data[8]['TEXT'] = $registro['fecha_venc'];
	$data[9]['TEXT'] = $registro['fecha_trans'];
	$data[10]['TEXT'] = $registro['estatus']-1000;
	if (!empty($evento)) {
	  $data[11]['TEXT'] = $registro['documento']; }
        else {
	  $data[11]['TEXT'] = ''; }
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
