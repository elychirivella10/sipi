<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
ob_start();

include ("../z_includes.php");

//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
	
//Class Extention for header and footer	
require_once("$include_lib/header_footer.inc");

//variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$vsol=$_GET["vsol"];
//$varsol1=$_POST["vsol1"];
//$varsol2=$_POST["vsol2"];
//$varreg1=$_POST["vreg1"];
//$varreg2=$_POST["vreg2"];
$nconex = $_POST['nconex'];

$varsol1=$_POST["vsol1"];
if (empty($varsol1)) {$varsol1=$_GET["vsol1"];}
$varsol2=$_POST["vsol2"];
if (empty($varsol2)) {$varsol2=$_GET["vsol2"];}
$varreg1=$_POST["vreg1"];
if (empty($varreg1)) {$varreg1=$_GET["vreg1"];}
$varreg2=$_POST["vreg2"];
if (empty($varreg2)) {$varreg2=$_GET["vreg2"];}

//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Cronologia Administrativa');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Cronologia Administrativa";

$varreg= $varreg1.$varreg2;
//$varsol=($varsol1.'-'.$varsol2);
if (empty($vsol)) {
$varsol=($varsol1.'-'.$varsol2);} else { $varsol=$vsol;}

// Verificacion de que los campos requeridos esten llenos...
  if (($varsol=='-') and ($varreg=='')) {
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!",'p_rptpcronol.php?conx=1&salir=1','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
if(!empty($varsol) and ($varsol!='-')) {
   $resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='P' 
		        AND b.solicitud= '$varsol' and b.solicitud!=''");
   $titulo= $titulo." Solicitud:"." $varsol"; 	
}
else {
if(!empty($varreg)) { 
   $resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='P' 
		        AND b.registro= '$varreg' and b.registro!=''");
   $titulo= $titulo." Registro:"." $varreg";
}
}
//verificando los resultados
if (!$resultado) 
   { 
     mensajenew('ERROR AL PROCESAR LA BUSQUEDAD ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit();  
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) 
   {
     mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit(); 
   } 

$reg = pg_fetch_array($resultado);

 $nderec=$reg['nro_derecho'];
 $varsol=$reg['solicitud'];
 $nregis=$reg['registro'];
 $nagen =$reg['agente'];
 $poder =$reg['poder'];

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
//echo "varsol1: $varsol1";
//echo "varsol2: $varsol2";
//$nameimage=ver_imagen($varsol1,$varsol2,'P');
$nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
//echo $nameimage;

$descripcion=estatus($reg['estatus']);

$pais_nombre=pais($reg['pais_resid']);

$cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
$cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
$cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
$cons_palc=pg_exec("SELECT * FROM stppacld WHERE nro_derecho='$nderec'");

$reg_inv = pg_fetch_array($cons_inv);
   $filas_cons_inv=pg_numrows($cons_inv); 
$regclasf = pg_fetch_array($cons_clas);
   $filas_clasif=pg_numrows($cons_clas); 
$reg_clasl = pg_fetch_array($cons_clasl);
   $filas_cons_clasl=pg_numrows($cons_clasl);
$reg_pri = pg_fetch_array($cons_pri);
   $filas_cons_pri=pg_numrows($cons_pri);


$vtip=tipo_patente($reg['tipo_paten']);

//Incio de la Clase de PDF para generar los reportes
//$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->AliasNbPages();

//imagen
if (file($nameimage)) 
   {
   $pdf->SetFillColor(192);
   $pdf->RoundedRect(175, 8, 33, 30, 3.5, 'D');
   $pdf->Image("$nameimage",176,10,30,25,'JPG');
   }

    $pdf->ln(2);
    $pdf->Cell(15,5,'Solicitud:',0,0); 
    $pdf->Cell(100,5,$varsol,0,0);
    $pdf->Cell(30,5,'Fecha de Solicitud:',0,0);
    $pdf->Cell(100,5,$reg['fecha_solic'],0,1);
    $pdf->Cell(25,5,'Tipo de Patente:',0,0);
    //$pdf->Cell(90,5,$reg['tipo_paten'].'-'.utf8_decode($vtip),0,0);
    $pdf->Cell(90,5,$reg['tipo_paten'].'-'.$vtip,0,0);
//    $pdf->Cell(15,5,'Pais:',0,0);
//    $pdf->Cell(100,5,$reg['pais_resid'].'-'.trim(utf8_decode($pais_nombre)),0,1);    

    $pdf->Cell(30,5,'Num. de Registro:',0,0);
    $pdf->Cell(85,5,$reg['registro'],0,1);

    $pdf->Cell(30,5,'Fecha de Registro:',0,0);
    $pdf->Cell(85,5,$reg['fecha_regis'],0,0);

    $pdf->Cell(35,5,'Fecha de Vencimiento:',0,0);
    $pdf->Cell(80,5,$reg['fecha_venc'],0,1); 

    $pdf->MultiCell(0,4,'Estatus: '.($reg['estatus']-2000).' '.$descripcion,0,1);  
    $pdf->ln(1); 
    /*
    $pdf->Cell(15,8,'Titulo:',0,0);
    $pdf->MultiCell(0,4,utf8_decode($reg['nombre']),0,'J');
    $pdf->ln(2); 
    */
    $pdf->MultiCell(0,4,'Titulo: '.utf8_decode($reg['nombre']),0,1); 
    $pdf->ln(2);
    //$pdf->Cell(30,5,'Tramitante/Agente:',0,0);
    //$tram = agente_tram($nagen,$reg['tramitante']);
    //$pdf->MultiCell(0,4, utf8_decode($tram),0,1);
    //Busqueda de tramitante y varios agentes
   //$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente = '$nagen'");
	$regage = pg_fetch_array($res_agen);
	//echo $regage['agente'];
	///if ($regage['agente']<= 0)
   //        { $tram = trim($reg['tramitante']); }
	//if ($regage['agente']> 0)
	//   {$tram= "Codigo: ".$regage['agente']." ".trim(utf8_decode($regage['nombre']));
	//    $res_agen1=pg_exec("SELECT stzagenr.agente, stzagenr.nombre  FROM stzautod,stzagenr WHERE stzautod.nro_derecho ='$nderec' and stzagenr.agente = stzautod.agente");
	//    $regage1 = pg_fetch_array($res_agen1);
	//    $filas_found_agen=pg_numrows($res_agen1);
	//    if ($filas_found_agen <> 0){
	//     for ($j=0; $j<$filas_found_agen; $j++){
	//	if ($regage1['agente'] == $regage['agente']){$regage1 = pg_fetch_array($res_agen1);}
	//	else{
 	//	   $tram= $tram."  /   Codigo: ".$regage1['agente']." ".trim(utf8_decode($regage1['nombre']));}
	//	$regage1 = pg_fetch_array($res_agen1);
	//     }
   //         }
	//}
   $tram = agente_tramp($nagen,$reg[tramitante],$poder);
	if (empty($poder)) { $pdf->MultiCell(0,4,'Poder/Tramitante/Agente:  '.utf8_decode($tram),0,1); }
	else { $pdf->MultiCell(0,4,'Poder/Tramitante/Agente:  '.$poder.':  '.utf8_decode($tram),0,1); }
	//$pdf->MultiCell(0,4,$tram,0,1);
   $pdf->ln(1);      	   

//Inventores	 
	 for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) { 
            $inv= $inv.trim(utf8_decode($reg_inv['nombre_inv'])).'; ';
   	    $reg_inv = pg_fetch_array($cons_inv);
	}
         $pdf->ln(2); 
         $pdf->MultiCell(0,4,'Inventores: '.$inv,0,'J');
         $pdf->ln(1); 

//Clasificacion Internacional
	 for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
	    $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
	    $regclasf = pg_fetch_array($cons_clas);
	}
         $pdf->ln(1); 
         $pdf->MultiCell(0,4,'Clasif.Internacional: '.$clasi,0,'J');

