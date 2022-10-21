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
$smarty->assign('titulo',$substpat);
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
$boletin1=$_POST["boletin1"];
$boletin2=$_POST["boletin2"];

$eventoplus=$_POST["eventoplus"];
$vplus=$_POST["vplus"];
$estatus=$_POST["estatus"];
$estatusant=$_POST["estatusant"];
if (empty($boletin2)) { $boletin2=$boletin1;}
$locarno1=$_POST["locarno1"];
$locarno2=$_POST["locarno2"];
$cip1=$_POST["cip1"];
$cip2=$_POST["cip2"];
$orden = $_POST["orden"];

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Listado";

$tipo=tipo_patentec($tipo);

//Query para buscar las opciones deseadas
$where='';
$titulo='';
$tablas = "stzderec, stppatee, stzevtrd ";

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
	$evento1=$evento-2000;
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento:"."$evento1";
	}
	else { 
		$where = $where." (stzevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento:"."$evento1";
	}
}
if (!empty($estatus) and ($estatus!='0')) {
	$est=$estatus-2000;
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"."$est";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"."$est";
	}
}
if (!empty($estatusant) and ($estatusant!='0')) {
	$estant=$estatusant-2000;
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.estat_ant = '$estatusant')";
           $estatus2=$estatusant-2000;
  	   $titulo= $titulo." Estatus Anterior:"."$estatus2";
	}
	else { 
	   $where = $where." (stzevtrd.estat_ant = '$estatusant')";
           $estatus2=$estatusant-2000;
  	   $titulo= $titulo." Estatus Anterior:"."$estatus2";
	}
}
if(!empty($tipo)) { 
   $tipopaten = tipo_patente($tipo);
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.tipo_derecho = '$tipo')";
  	   $titulo= $titulo." Tipo:"." $tipo-$tipopaten";  
	}
	else { 
		$where = $where." (stzderec.tipo_derecho = '$tipo')";
 	   $titulo= $titulo." Tipo:"." $tipo-$tipopaten";
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
if(!empty($boletin1)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.documento >= '$boletin1' and stzevtrd.documento <= '$boletin2')";
  	   $titulo= $titulo." Boletin:"."$boletin1"." al "."$boletin2";
	}
	else { 
		$where = $where." (stzevtrd.documento >= '$boletin1' and stzevtrd.documento <= '$boletin2')";
  	   $titulo= $titulo." Boletin:"."$boletin1"." al "."$boletin2";
	}
}

if(!empty($eventoplus)) { 
      $eventoplus1=$eventoplus-2000;
      if(!empty($where)) {
         if ($vplus==2) {
            $where = $where." and"." (stzderec.nro_derecho not in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Sin Evento Adicional:"."$eventoplus1";
         } else {
            $where = $where." and"." (stzderec.nro_derecho in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Con Evento Adicional:"."$eventoplus1";
         }
      }
      else { 
         if ($vplus==2) { 
            $where= $where." (stzderec.nro_derecho not in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Sin Evento Adicional:"."$eventoplus1";
         } else {
            $where= $where." (stzderec.nro_derecho in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Con Evento Adicional:"."$eventoplus1";
         }
      }
}
$rjoin= "";
if((!empty($locarno1)) AND (!empty($locarno2))) {
        $locarno = $locarno1."-".$locarno2;
        $tablas = $tablas.",stplocad ";
        $rjoin = $rjoin." AND (stzderec.nro_derecho = stplocad.nro_derecho) ";  
	if(!empty($where)) {
	   $where = $where." AND"." (stplocad.clasi_locarno = '$locarno')";
  	   $titulo= $titulo." Locarno:"."$locarno";  
	}
	else { 
	   $where = $where." (stplocad.clasi_locarno = '$locarno')";
 	   $titulo= $titulo." Locarno:"."$locarno";
	}
}

if(!empty($cip1)) {
        $tablas = $tablas.",stpclsfd ";
        $rjoin = $rjoin." AND (stzderec.nro_derecho = stpclsfd.nro_derecho) ";  
	if(!empty($where)) {
	   $where = $where." AND"." (stpclsfd.clasificacion ilike '$cip1%')";
  	   $titulo= $titulo." CIP:"."$cip1";  
	}
	else { 
	   $where = $where." (stpclsfd.clasificacion ilike '$cip1%')";
 	   $titulo= $titulo." CIP:"."$cip1";
	}
}

// Order by
$select = "SELECT ";
if (empty($orden)) { 
  $orderby = "stzderec.solicitud";
  if (!empty($evento)) { $select = "SELECT DISTINCT ON (stzderec.solicitud) "; }   
}
else {
 if ($orden=="fecha_event") { $orderby = "7,1"; }
 else {
   if ($orden=="document") { $orderby = "11,1"; }
   else {
     if ($orden=="registro") { $orderby = "stzderec.registro"; }
     else { $select = "SELECT DISTINCT ON (stzderec.solicitud) "; $orderby = "stzderec.solicitud"; } 
   }
 }
}

// Armando el query
$resultado=pg_exec($select."stzderec.solicitud,stzderec.registro,stzderec.nombre,stzderec.tipo_derecho,stzevtrd.evento,stzevtrd.estat_ant,stzevtrd.fecha_event,
stzevtrd.fecha_trans,stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento
						FROM  $tablas 
						WHERE $where 
						AND stzderec.registro !='' 
						AND stzderec.tipo_mp='P' 
						AND stzderec.nro_derecho = stppatee.nro_derecho 
						AND stzderec.nro_derecho = stzevtrd.nro_derecho
                                                $rjoin
						ORDER BY ".$orderby);

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
$pdf->Table_Init(10);
$columns=10;
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
		$header_type[$i]['TEXT'] = utf8_decode("Titulo");
		$header_type[$i]['WIDTH'] = 50;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 13;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Previo");
		$header_type[$i]['WIDTH'] = 12;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Evt.");
		$header_type[$i]['WIDTH'] = 17;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc");
		$header_type[$i]['WIDTH'] = 17;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans");
		$header_type[$i]['WIDTH'] = 17;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Actual");
		$header_type[$i]['WIDTH'] = 12;
		$i=9;
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
	$data[3]['TEXT'] = $registro['evento']-2000;
	$data[4]['TEXT'] = $registro['estat_ant']-2000;
	$data[5]['TEXT'] = $registro['fecha_event'];
	$data[6]['TEXT'] = $registro['fecha_venc'];
	$data[7]['TEXT'] = $registro['fecha_trans'];
	$data[8]['TEXT'] = $registro['estatus']-2000;
	if (!empty($evento)) {
	  $data[9]['TEXT'] = $registro['documento']; }
        else {
	  $data[9]['TEXT'] = ''; }
	$registro = pg_fetch_array($resultado);

	$pdf->Draw_Data($data);
  }
$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
