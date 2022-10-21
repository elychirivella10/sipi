<?php
// Reporte de consulta avanzada por criterio DNDA
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
//Encabezados de pantallas
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Consulta Obras Ineditas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Derecho de Autor";
$encabezado= "Listado Obras Ineditas";

//Conexion
$sql = new mod_db();
$sql->connection($login);
  
//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$registro1=$_POST["vreg1"];
$registro2=$_POST["vreg2"];
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$fecregd=$_POST["fecregd"];
$fecregh=$_POST["fecregh"];
$estatus=$_POST["estatus"];
$tipo=$_POST["tipo"];
$pais=$_POST["pais"];
$nombre=$_POST["nombre"];
$letra=$_POST["letra"];
$clase=$_POST["clase"];
$origen=$_POST["origen"];
$forma=$_POST["forma"];
$solicita=$_POST["solicita"];
//$nconex = $_POST['nconex'];
$orden = $_POST['orden'];

if (empty($orden)) { $orderby = "stdobras.solicitud"; }
else { $orderby = "stdobras.".$orden; }

if ($tipo=='LITERARIAS') {$tipo='OL';}
if ($tipo=='ARTE VISUAL') {$tipo='AV';}
if ($tipo=='ESCENICAS') {$tipo='OE';}
if ($tipo=='MUSICALES') {$tipo='OM';}
if ($tipo=='AUDIOVISUALES Y RADIOFONICAS') {$tipo='AR';}
if ($tipo=='PROGRAMAS DE COMPUTACION Y BASE DE DATOS') {$tipo='PC';}
if ($tipo=='PRODUCIONES FONOGRAFICAS') {$tipo='PF';}
if ($tipo=='INTERPRETACIONES Y EJECUCIONES ARTISTICAS') {$tipo='IE';}
if ($tipo=='ACTOS Y CONTRATOS') {$tipo='AC';}

if ($clase=='INEDITA')   {$clase='I';}
if ($clase=='PUBLICADA') {$clase='P';}

if ($origen=='ORIGINARIA') {$origen='O';}
if ($origen=='DERIVADA')   {$origen='D';}

if ($forma=='INDIVIDUAL')      {$forma='I';}
if ($forma=='EN COLABORACION') {$forma='E';}
if ($forma=='COLECTIVA')       {$forma='C';}

//Query para buscar las opciones deseadas
$where='';
//$where='stdobras.nro_derecho=stdobaut.nro_derecho and stdobaut.titular=stzsolic.titular';
$titulo='';
$from='stdobras';
//$from='stdobras, stdobaut, stzsolic';
if ($vsol1 > $vsol2){ 
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); 
     $sql->disconnect(); exit(); }
     
$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas de solicitud erroneo ...!!!','javascript:history.back();','N');    $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); }

$punt=0;
if ($vsol1 == '000000') { $punt=1; }
if ($vsol2 == '000000') { $punt=1; }

if (($punt!=1) and (!empty($vsol1) and !empty($vsol2))) { 

	if(!empty($where)) {
	   $where = $where." and"." ((stdobras.solicitud >= '$vsol1') and (stdobras.solicitud <='$vsol2'))";
	   $titulo= $titulo." Desde Solictud:"." $vsol1"." Hasta:"." $vsol2";
	}
	else { 
         $where = $where." ((stdobras.solicitud >= '$vsol1') and (stdobras.solicitud <='$vsol2'))";
         $titulo= $titulo." Desde Solicitud:"." $vsol1"." Hasta:"." $vsol2";
	}
}
if(!empty($registro1) and !empty($registro2)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stdobras.registro >= '$registro1') and (stdobras.registro <='$registro2'))";
 	   $titulo= $titulo." Desde Registro:"." $registro1"." Hasta:"." $registro2";
	}
	else { 
		$where = $where." ((stdobras.registro >= '$registro1') and (stdobras.registro <='$registro2'))";
 	   $titulo= $titulo." Desde Registro:"." $registro1"." Hasta:"." $registro2";
	}
}
if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stdobras.fecha_solic >= '$fecsold') and (stdobras.fecha_solic <='$fecsolh'))";
	   $titulo= $titulo." Fecha Sol.:"." $fecsold"." Hasta:"." $fecsolh";
	}
	else { 
		$where = $where." ((stdobras.fecha_solic >= '$fecsold') and (stdobras.fecha_solic <='$fecsolh'))";
      $titulo= $titulo." Fecha Sol.:"." $fecsold"." Hasta:"." $fecsolh";
	}
}

if(!empty($fecregd) and !empty($fecregh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stdobras.fecha_regis >= '$fecregd') and (stdobras.fecha_regis <='$fecregh'))";
	   $titulo= $titulo." Fecha Reg.:"." $fecregd"." Hasta:"." $fecregh";
	}
	else { 
		$where = $where." ((stdobras.fecha_regis >= '$fecregd') and (stdobras.fecha_regis <='$fecregh'))";
      $titulo= $titulo." Fecha Reg.:"." $fecregd"." Hasta:"." $fecregh";
	}
}

