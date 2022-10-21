<?php
// *************************************************************************************
// Programa: b_funcionr.php 
// Realizado por el Analista de Sistema - Profesional III - Ing. Rómulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Desarrollado Año: 2018 II Semestre
// *************************************************************************************

 function asesoria($nbol,$anoi,$anof,$anor,$nro_resol, $a800, $fec_800, $tit_800, $a801, $fec_801, $tit_801, $a802, $fec_802, $tit_802, $a803, $fec_803, $tit_803, $a804, $fec_804, $tit_804, $a805, $fec_805, $tit_805, $a806, $fec_806, $tit_806, $a807, $fec_807, $tit_807, $a808, $fec_808, $tit_808, $a809, $fec_809, $tit_809, $a821, $fec_821, $tit_821, $a822, $fec_822, $tit_822, $a823, $fec_823, $tit_823, $a824, $fec_824, $tit_824, $a825, $fec_825, $tit_825, $a830, $fec_830, $tit_830, $a831, $fec_831, $tit_831, $a833, $fec_833, $tit_833, $a835, $fec_835, $tit_835, $a836, $fec_836, $tit_836, $a837, $fec_837, $tit_837, $a838, $fec_838, $tit_838, $p800, $pfec_800, $ptit_800, $p801, $pfec_801, $ptit_801, $p802, $pfec_802, $ptit_802, $p804, $pfec_804, $ptit_804, $p805, $pfec_805, $ptit_805, $p806, $pfec_806, $ptit_806, $p809, $pfec_809, $ptit_809, $p821, $pfec_821, $ptit_821, $p833, $pfec_833, $ptit_833, $p835, $pfec_835, $ptit_835, $p836, $pfec_836, $ptit_836, $p837, $pfec_837, $ptit_837, $p838, $pfec_838, $ptit_838, $p840, $pfec_840, $ptit_840, $p921, $pfec_921, $ptit_921, $p922, $pfec_922, $ptit_922) {

 $boletin = $nbol;
 $numbol = $boletin;
 global $numbol,$pagina,$boletin,$nro_resoluc,$registrador1,$registrador2,$registrador3,$registrador4,$registrador5;
 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol-1;
 $ministerio  = "MINISTERIO DEL PODER POPULAR DE COMERCIO NACIONAL";

 $registrador2= "KRUZCAYA LOUDESKA DELGADO ABREU";
 $registrador3= "Registradora de la Propiedad Industrial";
 $registrador4= "Designada mediante Resolución No. 015/2021 de fecha 23 de Septiembre de 2021";
 $registrador5= "Publicada en Gaceta Oficial de la República Bolivariana de Venezuela"; 
 $registrador6= "Nº.42.224 de Fecha 30 de Septiembre de 2021"; 


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

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1800)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
ORDER BY a.solicitud");

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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CON PRIORIDAD EXTINGUIDA interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 800), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A LA SOLICITUD CON PRIORIDAD EXTINGUIDA Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes con Prioridad Extinguida en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES CON PRIORIDAD EXTINGUIDA interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 800  

//****************************************************************************************

if($a801==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1801)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho = a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A LAS SOLICITUDES DE MARCAS NEGADAS DE OFICIO interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 801), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN RECURSO DE RECONSIDERACIÓN A LA SOLICITUD NEGADA DE OFICIO Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes Negadas de Oficio en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A LAS SOLICITUDES NEGADAS DE OFICIO interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 801  

//****************************************************************************************

if($a802==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1802)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CON RESOLUCIÓN A OBSERVACIONES interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 802), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A LA SOLICITUD CON RESOLUCIÓN A OBSERVACIONES Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes con Resolución a Observación en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recurso in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES CON RESOLUCIÓN A OBSERVACIONES interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 802  

//****************************************************************************************

if($a803==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1803)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CON PERENCIÓN DE PROCEDIMIENTO interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 803), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A RECURSO DE RECONSIDERACIÓN A LA SOLICITUD CON PERENCIÓN DE PROCEDIMIENTO Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes con Perención de Procedimiento en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES CON PERENCIÓN DE PROCEDIMIENTO interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 803  

//****************************************************************************************

