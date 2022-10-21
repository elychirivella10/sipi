<?php
//Programa de Certificados de Derecho de Autor. Todas las Planillas menos las de Actos y Contratos.
// Realizado por: Ing. Karina Perez
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");
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
$usuario = $_SESSION['usuario_login'];
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
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); } 

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

$pdf=new PDF_Table('P','mm','LEGAL');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial','',9);

//Datos del certificado
	
for($cont=0;$cont<$filas_found;$cont++)   { 

// Modelo de la Planilla

// Encabezado 
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(14,40); $pdf->MultiCell(0,5,utf8_decode('DIRECCIÓN NACIONAL DEL DERECHO DE AUTOR '),0,'J');
$pdf->SetXY(14,45); $pdf->MultiCell(0,5,utf8_decode('REGISTRO DE PRODUCCIÓN INTELECTUAL'),0,'J');
// Area datos del certificado 1era parte 
$pdf->SetFont('Arial','B',9);
$fil=63; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'REGISTRO:');
$pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'FECHA:');
$pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,utf8_decode('INSCRIPCIÓN:'));
$pdf->SetFillColor(230);
$pdf->SetXY(65,64); $pdf->RoundedRect(42, 64, 40, 14, 3.5, 'F');

$pdf->SetXY(97,61);$pdf->Cell(0,0,'TIPO DE OBRA');
$pdf->SetXY(143,61);$pdf->Cell(0,0,UTF8_DECODE('CLASIFICACIÓN DE LA OBRA'));
$pdf->SetFillColor(230);
$pdf->SetXY(70,63); $pdf->RoundedRect(87, 64, 45, 14, 3.5, 'F');
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(143,66);$pdf->Cell(0,0,UTF8_DECODE('Indédita'));
$pdf->SetXY(100,63); $pdf->RoundedRect(137, 64, 6, 4, 1.5, 'F');
$pdf->SetXY(164,66);$pdf->Cell(0,0,UTF8_DECODE('Originaria'));
$pdf->SetXY(100,63); $pdf->RoundedRect(158, 64, 6, 4, 1.5, 'F');
$pdf->SetXY(185,66);$pdf->Cell(0,0,UTF8_DECODE('Individual'));
$pdf->SetXY(100,63); $pdf->RoundedRect(179, 64, 6, 4, 1.5, 'F');
$pdf->SetXY(143,71);$pdf->Cell(0,0,UTF8_DECODE('Publicada'));
$pdf->SetXY(100,63); $pdf->RoundedRect(137, 69, 6, 4, 1.5, 'F');
$pdf->SetXY(164,71);$pdf->Cell(0,0,UTF8_DECODE('Derivada'));
$pdf->SetXY(100,63); $pdf->RoundedRect(158, 69, 6, 4, 1.5, 'F');

$pdf->SetXY(185,71);$pdf->Cell(0,0,UTF8_DECODE('En Colaboración'));
$pdf->SetXY(100,63); $pdf->RoundedRect(179, 69, 6, 4, 1.5, 'F');
$pdf->SetXY(185,76);$pdf->Cell(0,0,UTF8_DECODE('Colectiva'));
$pdf->SetXY(100,63); $pdf->RoundedRect(179, 74, 6, 4, 1.5, 'F');


$pdf->SetXY(143,78);$pdf->Cell(0,0,UTF8_DECODE('Ejemp.Depositados'));
$pdf->SetXY(100,79); $pdf->RoundedRect(137, 75, 6, 4, 1.5, 'F');


$pdf->SetFont('Arial','B',9);
// Area datos del titular 
$pdf->SetFont('Arial','B',9);
$fil=84; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'TITULO DE LA OBRA:');

$pdf->SetFillColor(230);
$pdf->SetXY(65,83); $pdf->RoundedRect(52, 83, 156, 20, 3.5, 'F');

// solitantes, autores, titulares
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,114);$pdf->Cell(0,0,'SOLICITANTES(S):');
$pdf->SetFillColor(230);
$pdf->SetXY(65,83); $pdf->RoundedRect(52, 109, 156, 30, 3.5, 'F');

