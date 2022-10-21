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
$encabezado= "Reporte de Acceso Usuarios/Eventos por Roles";
$linea="_________________________________________________________________________________________________";

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Reporte de Acceso Usuarios/Eventos por Roles');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$nconex = $_POST['nconex'];
$vrol=$_GET["vrol"];

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 


//Obtención de Datos del Rol
$obj_query = $sql->query("SELECT * FROM $tbname3 WHERE estado='A' ORDER BY role");
$filas_rol = pg_numrows($obj_query); 
$objs      = $sql->objects('',$obj_query);
for($i=0;$i<$filas_rol;$i++) {
   $vrol        = trim($objs->role); 
   $namrol      = trim($objs->nombre); 
   $descripcion = trim($objs->descripcion); 
   $creacion   = $objs->fecha_crea." - ".$objs->hora_crea;

   $result = pg_exec("SELECT $tbname1.usuario,$tbname1.cedula,$tbname1.nombre,
                             $tbname1.cod_depto,trim($tbname2.nombre) as departamento 
                      FROM  $tbname1,$tbname2 
                      WHERE $tbname1.role='$vrol' AND $tbname1.estatus='1' 
                       AND  $tbname1.cod_depto=$tbname2.cod_depto  
                      ORDER BY 1");

   $res = pg_fetch_array($result);
   $filasu_found=pg_numrows($result);
   $fil=$filasu_found;
   if ($fil!=0) {
     $y = $pdf->Gety();
     if ($y>=226) {
       $pdf->AddPage(); $pdf->Ln(); }

     //Muestra campos principales del Rol 
     $pdf->ln(2);
     $pdf->SetFont('Arial','',8);
     $pdf->Cell(15,8,'Role:',0,0); 
     $pdf->Cell(95,8,$vrol,0,1);
     //$pdf->Cell(35,8,'Fecha de Creacion:',0,0);
     //$pdf->Cell(30,8,$creacion,0,1);
     $pdf->Cell(15,8,'Nombre:',0,0); 
     $pdf->Cell(95,8,utf8_decode($namrol),0,1);
     $pdf->Ln(2);

     //$pdf->Cell(19,8,'Descripcion:',0,0); 
     //$pdf->Cell(95,8,utf8_decode($descripcion),0,1);

     // Descripcion
     require("$include_path/tablas_def.inc");
     $columns = 1; //number of Columns     //Initialize the table class
     $pdf->tbInitialize($columns, true, true);
     //set the Table Type
     $pdf->tbSetTableType($table_default_table_type);	
     $aSimpleHeader = array();	
     //Table Header
     $i=0;
     $aSimpleHeader[$i] = $table_default_header_type;
     $aSimpleHeader[$i]['TEXT'] = utf8_decode("Descripción ");
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
      	  $data[0]['TEXT'] = utf8_decode($descripcion);
	  $pdf->tbDrawData($data);
	}

     //output the table data to the pdf
     $pdf->tbOuputData();	
     //draw the Table Border
     $pdf->tbDrawBorder();
     $pdf->Ln(3);

     //default text color
     $pdf->SetTextColor(118, 0, 3);
     $pdf->SetStyle("s1","arial","",7,"118,0,3"); //Cambia a color marron
     $pdf->MultiCellTag(100, 4, "<s1>USUARIOS ASIGNADOS</s1>", 0);

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
     $aSimpleHeader[$i]['TEXT'] = utf8_decode("Usuario ");
     $aSimpleHeader[$i]['WIDTH'] = 20;
     $i=1;
     $aSimpleHeader[$i] = $table_default_header_type;
     $aSimpleHeader[$i]['TEXT'] = utf8_decode("Cédula ");
     $aSimpleHeader[$i]['WIDTH'] = 20;
     $i=2;
     $aSimpleHeader[$i] = $table_default_header_type;
     $aSimpleHeader[$i]['TEXT'] = "Nombre ";
     $aSimpleHeader[$i]['WIDTH'] = 65;
     $i=3;
     $aSimpleHeader[$i] = $table_default_header_type;
     $aSimpleHeader[$i]['TEXT'] = "Depto ";
     $aSimpleHeader[$i]['WIDTH'] = 15;
     $i=4;
     $aSimpleHeader[$i] = $table_default_header_type;
     $aSimpleHeader[$i]['TEXT'] = utf8_decode("Nombre Unidad/Coordinación ");
     $aSimpleHeader[$i]['WIDTH'] = 70;

     //set the Table Header
     $pdf->tbSetHeaderType($aSimpleHeader);
	
     //Draw the Header
     $pdf->tbDrawHeader();

     //Table Data Settings
     $aDataType = Array();
     for ($i=0; $i<$columns; $i++) $aDataType[$i] = $table_default_data_type;

     $pdf->tbSetDataType($aDataType);

     for ($j=0; $j<$filasu_found; $j++)
     {
       $data = Array();
       $data[0]['TEXT'] = $res['usuario'];
       $data[1]['TEXT'] = trim($res['cedula']);
       $data[1]['T_ALIGN'] = 'R';
       $data[2]['TEXT'] = trim(utf8_decode($res['nombre']));
       $data[3]['TEXT'] = $res['cod_depto'];
       $data[3]['T_ALIGN'] = 'C';
       $data[4]['TEXT'] = trim(utf8_decode($res['departamento']));
       $pdf->tbDrawData($data);
       $res = pg_fetch_array($result);
     }
	
     //output the table data to the pdf
     $pdf->tbOuputData();

     //draw the Table Border
     $pdf->tbDrawBorder();
     //$pdf->Ln(1);

     $pdf->Cell(45,8,'Total Usuario asignados al Rol :',0,0);
     $pdf->Cell(10,8,$fil,0,1);
     $pdf->Ln(1);

     // Buscando los Eventos Asignados del Rol

     $vtipo='M';
     $result = pg_exec("SELECT $tbname6.evento,$tbname6.fecha_asig,$tbname6.fecha_elim,
                               $tbname6.estado,$tbname4.descripcion,$tbname4.tipo_evento 
                        FROM  $tbname6,$tbname4 
                        WHERE $tbname6.role='$vrol' AND $tbname6.tip_derecho='$vtipo' AND
                              $tbname6.estado='A' AND $tbname6.evento=$tbname4.evento 
                        ORDER BY $tbname6.evento,$tbname6.fecha_asig");
 
     $res = pg_fetch_array($result);
     $filasm_found=pg_numrows($result);
     $fil=$filasm_found;
     if ($fil!=0) {
       //default text color
       $pdf->SetTextColor(118, 0, 3);
       //$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
       $pdf->SetStyle("s1","arial","",7,"118,0,3"); //Cambia a color marron
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

       for ($j=0; $j<$filasm_found; $j++)
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
       //$pdf->Ln(1);

       $pdf->Cell(45,8,'Total Eventos asignados de Marcas :',0,0);
       $pdf->Cell(10,8,$fil,0,1);
     } else {
       $pdf->Cell(50,8,'NOTA: NO PRESENTA EVENTOS ASIGNADOS DE MARCAS !!!',0,1);
     }

     $vtipo='P';
     $result = pg_exec("SELECT $tbname6.evento,$tbname6.fecha_asig,$tbname6.fecha_elim,
                               $tbname6.estado,$tbname4.descripcion,$tbname4.tipo_evento 
                        FROM  $tbname6,$tbname4 
                        WHERE $tbname6.role='$vrol' AND $tbname6.tip_derecho='$vtipo' AND
                              $tbname6.estado='A' AND $tbname6.evento=$tbname4.evento 
                        ORDER BY $tbname6.evento,$tbname6.fecha_asig");
 
     $res = pg_fetch_array($result);
     $filasp_found=pg_numrows($result);
     $fil=$filasp_found;
     if ($fil!=0) {
       //default text color
       $pdf->SetTextColor(118, 0, 3);
       //$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
       $pdf->SetStyle("s1","arial","",7,"118,0,3"); //Cambia a color marron
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

       for ($j=0; $j<$filasp_found; $j++)
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
       //$pdf->Ln(1);

       $pdf->Cell(50,8,'Total Eventos asignados de Patentes :',0,0);
       $pdf->Cell(10,8,$fil,0,1);
     } else {
       $pdf->Cell(50,8,'NOTA: NO PRESENTA EVENTOS ASIGNADOS DE PATENTES !!!',0,1);
       //$pdf->Ln(1);
     }

     $vtipo='A';
     $result = pg_exec("SELECT $tbname6.evento,$tbname6.fecha_asig,$tbname6.fecha_elim,
                               $tbname6.estado,$tbname5.descripcion,$tbname5.tipo_evento 
                        FROM   $tbname6,$tbname5 
                        WHERE  $tbname6.role='$vrol' AND $tbname6.tip_derecho='$vtipo' AND
                               $tbname6.estado='A' AND $tbname6.evento=$tbname5.evento 
                        ORDER BY $tbname6.evento,$tbname6.fecha_asig");
 
     $res = pg_fetch_array($result);
     $filasa_found=pg_numrows($result);
     $fil=$filasa_found;
     if ($fil!=0) {
       //default text color
       $pdf->SetTextColor(118, 0, 3);
       //$pdf->SetStyle("s2","arial","",9,"0,49,159"); //Cambia a color negro
       $pdf->SetStyle("s1","arial","",7,"118,0,3"); //Cambia a color marron
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

       for ($j=0; $j<$filasa_found; $j++)
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
       //$pdf->Ln(1);

       $pdf->Cell(65,8,'Total Eventos asignados de Derecho de Autor :',0,0);
       $pdf->Cell(10,8,$fil,0,1);
       //$pdf->Ln(1);
     } else {
       $pdf->Cell(50,8,'NOTA: NO PRESENTA EVENTOS ASIGNADOS DE DERECHO DE AUTOR !!!',0,1);
       //$pdf->Ln(1);
     }
     $x = $pdf->Getx();
     $y = $pdf->Gety();
     $pdf->line($x,($y+1),208,($y+1));  

   } 
   $objs   = $sql->objects('',$obj_query);
}

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();

?>
