<?php
// *************************************************************************************
// Programa: p_devforesinfir.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza - PIII 
// Dirección de Sistemas y Tecnologias de la Informacion / SAPI / MPPCN
// Desarrollado Año: 2022 I Semestre
// *************************************************************************************

echo "<script language='javascript' type= 'text/javascript'>";
echo "  function valagente(v1,v2){"; 
echo "    if (v1!=''){";
echo "      v2.value=v1.value;";
echo "    }";
echo "  }";
echo "</script>";

ob_start();
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
include ("../z_includes.php");
include ("../phpqrcode/qrlib.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$modulo  = "p_gendevolucion.php";
$fecha   = fechahoy();
$fechahoy  = hoy();
$hh        = hora();
$tbname_4 = "stzsegudev";

$registrador2= 'HENDRICK J. PERDOMO COLMENARES';
$registrador3= "Registrador de la Propiedad Industrial";
$registrador4= "Designado mediante Resolución No. 067/2022 de fecha 16 de Agosto de 2022,";
$registrador5= "publicada en Gaceta Oficial de la República Bolivariana de Venezuela"; 
$registrador6= "Nº.42.447 de fecha 24 de Agosto de 2022"; 

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/PDF_tablesep.php");

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Generaci&oacute;n de Oficios de Devoluci&oacute;n Patentes x Bolet&iacute;n sin Firma Digital Expediente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$vopc     = $_GET['vopc'];

//Conexion
$sql = new mod_db();
$sql->connection($usuario);

if ($vopc==1) {
//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Bolet&iacute;n:');
}

if ($vopc==2) {
//Validacion de Entrada
$boletin = trim($_POST["boletin"]);
$vsol1 = $_POST["vsol1"];
$vsol2 = $_POST["vsol2"];
$vsol3 = $_POST["vsol1h"];
$vsol4 = $_POST["vsol2h"];
$rutafinal = $ruta_devolucion."/patentes/forma/boletin";
 
 if ((empty($boletin)) && (empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4))) {
   mensajenew('ERROR: Debe introducir un Criterio de B&uacute;squeda ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ($boletin < 613) {
   mensajenew('ERROR: El Boletin a generar y firmar NO puede ser menor al 615 ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ((!empty($vsol1)) && (!empty($vsol2)) && ((empty($vsol3)) || (empty($vsol4)))) {
   mensajenew('ERROR: Debe introducir el rango final de Solicitud para proseguir ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 } 

 if ((!empty($vsol1)) && (!empty($vsol2)) && (!empty($vsol3)) && (!empty($vsol4))) {
   if (empty($boletin)) {
     mensajenew('ERROR: Debe introducir el Numero de Boletin para proseguir ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
   else {
     $vsoli=sprintf("%04d-%06d",$vsol1,$vsol2);
     $vsolf=sprintf("%04d-%06d",$vsol3,$vsol4);
 
     if ($vsoli > $vsolf) {  
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');    
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
     }

     $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.tipo_derecho, b.fecha_solic         
     FROM stppatee a, stzderec b, stzevtrd c 
     WHERE a.nro_derecho = b.nro_derecho
       AND b.nro_derecho = c.nro_derecho
       AND b.solicitud between '$vsoli' and '$vsolf' 
       AND b.tipo_mp='P' 
       AND b.estatus IN (2202)
       AND c.evento IN (2122) 
       AND c.documento='$boletin'
     ORDER BY b.solicitud");


//       AND b.estatus IN (2202)
//       AND c.evento IN (2122) 

//     AND c.documento='$boletin'

     //verificando los resultados
     if (!$resultado) { 
       mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');   
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     $filas_found=pg_numrows($resultado); 
   }
 }

 if (!empty($boletin) &&  ((empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4)))) {
   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.tipo_derecho, b.fecha_solic         
     FROM stppatee a, stzderec b, stzevtrd c 
     WHERE a.nro_derecho = b.nro_derecho
  		 AND b.nro_derecho = c.nro_derecho
       AND b.tipo_mp='P' 
       AND b.estatus IN (2202)
       AND c.evento IN (2122)
       AND c.documento='$boletin'
     ORDER BY b.solicitud");

//       AND b.estatus IN (2202)
//       AND c.evento IN (2122) 
//       AND c.documento='$boletin'

   //verificando los resultados
   if (!$resultado) { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','../patentes/p_devforesinfir.php?vopc=1','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filas_found=pg_numrows($resultado); 
 }

 //echo " $vsoli, $vsolf, $boletin, $filas_found, $rutafinal "; exit();
 if ($filas_found>0) {
  $diripmaq = getRealIP();

  $aa =substr($fechahoy,6,4);  
  $mm =substr($fechahoy,3,2);  
  $dd =substr($fechahoy,0,2);  
  $hor=substr($hh,0,2);    
  $min=substr($hh,3,2);  
  $seg=substr($hh,6,2);  
  $tur=substr($hh,9,2);  

  $codesDir = "../documentos/devueltas/patentes/imagen_qr/"; 

  //Inicio del Pdf
  $pdf=new PDF_Table('P','mm','Letter');
  $pdf->Open();
  $pdf->AddPage();
  $pdf->AliasNbPages();
  $pdf->SetFont('Arial','',10);

  $reg = pg_fetch_array($resultado);
  for($cont=0;$cont<$filas_found;$cont++)   {

    $varsol=$reg['solicitud'];
    $nregis=$reg['registro'];
    $nagen=$reg['agente'];
    $nderec=$reg['nro_derecho'];
    $tipo_esta=$reg['estatus'];
    $n_poder=$reg['poder'];
    $varsol1=substr($varsol,-11,4);
    $varsol2=substr($varsol,-6,6);
    $vtip=tipo_patente($reg['tipo_derecho']);

    $nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
    $pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,190,12,'JPEG');
    $pdf->Image('../imagenes/logosapi.jpg',190,4,20,12,'JPEG');
    //Ruta Final para la Generacion del Oficio de Devolucion
    $archivo = $rutafinal.$boletin."/".$varsol1.$varsol2.".pdf";
    //Nombre del archivo QR 
    $filenameqr= $varsol1.$varsol2.".png";
    //$codseg2=generarCodigo(15);
      
    $codseg1=$nderec."P".$varsol1.$varsol2.$dd.$mm.$aa.$hor.$min.$seg.$tur.'2122'.$codseg2.$boletin;

    $content = "http://webpi.sapi.gob.ve/devolucion/verificadocpwpi.php?s=$varsol&b=$boletin&c=$codseg2";
    //QRcode::png($content,$codesDir.$filenameqr,QR_ECLEVEL_L,10,2);

    //Registro de Codigo de la Seguridad    
    $del_datos = $sql->del("$tbname_4","nro_derecho='$nderec'");
    $insert_campos="nro_derecho,solicitud,derecho,evento,fecha_dev,hora,codigo1,codigo2,usuario";
    $insert_valores ="$nderec,'$varsol','P',2122,'$fechahoy','$hh','$codseg1','$codseg2','$usuario'";
    //$ins_otros = $sql->insert("stzsegudev","$insert_campos","$insert_valores","");	 

    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+14);

    $pdf->ln(2);
    $pdf->Cell(115,12,'CIUDADANO(A): ',0,0);
    $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION DE FORMA A SOLICITUD N° '),0,0,'R');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(209,4,$reg['solicitud'],0,1);

    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(188,3,$codseg1,0,0,'R');
    $pdf->SetFont('Arial','B',10);

    $tram = agente_tramp($nagen,trim($reg['tramitante']),$n_poder);
    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+4);
    
    $pdf->MultiCell(199,4,utf8_decode($tram),0,'J',0);
    $pdf->SetFont('Arial','',10);

    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+2);

    $pdf->MultiCell(198,5,utf8_decode('De conformidad con el Artículo 61 de la Ley de Propiedad Industrial, cumplo con devolver a Ud. anexo la solicitud de patente de: ').$vtip.'.',0,'J',0); 
    $pdf->ln(2);
    $pdf->Cell(15,4,'Titulada:',0,0);
    $pdf->MultiCell(185,5,utf8_decode($reg['nombre']),0,'J',0);
    $pdf->ln(1);
    $pdf->MultiCell(198,7,utf8_decode('Anotada bajo el No.: '.$reg['solicitud'].', a fin de que se sirva cumplir con los requisitos señalado con una (X):'),0,'J',0);
    $pdf->ln(3);

    $res_des=pg_exec("SELECT  c.nro_derecho,c.cod_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
 					  FROM stppatee a, stzderec b, stzcaded c
 					  WHERE c.nro_derecho = '$nderec' 
					  AND c.nro_derecho= b.nro_derecho  
 					  AND b.nro_derecho = a.nro_derecho 
					  AND c.derecho = 'P'
					  AND c.grupo = 'M'
 					  ORDER BY c.cod_causa");

    $filas_found1= pg_numrows($res_des); 
    $regdes = pg_fetch_array($res_des);

    $res_coded=pg_exec("SELECT * FROM stzcoded WHERE derecho = 'P' AND grupo = 'M' order by cod_causa");
    $filas_coded= pg_numrows($res_coded);
    $reg_coded = pg_fetch_array($res_coded);

    //$pdf->ln(5);
    for ($j=0; $j<$filas_coded; $j++) {
         if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'(X)'),0,'J',0);
	        $regdes = pg_fetch_array($res_des);
 	 }
	 else {
		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'( )'),0,'J',0); }

        $reg_coded = pg_fetch_array($res_coded);
     }

    // Busqueda de Causa de Devolucion (otros) 
    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'P' AND grupo = 'M'");
    $filas_otros= pg_numrows($res_otros);
    $regotr = pg_fetch_array($res_otros);
    if ($filas_otros>0) {
       $pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '.$regotr['otros']),0,'J',0); } 
    else { 
       $pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '),0,'J',0); }

    // Busqueda de Boletin a salir Publicada 
    $res_bol = pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho = '$nderec' AND evento = 2500");
    $filas_bol = pg_numrows($res_bol); 
    $regbol = pg_fetch_array($res_bol);
    $boletin = $regbol['documento'];  
    $pdf->ln(8);

    // Nota de Documentos ANEXOS 
    $pdf->MultiCell(198,5,utf8_decode('NOTA: TODOS LOS DOCUMENTOS DEBEN SER PRESENTADOS EN IDIOMA CASTELLANO, AQUELLOS EN IDIOMA DISTINTO DEBERAN SER TRADUCIDOS POR INTERPRETE PUBLICO CERTIFICADO Y APOSTILLADOS SEGUN CORRESPONDA.'),0,'J',0);

    //Nota al pie
    $pdf->ln(2);
    if ($filas_bol == 0) {
      $pdf->MultiCell(198,5,utf8_decode('Se notifica que de no cumplir con los requisitos expresados ut supra, en el plazo de Treinta (30) días hábiles, contados a partir de la publicación en el Boletín de la Propiedad Industrial No.___________ se considerará Extinguida la Prioridad de la misma de acuerdo al Artículo 61 de la Ley de Propiedad Industrial.'),0,'J',0);
    } else {
      $texto_final = "Se notifica que de no cumplir con los requisitos expresados ut supra, en el plazo de Treinta (30) días hábiles, contados a partir de la publicación en el Boletín de la Propiedad Industrial No. ".$boletin." se considerará Extinguida la Prioridad de la misma de acuerdo al Artículo 61 de la Ley de Propiedad Industrial.";
      $pdf->MultiCell(198,5,utf8_decode($texto_final),0,'J',0);
    }   

    //Firma del Registrador(a)
    $pdf->ln(5);
    $pdf->MultiCell(198,4,'Atentamente,',0,'J',0);
    $y = $pdf->Gety();
    $pdf->ln(2);
    $pdf->MultiCell(198,4,utf8_decode('FIRMADO EN SU ORIGINAL'),0,'J',0);       
    $pdf->MultiCell(198,4,' ______________________________________________________',0,'J',0);
    $pdf->SetFont('Arial','B',10);    
    $pdf->MultiCell(198,4,utf8_decode($registrador2),0,'J',0);
    $pdf->SetFont('Arial','',10);    
    $pdf->MultiCell(198,4,utf8_decode($registrador3),0,'J',0);       
    $pdf->MultiCell(198,4,utf8_decode($registrador4),0,'J',0); 
    $pdf->MultiCell(198,4,utf8_decode($registrador5),0,'J',0);         
    $pdf->MultiCell(198,4,utf8_decode($registrador6),0,'J',0);         

    //$pdf->Image('../imagenes/kruzcaya.jpg',45,$y,125,65,'JPEG');
    //$pdf->Image('../documentos/devueltas/patentes/imagen_qr/'.$filenameqr,170,$y+5,35,35,'PNG');

    $pdf->Output($archivo);
    //$pdf->Output();
    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage(); }
  }     

 }

//Desconexion a la base de datos
$sql->disconnect();

}

if ($vopc==1) {
$smarty->assign('varfocus','forobscon.vsol1'); 
$smarty->display('p_devforesinfir.tpl');
$smarty->display('pie_pag.tpl');
}
$sql->disconnect();
    
?>
