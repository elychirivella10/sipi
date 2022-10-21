<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

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
$modulo= "m_rptagente.php";
$fecha = fechahoy();

$desde=$_POST["fechfon1"];
$hasta=$_POST["fechfon2"];
$vagen1=$_POST["vagen1"];
$vagen2=$_POST["vagen2"];
$usuario=$_POST["usuario"];

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
  $smarty->assign('titulo',$substmar);
  $smarty->assign('subtitulo','Hoja de Actas de Agentes Cargados');
  $smarty->assign('login',$login);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
  $smarty->display('pie_pag.tpl'); exit(); }

if(!empty($desde) and !empty($hasta)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzagenr.fecha_ingre >= '$desde') and (stzagenr.fecha_ingre <='$hasta'))";
	   $titulo= $titulo." Fecha Carga:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stzagenr.fecha_ingre >= '$desde') and (stzagenr.fecha_ingre <='$hasta'))";
      $titulo= $titulo." Fecha Carga:"."$desde"." al: "."$hasta";
	}
}

$punt=0;
if ($vsol1 == '000000') { $punt=1; }
if ($vsol2 == '000000') { $punt=1; }

if (($punt!=1) and (!empty($vagen1) and !empty($vagen1))) { 

	if(!empty($where)) {
	   $where = $where." and"." ((stzagenr.agente >= '$vagen1') and (stzagenr.agente <='$vagen2'))";
	   $titulo= $titulo." Desde Solictud:"." $vagen1"." Hasta:"." $vagen2";
	}
	else { 
         $where = $where." ((stzagenr.agente >= '$vagen1') and (stzagenr.agente <='$vagen2'))";
         $titulo= $titulo." Desde Solicitud:"." $vagen1"." Hasta:"." $vagen2";
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzagenr.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stzagenr.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

if (empty($where)) {
  $smarty->assign('titulo',$substmar);
  $smarty->assign('subtitulo','Hoja de Actas de Agentes Cargados');
  $smarty->assign('login',$login);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
			 
  Mensajenew("ERROR: No seleccion&oacute; ningun criterio para realizar la búsqueda de Informaci&oacute;n ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();
}  

//PDF Encabezados
$encab_principal= "Sistema de Marcas y Patentes";
$encabezado= utf8_decode("Auditoria de Agentes Cargados");

//Inicio del Pdf
header('Content-type: application/pdf'); 
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table 
$pdf->Table_Init(9);
$columns=9;
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
		$header_type[$i]['TEXT'] = utf8_decode("Codigo");
		$header_type[$i]['WIDTH'] = 13;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 55;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 45;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Prof");
		$header_type[$i]['WIDTH'] = 10;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Telefonos");
		$header_type[$i]['WIDTH'] = 30;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Inpre");
		$header_type[$i]['WIDTH'] = 14;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Colegio");
		$header_type[$i]['WIDTH'] = 18;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Correo");
		$header_type[$i]['WIDTH'] = 60;

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

$sql = new mod_db();
$sql->connection();

$resultado=pg_exec("SELECT * FROM stzagenr WHERE $where ORDER BY agente");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['agente'];
	$data[1]['TEXT'] = trim($registro['cedula']);
	$data[2]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro['domicilio']));
	$data[4]['TEXT'] = trim($registro['profesion']);
   $telefonos = trim($registro['telefono1'])." - ".trim($registro['telefono2']);
	$data[5]['TEXT'] = $telefonos;   
	$data[6]['TEXT'] = $registro['inpre'];
	$data[7]['TEXT'] = $registro['nro_colegiado'];
	$data[8]['TEXT'] = trim(utf8_decode($registro['email']));
	
	$registro = pg_fetch_array($resultado);
	
	$pdf->Draw_Data($data);

  }
  $pdf->ln(1);
  //$x = $pdf->Getx();
  //$y = $pdf->Gety();
  //$pdf->line($x,($y+1),203,($y+1));  
  $pdf->Cell(25,8,"Prof = Profesion: A=Abogado, E=Economista",0,1);

$pdf->Draw_Table_Border();

$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();

?>
