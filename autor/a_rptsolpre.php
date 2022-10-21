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

//Acceso
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezado de pantallas
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Reporte de Solicitudes Presentadas / Carga Inicial');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];
$nconex = $_POST['nconex'];
$tipo=$_POST["tipo"];

if ($tipo=='LITERARIAS') {$tipo='OL';}
if ($tipo=='ARTE VISUAL') {$tipo='AV';}
if ($tipo=='ESCENICAS') {$tipo='OE';}
if ($tipo=='MUSICALES') {$tipo='OM';}
if ($tipo=='AUDIOVISUALES Y RADIOFONICAS') {$tipo='AR';}
if ($tipo=='PROGRAMAS DE COMPUTACION Y BASE DE DATOS') {$tipo='PC';}
if ($tipo=='PRODUCIONES FONOGRAFICAS') {$tipo='PF';}
if ($tipo=='INTERPRETACIONES Y EJECUCIONES ARTISTICAS') {$tipo='IE';}
if ($tipo=='ACTOS Y CONTRATOS') {$tipo='AC';}

//PDF Encabezados
$encab_principal= "Sistema de Derecho de Autor";
$encabezado= "Listado de Solicitudes Presentadas / Carga Inicial";

//Query para buscar las opciones deseadas
$where='stdevtrd.evento=200 ';
$titulo='';

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
	   $where = $where." and"." ((stdobras.fecha_solic >= '$fecsold') and (stdobras.fecha_solic <='$fecsolh'))";
	   $titulo= $titulo." Desde:"." $fecsold"." Hasta:"." $fecsolh";
	}
	else { 
		$where = $where." ((stdobras.fecha_solic >= '$fecsold') and (stdobras.fecha_solic <='$fecsolh'))";
      $titulo= $titulo." Fecha Sol.:".$fecsold." Hasta:".$fecsolh;
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdevtrd.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
	   $where = $where." (stdevtrd.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

if(!empty($tipo)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.tipo_obra = '$tipo')";
  	   $titulo= $titulo." Tipo:"." $tipo";  
	}
	else { 
		$where = $where." (stdobras.tipo_obra = '$tipo')";
 	   $titulo= $titulo." Tipo:"." $tipo";
	}
}

$where = $where." and stdobras.nro_derecho=stdobsol.nro_derecho";
$where = $where." and stdobras.nro_derecho=stdevtrd.nro_derecho";

//$where = $where." and stztitur.titular=stmottid.titular";
//$where = $where." and stdobras.solicitud=stdevtrd.solicitud";
// Armando el query
$resultado=pg_exec("SELECT stdobras.nro_derecho, stdobras.solicitud,stdobras.fecha_solic,stdobras.titulo_obra,stdobras.tipo_obra,stdobras.estatus,stdevtrd.fecha_trans,stdevtrd.hora,stdevtrd.usuario 
 FROM  stdobras,stdevtrd, stdobsol
 WHERE $where ORDER BY 1"); 
 
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
$pdf= new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->ln(4);

//initialize the table with 6 columns
$pdf->Table_Init(8);
$columns=8;
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
		$header_type[$i]['WIDTH'] = 16;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titulo ");
		$header_type[$i]['WIDTH'] = 73;
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
		$header_type[$i]['TEXT'] = utf8_decode("Estatus Actual");
		$header_type[$i]['WIDTH'] = 15;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante ");
		$header_type[$i]['WIDTH'] = 92;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha/Hora Carga ");
		$header_type[$i]['WIDTH'] = 18;
		$i=7;
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

$total_ol = 0;
$total_om = 0;       
$total_ar = 0;       
$total_av = 0;       
$total_pc = 0;       
$total_oe = 0;       
$total_ac = 0;       
$total_ie = 0;       

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$solicita='';
	$nderec=$registro['nro_derecho'];
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro['titulo_obra']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[2]['T_ALIGN'] = "C";
	$data[3]['TEXT'] = $registro['tipo_obra'];
	$data[3]['T_ALIGN'] = "C";
	$data[4]['TEXT'] = $registro['estatus'];
	$data[4]['T_ALIGN'] = "C";
	//Busqueda de los datos del solicitante
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1   FROM stzsolic, stdobsol WHERE stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular  ");
	$regis = pg_fetch_array($resul_sol);
        $solicita= $solicita.'Nombre:'.$regis['nombre'].' Cedula:'.$regis['identificacion'].' Domicilio:'.trim($regis['domicilio']).' / '.trim($regis['telefono1']);
	$data[5]['TEXT'] = utf8_decode($solicita);
	$tiempo = $registro['fecha_trans']." - ".$registro['hora'];
	$data[6]['TEXT'] = $tiempo;
	$data[7]['TEXT'] = trim(utf8_decode($registro['usuario']));
	
   switch ($registro['tipo_obra']) {
     case "OL":
       $total_ol = $total_ol + 1;       
       break;
     case "OM":
       $total_om = $total_om + 1;       
       break;
     case "AR":
       $total_ar = $total_ar + 1;       
       break;
     case "AV":
       $total_av = $total_av + 1;       
       break;
     case "PC":
       $total_pc = $total_pc + 1;       
       break;
     case "OE":
       $total_oe = $total_oe + 1;       
       break;
     case "AC":
       $total_ac = $total_ac + 1;       
       break;
     case "IE":
       $total_ie = $total_ie + 1;       
       break;
   }       
   
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

$pdf->Draw_Table_Border();

$tipobr = "OL->Obra Literaria, OM->Obra Musical, AV->Arte Visual, OE->Obra Escenica, AR->Audiovisual y Radiofónica, PC->Programa de Computación y Base de Datos, PF->Producción Fonográfica, AC->Actos y Contratos, IE->Interpretaciones y Ejecuciones Artísticas";
$pdf->Setfont('Arial','B',6);
$pdf->Cell(0,8,utf8_decode($tipobr),0,1);
if(empty($tipo)) {
  $pdf->Setfont('Arial','B',8);
  $pdf->Cell(0,8,"Total OL: ".$total_ol."             Total OM: ".$total_om."             Total AR: ".$total_ar."             Total AV: ".$total_av."             Total PC: ".$total_pc."             Total OE: ".$total_oe."             Total AC: ".$total_ac."             Total IE: ".$total_ie,0,1);
}
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