if($a804==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1804)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CON PRIORIDAD EXTINGUIDA POR PUBLICACIÓN EN PRENSA EXTEMPORÁNEA interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 804), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A LA SOLICITUD CON PRIORIDAD EXTINGUIDA POR PUBLICACIÓN EN PRENSA EXTEMPORÁNEA Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes con Prioridad Extinguida por Publicación en Prensa Extemporánea en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES CON PRIORIDAD EXTINGUIDA POR PUBLICACIÓN EN PRENSA EXTEMPORÁNEA  interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 804  

//****************************************************************************************

if($a805==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1805)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CON PERENCIÓN DE PROCEDIMIENTO POR NO PUBLICACIÓN EN PRENSA interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 805), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A RECURSO DE RECONSIDERACIÓN A LA SOLICITUD CON PERENCIÓN DE PROCEDIMIENTO POR NO PUBLICACIÓN EN PRENSA Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes con Perención de Procedimiento por No Publicación en Prensa en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES CON PERENCIÓN DE PROCEDIMIENTO POR NO PUBLICACIÓN EN PRENSA interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 805  

//****************************************************************************************

if($a806==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1806)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho = a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CADUCAS interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 806), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A LA SOLICITUD DE MARCAS CADUCAS Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes de Marcas Caducas en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CADUCAS interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 806  

//****************************************************************************************

if($a807==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1807)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS DESISTIDAS POR LEY POR NO CONTESTAR OPOSICIÓN interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 807), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A LA SOLICITUD DESISTIDA POR LEY POR NO CONTESTAR OPOSICIÓN Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes Desistidas por Ley por No Contestar Oposición en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con losl Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES DESISTIDAS POR LEY POR NO CONTESTAR OPOSICIÓN interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 807  

//****************************************************************************************

if($a808==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1808)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN A SOLICITUDES DE MARCAS CON PRIORIDAD EXTINGUIDA POR PUBLICACIÓN EN PRENSA DEFECTUOSA interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 808), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A LA SOLICITUD CON PRIORIDAD EXTINGUIDA POR PUBLICACIÓN EN PRENSA DEFECTUOSA Nº (INDICAR NÚMERO DE SOLICITUD).')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Recursos de Reconsideración a las Solicitudes con Prioridad Extinguida por Publicación en Prensa Defectuosa en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN A SOLICITUDES CON PRIORIDAD EXTINGUIDA POR PUBLICACIÓN EN PRENSA DEFECTUOSA interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 808

//****************************************************************************************

if($a809==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1809)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de LAS SOLICITUDES DE MARCAS CON ESCRITOS DE NULIDAD A LA CONCESIÓN-PENDIENTES DE NOTIFICACIÓN interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones de Nulidades (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 809), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A SOLICITUD CON ESCRITO DE NULIDAD A LA CONCESIÓN-PENDIENTE DE NOTIFICACIÓN Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio,  nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las Solicitudes con Escritos de Nulidad a la Concesión la cual se encuentra Pendiente de Notificación, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de LAS SOLICITUDES CON ESCRITOS DE NULIDAD A LA CONCESIÓN-PENDIENTES DE NOTIFICACIÓN interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 809  

//****************************************************************************************

if($a821==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1821)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUDES DE MARCAS EN TRÁMITE CON PETICIÓN DE NULIDAD DEL ACTO ADMINISTRATIVO interpuestos ante este Despacho de Registro, las cuales más adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 821), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A SOLICITUD DE MARCA EN TRÁMITE CON PETICIÓN DE NULIDAD DEL ACTO ADMINISTRATIVO Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio, nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las Solicitudes de Marcas en Trámite con Petición de Nulidad del Acto Administrativo, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con Las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de  LAS SOLICITUDES DE MARCAS EN TRÁMITE CON PETICIÓN DE NULIDAD DEL ACTO ADMINISTRATIVO interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 821  

//****************************************************************************************

if($a822==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1822)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUDES DE MARCAS CON NULIDAD DE ACTO ADMINISTRATIVO DE OFICIO interpuestos ante este Despacho de Registro, las cuales más adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 822), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A SOLICITUD CON NULIDAD DE ACTO ADMINISTRATIVO DE OFICIO Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio, nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Las Solicitudes con Nulidad al Acto Administrativo de Oficio, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con Las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de LAS  SOLICITUDES CON NULIDAD DE ACTO ADMINISTRATIVO DE OFICIO interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 822  

//****************************************************************************************

