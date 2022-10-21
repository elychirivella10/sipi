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

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Listado de Poderes');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado de Poderes" ;

//Query para buscar las opciones deseadas
$where='';
$titulo='';

//Conexion
$sql = new mod_db();
$sql->connection($login);

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
 $resultado = pg_exec("SELECT DISTINCT ON (poder) *
	FROM stzpoder a
	WHERE a.fecha_trans BETWEEN '$desdet' AND '$hastat'
	ORDER by poder");
}
else {
 $resultado = pg_exec("SELECT DISTINCT ON (poder) *
	FROM stzpoder a
	WHERE a.poder BETWEEN '$desde' AND '$hasta'
	ORDER by poder");
}
//verificando los resultados
if (!$resultado)    { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit();    }$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('No Existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit();    } 

$registro = pg_fetch_array($resultado);
$total= "Total de Poderes: ".$filas_found;
$smarty->assign('n_conex',$nconex);

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

//Comienzo del pdf
$pdf->SetFont('Arial','',7);

//Tabla coloreada
//Colores, ancho de línea y fuente en negrita
    $pdf->SetFillColor(142,165,188);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetFont('','B',10);

    $header=array('Poder','Fecha','Facultad','','');
 
    //Cabecera
    $w=array(40,25,30,50,50);
    $pdf->Ln();
   
     //Restauración de colores y fuentes
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('','B',8);

  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->Cell(24,6,'Poder',0,0,'C'); 
  $pdf->Cell(16,6,'Fecha',0,0,'C'); 
  $pdf->Cell(22,6,'Facultad',0,1,'C'); 
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->SetFont('','',8);
	$pdf->ln(1);
  for($cont=0;$cont<$filas_found;$cont++)   { 
 	$pdf->Cell(24,4,$registro['poder'],0,0);
  	$pdf->Cell(16,4,$registro['fecha_poder'],0,0);
 	$pdf->Cell(30,4,$registro['facultad'],0,0);
	//Titulares
       $pdf->SetFont('','B',8);
       $pdf->Cell(35,4,"Titular(es) ",0,1);
       $pdf->SetFont('','',8);
       $x = $pdf->Getx();
       $y = $pdf->Gety();
       $pdf->line($x,($y+1),203,($y+1)); 
       $resultit = pg_exec("SELECT a.poder, a.fecha_poder, a.facultad, b.nombre as titular
	FROM stzpoder a, stzsolic b
	WHERE a.poder = '$registro[poder]' AND
	      a.titular = b.titular");
       $filas_tit=pg_numrows($resultit);
	$pdf->ln(1);
	for($cont_tit=0;$cont_tit<$filas_tit;$cont_tit++)  { 
          $regtit = pg_fetch_array($resultit);
    	  $pdf->Cell($w[0],4,$blanco,0,0,'C',1);
   	  $pdf->Cell($w[1],4,$blanco,0,0,'L',1);
          $pdf->Cell(80,4,trim(utf8_decode($regtit['titular'])),0,1);  
 	}
	//Poderhabientes
       $pdf->SetFont('','B',8);
       $x = $pdf->Getx();
       $pdf->Cell($x+30,4, "                                                                                         Poderhabiente(s) ",0,1);
       $pdf->SetFont('','',8);
       $x = $pdf->Getx();
       $y = $pdf->Gety();
       $pdf->line($x,($y+1),203,($y+1)); 
       $resulage = pg_exec("SELECT distinct a.poder, a.fecha_poder, a.facultad, c.agente, c.nombre 
	FROM stzpoder a, stzagenr c, stzpohad d
	WHERE a.poder = '$registro[poder]' AND
	      a.poder = d.poder AND
	      d.poderhabi = c.agente ");
       $filas_age=pg_numrows($resulage);
	$pdf->ln(1);
	for($cont_age=0;$cont_age<$filas_age;$cont_age++)  { 
          $regage = pg_fetch_array($resulage);
    	  $pdf->Cell($w[0],4,$blanco,0,0,'C',1);
   	  $pdf->Cell($w[1],4,$blanco,0,0,'L',1);
          $pdf->Cell(80,4,$regage['agente'].' - '.trim(utf8_decode($regage['nombre'])),0,1);  
 	}
   $registro = pg_fetch_array($resultado);      
  }
  
  $pdf->ln(1);
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),203,($y+1));  
  $pdf->SetFont('','B',8);
  $pdf->SetFont('','',8);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
