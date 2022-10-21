<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

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

//Encabezados de pantalla
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Consulta Abierta de Patentes');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Consulta de Expedientes de Solicitudes de Patentes";

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$nconex = $_POST['nconex'];

$varsol=$varsol1.'-'.$varsol2;
$varsolh=$varsol1h.'-'.$varsol2h;

// Verificacion de que los campos requeridos esten llenos...
  if (($varsol=='-') and ($varsolh=='-')) {
     mensajenew("AVISO: Hay Informacion asociada que esta Vacia ...!!!",'javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if ($varsolh <$varsol){ 
     mensajenew('AVISO: RANGO DE SOLICITUDES ERRONEO ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
if (!empty($varsol) and !empty($varsolh) and ($varsol!='-') and ($varsolh!='-')) {
   $resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND b.tipo_mp='P' 
		        AND b.solicitud between '$varsol' and '$varsolh' ORDER BY b.solicitud");

   $titulo= $titulo." Solicitud Inicial:"." $varsol"." Hasta: "." $varsolh"; 	
}

//verificando los resultados
if (!$resultado)    { 
     mensajenew('ERROR AL PROCESAR LA BUSQUEDAD ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit();  }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit();  }  

$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);   

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->AliasNbPages();

for($cont=0;$cont<$filas_found;$cont++) 
{
 $nderec=$reg['nro_derecho'];
 $varsol=$reg['solicitud'];
 $nregis=$reg['registro'];
 $nagen=$reg['agente'];
 $poder=trim($reg['poder']);

 $clasi='';
 $locarn='';
 $apuntador='';
 $palabras='';

//imagen
$varsol1=substr($varsol1,-11,4);
$varsol2=substr($varsol2,-6,6);
$nameimage=ver_imagen($varsol1,$varsol2,'P');

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
$reg_tit = pg_fetch_array($cons_tit);
   $filas_cons_tit=pg_numrows($cons_tit);
$reg_palc = pg_fetch_array($cons_palc);
   $filas_cons_palc=pg_numrows($cons_palc);

$vtip=tipo_patente($reg['tipo_paten']);

//imagen
if (file($nameimage)) 
   {
   $pdf->SetFillColor(192);
   $pdf->RoundedRect(178, 22, 33, 30, 5, '', '13');
   $pdf->Image("$nameimage",180,25,30,25,'JPG');
   }

   //Imprimiendo los resultados   
    $pdf->ln(2);
    $pdf->Cell(15,5,'Solicitud:',0,0); 
    $pdf->Cell(100,5,$varsol,0,0);
    $pdf->Cell(30,5,'Fecha de Solicitud:',0,0);
    $pdf->Cell(100,5,$reg['fecha_solic'],0,1);
    $pdf->Cell(25,5,'Tipo de Patente:',0,0);
    $pdf->Cell(90,5,$reg['tipo_paten'].'-'. utf8_decode($vtip),0,0);
//    $pdf->Cell(15,5,'Pais:',0,0);
//    $pdf->Cell(100,5,$reg['pais_resid'].'-'.trim($pais_nombre),0,1);    
     $pdf->Cell(30,5,'Num. de Registro:',0,0);
    $pdf->Cell(85,5,$reg['registro'],0,0);
    $pdf->Cell(30,5,'Fecha de Registro:',0,0);
    $pdf->Cell(80,5,$reg['fecha_regis'],0,1);
    $pdf->Cell(35,5,'Fecha de Vencimiento:',0,0);
    $pdf->Cell(80,5,$reg['fecha_venc'],0,0);  
    $pdf->MultiCell(0,4,'Estatus: '.($reg['estatus']-2000).' '.$descripcion,0,1); 
    $pdf->ln(1); 
    $pdf->Cell(15,5,'Titulo:',0,0);
    $pdf->MultiCell(0,4, utf8_decode($reg['nombre']),0,'J');
    $pdf->ln(2);
    //$pdf->Cell(30,5,'Tramitante/Agente(s):',0,0);
//    $tram = agente_tram($nagen,$reg['tramitante']);
//    $pdf->MultiCell(0,4, utf8_decode($tram),0,1);
//   Busqueda de tramitante y varios agentes
    //$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente = '$nagen'");
	 //$regage = pg_fetch_array($res_agen);
	 //echo $regage['agente'];
	 //if ($regage['agente']<= 0)
    //       { $tram = trim($reg['tramitante']); }
	 //if ($regage['agente']> 0)
	 //  {$tram= "Codigo: ".$regage['agente']." ".trim(utf8_decode($regage['nombre']));
	 //   $res_agen1=pg_exec("SELECT stzagenr.agente, stzagenr.nombre  FROM stzautod,stzagenr WHERE stzautod.nro_derecho ='$nderec' and stzagenr.agente = stzautod.agente");
	 //   $regage1 = pg_fetch_array($res_agen1);
	 //   $filas_found_agen=pg_numrows($res_agen1);
	 //   if ($filas_found_agen <> 0){
	 //    for ($j=0; $j<$filas_found_agen; $j++){
	//	if ($regage1['agente'] == $regage['agente']){$regage1 = pg_fetch_array($res_agen1);}
	//	else{
 	//	   $tram= $tram."  /   Codigo: ".$regage1['agente']." ".trim(utf8_decode($regage1['nombre']));}
	//	$regage1 = pg_fetch_array($res_agen1);
	 //    }
    //        }
	 //}
	//$pdf->MultiCell(0,4,$tram,0,1);
	$tram = agente_tramp($nagen,$reg[tramitante],$poder);
	if (empty($poder)) { $pdf->MultiCell(0,4,'Poder/Tramitante/Agente(s):  '.utf8_decode($tram),0,1); }
	else { $pdf->MultiCell(0,4,'Poder/Tramitante/Agente(s):  '.$poder.':  '.utf8_decode($tram),0,1); }

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

//Palabras Claves
	 for($cont_palc=0;$cont_palc<$filas_cons_palc;$cont_palc++) { 
	    $apuntador = $reg_palc['apuntador'];
            $cons_clave=pg_exec("SELECT * FROM stptesar WHERE apuntador='$apuntador'");
	    $reg_clave = pg_fetch_array($cons_clave);
	    $palabras=$palabras.trim($reg_clave['palabra']).';  ';
	    $reg_palc = pg_fetch_array($cons_palc);
	}

         $pdf->ln(1); 
         $pdf->MultiCell(0,4,'Palabras Claves: '.$palabras,0,'J');
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
      		$data[0]['TEXT'] = utf8_decode($reg['resumen']);
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
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("País Domicilio");
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
                     AND stzsolic.titular = stzottid.titular");

$filas_found_tit=pg_numrows($result);

	for ($j=0; $j<$filas_found_tit; $j++)
	{
		$res = pg_fetch_array($result);
		$data = Array();
		$data[0]['TEXT'] = trim($res['titular']);
		$data[1]['TEXT'] = utf8_decode(trim($res['nombre']));
		$pais_nombre=pais($res['nacionalidad']);
          $pais_nombred=pais($res['pais_domicilio']);
		$data[2]['TEXT'] = utf8_decode(trim($res['domicilio']));
		$data[3]['TEXT'] = trim($res['pais_domicilio']."-".$pais_nombred);
		$data[4]['TEXT'] = trim($res['nacionalidad']."-".$pais_nombre);
		$pdf->tbDrawData($data);

	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

$pdf->ln(3);
$pdf->SetFont('Arial','',9);
// Buscando los inventores de la solicitud
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>INVENTORES DE LA PATENTE</s1>", 0);

	require("$include_path/tablas_def.inc");

	$columns = 2; //number of Columns
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	
	$aSimpleHeader = array();
	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Inventor ");
		$aSimpleHeader[$i]['WIDTH'] = 95;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Nacionalidad/País ");
		$aSimpleHeader[$i]['WIDTH'] = 95;
             
	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

	//for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) { 
	for ($j=0; $j<$filas_cons_inv; $j++)
	{
		
		$data = Array();
		$data[0]['TEXT'] = trim($reg_inv['nombre_inv']);
		$pais_nombre=pais($reg_inv['nacionalidad']);
		$data[1]['TEXT'] = trim($reg_inv['nacionalidad']."-".$pais_nombre);
		$pdf->tbDrawData($data);
		$reg_inv = pg_fetch_array($cons_inv);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

$pdf->ln(3);
$pdf->SetFont('Arial','',9);

// Buscando las licencias de la solicitud
//load the table default definitions DEFAULT!!!
$res_reg_lic=pg_exec("SELECT * FROM stzliced WHERE nro_derecho='$nderec'");
$filas_found_reglic =pg_numrows($res_reg_lic);
if ($filas_found_reglic!=0) { 
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>LICENCIAS DE LA PATENTE</s1>", 0);

	require("$include_path/tablas_def.inc");

	$columns = 4; //number of Columns
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);	
	
	$aSimpleHeader = array();
	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Num. Licencia");
		$aSimpleHeader[$i]['WIDTH'] = 30;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Licenciatario ";
		$aSimpleHeader[$i]['WIDTH'] = 100;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Fecha Licencia ";
		$aSimpleHeader[$i]['WIDTH'] = 30;
                $i=3;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Fecha Vencimiento ";
		$aSimpleHeader[$i]['WIDTH'] = 30;

	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

	for ($j=0; $j<$filas_found_reglic; $j++)
	{
	        $reg_reglic = pg_fetch_array($res_reg_lic);  
		$data = Array();
		$data[0]['TEXT'] = trim($reg_reglic['licencia']);
		$data[1]['TEXT'] = trim($reg_reglic['nombre_licen']);
		$data[2]['TEXT'] = trim($reg_reglic['fecha_licen']);
		$data[3]['TEXT'] = trim($reg_reglic['fecha_venc']);
		$pdf->tbDrawData($data);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->Ln(6); 
}

// Prioridades asociados a la solicitud 
//load the table default definitions DEFAULT!!!

$res_reg_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'" );
$filas_found_regpri  =pg_numrows($res_reg_pri);
if ($filas_found_regpri!=0) { 
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>PRIORIDADES DE LA PATENTE</s1>", 0);

	require("$include_path/tablas_def.inc");

	$columns = 3; //number of Columns

	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type
	$pdf->tbSetTableType($table_default_table_type);
	
	$aSimpleHeader = array();
	
	//Table Header
                $i=0;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Prioridad ";
		$aSimpleHeader[$i]['WIDTH'] = 35;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("País ");
		$aSimpleHeader[$i]['WIDTH'] = 120;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Fecha ";
		$aSimpleHeader[$i]['WIDTH'] = 35;

	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);


	for ($j=0; $j<$filas_found_regpri ; $j++)
	{
 		$reg_regpri = pg_fetch_array($res_reg_pri);  
		$data = Array();
      		$data[0]['TEXT'] = $reg_regpri['prioridad'];
      		$data[1]['TEXT'] = $reg_regpri['pais_priori'];
      		$data[2]['TEXT'] = $reg_regpri['fecha_priori'];
		$pdf->tbDrawData($data);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->Ln(6); 
}

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

$pdf->SetFont('Arial','',9);  

$reg = pg_fetch_array($resultado);
if  ($cont+1!=$filas_found) {$pdf->AddPage();}

}
   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
