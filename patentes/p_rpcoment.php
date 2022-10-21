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

//variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

// encabezados de pantalla
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Listado de Observaciones a Solicitud de Patente');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$desdet=$_POST["desdet"];
$hastat=$_POST["hastat"];
$usuario=$_POST["usuario"];
$estatus=$_POST["estatus"];
$nconex = $_POST['nconex'];

$vsold=($vsol1.'-'.$vsol2);
$vsolh=($vsol1h.'-'.$vsol2h);

$punt=0;
if ($vsold == "-") { $punt=1; }
if ($vsolh == "-") { $punt=1; }

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Listado de Observaciones a Patentes";

//Query para buscar las opciones deseadas
$where='';
$titulo='';

if ($vsolh <$vsold){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if (($punt!=1) and (!empty($vsold) and !empty($vsolh))) { 
   if(!empty($where)) {
	   $where = $where." AND"." ((stzderec.solicitud >= '$vsold') AND (stzderec.solicitud <='$vsolh'))";
	   $titulo= $titulo." Desde Solictud:"." $vsold"." Hasta:"." $vsolh";
	}
	else { 
		$where = $where." ((stzderec.solicitud >= '$vsold') AND (stzderec.solicitud <='$vsolh'))";
      $titulo= $titulo." Desde Solicitud:"." $vsold"." Hasta:"." $vsolh";
	}
}

$esmayor=compara_fechas($desdet,$hastat);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desdet) and !empty($hastat)) { 
	if(!empty($where)) {
	   $where = $where." AND"." ((stpnotas.fecha_trans >= '$desdet') AND (stpnotas.fecha_trans <='$hastat'))";
	   $titulo= $titulo." Fecha Observacion: "."$desdet"." al: "."$hastat";
	}
	else { 
		$where = $where." ((stpnotas.fecha_trans >= '$desdet') AND (stpnotas.fecha_trans <='$hastat'))";
      $titulo= $titulo." Fecha Observacion: "."$desdet"." al: "."$hastat";
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." AND"." (stpnotas.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stpnotas.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}
if(!empty($estatus) and ($estatus!='0')) {
	$est=$estatus-2000;
	if(!empty($where)) {
	   $where = $where." AND"." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"."$est";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"."$est";
	}
}

//  Armando el query
//  Borrado del query a peticion de nelson DISTINCT ON(stmmarce.solicitud)
//  Se condiciono el select y el order by porque cuando no se indica un evento
//  se trae todos los eventos de stmevtrd. 

$resultado=pg_exec("SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud,stpnotas.id_nota,stpnotas.notas
						FROM  stzderec, stpnotas
						WHERE $where 
						AND stzderec.nro_derecho = stpnotas.nro_derecho
						AND stzderec.tipo_mp='P' 
                  GROUP BY 1,2,3
                  ORDER BY 1 ASC,2 DESC");
$filasres=pg_numrows($resultado); 
$total='Total de Solicitudes: '.$filasres;

$resultado=pg_exec("SELECT stzderec.solicitud, stzderec.nombre,stzderec.estatus,stpnotas.id_nota,stpnotas.notas,stpnotas.fecha_trans,stpnotas.usuario
						FROM  stzderec, stppatee, stpnotas
						WHERE $where 
						AND stzderec.nro_derecho = stppatee.nro_derecho 
						AND stzderec.nro_derecho = stpnotas.nro_derecho
						AND stzderec.tipo_mp='P' 
                  GROUP BY 1,2,3,4,5,6,7
                  ORDER BY 1 ASC,4 DESC");

//verificando los resultados Transacciones

if (!$resultado)    { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('AVISO: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
//$total='Total de Solicitudes: '.$filas_resultado;
$total='Total de Solicitudes: '.$filasres;

//Inicio de la Clase de PDF para generar los reportes

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//initialize the table with 6 columns
$pdf->Table_Init(6);
$columns=6;
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
$header_type[$i]['WIDTH'] = 18;
$i=1;
$header_type[$i] = $table_default_header_type;
$header_type[$i]['TEXT'] = utf8_decode("Titulo ");
$header_type[$i]['WIDTH'] = 80;
$i=2;
$header_type[$i] = $table_default_header_type;
$header_type[$i]['TEXT'] = utf8_decode("Estatus");
$header_type[$i]['WIDTH'] = 14;
$i=3;
$header_type[$i] = $table_default_header_type;
$header_type[$i]['TEXT'] = utf8_decode("Fecha Obs.");
$header_type[$i]['WIDTH'] = 18;
$i=4;
$header_type[$i] = $table_default_header_type;
$header_type[$i]['TEXT'] = utf8_decode("Observación");
$header_type[$i]['WIDTH'] = 60;
$i=5;
$header_type[$i] = $table_default_header_type;
$header_type[$i]['TEXT'] = utf8_decode("Usuario");
$header_type[$i]['WIDTH'] = 16;

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
 //$ciclo_sig = $registro['solicitud'];
 $ciclo_sol = "0000-000000";
 for($cont=0;$cont<$filas_resultado;$cont++) {
   $ciclo_sig = $registro['solicitud'];
   if ($ciclo_sol<>$ciclo_sig) { 
	  $data = Array();
	  $data[0]['TEXT'] = $registro['solicitud'];
	  $data[1]['TEXT'] = utf8_decode(trim($registro['nombre']));
	  $data[2]['TEXT'] = $registro['estatus']-2000;
	  $data[3]['TEXT'] = $registro['fecha_trans'];
	  $data[4]['TEXT'] = utf8_decode(trim($registro['notas'])); 
	  $data[5]['TEXT'] = $registro['usuario'];
	  $ciclo_sol = $registro['solicitud'];
	  $pdf->Draw_Data($data);
	}
	$registro = pg_fetch_array($resultado);

 }

$pdf->Draw_Table_Border();

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
