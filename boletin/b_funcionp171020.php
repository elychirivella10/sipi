<?php
// *************************************************************************************
// Programa: b_funcionp.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año ... 2016, 2017 I, 2019 I Semestre - Division Nacionales / Extranjeras MPPCN
// *************************************************************************************
// Modificado por Romulo Mendoza 20/09/2011: faltaban las siguientes variables $negad,$fecp_nega,$titp_nega   
 function patentes($nbol,$anoi,$anof,$anor,$nro_resol,$solip,$fecp_soli,$titp_soli, $concp,$fecp_conc,$titp_conc,$ordep,$fecp_orde,$titp_orden,$devup,$fecp_devu,$titp_devu,$priop,$fecp_prio,$titp_prio,$prio_extep,$fecp_prio_exte,$titp_prio_exte,$prio_defep,$fecp_prio_defe,$titp_prio_defe,$perip,$fecp_peri,$titp_peri,$denep,$fecp_dene,$titp_dene,$desip,$fecp_desi,$titp_desi,$aband,$fecp_aban,$titp_aban,$negad,$fecp_nega,$titp_nega,$oposi,$fecp_opos,$titp_opos,$rehab,$fecp_reha,$titp_reha,$titul,$fecp_titu,$titp_titu,$psefp,$fecp_sefp,$titp_sefp,$psevt,$fecp_sevt,$titp_sevt,$pseder,$fecp_derp,$titp_derp) {

 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol;
 global $numbol,$pagina,$boletin,$nro_resoluc,$registrador1,$registrador2,$registrador3,$registrador4,$registrador5,$registrador6;
 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol;
 $ministerio  = "MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL";
 $registrador1= "";
 $registrador2= "LIGIA CRISTINA RODRIGUEZ";
 $registrador3= "Registradora de la Propiedad Industrial";
 $registrador4= "Designada mediante Resolución No. 018/2020 de fecha 08 de junio de 2020";
 $registrador5= "Publicada en Gaceta Oficial de la República Bolivariana de Venezuela"; 
 $registrador6= "Nº.41.897 de Fecha 09 de junio de 2020"; 

 $fechahoy = hoy();
 $horactual=hora();
 $dia = substr($fechahoy, 0, 2);
 $mes = substr($fechahoy, 3, 2);
 $ano = substr($fechahoy, 6, 4);
 $fechagen = $dia.$mes.$ano;
 $horagen = substr($horactual,0,8).substr($horactual,9,2);
 $vnomsolpat= "boletin_sol_pat_nac"."_".$fechagen."_".$horagen.".pdf";

 //echo " valor= $boletin, $fecp_sefp,$psefp, $fecp_sevt,$psevt "; 
 //exit();
//****************************************************************************************
//Solicitadas de patentes
//****************************************************************************************
if($solip==1) {

//Inicio del Pdf
$pdf=new PDF_Tablebol('P','mm','Letter');
$pdf->Open();
$pdf->AliasNbPages();

// Armando el query segun las opciones
$counter= 1;
$tipo_derecho='A';
$titulo='PATENTE DE INVENCION';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2006' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpsolnac
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2006'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad='VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpsolnac
    WHERE estatus='2006'
    AND boletin = '$boletin'");
//    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

// Armando el query solicitadas segun las opciones
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.poder, b.fecha_solic, a.resumen 
	FROM  stzderec b, stztmpbo1 c, stppatee a
	WHERE c.estatus='2006'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
        AND c.tipo_nacionalidad = 'V'
	AND b.tipo_derecho = '$tipo_derecho'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

//$pol1=pg_numrows($resultado); 

//Solicitadas 
//$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, a.resumen, b.poder
//	FROM  stzderec b, stztmpbo c, stppatee a
//	WHERE c.estatus='2006'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND c.nro_derecho = a.nro_derecho 
//	AND b.tipo_derecho = '$tipo_derecho'
//	ORDER BY b.solicitud");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) { $mensaje= $mensaje.'  - No se genero Solicitadas '.$titulo; } 
else { 

// Montando los resultados en el formato boletin solicitadas
      $pdf->AddPage();
      $nro_resoluc = $nro_resoluc+1;
      $pdf->Setfont('Arial','B',20);
      $pdf->MultiCell(190,5,utf8_decode('SOLICITADAS DE PATENTES'),0,'C',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_soli)),0,'C',0);
      $pdf->Setfont('Arial','',8);          
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_soli)),0,'J',0);     $pdf->Setfont('Arial','B',8);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
//      $pdf->MultiCell(190,5,'SOLICITADAS DE '.utf8_decode($titulo),0,'C',0);
      $pdf->MultiCell(190,5,'SOLICITUDES NACIONALES DE '.utf8_decode($titulo).' PUBLICADAS A EFECTO DE OPOSICIONES',0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DE CONFORMIDAD CON EL ARTÍCULO 60 DE LA LEY DE PROPIEDAD INDUSTRIAL, Y POR CUANTO LOS INTERESADOS HAN CUMPLIDO DE ACUERDO A LA LEY CON LAS ORDENES DE PUBLICACIÓN EN PRENSA QUE SE HICIERA EN EL BOLETÍN DE LA PROPIEDAD INDUSTRIAL CORRESPONDIENTE, SE PROCEDE A PUBLICAR LAS SIGUIENTES SOLICITUDES DE REGISTRO DE '.$titulo.' CON EL FIN DE QUIEN TENGA LEGÍTIMO INTERES PUEDA PRESENTAR SUS OPOSICIONES DE ACUERDO A LO ESTABLECIDO EN EL ARTÍCULO 63 DE LA LEY DE PROPIEDAD INDUSTRIAL.'),0,'J',0);      
     
   for($cont=0;$cont<$filas_resultado;$cont++) { 

     $nsolic=$registro['solicitud'];
     $nagen=$registro['agente'];
     $nderec=$registro['nro_derecho'];
     $varsol1=substr($nsolic,-11,4);
     $varsol2=substr($nsolic,-6,6);
     $pdf->Setfont('Arial','B',12);
     $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

     $pdf->Setfont('Arial','',8);
     $pdf->MultiCell(135,5,'(11)'.'     '.$boletin.'-'.$varsol1.$varsol2,0,'J',0);
     $pdf->MultiCell(135,5,'(21)'.'     '.$registro['solicitud'],0,'J',0);
     //imagen
     $varsol1=substr($nsolic,-11,4);
     $varsol2=substr($nsolic,-6,6);
     //$nameimage=ver_imagen($varsol1,$varsol2,'P');
     $nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
     if (file($nameimage)) {   
	  $pdf->ln(1);
	  $x = $pdf->Getx();
	  $y = $pdf->Gety();
	  $pto = $y;
     $pdf->Image("$nameimage",160,$y,30,25,'JPG');
	  // $pdf->MultiCell(59,38,$pdf->Image("$nameimage",(150+3),$y,40,35,'JPG'),0,'J',0);
     }

     $pdf->MultiCell(135,5,'(22)'.'     '.$registro['fecha_solic'],0,'J',0);      
     //Prioridad
	  $cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
	  $reg_pri = pg_fetch_array($cons_pri);
	  $filas_cons_pri=pg_numrows($cons_pri);
	  $prioridad="";
	  for($cont_pri=0;$cont_pri<$filas_cons_pri;$cont_pri++) { 
	     $prioridad=$prioridad.trim($reg_pri['prioridad']).' '.trim($reg_pri['pais_priori']).', ';
	     $prioridad=$prioridad.trim($reg_pri['fecha_priori']).';  ';
     	     $reg_pri = pg_fetch_array($cons_pri);
          }
     $pdf->Cell(9,5,'(30)'.'     ',0,0);  
     $pdf->MultiCell(135,5,$prioridad,0,'J',0);

     $clasi="";
     if (($tipo_derecho=='B') || ($tipo_derecho=='E') || ($tipo_derecho=='G')) {
       //Clasificación Locarno B,E,G,
       $cons_clas=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
       $reglocar = pg_fetch_array($cons_clas);
       $filas_locar=pg_numrows($cons_clas); 
       $clasi=$clasi.trim($reglocar['clasi_locarno']);
     }
     else {
       //Clasificación internacional.
       $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
       $regclasf = pg_fetch_array($cons_clas);
       $filas_clasif=pg_numrows($cons_clas); 
       for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
          $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
          $regclasf = pg_fetch_array($cons_clas);
       }
     }
     //$pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);
     $pdf->Cell(9,5,'(51)'.'     ',0,0);  
     $pdf->MultiCell(135,5,$clasi,0,'J',0);
          
     //Titular
	  $titular='';
  	  $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	  $filas_found1=pg_numrows($res_titular);
	  $regt = pg_fetch_array($res_titular);
	  for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
       //$pais_nombre=pais($res['nacionalidad']);
       $pais_nombre=pais($regt['nacionalidad']);
 	    if ($cont1=='0'){
 	      $pdf->Cell(9,5,'(73)'.'     ',0,0);
	 	   //$pdf->MultiCell(135,5,'(73)'.'     '.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).' Nacionalidad: '.$pais_nombre.'',0,'J',0); }
 		   $pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode($pais_nombre).'',0,'J',0); }	   
		 else {$pdf->Getx(25); 
		   //$pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).' Nacionalidad: '.utf8_decode($pais_nombre).'',0,'J',0); }                   
		   $pdf->Cell(9,5,'    '.'     ',0,0);
		   $pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode($pais_nombre).'',0,'J',0); }                   
	    $regt = pg_fetch_array($res_titular);
	  }
	  //$pdf->MultiCell(135,5,utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode($pais_nombre).'',0,'J',0); }                   
   
     //Inventores
      $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
      $reg_inv = pg_fetch_array($cons_inv);
      $filas_cons_inv=pg_numrows($cons_inv);
      $inventores="";
      for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
         //$inventores=$inventores.utf8_decode(trim($reg_inv['nombre_inv']))."; ";
         if (empty($inventores)) { $inventores=$inventores.utf8_decode(trim($reg_inv['nombre_inv'])); }
         else { $inventores=$inventores."; ".utf8_decode(trim($reg_inv['nombre_inv'])); } 
         $reg_inv = pg_fetch_array($cons_inv);
      }
      $pdf->Cell(9,5,'(72)'.'     ',0,0);  
      $pdf->MultiCell(135,5,$inventores,0,'J',0);  
      //Tramitante o Agente         
      $ind=1;
      $tram = agente_tram($registro['agente'],trim($registro['tramitante']),$ind);     
      $pdf->MultiCell(135,5,'(74)'.'     '.utf8_decode($tram),0,'J',0);        
      //Titulo de la patente
      $pdf->Cell(9,5,'(54)'.'     ',0,0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(135,5,utf8_decode(trim($registro['nombre'])),0,'J',0);    
      $pdf->Setfont('Arial','',8);

      //Resumen 
      $pdf->Cell(9,5,'(57)'.'     ',0,0);  
      $resumen = mb_strtoupper(utf8_decode(trim($registro['resumen'])));
      $pdf->MultiCell(135,5,$resumen,0,'J',0); 

    $registro = pg_fetch_array($resultado);

  }
  
  // Fin de Pagina (Firma del Registrador)
    $pdf->ln(6); 
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total,0,'J',0);
    $pdf->Setfont('Arial','B',8);
  
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

    $pdf->Setfont('Arial','B',8);
    $pdf->ln(6); 
    $pdf->MultiCell(190,5,'Publiquese,',0,'L',0);
    $pdf->ln(20); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         
       

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='PATENTE DE MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='PATENTE DE MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='PATENTE DE DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='PATENTE DE DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='PATENTE DE INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='PATENTE DE MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='PATENTE DE VARIEDADES VEGETALES';}
}//fin del while

