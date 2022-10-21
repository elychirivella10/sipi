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

$login = trim($_SESSION['usuario_login']);
//$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones por Solicitud');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$desde=$_POST["desdec"];
$hasta=$_POST["hastac"];
$desdet=$_POST["desdet"];
$hastat=$_POST["hastat"];
$evento=$_POST["evento"];
$eventoplus=$_POST["eventoplus"];
$claseplus=$_POST["claseplus"];
$vplus=$_POST["vplus"];
$cplus=$_POST["cplus"];
$usuario=trim($_POST["usuario"]);
$estatus=$_POST["estatus"];
$estatusant=$_POST["estatusant"];
$boletin1=$_POST["boletin1"];
$boletin2=$_POST["boletin2"];
if (empty($boletin2)) {$boletin2=$boletin1;}
$modalidad=$_POST["modalidad"];
$indole=$_POST["indole"];
$tipo_marca=$_POST['tipo_marca'];
$fecha_venc=$_POST['fecha_venc'];
$orden = $_POST["orden"];
$busfone = $_POST["busfone"];
if (empty($busfone) or $busfone=='') { $busfone='N';}
$busgraf = $_POST["busgraf"];
if (empty($busgraf) or $busgraf=='') { $busgraf='N';}

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado";

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); exit(); }

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
     $smarty->display('pie_pag.tpl'); exit(); }

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
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
           $estatus1=$estatus-1000;
  	   $titulo= $titulo." Estatus:"."$estatus1";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
           $estatus1=$estatus-1000;
  	   $titulo= $titulo." Estatus:"."$estatus1";
	}
}
if(!empty($estatusant) and ($estatusant!='0')) {
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.estat_ant = '$estatusant')";
           $estatus2=$estatusant-1000;
  	   $titulo= $titulo." Estatus Anterior:"."$estatus2";
	}
	else { 
		$where = $where." (stzevtrd.estat_ant = '$estatusant')";
           $estatus2=$estatusant-1000;
  	   $titulo= $titulo." Estatus Anterior:"."$estatus2";
	}
}
if(!empty($boletin1)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.documento >= '$boletin1' and stzevtrd.documento <= '$boletin2')";
  	   $titulo= $titulo." Boletin:"."$boletin1"." al:"."$boletin2";
	}
	else { 
		$where = $where." (stzevtrd.documento >= '$boletin1' and stzevtrd.documento <= '$boletin2')";
  	   $titulo= $titulo." Boletin:"."$boletin1"." al:"."$boletin2";
	}
}

if(!empty($modalidad)) { 
	if(!empty($where)) {
	   $where = $where." and"." (position(stmmarce.modalidad in upper('$modalidad')) > 0)";
  	   $titulo= $titulo." Modalidad:"."$modalidad";
	}
	else { 
		$where = $where." (position(stmmarce.modalidad in upper('$modalidad')) > 0)";
  	   $titulo= $titulo." Modalidad:"."$modalidad";
	}
}

if(!empty($claseplus)) { 
      if(!empty($where)) {
         if ($cplus==2) {
            $where = $where." and"." (not (stmmarce.clase = '$claseplus' and ind_claseni='I'))";
            $titulo= $titulo." Distinto a la Clase Internacional:"."$claseplus";
         } else {
            $where = $where." and"." (stmmarce.clase = '$claseplus' and ind_claseni='I')";
            $titulo= $titulo." Igual a la Clase Internacional:"."$claseplus";
         }
      }
      else { 
         if ($cplus==2) { 
            $where= $where." (not (stmmarce.clase = '$claseplus' and ind_claseni='I'))";
            $titulo= $titulo." Distinto a la Clase Internacional:"."$claseplus";
         } else {
            $where= $where." (stmmarce = '$claseplus' and ind_claseni='I')";
            $titulo= $titulo." Igual a la Clase Internacional:"."$claseplus";
         }
      }
}

