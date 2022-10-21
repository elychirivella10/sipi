<?php
// *************************************************************************************
// Programa: m_gendevolfon.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza - PIII 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Desarrollado Año: 2021 I Semestre
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
$modulo  = "m_gendevolfon.php";
$fecha   = fechahoy();
$fechahoy  = hoy();
$hh        = hora();
$tbname_4 = "stzsegudev";

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/PDF_tablesep.php");

//Conexion
$sql = new mod_db();
$sql->connection($usuario);

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Oficios de Devoluci&oacute;n Fondo x Bolet&iacute;n con Firma Digital');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$vopc     = $_GET['vopc'];

if ($vopc==1) {
//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Bolet&iacute;n:');
}

if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {	 
    Mensajenew("ERROR: Opcion Deshabilitada, por favor contacte al Administrador del Sistema ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}  

if ($vopc==2) {
 //Validacion de Entrada
 $boletin = trim($_POST["boletin"]);
 $vsol1 = $_POST["vsol1"];
 $vsol2 = $_POST["vsol2"];
 $vsol3 = $_POST["vsol1h"];
 $vsol4 = $_POST["vsol2h"];
 //$registrador = "Abog. AMADO ENRIQUE MAESTRI LOYO";
 $rutafinal = $ruta_devolucion."/marcas/fondo/boletin";
 
 if ((empty($boletin)) && (empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4))) {
   mensajenew('ERROR: Debe introducir un Criterio de B&uacute;squeda ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ($boletin < 607) {
   mensajenew('ERROR: El Boletin a generar y firmar NO puede ser menor al 608 ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 }

 if ((!empty($vsol1)) && (!empty($vsol2)) && ((empty($vsol3)) || (empty($vsol4)))) {
   mensajenew('ERROR: Debe introducir el rango final de Solicitud para proseguir ...!!!','javascript:history.back();','N');   
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 } 

 if ((!empty($vsol1)) && (!empty($vsol2)) && (!empty($vsol3)) && (!empty($vsol4))) {
   if (empty($boletin)) {
     mensajenew('ERROR: Debe introducir el Numero de Boletin para proseguir ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } else {
     $vsoli=sprintf("%04d-%06d",$vsol1,$vsol2);
     $vsolf=sprintf("%04d-%06d",$vsol3,$vsol4);
 
     if ($vsoli > $vsolf) {  
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

       $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.estatus, b.poder, a.clase, a.modalidad    		FROM stmmarce a, stzderec b, stzevtrd c 
   		WHERE  a.nro_derecho = b.nro_derecho
   		AND b.nro_derecho = c.nro_derecho
		AND b.solicitud between '$vsoli' AND '$vsolf' 
		AND tipo_mp='M' 
   		AND b.estatus IN (1118)
                AND c.documento='$boletin'
   		AND c.evento IN (1122) ORDER BY b.solicitud");

//                AND c.documento='$boletin'
//AND c.evento IN (1122) ORDER BY b.solicitud");

     //verificando los resultados
     if (!$resultado) { 
       mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     $filas_found=pg_numrows($resultado); 
   }
 }

 if (!empty($boletin) &&  ((empty($vsol1)) && (empty($vsol2)) && (empty($vsol3)) && (empty($vsol4)))) {
   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.estatus, b.poder, a.clase, a.modalidad    		FROM stmmarce a, stzderec b, stzevtrd c 
   		WHERE  a.nro_derecho = b.nro_derecho
   		AND b.nro_derecho = c.nro_derecho
		AND tipo_mp='M' 
   		AND b.estatus IN (1118)
                AND c.documento='$boletin'
   		AND c.evento IN (1122) ORDER BY b.solicitud");

//                 AND c.documento='$boletin'

//   		AND c.evento IN (1122) 

   //verificando los resultados
   if (!$resultado) { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   $filas_found=pg_numrows($resultado); 
 }

 //echo " $vsoli, $vsolf, $boletin, $filas_found, $rutafinal ";

 if ($filas_found>0) {
  $reg = pg_fetch_array($resultado);
  $diripmaq = getRealIP();

  $aa =substr($fechahoy,6,4);  
  $mm =substr($fechahoy,3,2);  
  $dd =substr($fechahoy,0,2);  
  $hor=substr($hh,0,2);    
  $min=substr($hh,3,2);  
  $seg=substr($hh,6,2);  
  $tur=substr($hh,9,2);  

  //$vder = 302321;
  //$codesDir = "codes/"; 
  //$filename= $vder.".png";
  //$content = "http://certificado.sapi.gob.ve/validar_tramite.php?vnsol=".$vder;
  //QRcode::png($content,$codesDir.$filename,QR_ECLEVEL_L,10,2);
  //$boletin = 608;
  $codesDir = "../documentos/devueltas/marcas/imagen_qr_fd/"; 

  //for($cont=0;$cont<1;$cont++)   {

  for($cont=0;$cont<$filas_found;$cont++)   {
    //Inicio del Pdf
    $pdf=new PDF_Table('P','mm','Letter');
    $pdf->Open();
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','',10);

    $varsol=$reg['solicitud'];
    $nregis=$reg['registro'];
    $nagen=$reg['agente'];
    $nderec=$reg['nro_derecho'];
    $tipo_esta=$reg['estatus'];
    $n_poder=$reg['poder'];
    $nclase =$reg['clase'];
    $modal  =$reg['modalidad'];
    $varsol1=substr($varsol,-11,4);
    $varsol2=substr($varsol,-6,6);
    $nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";
    $pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,190,12,'JPEG');
    $pdf->Image('../imagenes/logosapi.jpg',190,4,20,12,'JPEG');
    //Ruta Final para la Generacion del Oficio de Devolucion
    $archivo = $rutafinal.$boletin."/".$varsol1.$varsol2.".pdf";
    //Nombre del archivo QR 
    $filenameqr= $varsol1.$varsol2.".png";
    //echo "$archivo,$varsol1,$varsol2 "; exit();
    $codseg2=generarCodigo(15);
      
    $codseg1=$nderec."M".$varsol1.$varsol2.$dd.$mm.$aa.$hor.$min.$seg.$tur.'1122'.$codseg2.$boletin;

    //$content = "Codigo Devolucion=".$codseg1;
    $content = "http://webpi.sapi.gob.ve/devolucion/verificadocwpif.php?s=$varsol&b=$boletin&c=$codseg2";
    QRcode::png($content,$codesDir.$filenameqr,QR_ECLEVEL_L,10,2);

    //Registro de Codigo de la Seguridad    
    $del_datos = $sql->del("$tbname_4","nro_derecho='$nderec'");
    $insert_campos="nro_derecho,solicitud,derecho,evento,fecha_dev,hora,codigo1,codigo2,usuario";
    $insert_valores ="$nderec,'$varsol','M',1122,'$fechahoy','$hh','$codseg1','$codseg2','$usuario'";
    $ins_otros = $sql->insert("stzsegudev","$insert_campos","$insert_valores","");	 

    $y = $pdf->Gety();
    $pdf->SetXY(10,$y+14);

    $pdf->ln(2);
    $pdf->Cell(115,12,'CIUDADANO(A): ',0,0);
    $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION FONDO A SOLICITUD N° '),0,0,'R');
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

    //Tablas para el Nuevo Formato de Devolucion
    //if (($tipo_esta==1200) || ($tipo_esta==1113)) {  // Examen de Forma
    //  $res_des=pg_exec("SELECT c.nro_derecho,c.cod_causa,c.sub_causa,d.desc_causa,e.desc_sub_causa,f.nombre 
    //        FROM stzsoldev c, stzcadev d, stzsubcodev e, stzusuar f 
    //        WHERE c.nro_derecho = '$nderec' 
    //        AND c.cod_causa = d.cod_causa
    //        AND c.cod_causa = e.cod_causa
    //        AND c.sub_causa = e.sub_causa
    //        AND c.usuario = f.usuario
    //        AND c.derecho = 'M'
    //        AND c.grupo = 'M'
    //        AND c.tipo_dev = 'M'
    //        ORDER BY c.cod_causa"); }

    //if (($tipo_esta==1116) || ($tipo_esta==1118)) {  // Examen de Fondo
    //  $res_des=pg_exec("SELECT c.nro_derecho,c.cod_causa,c.sub_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
    //        FROM stmmarce a, stzderec b, stzsoldev c
    //        WHERE c.nro_derecho = '$nderec' 
    //        AND c.nro_derecho= b.nro_derecho  
    //        AND b.nro_derecho = a.nro_derecho 
    //        AND c.derecho = 'M'
    //        AND c.grupo = 'M'
    //        AND c.tipo_dev = 'D'
    //        ORDER BY c.cod_causa"); }

    if (($tipo_esta==1200) || ($tipo_esta==1113) || ($tipo_esta==1300)) {  
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

    $filas_coded = pg_numrows($res_des); 
    $regdes      = pg_fetch_array($res_des);
    $usuaexam    = $regdes['nombre'];

    $pdf->ln(6);

    //Tablas para el Nuevo Formato de Devolucion
    //$indc=1;
    //$valor=$regdes['cod_causa'];
    //for ($j=0; $j<$filas_coded; $j++) {
	 //  if (($valor!= $regdes['cod_causa']) or ($indc==1)) {
	//	  $pdf->MultiCell(198,6,'- '.utf8_decode($regdes['desc_causa'].''),0,'J',0);
	//	  $subcausa = trim($regdes['desc_sub_causa']);
	//	  if (!empty($subcausa)) {
	//	    $pdf->MultiCell(198,6,'      -> '.utf8_decode($regdes['desc_sub_causa'].''),0,'J',0); }
   // 	  $indc=0;
   //   }
   //   else {
	//	  $pdf->MultiCell(198,6,'      -> '.utf8_decode($regdes['desc_sub_causa'].''),0,'J',0);
   //   }  
   //   $regdes = pg_fetch_array($res_des);
   //   if ($valor!= $regdes['cod_causa']) { $valor= $regdes['cod_causa']; $indc=1; }
   // }

    $res_coded=pg_exec("SELECT * FROM stzcoded WHERE derecho = 'M' AND grupo = 'M' order by cod_causa");
    $filas_coded= pg_numrows($res_coded);
    $reg_coded = pg_fetch_array($res_coded);

    $pdf->ln(6);
    for ($j=0; $j<$filas_coded; $j++) {
      if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
		  $pdf->MultiCell(198,6,'- '.utf8_decode($reg_coded['desc_causa'].''),0,'J',0);
        $regdes = pg_fetch_array($res_des); }
      $reg_coded = pg_fetch_array($res_coded);
    }

    // Busqueda de Causa de Devolucion (otros) 
    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
    $filas_otros= pg_numrows($res_otros);

    if ($filas_otros==0) { $nrgg=0; }
    else { 
       $regotr = pg_fetch_array($res_otros);
	    $pdf->MultiCell(198,6,utf8_decode('- Otros: '.$regotr['otros']),0,'J',0); }

    //Nota al pie
    $pdf->ln(8);
    $pdf->MultiCell(198,4,utf8_decode('De no cumplirse con los requisitos exigidos en el presente oficio, dentro del plazo de treinta (30) días hábiles, contados desde la notificación de la devolución en el Boletín de la Propiedad Industrial, se procederá a declarar la prioridad extinguida.'),0,'J',0);   
    $pdf->ln(8);

    $pdf->MultiCell(198,4,' Atentamente,',0,'J',0);
    //$pdf->ln(21);
    $y = $pdf->Gety();

    //$pdf->MultiCell(190,5,'______________________________________________________');
    //$pdf->SetFont('Arial','B',10);    
    //$pdf->MultiCell(190,5,utf8_decode('Abog. AMADO ENRIQUE MAESTRI LOYO'));
    //$pdf->SetFont('Arial','',10);    
    //$pdf->MultiCell(190,5,utf8_decode('Registrador de la Propiedad Industrial'));
    //$pdf->MultiCell(190,5,utf8_decode('Resolución No. 005, de fecha 12 de Julio de 2018'),0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('Gaceta Oficial de la República Bolivariana de Venezuela No. 41.438,'),0,'J',0);
    //$pdf->MultiCell(190,5,utf8_decode('de fecha 12 de Julio de 2018'),0,'J',0);
    //$pdf->Image('../imagenes/firma1_registradora2020.jpg',45,$y,125,65,'JPEG');
    //$pdf->Image('../imagenes/firma_registradora_2122.jpg',45,$y,125,65,'JPEG');
    $pdf->Image('../imagenes/kruzcaya.jpg',45,$y,125,65,'JPEG');
    $pdf->Image('../documentos/devueltas/marcas/imagen_qr_fd/'.$filenameqr,170,$y+5,35,35,'PNG');

    $pdf->Output($archivo);
    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage(); }
  }     

 }
                 
 //Desconexion a la base de datos
 $sql->disconnect();

 //COPIA DEL ARCHIVO PDF DEL SERVIDOR 172.16.0.30 AL 172.16.0.130 
 //$cmd="scp -P 3535 /var/www/apl/sipi/documentos/devueltas/marcas/*.pdf www-data@172.16.0.130:/var/www/apl/multimedia/marcas/devueltas/"; 
 //exec($cmd,$salida);
 //foreach($salida as $line) { 
 //echo "Holaa<br>";	
 //echo "$line<br>"; }


 $cmd="scp -P 3535 /var/www/apl/sipi/documentos/devueltas/marcas/fondo/boletin$boletin/*.pdf www-data@172.16.0.7:/var/www/apl/webpi/documentos/devolucion/marcas/fondo/boletin$boletin"; 
 //echo "$cmd"; exit();
 exec($cmd,$salida);
 //foreach($salida as $line) { 
 //echo "Holaa<br>";	
 //echo "$line<br>"; }

   $vmessage="$filas_found OFICIO(S) DE DEVOLUCION FONDO GENERADO(S) ...!!";
   $vmessage1="";
   echo "<br><br>";
   echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
   echo "   <tr>";
   echo "     <td colspan='2' height='60'>";
   echo "        <img src='../imagenes/messagebox_info.png' align='middle'>";
   echo "     </td>";
   echo "     <td colspan='2' height='60'>";
   echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>$vmessage<br><br><font color='#FFFF00'></b></font>";
   echo "       </div>";
   echo "     </td>";
   echo "   </tr>";
   echo "</table>";
   echo "<p align='center'><a href='../marcas/m_gendevolfon.php?vopc=1'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";
   echo "<br>";
   $smarty->display('pie_pag.tpl'); 
}

if ($vopc==1) {
$smarty->assign('varfocus','forobscon.vsol1'); 
$smarty->display('m_gendevolfon.tpl');
$smarty->display('pie_pag.tpl');
}
$sql->disconnect();
?>