//Salida del Reporte
//$pdf->Output("../../boletin/boletin_sol_pat.pdf");        
$pdf->Output("../../boletin/".$vnomsolpat);
$pdf->Output("../respaldoboletin/".$vnomsolpat);
          
} // fin de solicitadas


//****************************************************************************************
//Inicio del Pdf
$pdf=new PDF_Tablebol('P','mm','Letter');
$pdf->Open();
//$pdf->AddPage();
$pdf->AliasNbPages();

//****************************************************************************************
//orden de publicación
//****************************************************************************************
if($ordep==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCION';
$subpate='INVENCION';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2002' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmppub
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2002'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad, tipo_nacionalidad
    FROM  stztmppub
    WHERE estatus='2002'
    AND boletin = '$boletin'");

while ( $counter <= 8) {

// Armando el query solicitadas segun las opciones
$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.tipo_derecho, b.agente, b.tramitante, b.poder 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2002'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");
	
//Armando el query
//  $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente, b.tipo_derecho, b.poder
//		FROM  stzderec b, stztmpbo c
//		WHERE c.boletin = '$boletin'
//		AND c.nro_derecho = b.nro_derecho 
//		AND c.estatus = '2002'
//		AND c.tipo = 'P'
//		AND b.tipo_derecho = '$tipo_derecho'
//		ORDER BY b.solicitud");
		
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$cantreg=$filas_resultado;
$total=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'  - No se genero Orden de Publicación  '.$titulo;} 
else {  
// Montando los resultados en el formato boletin orden de publicacion
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_orde)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
       $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,utf8_decode('ORDEN DE PUBLICACIÓN EN PRENSA DE SOLICITUDES NACIONALES DE PATENTE '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_orden)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('De conformidad con el artículo 60 de la Ley de la Propiedad Industrial, se ordena la publicación de las solicitudes de patentes de '.$subpate.', que a continuación se especifican, en los diarios de circulación nacional: VEA o CIUDAD CARACAS. De no realizarse la mencionada publicación en prensa dentro de dos (02) meses a partir de la vigencia del presente Boletín, quedará perimida la solicitud, según lo establecido en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
      //$pdf->MultiCell(190,5,utf8_decode('DE CONFORMIDAD CON EL ARTÍCULO 60 DE LA LEY DE PROPIEDAD INDUSTRIAL, SE ORDENA LA PUBLICACIÓN DE LAS SOLICITUDES DE PATENTES DE '.$subpate.' QUE A CONTINUACIÓN SE ESPECIFICAN, EN LOS DIARIOS DE CIRCULACION NACIONAL: VEA Ó CIUDAD CARACAS. DE NO REALIZARSE LA MENCIONADA PUBLICACIÓN EN PRENSA DENTRO DE LOS DOS (02) MESES A PARTIR DE LA VIGENCIA DEL PRESENTE BOLETÍN, QUEDARÁ PERIMIDA LA SOLICITUD, SEGÚN LO ESTABLECIDO EN EL ARTÍCULO 64 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS.'),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('ESTE DESPACHO DE CONFORMIDAD CON LO ESTABLECIDO EL ARTÍCULO 60 DE LA LEY DE PROPIEDAD INDUSTRIAL, ORDENA LA PUBLICACIÓN EN PRENSA DE LAS SOLICITUDES DE PATENTES DE '.$subpate.' QUE A CONTINUACIÓN SE ESPECIFICAN, A TALES EFECTOS SE LES INFORMA QUE PODRÁN REALIZAR DICHA PUBLICACIÓN EN LOS PERIODICOS: VEA, CIUDAD CARACAS Y A TRAVÉS DEL PERIODICO DIGITAL DE ESTE SERVICIO AUTONOMO (SAPI). ESTA PUBLICACIÓN EL INTERESADO DEBERÁ REALIZARLA DE FORMA CORRECTA Y DE ACUERDO A LO SOLICITADO DENTRO DE DOS (2) MESES A PARTIR DE LA VIGENCIA DEL PRESENTE BOLETÍN; DE NO CUMPLIR CON LO DISPUESTO SE DECLARARAN PERIMIDAS LAS SOLICITUDES, DE ACUERDO A LO ESTABLECIDO EN EL ARTÍCULO 64 DE LA LEY ORGANICA DE PROCEDIMIENTOS ADMINISTRATIVOS.'),0,'J',0);
      $pdf->ln(4); 

//initialize the table with 4 columns
$pdf->Table_Init(4);
$columns=4;

//set table style
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA SOLICITUD ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;

$pdf->Set_Header_Type($header_type);

//set data style

$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);


//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 

      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
  
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
 	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']); }
	   else { $titular= $titular.", ".trim($regt['nombre']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	
	$data[2]['TEXT'] = utf8_decode($titular);
	
   $ind_agente=1;
   //$tram = agente_tram($registro['agente'],$registro['tramitante'],$ind_agente);	
   $poder = trim($registro['poder']);
   $tram = agente_tramp1($nagen,trim($registro['tramitante']),$poder);
	$data[3]['TEXT'] = trim(utf8_decode($tram));
	
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }

    // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$cantreg,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(25); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}// fin de orden de publicacion

//****************************************************************************************
//  Devueltas  x forma 
//****************************************************************************************
if($devup==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2200' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpdev
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2200'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpdev
    WHERE estatus='2200'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

//Armando el query
$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.tipo_derecho, b.agente, b.tramitante, b.poder 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2200'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud,b.nombre,b.nro_derecho,b.agente,b.tramitante, b.tipo_derecho, b.poder
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2200'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho = '$tipo_derecho'
//	ORDER BY b.solicitud");	
		
$registro_devu = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$cantreg=$filas_resultado;
$totald=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'  - No se genero Devueltas '.$titulo;} 
else {  
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_devu)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES NACIONALES DE PATENTES '.$titulo.' DEVUELTAS POR EXAMEN DE FORMA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_devu)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('VISTAS LAS SOLICITUDES DE PATENTES DE '.$subpate.', QUE A CONTINUACIÓN SE ESPECIFICAN, Y POR CUANTO LOS INTERESADOS NO CUMPLIERON CON LOS REQUISITOS FORMALES DE PRESENTACIÓN, SE DEVUELVEN DICHAS SOLICITUDES A FIN DE QUE SE DE CUMPLIMIENTO A LO EXIGIDO EN LOS CORRESPONDIENTES OFICIOS DE DEVOLUCIÓN DENTRO DE UN LAPSO DE TREINTA (30) DÍAS HÁBILES CONTADOS A PARTIR DE LA FECHA DE PUBLICACIÓN DEL PRESENTE BOLETÍN, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 61 DE LA LEY DE PROPIEDAD INDUSTRIAL. DE NO DARSE CABAL CUMPLIMIENTO A LO SOLICITADO EN EL OFICIO DE DEVOLUCIÓN, SE PROCEDERÁ A DECLARAR EXTINGUIDA LA PRIORIDAD DE LA SOLICITUD.'),0,'J',0);
      $pdf->ln(4); 
      
