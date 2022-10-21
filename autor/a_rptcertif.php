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
  $pri=substr($cadena,2,9);
 // $cedula= $letra.'-'.(string)(int)$pri;}
  $cedula= $ced;}
return ($cedula);
}

function consultar($idsol,$nderec) {
	$resul_tit=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stzsolic.tipo_persona FROM stzsolic,stdobtit WHERE stzsolic.identificacion = '$idsol' and stdobtit.nro_derecho = '$nderec' and stzsolic.titular = stdobtit.titular ");
	$regis = pg_fetch_array($resul_tit);
   $nombre= $regis['nombre']; $cedula=$regis['identificacion']; $tipo_per=$regis['tipo_persona']; 
   return array($cedula,$nombre,$tipo_per);
 }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection();

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
//Validacion de Entrada
$vsold=$_POST["vsold"];
$vsolh=$_POST["vsolh"];
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

if ($reg['tipo_obra']=='PF') { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Esta obra es del tipo: Produccion Fonografica y debe generar el Certificado desde otra opcion...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if ($reg['tipo_obra']=='AC') { 
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: Esta obra es del tipo: Actos y Contratos y debe generar el Certificado desde otra opcion...!!!','javascript:history.back();','N');   
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
//$pdf->Image('../imagenes/cintillo2015.jpg',12,60,190,12,'JPEG');
//$pdf->Image('../imagenes/cintillo2015.png',12,60,190,12,'PNG');
$pdf->Image('../imagenes/cintillo2018.png',12,60,190,12,'PNG');
//Datos del certificado
	
for($cont=0;$cont<$filas_found;$cont++)   { 

// Modelo de la Planilla

// Encabezado 
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(12,84); $pdf->MultiCell(0,5,utf8_decode('DIRECCIÓN NACIONAL DE DERECHO DE AUTOR '),0,'J');
$pdf->SetXY(12,89); $pdf->MultiCell(0,5,utf8_decode('REGISTRO DE LA PRODUCCIÓN INTELECTUAL'),0,'J');

$pdf->SetFillColor(230);
//inscripcion
$pdf->SetXY(65,100); $pdf->RoundedRect(42, 100, 35, 14, 3.5, 'F');
//tipo de obra


// Area datos del certificado 1era parte 
$pdf->SetFont('Arial','B',9);
$fil=99; $inc=4; 
$pdf->SetXY(12,$fil+($inc*1));$pdf->Cell(0,0,'REGISTRO:');
$pdf->SetXY(12,$fil+($inc*2));$pdf->Cell(0,0,'FECHA:');
$pdf->SetXY(12,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('INSCRIPCIÓN:'));
$pdf->SetFillColor(230);
//$pdf->SetXY(65,64); $pdf->RoundedRect(42, 64, 40, 14, 3.5, 'F');

$pdf->SetXY(91,98);$pdf->Cell(0,0,'TIPO DE OBRA');
$pdf->SetXY(138,98);$pdf->Cell(0,0,UTF8_DECODE('CLASIFICACIÓN DE LA OBRA'));
$pdf->SetFillColor(230);
$pdf->SetXY(70,63); $pdf->RoundedRect(82, 100, 43, 14, 3.5, 'F');
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(139,102);$pdf->Cell(0,0,UTF8_DECODE('Inédita'));
$pdf->SetXY(100,100); $pdf->RoundedRect(133, 100, 6, 4, 1.5, 'F');
$pdf->SetXY(160,102);$pdf->Cell(0,0,UTF8_DECODE('Originaria'));
$pdf->SetXY(100,100); $pdf->RoundedRect(154, 100, 6, 4, 1.5, 'F');
$pdf->SetXY(180,102);$pdf->Cell(0,0,UTF8_DECODE('Individual'));
$pdf->SetXY(100,100); $pdf->RoundedRect(174, 100, 6, 4, 1.5, 'F');
$pdf->SetXY(139,107);$pdf->Cell(0,0,UTF8_DECODE('Publicada'));
$pdf->SetXY(100,103); $pdf->RoundedRect(133, 105, 6, 4, 1.5, 'F');
$pdf->SetXY(160,107);$pdf->Cell(0,0,UTF8_DECODE('Derivada'));
$pdf->SetXY(100,103); $pdf->RoundedRect(154, 105, 6, 4, 1.5, 'F');

$pdf->SetXY(180,107);$pdf->Cell(0,0,UTF8_DECODE('Colaboración'));
$pdf->SetXY(100,103); $pdf->RoundedRect(174, 105, 6, 4, 1.5, 'F');
$pdf->SetXY(180,112);$pdf->Cell(0,0,UTF8_DECODE('Colectiva'));
$pdf->SetXY(100,111); $pdf->RoundedRect(174, 110, 6, 4, 1.5, 'F');


$pdf->SetXY(139,113);$pdf->Cell(0,0,UTF8_DECODE('Ejemp.Depositados'));
$pdf->SetXY(100,110); $pdf->RoundedRect(133, 111, 6, 4, 1.5, 'F');

//tipo de obra
  if ($reg['tipo_obra']=='OL') {$vtip= 'Registro de Obras Literarias';}
  if ($reg['tipo_obra']=='AV') {$vtip= 'Registro de Obras de Arte Visual';}
  if ($reg['tipo_obra']=='OE') {$vtip= 'Registro de Obras Escenicas';}
  if ($reg['tipo_obra']=='OM') {$vtip= 'Registro de Obras Musicales';}
  if ($reg['tipo_obra']=='AR') {$vtip= 'Registro de Obras Audiovisuales y Radiofónicas';}
  if ($reg['tipo_obra']=='PC') {$vtip= 'Programas de Computación y Base de Datos';}
  if ($reg['tipo_obra']=='PF') {$vtip= 'Registro de Obras de Producciones Fonografícas';}
  if ($reg['tipo_obra']=='IE') {$vtip= 'Registro de Interpretaciones y Ejecuciones Artisticas';}

 $varsol=$reg['solicitud'];
 $nregis=$reg['registro'];
 $nderec=$reg['nro_derecho'];

    $pdf->SetFont('Arial','',9);
    $pdf->Setxy(44,101);
    $pdf->Cell(75,4,$reg['registro'],0,1); 
    $pdf->Setxy(44,105);
    $pdf->Cell(75,4,$reg['fecha_regis'],0,1);
    $pdf->Setxy(44,109);
    $pdf->Cell(75,4,$reg['solicitud'],0,0);
    $pdf->Setxy(86,102);
    $pdf->MultiCell(35,4,utf8_decode($vtip),0,'C');
    $pdf->Setxy(190,69);

//Clasificación
  if ($reg['clase']=='I') {$pdf->SetXY(134,102);$pdf->Cell(0,0,'X');}
  if ($reg['clase']=='P') {$pdf->SetXY(134,108);$pdf->Cell(0,0,'X');}
  if ($reg['origen']=='O') {$pdf->SetXY(155,102);$pdf->Cell(0,0,'X');}
  if ($reg['origen']=='D') {$pdf->SetXY(155,108);$pdf->Cell(0,0,'X');}
  if ($reg['forma']=='I') {$pdf->SetXY(175,102);$pdf->Cell(0,0,'X');}
  if ($reg['forma']=='E') {$pdf->SetXY(175,108);$pdf->Cell(0,0,'X');}
  if ($reg['forma']=='C') {$pdf->SetXY(175,111);$pdf->Cell(0,0,'X');}

//Depositos
$res_dep=pg_exec("SELECT * FROM stdobras WHERE nro_derecho='$nderec'");
$resdep = pg_fetch_array($res_dep);
$pdf->SetXY(135,113);$pdf->Cell(0,0,$resdep['n_ejemplares']);

//titulo de la obra
$pdf->SetFont('Arial','B',9);
$fil=118; $inc=4; 
$pdf->SetXY(12,$fil+($inc*1));$pdf->Cell(0,0,'TITULO DE LA OBRA:');
$pdf->SetFillColor(230);
$pdf->SetXY(65,83); $pdf->RoundedRect(49, 119, 145, 20, 3.5, 'F');
$pdf->SetFont('Arial','',9);
$fil=84; $inc=4; 
$pdf->SetXY(52,119);$pdf->Multicell(140,4,utf8_decode($reg['titulo_obra']),0,'J');

// solitantes, autores, titulares
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(12,144);$pdf->Cell(0,0,'SOLICITANTE(S):');
$pdf->SetFillColor(230);
$pdf->SetXY(65,83); $pdf->RoundedRect(49, 142, 145, 30, 3.5, 'F');

//Solicitante
$resul_sol=pg_exec("SELECT stzsolic.tipo_persona,stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1, stdobsol.caracter, stdobsol.prueba_repres   FROM stzsolic,stdobsol WHERE  stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular ");
$regis_sol = pg_fetch_array($resul_sol);
$vcantreg=pg_numrows($resul_sol); 
//coletilla del solicitante
$texto_solicitante='';
for($contreg=0;$contreg<$vcantreg;$contreg++) {
 $ced=$regis_sol['identificacion'];
 $cedula_sol=cedula($ced);
 $letra=substr($cedula_sol,0,1);
 $tipo_per=$regis_sol['tipo_persona'];
 if (($letra=='V' or $letra=='E') and $tipo_per<>'J') {
    if ($contreg==0) {$texto_solicitante= trim($regis_sol['nombre']).",  C.I. N° ".$cedula_sol;}
    else {$texto_solicitante= $texto_solicitante."; ".trim($regis_sol['nombre']).",  C.I. N° ".$cedula_sol;}
 } else {
  if ($letra=='P') { 
     if ($contreg==0) {$texto_solicitante= trim($regis_sol['nombre']).",  Pasaporte N° ".$cedula_sol;}
     else {$texto_solicitante= $texto_solicitante."; ".trim($regis_sol['nombre']).",  Pasaporte N° ".$cedula_sol;} 
  } else {
     if ($cedula_sol=='V-83.155.325') {$cedula_sol='V083155325';}
     if (trim($cedula_sol)=='' or empty($cedula_sol) or $cedula_sol=='J000000000') {
        if ($contreg==0) {$texto_solicitante= trim($regis_sol['nombre']); }
        else {$texto_solicitante= $texto_solicitante."; ".trim($regis_sol['nombre']); }
     } else {  
        if ($contreg==0) {$texto_solicitante= trim($regis_sol['nombre']).",  Rif N° ".$cedula_sol;} 
        else {$texto_solicitante= $texto_solicitante."; ".trim($regis_sol['nombre']).",  Rif N° ".$cedula_sol;}
     }
  }
 }
 $vcaracter=$regis_sol['caracter'];
 $votrocaracter=$regis_sol['otro_caracter'];
 $vprueba_repre=$regis_sol['prueba_repres'];
 $regis_sol = pg_fetch_array($resul_sol);
}
 
   if (trim($vcaracter)=='A') {$tipoc='Autor';}
   if (trim($vcaracter)=='N') {$tipoc='En nombre del titular';}
   if (trim($vcaracter)=='T') {$tipoc='Como titular derivado';}
   if (trim($vcaracter)=='P') {$tipoc='Partes que intervienen';}
   if (trim($vcaracter)=='C') {$tipoc='Por cesion';}
   if (trim($vcaracter)=='H') {$tipoc='Heredero';}
   if (trim($vcaracter)=='O') {$tipoc='Otro';}

   if ($vcantreg>1) {$texto_caracter= 'Caracter con el que actuan: '.$tipoc;} else {$texto_caracter= 'Caracter con el que actua: '.$tipoc;}
   if (!empty($votrocaracter)){
       if ($vcantreg>1) {$texto_caracter= 'Otro Caracter con el que actuan: '.$votrocaracter;} else 
                        {$texto_caracter= 'Otro Caracter con el que actua: '.$votrocaracter;}
   }
   if (!empty($vprueba_repre)){
       $texto_caracter= 'Prueba, Representacion, Transferencia, Derechos: '.$vprueba_repre; }
$pdf->SetFont('Arial','',9);
$pdf->SetXY(52,143);$pdf->Multicell(140,4,utf8_decode($texto_solicitante).'. '.utf8_decode($texto_caracter),0,'J');


//Autores
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,177);$pdf->Cell(0,0,'AUTOR(ES):');
$pdf->SetFillColor(230);
$pdf->SetXY(65,83); $pdf->RoundedRect(49, 175, 145, 30, 3.5, 'F');
$pdf->SetFont('Arial','B',7);
//Autores
 $autor='';
 $resul_aut=pg_exec("SELECT DISTINCT ON (stzsolic.identificacion) stzsolic.identificacion, stzsolic.nombre, stdobaut.titular FROM stzsolic,stdobaut
WHERE stdobaut.nro_derecho = '$nderec' and stzsolic.titular = stdobaut.titular ");
 $regis_aut = pg_fetch_array($resul_aut);
 $filas_found_regaut =pg_numrows($resul_aut);
 for($cont3=0;$cont3<$filas_found_regaut;$cont3++) {
    $resul_seudo=pg_exec("SELECT * FROM stzdaper WHERE titular = '$regis_aut[titular]' ");
    $filas_found_seudo =pg_numrows($resul_seudo);
    $regis_seu = pg_fetch_array($resul_seudo);
    $ced=$regis_aut['identificacion'];
    $cedula=cedula($ced);
    $letra=substr($cedula,0,1);
    $vdesdoc=' ';
    if ($letra=='V' or $letra=='E') {$vdesdoc='C.I.';}
    if ($letra=='P')                {$vdesdoc='Pasaporte';}
    if ($letra=='J' or $letra=='G') {$vdesdoc='Rif';}
    if ($regis_seu['fecha_defun'] =' ') {
       $defun= 0;
    } 
    $seu= strlen(trim($regis_seu['seudonimo']));
    if ((empty($regis_seu['seudonimo'])) or ($seu==0)) {
       if ($defun== 0) {
         $autor= $autor." ".trim($regis_aut['nombre']).", ".$vdesdoc." N° ".$cedula.". ";}
       else {
         $autor= $autor." ".trim($regis_aut['nombre']).", ".$vdesdoc." N° ".$cedula." "."Fallecido. ";}
    } 
    else {
       if ($defun== 0) {
          $autor= $autor." ".trim($regis_aut['nombre']).", ".$vdesdoc." N° ".$cedula." cuyo seudonimo declara ser ".trim($regis_seu['seudonimo']).". ";}
      else {
          $autor= $autor." ".trim($regis_aut['nombre']).", ".$vdesdoc." N° ".$cedula." Fallecido,"." cuyo seudonimo declara ser ".trim($regis_seu['seudonimo']).". ";}
    }
    
    $regis_aut = pg_fetch_array($resul_aut);
    
 }
$pdf->SetFont('Arial','',7);
$pdf->SetXY(52,176);$pdf->Multicell(140,4,utf8_decode($autor),0,'J');

//Agregado por Romulo Mendoza 25/10/2012 
//Productores
$produc='';
$resul_pro=pg_exec("SELECT stzsolic.tipo_persona, stzsolic.nombre, stzsolic.identificacion, stdobpro.domicilio, stzsolic.telefono1   
	FROM stzsolic,stdobpro 
	WHERE  stdobpro.nro_derecho = '$nderec' 
	AND stzsolic.titular = stdobpro.titular  ");
$regis = pg_fetch_array($resul_pro);
$filas_found_regaut =pg_numrows($resul_pro);
for($cont3=0;$cont3<$filas_found_regaut;$cont3++) {
   $cedula=$regis['identificacion'];
   $prif=$regis['identificacion'];
   $letra=substr($cedula,0,1);
   $cedula=cedula($ced);
   $tipo_per=$regis['tipo_persona'];
   //Modificado por Romulo Mendoza 17/02/2011 
   if (($letra=='V' or $letra=='E') and $tipo_per<>'J') {
     $produc= $produc." ".$regis['nombre'].", C.I. "."N° ".$cedula." "; }
   else {
    if ($letra=='P') { 
       $produc= $produc." ".$regis['nombre'].", Pasaporte "."N° ".$cedula." ";
    } else {
       if ($cedula=='V-83.155.325') {$cedula='V083155325';}
       if (trim($cedula)=='' or empty($cedula) or $cedula=='J000000000') {
          $produc= $produc." ".$regis['nombre']." "; }
       else {   
          $produc= $produc." ".$regis['nombre'].", Rif "."N° ".$prif." "; }
    }
   }
   $regis = pg_fetch_array($resul_pro);
}

//titulares
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(12,209); $pdf->Cell(0,0,'TITULAR(ES) DE LOS DERECHOS PATRIMONIALES:');
$pdf->SetFillColor(230);
$pdf->SetXY(12,77); $pdf->RoundedRect(12, 211, 183, 35, 3.5, 'F');
$pdf->SetFont('Arial','',9);
//verificando si tiene titulares de los derechos patrimoniales
$titular='';
$res_tit=pg_exec("SELECT * FROM stdobtit WHERE nro_derecho='$nderec'");
//$restit = pg_fetch_array($res_tit);
$filas_found_regtit =pg_numrows($res_tit);
$restit = pg_fetch_array($res_tit);
$titular='';
for($contreg=0;$contreg<$filas_found_regtit;$contreg++) {
   $idsol= trim($restit['doc_titular']);
   $info = consultar($idsol,$nderec);
   //Modificado por RM 21/08/2017
   //$cedula_sol=cedula($info['0']);
   $cedula_sol=$info['0'];
   $letra=substr($cedula_sol,0,1);
   $tipo_per=$info['2']; 
   if (($letra=='V' or $letra=='E') and $tipo_per<>'J') {
       if ($contreg==0) {
       	if ($reg['solicitud']=="023703") { $titular=$info['1']." Rif N° ".$cedula_sol; } else { 
         $titular=$info['1']." Cédula N° ".$cedula_sol; }
       } else { 
         if ($reg['solicitud']=="023703") { $titular=$titular."; ".$info['1']." Rif N° ".$cedula_sol; } 
         else { $titular=$titular."; ".$info['1']." Cédula N° ".$cedula_sol; }
       }
   }
   else { if ($cedula_sol=='V-83.155.325') {$cedula_sol='V083155325';} 
          if (trim($cedula_sol)=='' or empty($cedula_sol) or $cedula_sol=='J000000000') {
             if ($contreg==0) {$titular=$info['1'];} else {$titular=$titular."; ".$info['1'];} 
          }
          else {   
             if ($contreg==0) {$titular=$info['1']." Rif N° ".$cedula_sol;} else {$titular=$titular."; ".$info['1']." Rif N° ".$cedula_sol."";}
          } 
   }
   $restit = pg_fetch_array($res_tit);
}
   if ($titular=='') {$titular='NO SE HA DECLARADO NINGÚN TITULAR'; }
   $res_tran=pg_exec("SELECT * FROM stdtrans WHERE nro_derecho='$nderec'");
   $restran = pg_fetch_array($res_tran);
   $filas_found_regtran =pg_numrows($res_tran);
   $transtitderpat = utf8_decode(trim($restran['transferencia']));
   if (($filas_found_regtran <> 0) AND (!empty($transtitderpat))) { 
     if ($reg['tipo_obra']!='OE') { 
       $pdf->SetXY(16,213);$pdf->Multicell(175,4,utf8_decode($titular).' - Transferencia: '.utf8_decode($restran['transferencia']),0,'J'); }
     else {
       $pdf->SetXY(16,213);$pdf->Multicell(175,4,utf8_decode($produc).' - Transferencia: '.utf8_decode($restran['transferencia']),0,'J'); }
   } 
   //Modificado 28/09/2015 Romulo Mendoza aqui esta el supuesto error, no se hizo. hay que comentar cuando lo autoricen    
   else { 
     if ($reg['tipo_obra']!='OE') { 
       $pdf->SetXY(16,213);$pdf->Multicell(175,4,utf8_decode($titular),0,'J'); }
     else { 
       $pdf->SetXY(16,213);$pdf->Multicell(175,4,utf8_decode($produc),0,'J'); }
   }
   
// Area de TEXTO
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(12,248); $pdf->MultiCell(181,5,utf8_decode('EL REGISTRO DA FE DE LA EXISTENCIA DE LA OBRA, PRODUCTO O PRODUCCIÓN Y DEL HECHO DE SU DIVULGACIÓN O PUBLICACIÓN. SE PRESUME, SALVO PRUEBA EN CONTRARIO, QUE LAS PERSONAS INDICADAS COMO TITULARES EN LA SOLICITUD, GOZAN DEL DERECHO EXCLUSIVO DEL AUTOR. EL PRESENTE REGISTRO ES MERAMENTE FACULTATIVO Y DECLARATIVO NO CONSTITUTIVO DE DERECHO. EL REGISTRO DE UNA OBRA, PRODUCTO O PRODUCCION NO PREJUZGA SOBRE LA ORIGINALIDAD DE LO DECLARADO COMO OBRA NI SOBRE SU AUTORÍA Y TITULARIDAD. SOLAMENTE DA FECHA CIERTA DE SU PRESENTACIÓN Y DE LAS PERSONA(S) SOLICITANTE(S). LA OMISION DEL REGISTRO NO PERJUDICA EL GOCE Y EJERCICIO DE LOS DERECHOS RECONOCIDOS POR LA LEY. (Art. 107 L.S.D.A) '),0,'J');

// Area derechos de registros 
$pdf->SetFillColor(230);
$pdf->SetXY(155,83); $pdf->RoundedRect(128, 286, 68, 25, 3.5, 'F');
$pdf->SetFont('Arial','B',8);
$fil=286; $inc=4; 
$pdf->SetXY(130,$fil+($inc*1));$pdf->Cell(0,0,'DERECHOS DE REGISTRO:');
$pdf->SetXY(130,$fil+($inc*2));$pdf->Cell(0,0,'Tasa Inicial:');
$pdf->SetXY(130,$fil+($inc*3));$pdf->Cell(0,0,'Planilla:____________  Fecha: _________ (U.T.1)');
$pdf->SetXY(130,$fil+($inc*4));$pdf->Cell(0,0,'Derechos de Registro:');
$pdf->SetXY(130,$fil+($inc*5));$pdf->Cell(0,0,'Planilla:____________  Fecha: _________ (U.T.5)');

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
$pdf->SetXY(142,298);$pdf->Cell(0,0,$plan_ini);
$pdf->SetXY(171,298);$pdf->Cell(0,0,$fecha_ini);
$pdf->SetXY(142,306);$pdf->Cell(0,0,$plan_der);
$pdf->SetXY(171,306);$pdf->Cell(0,0,$fecha_der);

// firma y leyenda
$pdf->SetFont('Arial','B',9);
$fil=286; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'__________________________________________');
$pdf->SetXY(22,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('   ROSALBA FEGHALI GEBRAEL'));
$pdf->SetXY(21,$fil+($inc*3));$pdf->Cell(0,0,'Directora Nacional de Derecho de Autor');
$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(20,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode('Resolución No 020/2022, de fecha 24/03/2022'));
$pdf->SetXY(15,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('Publicado en Gaceta Oficial 42.352 de fecha 05/04/2022'));
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
