<?php
// *************************************************************************************
// Programa: b_funcionre.php 
// Realizado por el Analista de Sistema - Profesional III - Ing. Rómulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Desarrollado Año: 2019 II Semestre
// *************************************************************************************

 function asesoria($nbol,$anoi,$anof,$anor,$nro_resol, $a800, $fec_800, $tit_800, $a801, $fec_801, $tit_801, $a802, $fec_802, $tit_802, $a803, $fec_803, $tit_803, $a804, $fec_804, $tit_804, $a805, $fec_805, $tit_805, $a806, $fec_806, $tit_806, $a807, $fec_807, $tit_807, $a808, $fec_808, $tit_808, $a809, $fec_809, $tit_809, $a821, $fec_821, $tit_821, $a822, $fec_822, $tit_822, $a823, $fec_823, $tit_823, $a824, $fec_824, $tit_824, $a825, $fec_825, $tit_825, $a830, $fec_830, $tit_830, $a831, $fec_831, $tit_831, $a833, $fec_833, $tit_833, $a835, $fec_835, $tit_835, $a836, $fec_836, $tit_836, $a837, $fec_837, $tit_837, $a838, $fec_838, $tit_838, $p800, $pfec_800, $ptit_800, $p801, $pfec_801, $ptit_801, $p802, $pfec_802, $ptit_802, $p804, $pfec_804, $ptit_804, $p805, $pfec_805, $ptit_805, $p806, $pfec_806, $ptit_806, $p809, $pfec_809, $ptit_809, $p821, $pfec_821, $ptit_821, $p833, $pfec_833, $ptit_833, $p835, $pfec_835, $ptit_835, $p836, $pfec_836, $ptit_836, $p837, $pfec_837, $ptit_837, $p838, $pfec_838, $ptit_838, $p840, $pfec_840, $ptit_840, $p921, $pfec_921, $ptit_921, $p922, $pfec_922, $ptit_922) {

 $boletin = $nbol;
 $numbol = $boletin;
 global $numbol,$pagina,$boletin,$nro_resoluc,$registrador1,$registrador2,$registrador3,$registrador4,$registrador5;
 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol-1;
 //$ministerio  = "MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL";
 //$registrador1= "Amado Enrique Maestri Loyo";
 //$registrador2= "Registrador de la Propiedad Industrial";
 ////$registrador3= "Designada por el Ciudadano Ministro, Mediante Delegación Contenida";
 //$registrador4= "Según Resolución No. 005, Publicada en la Gaceta Oficial de la "; 
 //$registrador5= "República Bolivariana de Venezuela No.41.438 de Fecha 12-07-2018"; 
 $ministerio  = "MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL";
 $registrador1= "(Firmado y Sellado en su original)";
 $registrador2= "EURIDYS LISETH HERNANDEZ URRIBARRI";
 $registrador3= "Registradora de la Propiedad Industrial";
 $registrador4= "Designada mediante Resolución No. 020/2019 de fecha 07 de mayo de 2019";
 $registrador5= "Publicada en Gaceta Oficial de la República Bolivariana de Venezuela"; 
 $registrador6= "Nº.41.628 de Fecha 08 de mayo de 2019"; 

 $fechahoy = hoy();
 $horactual=hora();
 $dia = substr($fechahoy, 0, 2);
 $mes = substr($fechahoy, 3, 2);
 $ano = substr($fechahoy, 6, 4);
 $fechagen = $dia.$mes.$ano;
 $horagen = substr($horactual,0,8).substr($horactual,9,2);

//****************************************************************************************
// RECURSOS, CANCELACIONES Y NULIDADES - MARCAS --- Asesoria Juridica 
//****************************************************************************************

//Inicio del Pdf
$pdf=new PDF_Tablebol('P','mm','Letter');
$pdf->Open();
//$pdf->AddPage();
$pdf->AliasNbPages();

if($a800==1) {

//Eliminacion de todo el Estatus 800 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1800' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo800
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1800'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1800'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo800
    WHERE estatus='1800'
    AND boletin = '$boletin'
    AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1800)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
ORDER BY a.solicitud");

//$resultado=pg_exec("SELECT DISTINCT a.nro_derecho,a.solicitud,a.estatus FROM stzderec a, stmmarce b, stzevtrd c WHERE a.tipo_mp='M' AND a.estatus='1800' AND (a.nro_derecho=b.nro_derecho) AND (a.nro_derecho=c.nro_derecho) AND c.evento = 1195 AND c.documento = 588 AND a.nro_derecho NOT IN (SELECT nro_derecho FROM stzevtrd WHERE evento = 1196) ORDER BY 1");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones Prioridades EXtinguidas';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°39,  en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas con Prioridad Extinguida que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 800  

//****************************************************************************************

if($a801==1) {

//Eliminacion de todo el Estatus 801 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1801' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo801
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1801'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1801'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo801
    WHERE estatus='1801'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1801)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho = a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Negadas de Oficio';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°40, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,  se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas Negadas de Oficio que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 801  

//****************************************************************************************

if($a802==1) {

//Eliminacion de todo el Estatus 801 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1802' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo802
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1802'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1802'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo802
    WHERE estatus='1802'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1802)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Resolucion a Observaciones';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°41,  en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos , se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas con  Resolución de Observaciones que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 802  

//****************************************************************************************

if($a803==1) {

//Eliminacion de todo el Estatus 803 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1803' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo803
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1803'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1803'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo803
    WHERE estatus='1803'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1803)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Perencion de Procedimiento';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°42,  en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas con  Perención de Procedimiento que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 803  

//****************************************************************************************

if($a804==1) {

//Eliminacion de todo el Estatus 804 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1804' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo804
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1804'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1804'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo804
    WHERE estatus='1804'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1804)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Prioridad Extinguida Publicacion Extemporanea';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°43, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,  se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas con  Prioridad Extinguida por Publicación en Prensa Extemporánea que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 804  

//****************************************************************************************

if($a805==1) {

//Eliminacion de todo el Estatus 805 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1805' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo805
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1805'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1805'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo805
    WHERE estatus='1805'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1805)  
                     AND a.tipo_mp='M' 
   	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Perencion de Procedimiento por NO publicacion en Prensa.';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°44,  en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas con  Perención de Procedimiento por No Publicación en Prensa que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 805  

//****************************************************************************************

if($a806==1) {

//Eliminacion de todo el Estatus 806 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1806' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo806
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1806'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1806'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo806
    WHERE estatus='1806'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1806)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho = a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones Caducas';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°45, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas Caducas que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 806  

//****************************************************************************************

if($a807==1) {

//Eliminacion de todo el Estatus 807 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1807' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo807
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1807'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1807'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo807
    WHERE estatus='1807'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1807)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Solicitudes Desistidas por Ley';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°46,  en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas Desistidas por Ley por No Contestar Oposición que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 807  

//****************************************************************************************

if($a808==1) {

//Eliminacion de todo el Estatus 808 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1808' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo808
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1808'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1808'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo808
    WHERE estatus='1808'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1808)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1865)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideraciones a Prioridad Extinguida Publicacion Defectuosa';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°47, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los procedimientos contentivos de los Recursos de Reconsideración a Solicitudes de Marcas con Prioridad Extinguida por Publicación en Prensa Defectuosa que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 808

