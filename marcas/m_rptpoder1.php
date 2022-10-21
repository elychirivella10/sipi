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

//Conexion
$sql = new mod_db();
$sql->connection();

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado de Poderes";

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Listado de Poderes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$desde1=$_POST["desde1"];
$desde2=$_POST["desde2"];
$hasta1=$_POST["hasta1"];
$hasta2=$_POST["hasta2"];
$nconex = $_POST['nconex'];
$desdet=$_POST["desdet"];
$hastat=$_POST["hastat"];

// Verificacion de que los campos requeridos esten llenos...
//  $req_fields = array("desde1","desde2","hasta1","hasta2");
//  $valores = array($desde1,$desde2,$hasta1,$hasta2);
//  $vacios = check_empty_fields();
//  if (!$vacios) { 
//     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
//     $smarty->display('pie_pag.tpl'); exit(); }

$desde=($desde1.'-'.$desde2);
$hasta=($hasta1.'-'.$hasta2);

//Verificacion del rango de poderes
if ($hasta <$desde){ 
     mensajenew('Rango de Poderes No Valido...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit(); }

$esmayor=compara_fechas($desdet,$hastat);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if ($desde=='-') {
pg_exec("CREATE TEMPORARY TABLE tabla (poder,fecha,facultad,titular,nombre) as 
  			SELECT a.poder, a.fecha_poder, a.facultad, b.nombre, c.nombre
			     FROM stzpoder a, stzsolic b, stzagenr c, stzpohad d
			     WHERE a.fecha_trans BETWEEN '$desdet' AND '$hastat' AND
			           a.poder = d.poder AND
			           a.titular = b.titular AND
				   d.poderhabi = c.agente 
			     ORDER BY poder, c.nombre ");
}
else {
pg_exec("CREATE TEMPORARY TABLE tabla (poder,fecha,facultad,titular,nombre) as 
  			SELECT a.poder, a.fecha_poder, a.facultad, b.nombre, c.nombre
			     FROM stzpoder a, stzsolic b, stzagenr c, stzpohad d
			     WHERE a.poder BETWEEN '$desde' AND '$hasta' AND
			           a.poder = d.poder AND
			           a.titular = b.titular AND
				   d.poderhabi = c.agente 
			     ORDER BY poder, c.nombre ");
}
$resultado=pg_exec("select * from tabla order by poder");

//verificando los resultados
if (!$resultado)    { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit();    }$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('No Existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit();    } 

$resul_total=pg_exec("SELECT DISTINCT ON(poder) *
			   FROM tabla
			   order by poder");	

//$filas_resultado=pg_numrows($resultado);
$regtotal = pg_fetch_array($resul_total);
$filas_total=pg_numrows($resul_total); 
$total= "Total de Poderes: ".$filas_total;

$registro = pg_fetch_array($resultado);

$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf

$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 
$pdf->Ln(4);
// Formateando los Poderes
//load the table default definitions DEFAULT!!!
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
	$pdf->SetStyle("s1","arial","",9,"118,0,3"); //Cambia a color marron
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
		$aSimpleHeader[$i]['TEXT'] = utf8_decode("Poder ");
		$aSimpleHeader[$i]['WIDTH'] = 15;
                $i=1;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Fecha ";
		$aSimpleHeader[$i]['WIDTH'] = 15;
                $i=2;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Faculta ";
		$aSimpleHeader[$i]['WIDTH'] = 15;
                $i=3;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Titular ";
		$aSimpleHeader[$i]['WIDTH'] = 75;
                $i=4;
		$aSimpleHeader[$i] = $table_default_header_type;
		$aSimpleHeader[$i]['TEXT'] = "Nombre ";
		$aSimpleHeader[$i]['WIDTH'] = 70;

	//set the Table Header
	$pdf->tbSetHeaderType($aSimpleHeader);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$aDataType = Array();
	for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

	$pdf->tbSetDataType($aDataType);

$valor= $registro['poder'];
$ind=1;
$blanco='';
	for ($j=0; $j<$filas_found; $j++)
	{
	    if (($valor!= $registro['poder']) or ($ind=='1')) {
		$data = Array();
		$data[0]['BRD_COLOR'] = array(255, 255, 255);
		$data[0]['TEXT'] = $registro['poder'];
		$data[1]['BRD_COLOR'] = array(255, 255, 255);
		$data[1]['TEXT'] = $registro['fecha'];
		$data[2]['BRD_COLOR'] = array(255, 255, 255);
		$data[2]['TEXT'] = $registro['facultad'];
		$data[3]['BRD_COLOR'] = array(255, 255, 255);
		$data[3]['TEXT'] = substr(utf8_decode($registro['titular']),0,32);
		$data[4]['BRD_COLOR'] = array(255, 255, 255);
		$data[4]['TEXT'] = trim(utf8_decode($registro['nombre']));
	        $ind=0;
	    }
	    else {
		//$data = Array();
		$data[0]['BRD_COLOR'] = array(255, 255, 255);
		$data[0]['TEXT'] = $blanco;
		$data[1]['BRD_COLOR'] = array(255, 255, 255);
		$data[1]['TEXT'] = $blanco;
		$data[2]['BRD_COLOR'] = array(255, 255, 255);
		$data[2]['TEXT'] = $blanco;
		$data[3]['BRD_COLOR'] = array(255, 255, 255);
		$data[3]['TEXT'] = $blanco;
		$data[4]['BRD_COLOR'] = array(255, 255, 255);
		$data[4]['TEXT'] = trim(utf8_decode($registro['nombre']));
	    }
	    $registro = pg_fetch_array($resultado);
	    if ($valor!= $registro['poder']){ $valor= $registro['poder']; $ind=1; }
            $pdf->tbDrawData($data);
	}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();

	$pdf->Ln(6);
     
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 

$pdf->Output();

?>
