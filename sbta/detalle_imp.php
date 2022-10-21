<?php
// Programa PHP. que imprime los resultados de la Consulta PDF
// (detalle_imp.php)
// Realizado Por Ing. Karina Pérez
// Modificado por Ing. Rómulo Mendoza / Julio 2008 

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

//PDF Encabezados
$encab_principal= "Sistema de Patentes";
$encabezado= "Consulta de Expediente";

// Parametros de la Consulta

//Conexion con la base de datos SAPI
$sql  = new mod_db();
//Verificando conexion
$sql->connection();

// Realizando Consulta por numero de solicitud

$valor1 = $_GET["num_sol"];

//imagen
$varsol1=substr($valor1,-11,4);
$varsol2=substr($valor1,-6,6);
$nameimage=ver_imagen($varsol1,$varsol2,'P');

$imagen_ok=0;
if (file_exists($nameimage)) { $imagen_ok=1; }

//$resultado=pg_exec("SELECT * FROM stppatee WHERE solicitud='$valor1'");
$resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='P' 
		        AND b.solicitud= '$valor1'");

$registro = pg_fetch_array($resultado);

 $nderec=$registro['nro_derecho'];
 $varsol=$registro['solicitud'];
 $nagen=$registro['agente'];

$estado = $registro['estatus']; 
$numreg = trim($registro['registro']);
 
$cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
$cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
$cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
$cons_tra=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' and evento=2124");
$cons_equiv=pg_exec("SELECT * FROM stpequiv WHERE nro_derecho='$nderec'");
$cons_tit = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular ");

$descripcion=estatus($registro['estatus']);

$reg_inv = pg_fetch_array($cons_inv);
   $filas_cons_inv=pg_numrows($cons_inv); 
$regclasf = pg_fetch_array($cons_clas);
   $filas_clasif=pg_numrows($cons_clas); 
$reg_clasl = pg_fetch_array($cons_clasl);
   $filas_cons_clasl=pg_numrows($cons_clasl);
$reg_res = pg_fetch_array($cons_res);
$reg_pri = pg_fetch_array($cons_pri);
   $filas_cons_pri=pg_numrows($cons_pri);
$reg_tit = pg_fetch_array($cons_tit);
   $filas_cons_tit=pg_numrows($cons_tit);
$reg_tra = pg_fetch_array($cons_tra);
   $filas_cons_tra=pg_numrows($cons_tra);
$reg_equiv = pg_fetch_array($cons_equiv);
   $filas_cons_equiv=pg_numrows($cons_equiv); 



//Creación del objeto de la clase heredada
//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetMargins(10,40,40);

$title='Busqueda de Patentes';

