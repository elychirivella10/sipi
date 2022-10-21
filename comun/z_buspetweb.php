<?php
// ************************************************************************************* 
// Programa: z_buswebpet.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Año: 2017 I Semestre BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$usuario=$login;
//Conexion
$sql = new mod_db();
$sql->connection($login);

$smarty->assign('titulo','Sistema de Marcas/Patentes');
$smarty->assign('subtitulo','Reporte de Busquedas de Peticionario');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$reftram=$_POST["referencia"];
$numpet=$_POST["numpet"];

if ($reftram=='' || $numpet=='') {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Obtención de los Datos del Tramite  
$objtram   = $sql->query("SELECT * FROM stzbuspet WHERE ref_busq='$reftram'");
$objfiltra = $sql->nums('',$objtram);
if ($objfiltra==0) { 
    mensajenew('ERROR: No existen los datos del Tramite correspondientes a la Referencia ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$objs = $sql->objects('',$objtram);
$vtramite      = $objs->nro_tramite;
$vpeticionario = trim($objs->peticionario);
$vsolicitante  = trim($objs->solicitante);
$vfecha_peti   = $objs->fecha_bus;
$vusremail     = trim($objs->usuario);
$vtipopet      = $objs->tipo_busq;
$titulo        = $vtramite;
$Referencia    = $reftram;
$npedido       = $objs->nro_pedido;

//Ruta donde se generara el archivo resultado pdf
$rutafinal = '/apl/webpi/peticionario/'; 

if($vtipopet=="M") {
$npedido = "BP".$vtipopet.str_pad($npedido,6,"0",STR_PAD_LEFT); 
$archivo   = $rutafinal.trim($npedido).".pdf";

//Query para buscar las solicitudes asociadas al titular
pg_exec("CREATE TEMPORARY TABLE stmpeticion (solicitud,clase,nombre,estatus,registro,fecha_regis,fecha_venc) AS 
  						  SELECT e.solicitud, a.clase, e.nombre, e.estatus, e.registro, e.fecha_regis, e.fecha_venc, a.ind_claseni
		     FROM stmmarce a, stzwordpet b, stzottid c, stzsolic d, stzderec e
		     WHERE b.titular = d.titular 
 		     AND c.titular = d.titular 
		     AND c.nro_derecho=a.nro_derecho
		     AND e.nro_derecho=a.nro_derecho
		     AND b.codigo = '$numpet' 
	             ORDER BY e.solicitud ");	
$resultado=pg_exec("select * from stmpeticion order by solicitud");

//verificando los resultados
if (!$resultado) { 
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: No existen los datos correspondientes ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$filas_found=pg_numrows($resultado); 

//Incio de la Clase de PDF para generar los reportes
function Cambiar_fecha($fechaini)
 {
 if (!empty($fechaini)) {
    $dia=substr($fechaini,8,2);
    $mes=substr($fechaini,5,2);
    $anio=substr($fechaini,0,4);
    return date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio));
   }
 }
 
class PDF_Table extends FPDF

{
var $tb_columns; 		//number of columns of the table
var $tb_header_type; 	//array which contains the header characteristics and texts
var $tb_data_type; 		//array which contains the data characteristics (only the characteristics)
var $tb_table_type; 	//array which contains the table charactersitics
var $table_startx, $table_starty;	//the X and Y position where the table starts

//returns the width of the page in user units

function PageWidth(){
	return (int) $this->w-$this->rMargin-$this->lMargin;
}

function Header()
{
	global $titulo;
	global $total;
	global $Referencia;
	//Title
	$this->SetFont('Arial','',15);
	//$this->Image("../imagenes/sapi.jpg",10,5,15,15,'JPG');
   $this->Image("../imagenes/logo_sapi_nuevo.jpg",10,5,30,28,'JPG');
	$this->Cell(0,6,'Sistema de Marcas',0,1,'C');
   $this->SetFont('Arial','',10);
	$this->Cell(0,6,'Servicios de Informacion Tecnologica y de Propiedad Industrial',0,1,'C');
	$this->SetFont('Arial','',10);
   $this->Cell(0,7,'Servicios Especializados Tramite WEBPI No: '.$titulo.' Referencia No. '.$Referencia,0,1,'C');
  	$this->SetFont('Arial','',9);
	   
	//Ensure table header is output
	parent::Header();
}

//Pie de página
function Footer()
{
    //Posición: a 2,0 cm del final
    $this->SetY(-20);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	// $this->Cell(0,10,'Fecha: '.$this->Date('d/m/y'),0,0,'L');
	 $this->Text(10,265,"Fecha:");
	 $this->text(20,265,date('d/m/y'),0,1); 
	 $this->Text(185,265,"Hora:");
	 $this->text(192,265,date('h:i A'),0,1); 
	 	 
 }

    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

}//end of PDF_Table class
error_reporting(E_ALL);

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

//Encabezado
   $pdf->ln(2);
   $pdf->Cell(30,5,'Marcas del Titular:',0,0); 
   $pdf->Cell(130,5,utf8_decode($vpeticionario),0,0);
   $pdf->Cell(25,5,'Nro. Peticionario:',0,0);
   $pdf->Cell(100,5,$numpet,0,1);
   $pdf->Cell(20,5,'Solicitante:',0,0);
   $pdf->Cell(90,5,utf8_decode($vsolicitante),0,1);
   $pdf->Cell(29,5,'Correo Solicitante:',0,0);
   $pdf->Cell(90,5,$vusremail ,0,1);
 		
// NOMBRE DE LAS COLUMNAS
   $pdf->ln(4);
   $pdf->Cell(80,8,'Nombre Marca',1,0,'C'); 
   $pdf->Cell(15,8,'Clase',1,0,'C'); 
   $pdf->Cell(20,8,'Inscripcion',1,0,'C'); 
   $pdf->Cell(15,8,'Estatus',1,0,'C'); 
   $pdf->Cell(20,8,'Registro',1,0,'C'); 
   $pdf->Cell(20,8,'Fecha',1,0,'C'); 
   $pdf->Cell(25,8,'Vencimiento',1,1,'C');

   if (!$filas_found) {
   $pdf->Cell(80,5,'NO HAY ANTERIORIDADES DE PETICIONARIOS SOLICITADAS',0,1);}

   $reg = pg_fetch_array($resultado);  

   for($cont=0;$cont<$filas_found;$cont++)   { 
      $pdf->SetFont('Arial','',8);  
      $pdf->Cell(80,5,substr($reg['nombre'],0,40),0,0);     
      $pdf->Cell(15,5, $reg['clase'].'-'.$reg['ind_claseni'],0,0);
      $pdf->Cell(20,5,$reg['solicitud'],0,0);
      $pdf->Cell(15,5,$reg['estatus']-1000,0,0);
      $pdf->Cell(20,5, $reg['registro'],0,0);
      $pdf->Cell(20,5,$reg['fecha_regis'],0,0);
      $pdf->Cell(20,5,$reg['fecha_venc'],0,1);
                        
      $reg = pg_fetch_array($resultado);
   }
      $pdf->ln(3);

//Guarda Informacion del peticionario
 pg_exec("BEGIN WORK");
 pg_exec("LOCK TABLE stzpetit IN SHARE ROW EXCLUSIVE MODE");
 $monto=0;
 $hora=hora();
// $hora="";  
 $fechahoy = hoy();
// $fechahoy = "";
 $insert_campos="pedido,f_carga,hora,solicitante,denominacion,recibo,tipo,f_recibo,monto,modo,usuario";
 $insert_valores ="$numpet,'$fechahoy','$hora','$solicit','$titular','$titulo','M','$fecha',$monto,'$tipo','$usuario'";
 echo "$insert_valores";
 $sql->insert("stzpetit","$insert_campos","$insert_valores","");
 pg_exec("COMMIT WORK");
}
else {
$npedido = "BP".$vtipopet.str_pad($npedido,6,"0",STR_PAD_LEFT); 
$archivo   = $rutafinal.trim($npedido).".pdf";

//Query para buscar las solicitudes asociadas al titular
pg_exec("CREATE TEMPORARY TABLE stppeticion (solicitud,fecha_solic,nombre,estatus,registro,fecha_regis,fecha_venc,tipo_paten) AS 
  		 SELECT e.solicitud, e.fecha_solic, e.nombre, e.estatus, e.registro, e.fecha_regis, e.fecha_venc, e.tipo_derecho
		     FROM stppatee a, stzwordpet b, stzottid c, stzsolic d, stzderec e
		     WHERE b.titular = d.titular 
 		     AND c.titular = d.titular 
		     AND c.nro_derecho=a.nro_derecho
		     AND e.nro_derecho=a.nro_derecho
		     AND b.codigo = '$numpet' 
	             ORDER BY e.solicitud ");	
$resultado=pg_exec("select * from stppeticion order by solicitud");

//verificando los resultados
if (!$resultado) { 
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: No existen los datos correspondientes ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado);

$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF para generar los reportes
class PDF_Table extends FPDF

{
var $tb_columns; 		//number of columns of the table
var $tb_header_type; 	//array which contains the header characteristics and texts
var $tb_data_type; 		//array which contains the data characteristics (only the characteristics)
var $tb_table_type; 	//array which contains the table charactersitics
var $table_startx, $table_starty;	//the X and Y position where the table starts

//returns the width of the page in user units

function PageWidth(){
	return (int) $this->w-$this->rMargin-$this->lMargin;
}

function Header()
{
	global $titulo;
	global $total;
	global $Referencia;
	//Title
	$this->SetFont('Arial','',15);
	//$this->Image("../imagenes/sapi.jpg",10,3,30,29,'JPG');
	$this->Image("../imagenes/logo_sapi_nuevo.jpg",10,5,30,28,'JPG');
	$this->Cell(0,6,'Sistema de Patentes',0,1,'C');
   $this->SetFont('Arial','',10);
	$this->Cell(0,6,'Servicios de Informacion Tecnologica y de Propiedad Industrial',0,1,'C');
	$this->SetFont('Arial','',10);
   $this->Cell(0,7,'Servicios Especializados Tramite WEBPI No: '.$titulo.' Referencia No. '.$Referencia,0,1,'C');
  	$this->SetFont('Arial','',9);
	   
	//Ensure table header is output
	parent::Header();
}

//Pie de página
function Footer()
{
    //Posición: a 2,0 cm del final
    $this->SetY(-20);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	// $this->Cell(0,10,'Fecha: '.$this->Date('d/m/y'),0,0,'L');
	 $this->Text(10,265,"Fecha:");
	 $this->text(20,265,date('d/m/y'),0,1); 
	 $this->Text(185,265,"Hora:");
	 $this->text(192,265,date('h:i A'),0,1); 
	 	 
 }

    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

}//end of PDF_Table class
error_reporting(E_ALL);

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

if ($filas_found==0)
   {
    $pdf->ln(2);
    $pdf->Cell(30,5,'Patentes del Titular:',0,0); 
    $pdf->Cell(130,5,utf8_decode($vpeticionario),0,0);
    $pdf->Cell(25,5,'Nro. Peticionario:',0,0);
    $pdf->Cell(100,5,$numpet,0,1);
    $pdf->Cell(25,5,'Solicitante:',0,0);
    $pdf->Cell(90,5,utf8_decode($vsolicitante),0,1);
    $pdf->Cell(29,5,'Correo Solicitante:',0,0);
    $pdf->Cell(90,5,$vusremail ,0,1);
    $pdf->ln(4);
    $pdf->Cell(28,8,'Inscripcion',1,0,'C'); 
    $pdf->Cell(25,8,'Fecha',1,0,'C'); 
    $pdf->Cell(37,8,'Tipo',1,0,'C'); 
    $pdf->Cell(25,8,'Estatus',1,0,'C'); 
    $pdf->Cell(25,8,'Registro',1,0,'C'); 
    $pdf->Cell(25,8,'Fecha Reg',1,0,'C'); 
    $pdf->Cell(25,8,'Vencimiento',1,1,'C'); 
    $pdf->ln(1);
    $pdf->Cell(25,5,'NO HAY ANTERIORIDADES DE PETICIONARIOS SOLICITADAS',0,1);
   }  
else {
   //Encabezado
   $pdf->ln(2);
   $pdf->Cell(30,5,'Patentes del Titular:',0,0); 
   $pdf->Cell(130,5,utf8_decode($vpeticionario),0,0);
   $pdf->Cell(25,5,'Nro. Peticionario:',0,0);
   $pdf->Cell(100,5,$numpet,0,1);
   $pdf->Cell(25,5,'Solicitante:',0,0);
   $pdf->Cell(90,5,utf8_decode($vsolicitante),0,1);
   $pdf->Cell(29,5,'Correo Solicitante:',0,0);
   $pdf->Cell(90,5,$vusremail ,0,1);
 		
// NOMBRE DE LAS COLUMNAS
   $pdf->ln(4);
   $pdf->Cell(28,8,'Inscripcion',1,0,'C'); 
   $pdf->Cell(25,8,'Fecha',1,0,'C'); 
   $pdf->Cell(37,8,'Tipo',1,0,'C'); 
   $pdf->Cell(25,8,'Estatus',1,0,'C'); 
   $pdf->Cell(25,8,'Registro',1,0,'C'); 
   $pdf->Cell(25,8,'Fecha',1,0,'C'); 
   $pdf->Cell(25,8,'Caducidad',1,1,'C'); 
      
   for($cont=0;$cont<$filas_found;$cont++)   { 

      $vtip=tipo_patente($reg['tipo_paten']);
      $pdf->SetFont('Arial','',8);  
      $pdf->Cell(28,5,$reg['solicitud'],0,0);     
      $pdf->Cell(25,5, $reg['fecha_solic'],0,0);
      $pdf->Cell(37,5,$vtip,0,0);
      $pdf->Cell(25,5,$reg['estatus']-1000,0,0);
      $pdf->Cell(25,5, $reg['registro'],0,0);
      $pdf->Cell(25,5,$reg['fecha_regis'],0,0);
      $pdf->Cell(25,5,$reg['fecha_venc'],0,1);
      $pdf->ln(1);
      $pdf->MultiCell(190,5,'Titulo Tec.: '.trim($reg['nombre']),0,J);     
      $reg = pg_fetch_array($resultado);
   }
      $pdf->ln(3);

//Guarda Informacion del peticionario
 pg_exec("BEGIN WORK");
 pg_exec("LOCK TABLE stzpetit IN SHARE ROW EXCLUSIVE MODE");
 $monto=0;
 $hora=hora();  
 $fechahoy = hoy();
 $insert_campos="pedido,f_carga,hora,solicitante,denominacion,recibo,tipo,f_recibo,monto,modo,usuario";
 $insert_valores ="$numpet,'$fechahoy','$hora','$solicit','$titular','$titulo','P','$fecha',$monto,'$tipo','$usuario'";
 $sql->insert("stzpetit","$insert_campos","$insert_valores","");
 pg_exec("COMMIT WORK");
}
	
}  

$fechahoy = hoy();
$horactual = Hora();
$update_str = "estado='2',fecha_proceso='$fechahoy',hora_proceso='$horactual',user_proceso='$usuario'";
$act_ref = $sql->update("stzbuspet","$update_str","tipo_busq='$vtipopet' AND ref_busq='$reftram'"); 

//Desconexion a la base de datos
$sql->disconnect();

//header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output($archivo);

$smarty->display('encabezado1.tpl');
mensajenew('Archivo PDF con Resultado Generado ...!!!','z_rptpetiweb.php','N');
$smarty->display('pie_pag.tpl'); exit();

?>