//initialize the table with 5 columns
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");      
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
   $nsolic=$registro_devu['solicitud'];
   $nagen=$registro_devu['agente'];
   $nderec=$registro_devu['nro_derecho'];
   if (empty($nagen)) {$nagen=0;}	
   $titular ='';	
   $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_devu['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_devu['nombre']));
		
	//busqueda del titular y sus datos
	$titular='';
	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   
		FROM stzottid, stzsolic, stzderec 
		WHERE stzottid.nro_derecho='$nderec'
		AND stzderec.nro_derecho=stzottid.nro_derecho
                AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_devu['tramitante'],'1');
   $poder = trim($registro_devu['poder']);
   $tram = agente_tramp($nagen,trim($registro_devu['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_devu = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$totald,0,'J',0);
       $pdf->ln(8); 
       $pdf->Setfont('Arial','',8);
       //$pdf->MultiCell(190,5,utf8_decode('SE ADVIERTE .'),0,'J',0);
       //$pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='MEJORAS';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL';  $subpate='MODELO INDUSTRIAL'; }
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD';  $subpate='MODELOS DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de Devueltas X Forma

//****************************************************************************************
//  Devueltas  x Fondo 
//****************************************************************************************
if($devfonp==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2103' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpdev
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2103'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpdev
    WHERE estatus='2103'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

//Armando el query
$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.tipo_derecho, b.agente, b.tramitante, b.poder 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2103'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud,b.nombre,b.nro_derecho,b.agente,b.tramitante, b.tipo_derecho, b.poder
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2200'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho = '$tipo_derecho'
//	ORDER BY b.solicitud");	
		
$registro_devu = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$cantreg=$filas_resultado;
$totald=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'  - No se genero Devueltas '.$titulo;} 
else {  
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_devu)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES NACIONALES DE PATENTES '.$titulo.' DEVUELTAS POR EXAMEN DE FONDO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_devu)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('VISTAS LAS SOLICITUDES DE PATENTE DE '.$subpate.', QUE A CONTINUACIÓN SE ESPECIFICAN, Y POR CUANTO LOS INTERESADOS NO CUMPLIERON CON LOS REQUISITOS TÉCNICO-JURÍDICOS DE FONDO, SE DEVUELVEN DICHAS SOLICITUDES A FIN DE QUE SE DE CUMPLIMIENTO A LO EXIGIDO EN LOS CORRESPONDIENTES OFICIOS DE DEVOLUCIÓN DENTRO DE UN LAPSO DE TREINTA (30) DÍAS HÁBILES CONTADOS A PARTIR DE LA FECHA DE PUBLICACIÓN DEL PRESENTE BOLETÍN, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 61 DE LA LEY DE PROPIEDAD INDUSTRIAL. DE NO DARSE CABAL CUMPLIMIENTO A LO SOLICITADO EN EL OFICIO DE DEVOLUCIÓN, SE PROCEDERÁ A DECLARAR EXTINGUIDA LA PRIORIDAD DE LA SOLICITUD.'),0,'J',0);
      $pdf->ln(4); 

//initialize the table with 5 columns
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");      
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
   $nsolic=$registro_devu['solicitud'];
   $nagen=$registro_devu['agente'];
   $nderec=$registro_devu['nro_derecho'];
   if (empty($nagen)) {$nagen=0;}	
   $titular ='';	
   $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_devu['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_devu['nombre']));
		
	//busqueda del titular y sus datos
	$titular='';
	$res_titular=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   
		FROM stzottid, stzsolic, stzderec 
		WHERE stzottid.nro_derecho='$nderec'
		AND stzderec.nro_derecho=stzottid.nro_derecho
                AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_devu['tramitante'],'1');
   $poder = trim($registro_devu['poder']);
   $tram = agente_tramp($nagen,trim($registro_devu['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_devu = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$totald,0,'J',0);
       $pdf->ln(8); 
       $pdf->Setfont('Arial','',8);
       //$pdf->MultiCell(190,5,utf8_decode('SE.'),0,'J',0);
       //$pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='MEJORAS';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL';  $subpate='MODELO INDUSTRIAL'; }
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD';  $subpate='MODELOS DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de Devueltas x Fondo

//****************************************************************************************
// CONCEDIDAS
//****************************************************************************************
if($concp==1) {
// Armando el query segun las opciones
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2101' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpcon
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2101'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpcon
    WHERE estatus='2101'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {
	
//concedidas 
$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.poder, b.fecha_solic, b.fecha_publi 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2101'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho = '$tipo_derecho'
//	ORDER BY b.solicitud");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'  - No se genero Concedidas '.$titulo;} 
else { 

// Montando los resultados en el formato boletin solicitadas
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','',12);          
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_conc)),0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'PATENTES NACIONALES '.utf8_decode($titulo).' CONCEDIDAS',0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //if($counter==4) {
      if($counter==3) {
        $pdf->MultiCell(190,5,utf8_decode('CUMPLIDOS COMO HAN SIDO LOS EXTREMOS LEGALES EXIGIDOS EN EL ARTICULO 65 DE LA LEY DE PROPIEDAD INDUSTRIAL, ESTE DESPACHO ACUERDA POR EL TERMINO CORRESPONDIENTE, EL REGISTRO DE LAS SOLICITUDES DE PATENTE DE MODELO INDUSTRIAL QUE A CONTINUACION SE MENCIONAN; ENTENDIENDOSE QUE LA PROTECCION QUE CONFIERE DICHO REGISTRO HA DE RECAER EXCLUSIVAMENTE SOBRE EL MODELO REPRESENTADO EN LAS FIGURAS CONSIGNADAS.'),0,'J',0);      
      } else {
        if($counter==5) {
          $pdf->MultiCell(190,5,utf8_decode('CUMPLIDOS COMO HAN SIDO LOS EXTREMOS LEGALES EXIGIDOS EN EL ARTICULO 65 DE LA LEY DE PROPIEDAD INDUSTRIAL, ESTE DESPACHO ACUERDA POR EL TERMINO CORRESPONDIENTE, EL REGISTRO DE LAS SOLICITUDES DE PATENTE DE DIBUJO INDUSTRIAL QUE A CONTINUACION SE MENCIONAN; ENTENDIENDOSE QUE LA PROTECCION QUE CONFIERE DICHO REGISTRO HA DE RECAER EXCLUSIVAMENTE SOBRE EL DIBUJO REPRESENTADO EN LAS FIGURAS CONSIGNADAS.'),0,'J',0);      
        } else {
          $pdf->MultiCell(190,5,utf8_decode('CUMPLIDOS COMO HAN SIDO LOS EXTREMOS LEGALES EXIGIDOS EN EL ARTICULO 65 DE LA LEY DE PROPIEDAD INDUSTRIAL, ESTE DESPACHO ACUERDA POR EL TERMINO CORRESPONDIENTE, EL REGISTRO DE LAS SOLICITUDES DE PATENTE '.utf8_decode($titulo).' QUE A CONTINUACION SE MENCIONAN.'),0,'J',0);
        }  
      }
      $pdf->ln(4); 
     
   for($cont=0;$cont<$filas_resultado;$cont++) { 

      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      $varsol1=substr($nsolic,-11,4);
      $varsol2=substr($nsolic,-6,6);
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

      $pdf->Setfont('Arial','',8);
      $pdf->MultiCell(135,5,'(21)'.'     '.$registro['solicitud'],0,'J',0);

      //imagen
      $nameimage = "../graficos/patentes/di".$varsol1."/".$varsol1.$varsol2.".jpg";
      if (file($nameimage)) {   
	   $pdf->ln(1);
	   $x = $pdf->Getx();
	   $y = $pdf->Gety();
	   $pto = $y;
        $pdf->Image("$nameimage",160,$y,30,25,'JPG');
      }
      // fin imagen

      $pdf->MultiCell(135,5,'(22)'.'     '.$registro['fecha_solic'],0,'J',0); 
      $pdf->MultiCell(135,5,'(11)'.'     '.$boletin.'-'.$varsol1.$varsol2,0,'J',0);
      $pdf->MultiCell(135,5,'(45)'.'     '.$registro['fecha_publi'],0,'J',0); 

      //Titular
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzsolic.domicilio, stzsolic.nacionalidad
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
 	      $pdf->MultiCell(135,5,'(73)'.'     '.utf8_decode(trim($regt['nombre'])).',',0,'J',0); }
	   else {$pdf->Getx(25); $pdf->MultiCell(135,5,'    '.'     '.utf8_decode(trim($regt['nombre'])).';',0,'J',0); }                
	   $regt = pg_fetch_array($res_titular);
	}       
   
      //Tramitante o Agente         
      $ind=1;
      //$tram = agente_tram($registro['agente'],$registro['tramitante'],$ind);
      $poder = trim($registro['poder']);
      $tram = agente_tramp($nagen,trim($registro['tramitante']),$poder);
      $pdf->MultiCell(135,5,'(74)'.'     '.utf8_decode($tram),0,'J',0);         

      $clasi="";
      if (($tipo_derecho=='B') || ($tipo_derecho=='E') || ($tipo_derecho=='G')) {
        //Clasificación Locarno B,E,G,
        $cons_clas=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
        $reglocar = pg_fetch_array($cons_clas);
        $filas_locar=pg_numrows($cons_clas); 
        $clasi=$clasi.trim($reglocar['clasi_locarno']);
      }
      else {
        //Clasificación internacional.
        $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
        $regclasf = pg_fetch_array($cons_clas);
        $filas_clasif=pg_numrows($cons_clas); 
        for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
          $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
          $regclasf = pg_fetch_array($cons_clas);
        }
      }
      //$pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);
      //$pdf->Cell(9,5,'(51)'.'     ',0,0);  
      //$pdf->MultiCell(135,5,$clasi,0,'J',0);

      //Clasificación internacional.
      //$clasi="";
      //$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
      //$regclasf = pg_fetch_array($cons_clas);
      //$filas_clasif=pg_numrows($cons_clas); 
      //for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
      //    $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
      //    $regclasf = pg_fetch_array($cons_clas);
      //}
      $pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);     

      //Clasificación internacional.
      //$clasi="";
      //$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
      //$regclasf = pg_fetch_array($cons_clas);
      //$filas_clasif=pg_numrows($cons_clas); 
      //for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
      //    $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
      //    $regclasf = pg_fetch_array($cons_clas);
      //}
      //$pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);     
  
      //Titulo de la patente
      $pdf->Cell(9,5,'(54)'.'     ',0,0);  
      $pdf->MultiCell(135,5,utf8_decode(trim($registro['nombre'])),0,'L',0);    

    $registro = pg_fetch_array($resultado);

  }
  
  // Fin de Pagina (Firma del Registrador)
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

    $pdf->ln(8); 
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total,0,'J',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(8); 
    $pdf->MultiCell(190,5,utf8_decode('En virtud de la Decisión tomada por este Despacho ut supra, el tramitante o interesado deberá consignar por escrito el pago de los derechos de registro correspondientes a la presente concesión en un lapso de treinta días (30) hábiles contados a partir de la presente publicación, de acuerdo a lo establecido en el contenido del Artículo 65 de la Ley de Propiedad Industrial. El incumplimiento del pago de los derechos registrales será causal para que quede sin efecto la resolución del Registrador sobre el registro y nulas las actuaciones respectivas según lo dispone el contenido del Artículo 65 de la Ley de Propiedad Industrial.'),0,'J',0);
    $pdf->ln(5); 
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'Publiquese,',0,'L',0);
    $pdf->ln(20); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         
       

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES';}
}//fin del while

}//fin de concedidas

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA X EXAMEN DE FORMA
//****************************************************************************************
if($priop==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 25 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2025' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpext
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2025'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpext
    WHERE estatus='2025'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.poder, b.tipo_derecho 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2025'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2025'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho= '$tipo_derecho' 
//	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Prioridades Extinguidas '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_prio)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTE NACIONALES '.$titulo.' DECLARADAS CON PRIORIDAD EXTINGUIDA POR EXAMEN DE FORMA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_prio)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('VISTAS LAS SOLICITUDES DE PATENTE DE '.$subpate.', QUE A CONTINUACIÓN SE ESPECIFICAN, Y POR CUANTO LOS INTERESADOS NO CUMPLIERON CON LOS REQUISITOS DE PRESENTACIÓN EXIGIDOS EN LOS RESPECTIVOS OFICIOS DE DEVOLUCIÓN, SE DECLARA EXTINGUIDA LA PRIORIDAD DE LAS MENCIONADAS SOLICITUDES, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 61 DE LA LEY DE PROPIEDAD INDUSTRIAL.'),0,'J',0);
      $pdf->ln(4); 
     
// dibujando la tabla 5 columns
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.domicilio, stzottid.nacionalidad
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,utf8_decode('SE NOTIFICA A LOS INTERESADOS QUE PODRÁN EJERCER CONTRA EL PRESENTE ACTO ADMINISTRATIVO EL RECURSO DE RECONSIDERACIÓN POR ANTE ESTE DESPACHO DENTRO DE LOS QUINCE (15) DÍAS HÁBILES  CONTADOS A PARTIR DE LA FECHA DE PUBLICACIÓN DEL PRESENTE BOLETÍN, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         
 } //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de PRIORIDAD EXTINGUIDA X EXAMEN DE FORMA

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA EXTEMPORANEA
//****************************************************************************************
if($prio_extep==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 23 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2023' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpextex
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2023'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpextex
    WHERE estatus='2023'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

//Armando el query
$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.tipo_derecho, b.agente, b.tramitante, b.poder 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2023'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2023'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho= '$tipo_derecho' 
//	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Prioridades Extinguidas Extemporaneas de Patentes '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_prio_exte)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDADES EXTINGUIDAS NACIONALES PUBLICADAS EN PRENSA EXTEMPORANEA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_prio_exte)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Vistas las solicitudes de patentes '.$subpate.', que a continuación se especifican; y por cuanto los interesados no cumplieron con los requisitos de presentación contenidos en el Articulo 71 de la Ley de Propiedad Industrial; y en concordancia con el Articulo 75 de la Ley de Propiedad Industrial, este despacho declara la Prioridad Extinguida.')),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
   $nsolic=$registro_prio['solicitud'];
   $nagen=$registro_prio['agente'];
   $nderec=$registro_prio['nro_derecho'];
   if (empty($nagen)) {$nagen=0;}	
   $titular ='';	
   $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
  	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	

   //busqueda del Tramitante (poder, agente o tramitante)
   $poder = trim($registro_prio['poder']);
	$tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  } //fin del for
  // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         
 } //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de PRIORIDAD EXTINGUIDA EXTEMPORANEA

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA DEFECTUOSA
//****************************************************************************************
if($prio_defep==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2024'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Prioridades Extinguidas Defectuosas de Patentes '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_prio_defe)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDADES EXTINGUIDAS PUBLICADAS EN PRENSA DEFECTUOSA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_prio_defe)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Vistas las solicitudes de patentes de '.$subpate.', que a continuación se especifican; y por cuanto los interesados no cumplieron con los requisitos de presentación contenidos en el Articulo 71 de la Ley de Propiedad Industrial; y en concordancia con el Articulo 75 de la Ley de Propiedad Industrial, este despacho declara la Prioridad Extinguida Defectuosa.')),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
    	$regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
   $poder = trim($registro_prio['poder']);
	$tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 } //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de PRIORIDAD EXTINGUIDA DEFECTUOSA

