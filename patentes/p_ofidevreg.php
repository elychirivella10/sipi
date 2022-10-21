<?php

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

//Variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit(); }

$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$vorden  = $_GET["orden"];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Oficios de Devoluci&oacute;n de Anotaciones Marginales');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql->connection($usuario);

$fechahoy = Hoy();
$horahoy  = Hora();

$tablas = "stzofdev, stzderec";   

 $cantidad=pg_exec("SELECT DISTINCT ON (orden,solicitud,documento) stzofdev.orden, stzderec.solicitud, stzofdev.documento, stzofdev.estatus, stzderec.nro_derecho FROM $tablas WHERE stzofdev.estatus='N' AND stzofdev.fecha_carga='$fechahoy' AND stzofdev.orden='$vorden' AND stzofdev.tipo_mp='P' AND stzofdev.solicitud = stzderec.solicitud");
 //$cantidad=pg_exec("SELECT stzofdev.orden, stzderec.solicitud, stzofdev.documento, stzofdev.estatus, stzderec.nro_derecho FROM $tablas WHERE stzofdev.estatus='N' AND stzofdev.fecha_carga='$fechahoy' AND stzofdev.orden='$vorden' AND stzofdev.tipo_mp='P' AND stzofdev.solicitud = stzderec.solicitud");
 $totalr=pg_numrows($cantidad);
 
 // Imprimir Oficio PDF

 //Inicio del Pdf
 $pdf = new PDF_Table('P','mm','Letter');
 $pdf->Open();
 $pdf->AddPage();
 $pdf->AliasNbPages();
 $pdf->SetFont('Arial','',9);

 $reg=pg_fetch_array($cantidad);
 for($cont=0;$cont<$totalr;$cont++) { 
   $v1   = $reg['solicitud'];
   $vdoc = $reg['documento'];

   $obj_query = $sql->query("SELECT nro_derecho FROM stzderec WHERE solicitud='$v1' AND tipo_mp='P'"); 
   $objs = $sql->objects('',$obj_query);
   $nderec = $objs->nro_derecho;

   $res_tipo_dev = pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho = '$nderec' and documento='$vdoc'"); 
   $reg_tipo_dev = pg_fetch_array($res_tipo_dev);
   $fecha_dev    = $reg_tipo_dev[fecha_event];
   $tipo_dev     = substr($reg_tipo_dev[comentario],0,1);
   switch ($tipo_dev) {
     case "F":
       $vtitulo="FUSION";
       break;
     case "C":
       $vtitulo="CESION";
       break;
     case "L":
       $vtitulo="LICENCIA DE USO";
       break;
     case "N":
       $vtitulo="CAMBIO DE NOMBRE";
       break;
     case "O":
       $vtitulo="CAMBIO DE DOMICILIO";
       break;
   }
   $valcomenta = trim($reg_tipo_dev[comentario]); 
   $pos_fecha  = strpos($valcomenta,":");
   $fecha_tra  = substr($valcomenta,$pos_fecha+2,10); 

   // Encabezado del pdf
   $pdf->MultiCell(0,4,'REPUBLICA BOLIVARIANA DE VENEZUELA ',0,1,'C');
   $pdf->MultiCell(0,4,'MINISTERIO PARA EL PODER POPULAR PARA EL COMERCIO ',0,1,'C');
   $pdf->MultiCell(0,4,'SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL ',0,1,'C');
   $pdf->MultiCell(0,4,'REGISTRO DE LA PROPIEDAD INDUSTRIAL ',0,1,'C');
   $pdf->ln(3);
   $pdf->Cell(115,9,'CIUDADANO(A): ',0,0);
   $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION N° '),0,0,'R');

   $res=pg_exec("SELECT stzderec.solicitud, stzderec.nombre,stzderec.fecha_solic,
                        stzderec.registro,stzderec.tramitante, stzderec.agente
                 FROM   stzderec
   		        WHERE (stzderec.nro_derecho = '$nderec') 
   		        AND    stzderec.registro <> ''");

   $reg_mar = pg_fetch_array($res);
   $filas_found1=pg_numrows($res); 
   $vsol      = $reg_mar['solicitud'];
   $vregistro = trim($reg_mar['registro']);

   $numero_oficio = $reg_mar['registro']." - ".$vdoc;
   $pdf->Cell(209,4,$numero_oficio,0,1);
         
   $tram = agente_tram($reg_mar['agente'],$reg_mar['tramitante'],'1');
   $pdf->SetFont('Arial','B');
   $pdf->Cell(35,7,$tram,0,1); 
   $pdf->SetFont('Arial','',9);

   $pdf->Cell(15,4,'Titulo:',0,0);
   $pdf->Cell(20,4,$reg_mar['nombre'],0,1);
   $pdf->ln(2);

     $res_des=pg_exec("SELECT  c.nro_derecho,c.cod_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
 					  FROM stzderec b, stzcaded c
 					  WHERE c.nro_derecho = '$nderec' 
					  AND c.nro_derecho= b.nro_derecho  
 					  AND c.derecho = 'P'
					  AND c.grupo = 'A'
					  AND c.documento = $vdoc
 					  ORDER BY c.cod_causa");

    $filas_found1= pg_numrows($res_des); 
    $regdes = pg_fetch_array($res_des);

    $res_coded=pg_exec("SELECT * FROM stzcoded WHERE derecho = 'P' AND grupo = 'A' order by cod_causa");
    $filas_coded= pg_numrows($res_coded);
    $reg_coded = pg_fetch_array($res_coded);
 
   //Cuerpo del pdf   
   $pdf->MultiCell(198,5,utf8_decode('     De conformidad con lo establecido en el artículo 42 literal "b" de la Ley de Propiedad Industrial, y los artículos 89, literales a,b,c, y d, y 91 (ejusdem), en concordancia con los artículos 49 y 60 último aparte de la Ley Orgánica de Procedimientos Administrativos, se devuelve a usted, anexo a la solicitud de ').$vtitulo.', de fecha '.$fecha_tra.', registro No. '.$vregistro.utf8_decode(', a fin de que se sirva cumplir con los siguientes requisitos que se señalan a continuación:'),0,'J',0);
   $pdf->ln(2);

   for ($j=0; $j<$filas_coded; $j++) {
         if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'(X)'),0,'J',0);
	        $regdes = pg_fetch_array($res_des);
 	 }
	 else {
		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'( )'),0,'J',0); }

        $reg_coded = pg_fetch_array($res_coded);
     }
	 
    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'P' AND grupo = 'A' AND documento=$vdoc");
    $filas_otros= pg_numrows($res_otros);

    // Busqueda de Causa de Devolucion (otros) 
    if ($filas_otros==0) {$pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '),0,'J',0);}
    else { 
        $regotr = pg_fetch_array($res_otros);
	$pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '.$regotr['otros']),0,'J',0); }


   $pdf->ln(3);
   $pdf->MultiCell(198,5,utf8_decode('     Se hace de su conocimiento que tienen un lapso de treinta (30) días, para que subsane tal como lo establece el artículo 75 de la Ley de Propiedad Industrial vigente.'),0,'J',0);
   $pdf->SetFont('');
   $pdf->SetFont('Arial','',9);
   $pdf->ln(3);
   $pdf->MultiCell(115,4,'          Recibido Por: ',0,'R',0);
   $pdf->ln(1);
   $pdf->MultiCell(115,4,'          C.I.No.: ',0,'R',0);
   $pdf->MultiCell(115,4,'          Fecha: ',0,'R',0);
   $pdf->ln(1);
   $pdf->MultiCell(115,4,'          Firma: ',0,'R',0);
   $pdf->ln(1);
   //$pdf->SetFont('Arial','B',9);
   //$pdf->MultiCell(95,4,utf8_decode('  MARIA ALEJANDRA MEDINA MAZARELLI'),0,'L',0);
   $pdf->SetFont('Arial','',9);
   $pdf->MultiCell(100,4,'  Registradora de la Propiedad Industrial',0,'L',0);

   $sol='';
   $update_str = "estatus='S'";
   $sql->update("stzofdev","$update_str","solicitud='$vsol' and documento='$vdoc' AND tipo_mp='P'");
//   $reg=pg_fetch_array($cantidad);

   if  ($cont!=$totalr) {$pdf->AddPage();
       $reg = pg_fetch_array($cantidad);}

  //   if ($cont+1<$total) {$pdf->AddPage();}
 }
//Eliminar datos temporales 
$sql->del("stptmpam","usuario='$usuario'");

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>
