<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();

include ("../z_includes.php");

//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
	
//Class Extention for header and footer	
require_once("$include_lib/header_footer.inc");

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }
;

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Cronologia Administrativa";
$linea="_________________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Cronologia Administrativa');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$vsol=$_GET["vsol"];
$varsol1=$_POST["vsol1"];
if (empty($varsol1)) {$varsol1=$_GET["vsol1"];}
$varsol2=$_POST["vsol2"];
if (empty($varsol2)) {$varsol2=$_GET["vsol2"];}
$varreg1=$_POST["vreg1"];
if (empty($varreg1)) {$varreg1=$_GET["vreg1"];}
$varreg2=$_POST["vreg2"];
if (empty($varreg2)) {$varreg2=$_GET["vreg2"];}
$nconex = $_POST['nconex'];

//Formateando los campos solicitud y registro
$varreg= $varreg1.$varreg2;
//$varsol=($varsol1.'-'.$varsol2);
if (empty($vsol)) {
$varsol=($varsol1.'-'.$varsol2);} else { $varsol=$vsol;}

//Query para buscar las opciones deseadas
if((!empty($varsol1)) and (!empty($varsol2))) {
  $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stmmarce a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='M' 
		        AND b.solicitud= '$varsol' and b.solicitud!=''");
  $titulo= $titulo." Solicitud:"." $varsol"; 	
}
else {
if(!empty($varreg)) { 
 $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stmmarce a, stzderec b
                        WHERE a.nro_derecho=b.nro_derecho 
		     	AND tipo_mp='M' 
			AND b.registro= '$varreg' 
			AND b.registro!=''");
 $titulo= $titulo." Registro:"." $varreg";
}
}

//Verificando los resultados
if (!$resultado) 
   { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) 
   {
     echo "<br><br>";   
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); 
   } 

$reg = pg_fetch_array($resultado);
$varsol=$reg['solicitud'];
$nregis=$reg['registro'];
$nagen=$reg['agente'];
$poder=$reg[poder];
$nderec=$reg['nro_derecho'];

