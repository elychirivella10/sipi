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
$fecha = fechahoy();

$tbname1 = "stzusuar";
$tbname2 = "stzdepto";
$tbname3 = "stzroles";
$tbname4 = "stzevder";
$tbname5 = "stdevobr";
$tbname6 = "stzroleve";

//Conexion
$sql = new mod_db();
$sql->connection($login);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }
;

//PDF Encabezados
$encab_principal= "Sistema de Propiedad Intelectual";
$encabezado= "Reporte de Rol/Eventos por Usuarios";
$linea="_________________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Reporte de Rol/Eventos por Usuarios');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$nconex = $_POST['nconex'];
$vus=$_GET["vus"];
$vcd=$_GET["vcd"];

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

//Verificación del valor
$obju_query = $sql->query("SELECT * FROM $tbname1 WHERE estatus='1'");
$filas_usr  = pg_numrows($obju_query); 
$objsu      = $sql->objects('',$obju_query);
for($i=0;$i<$filas_usr;$i++) {
  $cedula    = trim($objsu->cedula);
  $nombre    = trim($objsu->nombre);
  $email     = trim($objsu->email);
  $vuser     = trim($objsu->usuario);
  $rol       = trim($objsu->role);
  $fecha_ing = $objsu->fecha_ing;
  $hora_ing  = $objsu->hora_ing;
  $id_estado = $objsu->estatus;
  $depto_id  = $objsu->cod_depto;
  $estado    = "Activo";
  if ($id_estado!=1) { $estado="Inactivo"; }
  $ingreso   = $objsu->fecha_ing." - ".$objsu->hora_ing;

  //Obtención de los Departamentos 
  $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE cod_depto='$depto_id'");
  $objs = $sql->objects('',$obj_query);
  $unidad=trim($objs->nombre);

  //Obtención de Datos del Rol
  $obj_query = $sql->query("SELECT * FROM $tbname3 WHERE role='$rol'");
  $objs        = $sql->objects('',$obj_query);
  $namrol      = trim($objs->nombre); 
  $descripcion = trim($objs->descripcion); 
  $creacion   = $objs->fecha_crea." - ".$objs->hora_crea;
  $pdf->ln(2);
  $pdf->Cell(15,8,'Usuario:',0,0); 
  $pdf->Cell(95,8,$vuser,0,0);
  $pdf->Cell(40,8,'Fecha de Ingreso al SIPI:',0,0);
  $pdf->Cell(30,8,$fecha_ing,0,1);
  $pdf->Cell(15,8,'Nombre:',0,0); 
  $pdf->Cell(95,8,utf8_decode($nombre),0,0);
  $pdf->Cell(15,8,'Cedula:',0,0);
  $pdf->Cell(40,8,$cedula,0,1);    
  $pdf->Cell(15,8,'E-mail:',0,0);
  $pdf->Cell(50,8,$email,0,1);
  $pdf->Cell(35,8,'Coordinacion/Unidad:',0,0);
  $pdf->Cell(50,8,$depto_id.' - '.$unidad,0,1);
  $pdf->Cell(35,8,'Rol asignado actual:',0,0);
  $pdf->Cell(50,8,$rol.' - '.$namrol,0,1);

  //// Descripcion
  //require("$include_path/tablas_def.inc");
  //$columns = 1; //number of Columns  ////Initialize the table class
  //$pdf->tbInitialize($columns, true, true);
  ////set the Table Type
  //$pdf->tbSetTableType($table_default_table_type);	
  //$aSimpleHeader = array();	
  ////Table Header
  //$i=0;
  //$aSimpleHeader[$i] = $table_default_header_type;
  //$aSimpleHeader[$i]['TEXT'] = utf8_decode("Descripción ");
  //$aSimpleHeader[$i]['WIDTH'] = 190;
  //$i=1;
  ////set the Table Header
  //$pdf->tbSetHeaderType($aSimpleHeader);
  ////Draw the Header
  //$pdf->tbDrawHeader();
  ////Table Data Settings
  //$aDataType = Array();
  //for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;
  //$pdf->tbSetDataType($aDataType);
  //for ($j=0; $j<1; $j++)
  //  {
  //    $data = Array();
  //    $data[0]['TEXT'] = utf8_decode($descripcion);
   //   $pdf->tbDrawData($data);
  //  }

  ////output the table data to the pdf
  //$pdf->tbOuputData();	
  ////draw the Table Border
  //$pdf->tbDrawBorder();
  //$pdf->Ln(2);

  // Buscando los Eventos Asignados del Rol

  $vtipo='M';
  $result = pg_exec("SELECT $tbname6.evento,$tbname6.fecha_asig,$tbname6.fecha_elim,
                    $tbname6.estado,$tbname4.descripcion,$tbname4.tipo_evento 
                    FROM $tbname6,$tbname4 
                    WHERE $tbname6.role='$rol' AND $tbname6.tip_derecho='$vtipo' AND
                          $tbname6.estado='A' AND $tbname6.evento=$tbname4.evento 
                    ORDER BY $tbname6.evento,$tbname6.fecha_asig");
 
  $res = pg_fetch_array($result);
  $filas_found=pg_numrows($result);
  $fil=$filas_found;
  if ($fil!=0) {
   //default text color
   $pdf->SetTextColor(118, 0, 3);
   //$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
   $pdf->SetStyle("s1","arial","",8,"118,0,3"); //Cambia a color marron

   $pdf->MultiCellTag(100, 4, "<s1>EVENTOS ASIGNADOS DE MARCAS</s1>", 0);

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
   $aSimpleHeader[$i]['TEXT'] = utf8_decode("Código ");
   $aSimpleHeader[$i]['WIDTH'] = 20;
   $i=1;
   $aSimpleHeader[$i] = $table_default_header_type;
   $aSimpleHeader[$i]['TEXT'] = "Nombre ";
   $aSimpleHeader[$i]['WIDTH'] = 170;

   //set the Table Header
   $pdf->tbSetHeaderType($aSimpleHeader);
	
   //Draw the Header
   $pdf->tbDrawHeader();

   //Table Data Settings
   $aDataType = Array();
   for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

   $pdf->tbSetDataType($aDataType);

   for ($j=0; $j<$filas_found; $j++)
   {
     $data = Array();
     $data[0]['TEXT'] = $res['evento']-1000;
     $data[1]['TEXT'] = trim(utf8_decode($res['descripcion']));
     $pdf->tbDrawData($data);
     $res = pg_fetch_array($result);
   }
	
   //output the table data to the pdf
   $pdf->tbOuputData();

   //draw the Table Border
   $pdf->tbDrawBorder();
   $pdf->Ln(2);

   $pdf->Cell(45,8,'Total Eventos asignados de Marcas :',0,0);
   $pdf->Cell(10,8,$fil,0,1);
  } else {
    $pdf->Cell(50,8,'NOTA: NO PRESENTA EVENTOS ASIGNADOS DE MARCAS !!!',0,1);
  }

  $vtipo='P';
  $result = pg_exec("SELECT $tbname6.evento,$tbname6.fecha_asig,$tbname6.fecha_elim,
                    $tbname6.estado,$tbname4.descripcion,$tbname4.tipo_evento 
                    FROM $tbname6,$tbname4 
                    WHERE $tbname6.role='$rol' AND $tbname6.tip_derecho='$vtipo' AND
                          $tbname6.estado='A' AND $tbname6.evento=$tbname4.evento 
                    ORDER BY $tbname6.evento,$tbname6.fecha_asig");
 
  $res = pg_fetch_array($result);
  $filas_found=pg_numrows($result);
  $fil=$filas_found;
  if ($fil!=0) {
   //default text color
   $pdf->SetTextColor(118, 0, 3);
   //$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
   $pdf->SetStyle("s1","arial","",8,"118,0,3"); //Cambia a color marron

   $pdf->MultiCellTag(100, 4, "<s1>EVENTOS ASIGNADOS DE PATENTES</s1>", 0);

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
   $aSimpleHeader[$i]['TEXT'] = utf8_decode("Código ");
   $aSimpleHeader[$i]['WIDTH'] = 20;
   $i=1;
   $aSimpleHeader[$i] = $table_default_header_type;
   $aSimpleHeader[$i]['TEXT'] = "Nombre ";
   $aSimpleHeader[$i]['WIDTH'] = 170;

   //set the Table Header
   $pdf->tbSetHeaderType($aSimpleHeader);
	
   //Draw the Header
   $pdf->tbDrawHeader();

   //Table Data Settings
   $aDataType = Array();
   for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

   $pdf->tbSetDataType($aDataType);

   for ($j=0; $j<$filas_found; $j++)
   {
     $data = Array();
     $data[0]['TEXT'] = $res['evento']-2000;
     $data[1]['TEXT'] = trim(utf8_decode($res['descripcion']));
     $pdf->tbDrawData($data);
     $res = pg_fetch_array($result);
   }
	
   //output the table data to the pdf
   $pdf->tbOuputData();

   //draw the Table Border
   $pdf->tbDrawBorder();
   $pdf->Ln(2);

   $pdf->Cell(50,8,'Total Eventos asignados de Patentes :',0,0);
   $pdf->Cell(10,8,$fil,0,1);
  } else {
    $pdf->Cell(50,8,'NOTA: NO PRESENTA EVENTOS ASIGNADOS DE PATENTES !!!',0,1);
  }

  $vtipo='A';
  $result = pg_exec("SELECT $tbname6.evento,$tbname6.fecha_asig,$tbname6.fecha_elim,
                    $tbname6.estado,$tbname4.descripcion,$tbname4.tipo_evento 
                    FROM $tbname6,$tbname4 
                    WHERE $tbname6.role='$rol' AND $tbname6.tip_derecho='$vtipo' AND
                          $tbname6.estado='A' AND $tbname6.evento=$tbname4.evento 
                    ORDER BY $tbname6.evento,$tbname6.fecha_asig");
 
  $res = pg_fetch_array($result);
  $filas_found=pg_numrows($result);
  $fil=$filas_found;
  if ($fil!=0) {
   //default text color
   $pdf->SetTextColor(118, 0, 3);
   //$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
   $pdf->SetStyle("s1","arial","",8,"118,0,3"); //Cambia a color marron

   $pdf->MultiCellTag(100, 4, "<s1>EVENTOS ASIGNADOS DE DERECHO DE AUTOR</s1>", 0);

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
   $aSimpleHeader[$i]['TEXT'] = utf8_decode("Código ");
   $aSimpleHeader[$i]['WIDTH'] = 20;
   $i=1;
   $aSimpleHeader[$i] = $table_default_header_type;
   $aSimpleHeader[$i]['TEXT'] = "Nombre ";
   $aSimpleHeader[$i]['WIDTH'] = 170;

   //set the Table Header
   $pdf->tbSetHeaderType($aSimpleHeader);
	
   //Draw the Header
   $pdf->tbDrawHeader();

   //Table Data Settings
   $aDataType = Array();
   for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

   $pdf->tbSetDataType($aDataType);

   for ($j=0; $j<$filas_found; $j++)
   {
     $data = Array();
     $data[0]['TEXT'] = $res['evento'];
     $data[1]['TEXT'] = trim(utf8_decode($res['descripcion']));
     $pdf->tbDrawData($data);
     $res = pg_fetch_array($result);
   }
	
   //output the table data to the pdf
   $pdf->tbOuputData();

   //draw the Table Border
   $pdf->tbDrawBorder();
   $pdf->Ln(2);

   $pdf->Cell(65,8,'Total Eventos asignados de Derecho de Autor :',0,0);
   $pdf->Cell(10,8,$fil,0,1);
  } else {
    $pdf->Cell(50,8,'NOTA: NO PRESENTA EVENTOS ASIGNADOS DE DERECHO DE AUTOR !!!',0,1);
  }

  $objsu   = $sql->objects('',$obju_query);
}


//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();

?>
