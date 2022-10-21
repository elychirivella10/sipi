<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

//Variebles de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Reporte de Solicitudes Presentadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Listado de Solicitudes Presentadas";

//Conexion
$sql = new mod_db();
$sql->connection();
  
//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];
$nconex = $_POST['nconex'];

//Query para buscar las opciones deseadas
$where='stzevtrd.evento=2200 ';
$titulo='Estatus 1 - ';

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificacion del rango de fechas
$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }


if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
	   $titulo= $titulo." Desde:". $fecsold." Hasta:".$fecsolh;
	}
	else { 
		$where = $where." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
	   $titulo= $titulo." Fecha Sol.:".$fecsold." Hasta:".$fecsolh;
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
//and stmmarce.estatus=1
$where = $where." and stzderec.nro_derecho=stppatee.nro_derecho";
$where = $where." and stzderec.nro_derecho=stzevtrd.nro_derecho";
$where = $where." and stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." and stppatee.nro_derecho=stzottid.nro_derecho";
$where = $where." and stzsolic.titular = stzottid.titular";
$where = $where." and stzderec.tipo_mp='P' ";	

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,stzderec.poder,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad,stzevtrd.fecha_trans,stzevtrd.hora,stzevtrd.usuario
 FROM  stppatee, stzevtrd, stzottid, stzsolic, stzderec
 WHERE $where 
 ORDER BY 1"); 

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','p_rptpsolpre.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','p_rptpsolpre.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
 
$cantidad=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.fecha_solic,stzderec.nombre,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,stzderec.poder,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad,stzevtrd.fecha_trans,stzevtrd.hora,stzevtrd.usuario
 FROM  stppatee, stzevtrd, stzottid, stzsolic, stzderec
 WHERE $where "); 
$filas_res=pg_numrows($cantidad);
$total='Total de Solicitudes: '.$filas_res;

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 62;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 18;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo ");
		$header_type[$i]['WIDTH'] = 9;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tramitante/Poder/Agente ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular ");
		$header_type[$i]['WIDTH'] = 65;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha/Hora Carga ");
		$header_type[$i]['WIDTH'] = 18;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario ");
		$header_type[$i]['WIDTH'] = 18;
		
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
	$data[1]['TEXT'] = utf8_decode(trim($registro['nombre']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['tipo_derecho'];
   $nagen  = $registro['agente'];
   $npoder = trim($registro['poder']);
	$tram   = agente_tramp($nagen,$registro['tramitante'],$npoder);
	if (empty($npoder)) { 
	  $data[4]['TEXT'] = trim(utf8_decode($tram)); $data[4]['T_SIZE'] = 6; }
	else {
	  $data[4]['TEXT'] = trim(utf8_decode("Poder: ".$npoder.", ".$tram)); $data[4]['T_SIZE'] = 6; }
	$pais_nombre=pais($registro['nacionalidad']);
	$data[5]['TEXT'] = utf8_decode(trim($registro['ntitular'])).", Domicilio: ".utf8_decode(trim($registro['domicilio'])).utf8_decode(", País: ").$registro['nacionalidad']."-".utf8_decode($pais_nombre);
	$tiempo = $registro['fecha_trans']." - ".$registro['hora'];
	$data[6]['TEXT'] = $tiempo;
	$data[7]['TEXT'] = trim(utf8_decode($registro['usuario']));	

	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
