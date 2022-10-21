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

//control de sesiones
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = hoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Consulta de Memorias Digitalizadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Reporte de Memorias Digitalizadas";

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$registrod1=$_POST["vreg1d"];
$registroh1=$_POST["vreg2d"];
$registrod2=$_POST["vreg1h"];
$registroh2=$_POST["vreg2h"];
$estatus=$_POST["estatus"];
$tipo=$_POST["tipo"];

$vsold=($vsol1.'-'.$vsol2);
$vsolh=($vsol1h.'-'.$vsol2h);

$registrod= $registrod1.$registroh1;
$registroh= $registrod2.$registroh2;

$tipo=tipo_patentec($tipo);

//Query para buscar las opciones deseadas
$where='';
$titulo='';
$from='stzderec';
$orderby='stzderec.solicitud';

if ($vsolh <$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$punt=0;
if ($vsold == "-") { $punt=1; }
if ($vsolh == "-") { $punt=1; }

if (($punt!=1) and (!empty($vsold) and !empty($vsolh))) { 
        if(!empty($where)) {
	   $where = $where." and"." ((stzderec.solicitud >= '$vsold') and (stzderec.solicitud <='$vsolh'))";
	   $titulo= $titulo." Desde Solictud:"." $vsold"." Hasta:"." $vsolh";
	}
	else { 
		$where = $where." ((stzderec.solicitud >= '$vsold') and (stzderec.solicitud <='$vsolh'))";
      $titulo= $titulo." Desde Solicitud:"." $vsold"." Hasta:"." $vsolh";
	}
}

if(!empty($registrod) and !empty($registroh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.registro >= '$registrod') and (stzderec.registro <='$registroh'))";
 	   $titulo= $titulo." Desde Registro:"." $registrod"." Hasta:"." $registroh";
	}
	else { 
		$where = $where." ((stzderec.registro >= '$registrod') and (stzderec.registro <='$registroh'))";
 	   $titulo= $titulo." Desde Registro:"." $registrod"." Hasta:"." $registroh";
	}
        $orderby='stzderec.registro';
}
if(!empty($estatus) and ($estatus!='0')) {
	$est=$estatus-2000;
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"." $est";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"." $est";
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

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.tipo_derecho, stzderec.nombre, stzderec.estatus,stzderec.registro,stzderec.fecha_regis,stzderec.fecha_venc, stzderec.tramitante
		   FROM  stzderec, stppatee
			WHERE $where 
			AND stzderec.nro_derecho=stppatee.nro_derecho
			AND stzderec.tipo_mp='P'
			AND stzderec.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE stzevtrd.evento=2015)
			ORDER BY $orderby"); 
				 
//verificando los resultados
if (!$resultado)    { 
      mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total="Total de Solicitudes: ".$filas_resultado;

//Incio de la Clase de PDF para generar los reportes
//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
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
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 72;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 19;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo ");
		$header_type[$i]['WIDTH'] = 11;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus ");
		$header_type[$i]['WIDTH'] = 15;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro ");
		$header_type[$i]['WIDTH'] = 18;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Reg.");
		$header_type[$i]['WIDTH'] = 20;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc.");
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
	$data[1]['TEXT'] = utf8_decode(trim($registro['nombre']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['tipo_derecho'];
	$data[4]['TEXT'] = $registro['estatus']-2000;
	$data[5]['TEXT'] = $registro['registro'];
	$data[6]['TEXT'] = $registro['fecha_regis'];
	$data[7]['TEXT'] = $registro['fecha_venc'];
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
