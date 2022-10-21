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
$poder1=$_POST["poder1"];
$poder2=$_POST["poder2"];
$tramitante=$_POST["tramitante"];
$nconex = $_POST['nconex'];

$vsold=sprintf("%04d-%06d",$vsol1,$vsol2);
$vsolh=sprintf("%04d-%06d",$vsol1h,$vsol2h);

$registrod = $registrod1.$registroh1;
$registroh = $registrod2.$registroh2;
$tipomarca = $tipo; 

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
  	   $titulo= $titulo." Tipo:"." $tipo-$tipomarca ";  
	}
	else { 
		$where = $where." (stzderec.tipo_derecho = '$tipo')";
 	   $titulo= $titulo." Tipo:"." $tipo-$tipomarca ";
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
$punt1=0;
if ($poder1=='') { $punt1=1; }
if ($poder2=='0000-0000') { $punt1=1; }

if (($punt1!=1) and (!empty($poder1) and !empty($poder2))) { 
   $vpoder = $poder1."-".$poder2;
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.poder = '$vpoder')";
	   $titulo= $titulo." Poder:"." $vpoder";
	}
	else { 
		$where = $where." (stzderec.poder = '$vpoder')";
      $titulo= $titulo." Poder:"." $vpoder";
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
$resultado=pg_exec("SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.fecha_solic,stzderec.tipo_derecho,stzderec.nombre,stzderec.poder,stmmarce.clase,stmmarce.ind_claseni,tzderec.estatus,stzderec.registro,stzderec.fecha_regis,stzderec.fecha_venc,
stzevtrd.comentario,stmliaor.articulo,stmliaor.literal,stmliaor.reg_base
						FROM  stzderec,stmmarce,stzevtrd,stmliaor $from
						WHERE $where and evento='1225'
                                                AND stzderec.nro_derecho=stmliaor.nro_derecho  
                                                AND stzderec.nro_derecho=stzevtrd.nro_derecho  
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp= 'M'
						ORDER BY stmliaor.articulo,stmliaor.literal,stzderec.solicitud"); 
				 
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Art");
		$header_type[$i]['WIDTH'] = 8;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Lit");
		$header_type[$i]['WIDTH'] = 8;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 18;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre");
		$header_type[$i]['WIDTH'] = 64;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 58;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cl");
		$header_type[$i]['WIDTH'] = 7;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 15;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Comentario");
		$header_type[$i]['WIDTH'] = 70;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Poder Nro.");
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

//Dibujando la Tabla 
 for($cont=0;$cont<$filas_resultado;$cont++) { 
  	$nderec=$registro['nro_derecho'];
 	//busqueda del titular
	$result = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce 
       WHERE stzottid.nro_derecho='$nderec'
       AND stmmarce.nro_derecho=stzottid.nro_derecho
       AND stzsolic.titular = stzottid.titular");
       $res = pg_fetch_array($result);
       $filas_found_tit=pg_numrows($result);

	for ($j=0; $j<$filas_found_tit; $j++)
	{
	 $titular = $titular.trim(utf8_decode($res['nombre']));
	 $res = pg_fetch_array($result);
	}
	
	$data = Array();
	$data[0]['TEXT'] = trim($registro['articulo']);
	$data[1]['TEXT'] = trim($registro['literal']);
	$data[2]['TEXT'] = $registro['solicitud'];
	$data[3]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[4]['TEXT'] = trim($titular);
	$data[5]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[6]['TEXT'] = $registro['reg_base'];
	$data[7]['TEXT'] = trim(utf8_decode($registro['comentario']));
	$data[8]['TEXT'] = $registro['poder'];
	$titular='';
	
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
