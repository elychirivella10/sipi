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
require_once("$include_lib/header_footer_planilla.inc");

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
$encab_principal= "";
$encabezado= "Solicitud Planilla Busqueda";
$linea="_________________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitud Planilla Busqueda');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$cantidad=$_POST["nbusfon"];
$factura=$_POST["factura"];
$fechafac=$_POST["fechadep"];
$sede = $_POST["vsede"];
$horactual = Hora();
$fechahoy = hoy();
$tbname_1 = "stzplanfac";
$tbname_2 = "stzsystem";
$tbname_3 = "stmfactura";
$tbname_4 = "stzplanexo";

//Verificacion de factura en stzplanfac
$resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_factura='$factura'");
if (!$resultado) { 
  mensajenew("ERROR: PROBLEMA AL PROCESAR LA CONSULTA DE LA FACTURA ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
$filas_found=pg_numrows($resultado); 
if ($filas_found!=0) {
  $regfac = pg_fetch_array($resultado);
  $cant   = $regfac[cant_plan];
  $nplan1 = $regfac[nplanilla1];
  $nplan2 = $regfac[nplanilla2];
  mensajenew("ERROR: NO. DE FACTURA ".$nfac." YA SE LE IMPRIMIO $cant PLANILLAS BUSQUEDAS, DESDE LA NO. $nplan1 A LA $nplan2 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();	 
}

$diasemana=date("w", $fechafac); 
$vhora = substr($horactual,0,2).substr($horactual,3,2).substr($horactual,6,2).substr($horactual,9,2);
$vfecha= substr($fechafac,0,2).substr($fechafac,3,2).substr($fechafac,6,4);
//$vfecha= substr($fechafac,0,4).substr($fechafac,5,2).substr($fechafac,8,2);

pg_exec("BEGIN WORK");
pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
$obj_query = $sql->query("SELECT last_value FROM stzsystem_planillabus_seq");
$objs = $sql->objects('',$obj_query);
$nplanilla1 = $objs->last_value;
$nplanilla2 = $nplanilla1 + $cantidad;
pg_exec("ALTER SEQUENCE stzsystem_planillabus_seq RESTART WITH $nplanilla2");
$update_str = "planillabus=$nplanilla2";
$updsystem = $sql->update("$tbname_2","$update_str","");
pg_exec("COMMIT WORK");

$tipoletra = substr($factura,0,1);
pg_exec("BEGIN WORK");
if ($tipoletra=='E') {
  // Tabla Control de Cantidad x Facturas
  // $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede";
  // $insert_str = "'$factura','$fechahoy',$cantidad,0,0,'1'";
  // $insfact = $sql->insert("$tbname_3","$col_campos","$insert_str","");
  $solicitante=$_POST["solicitant"];
  $lced=$_POST["lced"];
  $nced=$_POST["nced"];
  $identifica = $lced.$nced; 
  $telefono=$_POST["telefono"];
  // Tabla con Información de Planillas Exoneradas
  $col_campos = "nro_factura,fecha_factura,solicitante,identificacion,telefono,cantidad,usuario,f_transac,h_transac,sede"; 
  $insert_str = "'$factura','$fechafac','$solicitante','$identifica','$telefono',$cantidad,'$login','$fechahoy','$horactual','$sede'";
  $insdatplan = $sql->insert("$tbname_4","$col_campos","$insert_str","");
}

// Tabla de Planillas x Factura 
$col_campos = "nro_factura,cant_plan,nplanilla1,nplanilla2,fecha_gen,hora_gen,usuario,estatus";
$insert_str = "'$factura',$cantidad,($nplanilla1+1),$nplanilla2,'$fechahoy','$horactual','$login','I'";
$insplan = $sql->insert("$tbname_1","$col_campos","$insert_str","");
if ($insplan) { }
else {
  Mensajenew("ERROR: Falla de Inserci&oacute;n de Datos en la BD  ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();
}
pg_exec("COMMIT WORK");

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 
//$pdf->Image('../imagenes/certmarcas2.jpg',3,0,205,330,'JPEG');

$inicio = $nplanilla1;
for ($p=1; $p<=$cantidad; $p++)
{
$planilla = $inicio + $p;
$codigo = $factura.'F'.$vfecha.'D'.$diasemana.'P'.$planilla.'H'.$vhora;
	
$pdf->ln(1);
$pdf->SetTextColor(118, 0, 3);
//$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
$pdf->SetStyle("s1","arial","",10,"0,49,159"); //Cambia a color azul
$pdf->MultiCellTag(180, 4, "<s1>BUSQUEDA PREVIA DE ANTERIORIDADES MARCAS                                                     Planilla No.:  $planilla</s1>", 0);
$pdf->SetStyle("s1","arial","",9,"0,49,159"); //Cambia a color azul
$pdf->MultiCellTag(250, 4, "<s1>Y PETICIONARIO DE MARCAS / PATENTES                                                                          Fecha de Solicitud: ____________</s1>", 0);
$pdf->Ln(4);

// Datos de la Marca o Peticionario
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("DATOS DE LA MARCA");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$filas_found = 2;
for ($j=0; $j<$filas_found; $j++)
{
  $data = Array();
  if ($j==0) { 
    $palabra = "Nombre:"; }
  else {
    $palabra = "Clase Internacional:"; }
  $data[0]['TEXT'] = utf8_decode($palabra);
  $data[0]['T_SIZE'] = 10;
  $data[1]['TEXT'] = utf8_decode($palabra);
  $pdf->tbDrawData($data);
}

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(5);

// Datos del Peticionario Marca o Patente
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("DATOS DEL PETICIONARIO");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$filas_found = 2;
for ($j=0; $j<$filas_found; $j++)
{
  $data = Array();
  if ($j==0) { 
    $palabra = "Nombre:"; }
  else { 
    $palabra = "Búsqueda en: (   ) Marcas  ó  (   ) Patentes"; }
  $data[0]['TEXT'] = utf8_decode($palabra);
  $data[0]['T_SIZE'] = 10;
  $data[1]['TEXT'] = utf8_decode($palabra);
  $pdf->tbDrawData($data);
}

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(5);

// Datos del Solicitante
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("DATOS DEL SOLICITANTE");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$filas_found = 4;
for ($j=0; $j<$filas_found; $j++)
{
  $data = Array();
  if ($j==0) { 
    $palabra = "Nombre:                                                                                                                       Cédula / Rif No.:"; }
  if ($j==1) { 
    $palabra = "Dirección:                                                                                                                     Teléfono No.:"; }
  if ($j==2) { 
    $palabra = "Correo Electrónico:"; }
  if ($j==3) { 
    $palabra = "Firma:                                                                                                                           Enviar por Correo:   (  ) Si    (  ) No"; }
  $data[0]['TEXT'] = utf8_decode($palabra);
  $data[0]['T_SIZE'] = 10;
  $data[1]['TEXT'] = utf8_decode($palabra);
  $data[2]['TEXT'] = utf8_decode($palabra);
  $data[3]['TEXT'] = utf8_decode($palabra);
  $pdf->tbDrawData($data);
}

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(5);

// Datos del Funcionario Receptor
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("FUNCIONARIO RECEPTOR");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$data = Array();
$palabra = "Fecha Recepción:                               Nombre:                                                                     Firma:";
$data[0]['TEXT'] = utf8_decode($palabra);
$data[0]['T_SIZE'] = 10;
$pdf->tbDrawData($data);

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(3);
$pdf->MultiCellTag(180, 4, "<s1>Original - $codigo</s1>", 0);
$pdf->Ln(6);

$x = $pdf->Getx();
$y = $pdf->Gety();
$pdf->line($x,($y+1),200,($y+1));  
$pdf->Ln(8);

//$pdf->Image("../imagenes/topenuevo2014.jpg",10,7,192,12,'JPG');
$pdf->Image("../imagenes/topenuevo2014gris.jpg",10,143,192,14,'JPG');
$pdf->Ln(24);
$x = $pdf->Getx();
$y = $pdf->Gety();
$pdf->SetStyle("s1","arial","",10,"0,49,159"); //Cambia a color azul
$pdf->MultiCellTag(180, 4, "<s1>BUSQUEDA PREVIA DE ANTERIORIDADES MARCAS                                                     Planilla No.:  $planilla</s1>", 0);
$pdf->SetStyle("s1","arial","",9,"0,49,159"); //Cambia a color azul
$pdf->MultiCellTag(250, 4, "<s1>Y PETICIONARIO DE MARCAS / PATENTES                                                                          Fecha de Solicitud: ____________</s1>", 0);
$pdf->Ln(4);

// Datos de la Marca o Peticionario
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("DATOS DE LA MARCA");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$filas_found = 2;
for ($j=0; $j<$filas_found; $j++)
{
  $data = Array();
  if ($j==0) { 
    $palabra = "Nombre:"; }
  else {
    $palabra = "Clase Internacional:"; }
  $data[0]['TEXT'] = utf8_decode($palabra);
  $data[0]['T_SIZE'] = 10;
  $data[1]['TEXT'] = utf8_decode($palabra);
  $pdf->tbDrawData($data);
}

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(5);

// Datos del Peticionario Marca o Patente
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("DATOS DEL PETICIONARIO");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$filas_found = 2;
for ($j=0; $j<$filas_found; $j++)
{
  $data = Array();
  if ($j==0) { 
    $palabra = "Nombre:"; }
  else { 
    $palabra = "Búsqueda en: (   ) Marcas  ó  (   ) Patentes"; }
  $data[0]['TEXT'] = utf8_decode($palabra);
  $data[0]['T_SIZE'] = 10;
  $data[1]['TEXT'] = utf8_decode($palabra);
  $pdf->tbDrawData($data);
}

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(5);

// Datos del Solicitante
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("DATOS DEL SOLICITANTE");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$filas_found = 4;
for ($j=0; $j<$filas_found; $j++)
{
  $data = Array();
  if ($j==0) { 
    $palabra = "Nombre:                                                                                                                       Cédula / Rif No.:"; }
  if ($j==1) { 
    $palabra = "Dirección:                                                                                                                     Teléfono No.:"; }
  if ($j==2) { 
    $palabra = "Correo Electrónico:"; }
  if ($j==3) { 
    $palabra = "Firma:                                                                                                                           Enviar por Correo:   (  ) Si    (  ) No"; }
  $data[0]['TEXT'] = utf8_decode($palabra);
  $data[0]['T_SIZE'] = 10;
  $data[1]['TEXT'] = utf8_decode($palabra);
  $data[2]['TEXT'] = utf8_decode($palabra);
  $data[3]['TEXT'] = utf8_decode($palabra);
  $pdf->tbDrawData($data);
}

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(5);

// Datos del Funcionario Receptor
require("$include_path/tablas_defplan.inc");
$columns = 1; //number of Columns
//Initialize the table class
$pdf->tbInitialize($columns, true, true);
//set the Table Type
$pdf->tbSetTableType($table_default_table_type);	
$aSimpleHeader = array();	
//Table Header
$i=0;
$aSimpleHeader[$i] = $table_default_header_type;
$aSimpleHeader[$i]['TEXT'] = utf8_decode("FUNCIONARIO RECEPTOR");
$aSimpleHeader[$i]['WIDTH'] = 190;
//set the Table Header
$pdf->tbSetHeaderType($aSimpleHeader);
//Draw the Header
$pdf->tbDrawHeader();
//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

$pdf->tbSetDataType($aDataType);
$data = Array();
$palabra = "Fecha Recepción:                               Nombre:                                                                     Firma:";
$data[0]['TEXT'] = utf8_decode($palabra);
$data[0]['T_SIZE'] = 10;
$pdf->tbDrawData($data);

//output the table data to the pdf
$pdf->tbOuputData();	
//draw the Table Border
$pdf->tbDrawBorder();
$pdf->Ln(3);
$pdf->MultiCellTag(180, 4, "<s1>Copia - $codigo</s1>", 0);
if ($p<$cantidad) { $pdf->AddPage(); }
}

//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 

$pdf->Output();
?>
