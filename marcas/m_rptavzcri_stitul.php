<?php
header('Content-type: application/pdf'); 

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
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Consulta Avanzada por Criterios');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado por Criterios";

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
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$fecpubd=$_POST["fecpubd"];
$fecpubh=$_POST["fecpubh"];
$fecvend=$_POST["fecvend"];
$fecvenh=$_POST["fecvenh"];
$estatus=$_POST["estatus"];
$tipo=$_POST["tipo"];
$clase=$_POST["clase"];
$pais=$_POST["pais"];
$nombre=$_POST["nombre"];
$titular=$_POST["titular"];
$agente=$_POST["agente"];
$tramitante=$_POST["tramitante"];
$nconex = $_POST['nconex'];

$vsold=sprintf("%04d-%06d",$vsol1,$vsol2);
$vsolh=sprintf("%04d-%06d",$vsol1h,$vsol2h);

$registrod= $registrod1.$registroh1;
$registroh= $registrod2.$registroh2;

$tipo=tipo_marcac($tipo);
//echo $estatus;
//Query para buscar las opciones deseadas
$where='';
$titulo='';
//$from='stzderec';
if ($vsolh <$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
if ($fecsolh <$fecsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas de solicitud erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
if ($fecpubh <$fecpubd){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas de publicacion erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
if ($fecvenh <$fecvend){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas de vencimiento erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$punt=0;
if ($vsold == '0000-000000') { $punt=1; }
if ($vsolh == '0000-000000') { $punt=1; }

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
}
if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
	   $titulo= $titulo." Fecha Sol.:"." $fecsold"." Hasta:"." $fecsolh";
	}
	else { 
		$where = $where." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
      $titulo= $titulo." Fecha Sol.:"." $fecsold"." Hasta:"." $fecsolh";
	}
}
if(!empty($fecpubd) and !empty($fecpubh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.fecha_publi >= '$fecpubd') and (stzderec.fecha_publi <='$fecpubh'))";
	   $titulo= $titulo." Fecha Pub.:"." $desde"." Hasta:"." $hasta";
	}
	else { 
		$where = $where." ((stzderec.fecha_publi >= '$fecpubd') and (stzderec.fecha_publi <='$fecpubh'))";
      $titulo= $titulo." Fecha Pub.:"." $desde"." Hasta:"." $hasta";
	}
}
if(!empty($fecvend) and !empty($fecvenh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.fecha_venc >= '$fecvend') and (stzderec.fecha_venc <='$fecvenh'))";
	   $titulo= $titulo." Fecha Venc.:"." $fecvend"." Hasta:"." $fecvenh";
	}
	else { 
		$where = $where." ((stzderec.fecha_venc >= '$fecvend') and (stzderec.fecha_venc <='$fecvenh'))";
      $titulo= $titulo." Fecha venc.:"." $fecvend"." Hasta:"." $fecvenh";
	}
}
if(!empty($estatus) and ($estatus!='0')) {
	$estatus1=$estatus-1000;
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"." $estatus1";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"." $estatus1";
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
if(!empty($clase)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stmmarce.clase = '$clase')";
  	   $titulo= $titulo." Clase:"." $clase";  
	}
	else { 
		$where = $where." (stmmarce.clase = '$clase')";
 	   $titulo= $titulo." Clase:"." $clase";
	}
}
if(!empty($pais)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.pais_resid = '$pais')";
  	   $titulo= $titulo." Pais:"." $pais";  
	}
	else { 
		$where = $where." (stzderec.pais_resid = '$pais')";
 	   $titulo= $titulo." Pais:"." $pais";
	}
}
if(!empty($nombre)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.nombre LIKE '%$nombre%')";
  	   $titulo= $titulo." Nombre:"." $nombre";  
	}
	else { 
		$where = $where." (stzderec.nombre LIKE '%$nombre%')";
 	   $titulo= $titulo." Nombre:"." $nombre";
	}
}
if(!empty($titular)) { 
	if(!empty($where)) {
      	   $from = $from.", stzottid, stzsolic";    
	   $where = $where." and"." (stzsolic.titular = '$titular'
				   AND stzottid.titular=stzsolic.titular
         		AND stzderec.nro_derecho=stzottid.nro_derecho )";
  	   $titulo= $titulo." Titular:"." $titular";  
	}
	else { 
      		$from = $from.", stzottid, stzsolic";    
		$where = $where." (stzsolic.titular = '$titular'
				   AND stzottid.titular=stzsolic.titular
         		AND stzderec.nro_derecho=stzottid.nro_derecho )";
		$titulo= $titulo." Titular:"." $titular";
	}
}
if(!empty($agente)) { 
	if(!empty($where)) { 
	   $where = $where." and"." (stzderec.agente = '$agente')";
  	   $titulo= $titulo." Agente:"." $agente";  
	}
	else {    
		$where = $where." (stzderec.agente = '$agente')";
 	   $titulo= $titulo." Agente:"." $agente";
	}
}
if(!empty($tramitante)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.tramitante like '%$tramitante%')";
  	   $titulo= $titulo." Tramitante:"." $tramitante";  
	}
	else { 
		$where = $where." (stzderec.tramitante like '%$tramitante%')";
 	   $titulo= $titulo." Tramitante:"." $tramitante";
	}
}

// Armando el query

$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.fecha_solic,stzderec.tipo_derecho,stzderec.nombre,stmmarce.clase, stmmarce.ind_claseni,	stzderec.estatus,stzderec.registro,stzderec.fecha_regis,stzderec.fecha_venc
						FROM  stzderec,stmmarce $from
						WHERE $where 
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp= 'M'
						ORDER BY stzderec.solicitud"); 
				 
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
$total="Total de Solicitudes: ".$filas_resultado;

$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 61;
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
		$header_type[$i]['TEXT'] = utf8_decode("Clase ");
		$header_type[$i]['WIDTH'] = 12;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus ");
		$header_type[$i]['WIDTH'] = 15;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro ");
		$header_type[$i]['WIDTH'] = 18;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Reg.");
		$header_type[$i]['WIDTH'] = 20;
		$i=8;
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

//Dibujando la Tabla 
 for($cont=0;$cont<$filas_resultado;$cont++) { 
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['tipo_derecho'];
	$data[4]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[5]['TEXT'] = $registro['estatus']-1000;
	$data[6]['TEXT'] = $registro['registro'];
	$data[7]['TEXT'] = $registro['fecha_regis'];
	$data[8]['TEXT'] = $registro['fecha_venc'];
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