$pdf->SetXY(14,152);$pdf->Cell(0,0,'AUTOR(ES):');
$pdf->SetFillColor(230);
$pdf->SetXY(65,83); $pdf->RoundedRect(52, 145, 156, 30, 3.5, 'F');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(14,184); $pdf->Cell(0,0,'TITULAR(ES) DE LOS DERECHOS PATRIMONIALES:');
$pdf->SetFillColor(230);
$pdf->SetXY(14,77); $pdf->RoundedRect(14, 186, 195, 43, 3.5, 'F');


// Area de TEXTO
$pdf->SetXY(14,240); $pdf->MultiCell(0,5,utf8_decode('EL REGISTRO DA FE DE LA EXISTENCIA DE LA OBRA, PRODUCTO O PRODUCCIÓN Y DEL HECHO DE SU DIVULGACIÓN O PUBLICACIÓN. SE PRESEUME, SALVO PRUEBA EN CONTRARIO, QUE LAS PERSONAS INDICADAS COMO TITULARES EN LA SOLICITUD, GOZAN DEL DERECHO EXCLUSIVO DEL AUTOR. '),0,'J');

$pdf->SetXY(14,260); $pdf->MultiCell(0,5,utf8_decode('EL PRESENTE REGISTRO ES MERAMENTE FACULTATIVO Y DECLARATIVO NO CONSTITUTIVO DE DERECHO. EL REGISTRO DE UNA OBRA, PRODUCTO O PRODUCCION NO PREJUZGA SOBRE LA ORIINALIDAD DE LO DECLARADO COMO OBRA NI SOBRE SU AUTORÍA Y TITULARIDAD. SOLAMANTE DA FECHA CIERTA DE SU PRESENTACIÓN Y DE LAS PERSONA(S) SOLICITANTE(S). LA OMISION DEL REGISTRO NO PERJUDICA EL GOCE Y EJERCICIO DE LOS DERECHOS RECONOCIDOS POR LA LEY. (Art. 107 L.S.D.A) '),0,'J');

// Area derechos de registros 
$pdf->SetFillColor(230);
$pdf->SetXY(164,83); $pdf->RoundedRect(141, 295, 68, 30, 3.5, 'F');
$pdf->SetFont('Arial','B',8);
$fil=295; $inc=4; 
$pdf->SetXY(141,$fil+($inc*1));$pdf->Cell(0,0,'DERECHOS DE REGISTRO:');
$pdf->SetXY(141,$fil+($inc*3));$pdf->Cell(0,0,'Tasa Inicial:');
$pdf->SetXY(141,$fil+($inc*4));$pdf->Cell(0,0,'Planilla:____________  Fecha: _________ (U.T.1)');
$pdf->SetXY(141,$fil+($inc*5));$pdf->Cell(0,0,'Derechos de Registro:');
$pdf->SetXY(141,$fil+($inc*6));$pdf->Cell(0,0,'Planilla:____________  Fecha: _________ (U.T.5)');
//$pdf->SetFillColor(230);
//$pdf->SetXY(164,83); $pdf->RoundedRect(145, 295, 35, 20, 3.5, 'F');

// firma y leyenda
$pdf->SetFont('Arial','B',9);
$fil=304; $inc=4; 
$pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'__________________________________________');
$pdf->SetXY(34,$fil+($inc*2));$pdf->Cell(0,0,utf8_decode('Castiela Velásquez'));
$pdf->SetXY(18,$fil+($inc*3));$pdf->Cell(0,0,'Directora Nacional del Derecho de Autor');
$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(18,$fil+($inc*4));$pdf->Cell(0,0,utf8_decode('Resolución Nro. 372, del 20 de Febrero de 2008'));
$pdf->SetXY(14,$fil+($inc*5));$pdf->Cell(0,0,utf8_decode('Gaceta Oficial Nro. 38.875 de fecha 21 de febrero de 2008'));
//Fin de certificado

//Muestra de datos
$pdf->SetFont('Arial','B',11);
$pdf->Settextcolor(255,0,0);
$pdf->Settextcolor(0,0,0);