//Locarno
	 for($cont_loc=0;$cont_loc<$filas_cons_clasl;$cont_loc++) { 
	      $locarn=$locarn.trim($reg_clasl['clasi_locarno']).'; ';
		$reg_clasl = pg_fetch_array($cons_clasl);
         }
         $pdf->ln(1); 
         $pdf->MultiCell(0,4,'Locarno: '.$locarn,0,'J');

//Prioridad
	 for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	    $prioridad=$prioridad.trim($reg_pri['prioridad']).'; ';
            $reg_pri = pg_fetch_array($cons_pri);
	}

         $pdf->ln(1); 
         $pdf->MultiCell(0,4,'Prioridad: '.$prioridad,0,'J');
         $pdf->ln(3); 

// Resumen
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
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Resumen");
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
      		$data[0]['TEXT'] = utf8_decode(trim($reg['resumen']));
		$pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();	
	//draw the Table Border
	$pdf->tbDrawBorder();
	$pdf->Ln(6);


// Buscando los titulares de la solicitud
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>TITULARES DE LA PATENTE</s1>", 0);

	require("$include_path/tablas_def.inc");

	$columns = 5; //number of Columns
	
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
		$aSimpleHeader[$i]['WIDTH'] = 65;
                $i=3;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("País Domicilio ");
		$aSimpleHeader[$i]['WIDTH'] = 25;
                $i=4;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Nacionalidad ");
		$aSimpleHeader[$i]['WIDTH'] = 25;


	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);