if($a823==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1823)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUDES DE MARCAS EN TRAMITE CON PETICION DE NULIDAD DE ACTO ADMINISTRATIVO NOTIFICADOS interpuestos ante este Despacho de Registro, las cuales más adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 823), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A SOLICITUD EN TRAMITE CON PETICION DE NULIDAD DE ACTO ADMINISTRATIVO - NOTIFICADO Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio, nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Las Solicitudes en Trámite con Petición de Nulidad de Acto Administrativo Notificados, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con Las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de LAS SOLICITUDES EN TRAMITE CON PETICION DE NULIDAD DE ACTO ADMINISTRATIVO NOTIFICADAS interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 823  

if($a824==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1824)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUDES DE MARCAS CON NULIDAD DE ACTO ADMINISTRATIVO DE OFICIO-NOTIFICADAS interpuestos ante este Despacho de Registro, las cuales más adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 824), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A SOLICITUD CON NULIDAD DE ACTO ADMINISTRATIVO DE OFICIO-NOTIFICADA Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio, nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Las Solicitudes con Nulidad al Acto Administrativo de Oficio-Notificadas, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de LAS  SOLICITUDES CON NULIDAD DE ACTO ADMINISTRATIVO DE OFICIO-NOTIFICADAS interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 824  

//****************************************************************************************

if($a825==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1825)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de LAS SOLICITUDES DE MARCAS CON RECURSOS DE NULIDAD A LA CONCESIÓN-NOTIFICADAS interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos de Nulidades (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 825), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A SOLICITUD CON RECURSO DE NULIDAD A LA CONCESIÓN-NOTIFICADA Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio,  nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Las Solicitudes con Recurso de Nulidad a la Concesión Notificadas, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de LAS SOLICITUDES CON RECURSOS DE NULIDAD A LA CONCESIÓN-NOTIFICADAS interpuestas ante este Despacho:')),0,'J',0);
      
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 825  

//****************************************************************************************

if($a830==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1830)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de REGISTROS DE MARCAS CON SOLICITUDES DE CANCELACIÓN POR FALTA DE USO, O CADUCIDAD POR NO USO,- PENDIENTES POR NOTIFICAR interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 830), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A REGISTRO CON SOLICITUD DE CANCELACIÓN POR NO USO- PENDIENTE POR NOTIFICAR Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito (cancelación por falta de uso, caducidad por no uso) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar estos Registros con Solicitudes de Cancelación por Falta de Uso o Caducidad por No Uso, que se encuentran Pendientes de Notificación, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de REGISTROS CON SOLICITUDES DE CANCELACIÓN POR FALTA DE USO, O CADUCIDAD POR NO USO,- PENDIENTES POR NOTIFICAR interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 830  

//****************************************************************************************

if($a831==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1831)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de REGISTROS DE MARCAS CON SOLICITUDES DE CANCELACIÓN POR FALTA DE USO, O CADUCIDAD POR NO USO,- NOTIFICADAS interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 831), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN A REGISTRO CON SOLICITUD DE CANCELACIÓN POR NO USO- NOTIFICADA  Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito (cancelación por falta de uso, caducidad por no uso) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar estos Registros con Solicitudes de Cancelación por Falta de Uso o Caducidad por No Uso, Notificadas, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de REGISTROS CON SOLICITUDES DE CANCELACIÓN POR FALTA DE USO, O CADUCIDAD POR NO USO,- NOTIFICADAS interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 831  

//****************************************************************************************

if($a833==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1833)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSOS DE RECONSIDERACIÓN POR DISPOSICIONES ADMINISTRATIVAS QUE AFECTAN AL REGISTRO DE MARCA RELACIONADAS CON CANCELACIONES POR FALTA DE USO O CADUCIDAD POR NO USO interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 833), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÒN DE RECURSO DE RECONSIDERACIÓN POR DISPOSICIÓN ADMINISTRATIVA QUE AFECTA AL REGISTRO RELACIONADA CON CANCELACION POR FALTA DE USO O CADUCIDAD POR NO USO Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito (cancelación por falta de uso, caducidad por no uso) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar estos Recursos de Reconsideración por Disposición Administrativa  que afecta al Registro Por Cancelación por Falta de Uso o Caducidad por No Uso, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de RECURSOS DE RECONSIDERACIÓN POR DISPOSICIONES ADMINISTRATIVAS QUE AFECTAN AL REGISTRO RELACIONADAS CON CANCELACIONES POR FALTA DE USO O CADUCIDAD POR NO USO interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 833

