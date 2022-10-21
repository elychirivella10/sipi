<?php
//Programa de Certificados de Derecho de Autor. Todas las Planillas menos las de Actos y Contratos.
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
//require ("$include_lib/PDF_table.php");
require ("$include_lib/jlpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Funciones
//Formato de Cedulas
function cedula($ced){
  $cadena=(string)$ced;
  $letra=substr($cadena,-10,1);
  if ($letra=='V' or $letra=='E') {
  $ult3=substr($cadena,7,3);
  $ant3=substr($cadena,4,3);
  $pri2=substr($cadena,1,3);
  $cedula= $letra.'-'.(string)(int)$pri2.'.'.$ant3.'.'.$ult3;}
  else {
  $pri=substr($cadena,1,9);
  $cedula= $letra.'-'.(string)(int)$pri;}
return ($cedula);
}

function consultar($idsol,$nderec) {
	$resul_tit=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion FROM stzsolic,stdobtit WHERE stzsolic.identificacion = '$idsol' and stdobtit.nro_derecho = '$nderec' and stzsolic.titular = stdobtit.titular ");
	$regis = pg_fetch_array($resul_tit);
        $nombre= $regis['nombre']; $cedula=$regis['identificacion']; 
   return array($cedula,$nombre);
 }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection();

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados de Actos y Contratos');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
//Validacion de Entrada
$vsold=$_POST["vsold"];
$vsolh=$_POST["vsolh"];
$egc=$_POST["egc"];
$log=substr($login,0,2);

if ($vsold=='' || $vsolh=='') {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl');
	 $sql->disconnect(); exit(); 
}

//Query para buscar los certificados de dnda en el rango correspondiente
if(!empty($vsold) and !empty($vsolh)) {  
   $resultado=pg_exec("SELECT * FROM stdobras WHERE stdobras.solicitud BETWEEN '$vsold' AND '$vsolh' ORDER BY solicitud");
}

//verificando los resultados
if (!$resultado) { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); } 

$reg = pg_fetch_array($resultado);

if ($reg['tipo_obra']<>'AC') { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Esta obra no es del tipo Actos y Contratos; no puede generar el Certificado desde esta opcion...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }


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

$pdf=new PDF_Table('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial','',9);
$pdf->Image('../imagenes/cintillo2018.png',12,60,190,12,'PNG');

//Datos del certificado
	
for($cont=0;$cont<$filas_found;$cont++)   { 

// Modelo de la Planilla

// Encabezado 
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(14,84); $pdf->MultiCell(0,5,utf8_decode('DIRECCIÓN NACIONAL DE DERECHO DE AUTOR '),0,'J');
$pdf->SetXY(14,89); $pdf->MultiCell(0,5,utf8_decode('REGISTRO DE LA PRODUCCIÓN INTELECTUAL'),0,'J');
// Area datos del certificado 1era parte 
$pdf->SetFillColor(230);
//inscripcion
$pdf->SetXY(65,100); $pdf->RoundedRect(42, 100, 40, 14, 3.5, 'F');
//tipo de obra
$pdf->SetXY(95,100); $pdf->RoundedRect(152, 100, 45, 14, 3.5, 'F');

//Datos de base de datos
    $varsol=$reg['solicitud'];
    $nregis=$reg['registro'];
    $nderec=$reg['nro_derecho'];
    $resul_actos=pg_exec("SELECT * FROM stdactos WHERE nro_derecho = '$nderec'");
    $regac = pg_fetch_array($resul_actos);
  if ($reg['tipo_obra']=='AC') {$vtip= 'Actos y Contratos';}
    $pdf->SetFont('Arial','',9);
    $pdf->Setxy(44,101);
    $pdf->Cell(75,4,$reg['registro'],0,1); 
    $pdf->Setxy(44,105);
    $pdf->Cell(75,4,$reg['fecha_regis'],0,1);
    $pdf->Setxy(44,109);
    $pdf->Cell(75,4,$reg['solicitud'],0,0);
    $pdf->Setxy(154,102);
    $pdf->MultiCell(35,4,$vtip,0,'C');

//solicitante
$pdf->RoundedRect(14, 120, 185, 20, 3.5, 'F');

//Solicitante
$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1, stdobsol.caracter, stdobsol.prueba_repres   FROM stzsolic,stdobsol WHERE  stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular ");
$regis_sol = pg_fetch_array($resul_sol);

//coletilla del solicitante
$ced=$regis_sol['identificacion'];
$cedula_sol=cedula($ced);
$letra=substr($cedula_sol,0,1);
 if ($letra=='V' or $letra=='E') {
  $texto_solicitante= $regis_sol['nombre'].",  CÉDULA. N° ".$cedula_sol;}
 else {
  if (trim($cedula_sol)=='' or empty($cedula_sol) or $cedula_sol=='J000000000') {
        $texto_solicitante= " ".$regis_sol['nombre']; }
     else { 
        $texto_solicitante= " ".$regis_sol['nombre'].",  RIF N° ".$cedula_sol;}
 }
 
   if (trim($regis_sol['caracter'])=='A') {$tipoc='AUTOR';}
   if (trim($regis_sol['caracter'])=='N') {$tipoc='EN NOMBRE DEL TITULAR';}
   if (trim($regis_sol['caracter'])=='T') {$tipoc='COMO TITULAR DERIVADO';}
   if (trim($regis_sol['caracter'])=='P') {$tipoc='PARTES QUE INTERVIENEN';}
   if (trim($regis_sol['caracter'])=='C') {$tipoc='POR CESION';}
   if (trim($regis_sol['caracter'])=='H') {$tipoc='HEREDERO';}
   if (trim($regis_sol['caracter'])=='O') {$tipoc='OTRO';}
   $texto_caracter= 'CARACTER CON EL QUE ACTUA: '.$tipoc;
   if (!empty($regis_sol['otro_caracter'])){
       $texto_caracter= 'OTRO CARACTER CON EL QUE ACTUA: '.$regis_sol['otro_caracter'];}
   if (!empty($regis_sol['prueba_repres'])) {
       $texto_caracter= 'PRUEBA, REPRESENTACIÓN,TRANSFERENCIA, DERECHOS: '.$regis_sol['prueba_repres']; }
$pdf->SetFont('Arial','',7);
$pdf->SetXY(16,121);$pdf->Multicell(180,4,utf8_decode($texto_solicitante).' '. UTF8_DECODE($texto_caracter),0,'J');

$pdf->SetFont('Arial','B',9);
$fil=99; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'REGISTRO:');
$pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'FECHA:');
$pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('INSCRIPCIÓN:'));