//****************************************************************************************
//  PERIMIDAS POR NO PUBLICACION EN PRENSA   perencion
//****************************************************************************************
if($perip==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 30 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2030' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp tmpperpub
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2030'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  tmpperpub
    WHERE estatus='2030'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.poder, b.tipo_derecho 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2030'
   AND c.boletin = '$boletin'
   AND c.tipo = 'P'
   AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2030'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho= '$tipo_derecho' 
//	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Perimidas por no Publicación en Prensa '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_peri)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PERIMIDAS POR NO PUBLICAR EN PRENSA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_peri)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('De conformidad con el artículo 64 de la Ley Orgánica de Procedimientos Administrativos y por cuanto los interesados no cumplieron de acuerdo a la Ley con las Ordenes de Publicación en Prensa que se hiciera en el Boletín de la Propiedad Industrial correspondiente, se procede a declarar la perención de las siguientes solicitudes de registro de patentes.'),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DE CONFORMIDAD CON EL ARTÍCULO 64 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS Y POR CUANTO LOS INTERESADOS NO CUMPLIERON DE ACUERDO A LA LEY CON LAS ORDENES DE PUBLICACIÓN EN PRENSA QUE SE HICEIRA EN EL BOLETÍN DE LA PROPEIDAD INDUSTRIAL CORRESPONDIENTE, SE PROCEDE A DECLARAR LA PERENCIÓN DE LAS SIGUIENTES SOLICITUDES DE REGISTRO DE PATENTES.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,utf8_decode('SE INFORMA A LOS TRAMITANTES E INTERESADOS EN LAS SOLICITUDES DE REGISTROS MENCIONADOS ANTERIORMENTE, QUE PODRÁN EJERCER EL RECURSO ADMINISTRATIVO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS; DENTRO DE UN LAPSO DE QUINCE (15) DÍAS SIGUIENTES, A PARTIR DE LA PRESENTE PUBLICACIÓN.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else
 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  PERIMIDAS POR NO PUBLICACION EN PRENSA


//****************************************************************************************
//  DENEGADAS
//****************************************************************************************
if($denep==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2119' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpdene
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2119'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpdene
    WHERE estatus='2119'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.poder, b.tipo_derecho 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2119'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2119'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho= '$tipo_derecho' 
//	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Denegadas '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_dene)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTES NACIONALES DENEGADAS '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_dene)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('XXXXXXXXX.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de  DENEGADAS


//****************************************************************************************
//  NEGADAS
//****************************************************************************************
if($negad==1) {
$counter=0;
$tipo_derecho="'A','F'";
$titulo='';
$subpate='INVENCIÓN';
$titp_nega ='NEGADAS DE OFICIO';
//if($counter==4) { $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2102' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpnega
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2102'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpnega
    WHERE estatus='2102'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 2) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.poder, b.tipo_derecho 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2102'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho in ($tipo_derecho)
	ORDER BY b.solicitud");
	
//$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2102'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND b.tipo_derecho in ($tipo_derecho) 
//	AND c.nro_derecho = b.nro_derecho 
//	ORDER BY b.solicitud");

//	AND b.tipo_derecho IN ('A','E','G')
//	AND b.tipo_derecho IN ('A','C','F','G')
//	AND b.tipo_derecho='$tipo_derecho'
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Negadas '.$titulo;} 
else { 
    $nro_resoluc = $nro_resoluc+1;
    $pdf->AddPage();
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
    $pdf->Setfont('Arial','',8);
    $pdf->ln(2); 
    $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_nega)),0,'J',0);           
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
    $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
    $pdf->Setfont('Arial','B',12);
    $pdf->ln(4); 
    //$pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTE DE INVENCION '),0,'C',0);
    $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES NACIONALES DE PATENTE DE '.$subpate),0,'C',0);
    $pdf->MultiCell(190,5,utf8_decode(trim($titp_nega)),0,'C',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(4); 
    if ($subpate=='INVENCIÓN') {
    $pdf->MultiCell(190,5,utf8_decode('Se les notifica a los interesados y público en general, que vistas las solicitudes de registro de patentes de invención que se detallan a continuación y por cuanto el informe técnico emanado de la Coordinación de Invenciones y Nuevas Tecnologías emitido luego de la revisión exhaustiva de las reivindicaciones anexadas a la solicitud, así como la descripción, se determinó que las mismas incumplen los requisitos legales exigidos en el artículo 14 y/o se encuentran incursas en las prohibiciones establecidas en el artículo 15 de la Ley de Propiedad Industrial, de conformidad con lo establecido en el artículo 62 de la misma Ley; y/o por contravenir el artículo 8 ejusdem, razón por la cual este despacho las NIEGA de oficio. El informe técnico de cada solicitud, se encuentra disponible para su consulta en el expediente respectivo.'),0,'J',0); }
    if ($subpate=='MODELO INDUSTRIAL') {
    $pdf->MultiCell(190,5,utf8_decode('Se les notifica a los interesados y público en general, que vistas las solicitudes de registro de patentes de modelo industrial que se detallan a continuación y por cuanto el informe técnico emanado de la Coordinación de Invenciones y Nuevas Tecnologías emitido luego de la revisión exhaustiva de la descripción, la reivindicación y/o las figuras, se determinó que las mismas contravienen y/o están incursas en las prohibiciones establecidas en los artículos 8, 22, 23 y 24 de la Ley de Propiedad Industrial, razón por la cual este despacho las NIEGA de oficio. El informe técnico de cada solicitud, se encuentra disponible para su consulta en el expediente respectivo.'),0,'J',0); }
    if ($subpate=='DIBUJO INDUSTRIAL') {
    $pdf->MultiCell(190,5,utf8_decode('Se les notifica a los interesados y público en general, que vistas las solicitudes de registro de patentes de dibujo industrial que se detallan a continuación y por cuanto el informe técnico emanado de la Coordinación de Invenciones y Nuevas Tecnologías emitido luego de la revisión exhaustiva de la descripción, la reivindicación y/o las figuras, se determinó que las mismas contravienen y/o están incursas en las prohibiciones establecidas en los artículos 8, 22, 23 y 24 de la Ley de Propiedad Industrial, razón por la cual este despacho las NIEGA de oficio. El informe técnico de cada solicitud, se encuentra disponible para su consulta en el expediente respectivo.'),0,'J',0); }
    $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(3);
$columns=3;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 91;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 82;
		//$i=3;
		//$header_type[$i] = $table_default_header_type;
		//$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		//$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); 
$pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
   $nsolic=$registro_prio['solicitud'];
   $nagen=$registro_prio['agente'];
   $nderec=$registro_prio['nro_derecho'];
   if (empty($nagen)) {$nagen=0;}	
   $titular ='';	
   $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
   //$data[0]['T_TYPE'] = 'B'; 
		$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
	$pdf->Draw_Data($data);
		
   //busqueda del Tramitante (poder, agente o tramitante)
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   //$data[3]['TEXT'] = trim(utf8_decode($tram));
 	$pdf->MultiCell(180,5,'Tramitante: '. trim(utf8_decode($tram)),0,'J',0);

	//comentario
   $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento='2052' ORDER BY fecha_trans DESC");   
	$reg_neg = pg_fetch_array($reg_com);
   $pdf->MultiCell(180,5,'COMENTARIO: '.trim(utf8_decode($reg_neg['comentario'])),0,1);	
   $pdf->Ln(2);

	$registro_prio = pg_fetch_array($resultado);
  }//fin del for
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
  $pdf->Setfont('Arial','',8);
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a la parte interesada que con fundamento en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, contra esta decisión podrá ejercer el Recurso de Reconsideración por ante este despacho, dentro de los quince (15) días hábiles siguientes, contados a partir de la publicación de este Acto Administrativo en el Boletín de la Propiedad Industrial.')),0,'J',0);       
  $pdf->ln(5); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

}//fin del else
$counter = $counter + 1; 
//if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='MEJORAS';}
if($counter==1) { $tipo_derecho="'E','G'"; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==2) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
//if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
//if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='MODELOS DE UTILIDAD';}
//if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de NEGADAS