//****************************************************************************************

if($a809==1) {

//Eliminacion de todo el Estatus 809 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1809' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo809
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1809'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1809'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo809
    WHERE estatus='1809'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1809)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1867)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Nulidad a Concesion por Notificar';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°48, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad a la Concesión Pendientes de Notificación que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 809  

//****************************************************************************************

if($a821==1) {

//Eliminacion de todo el Estatus 821 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1821' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo821
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1821'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1821'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo821
    WHERE estatus='1821'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1821)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1871)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Peticion de Nulidad del Acto Administrativo';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°49, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad del Acto Administrativo en los Procedimientos de Marcas en trámite que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 821  

//****************************************************************************************

if($a822==1) {

//Eliminacion de todo el Estatus 822 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1822' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo822
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1822'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1822'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo822
    WHERE estatus='1822'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1822)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1873)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Nulidad de Acto Administrativo de Oficio';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°50, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad del Acto Administrativo de Oficio en los Procedimientos de Marcas en trámite que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 822  

//****************************************************************************************

if($a823==1) {

//Eliminacion de todo el Estatus 823 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1823' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo823
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1823'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1823'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo823
    WHERE estatus='1823'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1823)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1875)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Peticion de Nulidad de Acto Administrativo Notificada ';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°51, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,se declara la perención de las Peticiones de Nulidad del Acto Administrativo Notificadas en los Procedimientos de Marcas en Trámite que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 823  

