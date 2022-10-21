<?php
// Programa de peticionario de patentes (reporte)
// Realizado por: Ing. Karina Perez

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

//Conexion
$sql = new mod_db();
$sql->connection($login);

$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Reporte de Peticionario');
$smarty->assign('login',$login);

//Validacion de Entrada
$titulo=$_POST["recibo"];
$fecha=$_POST["fecha"];
$numpet=$_POST["numpet"];
$titular=$_POST["titular"];
$solicit=$_POST["solicit"];
$tipo=$_POST["tipo"];
$nconex = $_POST['nconex'];


// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("titulo","fecha","numpet","titular","solicit","tipo");
  $valores = array($titulo,$fecha,$numpet,$titular,$solicit,$tipo);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

if ($tipo!= 'A') {
  if ($tipo!='B') {
    $smarty->display('encabezado1.tpl');
    mensajenew('SOLO PUEDEN SER BUSQUEDAS EN TIPO A O B ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
}

//Query para buscar las solicitudes asociadas al titular
pg_exec("CREATE TEMPORARY TABLE stppeticion (solicitud,fecha_solic,nombre,estatus,registro,fecha_regis,fecha_venc,tipo_paten) AS 
  		 SELECT e.solicitud, e.fecha_solic, e.nombre, e.estatus, e.registro, e.fecha_regis, e.fecha_venc, e.tipo_derecho
		     FROM stppatee a, wordtitu b, stzottid c, stzsolic d, stzderec e
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
    mensajenew('No existen los datos correspondientes ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado);

$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);  
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
	//Title
	$this->SetFont('Arial','',15);
	$this->Image("../imagenes/sapi.jpg",10,3,30,29,'JPG');
	$this->Cell(0,6,'Sistema de Patentes',0,1,'C');
   $this->SetFont('Arial','',10);
	$this->Cell(0,6,'Servicios de Informacion Tecnologica y de Propiedad Industrial',0,1,'C');
	//$this->Image("imagenes/milco1.jpg",160,5,40,10,'JPG');
	$this->SetFont('Arial','',10);
	//$this->Cell(0,7,'Servicios Especializados Nro:',0,1,'C');
   $this->Cell(0,7,'Servicios Especializados Nro: '.$titulo,0,1,'C');
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
    $pdf->Cell(30,8,'Patentes del Titular:',0,0); 
    $pdf->Cell(130,8,$titular,0,0);
    $pdf->Cell(25,8,'Nro. Peticionario:',0,0);
    $pdf->Cell(100,8,$numpet,0,1);
    $pdf->Cell(25,8,'Solicitante:',0,0);
    $pdf->Cell(90,8,$solicit,0,1);
    $pdf->ln(4);
    $pdf->Cell(28,8,'Inscripcion',1,0,'C'); 
    $pdf->Cell(25,8,'Fecha',1,0,'C'); 
    $pdf->Cell(37,8,'Tipo',1,0,'C'); 
    $pdf->Cell(25,8,'Estatus',1,0,'C'); 
    $pdf->Cell(25,8,'Registro',1,0,'C'); 
    $pdf->Cell(25,8,'Fecha Reg',1,0,'C'); 
    $pdf->Cell(25,8,'Caducidad',1,1,'C'); 
    $pdf->Cell(25,5,'NO HAY ANTERIORIDADES DE PETICIONARIOS SOLICITADAS',0,1);
	 //$sql->disconnect();
    //exit();
   }  
else {
   //Encabezado
    $pdf->ln(2);
    $pdf->Cell(30,5,'Patentes del Titular:',0,0); 
    $pdf->Cell(130,5,$titular,0,0);
    $pdf->Cell(25,5,'Nro. Peticionario:',0,0);
    $pdf->Cell(100,5,$numpet,0,1);
    $pdf->Cell(25,5,'Solicitante:',0,0);
    $pdf->Cell(90,5,$solicit,0,1);
 		
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

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
