<?php
// *************************************************************************************
// Programa: p_rptoficio.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza - PIII 
// Dirección de Sistemas y Tecnologias de la Informacion / SAPI / MPPCN
// Modificado Año: 2022 I Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

require ("$include_lib/PDF_tablesep.php");

//Variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit(); }

$login = $_SESSION['usuario_login'];
$role  = $_SESSION['usuario_rol'];
$fecha = fechahoy();

$registrador2= 'Abog. HENDRICK J. PERDOMO COLMENARES';
$registrador3= "Registrador de la Propiedad Industrial";
$registrador4= "Designado mediante Resolución No. 067/2022 de fecha 16 de Agosto de 2022";
$registrador5= "Publicada en Gaceta Oficial de la República Bolivariana de Venezuela"; 
$registrador6= "Nº.458.154 de Fecha 24 de Agosto de 2022"; 

//Conexion
$sql  = new mod_db();
$sql->connection($login);


//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$tipo=$_POST["tipo"];
$nconex = $_POST['nconex'];

$vsold=sprintf($vsol1.'-'.$vsol2);
$vsolh=sprintf($vsol1h.'-'.$vsol2h);

// Pantalla titulos
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("vsold","vsolh");
  $valores = array($vsold,$vsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

if ($vsold=='-' || $vsolh=='-') {
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vsolh < $vsold) { 
    mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Query para buscar las opciones deseadas para oficio 
$tipo=$tipo+2000;
 if(!empty($vsold) and !empty($vsolh) and ($vsold!='0000-000000') and ($vsolh!='0000-000000')) { 
   //$resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.tipo_derecho, b.fecha_solic 				
	//		FROM stppatee a, stzderec b 
   //			WHERE  a.nro_derecho = b.nro_derecho
	//		AND b.solicitud between '$vsold' and '$vsolh' 
	//		AND tipo_mp='P' 
   //			AND b.estatus in ('$tipo')
	//		ORDER BY b.solicitud");

   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.tipo_derecho, b.fecha_solic 				
			FROM stppatee a, stzderec b 
   			WHERE  a.nro_derecho = b.nro_derecho
			AND b.solicitud between '$vsold' and '$vsolh' 
			AND tipo_mp='P' 
   			AND b.estatus in (2200,2202,2600)
			ORDER BY b.solicitud");
 }

//verificando los resultados
if (!$resultado)  { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)  {
    mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  } 

$reg = pg_fetch_array($resultado);
$varsol=$reg[solicitud];
$res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$reg[agente]' and agente!=''");
$resage = pg_fetch_array($res_agen);

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);  

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

   
    $pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,190,12,'JPEG');
    $pdf->Image('../imagenes/logo_sapi.jpg',190,4,20,12,'JPEG');
    $y = $pdf->Gety();
 	 $pdf->SetXY(10,$y+5);

    //$pdf->ln(2);
    $pdf->Setxy(130,30);
    $pdf->Cell(190,5,'Caracas, ',0,0);
    $pdf->ln(2);
    $pdf->Cell(115,8,'CIUDADANO(A): ',0,0);
    $pdf->Setxy(10,38);
    $ind=1;
    $tram = agente_tram($nagen,$reg['tramitante'],$ind);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(115,8,utf8_decode($tram),0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->Setxy(130,40);
    $pdf->Cell(90,4,utf8_decode('Oficio No.'),0,0);
    $pdf->Setxy(150,40);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60,4,$reg['solicitud'],0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->ln(6);
    $vtip=tipo_patente($reg['tipo_derecho']);
  //  $esmayor=compara_fechas('26/04/2006',$reg['fecha_solic']);


    $pdf->MultiCell(198,5,utf8_decode('         De conformidad con el Artículo 61 de la Ley de Propiedad Industrial, cumplo con devolver a Ud. anexo la solicitud de patente de: ').$vtip.'.',0,'J',0); 
    $pdf->ln(2);
    $pdf->Cell(15,8,'Titulada:',0,0);
    $pdf->MultiCell(185,5,utf8_decode($reg['nombre']),0,'J',0);
    $pdf->ln(1);
    $pdf->MultiCell(198,7,utf8_decode('Anotada bajo el No.'. $reg['solicitud'].', a fin de que se sirva cumplir con los requisitos señalado con una (X):'),0,'J',0);
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

    $pdf->ln(5);

    for ($j=0; $j<$filas_coded; $j++) {
         if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'(X)'),0,'J',0);
	        $regdes = pg_fetch_array($res_des);
 	 }
	 else {
		$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'( )'),0,'J',0); }

        $reg_coded = pg_fetch_array($res_coded);
     }


    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'P' AND grupo = 'M'");
    $filas_otros= pg_numrows($res_otros);
    $regotr = pg_fetch_array($res_otros);

 // Busqueda de Causa de Devolucion (otros) 
    if ($filas_otros>0) {
//        $regotr = pg_fetch_array($res_otros);
  	  $pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '.$regotr['otros']),0,'J',0);} 
    else { $pdf->MultiCell(198,6,utf8_decode(($filas_coded+1).') Otros: '),0,'J',0);}

    $res_bol = pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho = '$nderec' AND evento = 2500");
    $filas_bol = pg_numrows($res_bol); 
    $regbol = pg_fetch_array($res_bol);
    $boletin = $regbol['documento'];  
    $pdf->ln(8);

    $pdf->MultiCell(198,5,utf8_decode('NOTA: TODOS LOS DOCUMENTOS DEBEN SER PRESENTADOS EN IDIOMA CASTELLANO, AQUELLOS EN IDIOMA DISTINTO DEBERAN SER TRADUCIDOS POR INTERPRETE PUBLICO CERTIFICADO Y APOSTILLADOS SEGUN CORRESPONDA.'),0,'J',0);
    $pdf->ln(2);
    if ($filas_bol == 0) {
      $pdf->MultiCell(198,5,utf8_decode('Se notifica que de no cumplir con los requisitos expresados ut supra, en el plazo de Treinta (30) días hábiles, contados a partir de la publicación en el Boletín de la Propiedad Industrial No.___________ se considerará Extinguida la Prioridad de la misma de acuerdo al Artículo 61 de la Ley de Propiedad Industrial.'),0,'J',0);
    } else {
      $texto_final = "Se notifica que de no cumplir con los requisitos expresados ut supra, en el plazo de Treinta (30) días hábiles, contados a partir de la publicación en el Boletín de la Propiedad Industrial No. ".$boletin." se considerará Extinguida la Prioridad de la misma de acuerdo al Artículo 61 de la Ley de Propiedad Industrial.";
      $pdf->MultiCell(198,5,utf8_decode($texto_final),0,'J',0);
    }   
    $pdf->ln(4);
    $pdf->MultiCell(198,4,'   Atentamente,                                                                                        Fecha de Entrega:____/____/________',0,'J',0);
    $pdf->ln(4);
    $pdf->MultiCell(198,4,'                                                                                                                Retirado Por:_______________________________',0,'J',0);
    $pdf->ln(10);
    $pdf->MultiCell(198,4,'  ____________________              ______________________            C.I. No:___________    _______________________',0,'J',0);
    $pdf->MultiCell(198,4,'  Funcionario Examinador                            Registrador                                                                               Firma',0,'J',0);

    //$pdf->MultiCell(198,4,'Atentamente,',0,'J',0);
    //$y = $pdf->Gety();
    //$pdf->ln(2);
    //$pdf->MultiCell(198,4,utf8_decode('FIRMADO EN SU ORIGINAL'),0,'J',0);       
    //$pdf->MultiCell(198,4,' ______________________________________________________',0,'J',0);
    //$pdf->SetFont('Arial','B',10);    
    //$pdf->MultiCell(198,4,utf8_decode($registrador2),0,'J',0);
    //$pdf->SetFont('Arial','',10);    
    //$pdf->MultiCell(198,4,utf8_decode($registrador3),0,'J',0);       
    //$pdf->MultiCell(198,4,utf8_decode($registrador4),0,'J',0); 
    //$pdf->MultiCell(198,4,utf8_decode($registrador5),0,'J',0);         
    //$pdf->MultiCell(198,4,utf8_decode($registrador6),0,'J',0);         

    $reg = pg_fetch_array($resultado);

    if  ($cont+1!=$filas_found) {$pdf->AddPage();}

  }     
     
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>
