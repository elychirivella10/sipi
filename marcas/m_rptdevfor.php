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

if (empty($usuario)) { 
    $queryusuario="AND c.usuario <> ''";
} else {
   $queryusuario="AND c.usuario = '$usuario'";
}

 //Query para buscar las opciones deseadas para oficio 
   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.estatus    				
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
   $nderec=$reg['nro_derecho'];
   $tipo_esta=$reg['estatus'];

    $pdf->MultiCell(0,4,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'C');
    $pdf->MultiCell(0,4,'MINISTERIO DEL PODER POPULAR PARA EL COMERCIO',0,1,'C');
    $pdf->MultiCell(0,4,'SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL',0,1,'C');
    $pdf->MultiCell(0,4,'REGISTRO DE LA PROPIEDAD INDUSTRIAL.',0,1,'C');
    $pdf->ln(6);
    $pdf->Cell(115,9,'CIUDADANO(A): ',0,0);
    $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION A SOLICITUD N° '),0,0,'R');
    $pdf->Cell(209,4,$reg['solicitud'],0,1);
    $tram = agente_tram($nagen,$reg['tramitante']);
    $pdf->Cell(42,10,utf8_decode($tram),0,1);
    $pdf->Cell(15,4,'Marca:',0,0);
    $pdf->Cell(20,4,utf8_decode($reg['nombre']),0,1);
    $pdf->ln(8);
//    $pdf->MultiCell(198,4,utf8_decode('         Esta Autoridad Administrativa fundamentada en el artículo 1 de la Ley Organica de Procedimientos Administrativos (L.O.P.A.), una vez practicado el examen correspondiente a la solicitud en referencia, decide de conformidad con lo establecido en los artículos 50 (ejusdem), 71, 72, 75 de la Ley de Propiedad Industrial, devolver dicha solicitud a los fines de que el interesado se sirva subsanar las omisiones señaladas con una (X) en el presente oficio; y una vez contestado correctamente el oficio de devolución, se proceda a ordenar la publicación en prensa de conformidad con el artículo 76 de la Ley de Propiedad Industrial y en el Boletín de la Propiedad Industrial:'),0,'J',0);
    $pdf->MultiCell(198,4,utf8_decode('         Esta Autoridad Administrativa fundamentada en el artículo 1 de la Ley Organica de Procedimientos Administrativos (L.O.P.A.), una vez practicado el examen correspondiente a la solicitud en referencia, decide de conformidad con lo establecido en los artículos 50 (ejusdem), 71, 72, 75 de la Ley de Propiedad Industrial, devolver dicha solicitud a los fines de que el interesado se sirva subsanar las omisiones señaladas en el presente oficio; y una vez contestado correctamente el oficio de devolución, se proceda a ordenar la publicación en prensa de conformidad con el artículo 76 de la Ley de Propiedad Industrial y en el Boletín de la Propiedad Industrial:'),0,'J',0);


    if (($tipo_esta==1200) || ($tipo_esta==1113)) {  
      $res_des=pg_exec("SELECT  c.nro_derecho,c.cod_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
 					  FROM stmmarce a, stzderec b, stzcaded c
 					  WHERE c.nro_derecho = '$nderec' 
					  AND c.nro_derecho= b.nro_derecho  
 					  AND b.nro_derecho = a.nro_derecho 
					  AND c.derecho = 'M'
					  AND c.grupo = 'M'
					  AND c.tipo_dev = 'M'
 					  ORDER BY c.cod_causa"); }

    if (($tipo_esta==1116) || ($tipo_esta==1118)) {  
      $res_des=pg_exec("SELECT  c.nro_derecho,c.cod_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
 					  FROM stmmarce a, stzderec b, stzcaded c
 					  WHERE c.nro_derecho = '$nderec' 
					  AND c.nro_derecho= b.nro_derecho  
 					  AND b.nro_derecho = a.nro_derecho 
					  AND c.derecho = 'M'
					  AND c.grupo = 'M'
					  AND c.tipo_dev = 'D'
 					  ORDER BY c.cod_causa"); }

    $filas_found1= pg_numrows($res_des); 
    $regdes = pg_fetch_array($res_des);

    $res_coded=pg_exec("SELECT * FROM stzcoded WHERE derecho = 'M' AND grupo = 'M' order by cod_causa");
    $filas_coded= pg_numrows($res_coded);
    $reg_coded = pg_fetch_array($res_coded);

    $pdf->ln(6);

//    for ($j=0; $j<$filas_coded; $j++) {
	//echo "coded: ".$reg_coded['cod_causa']."des: ".$regdes['cod_causa'];
//         if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
//		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'(X)'),0,'J',0);
//	        $regdes = pg_fetch_array($res_des);
// 	 }
//	 else {
//		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'( )'),0,'J',0); }
//
//        $reg_coded = pg_fetch_array($res_coded);
//     }
	 
    for ($j=0; $j<$filas_coded; $j++) {
	//echo "coded: ".$reg_coded['cod_causa']."des: ".$regdes['cod_causa'];
         if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
		$pdf->MultiCell(198,6,'- '.utf8_decode($reg_coded['desc_causa'].''),0,'J',0);
          $regdes = pg_fetch_array($res_des); }
         $reg_coded = pg_fetch_array($res_coded);
     }

    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
    $filas_otros= pg_numrows($res_otros);

    // Busqueda de Causa de Devolucion (otros) 
//    if ($filas_otros==0) {$pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '),0,'J',0);}
//    else { 
//        $regotr = pg_fetch_array($res_otros);
//	$pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '.$regotr['otros']),0,'J',0); }

    if ($filas_otros==0) { $nrgg=0; }
    else { 
        $regotr = pg_fetch_array($res_otros);
	$pdf->MultiCell(198,6,utf8_decode('- Otros: '.$regotr['otros']),0,'J',0); }

//Nota al pie
    $pdf->ln(12);
    //$pdf->SetFont('Arial','',8);
    $pdf->MultiCell(198,4,utf8_decode('De no cumplirse con los requisitos exigidos en el presente oficio, dentro del plazo de treinta (30) días hábiles, contados desde la notificación de la devolución en el Boletín de la Propiedad Industrial, se procederá a declarar la prioridad extinguida.'),0,'J',0);   
    //$pdf->SetFont('Arial','',10);
    $pdf->ln(12);
 $pdf->ln(1);
    $pdf->MultiCell(198,4,'   Atentamente,                                                                    Fecha de Entrega:',0,'J',0);
    $pdf->ln(14);
    $pdf->MultiCell(198,4,utf8_decode('   El Registrador(a) de la Propiedad Industrial                    Retirado por: '),0,'J',0);
    
    $pdf->MultiCell(198,4,utf8_decode('                                                                                            C.I. No:                                                  Firma:'),0,'J',0);


	
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
