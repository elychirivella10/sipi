<?php
include ("../setting.inc.php");
//Comienzo del Programa por los encabezados del reporte
define('FPDF_FONTPATH',$root_path.'/font/');
include ("$include_path/fpdf.php");
ob_start();

// *************************************************************************************
// Programa: m_rpt1binef.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado II Semestre 2009 - BD.Relacional  
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos y Smarty 
include ("../z_includes.php");

$sql      = new mod_db();
$fecha    = fechahoy();
$tbname_1 = "stzevder";
$tbname_2 = "stzevtrd";
$horactual= hora();
$fechahoy = hoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','B&uacute;squeda Interna de Elemento Figurativo');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
//$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$npedido = $_GET["vped"];
$usuario = $_GET["vusr"]; 
$sede=2;

//Conexion
$sql->connection($usuario);

//Query para buscar las opciones deseadas
if(!empty($npedido) and ($npedido!='0000-000000')) {
  $respedido=pg_exec("SELECT * FROM stzderec WHERE solicitud= '$npedido' AND tipo_mp='M'");
}

//verificando los resultados
if (!$respedido)    { 
   $smarty->display('encabezado1.tpl');
   mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_pbinfigu.php','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($respedido); 
if ($filas_found==0)    {
   $smarty->display('encabezado1.tpl');
   mensajenew('AVISO: No existen Datos Asociados ...!!!','m_pbinfigu.php','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$regder = pg_fetch_array($respedido);

//Para la imagen 
$varsol1 = substr($npedido,-11,4);
$varsol2 = substr($npedido,-6,6);
//$nameimage= ver_imagen($varsol1,$varsol2,'M');
$nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";

$rutafinal = '../documentos/grafica/ef';
$archivo   = $rutafinal.$varsol1."/".$varsol1.$varsol2.".pdf";

$vder    = $regder['nro_derecho'];  
$nregis  = $regder['registro'];
$nsolic  = $regder['solicitud'];
$estatus = $regder['estatus'];

$nagen=$regder['agente'];
if (empty($nagen)) { $nagen=0; } 

$res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$regder[estatus]'");
$restat = pg_fetch_array($res_estatus);

$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regder[pais_resid]' and pais!=''");
$respai = pg_fetch_array($res_pais);

$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$regder[agente]' and agente!=0");
$resage = pg_fetch_array($res_agen);

if ($regder['tipo_derecho']=='M') {$vtip='MARCA DE PRODUCTO';}
if ($regder['tipo_derecho']=='N') {$vtip='NOMBRE COMERCIAL';}
if ($regder['tipo_derecho']=='L') {$vtip='LEMA COMERCIAL';}
if ($regder['tipo_derecho']=='S') {$vtip='MARCA DE SERVICIO';}
if ($regder['tipo_derecho']=='C') {$vtip='MARCA COLECTIVA';}
if ($regder['tipo_derecho']=='D') {$vtip='DENOMINACION DE ORIGEN';}

$resmarca= pg_exec("SELECT * FROM stmmarce WHERE nro_derecho= '$regder[nro_derecho]'");
$regm    = pg_fetch_array($resmarca);

if ($regm['modalidad']=='D') {$vmod='DENOMINATIVA';}
if ($regm['modalidad']=='M') {$vmod='MIXTA';}
if ($regm['modalidad']=='G') {$vmod='GRAFICA';}

if ($regm['ind_claseni']=='N') {$vcla='NACIONAL';}
if ($regm['ind_claseni']=='I') {$vcla='INTERNACIONAL';}

$vporc='83%';
if ($regm['modalidad']!="D")
   {$vporc='55%';}  

if(!empty($npedido)) {
   $resaudef=pg_exec("SELECT * FROM stmaudef WHERE pedido='$npedido' and estatus!='P'"); }

//verificando los resultados
if (!$resaudef)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_pbinfigu.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resaudef); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!','m_pbinfigu.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$reg = pg_fetch_array($resaudef);
$clase=$reg[clase];
$vc1=$reg[vc1];
$vc2=$reg[vc2];
$vc3=$reg[vc3];
$vc4=$reg[vc4];
$vc5=$reg[vc5];
$vc6=$reg[vc6];
$vc7=$reg[vc7];
$vc8=$reg[vc8];

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
    global $usuario;
    //Title
    $this->SetFont('Arial','',14);
    $this->Image("../imagenes/sapi.jpg",10,5,15,15,'JPG');
    $this->Cell(0,6,'Sistema de Marcas',0,1,'C');
    $this->Cell(0,6,'Elementos Figurativos',0,0,'C');
    $this->SetFont('Arial','BI',7);
    $this->Cell(0,6,'Usuario: '.$usuario,0,1,'R');
    //$this->Image("../imagenes/milco1.jpg",160,5,40,10,'JPG');
    $this->SetFont('Arial','BU',10);
    $this->Cell(0,7,'Busqueda Interna de Antecedente',0,1,'C');
    $this->SetFont('Arial','',8);
    $this->ln(4);
    //Ensure table header is output
    parent::Header();
}

//Pie de página
function Footer()
{
    //Posición: a 2,0 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    $this->Text(10,270,"Fecha: ");
    $this->text(20,270,date('d/m/y'),0,1); 
    $this->Text(185,270,"Hora:");
    $this->text(192,270,date('h:i A'),0,1); 
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
$pdf->SetAutoPageBreak(true,30);

if ($regm['modalidad']!="D" and file($nameimage)) {
  $pdf->SetFillColor(192);
  $pdf->RoundedRect(178, 32, 33, 30, 5, '', '13');
  $pdf->Image("$nameimage",180,35,30,25,'JPG');
 }

   //Arreglando el formato de la fecha
    $pdf->Cell(15,8,'Solicitud:',0,0); 
    $pdf->Cell(100,8,$nsolic,0,0);
    $pdf->Cell(30,8,'Fecha de Solicitud:',0,0);
    $pdf->Cell(100,8,$regder['fecha_solic'],0,1);
    $pdf->Cell(25,8,'Tipo de Marca:',0,0);
    $pdf->Cell(90,8,$regder['tipo_derecho'].'-'.$vtip,0,0);
    $pdf->Cell(20,8,'Modalidad:',0,0);
    $pdf->Cell(100,8,$regm['modalidad'].'-'.$vmod,0,1);    
    $pdf->Cell(15,8,'Pais:',0,0);
    $pdf->Cell(100,8,$regder['pais_resid'].'-'.$respai['nombre'],0,0);    
    $pdf->Cell(10,8,'Clase:',0,0);
    $pdf->Cell(80,8,$regm['clase'].'-'.$vcla,0,1);    
    $pdf->Cell(30,8,'Num. de Registro:',0,0);
    $pdf->Cell(85,8,$regder['registro'],0,0);
    $pdf->Cell(30,8,'Fecha de Registro:',0,0);
    $pdf->Cell(80,8,$regder['fecha_regis'],0,1);
    $pdf->Cell(35,8,'Fecha de Vencimiento:',0,0);
    $pdf->Cell(80,8,$regder['fecha_venc'],0,0);  
    $pdf->Cell(12,8,'Estatus:',0,0);
    $pdf->Cell(6,8,$regder['estatus']-1000,0,0);
    $pdf->Cell(15,8,substr($restat['descripcion'],0,28),0,1); 
    $pdf->Cell(15,8,'Nombre:',0,0);
    $pdf->Cell(20,8,utf8_decode($regder['nombre']),0,1);
   
    $pdf->Cell(20,8,'Distingue:',0,0);
    //$res_dist=pg_exec("SELECT * FROM stmdistd WHERE solicitud='$nsolic' and solicitud!=''");
    //$regdis = pg_fetch_array($res_dist);
    $distin= trim($regm['distingue']);
    $pdf->MultiCell(0,4,utf8_decode($distin),0,'J');
    $pdf->ln(1); 
    $pdf->Cell(30,8,'Tramitante/Agente:',0,0);
    $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$nagen'");
    $regage = pg_fetch_array($res_agen);
    if ($regder['agente']<=0) { 
      $pdf->Cell(20,8,$regder['tramitante'],0,1); }
    if ($regder['agente']>0)  {
      $pdf->Cell(20,8,$regder['tramitante'],0,0);
      $pdf->Cell(20,8,'- Codigo:',0,0);
      $pdf->Cell(20,8,$regder['agente'],0,0);
      $pdf->Cell(20,8,$regage['nombre'],0,1);  }

    $pdf->ln(1);
    $pdf->Cell(40,8,'CLASIFICACION SEGUN VIENA',0,1);

    //Busqueda de la Clasificacion de Viena de la Solicitud
    $codviena = "";
    $resccv=pg_exec("SELECT ccv FROM stmccvma WHERE nro_derecho='$vder'");
    $filasvfound=pg_numrows($resccv);
    $regccv = pg_fetch_array($resccv);
    for($cont2=0;$cont2<$filasvfound;$cont2++) {
      $codigo = $regccv['ccv'];
      $rccv=pg_exec("SELECT descripcion FROM stmviena WHERE ccv='$codigo'");
      $regviena = pg_fetch_array($rccv);
      $nomviena = trim($regviena['descripcion']);
      $codviena2 = $regccv['ccv']." - ".$nomviena;
      $pdf->Cell(100,8,$codviena2,0,1);
      //if ($codviena=="") { 
      //  $codviena = $regccv['ccv']; }
      //else { 
      //  $codviena = $codviena." - ".$regccv['ccv']; }
      //$pdf->Cell(100,8,$codviena,0,1);
      $regccv = pg_fetch_array($resccv);
    }
    $pdf->Cell(100,8,$codviena,0,1);

// Buscando los titulares de la solicitud
   $pdf->ln(1);
   $pdf->Cell(40,8,'TITULARES DE LA MARCA',0,1);
   $pdf->Cell(20,8,'Codigo',1,0,'C'); 
   $pdf->Cell(88,8,'Nombre',1,0,'C'); 
   $pdf->Cell(60,8,'Domicilio',1,0,'C'); 
   $pdf->Cell(30,8,'Nac/Pais',1,1,'C'); 
   
   $resultado=pg_exec("SELECT titular,nacionalidad,domicilio FROM stzottid WHERE stzottid.nro_derecho='$vder'");
   $filas_found=pg_numrows($resultado);
   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++)   { 
      $resul2=pg_exec("SELECT titular,nombre FROM stzsolic WHERE titular='$reg[titular]'");    
      $reg2 = pg_fetch_array($resul2);
      $pdf->Cell(20,8,$reg2['titular'],0,0); 
      $pdf->Cell(88,8,substr($reg2['nombre'],0,45),0,0);
      $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[nacionalidad]' and pais!=''");
      $respai = pg_fetch_array($res_pais);
      $pdf->Cell(60,8,utf8_decode(substr($reg['domicilio'],0,35)),0,0);
      //$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg2[pais_resid]' and pais!=''");
      //$respai = pg_fetch_array($res_pais);  
      $pdf->Cell(30,8,$reg['nacionalidad'].'-'.$respai['nombre'],0,1);
      $reg = pg_fetch_array($resultado);
   }

   $pdf->ln(3);
   $pdf->SetFont('Arial','BU',11);
   $pdf->Cell(0,8,'POSIBLES PARECIDOS GRAFICOS',0,1,'C');
   $pdf->SetFont('Arial','',8);
   $pdf->ln(1);

  //Obteniendo solicitudes seleccionadas 
  $res_pedido=pg_exec("SELECT * FROM stmpsovi WHERE pedido= '$npedido' and estatus='P'");
  //$res_pedido=pg_exec("SELECT * FROM stmpsovi WHERE pedido= '$npedido'");
  $filasfound=pg_numrows($res_pedido);
  $regef = pg_fetch_array($res_pedido);
  for($cont=0;$cont<$filasfound;$cont++)   { 
     $varsol = $regef['solicitud'];

     $varsol1=substr($varsol,-11,4);
     $varsol2=substr($varsol,-6,6);
     //$nameimage= ver_imagen($varsol1,$varsol2,'M');
     $nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";
     
     $respedido=pg_exec("SELECT * FROM stzderec WHERE solicitud= '$varsol' AND tipo_mp='M'");
     $regef = pg_fetch_array($respedido);
     $vder1 = $regef['nro_derecho'];
     $resmarca=pg_exec("SELECT * FROM stmmarce WHERE nro_derecho= '$vder1'");
     $reg = pg_fetch_array($resmarca);
     $res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$regef[estatus]'");
     $restat = pg_fetch_array($res_estatus);
     $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regef[pais_resid]' and pais!=''");
     $respai = pg_fetch_array($res_pais);
     $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$regef[agente]' and agente!=''");
     $resage = pg_fetch_array($res_agen);
     $nombagen=$resage[nombre];

     if ($regef['tipo_derecho']=='M') {$vtip='MARCA DE PRODUCTO';}
     if ($regef['tipo_derecho']=='N') {$vtip='NOMBRE COMERCIAL';}
     if ($regef['tipo_derecho']=='L') {$vtip='LEMA COMERCIAL';}
     if ($regef['tipo_derecho']=='S') {$vtip='MARCA DE SERVICIO';}
     if ($regef['tipo_derecho']=='C') {$vtip='MARCA COLECTIVA';}
     if ($regef['tipo_derecho']=='D') {$vtip='DENOMINACION DE ORIGEN';}

     if ($reg['ind_claseni']=='N') {$vcla='NACIONAL';}
     if ($reg['ind_claseni']=='I') {$vcla='INTERNACIONAL';}
     if ($reg['modalidad']=='D') {$vmod='DENOMINATIVA';}
     if ($reg['modalidad']=='M') {$vmod='MIXTA';}
     if ($reg['modalidad']=='G') {$vmod='GRAFICA';}

     //imagen
     if ($reg['modalidad']!="D" AND file($nameimage)) { 
       //echo $nameimage;
       $pdf->SetFillColor(192);
       $x = $pdf->Getx();
       $y = $pdf->Gety();
       $pdf->RoundedRect(($x+138),($y+6),55,35,5,'', '13');
       $pdf->Image("$nameimage",($x+140),($y+8),50,31,'JPG');
     }

     $pdf->Cell(15,8,'Solicitud:',0,0); 
     $pdf->Cell(70,8,$varsol,0,0);
     $pdf->Cell(30,8,'Fecha de Solicitud:',0,0);
     $pdf->Cell(100,8,$regef['fecha_solic'],0,1);
     $pdf->Cell(25,8,'Tipo de Marca:',0,0);
     $pdf->Cell(60,8,$regef['tipo_derecho'].'-'.$vtip,0,0);
     $pdf->Cell(20,8,'Modalidad:',0,0);
     $pdf->Cell(100,8,$reg['modalidad'].'-'.$vmod,0,1);    
     $pdf->Cell(15,8,'Pais:',0,0);
     $pdf->Cell(70,8,$regef['pais_resid'].'-'.$respai['nombre'],0,0);    
     $pdf->Cell(10,8,'Clase:',0,0);
     $pdf->Cell(80,8,$reg['clase'].'-'.$vcla,0,1);    
     $pdf->Cell(30,8,'Num. de Registro:',0,0);
     $pdf->Cell(55,8,$regef['registro'],0,0);
     $pdf->Cell(30,8,'Fecha de Registro:',0,0);
     $pdf->Cell(80,8,$regef['fecha_regis'],0,1);
     $pdf->Cell(35,8,'Fecha de Vencimiento:',0,0);
     $pdf->Cell(50,8,$regef['fecha_venc'],0,1);  
     $pdf->Cell(15,8,'Nombre:',0,0);
     $pdf->Cell(20,8,$regef['nombre'],0,1);
     $pdf->Cell(12,8,'Estatus:',0,0);
     $pdf->Cell(6,8,$regef['estatus']-1000,0,0);
     $pdf->Cell(15,8,substr($restat['descripcion'],0,99),0,1); 
     $pdf->Cell(30,8,'Tramitante/Agente:',0,0);
     if ($regef['agente']<=0) { 
       $pdf->Cell(20,8,$reg['tramitante'],0,1); }
     if ($regef['agente']>0)  {
       $nagente=$regef['agente'];
       $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente=$nagente");
       $regage = pg_fetch_array($res_agen);
       //$pdf->Cell(20,8,$reg['tramitante'],0,0);
       $pdf->Cell(20,8,'- / Codigo:',0,0);
       $pdf->Cell(20,8,$regef['agente'],0,0);
       $pdf->Cell(10,8,$regage['nombre'],0,1);  }
     $pdf->ln(1); 
     //Busqueda del Distingue
     $pdf->Cell(20,8,'Distingue:',0,1);
     $pdf->SetFont('Arial','',7);
     //$res_dist=pg_exec("SELECT * FROM stmdistd WHERE solicitud= '$varsol' ");
     //$filasdist=pg_numrows($res_dist);
     //if ($filasdist!=0) {
       //$regdis = pg_fetch_array($res_dist);
       $distin= trim($reg['distingue']);
     if (!empty($distin)) {     
       $pdf->MultiCell(0,4,utf8_decode($distin),0,'J',0); }
     else {
       $pdf->Cell(0,4,"- No posee Descripcion de Productos ...",0,1); }
     $pdf->SetFont('Arial','',8);
     $pdf->ln(1); 
     //Busqueda de la Etiqueta
     $pdf->Cell(40,8,'Descripcion de la Etiqueta:',0,1);
     $pdf->SetFont('Arial','',7);
     $res_log=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho= '$vder1' ");
     $filaslog=pg_numrows($res_log);
     if ($filaslog!=0) {
       $reglog = pg_fetch_array($res_log);
       $etiqueta= trim($reglog['descripcion']);
       $pdf->MultiCell(0,4,$etiqueta,0,'J',0); }
     else {
       $pdf->Cell(0,4," - No posee Descripcion de la Imagen ...",0,1); }
     $pdf->SetFont('Arial','',8);
     $pdf->ln(1); 
     //Busqueda de la Clasificacion de Viena de la Solicitud
     $codviena = "";
     $resccv=pg_exec("SELECT ccv FROM stmccvma WHERE nro_derecho='$vder1'");
     $filasvfound=pg_numrows($resccv);
     $regccv = pg_fetch_array($resccv);
     for($cont2=0;$cont2<$filasvfound;$cont2++) { 
       if ($codviena=="") { 
         $codviena = $regccv['ccv']; }
       else { 
         $codviena = $codviena." - ".$regccv['ccv']; }
       $regccv = pg_fetch_array($resccv);
     }
     $pdf->Cell(100,8,"Codigos de Viena:   ".$codviena,0,1);
     //$pdf->ln(1);

     // Buscando los titulares de la solicitud
     $pdf->ln(2);
     $pdf->Cell(40,8,'TITULAR(ES) DE LA MARCA',0,1);
     $pdf->Cell(20,8,'Codigo',1,0,'C'); 
     $pdf->Cell(88,8,'Nombre',1,0,'C'); 
     //$pdf->Cell(40,8,'Nacionalidad',1,0,'C'); 
     $pdf->Cell(60,8,'Domicilio',1,0,'C'); 
     $pdf->Cell(30,8,'Nac/Pais',1,1,'C'); 
     $restitular=pg_exec("SELECT titular,nacionalidad,domicilio FROM stzottid WHERE stzottid.nro_derecho='$vder1'");
     $filastfound=pg_numrows($restitular);
     $regtitu = pg_fetch_array($restitular);
     for($cont1=0;$cont1<$filastfound;$cont1++)   { 
       $resul2=pg_exec("SELECT titular,nombre FROM stzsolic WHERE titular='$regtitu[titular]'");    
       $reg2 = pg_fetch_array($resul2);
       $pdf->Cell(20,8,$reg2['titular'],0,0); 
       $pdf->Cell(88,8,substr($reg2['nombre'],0,45),0,0);
       $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$regtitu[nacionalidad]' and pais!=''");
       $respai = pg_fetch_array($res_pais);
       //$pdf->Cell(40,8,$reg['nacionalidad'].'-'.$respai['nombre'],0,0); 
       $pdf->Cell(60,8,substr($regtitu['domicilio'],0,35),0,0);
       //$res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg2[pais_resid]' and pais!=''");
       //$respai = pg_fetch_array($res_pais);  
       $pdf->Cell(30,8,$regtitu['nacionalidad'].'-'.$respai['nombre'],0,1);
       $regtitu = pg_fetch_array($restitular);
     }
     $pdf->ln(1);
     $x = $pdf->Getx();
     $y = $pdf->Gety();
     $pdf->line($x,($y+1),208,($y+1));  

     $update_str = "estatus='I'";
     $sql->update("stmpsovi","$update_str","solicitud='$varsol' and estatus='P'");

     $regef = pg_fetch_array($res_pedido);
  }
  $update_str = "estatus='P'";
  $sql->update("stmaudef","$update_str","pedido='$npedido' and estatus='S'");

//Desconexion a la base de datos
//$sql->disconnect();
ob_end_clean();

//Verificando si el expediente ya presenta el evento 50 para cargarlo o no.  
$resul=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1050");
$filas_found=pg_numrows($resul); 
if ($filas_found==0) {
  $evento = 1050;
  $reseve = pg_exec("SELECT * FROM $tbname_1 WHERE evento='$evento'");
  $regeve = pg_fetch_array($reseve);   
  $comentario = trim($regeve['descripcion']);
  $mensa_auto = trim($regeve['mensa_automatico']);

  $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,comentario,hora";
  $insert_str = "'$vder','$evento','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$fechahoy','$usuario','$mensa_auto','$comentario','$horactual'";
  $instram = $sql->insert("$tbname_2","$col_campos","$insert_str",""); 
} 

if ($sede==2) {
  //$update_str = "estado='2'";
  //$recibo=trim($recibo);
  //$act_ref = $sql->update("stmbusweb","$update_str","tipo_busq='G' AND ref_busq=$recibo"); 
  $pdf->Output($archivo); 
  //Desconexion a la base de datos
  $sql->disconnect();
  $smarty->display('encabezado1.tpl');
  mensajenew('Archivo Generado en el Servidor ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}   
else { $pdf->Output(); }
?>