$pdf->SetXY(124,105);$pdf->Cell(0,0,'TIPO DE OBRA:');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,118); $pdf->Cell(0,0,'SOLICITANTE:');

$pdf->SetXY(14,143); $pdf->Cell(0,0,'PARTES QUE INTERVIENEN:');
$pdf->SetFillColor(230);
$pdf->SetXY(14,77); $pdf->RoundedRect(14, 145, 185, 25, 3.5, 'F');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(16,146);$pdf->Multicell(180,3.5,trim(utf8_decode($regac['partes'])),0,'J');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,173); $pdf->Cell(0,0,'NATURALEZA DEL ACTO O CONTRATO:');
$pdf->SetFillColor(230);
$pdf->SetXY(14,77); $pdf->RoundedRect(14, 175, 185, 20, 3.5, 'F');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(16,176);$pdf->Multicell(180,4,trim(utf8_decode($regac['naturaleza'])),0,'J');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,198); $pdf->Cell(0,0,'OBJETO:');
$pdf->SetFillColor(230);
$pdf->SetXY(14,77); $pdf->RoundedRect(14, 200, 185, 20, 3.5, 'F');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(16,201);$pdf->Multicell(180,4,trim(utf8_decode($regac['objeto'])),0,'J');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,223); $pdf->Cell(0,0,utf8_decode('DERECHOS O MODALIDADES DE EXPLOTACIÓN:'));
$pdf->SetFillColor(230);
$pdf->SetXY(14,77); $pdf->RoundedRect(14, 225, 185, 18, 3.5, 'F');
$pdf->SetFont('Arial','',7);
$pdf->SetXY(16,226);$pdf->Multicell(180,4,trim(utf8_decode($regac['derechos'])),0,'J');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,246); $pdf->Cell(0,0,'CARACTERISTICAS DEL ACTO O CONTRATO:');
$pdf->SetFillColor(230);
$pdf->SetXY(14,77); $pdf->RoundedRect(14, 249, 185, 25, 3.5, 'F');
$pdf->SetFont('Arial','',7);

//Caracteriticas
    if ($regac['tipo_cuantia']=='G') {$caract= $caract.' - '.utf8_decode('CUANTÍA DEL ACTO O CONTRATO: A TÍTULO GRATUITO');}
    if ($regac['tipo_cuantia']=='O') {$caract= $caract.' - '.utf8_decode('CUANTÍA DEL ACTO O CONTRATO: A TÍTULO ONEROSO');}
    if (!empty($regac['espec_cuantia'])) {$caract= $caract.' - '.utf8_decode('ESPECIFICAR CUANTÍA: ').trim(utf8_decode($regac['espec_cuantia']));}
    $caract= $caract.' - '.utf8_decode('DURACIÓN/PLAZO: ').trim(utf8_decode($regac['duracion']));
    $caract= $caract.' - '.utf8_decode('LUGAR DE LA FIRMA: ').trim(utf8_decode($regac['domicilio']));
    $caract= $caract.' - '.utf8_decode('FECHA DE LA FIRMA: ').trim($regac['fecha_firma']);
    $caract= $caract.' - '.utf8_decode('DATOS DE REGISTRO/NOTARIA: ').trim(utf8_decode($regac['datosregistro']));