//****************************************************************************************

if($a835==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1835)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de MARCAS  CON SOLICITUDES DE NULIDAD -PENDIENTES DE NOTIFICACIÓN interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones de Nulidades (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 835), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE MARCA CON SOLICITUD DE NULIDAD-PENDIENTE DE NOTIFICACIÓN Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio,  nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Las Marcas con Solicitudes de Nulidad que se encuentran Pendientes de Notificación, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de MARCAS  CON SOLICITUDES DE NULIDAD-PENDIENTES DE NOTIFICACIÓN interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 835  

//****************************************************************************************

if($a836==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1836)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de REGISTROS DE MARCAS CON SOLICITUDES DE NULIDAD-NOTIFICADAS interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones de Nulidades (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 836), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE REGISTRO CON SOLICITUD DE NULIDAD-NOTIFICADA Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio,  nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los Registros con Solicitud de Nulidad Notificadas, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de REGISTROS CON SOLICITUDES DE NULIDAD-NOTIFICADAS  interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 836  

//****************************************************************************************

if($a837==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1837)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de REGISTROS DE MARCAS CON NULIDADES POR DISPOSICIÓN ADMINISTRATIVAS interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de las mencionadas Acciones de Nulidades (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 837), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE REGISTRO CON NULIDAD POR DISPOSICIÓN ADMINISTRATIVA Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio, nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Los Registros con Nulidades por Disposición Administrativa, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con las Acciones de Nulidad in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de REGISTROS CON NULIDADES POR DISPOSICIÓN ADMINISTRATIVAS interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else

}//fin Estatus 837  

//****************************************************************************************