//$pdf->Image("../imagenes/logo-oficial.jpg",10,5,190,14,'JPG');
//echo "estoy aqui ";
    //Arial 12
    $pdf->SetFont('Arial','',8);
    //Color de fondo
    $pdf->SetFillColor(200,220,255);

    $pdf->Text(162,26,"Fecha:");
    $pdf->text(175,26,date('d/m/y'),0,1);
    //$pdf->Text(175,26,"Hora:");
	 $pdf->text(188,26,date('h:i A'),0,1);  
    $pdf->Ln(1);

    $pdf->SetFont('Arial','',9);
    //Título
    $pdf->Cell(0,6,"Datos Generales de la Consulta",0,1,'L',1);

    //Salto de línea
    $pdf->Ln(2);

    $pdf->Cell(40,8,'Título del Documento:',0,0);
    $pdf->MultiCell(120,5,trim(utf8_decode($registro['nombre'])),0,1);
    $pdf->Cell(40,8,'Número de Solicitud:',0,0); 
    $pdf->Cell(25,8,$valor1,0,0);
    $pdf->Cell(40,8,'Fecha de Presentación:',0,0);
    $pdf->Cell(40,8,$registro['fecha_solic'],0,1);
    $pdf->Cell(40,8,'Estatus:',0,0);
    $pdf->Cell(10,8,($registro['estatus']-2000). " - ".$descripcion,0,1);
 
    
    if (!empty($numreg)) { 
      $pdf->Cell(40,8,'Número de Registro:',0,0);
      $pdf->Cell(25,8,$registro['registro'],0,0);
      $pdf->Cell(40,8,'Fecha de Vencimiento:',0,0);
      $pdf->Cell(40,8,$registro['fecha_venc'],0,1);
    }  
    if ($filas_cons_tra != 0) {
      $pdf->Cell(40,8,'Boletín de Publicación:',0,0);
      $pdf->Cell(25,8,$reg_tra['documento'],0,0);
      $pdf->Cell(40,8,'Fecha de Publicación:',0,0);
      $pdf->Cell(25,8,$registro['fecha_publi'],0,1);
    }  

    $pdf->Cell(0,10,'Número de Prioridad:',0,1);  
 	 for($cont=0;$cont<$filas_cons_pri;$cont++) {
 	   $nprioridad = trim($reg_pri['prioridad'])."  de fecha ".$reg_pri['fecha_priori'].",  Pais:  ".$reg_pri['pais_priori']."; ";  
		$pdf->Cell(4,5,'--');
	   $pdf->Cell(10,5,$nprioridad,0,1);
		$reg_pri = pg_fetch_array($cons_pri);
	 }

    $pdf->Cell(0,6,"Inventor(es)",0,1,'L',1);

	for($cont=0;$cont<$filas_cons_inv;$cont++) { 
		$pdf->Cell(5,5,'--',0,0);
		$inventor="";
		$inventor=trim(utf8_decode($reg_inv['nombre_inv']))." (".$reg_inv['nacionalidad'].")";
		$pdf->Cell(50,5,$inventor,0,1,'L');
		$reg_inv = pg_fetch_array($cons_inv);
	}
    $pdf->Ln(2);
    $pdf->Cell(0,6,"Titular(es)",0,1,'L',1);
   // $pdf->Cell(40,10,'Titular(es):',0,1); 
	for($cont=0;$cont<$filas_cons_tit;$cont++) { 
		$pdf->Cell(5,5,'--');
		$propietario="";
		$propietario=trim(utf8_decode($reg_tit['nombre']))." (".$reg_tit['nacionalidad'].")";
    	$pdf->Cell(150,5,$propietario,0,1);
		$reg_clas = pg_fetch_array($cons_tit);
	}
    $pdf->Ln(2);
    $pdf->Cell(0,6,"Clasificaciones",0,1,'L',1);
    $pdf->Cell(40,8,'Clasificacion Internacional:',0,1); 
	for($cont=0;$cont<$filas_clasif;$cont++) { 
		$pdf->Cell(4,5,'--');
		$pdf->Cell(4,5,$regclasf['tipo_clas'],0,0);	
		$pdf->Cell(4,5,'=');
		$pdf->Cell(10,5,$regclasf['clasificacion'],0,1);	
		$regclasf = pg_fetch_array($cons_clas);
	}
    $pdf->Cell(40,8,'Clasificacion Locarno:',0,1);  
	for($cont=0;$cont<$filas_cons_clasl;$cont++) {
		$pdf->Cell(4,5,'--');
      	$pdf->Cell(10,5,$reg_clasl['clasi_locarno'],0,1);	 
		$reg_clasl = pg_fetch_array($cons_clasl);
	}
    $pdf->Cell(0,6,"Equivalencias",0,1,'L',1);
	for($cont=0;$cont<$filas_cons_equiv;$cont++) { 
		$pdf->Cell(5,5,'--',0,0);
		$equivalente="";
		$equivalente=trim($reg_equiv['equivalente']);
		$pdf->Cell(50,5,$equivalente,0,1,'L');
		$reg_equiv = pg_fetch_array($cons_equiv);
	}
    
    $pdf->Ln(2);
    $pdf->Cell(0,6,"Resumen",0,1,'L',1);
    $pdf->MultiCell(190,5,trim(utf8_decode($registro['resumen'])),0,'J');
    $pdf->Ln(2);

    //Save the current position
	 $x=$pdf->GetX();
	 $y=$pdf->GetY();
	 //Put the position to the right of the cell
	 $pdf->SetXY($x,$y+2);
	 
    if ($imagen_ok==1) {    
      $pdf->Image("$nameimage",$x+60,$y,60,60,'JPG'); }

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>
