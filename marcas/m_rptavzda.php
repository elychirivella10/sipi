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
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Consulta Avanzada por Solicitud con Titular');
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
$estatus=$_POST["estatus"];
$boletin=$_POST["boletin"];
$indole=$_POST["indole"];
$tipo_marca=$_POST['tipo_marca'];

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado ";

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

if(!empty($estatus) and ($estatus!='0')) {
        $estatus1=$estatus-1000;
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"."$estatus1";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"."$estatus1";
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

 $vtiposoli="";
 switch ($indole) {
     case "N":
       $vtiposoli = "PERSONA NATURAL";
       break;
     case "P":
       $vtiposoli = "PERSONA JURIDICA";
       break;
     case "G":
       $vtiposoli = "SECTOR PUBLICO";
       break;
     case "C":
       $vtiposoli = "COOPERATIVA";
       break;
     case "O":
       $vtiposoli = "COMUNAL";
       break;
 }       

if(!empty($indole) and $indole<>'V') { 
	if(!empty($where)) {
      $where = $where." and"." (stzsolic.indole = '$indole')";
  	   $titulo= $titulo." Indole:"."$indole-$vtiposoli";
	}
	else { 
		$where = $where." (stzsolic.indole = '$indole')";
  	   $titulo= $titulo." Indole:"."$indole-$vtiposoli";
	}
}

 $vclatipo="";
 switch ($tipo_marca) {
     case "M":
       $vclatipo = "MARCA DE PRODUCTO";
       break;
     case "S":
       $vclatipo = "MARCA DE SERVICIO";
       break;
     case "N":
       $vclatipo = "NOMBRE COMERCIAL";
       break;
     case "L":
       $vclatipo = "LEMA COMERCIAL";
       break;
     case "D":
       $vclatipo = "DENOMINACION COMERCIAL";
       break;
     case "O":
       $vclatipo = "DENOMINACION DE ORIGEN";
       break;
     case "C":
       $vclatipo = "MARCA COLECTIVA";
       break;
 }       

if(!empty($tipo_marca) and $tipo_marca<>'V') { 
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.tipo_derecho = '$tipo_marca')";
  	   $titulo= $titulo." Tipo:"." $tipo_marca-$vclatipo ";  
	}
	else { 
		$where = $where." (stzderec.tipo_derecho = '$tipo_marca')";
 	   $titulo= $titulo." Tipo:"." $tipo_marca-$vclatipo ";
	}
}

// Armando el query

$resultado=pg_exec("SELECT DISTINCT ON(stzderec.solicitud) stzderec.solicitud, stzderec.fecha_solic, stzderec.nombre, stmmarce.modalidad,stmmarce.clase,stmmarce.ind_claseni, stzderec.estatus, stzsolic.nombre as titular, telefono1,email,identificacion
		    FROM  stmmarce, stzevtrd, stzottid, stzsolic, stzderec
		    WHERE $where 
		    AND stzderec.tipo_mp= 'M'
 		    AND stzderec.nro_derecho=stmmarce.nro_derecho
		    AND stzderec.nro_derecho=stzevtrd.nro_derecho
		    AND stzderec.nro_derecho=stzottid.nro_derecho
		    AND stmmarce.nro_derecho=stzottid.nro_derecho
		    AND stzsolic.titular = stzottid.titular
		    ORDER BY  stzderec.solicitud ");	
 

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!'.$where,'javascript:history.back();','N');
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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud ");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fec.Sol ");
		$header_type[$i]['WIDTH'] = 16;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 65;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Mod");
		$header_type[$i]['WIDTH'] = 8;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clase");
		$header_type[$i]['WIDTH'] = 10;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus");
		$header_type[$i]['WIDTH'] = 13;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 51;
      $i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("C.I./Rif");
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
	$data[1]['TEXT'] = $registro['fecha_solic'];
	$data[2]['TEXT'] = trim(utf8_decode($registro['nombre']));
	$data[3]['TEXT'] = $registro['modalidad'];
	$data[4]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[5]['TEXT'] = $registro['estatus']-1000;
	$data[6]['TEXT'] = trim(utf8_decode($registro['titular']));
   $datostitular='';
   $tel=trim($registro['telefono1']);
   $ema=trim($registro['email']);
   if (!empty($tel)) {$datostitular=$datostitular.''.trim($registro['telefono1']);}
   if (!empty($ema)) {$datostitular=$datostitular.'  '.trim($registro['email']);}
	//$data[7]['TEXT'] = $datostitular;
	$data[7]['TEXT'] = trim($registro['identificacion']);
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
