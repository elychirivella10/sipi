<?php
// *************************************************************************************
// Programa: m_logentre.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2006
// Modificado Año 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
ob_start();
include ("../z_includes.php");
//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
//Class Extention for header and footer	
//require_once("$include_lib/header_footer.inc");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";	
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditoria Busquedas Externas de Logos Entregados');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql  = new mod_db();
$sql->connection($login);
$fecha = fechahoy();

//Validacion de Entrada
$desde=$_POST["desdec"];
$hasta=$_POST["hastac"];
$usuario=trim($_POST["usuario"]);
$vplus  = trim($_POST['vplus']);
$orden = $_POST['orden'];

if ($orden=='Pedido') { $orderby = "stmcntrl.pedido"; }
else { $orderby = "stmcntrl.recibo"; }

//Query para buscar las opciones deseadas
$where='';
$titulo='';

if(empty($desde) || empty($hasta)) { 
   $smarty->display('encabezado1.tpl');
   mensajenew('ERROR: Alguna Fecha Vacia ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
   $smarty->display('encabezado1.tpl');
   mensajenew('Error: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($desde) and !empty($hasta)) { 
     if(empty($where)) {
       $where = $where." (stmaudef.fecha>='$desde' AND stmaudef.fecha<='$hasta')";
       $titulo= $titulo." Desde el: "."$desde"." Hasta: "."$hasta"; }
}

if(!empty($usuario)) { 
  if(!empty($where)) {
     $where = $where." and"." (stmaudef.usuario='$usuario')";
     $titulo= $titulo." por el Usuario: "."$usuario";  }
}

$where = $where." AND (tipo='E') AND (estatus='P')"." order by 1,2";
//$where = $where." and (tipo='E') ".$orden;

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Auditoria Busquedas Externas de Logos Entregados por Usuario";
$linea="___________________________________________________________________________________________________________";

class pdf_usage extends fpdf_table
{
   public function Header()
   {
	global $encab_principal;
	global $encabezado;
	global $titulo;
	global $total;

	//Title
	$this->SetFont('Arial','',15);
	$this->Image("../imagenes/gob.jpg",10,7,30,29,'JPG');
	$this->Cell(0,6,$encab_principal,0,1,'C');
	$this->Cell(0,6,$encabezado,0,1,'C');
	$this->SetFont('Arial','',10);
	$this->Cell(0,7,$titulo,0,1,'C');
	//$this->Cell(0,7,"Total ".$total,0,1,'C');
	$this->Cell(0,7,"     ",0,1,'C');
	$this->SetX(18);
	$this->SetFont('','B',8);

	$this->Ln(2);
	$x = $this->Getx();
	$y = $this->Gety();
	$this->line($x,($y+1),270,($y+1));  
	$this->Cell(14,8,'Factura','L,T,B,R',0,'C'); 
	$this->Cell(15,8,'de Fecha','L,T,B,R',0,'C');
	$this->Cell(57,8,'Solicitante','L,T,B,R',0,'L'); 
	$this->Cell(6,8,'P','L,T,B,R',0,'C'); 
	$this->Cell(12,8,'Pedido','L,T,B,R',0,'C'); 
	$this->Cell(10,8,'Clase','L,T,B,R',0,'C');
	$this->Cell(11,8,'Planilla','L,T,B,R',0,'C');
	$this->Cell(6,8,'E','L,T,B,R',0,'C'); 
	$this->Cell(33,8,'Fecha de Carga','L,T,B,R',0,'C'); 
	$this->Cell(33,8,'Fecha de Proceso','L,T,B,R',0,'C');
	$this->Cell(6,8,'I','L,T,B,R',0,'C'); 
	$this->Cell(6,8,'U','L,T,B,R',0,'C'); 
	$this->Cell(19,8,'Usuario','L,T,B,R',0,'C');
	$this->Cell(32,8,'Logotipo','L,T,B,R',1,'C'); 
   $this->SetFont('Arial','',8);
   }	
	
   public function Footer()
   {
    	//Posición: a 2,0 cm del final
    	$this->SetY(-20);
    	//Arial italic 8
    	$this->SetFont('Arial','I',7);
	   //Número de página
    	//$this->Cell(0,27,'Fecha: '.date('d/m/y').' Page '.$this->PageNo().'/{nb}',0,0,'C');
      $this->Cell(10,27,'Fecha:  '.date('d/m/y'),0,0,'L');
    	$this->Cell(0,27,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	   $this->Cell(10,27,'Hora: '.date('h:i A'),0,0,'R');
   }
} 

//distinct on(fecha,pedido)
$res_pedido=pg_exec("SELECT distinct on (fecha,pedido) fecha,pedido,hora,usuario,clase,tipo FROM stmaudef WHERE $where ");
$total=pg_numrows($res_pedido);

//Inicio del Pdf
$pdf = new pdf_usage('L','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

//Comienzo del pdf
$pdf->SetFont('Arial','',6);

//Tabla coloreada
//Colores, ancho de línea y fuente en negrita
//$pdf->SetFillColor(142,165,188);
//$pdf->SetTextColor(0);
//$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('','B',7);

//$header=array('# Recibo','de Fecha','Prioridad','Pedido','Clase','Recibido en Fecha','Fecha y Recibido por','Logotipo');

//Cabecera
$w=array(14,15,57,6,12,10,11,6,33,33,6,6,19,30);
$blanco='';   

//Restauración de colores y fuentes
//$pdf->SetFillColor(255,255,255);
//$pdf->SetTextColor(0);
//$pdf->SetFont('','B',8);

 $total=pg_numrows($res_pedido); echo "total= $total"; 
 if ($total==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptlogent.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

 $total_nor = 0;
 $total_hab = 0; 
 $total_cor = 0;
 $total_imp = 0;
 $total_nat = 0;
 $total_jur = 0;
 $total_gob = 0;
 $total_cop = 0; 
 $total_com = 0; 
 $total_pro = 0;
 $totcorreos= 0;
 
  $regef = pg_fetch_array($res_pedido);
  for($cont=0;$cont<$total;$cont++)   { 
    $npedido=trim($regef['pedido']);
    $clase=$regef['clase'];
    $proceso=$regef['fecha'];
    $horapro=$regef['hora'];
    $responsable=trim($regef['usuario']);
    
    $planilla="";
    $resplanilla=pg_exec("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$npedido' AND tipo_busq='G'");
    $filas_found=pg_numrows($resplanilla); 
    if ($filas_found!=0) {
      $regplan = pg_fetch_array($resplanilla);
      $planilla= trim($regplan[cod_planilla]); }

    $existe_img = 0;
    $buscaimage ="../graficos/logbext/".$npedido.".jpg";
    if (file_exists($buscaimage)) {
      $existe_img = 1;
    }
    if ($existe_img==0) {
      $buscaimage ="../graficos/planblog/".$planilla.".jpg"; 
      if (file_exists($buscaimage)) {
        $existe_img = 1;
      }
    }

    //$buscaimage ="../graficos/logbext/".$npedido.".jpg";
    if(!empty($npedido)) {
      $respedido=pg_exec("SELECT * FROM stmcntrl WHERE pedido=$npedido"); }

    //verificando los resultados
    if (!$respedido)    { 
      $smarty->display('encabezado1.tpl');
      mensajenew('Error: Problema en Base de Datos  ...!!!','m_rptlogent.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($respedido); 
    if ($filas_found==0)    {
      $smarty->display('encabezado1.tpl');
      mensajenew('AVISO: No existen Datos Asociados ...!!!','m_rptlogent.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $reg = pg_fetch_array($respedido);
    
    $recibo      = trim($reg['recibo']);
    $fecharec    = $reg['fecharec'];
    $solicitante = substr(trim($reg['solicitant']),0,41);
    $tipoprio    = $reg['prioridad'];
    $envio       = $reg['envio'];
    $email       = trim($reg['email']);
    $ubicacion   = $reg['sede'];
    $cedrif      = $reg['identificacion'];
    $tipindole   = $reg['indole'];
    $fechatrans  = $reg['fechaing'];
    $horatrans   = $reg['hora'];
    $nameuser    = trim($reg['usuario']);
    
    if ($envio=='S') { 
      $existeped = 0;
      $vruta="/home/fonetica/pdfext/grafica/";   
      $filepdf = $vruta.trim($npedido).".pdf";
      if (file_exists($filepdf)) { } 
      else { $existeped = $existeped + 1; }
    }   

    if (($sede=='3') AND ($nameuser='admwebpi')) {  } 
   
    if (($envio=='N') OR (($envio=='S') AND ($existeped==0))) { 
      //echo "$npedido,$envio,$responsable,"; exit();

      if($cont==0) {
        $factura = trim($reg['recibo']);
        if ($tipindole=="N") { $total_nat = $total_nat + 1; } 
        //if ($tipindole=="P") { $total_jur = $total_jur + 1; } 
        if ($tipindole=="G") { $total_gob = $total_gob + 1; } 
        if ($tipindole=="O") { $total_com = $total_com + 1; } 
        if ($tipindole=="C") { $total_cop = $total_cop + 1; }
      }

      $y = $pdf->Gety();
      if ($y>=226) {
       $pdf->AddPage(); $pdf->Ln(); }

       //Solucion temporal hasta que se mejore el query y se haga de otra forma     
       if ((($vplus=='C') || ($vplus=='T')) AND ($envio=="S")) {
       	 $total_pro = $total_pro + 1;
         if ($tipoprio=="L") { $tipo="H"; $total_hab = $total_hab + 1; } else { $tipo="N"; $total_nor = $total_nor + 1; }
         if ($envio=="N")    { $tipoenv="I"; $total_imp = $total_imp + 1; } else { $tipoenv="C"; $total_cor = $total_cor + 1; }
         if ($recibo!=$factura) {
           if ($envio=="S") { $totcorreos=$totcorreos+1; } 
           $factura=trim($reg['recibo']);

           if ($tipindole=="N") { $total_nat = $total_nat + 1; } 
           if ($tipindole=="P") { $total_jur = $total_jur + 1; } 
           if ($tipindole=="G") { $total_gob = $total_gob + 1; } 
           if ($tipindole=="O") { $total_com = $total_com + 1; } 
           if ($tipindole=="C") { $total_cop = $total_cop + 1; } 
         }
       
         $pdf->Cell($w[0],8,$recibo,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[1],8,$fecharec,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[2],8,utf8_decode($solicitante),'L,T,B,R',0,'L',0);
         $pdf->Cell($w[3],8,$tipo,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[4],8,$npedido,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[5],8,$clase,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[6],8,$planilla,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[7],8,$tipoenv,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[8],8,$fechatrans." - ".$horatrans,'L,T,B,R',0,'L',0);      
         $pdf->Cell($w[9],8,$proceso." - ".$horapro,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[10],8,$tipindole,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[11],8,$ubicacion,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[12],8,$responsable,'L,T,B,R',0,'L',0);

         $x = $pdf->Getx();
         $y = $pdf->Gety();
         $pdf->Image("$buscaimage",239,$y+2,30,25,'JPG');
         $pdf->ln(30);
         $pdf->line(10,($y+1),270,($y+1)); 
         $pdf->ln(2);
       }  
       if ((($vplus=='I') || ($vplus=='T')) AND ($envio=="N")) {
       	$total_pro = $total_pro + 1;
         if ($tipoprio=="L") { $tipo="H"; $total_hab = $total_hab + 1; } else { $tipo="N"; $total_nor = $total_nor + 1; }
         if ($envio=="N")    { $tipoenv="I"; $total_imp = $total_imp + 1; } else { $tipoenv="C"; $total_cor = $total_cor + 1; }
         if ($recibo!=$factura) {
           if ($envio=="S") { $totcorreos=$totcorreos+1; } 
           $factura=trim($reg['recibo']);

           if ($tipindole=="N") { $total_nat = $total_nat + 1; } 
           if ($tipindole=="P") { $total_jur = $total_jur + 1; } 
           if ($tipindole=="G") { $total_gob = $total_gob + 1; } 
           if ($tipindole=="O") { $total_com = $total_com + 1; } 
           if ($tipindole=="C") { $total_cop = $total_cop + 1; } 
         }

         $pdf->Cell($w[0],8,$recibo,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[1],8,$fecharec,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[2],8,utf8_decode($solicitante),'L,T,B,R',0,'L',0);
         $pdf->Cell($w[3],8,$tipo,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[4],8,$npedido,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[5],8,$clase,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[6],8,$planilla,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[7],8,$tipoenv,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[8],8,$fechatrans." - ".$horatrans,'L,T,B,R',0,'L',0);      
         $pdf->Cell($w[9],8,$proceso." - ".$horapro,'L,T,B,R',0,'L',0);
         $pdf->Cell($w[10],8,$tipindole,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[11],8,$ubicacion,'L,T,B,R',0,'C',0);
         $pdf->Cell($w[12],8,$responsable,'L,T,B,R',0,'L',0);

         $x = $pdf->Getx();
         $y = $pdf->Gety();
         $pdf->Image("$buscaimage",239,$y+2,30,25,'JPG');
         $pdf->ln(30);
         $pdf->line(10,($y+1),270,($y+1)); 
         $pdf->ln(2);
       }
     }    
     $regef = pg_fetch_array($res_pedido);
  } 

  $pdf->ln(6);
  $x = $pdf->Getx();
  $y = $pdf->Gety();
  $pdf->line($x,($y+1),270,($y+1));  
  $pdf->SetFont('','B',8);
  $pdf->ln(6);
  $pdf->Cell(25,8,"Total Planillas Procesadas: ".$total_pro,0,1);

  $pdf->SetX(10);
  $pdf->Cell(0,8,"Total Planillas Habilitadas: ".$total_hab."                     Total Planillas Normales: ".$total_nor."               Total Archivos por Impresora: ".$total_imp."               Total Archivos por Correo: ".$total_cor."       Total Correos enviados: ".$totcorreos,0,1);
  $indole = "I= Indole: N-> Persona Natural,     P-> Persona Juridica,     G-> Sector Gobierno,     C-> Cooperativa,     O-> Comunal    - / -    P=Prioridad: H -> Habilitada,    N -> Normal";
  $pdf->Cell(0,8,$indole,0,1);
  $pdf->Cell(0,8,"E=Envio: I -> Impresora,    C -> Correo   -  /  -  U=Sede: 1->SAPI,      2->El Chorro,      3->Sistema En Linea WEBPI",0,1);
  $pdf->Cell(0,8,"Total Natural: ".$total_nat."        Total Juridico: ".$total_jur."        Total Gobierno: ".$total_gob."        Total Cooperativa: ".$total_cop."        Total Comunal: ".$total_com,0,1);
  $pdf->SetFont('','',8);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