if($a824==1) {

//Eliminacion de todo el Estatus 824 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1824' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo824
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1824'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1824'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo824
    WHERE estatus='1824'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1824)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1877)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Nulidad de Acto Administrativo de Oficio Notificada';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°52, n el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Peticiones de Nulidad del Acto Administrativo Notificadas en los Procedimientos de Marcas en Trámite que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 824  

//****************************************************************************************

if($a825==1) {

//Eliminacion de todo el Estatus 825 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1825' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo825
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1825'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1825'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo825
    WHERE estatus='1825'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1825)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1867)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Recurso a Nulidad de Concesion Notificada';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°53, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos de Nulidad a la Concesión Notificados que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic=$registro_obse['solicitud'];
      $nagen=$registro_obse['agente'];
      $nderec=$registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[1]['TEXT'] = $clase;
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[3]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 825  

//****************************************************************************************

if($a830==1) {

//Eliminacion de todo el Estatus 830 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1830' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo830
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1830'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1830'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo830
    WHERE estatus='1830'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1830)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1869)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Caducidad por NO Uso por Notificar';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°54, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,  se declara la perención de las Solicitudes de Cancelación o Caducidad por No Uso de Marcas Pendientes de Notificar que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 830  

//****************************************************************************************

if($a831==1) {

//Eliminacion de todo el Estatus 831 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1831' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo831
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1831'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1831'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo831
    WHERE estatus='1831'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1831)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1869)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Caducidad por NO Uso Notificada';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°55, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las solicitudes de Cancelación o Caducidad por no Uso de Notificadas que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 831  

//****************************************************************************************

if($a833==1) {

//Eliminacion de todo el Estatus 833 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1833' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo833
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1833'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1833'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo833
    WHERE estatus='1833'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1833)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1881)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideracion Disposicion Administrativa que Afecta al Registro';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°56, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,  se declara la perención de Recursos de Reconsideracion por Disposiciones Administrativas que afectan el Registro de Marca Relacionados con Cancelaciones por Falta de Uso o Caducidad por No Uso que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 833

//****************************************************************************************

if($a835==1) {

//Eliminacion de todo el Estatus 835 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1835' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo835
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1835'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1835'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo835
    WHERE estatus='1835'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1835)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1879)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Marca con Solicitud de Nulidad por Notificar';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°57,en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad Pendientes de Notificación que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 835  

//****************************************************************************************

if($a836==1) {

//Eliminacion de todo el Estatus 836 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1836' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo836
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1836'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1836'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo836
    WHERE estatus='1836'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1836)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1867)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Registro con Solicitud de Nulidad Notificada';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°58, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad Notificadas  que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 836  

//****************************************************************************************

if($a837==1) {

//Eliminacion de todo el Estatus 837 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1837' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo837
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1837'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1837'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo837
    WHERE estatus='1837'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1837)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1867)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Registro con Nulidad por Disposicion Administrativa';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°59,en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad por Disposición Administrativa que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 837  

//****************************************************************************************

if($a838==1) {

//Eliminacion de todo el Estatus 838 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '1838' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stztmpbo838
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1838'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio!='VE'
     AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'M' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='1838'
     AND c.boletin = '$boletin'
     AND c.tipo = 'M'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = a.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stztmpbo838
    WHERE estatus='1838'
     AND boletin = '$boletin'
     AND tipo_nacionalidad = 'E'");

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo1 c  
                    WHERE a.estatus IN (1838)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
   	               AND c.tipo_nacionalidad = 'E'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
                     AND a.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=1883)
                    ORDER BY a.solicitud");

//                     AND c.evento=1310   , stzevtrd c 
//                     AND (a.nro_derecho=c.nro_derecho)

$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Reconsideracion a Disposicion Administrativa de Nulidad de Registro';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.', '.$anof.' y '.$anor,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°60, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Recursos De Reconsideracion A Disposiciones Administrativas que Resuelven Acciones De Nulidad al Registro De Marcas que se identifican a continuación:')),0,'J',0);
      