//****************************************************************************************
//  DESISTIDAS
//****************************************************************************************
if($desip==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 910 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2910' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpdes
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2910'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpdes
    WHERE estatus='2910'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'V'");

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.poder, b.tipo_derecho 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2910'
   AND c.boletin = '$boletin'
   AND c.tipo = 'P'
   AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2910'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho= '$tipo_derecho' 
//	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Desistidas '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_desi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTE '.$titulo.' DESISTIDAS '),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en los Artículos 78 y 79 de la Ley de la Propiedad Industrial, y considerando que los solicitantes no contestaron las observaciones en el lapso legal establecido, se declaran las solicitudes detalladas a continuación como desistidas por disposición de la ley.'),0,'J',0);
      //$pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en el artículo 63 de la Ley Orgánica de Procedimientos Administrativos, considerando que los solicitantes han presentado por escrito el desistimiento. Se declaran las solicitudes detalladas a continuación como desistidas, ordenándose el archivo del expediente.'),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍCULO 63 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS, CONSIDERANDO QUE LOS SOLICITANTES HAN PRESENTADO POR ESCRITO EL DESISTIMIENTO. SE DECLARAN LAS SOLICITUDES DETALLADAS A CONTINUACIÓN COMO DESISTIDAS, ORDENANDOSE EL ARCHIVO DEL EXPEDIENTE.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	}  
	//$data[2]['TEXT'] = utf8_decode($titular);	
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       //$pdf->ln(8); 
       //$pdf->MultiCell(190,5,utf8_decode('SE INFORMA A LOS TRAMITANTES E INTERESADOS EN LAS SOLICITUDES DE REGISTROS MENCIONADOS ANTERIORMENTE, QUE PODRÁN EJERCER EL RECURSO ADMINISTRATIVO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS; DENTRO DE UN LAPSO DE QUINCE (15) DÍAS SIGUIENTES, A PARTIR DE LA PRESENTE PUBLICACIÓN.'),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else
 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  DESISTIDAS

//****************************************************************************************
//  ABANDONADAS
//****************************************************************************************
if($aband==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2090'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Abandonadas '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_aban)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('ABANDONADAS POR NO SOLICITAR EXAMEN TECNICO '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_aban)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('XXXXXXX.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         
 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  ABANDONADAS

//****************************************************************************************
//  PATENTES SIN EFECTO X NO PAGO DE DERECHOS DE CONCESION
//****************************************************************************************

if($pseder==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2752'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Solicitudes Sin Efecto x No Pago de Derechos ';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_derp)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTE NACIONALES SIN EFECTO POR FALTA DE PAGO DE DERECHOS'),0,'C',0);
      //$pdf->MultiCell(190,5,utf8_decode(trim($titp_aban)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('POR CUANTO LAS SOLICITUDES DE PATENTE QUE A CONTINUACIÓN SE ESPECIFICAN, PUBLICADAS COMO CONCEDIDAS EN BOLETÍN DE LA PROPIEDAD INDUSTRIAL, NO CONSIGNARON DENTRO DEL PLAZO LEGALMENTE ESTABLECIDO LOS DERECHOS DE REGISTRO CORRESPONDIENTES, ESTA OFICINA DE REGISTRO DECLARA SIN EFECTO LA CONCESIÓN DE LAS MISMAS, DE CONFORMIDAD CON LO DISPUESTO EN EL ARTÍCULO 65 DE LA LEY DE LA PROPIEDAD INDUSTRIAL.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.')),0,'J',0);
       $pdf->ln(8); 
       //$pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         
 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de PATENTES SIN EFECTO X NO PAGO DE DERECHOS DE CONCESION

//****************************************************************************************
//  ABANDONADAS X NO PAGO
//****************************************************************************************
if($aband==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2750'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Abandonadas x No Pago '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_aban)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('ABANDONADAS POR NO PAGO '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_aban)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('XXXXXXX.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  ABANDONADAS x NO PAGO

//****************************************************************************************
//  OPOSICIONES
//****************************************************************************************
if($oposi==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2009'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Oposiciones ' .$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_opos)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('OPOSICIONES DE PATENTES '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_opos)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('Se hace del conocimiento de los usuarios e interesados en las solicitudes de patente, que a continuación se señalan, publicadas como solicitadas en el Boletín de la Propiedad Industrial, que deben comparecer por ante este Servicio Autónomo a fin de retirar copia fotostática de el/los escritos de oposición que le fue formuladas a dichas solicitudes, a efectos que se notifiquen y contesten las mismas si lo estimaren conveniente en un lapso de treinta (30) días hábiles, contados a partir de la fecha, de conformidad con el artículo 63 de la Ley de Propiedad Industrial.'),0,'J',0);
      //$pdf->MultiCell(190,5,utf8_decode('Se hace conocimiento de los usuarios e interesados y/o apoderados de las solicitudes de Registro de las patentes detallados a continuación; que las mismas fueron objetadas, en consecuencia deberán comparecer por esta oficina a retirar la copia fotostática de el escrito(s) de oposición(es) que le fue formulada a la solicitud , a efectos de informarse de aquella en el plazo de quince (15) días hábiles a contar desde la presente publicación. Vencido dicho plazo los interesados cuentan con un lapso de quince (15) días hábiles, para la contestación, a fin de que ejerzan su derecho a la defensa, de acuerdo a los establecido en el artículo 63 de la Ley de Propiedad Industrial, G. O. N° 25.227 del 10/12/1956.'),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('SE HACE DEL CONOCIMIENTO DE LOS USUARIOS E INTERESADOS Y/O APODERADOS DE LAS SOLICITUDES DE REGISTRO DE LAS PATENTES DETALLADAS A CONTINUACIÓN; QUE LAS MISMAS FUERON OBJETADAS, EN CONSECUENCIA DEBERAN COMPARECER POR ESTA OFICINA A RETIRAR LA COPIA FOTOSTÁTICA DE EL ESCRITO(S) DE OPOSICIÓN (ES) QUE LE FUE FORMULADA A LA SOLICITUD, A EFECTOS DE INFORMARSE DE AQUELLA EN EL PLAZO DE QUINCE (15) DÍAS HÁBILES A CONTAR DESDE LA PRESENTE PUBLICACIÓN.  VENCIDO DICHO PLAZO LOS INTERESADOS CUENTAN CON UN LAPSO DE QUINCE DÍAS HÁBILES, PARA LA CONTESTACIÓN, A FIN DE QUE EJERZAN SU DERECHO A LA DEFENSA, DE ACUERDO A LO ESTABLECIDO EN EL ARTÍCULO 63 DE LA LEY DE PROPIEDAD INDUSTRIAL, G.O.N° 25.227 DEL 10/12/1956.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  OPOSICIONES

//****************************************************************************************
//  PATENTES EN REHABILITACION
//****************************************************************************************
if($rehab==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT stzderec.solicitud, stzderec.nro_derecho, stzderec.nombre, stzderec.tramitante, stzderec.agente, stzderec.poder 
		FROM  stzderec, stztmpbo
		WHERE stztmpbo.boletin = = '$boletin'
  		AND stztmpbo.nro_derecho = stzderec.nro_derecho 
		AND stztmpbo.tipo = 'P'
		AND stzderec.estatus = '2555'
		AND stzderec.nro_derecho in (select nro_derecho FROM stzevtrd WHERE evento = 2799) 
		AND stzderec.nro_derecho not in (select nro_derecho FROM stzevtrd WHERE evento = 2238)	ORDER BY stzderec.solicitud");	

$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Patentes en Rehabilitacion '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_reha)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REHABILITACION DE PATENTES '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_reha)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode('XXXXX'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
    	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
 
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 
}//fin de  PATENTES EN REHABILITACION

//****************************************************************************************
//  PATENTES SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD(ES)  
//****************************************************************************************
if($psefp==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2917'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Patentes sin Efecto por Falta de Pago de Anualidad'.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_sefp)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PATENTES SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode(  
      //'Se le notifica a los interesados y/o solicitantes, a fin de dar cumplimiento a lo establecido en el artículo 18 de la Ley de Propiedad Industrial, que las patentes que a continuación se detallan, no consignaron el pago de las anualidades establecido en el artículo 49 iusdem, por lo que esta Oficina Registral, declara que las mismas han quedado sin efecto, de conformidad con lo establecido en el artículo 17 literal "d", de la misma ley, en vista que los solicitantes no hicieron uso del Derecho de Rehabilitación, regulado por el artículo 19 de la Ley de Propiedad Industrial, las patentes señaladas se declaran de dominio público.'
      //),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('SE LE NOTIFICA A LOS INTERESADOS Y/O SOLICITANTES, A FN DE DAR CUMPLIMIENTO A LO ESTABLECIDO EN EL ARTÍCULO 18 DE LA LEY DE PROPIEDAD INDUSTRIAL, QUE LAS PATENTES QUE A CONTINUACIÓN SE DETALLAN, NO CONSIGNARON EL PAGO DE LAS ANUALIDADES ESTABLECIDO EN EL ARTÍCULO 49 JUSDEM, POR LO QUE ESTA OFICINA REGISTRAL, DECLARA QUE LAS MISMAS HAN QUEDADO SIN EFECTO, DE CONFORMIDAD CON LO ESTABLECIDO EN EL ARTÍUCLO 17 LITERAL d), DE LA MISMA LEY, EN VISTA QUE LOS SOLICITANTES NO HICIERON USO DEL DERECHO DE REHABILITACIÓN, REGULADO POR EL ARTÍCULO 19 DE LA LEY DE PROPIEDAD INDUSTRIAL, LAS PATENTES SEÑALADAS SE DECLARAN DEL DOMINIO PÚBLICO.'),0,'J',0);
      $pdf->ln(4); 

// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
   $nsolic=$registro_prio['solicitud'];
   $nregis=$registro_prio['registro'];
   $nagen=$registro_prio['agente'];
   $nderec=$registro_prio['nro_derecho'];
   if (empty($nagen)) {$nagen=0;}	
   $titular ='';	
   $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }                
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	}  
	//$data[2]['TEXT'] = utf8_decode($titular);	
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Registros : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,utf8_decode('SE INFORMA A LOS TRAMITANTES E INTERESADOS EN LOS REGISTROS MENCIONADOS ANTERIORMENTE, QUE PODRÁN EJERCER EL RECURSO ADMINISTRATIVO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS; DENTRO DE UN LAPSO DE QUINCE (15) DÍAS SIGUIENTES, A PARTIR DE LA PRESENTE PUBLICACIÓN.'),0,'J',0);
       //$pdf->MultiCell(190,5,utf8_decode('SE INFORMA A LOS TRAMITANTES E INTERESADOS EN LAS SOLICITUDES DE REGISTROS MENCIONADOS ANTERIORMENTE, QUE PODRÁN EJERCER EL RECURSO ADMINISTRATIVO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS; DENTRO DE UN LAPSO DE QUINCE (15) DÍAS SIGUIENTES, A PARTIR DE LA PRESENTE PUBLICACIÓN.'),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else
 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de Sin Efecto por falta de pago 