if($a838==1) {

$resultado=pg_exec("SELECT DISTINCT a.solicitud, a.nro_derecho, a.registro, a.nombre, a.agente, a.tramitante, b.clase, a.poder, a.tramitewebpi 
                    FROM stzderec a, stmmarce b, stztmpbo c  
                    WHERE a.estatus IN (1838)  
                     AND a.tipo_mp='M' 
    	               AND c.boletin='$boletin'
   	               AND c.tipo='M'
                     AND (a.nro_derecho=b.nro_derecho)
	                  AND (c.nro_derecho=a.nro_derecho) 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSOS DE RECONSIDERACIÓN A DISPOSICIONES ADMINISTRATIVAS QUE RESUELVEN ACCIONES DE NULIDADES AL REGISTRO DE MARCA interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 838), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RATIFICACIÓN DE RECURSO DE RECONSIDERACIÓN A DISPOSICIÓN ADMINISTRATIVA QUE RESUELVE ACCIÓN DE NULIDAD AL REGISTRO Nº (INDICAR NÚMERO DE SOLICITUD). De existir un error en la calificación del escrito por el tipo de nulidad (nulidad al acto administrativo de marca en trámite, nulidad al acto administrativo de oficio, nulidad a la concesión o nulidad a la disposición administrativa) se deberá informar en el mismo escrito de la Ratificación.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar Los Recursos de Reconsideración a Disposiciones  Administrativas que resuelven Acciones de Nulidades al Registro, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de RECURSOS DE RECONSIDERACIÓN A DISPOSICIONES ADMINISTRATIVAS QUE RESUELVEN ACCIONES DE NULIDADES AL REGISTRO interpuestas ante este Despacho:')),0,'J',0);
      
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
  $pdf->ln(8); 
  $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
  $pdf->Setfont('Arial','B',8);
  $pdf->ln(10); 
  $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
  $pdf->ln(30); 
  $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
  $pdf->Setfont('Arial','B',7);
  $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
  //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
  $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
  $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2800'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE CON ESCRITO DE RECONSIDERACIÓN - PRIORIDAD EXTINGUIDA interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 800), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD CON ESCRITO DE RECONSIDERACIÓN - PRIORIDAD EXTINGUIDA..')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes con escritos de reconsideración - prioridad extinguida, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD CON ESCRITO DE RECONSIDERACIÓN - PRIORIDAD EXTINGUIDA interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2801'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE NEGADA CON RECURSO DE RECONSIDERACIÓN interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 801), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD NEGADA CON RECURSO DE RECONSIDERACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes negadas con recurso de reconsideración, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD NEGADA CON RECURSO DE RECONSIDERACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2802'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de PATENTE DENEGADA CON ESCRITO DE RECONSIDERACIÓN interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 802), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera:  PATENTE DENEGADA CON ESCRITO DE  RECONSIDERACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las patentes denegadas con escrito de reconsideración, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con PATENTE DENEGADA CON ESCRITO DE RECONSIDERACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2804'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE CON ESCRITO DE RECONSIDERACIÓN - PRIORIDAD EXTINGUIDA-PUBLICACIÓN DEFECTUOSA interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 804), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD CON ESCRITO DE RECONSIDERACIÓN - PRIORIDAD EXTINGUIDA-PUBLICACIÓN DEFECTUOSA.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes con escritos de reconsideración - prioridad extinguida-publicación defectuosa, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD CON ESCRITO DE RECONSIDERACIÓN - PRIORIDAD EXTINGUIDA-PUBLICACIÓN DEFECTUOSA  interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2805'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE CON ESCRITO DE RECONSIDERACIÓN / PERENCIÓN DE PROCEDIMIENTO ORDEN DE PUBLICACIÓN EN PRENSA, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 805), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD CON ESCRITO DE RECONSIDERACIÓN / PERENCIÓN DE PROCEDIMIENTO ORDEN DE PUBLICACIÓN EN PRENSA.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes con escritos de reconsideración / perención de procedimiento orden de publicación en prensan, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD CON ESCRITO DE RECONSIDERACIÓN / PERENCIÓN DE PROCEDIMIENTO ORDEN DE PUBLICACIÓN EN PRENSA  interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2806'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de PATENTE ABANDONADA CON ESCRITO DE RECONSIDERACIÓN interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 806), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera:  PATENTE ABANDONADA CON ESCRITO DE RECONSIDERACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las patentes abandonadas con escrito de reconsideración, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con PATENTE ABANDONADA CON ESCRITO DE RECONSIDERACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2809'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE CON ESCRITO DE NULIDAD A LA CONCESION PENDIENTE DE NOTIFICACIÓN, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 809), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD CON ESCRITO DE NULIDAD A LA CONCESION PENDIENTE DE NOTIFICACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes con escritos de nulidad a la concesion pendiente de notificación, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD CON ESCRITO DE NULIDAD A LA CONCESION PENDIENTE DE NOTIFICACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2821'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE EN TRAMITE CON PETICIÓN DE NULIDAD DEL ACTO ADMINISTRATIVO, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 821), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD EN TRAMITE CON PETICIÓN DE NULIDAD DEL ACTO ADMINISTRATIVO.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes en tramite con petición de nulidad del acto administrativo en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD EN TRAMITE CON PETICIÓN DE NULIDAD DEL ACTO ADMINISTRATIVO interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2833'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN - DISPOSICIÓN ADMINISTRATIVA QUE AFECTA EL REGISTRO DE PATENTE, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 833), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RECURSO DE RECONSIDERACIÓN - DISPOSICIÓN ADMINISTRATIVA QUE AFECTA EL REGISTRO.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los recursos de reconsideración - disposición administrativa que afecta el registro, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN - DISPOSICIÓN ADMINISTRATIVA QUE AFECTA EL REGISTRO interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2835'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de PATENTE CON SOLICITUD DE NULIDAD, PENDIENTE DE NOTIFICACIÓN, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 835), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera:  PATENTE CON SOLICITUD DE NULIDAD, PENDIENTE DE NOTIFICACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las  patentes con solicitud de nulidad, pendiente de notificación, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con PATENTE CON SOLICITUD DE NULIDAD, PENDIENTE DE NOTIFICACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2836'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de REGISTRO DE PATENTE CON SOLICITUD DE NULIDAD - NOTIFICADA, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 836), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: REGISTRO CON SOLICITUD DE NULIDAD - NOTIFICADA.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los registros con solicitud de nulidad – notificada, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con REGISTRO CON SOLICITUD DE NULIDAD - NOTIFICADA interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2837'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN – DISPOSICIÓN ADMINISTRATIVA DE NULIDAD DE REGISTRO DE PATENTE, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 838), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RECURSO DE RECONSIDERACIÓN – DISPOSICIÓN ADMINISTRATIVA DE NULIDAD DE REGISTRO.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los recursos de reconsideración – disposición administrativa de nulidad de registro, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN – DISPOSICIÓN ADMINISTRATIVA DE NULIDAD DE REGISTRO interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2838'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de RECURSO DE RECONSIDERACIÓN - DISPOSICIÓN ADMINISTRATIVA DE NULIDAD DE REGISTRO DE PATENTE, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 838), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: RECURSO DE RECONSIDERACIÓN - DISPOSICIÓN ADMINISTRATIVA DE NULIDAD DE REGISTRO.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar los recursos de reconsideración - disposición administrativa de nulidad de registro, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con RECURSO DE RECONSIDERACIÓN - DISPOSICIÓN ADMINISTRATIVA DE NULIDAD DE REGISTRO interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2840'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de SOLICITUD DE PATENTE DESISTIDA CON RECURSO DE RECONSIDERACIÓN, interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 840), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: SOLICITUD DESISTIDA CON RECURSO DE RECONSIDERACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes desistidas con recurso de reconsideración, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con SOLICITUD DESISTIDA CON RECURSO DE RECONSIDERACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2921'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de PATENTE SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD PUBLICADA CON RECURSO DE RECONSIDERACIÓN interpuestos ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 921), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: PATENTE SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD PUBLICADA CON RECURSO DE RECONSIDERACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes negadas con recurso de reconsideración, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con PATENTE SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD PUBLICADA CON RECURSO DE RECONSIDERACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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
