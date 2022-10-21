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
$orden = $_POST["orden"];

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

//Conexion 
$sql = new mod_db();
$sql->connection($login);

$desevento=' '; 

if(!empty($evento)) { 
   $res_desev=pg_exec("SELECT descripcion FROM stzevder WHERE evento='$evento'");
   $regdesev = pg_fetch_array($res_desev);
//   if ($evento=='1225') {$desevento='NEGADA POR PUBLICAR - '; } 
//   if ($evento=='1091') {$desevento='PRIORIDAD EXTINGUIDA POR PUBLICAR - '; }
//   if ($evento=='1062') {$desevento='NEGADA - '; } 
//   if ($evento=='1197') {$desevento='PERENCION DE PROCEDIMIENTO POR NO RATIFICACION DEFINITIVAMENTE FIRME- '; } 
//   if ($evento<>'1225' and $evento<>'1091' and $evento<>'1062' and $evento<>'1197') { 
      $desevento=rtrim(ltrim(substr($regdesev['descripcion'],0,80))).' - ';
//   } 

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
 if ($orden=="fecha_event") { $orderby = "8,2"; }
 else {
  if ($orden=="fecha_trans") { $orderby = "11,2"; }
  else {
    if ($orden=="documento") { $orderby = "14,2"; }
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

$qquery = "$select stzderec.nro_derecho,stzderec.solicitud, stzderec.registro,stzderec.nombre,stmmarce.modalidad,stzevtrd.evento,stzevtrd.estat_ant,stzevtrd.fecha_event,stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento,stzevtrd.comentario,stzevtrd.usuario
						FROM  stmmarce, stzevtrd, stzderec
						WHERE $where 
						AND stzevtrd.nro_derecho = stzderec.nro_derecho
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp = 'M'
						ORDER BY $orderby";

//echo " $qquery  "; 
//exit();
// DISTINCT ON (stzderec.solicitud) 
						
$resultado=pg_exec($select." stzderec.nro_derecho,stzderec.solicitud, stzderec.registro,stzderec.nombre,stmmarce.modalidad,stzevtrd.evento,stzevtrd.estat_ant,stzevtrd.fecha_event,stmmarce.clase, stmmarce.ind_claseni,
stzevtrd.fecha_trans, stzderec.fecha_venc,stzderec.estatus,stzevtrd.documento,stzevtrd.comentario,stzevtrd.hora,stzevtrd.usuario 
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
$total=$desevento.' Total de Solicitudes: '.$filas_resultado;

//Incio de la Clase de PDF para generar los reportes

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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 17;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 45;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("M");
		$header_type[$i]['WIDTH'] = 5;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cla se");
		$header_type[$i]['WIDTH'] = 8;
                $i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 8;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Evento");
		$header_type[$i]['WIDTH'] = 15;
                $i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Trans.");
		$header_type[$i]['WIDTH'] = 15; 
                $i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 18;
		$i=8;
                $header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Comentario");
	        $header_type[$i]['WIDTH'] = 59;   
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
    $nderec=$registro['nro_derecho'];
    $data[0]['TEXT'] = $registro['solicitud'];
    $data[1]['TEXT'] = trim(utf8_decode($registro['nombre']));
    $data[2]['TEXT'] = $registro['modalidad'];
    $data[3]['TEXT'] = $registro['clase'].'-'.$registro['ind_claseni'];
    $data[4]['TEXT'] = $registro['evento']-1000;
    $data[5]['TEXT'] = $registro['fecha_event'];
    $data[6]['TEXT'] = $registro['fecha_trans'];
    $data[7]['TEXT'] = $registro['usuario'];
    if ($registro['evento']==1053 || $registro['evento']==1052) {
        if ($registro['evento']==1053) {  // Examen de Forma
            $res_des=pg_exec("SELECT c.nro_derecho,c.cod_causa,c.sub_causa,d.desc_causa,e.desc_sub_causa,f.nombre 
            FROM stzsoldev c, stzcadev d, stzsubcodev e, stzusuar f 
            WHERE c.nro_derecho = '$nderec' 
            AND c.cod_causa = d.cod_causa
            AND c.cod_causa = e.cod_causa
            AND c.sub_causa = e.sub_causa
            AND c.usuario = f.usuario
            AND c.derecho = 'M'
            AND c.grupo = 'M'
            AND c.tipo_dev = 'M'
            ORDER BY c.cod_causa"); }

        if ($registro['evento']==1052) {  // Examen de Fondo
            $res_des=pg_exec("SELECT c.nro_derecho,c.cod_causa,c.sub_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
            FROM stmmarce a, stzderec b, stzsoldev c
            WHERE c.nro_derecho = '$nderec' 
            AND c.nro_derecho= b.nro_derecho  
            AND b.nro_derecho = a.nro_derecho 
            AND c.derecho = 'M'
            AND c.grupo = 'M'
            AND c.tipo_dev = 'D'
            ORDER BY c.cod_causa"); }

        $filas_coded = pg_numrows($res_des); 
        $regdes      = pg_fetch_array($res_des);
        $indc=1;
        $valor=$regdes['cod_causa'];
        $lcomenta='';
        for ($j=0; $j<$filas_coded; $j++) {
	  if (($valor!= $regdes['cod_causa']) or ($indc==1)) {
		  $lcomenta=$lcomenta.' '.utf8_decode($regdes['desc_causa']); 
		  $subcausa = trim($regdes['desc_sub_causa']);
		  if (!empty($subcausa) AND ($subcausa!='Ninguna Sub Causa')) {
		    $lcomenta=$lcomenta.' '.utf8_decode($regdes['desc_sub_causa']); }
     	  $indc=0;
          }
          else {
		  $lcomenta=$lcomenta.' '.utf8_decode($regdes['desc_sub_causa']);
          }  
          $regdes = pg_fetch_array($res_des);
          if ($valor!= $regdes['cod_causa']) { $valor= $regdes['cod_causa']; $indc=1; }
        }
        // Busqueda de Causa de Devolucion (otros) 
        //$res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
        $res_otros=pg_exec("SELECT * FROM stzotrode WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
        $filas_otros= pg_numrows($res_otros);
        if ($filas_otros==0) { $nrgg=0; }
        else { 
           $regotr = pg_fetch_array($res_otros);
	   $lcomenta=$lcomenta.' '.utf8_decode('- Otros: '.$regotr['otros']); 
        }
        $data[8]['TEXT'] = $lcomenta;

    } else {  
      $data[8]['TEXT'] = trim(utf8_decode($registro['comentario']));
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
