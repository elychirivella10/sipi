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
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n de Forma - Anotaciones Marginales');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$vsol1   = $_POST["vsol1"];
$vsol2   = $_POST["vsol2"];
$vsol1h  = $_POST["vsol1h"];
$vsol2h  = $_POST["vsol2h"];
$nconex  = $_POST['nconex'];
$usuario = $_POST['usuario'];
$tipoest = $_POST['tipoest'];
$desdec  = $_POST['fecsold'];
$hastac  = $_POST['fecsolh'];

$vsold=($vsol1.$vsol2);
$vsolh=($vsol1h.$vsol2h);

if ($vsold=='' and $vsolh=='') {
   $vsold=$_GET["vsol"];
   $vsolh=$_GET["vsol"];
}
if ($vsolh=='') {
   $vsolh=$vsold;
}

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("vsold","vsolh");
  $valores = array($vsold,$vsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $req_fields = array("desdec","hastac");
     $valores = array($desdec,$hastac);
     $vacios = check_empty_fields();
     if (!$vacios) { 
        $smarty->display('encabezado1.tpl');
        mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); 
     }
  }

$queryregistro= " ";
if ($vsold!='' and $vsolh!='') {
   $queryregistro= " AND b.registro between '$vsold' and '$vsolh'"; 
}