//Busqueda de Tablas necesarias

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$nameimage=ver_imagen($varsol1,$varsol2,'M');
$resulteti=pg_exec("SELECT descripcion FROM stmlogos 
                        WHERE nro_derecho='$nderec'");
$regeti = pg_fetch_array($resulteti);
$desc_etiq=$regeti['descripcion'];
//$nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";
//$nameimageMAY = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".JPG";

$descripcion=estatus($reg['estatus']);

$pais_nombre=pais($reg['pais_resid']);

$vmod=modalida_marca($reg['modalidad']);

$vtip=tipo_marca($reg['tipo_marca']);

$vcla=ind_clase($reg['ind_claseni']);

$vporc='83%';
if ($reg['modalidad']!="D")
   {$vporc='55%';} 

//$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

//imagen
if (file($nameimage)) 
   {
   $pdf->SetFillColor(192);
   $pdf->RoundedRect(175, 38, 33, 30, 3.5, 'D');
   $pdf->Image("$nameimage",176,40,30,25,'JPG');
   }

   //Muestra campos principales de la cronologia
 	
   $pdf->ln(2);
   $pdf->Cell(15,8,'Solicitud:',0,0); 
   $pdf->Cell(100,8,$varsol,0,0);
   $pdf->Cell(30,8,'Fecha de Solicitud:',0,0);
   $pdf->Cell(100,8,$reg['fecha_solic'],0,1);
   $pdf->Cell(25,8,'Tipo de Marca:',0,0);
   $pdf->Cell(90,8,$reg['tipo_marca'].'-'.$vtip,0,0);
   $pdf->Cell(20,8,'Modalidad:',0,0);
   $pdf->Cell(100,8,$reg['modalidad'].'-'.$vmod,0,1);    
   $pdf->Cell(30,8,'Pais de Residencia:',0,0);
   $pdf->Cell(85,8,$reg['pais_resid'].'-'.trim(utf8_decode($pais_nombre)),0,0);
   $pdf->Cell(15,8,'Clase:',0,0);
   $pdf->Cell(100,8,$reg['clase'].'-'.$vcla,0,1);    
   $pdf->Cell(35,8,'Fecha de Publicacion:',0,0);
   $pdf->Cell(80,8,$reg['fecha_publi'],0,0);  
   $pdf->Cell(30,8,'Num. de Registro:',0,0);
   $pdf->Cell(85,8,$reg['registro'],0,1);
   $pdf->Cell(30,8,'Fecha de Registro:',0,0);
   $pdf->Cell(85,8,$reg['fecha_regis'],0,0);
   $pdf->Cell(35,8,'Fecha de Vencimiento:',0,0);
   $pdf->Cell(85,8,$reg['fecha_venc'],0,1);  
   //$pdf->Cell(15,8,'Nombre:',0,0); 
   //$pdf->Cell(20,8,utf8_decode($reg['nombre']),0,1);
   //$pdf->Ln(2);
   $pdf->MultiCell(0,4,'Nombre:  '.utf8_decode($reg['nombre']),0,1);
   $pdf->Ln(2);
   //$pdf->Cell(30,8,'Tramitante/Agente:',0,0);
   // $tram = agente_tram($nagen,$reg['tramitante']);
   // Busqueda de tramitante y varios agentes
   $tram = agente_tramp($nagen,$reg[tramitante],$poder);    

   //$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente = '$nagen'");
	//$regage = pg_fetch_array($res_agen);
	//if ($regage['agente']<= 0)
   //   { $tram = trim($reg['tramitante']); }
	//if ($regage['agente']> 0)
	//   {$tram= "Codigo: ".$regage['agente']." ".trim(utf8_decode($regage['nombre']));
	//    $res_agen1=pg_exec("SELECT stzagenr.agente, stzagenr.nombre  FROM stzautod,stzagenr WHERE stzautod.nro_derecho ='$nderec' and stzagenr.agente = stzautod.agente");
	//    $regage1 = pg_fetch_array($res_agen1);
	//    $filas_found_agen=pg_numrows($res_agen1);
	//    if ($filas_found_agen <> 0){
	//     for ($j=0; $j<$filas_found_agen; $j++){
	//	    if ($regage1['agente'] == $regage['agente']) { 
	//	      $regage1 = pg_fetch_array($res_agen1); }
	//	    else {
 	//	      $tram= $tram."  /   Codigo: ".$regage1['agente']." ".trim(utf8_decode($regage1['nombre'])); }
	//	    $regage1 = pg_fetch_array($res_agen1);
	//    }
   //    }
	//}
     $poder=trim($poder);
     if ($poder=='-') {$poder='';} 
	if (empty($poder)) { $pdf->MultiCell(0,4,'Poder/Tramitante/Agente:  '.$tram,0,1); }
	else { $pdf->MultiCell(0,4,'Poder/Tramitante/Agente:  '.$poder.':  '.$tram,0,1); }
   $pdf->Ln(2);
   $pdf->MultiCell(0,4,'Estatus:  '.($reg['estatus']-1000).' '.$descripcion,0,1);
   $pdf->Ln(5);

// Buscando los Titulares de la solicitud
//load the table default definitions DEFAULT!!!
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>TITULARES DE LA MARCA</s1>", 0);

	require("$include_path/tablas_def.inc");

	$columns = 6; //number of Columns
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	
	$aSimpleHeader = array();
	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Código ");
		$aSimpleHeader[$i]['WIDTH'] = 15;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Nombre ";
		$aSimpleHeader[$i]['WIDTH'] = 60;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Domicilio ";
		$aSimpleHeader[$i]['WIDTH'] = 50;
                $i=3;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("País ");
		$aSimpleHeader[$i]['WIDTH'] = 22;
                $i=4;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Indole ";
		$aSimpleHeader[$i]['WIDTH'] = 20;
		$i=5;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Identificacion ";
		$aSimpleHeader[$i]['WIDTH'] = 22;
		
	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);


$result = pg_exec("SELECT stzottid.titular, stzsolic.nombre,stzsolic.indole, stzsolic.identificacion, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");

