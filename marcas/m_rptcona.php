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
//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Consulta de Expedientes de Solicitudes de Marcas";
//$linea="___________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Consulta Abierta de Marcas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol1h=$_POST["vsol1h"];
$varsol2h=$_POST["vsol2h"];
$nconex = $_POST['nconex'];

//Formateando los campos solicitud y registro
$varsol= $varsol1.'-'.$varsol2;
$varsolh= $varsol1h.'-'.$varsol2h;

// Verificacion de que los campos requeridos esten llenos...
  if (($varsol=='0000-000000') and ($varsolh=='0000-000000')) {
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!",'javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

// Verificacion que el rango de solicitud este correcto
if ($varsolh <$varsol){ 
     mensajenew('Rango de Solicitudes Erroneo ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas
if (($varsol!='-0') and ($varsolh!='-0')) {
   $resultado=pg_exec("SELECT  clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stmmarce a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='M' 
		        AND b.solicitud between '$varsol' and '$varsolh' ORDER BY b.solicitud");
   $titulo= $titulo." Solicitud Inicial:"." $varsol"." Hasta: "." $varsolh"; 	
}

//verificando los resultados
if (!$resultado)    { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     echo "<br><br>";   
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }  
$reg = pg_fetch_array($resultado);

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->AliasNbPages(); 

$smarty->assign('n_conex',$nconex);  
//Inicio de ciclo 

for($cont=0;$cont<$filas_found;$cont++) 
{

$varsol=$reg['solicitud'];
$nregis=$reg['registro'];
$nagen=$reg['agente'];
$nderec=$reg['nro_derecho'];

//Busqueda de Tablas necesarias

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$nameimage=ver_imagen($varsol1,$varsol2,'M');

$descripcion=estatus($reg['estatus']);

$pais_nombre=pais($reg['pais_resid']);

$vmod=modalida_marca($reg['modalidad']);

$vtip=tipo_marca($reg['tipo_marca']);

$vcla=ind_clase($reg['ind_claseni']);

$vporc='83%';
if ($reg['modalidad']!="D")
   {$vporc='55%';} 

//imagen
if (file($nameimage)) 
   {
   $pdf->SetFillColor(192);
   $pdf->RoundedRect(175, 38, 33, 30, 3.5, 'D');
   $pdf->Image("$nameimage",176,40,30,25,'JPG');
   }

    $pdf->Cell(10,5,$ruta,0,0); 
    //Imprimiendo los resultados    
    //Muestra campos principales de la cronologia
    $pdf->SetFont("arial","",9,"0,49,159"); //Cambia a color negro	
    $pdf->ln(2);
    $pdf->Cell(15,5,'Solicitud:',0,0); 
    $pdf->Cell(100,5,$varsol,0,0);
    $pdf->Cell(30,5,'Fecha de Solicitud:',0,0);
    $pdf->Cell(100,5,$reg['fecha_solic'],0,1);
    $pdf->Cell(25,5,'Tipo de Marca:',0,0);
    $pdf->Cell(90,5,$reg['tipo_marca'].'-'.$vtip,0,0);
    $pdf->Cell(20,5,'Modalidad:',0,0);
    $pdf->Cell(100,5,$reg['modalidad'].'-'.$vmod,0,1);    
    $pdf->Cell(30,5,'Pais de Residencia:',0,0);
    $pdf->Cell(85,5,$reg['pais_resid'].'-'.trim($pais_nombre),0,0);
    $pdf->Cell(15,5,'Clase:',0,0);
    $pdf->Cell(100,5,$reg['clase'].'-'.$vcla,0,1);    
    $pdf->Cell(30,5,'Num. de Registro:',0,0);
    $pdf->Cell(85,5,$reg['registro'],0,0);
    $pdf->Cell(30,5,'Fecha de Registro:',0,0);
    $pdf->Cell(80,5,$reg['fecha_regis'],0,1);
    $pdf->Cell(35,5,'Fecha de Vencimiento:',0,0);
    $pdf->Cell(80,5,$reg['fecha_venc'],0,0);  
    $pdf->MultiCell(0,4,'Estatus: '.($reg['estatus']-1000).' '.$descripcion,0,1); 
    $pdf->Cell(15,5,'Nombre:',0,0); 
    $pdf->Cell(20,5,utf8_decode($reg['nombre']),0,1);
    $pdf->Cell(30,5,'Tramitante/Agente:',0,0);
    //    $tram = agente_tram($nagen,$reg['tramitante']);
    //	$pdf->Cell(20,5,$tram,0,1);
//   Busqueda de tramitante y varios agentes
        $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente = '$nagen'");
	$regage = pg_fetch_array($res_agen);
	echo $regage['agente'];
	if ($regage['agente']<= 0)
           { $tram = trim($reg['tramitante']); }
	if ($regage['agente']> 0)
	   {$tram= "Codigo: ".$regage['agente']." ".trim(utf8_decode($regage['nombre']));
	    $res_agen1=pg_exec("SELECT stzagenr.agente, stzagenr.nombre  FROM stzautod,stzagenr WHERE stzautod.nro_derecho ='$nderec' and stzagenr.agente = stzautod.agente");
	    $regage1 = pg_fetch_array($res_agen1);
	    $filas_found_agen=pg_numrows($res_agen1);
	    if ($filas_found_agen <> 0){
	     for ($j=0; $j<$filas_found_agen; $j++){
		if ($regage1['agente'] == $regage['agente']){$regage1 = pg_fetch_array($res_agen1);}
		else{
 		   $tram= $tram."  /   Codigo: ".$regage1['agente']." ".trim(utf8_decode($regage1['nombre']));}
		$regage1 = pg_fetch_array($res_agen1);
	     }
            }
	}
	$pdf->MultiCell(0,4,$tram,0,1);


    $pdf->Cell(15,5,'Poder:',0,0);
    $pdf->Cell(20,5,$reg['poder'],0,1);
    $pdf->Ln(3);		

	// Distingue
	require("$include_path/tablas_def.inc");
	$columns = 1; //number of Columns	//Initialize the table class
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
      		$data[0]['TEXT'] = utf8_decode($reg['distingue']);
		$pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();	
	//draw the Table Border
	$pdf->tbDrawBorder();
	$pdf->Ln(6);

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

//$res = pg_fetch_array($result);
$filas_found_tit=pg_numrows($result);

	for ($j=0; $j<$filas_found_tit; $j++)
	{
		$res = pg_fetch_array($result);
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

	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->Ln(6);

// Buscando las licencias de la solicitud
//load the table default definitions DEFAULT!!!

$res_reg_lic=pg_exec("SELECT * FROM stzliced WHERE nro_derecho='$nderec'");
$filas_found_reglic =pg_numrows($res_reg_lic);
if ($filas_found_reglic!=0) { 
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>LICENCIAS DE LA MARCA</s1>", 0);

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

// Lemas asociados a la solicitud 
//load the table default definitions DEFAULT!!!

$res_lema=pg_exec("SELECT * FROM stmlemad WHERE nro_derecho='$nderec'");
$filas_found_reglem =pg_numrows($res_lema);
if ($filas_found_reglem!=0) { 
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron

	$pdf->MultiCellTag(100, 4, "<s1>LEMAS DE LA MARCA</s1>", 0);

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
		$aSimpleHeader[$i]['TEXT'] = "Solicitud";
		$aSimpleHeader[$i]['WIDTH'] = 25;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Nombre del Lema asociado a la solicitud ";
		$aSimpleHeader[$i]['WIDTH'] = 165;

	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);
	if ($reg_reglem['solicitud_aso']==0) {
   	  for ($j=0; $j<$filas_found_reglem; $j++)
	  {
		$reg_reglem = pg_fetch_array($res_lema);  
		$data = Array();
		$data[0]['TEXT'] = $reg_reglem['registro_aso'];
      		$res_reg_lem1=pg_exec("SELECT nombre FROM  stzderec 
                        WHERE registro='$reg_reglem[registro_aso]' AND tipo_mp='M' ");
      		$reg_reglem1 = pg_fetch_array($res_reg_lem1);
		$data[1]['TEXT'] = trim($reg_reglem1['nombre']);
		$pdf->tbDrawData($data);
	  }}
        else {
   	  for ($j=0; $j<$filas_found_reglem; $j++)
	  {
		$reg_reglem = pg_fetch_array($res_lema);  
		$data = Array();
		$data[0]['TEXT'] = $reg_reglem['solicitud_aso'];
      		$res_reg_lem1=pg_exec("SELECT nombre FROM  stzderec  
                        WHERE solicitud='$reg_reglem[solicitud_aso]' AND tipo_mp='M' ");
      		$reg_reglem1 = pg_fetch_array($res_reg_lem1);
		$data[1]['TEXT'] = trim($reg_reglem1['nombre']);
		$pdf->tbDrawData($data);
	  }}
	
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

	$pdf->MultiCellTag(100, 4, "<s1>PRIORIDADES DE LA MARCA</s1>", 0);

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
		$aSimpleHeader,	);

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
	        $data[4]['TEXT'] = ($reg_cronol['evento']-1000);
	        $data[5]['TEXT'] = trim(sprintf($reg_cronol['desc_evento']));
	        $data[6]['TEXT'] = trim(sprintf($reg_cronol['comentario']));
		$pdf->tbDrawData($data);
	}

	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

$reg = pg_fetch_array($resultado);
if  ($cont+1!=$filas_found) {$pdf->AddPage();}
}
   
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
