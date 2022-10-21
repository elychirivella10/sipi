<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

require ("$include_lib/PDF_tablesep.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n Ley 55');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$vsol1=$_GET["vsol"];
//$vsol2=$_GET["vsol2"];
$usuario = $_GET['vusr'];

$registrador = "Amado Maestri";

if (empty($usuario)) { 
    $queryusuario="AND c.usuario <> ''";
} else {
   $queryusuario="AND c.usuario = '$usuario'";
}

 //Query para buscar las opciones deseadas para oficio 
   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.estatus, a.clase, a.modalidad    				
			FROM stmmarce a, stzderec b, stzevtrd c 
   		WHERE  a.nro_derecho = b.nro_derecho
   		AND b.nro_derecho = c.nro_derecho
			AND b.solicitud ='$vsol1' 
			AND tipo_mp='M' 
   		AND b.estatus in (1200,1113,1116,1118)
   		AND c.evento IN (1500) ".$queryusuario." ORDER BY b.solicitud");

//verificando los resultados
if (!$resultado)  { 
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)  {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  } 
$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',10);

for($cont=0;$cont<$filas_found;$cont++)   { 
   $varsol=$reg['solicitud'];
   $nregis=$reg['registro'];
   $nagen=$reg['agente'];
//   if ($nagen==0) {$nagen='';}
   $nderec=$reg['nro_derecho'];
   $tipo_esta=$reg['estatus'];
   $n_poder=$reg['poder'];
   $nclase =$reg['clase'];
   $modal  =$reg['modalidad'];
   $varsol1=substr($varsol,-11,4);
   $varsol2=substr($varsol,-6,6);
   $nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";

   if (($tipo_esta==1200) || ($tipo_esta==1113)) {  // Examen de Forma
     $resulseg=pg_exec("SELECT * FROM stzsegudev WHERE nro_derecho='$nderec' AND evento=1053");
     $regseg  = pg_fetch_array($resulseg);
     $vseg    = $regseg['codigo1'];
   }
   
   //$pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,160,12,'JPEG');
  
   //$pdf->Image('../imagenes/logo_sapi.jpg',180,4,20,10,'JPEG');

   $pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,190,12,'JPEG');
   $pdf->Image('../imagenes/logosapi.jpg',190,4,20,12,'JPEG');

   $y = $pdf->Gety();
   $pdf->SetXY(10,$y+14);

   $pdf->ln(2);
   $pdf->Cell(115,12,'CIUDADANO(A): ',0,0);
   $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION A SOLICITUD N° '),0,0,'R');
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(209,4,$reg['solicitud'],0,1);

   $pdf->SetFont('Arial','B',7);
   $pdf->Cell(188,3,$vseg,0,0,'R');
   $pdf->SetFont('Arial','B',10);


   $tram = agente_tramp($nagen,trim($reg['tramitante']),$n_poder);
   $y = $pdf->Gety();
   $pdf->SetXY(10,$y+4);
    
   $pdf->MultiCell(199,4,utf8_decode($tram),0,'J',0);
   $pdf->SetFont('Arial','',10);

   $y = $pdf->Gety();
   $pdf->SetXY(10,$y+2);
   $pdf->Cell(15,4,'Marca:',0,0);
   $pdf->Cell(20,4,utf8_decode($reg['nombre']),0,1);

   if ($modal!="D" and file($nameimage)) {
     $y = $pdf->Gety();
     $pdf->Image("$nameimage",178,$y,30,25,'JPG');
     $y = $pdf->Gety();
     $pdf->SetXY(10,$y+8);
   }

   //$pdf->ln(2);
   $pdf->Cell(15,4,'Clase:',0,0);
   $pdf->Cell(20,4,$nclase,0,1);

   if ($modal!="D") {
     $pdf->ln(15); }
   else {
     $pdf->ln(8);
   }  

   $pdf->MultiCell(198,4,utf8_decode('         Esta Autoridad Administrativa fundamentada en el artículo 1 de la Ley Organica de Procedimientos Administrativos (L.O.P.A.), una vez practicado el examen correspondiente a la solicitud en referencia, decide de conformidad con lo establecido en los artículos 50 (ejusdem), 71, 72, 75 de la Ley de Propiedad Industrial, devolver dicha solicitud a los fines de que el interesado se sirva subsanar las omisiones señaladas en el presente oficio; y una vez contestado correctamente el oficio de devolución, se proceda a ordenar la publicación en prensa de conformidad con el artículo 76 de la Ley de Propiedad Industrial y en el Boletín de la Propiedad Industrial:'),0,'J',0);

   if (($tipo_esta==1200) || ($tipo_esta==1113)) {  // Examen de Forma
      $res_des=pg_exec("SELECT c.nro_derecho,c.cod_causa,c.sub_causa,d.desc_causa,e.desc_sub_causa,f.nombre 
            FROM stzsoldev c, stzcadev d, stzsubcodev e, stzusuar f 
            WHERE c.nro_derecho = '$nderec' 
            AND c.cod_causa = d.cod_causa
            AND c.cod_causa = e.cod_causa
            AND c.sub_causa = e.sub_causa
            AND c.usuario = f.usuario
            AND c.derecho = 'M'
            AND c.grupo = 'M'
            AND c.tipo_dev = 'M'
            ORDER BY c.cod_causa");

      $resulseg=pg_exec("SELECT * FROM stzsegudev WHERE nro_derecho='$nderec' AND evento=1053");
      $regseg  = pg_fetch_array($resulseg);
      $vseg    = $regseg['codigo1'];
             
   }

   if (($tipo_esta==1116) || ($tipo_esta==1118)) {  // Examen de Fondo
      $res_des=pg_exec("SELECT c.nro_derecho,c.cod_causa,c.sub_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
            FROM stmmarce a, stzderec b, stzsoldev c
            WHERE c.nro_derecho = '$nderec' 
            AND c.nro_derecho= b.nro_derecho  
            AND b.nro_derecho = a.nro_derecho 
            AND c.derecho = 'M'
            AND c.grupo = 'M'
            AND c.tipo_dev = 'D'
            ORDER BY c.cod_causa"); }

   $filas_coded= pg_numrows($res_des); 
   $regdes = pg_fetch_array($res_des);
   $usuaexam = $regdes['nombre'];

   $pdf->ln(6);

    //$causappal = 0;
    $valor=$regdes['cod_causa'];
    $indc=1;

    for ($j=0; $j<$filas_coded; $j++) {
	   if (($valor!= $regdes['cod_causa']) or ($indc==1)) {
		  $pdf->MultiCell(198,6,'- '.utf8_decode($regdes['desc_causa'].''),0,'J',0);
		  $subcausa = trim($regdes['sub_causa']);
		  //if (!empty($subcausa)) {
		  if ($subcausa!=0) {
		    $pdf->MultiCell(198,6,'      -> '.utf8_decode($regdes['desc_sub_causa'].''),0,'J',0); }
     	  $indc=0;
      }
      else {
		  $pdf->MultiCell(198,6,'      -> '.utf8_decode($regdes['desc_sub_causa'].''),0,'J',0);
      }  
      $regdes = pg_fetch_array($res_des);
      if ($valor!= $regdes['cod_causa']) { $valor= $regdes['cod_causa']; $indc=1; }
    }

    $res_otros=pg_exec("SELECT * FROM stzotrode WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
    $filas_otros= pg_numrows($res_otros);

    if ($filas_otros==0) { $nrgg=0; }
    else { 
        $regotr = pg_fetch_array($res_otros);
	$pdf->MultiCell(198,6,utf8_decode('- Otros: '.$regotr['otros']),0,'J',0); }

   $pdf->ln(6);
   $pdf->MultiCell(198,4,utf8_decode('De no cumplirse con los requisitos exigidos en el presente oficio, dentro del plazo de treinta (30) días hábiles, contados desde la notificación de la devolución en el Boletín de la Propiedad Industrial, se procederá a declarar la prioridad extinguida.'),0,'J',0);   
   $pdf->ln(8);
   $pdf->MultiCell(198,4,'Atentamente,',0,'J',0);
   $y = $pdf->Gety();
   //$pdf->Image('../imagenes/firma_registrador.jpg',45,$y,125,65,'JPEG');
   $pdf->Image('../imagenes/firma1_registradora2020.jpg',45,$y,125,65,'JPEG');
  
   //$y = $pdf->Gety();
   //$pdf->ln(1);
   //$pdf->SetFont('Arial','B',7);
   //$pdf->MultiCell(198,4,$vseg,0,'J',0);
   $reg = pg_fetch_array($resultado);
   if  ($cont+1!=$filas_found) {$pdf->AddPage();    //$reg = pg_fetch_array($resultado);
   }
  }     

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();

?>