//tipo de obra
  if ($reg['tipo_obra']=='OL') {$vtip= 'Registro de Obras Literarias';}
  if ($reg['tipo_obra']=='AV') {$vtip= 'Registro de Obras de Arte Visual';}
  if ($reg['tipo_obra']=='OE') {$vtip= 'Registro de Obras Escenicas';}
  if ($reg['tipo_obra']=='OM') {$vtip= 'Registro de Obras Musicales';}
  if ($reg['tipo_obra']=='AR') {$vtip= 'Registro de Obras Audiovisuales y Radiofónicas';}
  if ($reg['tipo_obra']=='PC') {$vtip= 'Programas de Computación y Base de Datos';}
  if ($reg['tipo_obra']=='PF') {$vtip= 'Registro de Obras de Producciones Fonografícas';}
  if ($reg['tipo_obra']=='IE') {$vtip= 'Registro de Interpretaciones y Ejecuciones Artisticas';}
//  if ($reg['tipo_obra']=='AC') {$vtip= 'Actos y Contratos';}

 $varsol=$reg['solicitud'];
 $nregis=$reg['registro'];
 $nderec=$reg['nro_derecho'];

    $pdf->SetFont('Arial','',9);
    $pdf->Setxy(44,65);
    $pdf->Cell(20,4,$reg['registro'],0,1); 
    $pdf->Setxy(44,69);
    $pdf->Cell(20,4,$reg['fecha_regis'],0,1);
    $pdf->Setxy(44,73);
    $pdf->Cell(75,4,$reg['solicitud'],0,0);
    $pdf->Setxy(92,65);
    $pdf->MultiCell(35,4,$vtip,0,'C');
    $pdf->Setxy(190,69);

//Clasificación
  if ($reg['clase']=='I') {$pdf->SetXY(138,66);$pdf->Cell(0,0,'X');}
  if ($reg['clase']=='P') {$pdf->SetXY(138,71);$pdf->Cell(0,0,'X');}
  if ($reg['origen']=='O') {$pdf->SetXY(159,66);$pdf->Cell(0,0,'X');}
  if ($reg['origen']=='D') {$pdf->SetXY(159,71);$pdf->Cell(0,0,'X');}
  if ($reg['forma']=='I') {$pdf->SetXY(180,66);$pdf->Cell(0,0,'X');}
  if ($reg['forma']=='E') {$pdf->SetXY(180,71);$pdf->Cell(0,0,'X');}
  if ($reg['forma']=='C') {$pdf->SetXY(180,76);$pdf->Cell(0,0,'X');}

//Depositos
$res_dep=pg_exec("SELECT * FROM stdobras WHERE nro_derecho='$nderec'");
$resdep = pg_fetch_array($res_dep);
$pdf->SetXY(138,77);$pdf->Cell(0,0,$resdep['n_ejemplares']);

//titulo de la obra
$fil=84; $inc=4; 
$pdf->SetXY(54,85);$pdf->Multicell(140,4,utf8_decode($reg['titulo_obra']),0,'J');

//Solicitante
$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1   FROM stzsolic,stdobsol WHERE  stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular ");
$regis_sol = pg_fetch_array($resul_sol);

//coletilla del solicitante
$ced=$regis_sol['identificacion'];
$cedula_sol=cedula($ced);
$letra=substr($cedula_sol,0,1);
 if ($letra=='V' or $letra=='E') {
  $texto_solicitante= $regis_sol['nombre'].",  Cédula. N° ".$cedula_sol;}
 else {
  $texto_solicitante= " ".$regis_sol['nombre'].",  Rif N° ".$cedula_sol;
 }
 
$pdf->SetXY(54,110);$pdf->Multicell(140,4,utf8_decode($texto_solicitante),0,'J');

