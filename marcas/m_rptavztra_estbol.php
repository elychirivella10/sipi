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
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);
 
//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado de Marcas en Estatus 555";

//Validacion de Entrada
$boletin=$_POST["boletin"];
$tipo=$_POST["tipo"];
$orde=$_POST["orde"];
$nconex = $_POST['nconex'];
$tip=$tipo;
$tipo=tipo_marcac($tipo);


// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("boletin","tipo","orde");
  $valores = array($boletin,$tipo,$orde);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Query para buscar las opciones deseadas
$where='';
$titulo='';

if(!empty($tipo)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.tipo_derecho = '$tipo')";
  	   $titulo= $titulo." Tipo:"." $tip";  
	}
	else { 
		$where = $where." (stzderec.tipo_derecho = '$tipo')";
 	   $titulo= $titulo." Tipo:"." $tip";
	}
}
if(!empty($boletin)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.documento = '$boletin')";
  	   $titulo= $titulo." Boletin:"."$boletin";
	}
	else { 
		$where = $where." (stzevtrd.documento = '$boletin')";
  	   $titulo= $titulo." Boletin:"."$boletin";
	}
}


// Armando el query

// Query original de Karina
//$resultado=pg_exec("SELECT stmmarce.solicitud,stmmarce.registro, stmmarce.nombre,stmmarce.tipo_marca, stmmarce.clase
//						FROM  stmmarce, stmevtrd 
//						WHERE stmmarce.estatus = '555' and
//						      stmmarce.tipo_marca = '$tipo' and
//						      stmevtrd.documento = '$boletin' and
//						      (stmevtrd.evento = '122' or stmevtrd.evento = '97')
//						AND stmmarce.registro !='' 
//						AND stmevtrd.solicitud = stmmarce.solicitud 
//						ORDER BY  stmmarce.$orde ");	

// Query modificado por Nelson
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.registro,stzderec.nombre,stzderec.tipo_derecho, stmmarce.clase
                      FROM  stmmarce, stzevtrd, stzderec
		     WHERE stzderec.tipo_derecho = '$tipo' and
			   stzevtrd.documento = '$boletin' and
			   ((evento = '1122' and estat_ant in (1101,1390)) or
                           (evento = '1097' and stzevtrd.nro_derecho not in (select nro_derecho from stzevtrd  where (evento='1180' and estat_ant < '1555') or  (evento='1122' and estat_ant in (1101,1390)))) or    (evento = '1180' and estat_ant < '1555'   and stzevtrd.nro_derecho not in (select nro_derecho from stzevtrd where evento='1122' and estat_ant in (1101,1390))))
                           AND stzderec.registro !='' and substr(stzderec.registro,1,1) in ('P','S','L','N')
			   AND stzevtrd.nro_derecho = stzderec.nro_derecho
			   AND stzderec.nro_derecho=stmmarce.nro_derecho 
            	           AND stzderec.tipo_mp= 'M'
		   ORDER BY  stzderec.$orde");	

 
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

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
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
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro ");
		$header_type[$i]['WIDTH'] = 20;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 20;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 135;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 11;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 11;
		
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
	$data[2]['TEXT'] = trim($registro['nombre']);
	$data[3]['TEXT'] = $registro['clase'];
	$data[4]['TEXT'] = $registro['tipo_derecho'];

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