$res = pg_fetch_array($result);
$filas_found=pg_numrows($result);
$fil=$filas_found;

	for ($j=0; $j<$filas_found; $j++)
	{
		$data = Array();
		$data[0]['TEXT'] = trim($res['titular']);
		$data[1]['TEXT'] = trim(utf8_decode($res['nombre']));
		$pais_nombre=pais($res['nacionalidad']);
		$data[2]['TEXT'] = utf8_decode(trim($res['domicilio']));
		$data[3]['TEXT'] = trim($res['nacionalidad']."-".utf8_decode($pais_nombre));
      if(!empty($res['indole'])) { 		
		  if ($res['indole']== 'N') { $indole='Persona Natural';}
		  if ($res['indole']== 'P') { $indole='Empresa Privada';}
		  if ($res['indole']== 'C') { $indole='Cooperativas';}		
		  if ($res['indole']== 'G') { $indole='Sector Publico';}
		  if ($res['indole']== 'O') { $indole='Comunales';}				
		} else {$indole='';}
		$data[4]['TEXT'] = $indole;
		$data[5]['TEXT'] = trim($res['identificacion']);				
		$pdf->tbDrawData($data);
		$res = pg_fetch_array($result);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->Ln(6);

// Etiqueta
   if ($reg['modalidad']=='G' or $reg['modalidad']=='M') {
	require("$include_path/tablas_def.inc");
	$columns = 1; //number of Columns
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	$aSimpleHeader = array();	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Etiqueta ");
		$aSimpleHeader[$i]['WIDTH'] = 190;
                $i=1;
	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	//Draw the Header
	$pdf->tbDrawHeader();
	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

	for ($j=0; $j<1; $j++)
	{
	    $data = Array();
	    //$textodis = utf8_encode($desc_etiq);
         $textodis = utf8_decode($desc_etiq);
         $data[0]['TEXT'] = $textodis;
	    $pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();	
	//draw the Table Border
	$pdf->tbDrawBorder();
	$pdf->Ln(6);
   } //fin etiqueta

// Distingue
	require("$include_path/tablas_def.inc");
	$columns = 1; //number of Columns
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	$aSimpleHeader = array();	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Distingue ");
		$aSimpleHeader[$i]['WIDTH'] = 190;
                $i=1;
	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	//Draw the Header
	$pdf->tbDrawHeader();
	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

	for ($j=0; $j<1; $j++)
	{
		$data = Array();
		$textodis = utf8_decode($reg['distingue']);
      $data[0]['TEXT'] = $textodis;
		$pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();	
	//draw the Table Border
	$pdf->tbDrawBorder();
	$pdf->Ln(6);
     // fin Distingue

// Buscando la Cronologia de la Solicitud
	//load the table default definitions
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s1","arial","",9);
	$pdf->MultiCellTag(100, 4, "<s1>CRONOLOGIA DE LA SOLICITUD</s1>", 0);

	$bTableSplitMode = true;

	require("$include_path/tablas_def.inc");

	$columns = 7; //number of Columns
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	$aSimpleHeader = array();
	
	//Table Header
	//for($i=0; $i<$columns; $i++) {
 		$i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Fecha Evento ";
		$aSimpleHeader[$i]['WIDTH'] = 15;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Transacción ");
		$aSimpleHeader[$i]['WIDTH'] = 20;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Usuario ";
		$aSimpleHeader[$i]['WIDTH'] = 18;
                $i=3;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Documento ";
		$aSimpleHeader[$i]['WIDTH'] = 20;
                $i=4		;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Evento ";
		$aSimpleHeader[$i]['WIDTH'] = 12;
             	$i=5;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Descripción ");
		$aSimpleHeader[$i]['WIDTH'] = 70;
             	$i=6;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Comentario ";
		$aSimpleHeader[$i]['WIDTH'] = 35;
	
	$aSimpleHeader1 = $aSimpleHeader;
	
	$aHeader = array(
		$aSimpleHeader,
	);

	//set the Table Header
	$pdf->tbSetHeaderType($aHeader, true);
	
	$bTableSplitMode = true;
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	
	if (isset($bTableSplitMode))
		$pdf->tbSetSplitMode($bTableSplitMode);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

$resultado=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' order by fecha_event,secuencial");   
   $filas_found=pg_numrows($resultado);
  // $reg = pg_fetch_array($resultado);

	for ($j=0; $j<$filas_found; $j++)
	{
		$reg = pg_fetch_array($resultado);
		$data = Array();
      		$data[0]['TEXT'] = $reg['fecha_event'];
		$data[1]['TEXT'] = $reg['fecha_trans'];
	        $data[2]['TEXT'] = trim($reg['usuario']);
		$data[3]['TEXT'] = $reg['documento'];
	        $data[4]['TEXT'] = ($reg['evento']-1000);
	        $data[5]['TEXT'] = utf8_decode(trim(sprintf($reg['desc_evento'])));
	        $data[6]['TEXT'] = utf8_decode(trim(sprintf($reg['comentario'])));
		$pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();

?>