//Autores
 $autor='';
 $resul_aut=pg_exec("SELECT DISTINCT ON (stzsolic.identificacion) stzsolic.identificacion, stzsolic.nombre, stdobaut.titular FROM stzsolic,stdobaut
WHERE stdobaut.nro_derecho = '$nderec' and stzsolic.titular = stdobaut.titular ");
 $regis_aut = pg_fetch_array($resul_aut);
 $filas_found_regaut =pg_numrows($resul_aut);
 for($cont3=0;$cont3<$filas_found_regaut;$cont3++) {
    $resul_seudo=pg_exec("SELECT seudonimo,fecha_defun FROM stzdaper WHERE titular = '$regis_aut[titular]' ");
    $filas_found_seudo =pg_numrows($resul_seudo);
    $ced=$regis_aut['identificacion'];
    $cedula=cedula($ced);
    if ($regis_seu['fecha_defun'] =' ') {
       $defun= 0;
    } 
    if ($regis_seu['seudonimo'] =' ') {
       if ($defun== 0) {
         $autor= $autor." ".$regis_aut['nombre'].", Cédula "."N° ".$cedula."";}
       else {
         $autor= $autor." ".$regis_aut['nombre'].", Cédula "."N° ".$cedula." "."Fallecido";}
    } 
    else {
       if ($defun== 0) {
          $regis_seu = pg_fetch_array($resul_seudo);
          $autor= $autor." ".$regis_aut['nombre'].", Cédula "."N° ".$cedula." cuyo seudonimo declara ser ".$regis_seu['seudonimo'];}
      else {
          $regis_seu = pg_fetch_array($resul_seudo);
          $autor= $autor." ".$regis_aut['nombre'].", Cédula "."N° ".$cedula." Fallecido,"." cuyo seudonimo declara ser ".$regis_seu['seudonimo'];}
    }
    
    $regis_aut = pg_fetch_array($resul_aut);
 }
$pdf->SetXY(54,146);$pdf->Multicell(140,4,utf8_decode($autor),0,'J');


//verificando si tiene titulares de los derechos patrimoniales
$titular='';
$res_tit=pg_exec("SELECT * FROM stdobtit WHERE nro_derecho='$nderec'");
$restit = pg_fetch_array($res_tit);
$filas_found_regtit =pg_numrows($res_tit);
if ($filas_found_regtit <> 0)  { 
   $idsol= trim($restit['doc_titular']);
   $info = consultar($idsol,$nderec);
   $cedula_sol=cedula($info['0']);
   $letra=substr($cedula_sol,0,1);
   if ($letra=='V' or $letra=='E') {
       $titular=" ".$info['1']." Cédula N°".$cedula_sol."";}
   else { $titular=" ".$info['1']." Rif N°".$cedula_sol."";}
}
$pdf->SetXY(18,188);$pdf->Multicell(170,4,utf8_decode($titular),0,'J');

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
   $reg3 = pg_fetch_array($resultado3);
   $plan_der= $reg3['documento'];
   $fecha_der= $reg3['fecha_event'];
   $texto_tasa= "La tasa inicial según planilla "."[b]N° ".$plan_ini."[/b] de fecha".$fecha_ini.", es de una unidad tributaria (U.T.1) y los Derechos de Registro según planilla "."[b]N° ".$plan_der."[/b] de fecha ".$fecha_der.", son: cinco unidades tributarias (U.T.5). ";
}
else {
  $plan_ini="exento"; $fecha_ini="exento";
  $plan_der="exento"; $fecha_der="exento"; 
}

$pdf->SetFont('Arial','',8);
$pdf->SetXY(154,311);$pdf->Cell(0,0,$plan_ini);
$pdf->SetXY(182,311);$pdf->Cell(0,0,$fecha_ini);
$pdf->SetXY(154,319);$pdf->Cell(0,0,$plan_der);
$pdf->SetXY(182,319);$pdf->Cell(0,0,$fecha_der);
 
    if ($num_letras>1470)
    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg_dis['distingue'],0,1470));
       $str = $str.' *****';
       $pdf->MultiCell(180,4,$str,0,'J'); 
    }
    
    if ($num_letras<1470) { $pdf->MultiCell(180,4,$reg_dis['distingue'],0,'J');}
       
    // Datos del recibo
    $resultado4=pg_exec("SELECT * FROM stmevtrd WHERE solicitud='$varsol' and solicitud!='' 
              			  AND evento = '65' ");   
    $filas_found4=pg_numrows($resultado4);
    $reg4 = pg_fetch_array($resultado4);
    $resultado5=pg_exec("SELECT * FROM stmevtrd WHERE solicitud='$varsol' and solicitud!='' 
              			  AND evento = '795' ");   
    $filas_found5=pg_numrows($resultado5);
    $reg5 = pg_fetch_array($resultado5);
    if ($filas_found4!= 0) 
       {$pdf->Setxy(167,276);   
        $pdf->Cell(20,4,$reg4['documento'],0,1);
        $pdf->Setxy(167,280);
        $pdf->Cell(20,4,$reg4['fecha_event'],0,1);
       }
    
    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage();}

  }  

   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