$result = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular ");

$filas_found_tit=pg_numrows($result);

	for ($j=0; $j<$filas_found_tit; $j++)
	{
		$res = pg_fetch_array($result);
		$data = Array();
		$data[0]['TEXT'] = trim($res['titular']);
		$data[1]['TEXT'] = trim(utf8_decode($res['nombre']));
		$pais_nombre=pais($res['nacionalidad']);
		$pais_nombred=pais($res['pais_domicilio']);
		$data[2]['TEXT'] = trim(utf8_decode($res['domicilio']));
		$data[3]['TEXT'] = trim($res['pais_domicilio']."-".utf8_decode($pais_nombred));
		$data[4]['TEXT'] = trim($res['nacionalidad']."-".utf8_decode($pais_nombre));
		$pdf->tbDrawData($data);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
         $pdf->ln(6); 


//Anualidades de la Patente
$resul_anu=pg_exec("SELECT * FROM stpanual,stzderec WHERE stpanual.nro_derecho='$nderec'  AND stzderec.tipo_mp='P' AND stpanual.nro_derecho=stzderec.nro_derecho ORDER BY stpanual.anualidad");
$filas_anu=pg_numrows($resul_anu); 

if ($filas_anu > 0) {
//dibujando tabla de anualidades
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s1","arial","",9);
	$pdf->MultiCellTag(100, 4, "<s1>ANUALIDADES PAGADAS DE LA SOLICITUD</s1>", 0);

	$bTableSplitMode = true;

	require("$include_path/tablas_def.inc");

	$columns = 6; //number of Columns
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	$aSimpleHeader = array();
	
	//Table Header
 		$i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Anualidad";
		$aSimpleHeader[$i]['WIDTH'] = 35;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Fecha Anualidad ");
		$aSimpleHeader[$i]['WIDTH'] = 40;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Planilla ";
		$aSimpleHeader[$i]['WIDTH'] = 25;
                $i=3;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Tasa ";
		$aSimpleHeader[$i]['WIDTH'] = 30;
                $i=4		;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Monto ";
		$aSimpleHeader[$i]['WIDTH'] = 25;
                $i=5		;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Multa ";
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

	for ($j=0; $j<$filas_anu; $j++)
	{
		$reg_anu = pg_fetch_array($resul_anu);
		$data = Array();
      		$data[0]['TEXT'] = $reg_anu['anualidad'];
		$data[1]['TEXT'] = $reg_anu['fecha_anual'];
	        $data[2]['TEXT'] = $reg_anu['planilla'];
		$data[3]['TEXT'] = $reg_anu['tasa'];
	        $data[4]['TEXT'] = $reg_anu['monto'];
      	        $data[5]['TEXT'] = $reg_anu['multa'];
		$pdf->tbDrawData($data);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

         $pdf->ln(6); 	
} 



// Buscando la Cronologia de la Solicitud
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
		$aSimpleHeader[$i]['TEXT'] = "Doc.";
		$aSimpleHeader[$i]['WIDTH'] = 10;
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
		$aSimpleHeader[$i]['WIDTH'] = 45;
	
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

$result_cronol=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' order by fecha_event,secuencial");   
   $filas_found_cronol=pg_numrows($result_cronol);

	for ($j=0; $j<$filas_found_cronol; $j++)
	{
		$reg_cronol = pg_fetch_array($result_cronol);
		$data = Array();
      		$data[0]['TEXT'] = $reg_cronol['fecha_event'];
		$data[1]['TEXT'] = $reg_cronol['fecha_trans'];
	        $data[2]['TEXT'] = trim($reg_cronol['usuario']);
		$data[3]['TEXT'] = $reg_cronol['documento'];
	        $data[4]['TEXT'] = ($reg_cronol['evento']-2000);
	        $data[5]['TEXT'] = trim(sprintf(utf8_decode($reg_cronol['desc_evento'])));
	        $data[6]['TEXT'] = trim(sprintf(utf8_decode($reg_cronol['comentario'])));
		$pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

         $pdf->ln(6); 
         

 
//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 
$pdf->Output();

?>