while ( $counter <= 1) {

$resultado=pg_exec("SELECT b.solicitud, b.registro, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho, b.poder	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2922'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
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
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Se hace del conocimiento de los usuarios, apoderados, tramitantes, al público en general, y en especial de los interesados en los procedimientos de PATENTE SIN EFECTO POR VENCIMIENTO DE TÉRMINO PUBLICADA CON RECURSO DE RECONSIDERACIÓN interpuestos  ante este Despacho de Registro, las cuales mas adelante se especifican, que con fundamento en los artículos 30 y 53 de la Ley Orgánica de Procedimientos Administrativos; a los fines de depurar los procedimientos administrativos en espera de resolución y con miras a su agilización, deben RATIFICAR por escrito su interés en continuar con la tramitación de los mencionados Recursos (en el Sistema Automatizado de nuestra Base de Datos, se identifican con el estatus interno Nº 922), sin que ello implique la consignación nuevamente de los recaudos concerniente a dichos asuntos.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('A tales fines, se les otorga un plazo de dos (2) meses contados a partir de la vigencia de ésta publicación en el Boletín de la Propiedad Industrial para la Ratificación del Interés de continuar con la tramitación de dichos procedimientos, los mencionados escritos deberán ser titulados de la siguiente manera: PATENTE SIN EFECTO POR VENCIMIENTO DE TÉRMINO PUBLICADA CON RECURSO DE RECONSIDERACIÓN.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De no ratificar las solicitudes con escritos de reconsideración, en el plazo señalado ut-supra, se entenderá que no existe interés procesal administrativo en continuar con los Recursos in comento, y en consecuencia se procederá a declararles la perención del procedimiento, de conformidad con lo dispuesto en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos, por lo que esas decisiones administrativas quedaran firmes.')),0,'J',0);
      $pdf->ln(1); 
      $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De seguidas se emite el listado de las solicitudes con PATENTE SIN EFECTO POR VENCIMIENTO DE TÉRMINO PUBLICADA CON RECURSO DE RECONSIDERACIÓN interpuestas ante este Despacho:')),0,'J',0);
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
       $pdf->ln(8); 
       $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('De la misma manera se deja constancia que una vez vencido el lapso in comento se procederá a resolver cada uno de los casos ratificados en el estricto orden cronológico en el que fueron presentados y/o debidamente notificados en los respectivos Boletines de la Propiedad Industrial, atendiendo al orden de prelación previsto en el Artículo 34 de la Ley Orgánica de Procedimientos Administrativos en concordancia con el Artículo 74 de la Ley de Propiedad Industrial. No significando con ello la apertura o restitución del lapso originario. El objeto de este llamamiento es a los fines de depurar aquellas causas en las cuales se haya perdido el interés legítimo, directo y particular en su continuación, para así proceder como ya se ha señalado a resolver las causas ratificadas siempre en estricto cumplimiento del orden de prelación previsto en la Ley.')),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
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

$vnommar= "boletin_rec"."_".$fechagen."_".$horagen.".pdf";
$pdf->Output("../../boletin/".$vnommar);
$pdf->Output("../respaldoboletin/".$vnommar);

return $nro_resoluc;

}
       
?>