if(!empty($eventoplus)) { 
      $eventoplus1=$eventoplus-1000;
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

if(!empty($fecha_venc)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.fecha_venc = '$fecha_venc')";
	   $titulo= $titulo." Fecha Venc:"."$fecha_venc";
	}
	else { 
	   $where = $where." (stzevtrd.fecha_venc = '$fecha_venc')";
           $titulo= $titulo." Fecha Venc:"."$fecha_venc";
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

//Conexion 
$sql = new mod_db();
$sql->connection($login);

//  Armando el query
//  Borrado del query a peticion de nelson DISTINCT ON(stmmarce.solicitud)
//  Se condiciono el select y el order by porque cuando no se indica un evento
//  se trae todos los eventos de stmevtrd. 

//  Borrado del query por problema en los eventos cargados por sandra DISTINCT ON(stmmarce.solicitud) 25/07/2013
//if (empty($evento)) {$select = "SELECT DISTINCT ON (stzderec.solicitud) ";
//                     $orderby= "stzderec.solicitud"; }

$select = "SELECT ";
if (empty($orden)) { 
  $orderby = "stzderec.solicitud";
  if (!empty($evento)) { $select = "SELECT DISTINCT ON (stzderec.solicitud) "; }   
}
else {
 if ($orden=="fecha_event") { $orderby = "7,1"; }
 else {
  if ($orden=="fecha_trans") { $orderby = "10,1"; }
  else {
    if ($orden=="documento") { $orderby = "13,1"; }
    else { $select = "SELECT DISTINCT ON (stzderec.solicitud) "; $orderby = "stzderec.solicitud"; } 
  }
 }
}

//stzevtrd.documento
//if (empty($evento)) {$select = "SELECT ";
//                     $orderby= "stzderec.solicitud"; }
//else {$select = "SELECT ";
//      //$orderby= "stzevtrd.documento, stzderec.solicitud"; 
//      $orderby= "stzderec.solicitud"; 
//}

$qquery = "$select stzderec.solicitud, stzderec.registro,stzderec.nombre,stmmarce.modalidad,stzevtrd.evento,stzevtrd.estat_ant,stzevtrd.fecha_event,stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento,stzevtrd.comentario 
						FROM  stmmarce, stzevtrd, stzderec
						WHERE $where 
						AND stzevtrd.nro_derecho = stzderec.nro_derecho
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp = 'M'
						ORDER BY $orderby";

//echo " $qquery  "; 
//exit();
// DISTINCT ON (stzderec.solicitud) 
						
$resultado=pg_exec($select." stzderec.solicitud, stzderec.registro,stzderec.nombre,stmmarce.modalidad,stzevtrd.evento,stzevtrd.estat_ant,stzevtrd.fecha_event,stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento,stzevtrd.comentario,stzevtrd.hora 
						FROM  stmmarce, stzevtrd, stzderec
						WHERE $where 
						AND stzevtrd.nro_derecho = stzderec.nro_derecho
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp = 'M'
						ORDER BY ".$orderby);	
 
//stmevtrd.evento,stmevtrd.fecha_event, stmmarce.solicitud,

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
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

// En el caso de las Detinidas para ver el Comentario
if ($evento==1054) { 
   $pdf->Table_Init(9);
   $columns=9;
} else {
   $pdf->Table_Init(12);
   $columns=12;
}
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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 54;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("M");
		$header_type[$i]['WIDTH'] = 5;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Clas");
		$header_type[$i]['WIDTH'] = 8;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Even");
		$header_type[$i]['WIDTH'] = 9;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Previo");
		$header_type[$i]['WIDTH'] = 11;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Evt.");
		$header_type[$i]['WIDTH'] = 17;
		$i=7;
      if ($evento==1054) {
        $header_type[$i] = $table_default_header_type;
		  $header_type[$i]['TEXT'] = utf8_decode("Comentario");
		  $header_type[$i]['WIDTH'] = 59;    
		  $i=8;
		  $header_type[$i] = $table_default_header_type;
		  $header_type[$i]['TEXT'] = utf8_decode("Hora Carga");
		  $header_type[$i]['WIDTH'] = 10;
      } else { 
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Venc");
		$header_type[$i]['WIDTH'] = 16;
		$i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Status Actual");
		$header_type[$i]['WIDTH'] = 12;
		$i=9;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Doc.");
		$header_type[$i]['WIDTH'] = 12;
		$i=10;
		$header_type[$i] = $table_default_header_type;
                if ($busgraf=='S') {$header_type[$i]['TEXT'] = utf8_decode("Busqueda grafica?"); }
		if ($busgraf=='N') {$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans"); }
		$header_type[$i]['WIDTH'] = 17;
		$i=11;
		$header_type[$i] = $table_default_header_type;
                if ($busfone=='S') {$header_type[$i]['TEXT'] = utf8_decode("Busqueda fonetica?"); }
		if ($busfone=='N') {$header_type[$i]['TEXT'] = utf8_decode("Hora Carga"); }
		$header_type[$i]['WIDTH'] = 17;
                }

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
	$data[2]['TEXT'] = $registro['modalidad'];
	$data[3]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
	$data[4]['TEXT'] = $registro['evento']-1000;
	$data[5]['TEXT'] = $registro['estat_ant']-1000;
	$data[6]['TEXT'] = $registro['fecha_event'];
   if ($evento==1054) { 
  	   $data[7]['TEXT'] = trim(utf8_decode($registro['comentario']));
	   $data[8]['TEXT'] = trim($registro['hora']);
   } else {   
	$data[7]['TEXT'] = $registro['fecha_venc'];    
        $data[8]['TEXT'] = $registro['estatus']-1000;

	if (!empty($evento)) { $data[9]['TEXT'] = $registro['documento']; }
        else {                 $data[9]['TEXT'] = ' '; }

        if ($busgraf=='S') {$varsol1=substr($registro['solicitud'],0,4); 
                            $varsol2=substr($registro['solicitud'],5,6);
                            $name ="../documentos/grafica/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
                            if (is_file($name)) { $resulbus='SI'; } else { $resulbus='NO'; } 
                            $data[10]['TEXT'] = trim($resulbus); }
        if ($busgraf=='N') {$data[10]['TEXT'] = $registro['fecha_trans']; }

        if ($busfone=='S') {$varsol1=substr($registro['solicitud'],0,4); 
                            $varsol2=substr($registro['solicitud'],5,6);
                            $name ="../documentos/fonetica/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
                            if (is_file($name)) { $resulbus='SI'; } else { $resulbus='NO'; } 
                            $data[11]['TEXT'] = trim($resulbus); }
        if ($busfone=='N') {$data[11]['TEXT'] = trim($registro['hora']); }
   } 
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