//****************************************************************************************
//  PATENTES SIN EFECTO POR VENCIMIENTO DE TERMINO  
//****************************************************************************************
if($psevt==1) {
	
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 6 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2918' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'V' as tipo_nacionalidad
    INTO temp stztmpsevt
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2918'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpsevt
    WHERE estatus='2918'
    AND boletin = '$boletin'");

while ( $counter <= 8) {

//Armando el query
$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.tipo_derecho, b.agente, b.tramitante, b.poder 	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2918'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'V'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

//$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
//	FROM  stzderec b, stztmpbo c
//	WHERE c.estatus='2918'
//    	AND c.boletin = '$boletin'
//   	AND c.tipo = 'P'
//	AND c.nro_derecho = b.nro_derecho 
//	AND b.tipo_derecho= '$tipo_derecho' 
//	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Patentes por Vencimiento del Termino'.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_sevt)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PATENTES NACIONALES SIN EFECTO POR VENCIMIENTO DEL TERMINO '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      //$pdf->MultiCell(190,5,utf8_decode(   
      //'Se le notifica a los interesados y/o solicitantes que de acuerdo a lo establecido en los artículos 17, literal e y 20 de la Ley de Propiedad Industrial, que las patentes detalladas a continuación se declaran sin efecto por vencimiento del término, establecido en la misma ley; por lo que esta Oficina Registral declara que las mismas pasan al dominio público.'
      //),0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('SE LE NOTIFICA A LOS INTERESADOS Y/O SOLICITANTES QUE DE ACUERDO A LO ESTABLECIDO EN LOS ARTÍCULOS 17, LITERAL e) Y 20 DE LA LEY DE PROPIEDAD INDUSTRIAL, QUE LAS PATENTES DETALLADAS A CONTINUACIÓN SE DACLARAN SIN EFECTO POR VENCIMIENTO DEL TÉRMINO, ESTABLECIDO EN LA MISMA LEY; POR LO QUE ESTA OFICINA REGISTRAL  DECLARA QUE LAS MISMAS PASAN AL DOMINIO PÚBLICO.'),0,'J',0);
      $pdf->ln(4); 
     
// dibujando la tabla
$pdf->Table_Init(4);
$columns=4;
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));
 