//initialize the table with 5 columns
$pdf->Table_Init(6);
$columns=6;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 59;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 50;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 40;
		
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
 for($cont=0;$cont<$filas_resultado_obse;$cont++) { 
      $nsolic   = $registro_obse['solicitud'];
      $nregis   = $registro_obse['registro'];
      $nagen    = $registro_obse['agente'];
      $nderec   = $registro_obse['nro_derecho'];
      $solwebpi = trim($registro['tramitewebpi']);

      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['registro'];	
	$clase= $registro_obse['clase'];		
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}
	$data[2]['TEXT'] = $clase;
	$data[3]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   //$pais_nombre=pais($regt['nacionalidad']);
	   if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	   else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	   if ($cont1=='0'){
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	$data[4]['TEXT'] = $titular;	
	
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
   $poder = trim($registro_obse['poder']);
   $tram = agente_tramp($nagen,trim($registro_obse['tramitante']),$poder);
   $data[5]['TEXT'] = trim(utf8_decode($tram)); 
   $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
  // Fin de Pagina (Firma del Registrador)
  $pdf->ln(8); 
  $pdf->Setfont('Arial','B',8);
  $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
  $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
 }//fin del else

}//fin Estatus 838  

//****************************************************************************************
//  RECURSOS, ACCIONES Y NULIDADES DE PATENTES
//****************************************************************************************

if($p800==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 800 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2800' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol800
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2800'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2800'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol800
    WHERE estatus='2800'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2800'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");

//	AND c.nro_derecho = b.nro_derecho 
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 800 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°61, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,  se declara la perención de los Recursos De Reconsideracion a Patentes declaradas con Prioridad Extinguida  que se identifican a continuación:')),0,'J',0);
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
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 800

if($p801==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 801 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2801' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol801
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2801'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2801'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol801
    WHERE estatus='2801'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2801'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	               AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 801 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°62, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos de Reconsideración a Patentes Negadas que se identifican a continuación:')),0,'J',0);
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
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 801

if($p802==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 802 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2802' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol802
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2802'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2802'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol802
    WHERE estatus='2802'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2802'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
   	               AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 802 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°63, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,se declara la perención de los Recursos De Reconsideración a Patentes Denegadas que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 

      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 802

if($p804==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 804 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2804' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol804
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2804'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2804'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol804
    WHERE estatus='2804'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2804'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
      AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 804 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°64, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos De Reconsideración a Patentes Declaradas con Prioridad Extinguida por Publicación Defectuosa que se identifican a continuación:')),0,'J',0);
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
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 804


if($p805==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 805 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2805' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol805
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2805'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2805'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol805
    WHERE estatus='2805'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2805'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
      AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 805 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°65 publicado en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos De Reconsideración a Patentes Declaradas con Perención de Procedimiento  que se identifican a continuación:')),0,'J',0);
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
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 805

if($p806==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 806 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2806' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol806
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2806'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2806'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
     AND c.nro_derecho = d.nro_derecho
     AND d.pais_domicilio='VE'
     AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol806
    WHERE estatus='2806'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2806'
  	 AND c.boletin = '$boletin'
    AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	 AND c.nro_derecho = b.nro_derecho 
    AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 806 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°66, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos De Reconsideración a Patentes Abandonadas  que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 

      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 806

if($p809==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 809 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2809' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol809
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2809'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2809'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol809
    WHERE estatus='2809'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2809'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2867)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 809 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°67, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Escritos de Nulidad a las Solicitudes de Patentes  que se identifican a continuación:')),0,'J',0);
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
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 809

if($p821==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 821 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2821' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol821
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2821'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2821'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol821
    WHERE estatus='2821'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2821'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2867)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 821 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°68, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Peticiones de Nulidad del Acto Administrativo de Solicitudes de Patentes en Trámite que se identifican a continuación:')),0,'J',0);
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
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 821

