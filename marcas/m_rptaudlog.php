<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

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
$smarty->assign('subtitulo','Reporte de Auditorias de Logotipos Modificados');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Auditoria de Logotipos Modificados";

//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=trim($_POST["usuario"]);

//Query para buscar las opciones deseadas
$where='';
$titulo='';

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","../index.php","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificacion del rango de fechas
$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','../index.php','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }


if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzaudimag.fecha_cambio >= '$fecsold') and (stzaudimag.fecha_cambio <='$fecsolh'))";
	   $titulo= $titulo." Desde:"." $fecsold"." Hasta:"." $fecsolh";
	}
	else { 
		$where = $where." ((stzaudimag.fecha_cambio >= '$fecsold') and (stzaudimag.fecha_cambio <='$fecsolh'))";
      $titulo= $titulo." Fecha Sol.:".$fecsold." Hasta:".$fecsolh;
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (trim(stzaudimag.usuario_cambio)='$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (trim(stzaudimag.usuario_cambio)='$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}
//and stmmarce.estatus=1
$where = $where." and stzderec.nro_derecho=stmmarce.nro_derecho";
$where = $where." and stzderec.nro_derecho=stzottid.nro_derecho";
$where = $where." and stmmarce.nro_derecho=stzottid.nro_derecho";
$where = $where." and stzsolic.titular = stzottid.titular";
$where = $where." and stzderec.solicitud=stzaudimag.solicitud";
$where = $where." and stzderec.tipo_mp='M' ";	

//Conexion a la base de datos  
$sql = new mod_db();
//$db_user=$login;
//$sql->connection($db_user);
$sql->connection($login);

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud, stzderec.fecha_solic,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,
stzderec.poder,stmmarce.modalidad,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad,stzaudimag.fecha_cambio,stzaudimag.hora_cambio,stzaudimag.usuario_cambio
 FROM  stmmarce, stzottid, stzsolic, stzderec, stzaudimag
 WHERE $where  ORDER BY 1"); 

//verificando los resultados  DISTINCT ON (stzderec.solicitud) 
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_rptpaudlog.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','m_rptpaudlog.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

//DISTINCT ON (stzderec.solicitud)
$cantidad=pg_exec("SELECT stzderec.solicitud,stzderec.fecha_solic,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stzderec.tipo_derecho,stzderec.tramitante,stzderec.agente,stzderec.poder,stmmarce.modalidad,stzsolic.nombre as ntitular,stzottid.domicilio,stzottid.nacionalidad,stzaudimag.fecha_cambio,stzaudimag.hora_cambio,stzaudimag.usuario_cambio
 FROM  stmmarce, stzottid, stzsolic, stzderec, stzaudimag
 WHERE $where "); 

$filas_res=pg_numrows($cantidad); 
$total='Total de Solicitudes Modificadas: '.$filas_res;

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ln(2);

//initialize the table with columns
$pdf->Table_Init(10);
$columns=10;

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
		$header_type[$i]['WIDTH'] = 63;
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
		$header_type[$i]['WIDTH'] = 42;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular/Solicitante ");
		$header_type[$i]['WIDTH'] = 63;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha/Hora Modificación ");
		$header_type[$i]['WIDTH'] = 21;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario ");
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
   $pais_nombre=pais($registro['nacionalidad']);
	$data[7]['TEXT'] = trim(utf8_decode($registro['ntitular'])).", Domicilio: ".trim(utf8_decode($registro['domicilio'])).utf8_decode(", País: ").$registro['nacionalidad']."-".utf8_decode($pais_nombre);
	$tiempo = $registro['fecha_cambio']." - ".$registro['hora_cambio'];
	$data[8]['TEXT'] = $tiempo;
	$data[9]['TEXT'] = trim(utf8_decode($registro['usuario_cambio']));	
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