$pdf->SetXY(16,249);$pdf->Multicell(180,4,$caract,0,'J');

$pdf->SetFont('Arial','B',8);

// Area de TEXTO
if ($egc==0) {
   $pdf->SetXY(14,275); $pdf->MultiCell(0,5,utf8_decode('EL REGISTRO DE LA PRODUCCIÓN INTELECTUAL, OTORGA LA PRESENTE CERTIFICACIÓN, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTICULO 105 DE LA LEY SOBRE EL DERECHO DE AUTOR. '),0,'J');
}
if ($egc==1) {
   $pdf->SetXY(14,275); $pdf->MultiCell(0,5,utf8_decode('EL REGISTRO DE LA PRODUCCIÓN INTELECTUAL, OTORGA LA PRESENTE CERTIFICACIÓN, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTICULO 30 NUMERAL 1 DEL REGLAMENTO DE LA LEY SOBRE EL DERECHO DE AUTOR. '),0,'J');
}
// Area derechos de registros 
$pdf->SetFillColor(230);
$pdf->SetXY(164,83); $pdf->RoundedRect(135, 287, 69, 25, 3.5, 'F');
$pdf->SetFont('Arial','B',8);
$fil=287; $inc=4; 
$pdf->SetXY(137,$fil+($inc*1));$pdf->Cell(0,0,'DERECHOS DE REGISTRO:');
$pdf->SetXY(137,$fil+($inc*2));$pdf->Cell(0,0,'Tasa Inicial:');
$pdf->SetXY(137,$fil+($inc*3));$pdf->Cell(0,0,'Planilla:____________  Fecha: _________ (U.T.1)');
$pdf->SetXY(137,$fil+($inc*4));$pdf->Cell(0,0,'Derechos de Registro:');
$pdf->SetXY(137,$fil+($inc*5));$pdf->Cell(0,0,'Planilla:____________  Fecha: _________ (U.T.5)');


// Verificando la exoneracion de pago
$resultado5=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '67' ");   
$filas_found5=pg_numrows($resultado5);
if ($filas_found5==0) {
   //Tasa inicial
   $resultado4=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '64' ");   
   $filas_found4=pg_numrows($resultado4);
   $reg4 = pg_fetch_array($resultado4);
   $plan_ini= $reg4['documento'];
   $fecha_ini= $reg4['fecha_event'];
   //Tasa Derechos
   $resultado3=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '65' ");   
   $filas_found3=pg_numrows($resultado3);
   if ($filas_found3==0) {
     $resultado3=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '66' ");   
   }
   $reg3 = pg_fetch_array($resultado3);
   $plan_der= $reg3['documento'];
   $fecha_der= $reg3['fecha_event'];
   $texto_tasa= "La tasa inicial según planilla "."[b]N° ".$plan_ini."[/b] de fecha".$fecha_ini.", es de una unidad tributaria (U.T.1) y los Derechos de Registro según planilla "."[b]N° ".$plan_der."[/b] de fecha ".$fecha_der.", son: cinco unidades tributarias (U.T.5). ";
}
else {
  $plan_ini="exento"; $fecha_ini="exento";
  $plan_der="exento"; $fecha_der="exento"; 
}

$pdf->SetFont('Arial','',7);
$pdf->SetXY(154,299);$pdf->Cell(0,0,$plan_ini);
$pdf->SetXY(178,299);$pdf->Cell(0,0,$fecha_ini);
$pdf->SetXY(154,307);$pdf->Cell(0,0,$plan_der);
$pdf->SetXY(178,307);$pdf->Cell(0,0,$fecha_der);

// firma y leyenda
$pdf->SetFont('Arial','B',9);
$fil=286; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'__________________________________________');
$pdf->SetXY(22,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('    ROSALBA FEGHALI GEBRAEL'));
$pdf->SetXY(21,$fil+($inc*3));$pdf->Cell(0,0,'Directora Nacional de Derecho de Autor');
$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(20,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode('Resolución No 020/2022, de fecha 24/03/2022'));
$pdf->SetXY(15,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('Publicado en Gaceta Oficial 42.352 de fecha 24/03/2022'));
$pdf->SetFont('Arial','',7);
$pdf->SetXY(15,307);
//$pdf->MultiCell(30,4,utf8_decode('MM/'.$log),0,'L');
//Fin de certificado


    
    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage();}

  }  

   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