if(!empty($estatus) and ($estatus!='0')) {
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"." $estatus";
	}
	else { 
		$where = $where." (stdobras.estatus = '$estatus')";
  	   $titulo= $titulo." Estatus:"." $estatus";
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

if(!empty($clase)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.clase = '$clase')";
  	   $titulo= $titulo." Clase:"." $clase";  
	}
	else { 
		$where = $where." (stdobras.clase = '$clase')";
 	   $titulo= $titulo." Clase:"." $clase";
	}
}
if(!empty($origen)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.origen = '$origen')";
  	   $titulo= $titulo." Origen:"." $origen";  
	}
	else { 
		$where = $where." (stdobras.origen = '$origen')";
 	   $titulo= $titulo." Origen:"." $origen";
	}
}
if(!empty($forma)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.forma = '$forma')";
  	   $titulo= $titulo." Forma:"." $forma";  
	}
	else { 
		$where = $where." (stdobras.forma = '$forma')";
 	   $titulo= $titulo." Forma:"." $forma";
	}
}

if(!empty($pais)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.pais_origen = '$pais')";
  	   $titulo= $titulo." Pais:"." $pais";  
	}
	else { 
		$where = $where." (stdobras.pais_origen = '$pais')";
 	   $titulo= $titulo." Pais:"." $pais";
	}
}
if(!empty($nombre)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stdobras.titulo_obra LIKE '%$nombre%')";
  	   $titulo= $titulo." Titulo:"." $nombre";  
	}
	else { 
		$where = $where." (stdobras.titulo_obra LIKE '%$nombre%')";
 	   $titulo= $titulo." Titulo:"." $nombre";
	}
}

// Armando el query
//$resultado=pg_exec("SELECT stdobras.solicitud,stdobras.fecha_solic,stdobras.tipo_obra,stdobras.titulo_obra,stdobras.estatus, stdobras.registro,stdobras.fecha_regis,stdobras.nplanilla,stdobaut.doc_autor as identificacion,stzsolic.nombre
$resultado=pg_exec("SELECT stdobras.solicitud,stdobras.fecha_solic,stdobras.tipo_obra,stdobras.titulo_obra,stdobras.estatus, stdobras.registro,stdobras.fecha_regis,stdobras.nplanilla
						FROM  $from
						WHERE $where 
						ORDER BY $orderby"); 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');  
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total="Total de Solicitudes: ".$filas_resultado;

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','I',9);

//initialize the table with columns
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
		$header_type[$i]['TEXT'] = utf8_decode("Solicitud");
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titulo");
		$header_type[$i]['WIDTH'] = 60;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Sol.");
		$header_type[$i]['WIDTH'] = 19;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 11;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Estatus");
		$header_type[$i]['WIDTH'] = 15;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Registro");
		$header_type[$i]['WIDTH'] = 18;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Reg.");
		$header_type[$i]['WIDTH'] = 20;
		$i=7;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Autor");
		$header_type[$i]['WIDTH'] = 60;
                $i=8;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Ced_Autor");
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
   
   for($cont=0;$cont<$filas_resultado;$cont++) { 
        $data = Array();
        $data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro['titulo_obra']));
	$data[2]['TEXT'] = $registro['fecha_solic'];
	$data[3]['TEXT'] = $registro['tipo_obra'];
	$data[4]['TEXT'] = $registro['estatus'];
	$data[5]['TEXT'] = $registro['registro'];
	$data[6]['TEXT'] = $registro['fecha_regis'];
        //////Inicio
        $solact=$registro['solicitud'];
        $resultado_autor=pg_exec("SELECT b.doc_autor as identificacion, trim(c.nombre) as nombre 
                                    FROM stdobras a, stdobaut b, stzsolic c
                                   WHERE a.nro_derecho=b.nro_derecho and b.titular=c.titular and a.solicitud='$solact'");
        $registro_autor = pg_fetch_array($resultado_autor);
        $filas_resultado_autor=pg_numrows($resultado_autor);
        $doc_autores='';
        $nom_autores=''; 
//        for($cont_aut=0;$cont_aut<$filas_resultado_autor;$cont_aut++) { 
           $doc_autores=$doc_autores.$registro_autor['identificacion'];
           $nom_autores=$nom_autores.$registro_autor['nombre'];
//        }
        //////Fin
	$data[7]['TEXT'] = utf8_decode($nom_autores);
	$data[8]['TEXT'] = $doc_autores;
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  
   }
 $pdf->Draw_Table_Border();

//Desconexion a la base de datos

$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
