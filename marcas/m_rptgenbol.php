<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");
require("$include_lib/jlpdf.php");
if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection();
$title='MARCAS';

//Llamada a encabezados y titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n  de las Solicitadas para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");
  
//Validacion de Entrada
$boletin=$_POST["boletin"];
$numero=$_POST["numero"];
$fechab=$_POST["fechab"];
$resolucion=$_POST["resolucion"];
if ($boletin=='' ) {
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
	 
// Armando el query segun las opciones

$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1006'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

//verificando que consiguio los datos necesarios
if (!$resultado)    { 
     Mensage_Error("No existe el Numero de Boletin ...");
     mensajenew('No existe el Numero de Boletin ...!!!','m_rptpgenbol.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {
     mensajenew('No existen Datos Asociados para Generar ...!!!','m_rptpgenbol.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

// Montando los resultados en el array

class PDF extends JLPDF
{
//Columna actual
var $col=0;
//Ordenada de comienzo de la columna
var $y0;

function Header()
{
    //Cabacera
    global $title;

    $this->SetFont('Arial','B',15);
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
   // $this->SetDrawColor(0,80,180);
   // $this->SetFillColor(230,230,0);
   // $this->SetTextColor(220,50,50);
   // $this->SetLineWidth(1);
    $this->Cell($w,9,$title,0,1,'C',0);
    $this->Ln(10);
    //Guardar ordenada
    $this->y0=$this->GetY();
}

function Footer()
{
    //Pie de página
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,10,utf8_decode('Boletín de la Propiedad Industrial     ').$this->PageNo(),0,0,'C');
}

function SetCol($col)
{
    //Establecer la posición de una columna dada
    $this->col=$col;
    $x=15+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    //Método que acepta o no el salto automático de página
    if($this->col<2)
    {
        //Ir a la siguiente columna
        $this->SetCol($this->col+1);
        //Establecer la ordenada al principio
        $this->SetY($this->y0);
        //Seguir en esta página
        return false;
    }
    else
    {
        //Volver a la primera columna
        $this->SetCol(0);
        //Salto de página
        return true;
    }
}

}
 
//Inicio del Pdf
$pdf=new PDF('P','mm','letter');
//$pdf=new JLPDF('P','mm','letter');
$pdf->SetMargins(15,15,10);
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();


      $pdf->SetTitle($title);
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(59,5,'________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(59,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL',0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(59,5,'Caracas, '.$fechab,0,'J',0);     $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(59,5,utf8_decode($numero),0,'J',0);
      $pdf->MultiCell(59,5,utf8_decode('RESOLUCIÓN N· '.$resolucion),0,'J',0);
      $pdf->ln(4); 
      $pdf->MultiCell(59,5,'MARCAS COMERCIALES SOLICITADAS',0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(59,5,utf8_decode('Esta Autoridad Administrativa, en cumplimiento a lo establecido en los articulos 76 y 77 de la Ley de Propiedad Industrial, una vez cumplidos los requisitos de Ley ordena la publicación en el Boletín: de las marcas de productos y servicioa, nombres y lemas comerciales solicitadas; a los efectos de que los interesados presenten sus observaciones, en un lapso de treinta (30) días hábiles a la publicación del presente Boletín, de acuerdo a lo establecido en el artículo 77.'),0,'J',0);
      
   for($cont=0;$cont<$filas_resultado;$cont++) { 

      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];

      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(59,5,'________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(59,5,'Insc. '. $registro['solicitud'].' del '.Cambiar_fecha_mes($registro['fecha_solic']),0,'J',0);
      
    	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'. '.trim($regt['domicilio']).', '.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. '.trim($regt['domicilio']).', '.trim($pais_nombre); }                
	   $regt = pg_fetch_array($res_titular);
	} 


         $texto= $pdf->Setfont('Arial','B',8)."SOLICITADA POR: ".$pdf->Setfont('Arial','',9);
         $pdf->MultiCell(59,5,$texto.utf8_decode($titular),0,'J',0); 

      		//imagen
		$varsol1=substr($nsolic,-11,4);
		$varsol2=substr($nsolic,-6,6);
		$nameimage=ver_imagen($varsol1,$varsol2,'M');

		if (file($nameimage)) {   
		   $pdf->ln(1);
		   $x = $pdf->Getx();
		   $y = $pdf->Gety();
		   if ($y >= 226) {
		      if ($x == 15) { 
       		  	 $pdf->MultiCell(59,38,$pdf->Image("$nameimage",(80+8),36,40,35,'JPG'),0,'J',0); }
		      if ($x == 80) {
		         $pdf->MultiCell(59,38,$pdf->Image("$nameimage",(145+8),36,40,35,'JPG'),0,'J',0); }
		      if ($x == 145) { 
		         $pdf->AddPage();
	                 $pdf->SetCol(0);
       		  	 $pdf->MultiCell(59,38,$pdf->Image("$nameimage",(15+8),36,40,35,'JPG'),0,'J',0); }
		   }
		   else {   
		      $pdf->MultiCell(59,38,$pdf->Image("$nameimage",($x+8),$y,40,35,'JPG'),0,'J',0); }
       		   
		   $pdf->ln(1);
		 //  $pdf->MultiCell(59,5,$x.'y: '.$y,0,'J',0); 
		}
                else {
   		$pdf->Setfont('Arial','B',8);
   		$pdf->ln(4); 
   	        $pdf->MultiCell(59,5,trim(utf8_decode($registro['nombre'])),0,'C',0);  
   	        $prueba1= trim(utf8_decode($registro['nombre']));  
     		$espacio=$pdf->ln(4);
	        $pdf->Setfont('Arial','',8);
   	        }     	    
   	
   	//busqueda del distingue
	$pdf->Setfont('Arial','',8);
        $pdf->MultiCell(59,5,'Para distinguir: '.trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$registro['clase'],0,'J',0);
		 
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
	$pdf->MultiCell(59,5,'TRAMITANTE: '. trim(utf8_decode($tram)),0,'J',0); 

    $registro = pg_fetch_array($resultado);
  }
  
  // Fin de Pagina (Firma del Registrador)
       $pdf->Setfont('Arial','B',12);
       $pdf->MultiCell(59,5,'________________________',0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(59,5,'Publiquese,',0,'L',0);
       $pdf->ln(20); 
       $pdf->MultiCell(59,5,utf8_decode('MARGARITA VILATIMÓ RIVERO'),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(59,5,utf8_decode('Registradora de la Propiedad Industrial'),0,'C',0);
       $pdf->MultiCell(59,5,utf8_decode('Resolución N·0178 de Fecha 14/06/06'),0,'C',0);       
       $pdf->MultiCell(59,5,utf8_decode('Gaceta Oficial No.38.458 de Fecha 14/06/06'),0,'C',0);     
       
         
//Desconexion a la base de datos
$sql->disconnect();
ob_end_clean(); 

//Salida del Reporte
$pdf->Output();

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Nro. Bolet&iacute;n:');
$smarty->assign('campo2','A&ntilde;os de Independecia y Federaci&oacute;n:');
$smarty->assign('campo3','Mes de Publicaci&oacute;n del Bolet&iacute;n:');
$smarty->assign('campo4','Nro. Resoluci&oacute;n:');
$smarty->assign('varfocus','forgenbol.boletin'); 
$smarty->display('m_rptpgenbol.tpl');
$smarty->display('pie_pag.tpl');

?>