//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 255, 255),	
	'BRD_COLOR' => array(0,0,0),		
	'BRD_SIZE' => 0.4,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 38;
		
$pdf->Set_Header_Type($header_type);

//set data style
$data_type = Array();
  for ($i=0; $i<$columns; $i++) {
   $data_type[$i] = array(
	'T_COLOR' => array(0,0,0),	
	'T_SIZE' => 7,		
	'T_FONT' => 'Arial',	
	'T_ALIGN' => 'L',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => '',		
	'LN_SIZE' => 4,		
	'BG_COLOR' => array(255,255,255),	
	'BRD_COLOR' => array(255,255,255),		
	'BRD_SIZE' => 0,			
	'BRD_TYPE' => '0'		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header(); $pdf->Ln(1);

//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
   $nsolic=$registro_prio['solicitud'];
   $nregis=$registro_prio['registro'];
   $nagen=$registro_prio['agente'];
   $nderec=$registro_prio['nro_derecho'];
   if (empty($nagen)) {$nagen=0;}	
   $titular ='';	
   $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	//$data[1]['T_ALIGN'] = "C";
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);

	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	   //   $titular= $titular.utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }
	   //else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Nacionalidad: '.utf8_decode(trim($pais_nombre)).' Domicilio: '.utf8_decode(trim($regt['domicilio'])); }               
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	}  
	//$data[2]['TEXT'] = utf8_decode($titular);	
	$data[2]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
   $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Registros : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,utf8_decode('SE INFORMA A LOS TRAMITANTES E INTERESADOS EN LOS REGISTROS MENCIONADOS ANTERIORMENTE, QUE PODRÁN EJERCER EL RECURSO ADMINISTRATIVO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS; DENTRO DE UN LAPSO DE QUINCE (15) DÍAS SIGUIENTES, A PARTIR DE LA PRESENTE PUBLICACIÓN.'),0,'J',0);
       //$pdf->MultiCell(190,5,utf8_decode('SE INFORMA A LOS TRAMITANTES E INTERESADOS EN LAS SOLICITUDES DE REGISTROS MENCIONADOS ANTERIORMENTE, QUE PODRÁN EJERCER EL RECURSO ADMINISTRATIVO ESTABLECIDO EN EL ARTÍCULO 94 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS; DENTRO DE UN LAPSO DE QUINCE (15) DÍAS SIGUIENTES, A PARTIR DE LA PRESENTE PUBLICACIÓN.'),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
    $pdf->Setfont('Arial','',7);
    $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
    $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
    $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
    $pdf->MultiCell(190,5,utf8_decode($registrador6),0,'C',0);         

 }//fin del else
 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de Sin Efecto por VENCIMIENTO DEL TERMINO

// falta Titulos de Patentes (no existen en la base de datos los eventos para que carguen los titulos)
//Salida del Reporte
echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'> $mensaje</p></H3>"; 

$vnompat= "boletin_pat_nac"."_".$fechagen."_".$horagen.".pdf";

//$pdf->Output("../../boletin/boletin_pat.pdf");
$pdf->Output("../../boletin/".$vnompat);
$pdf->Output("../respaldoboletin/".$vnompat);

return $nro_resoluc;

}
       
?>