if (($vsold=='' || $vsolh=='') and ($hastac=='' || $desdec=='')) {
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Datos Incorrectos o Vacios ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if (($vsolh < $vsold) or ($hastac < $desdec)) { 
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if (empty($usuario)) { 
    $queryusuario="AND c.usuario <> ''";
    //$smarty->display('encabezado1.tpl');
    //mensajenew('ERROR: El Campo Usuario NO puede estar Vacio ...!!!','javascript:history.back();','N');
    //$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
} else {
   $queryusuario="AND c.usuario = '$usuario'";
}

if (empty($desdec) or $desdec<'01/12/2020') { 
   $desdec='01/12/2020';
}

if (empty($hastac)) { 
   $queryfecha="c.fecha_trans >= '$desdec' ";
} else {
   $queryfecha="c.fecha_trans >= '$desdec' AND c.fecha_trans <= '$hastac' ";
}

//$rutafinal = '../documentos/devueltas/marcas/boletin';
//$archivo   = $rutafinal.$vbol."/".$varsol1.$varsol2.".pdf";

//Query para buscar las opciones deseadas para oficio 
//if(!empty($vsold) and !empty($vsolh) and ($vsold!='') and ($vsolh!='')) { 
   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.estatus, b.poder, a.clase, a.modalidad,
                              c.documento,substr(c.comentario,1,1) as tipodev,c.fecha_event,comentario  			
                FROM stmmarce a, stzderec b, stzevtrd c 
   		WHERE  a.nro_derecho = b.nro_derecho
   		AND b.nro_derecho = c.nro_derecho ".$queryregistro."
		AND tipo_mp='M' 
                AND ".$queryfecha."
   		AND b.estatus in (1555)
   		AND c.evento IN (1502) ".$queryusuario." ORDER BY b.solicitud");
//}

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
   $nderec=$reg['nro_derecho'];
   $tipo_esta=$reg['estatus'];
   $nclase =$reg['clase'];
   $modal  =$reg['modalidad'];
   $docum  =$reg['documento'];
   $tipdev =$reg['tipodev'];
   $fecdev =$reg['fecha_event'];
//   $n_poder=$reg['poder'];
//   $vtramita=trim($reg['tramitante']);
   if (strpos($reg['comentario'],'Poder:')>0) 
      { $n_poder=substr($reg['comentario'],strpos($reg['comentario'],'Poder:')+7,strlen($reg['comentario'])); }
   if (strpos($reg['comentario'],'Tramitante:')>0) 
      { $vtramita=substr($reg['comentario'],strpos($reg['comentario'],'Tramitante:')+12,strlen($reg['comentario'])); }

   $destipdev=' ';
   if ($tipdev=='C') {$destipdev='CESION';}
   if ($tipdev=='F') {$destipdev='FUSION';}
   if ($tipdev=='L') {$destipdev='LICENCIA DE USO';}
   if ($tipdev=='N') {$destipdev='CAMBIO DE NOMBRE DEL TITULAR';}
   if ($tipdev=='O') {$destipdev='CAMBIO DE DOMICILIO DEL TITULAR';}
   if ($tipdev=='R') {$destipdev='RENOVACION';}
   $varsol1=substr($varsol,-11,4);
   $varsol2=substr($varsol,-6,6);
   $nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";
 
//   if ($tipo_esta==1555) {  // Examen de Forma
//     $resulseg=pg_exec("SELECT * FROM stzsegudev WHERE nro_derecho='$nderec' AND evento=1502");
//     $regseg  = pg_fetch_array($resulseg);
//     $vseg    = $regseg['codigo1'];
//   }
   
    $pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,190,12,'JPEG');
    //$pdf->Image('../imagenes/logo_sapi.jpg',190,4,20,12,'JPEG');
    $pdf->Image('../imagenes/logosapi.jpg',190,4,20,12,'JPEG');

    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+14);

    $pdf->ln(2);
    $pdf->Cell(115,12,'CIUDADANO(A): ',0,0);
    $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION AL REGISTRO N° '),0,0,'R');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(209,4,$nregis,0,1);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(188,3,$vseg,0,0,'R');
    $pdf->SetFont('Arial','B',10);
    
    //$tram = agente_tramp($nagen,trim($reg['tramitante']),$n_poder);
    $tram = agente_tramp($nagen,$vtramita,$n_poder);
    $y = $pdf->Gety();
 	 $pdf->SetXY(10,$y+4);
    
    $pdf->MultiCell(199,4,utf8_decode($tram),0,'J',0);
    $pdf->SetFont('Arial','',10);

    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+2);
    $pdf->Cell(15,4,'Marca:',0,0);
    $pdf->Cell(20,4,utf8_decode($reg['nombre']),0,1);
    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+2);
    //$pdf->Cell(15,4,'Solicitud:',0,0);
    //$pdf->Cell(20,4,utf8_decode($reg['solicitud']),0,1);

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
    $pdf->MultiCell(198,4,utf8_decode('         De conformidad con lo establecido en el artículo 42 literal "b" de la Ley de Propiedad Industrial, y los artículos 71, literales a,b,c, 89 y 91 (ejusdem), en concordancia con los artículos 49 y 60 último aparte de la Ley Orgánica de Procedimientos Administrativos, se devuelve a usted, anexo a la solicitud de '.$destipdev.', de fecha '.$fecdev.', registro No. '.$nregis.', a fin de que se sirva cumplir con los siguientes requisitos que se señalan a continuación, en el presente oficio:'),0,'J',0);


    if ($tipo_esta==1555) {  // Examen de Forma
      $res_des=pg_exec("SELECT a.nro_derecho,a.cod_causa,b.desc_causa 
            FROM stzcaded a, stzcoded b 
            WHERE a.nro_derecho = '$nderec'
            AND a.cod_causa = b.cod_causa   
            AND a.derecho = b.derecho
            AND a.grupo = b.grupo
            AND a.tipo_dev = '$tipdev'    
            AND a.documento = '$docum' 
            AND a.derecho = 'M'
            AND a.grupo = 'A'
            ORDER BY a.cod_causa"); }


    $filas_coded = pg_numrows($res_des); 
    $regdes      = pg_fetch_array($res_des);
//    $usuaexam    = $regdes['nombre'];

    $pdf->ln(6);

    $indc=1;
    $valor=$regdes['cod_causa'];
    for ($j=0; $j<$filas_coded; $j++) {
      if (($valor!= $regdes['cod_causa']) or ($indc==1)) {
	  $pdf->MultiCell(198,6,'- '.utf8_decode($regdes['desc_causa'].''),0,'J',0);	  
          $indc=0;
      }
      $regdes = pg_fetch_array($res_des);
      if ($valor!= $regdes['cod_causa']) { $valor= $regdes['cod_causa']; $indc=1; }
    }

    // Busqueda de Causa de Devolucion (otros) 
    //$res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'A' 
                           AND tipo_dev = '$tipdev' AND documento='$docum'");
    $filas_otros= pg_numrows($res_otros);

    if ($filas_otros==0) { $nrgg=0; }
    else { 
       $regotr = pg_fetch_array($res_otros);
	    $pdf->MultiCell(198,6,utf8_decode('- '.$regotr['otros']),0,'J',0); }

    //Nota al pie
    $pdf->ln(8);
    $pdf->MultiCell(198,4,utf8_decode('Se hace de su conocimiento que tienen un lapso de treinta (30) días, para que subsane tal como lo establece el artículo 75 de la Ley de Propiedad Industrial vigente.'),0,'J',0);   
    $pdf->ln(8);

    $pdf->MultiCell(198,4,' Atentamente,',0,'J',0);
    //$pdf->MultiCell(198,4,'   Atentamente,                                                                                        Fecha de Entrega:____/____/________',0,'J',0);
    //$pdf->ln(4);
    //$pdf->MultiCell(198,4,'                                                                                                                Retirado Por:_______________________________',0,'J',0);
    $y = $pdf->Gety();
    //$pdf->SetXY(10,$y+21);
    //$pdf->ln(21);
    //$pdf->SetFont('Arial','B',8);
    //$pdf->MultiCell(200,1,utf8_decode(rtrim($usuaexam)).'                       '.utf8_decode(rtrim($registrador)),0,'J',0);
    //$pdf->SetFont('Arial','',10);
    //$pdf->MultiCell(198,4,'  ____________________              ______________________            C.I. No:___________    _______________________',0,'J',0);
    //$pdf->MultiCell(198,4,'  Funcionario Examinador      Registrador de la Propiedad Industrial                                                                     Firma',0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('                                               Resolución No. 005, de fecha 12 de Julio de 2018'),0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('                                               Gaceta Oficial de la República Bolivariana de Venezuela No. 41.438,'),0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('                                               de fecha 12 de Julio de 2018'),0,'J',0);

    //$pdf->MultiCell(190,5,'______________________________________________________');
    //$pdf->SetFont('Arial','B',10);    
    //$pdf->MultiCell(190,5,utf8_decode('Abog. AMADO ENRIQUE MAESTRI LOYO'));
    //$pdf->SetFont('Arial','',10);    
    //$pdf->MultiCell(190,5,utf8_decode('Registrador de la Propiedad Industrial'));
    //$pdf->MultiCell(190,5,utf8_decode('Resolución No. 005, de fecha 12 de Julio de 2018'),0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('Gaceta Oficial de la República Bolivariana de Venezuela No. 41.438,'),0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('de fecha 12 de Julio de 2018'),0,'J',0);
    //$pdf->Image('../imagenes/firma_registrador.jpg',45,$y,125,65,'JPEG');
    $pdf->Image('../imagenes/firma1_registradora2020.jpg',45,$y,125,65,'JPEG');

    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage();
    }
  }     

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>