if($p833==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 833 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2833' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol833
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2833'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2833'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol833
    WHERE estatus='2833'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2833'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2869)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 833 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°69, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos de Reconsideraron de Patentes afectadas por Disposición Administrativa  que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 

      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 833

if($p835==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 835 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2835' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol835
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2835'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2835'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol835
    WHERE estatus='2835'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2835'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2871)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 835 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°70, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad de Patentes pendientes de Notificación que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 835

if($p836==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 836 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2836' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol836
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2836'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2836'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol836
    WHERE estatus='2836'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2836'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2871)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 836 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°71, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de las Solicitudes de Nulidad de Patentes Notificadas que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 

      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 836

if($p837==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 837 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2837' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol837
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2837'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2837'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol837
    WHERE estatus='2837'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2837'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2869)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 837 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°72, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos de Reconsideración -Disposición Administrativa de Nulidad de Registro de Patente que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 837

if($p838==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 838 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2838' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol838
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2838'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2838'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol838
    WHERE estatus='2838'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2838'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2869)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 838 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°72, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos de Reconsideración -Disposición Administrativa de Nulidad de Registro de Patente que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 

      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 838

if($p840==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 840 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2840' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol840
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2840'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2840'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol840
    WHERE estatus='2840'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2840'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2865)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 840 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°73, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos,  se declara la perención de las Solicitudes de Patente Desistidas Con Recurso de Reconsideración que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 

      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 840

if($p921==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 921 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2921' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol921
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2921'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2921'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol921
    WHERE estatus='2921'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2921'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2873)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 921 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°74,  en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recursos de Reconsideración de Solicitudes de Patente sin Efecto por Falta de Pago  de Anualidad Publicada que se identifican a continuación: ')),0,'J',0);
      $pdf->ln(4); 
    
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 921

if($p922==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='INVENCIÓN';

//Eliminacion de todo el Estatus 922 de stztmpbo1 
$delbol1    = pg_exec("DELETE FROM stztmpbo1 WHERE estatus= '2922' AND boletin= '$boletin'");

$resultadopais=pg_exec("SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    INTO temp stptmpsol922
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2922'
     AND c.boletin = '$boletin'
     AND c.tipo = 'P'
     AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio!='VE'
        AND d.nacionalidad!= 'VE'
UNION
SELECT b.nro_derecho, b.solicitud, c.boletin, c.estatus, 'P' as tipo, d.pais_domicilio, d.nacionalidad,'E' as tipo_nacionalidad
    FROM  stzderec b, stztmpbo c, stzottid d
    WHERE c.estatus='2922'
        AND c.boletin = '$boletin'
       AND c.tipo = 'P'
    AND c.nro_derecho = b.nro_derecho
        AND c.nro_derecho = d.nro_derecho
        AND d.pais_domicilio='VE'
        AND d.nacionalidad!= 'VE'
ORDER BY 1");

$resultado1 = pg_exec("INSERT INTO stztmpbo1
SELECT distinct on (nro_derecho) nro_derecho, solicitud, boletin, estatus, tipo, pais_domicilio, nacionalidad,tipo_nacionalidad
    FROM  stptmpsol922
    WHERE estatus='2922'
    AND boletin = '$boletin'");

while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo1 c
	WHERE c.estatus='2922'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
    AND c.tipo_nacionalidad = 'E'
	AND c.nro_derecho = b.nro_derecho 
        AND b.nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento=2873)
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Estatus 922 ';} 
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
      $pdf->MultiCell(190,5,utf8_decode('DRPI-AO N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('AVISO OFICIAL'),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Visto que en fecha 12 de noviembre de 2018, este Registro de la Propiedad Industrial, publicó el Aviso Oficial N.º DRPI-AO-N°75, en el Boletín de la Propiedad Industrial Nº 588 de fecha 12 de noviembre de 2018, y vencido el plazo otorgado en el mismo, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, se declara la perención de los Recurso de Reconsideración de Solicitudes de Patente sin Efecto por Vencimiento del Término que se identifican a continuación:')),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 5 columns
$pdf->Table_Init(5);
$columns=5;
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULO DE LA PATENTE ");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR(ES) ");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
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
	$data[1]['TEXT'] = $registro_prio['registro'];	
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
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
	$data[3]['TEXT'] = $titular;	
		
	//busqueda del tramitante
	//$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
   $poder = trim($registro_prio['poder']);
   $tram = agente_tramp($nagen,trim($registro_prio['tramitante']),$poder);
	
   $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->Setfont('Arial','',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se notifica a las partes interesadas que para impugnar administrativamente la presente Resolución dispone, de conformidad con el artículo 94 de la Ley Orgánica de Procedimientos Administrativos, del Recurso de Reconsideración, el cual podrán ejercer por ante este Despacho, dentro del lapso de quince (15) días hábiles, contados a partir de la fecha de la publicación de esta Decisión en el Boletín de la Propiedad Industrial.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
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
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORA'; $subpate='MEJORA';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
//if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='DISEÑO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE MODELO INDUSTRIAL'; $subpate='MODELO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCIÓN'; $subpate='INTRODUCCIÓN';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELO DE UTILIDAD'; $subpate='MODELO DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

} //fin Estatus 922

//Salida del Reporte
echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'> $mensaje</p></H3>"; 

$vnommar= "boletin_rec_ext"."_".$fechagen."_".$horagen.".pdf";
$pdf->Output("../../boletin/".$vnommar);
$pdf->Output("../respaldoboletin/".$vnommar);
//$pdf->Output('F',$vnommar);
return $nro_resoluc;

}
       
?>
