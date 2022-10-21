<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
ob_start();
include ("../z_includes.php");
//require ("$include_lib/PDF_tablesep.php");
//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();
$tbname1 = "stzderec";
$tbname2 = "stzevtrd";

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Prorrogas Otorgadas para Reingreso');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$nconex = $_POST['nconex'];

$vsold=($vsol1.'-'.$vsol2);
$vsolh=($vsol1h.'-'.$vsol2h);

// Verificacion de que los campos requeridos esten llenos...
$req_fields = array("vsold","vsolh");
$valores = array($vsold,$vsolh);
$vacios = check_empty_fields();
if (!$vacios) { 
  $smarty->display('encabezado1.tpl');
  Mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

if ($vsold=='-' || $vsolh=='-' ) {
  $smarty->display('encabezado1.tpl');
  mensajenew('AVISO: Datos Incorrectos o Vacios ...!!!','javascript:history.back();','N');    
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vsolh < $vsold) { 
  $smarty->display('encabezado1.tpl');
  mensajenew('AVISO: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas para oficio 
if(!empty($vsold) and !empty($vsolh) and ($vsold!='0000-000000') and ($vsolh!='0000-000000')) { 
  $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro    				
		FROM stmmarce a, stzderec b 
		WHERE  a.nro_derecho = b.nro_derecho
		AND b.solicitud between '$vsold' and '$vsolh' 
		AND tipo_mp='M' 
		AND b.estatus in (1119)
		ORDER BY b.solicitud");
 }

//verificando los resultados
if (!$resultado)  { 
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: Problema de Acceso a la Base de Datos ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)  {
  $smarty->display('encabezado1.tpl');
  mensajenew('AVISO: No existen Datos Asociados ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  } 
$reg = pg_fetch_array($resultado);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Oficio de Prorroga a Devolucion para Reingresar";
$linea="_________________________________________________________________________________________________";

//Incio de la Clase de PDF 
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
	//$this->Image("../imagenes/Logo-Sapi200.jpg",10,7,198,15,'JPG');
	$this->Ln(14);
	//$this->Cell(0,5,$encab_principal,0,1,'C');
	//$this->Cell(0,8,$encabezado,0,1,'C');
	$this->SetFont('Arial','',10);
	$this->Ln(2);
   }	
	
   public function Footer()
   {
    	//Posición: a 2,0 cm del final
    	$this->SetY(-20);
    	//Arial italic 7
    	$this->SetFont('Arial','I',7);
	//Número de página
    	$this->Cell(0,27,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    	$this->Text(10,273,"Fecha:");
    	$this->text(20,273,date('d/m/y'),0,1); 
    	$this->Text(185,273,"Hora:");
    	$this->text(192,273,date('h:i A'),0,1); 
   }
} 

//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 
$pdf->SetFont('Arial','B',10);

$pdf->Cell(0,4,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'L');
$pdf->Cell(0,4,'MINISTERIO DEL PODER POPULAR PARA EL COMERCIO',0,1,'L');
$pdf->Cell(0,4,'SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL',0,1,'L');
$pdf->Cell(0,4,'REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,1,'L');
$pdf->Ln(4);
//$pdf->SetFont('Arial','B',12);
$pdf->SetFont('Arial','B',10);
$pdf->ln(7);

for($cont=0;$cont<$filas_found;$cont++)   { 
   $varsol=$reg['solicitud'];
   $nregis=$reg['registro'];
   $nagen=$reg['agente'];
   $nderec=$reg['nro_derecho'];

   //Obtención de Datos del Evento de Publicacion de Devolucion 
   $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE evento=1122 AND estat_ant=1200 AND  nro_derecho='$nderec'");
   $objs = $sql->objects('',$obj_query);
   $vbol = $objs->documento;
   $fechavenc = $objs->fecha_venc;

   //Obtención de Datos del Evento de Solicitud de Prorroga 
   $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE evento=1028 AND  nro_derecho='$nderec'");
   $objs  = $sql->objects('',$obj_query);
   $vfec = $objs->fecha_event;

   //Obtención de Datos del Evento de Prorroga definitivo
   $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE evento IN (1029,1031) AND  nro_derecho='$nderec'");
   $objs = $sql->objects('',$obj_query);
   $veve = $objs->evento;
   $vpro = $objs->documento;

   $pdf->Cell(115,9,'CIUDADANO(A): ',0,0);
   $pdf->Cell(59,4,utf8_decode('OFICIO DE PRORROGA A SOLICITUD N° '),0,0,'R');
   $pdf->Cell(209,4,$reg['solicitud'],0,1);
   $tram = agente_tram($nagen,$reg['tramitante']);
   $pdf->Cell(42,10,utf8_decode($tram),0,1);
   $pdf->Cell(15,4,'Marca:',0,0);
   $pdf->Cell(20,4,$reg['nombre'],0,1);
   $pdf->SetFont('Arial','',10);
   $pdf->ln(5);
   $pdf->MultiCell(198,4,utf8_decode('         Esta Autoridad Administrativa una vez practicado la revisión de su Solicitud de Prorroga a la Contestación de la Devolución de Forma notificada en el Boletín de la Propiedad Industrial No. '.$vbol.', prorroga presentada en este Despacho en fecha '.$vfec.', correspondiente a la solicitud en referencia, decide de conformidad con lo establecido en el artículo 75 de la Ley de Propiedad Industrial, que su solicitud de prorroga es: '),0,'J',0);

    $causa4="";
    if ($veve==1031) { $causa4="X"; $causa1=""; $causa2=""; $causa3=""; }
    if ($veve==1029) {
      switch ($vpro) {
        case 1:
          $causa1="X"; $causa2=""; $causa3="";
          break;
        case 2:
          $causa1=""; $causa2="X"; $causa3="";
          break;
        case 3:
          $causa1=""; $causa2=""; $causa3="X";
          break;
      }       
    }

    $pdf->ln(5);
    $pdf->MultiCell(198,7,utf8_decode('1)  Acordada por un (1) Mes:  ________________('). $causa1.' )',0,'J',0);
    $pdf->MultiCell(198,7,utf8_decode('2)  Acordada por dos (2) Meses:  _____________('). $causa2.' )',0,'J',0);
    $pdf->MultiCell(198,7,utf8_decode('3)  Acordada por tres (3) Meses:  _____________('). $causa3.' )',0,'J',0);
    $pdf->MultiCell(198,7,utf8_decode('4)  Negada: ______________________________('). $causa4.' )',0,'J',0);

  
//Nota al pie
    $pdf->ln(6);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(198,4,utf8_decode('           De no cumplirse con los requisitos exigidos dentro del lapso establecido en el presente oficio, se procederá a declarar la prioridad extinguida.'),0,'J',0);   
    $pdf->SetFont('Arial','',10);
    $pdf->ln(7);
    $pdf->MultiCell(198,4,'   Atentamente,                                                                     Fecha de Entrega:',0,'J',0);
    $pdf->ln(5);
    $pdf->MultiCell(198,4,utf8_decode('   Margarita Vilatimo Rivero                                                  Retirado por: '),0,'J',0);
    
    $pdf->MultiCell(198,4,utf8_decode('   Registradora de la Propiedad Industrial                            C.I. No:                                                  Firma:'),0,'J',0);

    if  ($cont!=$filas_found) {$pdf->AddPage();
    $reg = pg_fetch_array($resultado);

  }     

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>
