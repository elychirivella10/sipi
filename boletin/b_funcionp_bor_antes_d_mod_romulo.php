<?php
// *************************************************************************************
// Programa: b_funcionp.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
 function patentes($nbol,$anoi,$anof,$nro_resol,$solip,$fecp_soli,$titp_soli, $concp,$fecp_conc,$titp_conc,$ordep,$fecp_orde,$titp_orden,$devup,$fecp_devu,$titp_devu,$priop,$fecp_prio,$titp_prio,$prio_extep,$fecp_prio_exte, $titp_prio_exte, $prio_defep,$fecp_prio_defe,$titp_prio_defe, $perip, $fecp_peri,$titp_peri,$denep,$fecp_dene,$titp_dene,$desip,$fecp_desi,$titp_desi,$aband,$fecp_aban,$titp_aban, $oposi,$fecp_opos,$titp_opos, $rehab,$fecp_reha,$titp_reha, $titul,$fecp_titu,$titp_titu) {

 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol;
 global $numbol,$pagina,$boletin,$nro_resoluc,$registrador1,$registrador2,$registrador3,$registrador4,$registrador5;
 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol;
 $registrador1= "Castiela Velasquez";
 $registrador2= "Registradora de la Propiedad Industrial";
 //$registrador3= "Designada por el Ciudadano Ministro, Mediante Delegación Contenida";
 $registrador4= "Según Resolución N° 052, Publicada en la Gaceta Oficial de la "; 
 $registrador5= "República Bolivariana de Venezuela No.39.694 de Fecha 13-06-2011"; 

//****************************************************************************************
//Solicitadas de patentes
//****************************************************************************************
if($solip==1) {

//Inicio del Pdf
$pdf=new PDF('P','mm','Letter');
//$pdf=new PDF_Tablebol('P','mm','Letter');
$pdf->Open();
$pdf->AliasNbPages();

// Armando el query segun las opciones
$counter= 1;
$tipo_derecho='A';
$titulo='PATENTES DE INVENCIÓN';

while ( $counter <= 8) {

//Solicitadas 
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, a.resumen
	FROM  stzderec b, stztmpbo c, stppatee a
	WHERE c.estatus='2006'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'  - No se genero Solicitadas '.$titulo;} 
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_soli)),0,'J',0);     $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'SOLICITADAS DE '.utf8_decode($titulo),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DE CONFORMIDAD CONEL ARTÍCULO 60 DE LA LEY DE PROPIEDAD INDUSTRIAL, Y POR CUANTO LOS INTERESADOS HAN CUMPLIDO DE ACUERDO A LA LEY CON LAS ORDENES DE PUBLICACIÓN EN PRENSA QUE SE HICIERA EN EL BOLETÍN DE LA PROPIEDAD INDUSTRIAL CORRESPONDIENTE, SE PROCEDE A PUBLICAR LAS SIGUIENTES SOLICITUDES DE REGISTRO DE PATENTES DE INVENCIÓN. CON EL FIN DE QUIEN TENGA LEGÍTIMO INTERES PUEDA PRESENTAR SUS OPOSICIONES DE ACUERDO A LO ESTABLECIDO EN EL ARTÍCULO 63 DE LA LEY DE PROPIEDAD INDUSTRIAL.'),0,'J',0);
      
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
     // $nameimage=ver_imagen($varsol1,$varsol2,'P');
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
      //Clasificación internacional.
      $clasi="";
      $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
      $regclasf = pg_fetch_array($cons_clas);
      $filas_clasif=pg_numrows($cons_clas); 
      for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
          $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
          $regclasf = pg_fetch_array($cons_clas);      }
      $pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);     
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
        $pais_nombre=pais($res['nacionalidad']);
 	   if ($cont1=='0'){
		$pdf->MultiCell(135,5,'(73)'.'     '.trim($regt['nombre']).'. Domicilio: '.trim($regt['domicilio']).'. Nacionalidad: '.$pais_nombre.',',0,'J',0); }
	   else {$pdf->Getx(25); $pdf->MultiCell(135,5,'    '.'     '.trim($regt['nombre']).'. Domicilio: '.trim($regt['domicilio']).'. Nacionalidad: '.$pais_nombre.';',0,'J',0); }                   
	   $regt = pg_fetch_array($res_titular);
	}       
   
      //Inventores
      $cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
      $reg_inv = pg_fetch_array($cons_inv);
      $filas_cons_inv=pg_numrows($cons_inv);
      $inventores="";
      for($cont_inv=0;$cont_inv<$filas_cons_inv;$cont_inv++) {
         $inventores=$inventores.trim($reg_inv['nombre_inv'])."; ";
         $reg_inv = pg_fetch_array($cons_inv);
      }
      $pdf->Cell(9,5,'(72)'.'     ',0,0);  
      $pdf->MultiCell(135,5,trim($inventores),0,'J',0);  
      //Tramitante o Agente         
      $ind=1;
      $tram = agente_tram($registro['agente'],$registro['tramitante'],$ind);     
      $pdf->MultiCell(135,5,'(74)'.'     '.$tram,0,'J',0);        
      //Titulo de la patente
      $pdf->Cell(9,5,'(54)'.'     ',0,0);  
      $pdf->MultiCell(135,5,utf8_decode(trim($registro['nombre'])),0,'L',0);    
      //Resumen 
      $pdf->Cell(9,5,'(57)'.'     ',0,0);  
      $resumen = utf8_decode(trim($registro['resumen']));
      $pdf->MultiCell(135,5,$resumen,0,'J',0); 

    $registro = pg_fetch_array($resultado);

  }
  
  // Fin de Pagina (Firma del Registrador)
       $pdf->Setfont('Arial','B',12);
        $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

       $pdf->Setfont('Arial','B',8);
       $pdf->ln(6); 
       $pdf->MultiCell(190,5,'Publiquese,',0,'L',0);
       $pdf->ln(20); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);        
       

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='PATENTES DE MEJORAS';}
if($counter==3) { $tipo_derecho='E'; $titulo='PATENTES DE MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='PATENTES DE DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='PATENTES DE DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='PATENTES DE INTRODUCCION';}
if($counter==7) { $tipo_derecho='F'; $titulo='PATENTES DE MODELOS DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='PATENTES DE VARIEDADES VEGETALES';}
}//fin del while

//Salida del Reporte
$pdf->Output("../../boletin/boletin_sol_pat.pdf");        
          
} // fin de solicitadas


//****************************************************************************************
//Inicio del Pdf

//$pdf=new PDF('P','mm','Letter');
$pdf=new PDF_tablebol_bor('P','mm','Letter');
$pdf->Open();
//$pdf->AddPage();
$pdf->AliasNbPages();


//****************************************************************************************
//orden de publicación
//****************************************************************************************
if($ordep==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIONES';
$subpate='invención';

while ( $counter <= 8) {
//Armando el query
  $resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho, b.tramitante, b.agente, b.tipo_derecho
		FROM  stzderec b, stztmpbo c
		WHERE c.boletin = '$boletin'
		AND c.nro_derecho = b.nro_derecho 
		AND c.estatus = '2002'
		AND c.tipo = 'P'
		AND b.tipo_derecho = '$tipo_derecho'
		ORDER BY b.solicitud");
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_orde)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
       $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,utf8_decode('ORDEN DE PUBLICACIÓN EN PRENSA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_orden)),0,'C',0);      
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con el artículo 60 de la Ley de la Propiedad Industrial, se ordena la publicación de las solicitudes de patentes de '.$subpate.', que a continuación se especifican, en los diarios de circulación nacional: VEA o ULTIMAS NOTICIAS. De no realizarse la mencionada publicación en prensa dentro de dos (02) meses a partir de la vigencia del presente Boletín, quedará perimida la solicitud, según lo establecido en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
//      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en el artículo 60 de la Ley de la Propiedad Industrial, se ordena la publicación de las solicitudes de patentes, que a continuación se especifican, en los diarios de circulación nacional: VEA o ULTIMAS NOTICIAS. De no consignarse ante la unidad de receptoria de este Servicio Autónomo de la Propiedad Intelectual y mediante escrito la mencionada publicación en prensa dentro de dos (02) meses a partir de la vigencia del presente Boletín, quedará perimida la solicitud, según lo establecido en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
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
//      $nagen=$registro['agente'];
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
        $tram = agente_tram($registro['agente'],$registro['tramitante'],$ind_agente);	
	$data[3]['TEXT'] = $tram;
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelo de utilidad';}
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
$subpate='invención';

while ( $counter <= 8) {
//Armando el query

$resultado=pg_exec("SELECT b.solicitud,b.nombre,b.nro_derecho,b.agente,b.tramitante, b.tipo_derecho
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2200'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");	
		
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_devu)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTES '.$titulo.' DEVUELTAS POR REQUISITOS ADMINISTRATIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_devu)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de registro de patentes de '.$subpate.', que a continuación se especifican, y por cuanto los interesados no han cumplido con los requisitos legales establecidos dentro del término que señala la Ley, esta oficina de Registro procede a realizar la Devolución por requisitos administrativos de las mismas, según lo preceptuado en el artículo 61 de la Ley de Propiedad Industrial.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_devu['tramitante'],'1');
        $data[3]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_devu = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$totald,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de Devueltas 


//****************************************************************************************
// CONCEDIDAS
//****************************************************************************************
if($concp==1) {
// Armando el query segun las opciones
$counter= 1;
$tipo_derecho='A';
$titulo='PATENTES DE INVENCIÓN';

while ( $counter <= 8) {
//concedidas 
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic,b.fecha_publi	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2101'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho = '$tipo_derecho'
	ORDER BY b.solicitud");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'  - No se genero Concedidas '.$titulo;} 
else { 

// Montando los resultados en el formato boletin solicitadas
      $nro_resoluc = $nro_resoluc+1;
      $pdf->Setfont('Arial','B',20);
      $pdf->MultiCell(190,5,utf8_decode('CONCEDIDAS DE '.$titulo),0,'C',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_conc)),0,'C',0);
      $pdf->Setfont('Arial','',8);          
      $pdf->Setfont('Arial','B',12);
 $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);

      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_soli)),0,'J',0);     $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'CONCEDIDAS DE '.utf8_decode($titulo),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('XXXXXX'),0,'J',0);
      
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
      $pdf->MultiCell(135,5,'(22)'.'     '.$registro['fecha_solic'],0,'J',0); 
      $pdf->MultiCell(135,5,'(11)'.'     '.$boletin.'-'.$varsol1.$varsol2,0,'J',0);
      $pdf->MultiCell(135,5,'(45)'.'     '.$registro['fecha_publi'],0,'J',0); 

      //Titular
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
  		     FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
	for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	   if ($cont1=='0'){
 	      $pdf->MultiCell(135,5,'(73)'.'     '.trim($regt['nombre']).',',0,'J',0); }
	   else {$pdf->Getx(25); $pdf->MultiCell(135,5,'    '.'     '.trim($regt['nombre']).';',0,'J',0); }                
	   $regt = pg_fetch_array($res_titular);
	}       
   
      //Tramitante o Agente         
      $ind=1;
      $tram = agente_tram($registro['agente'],$registro['tramitante'],$ind);     
      $pdf->MultiCell(135,5,'(74)'.'     '.$tram,0,'J',0);         

      //Clasificación internacional.
      $clasi="";
      $cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
      $regclasf = pg_fetch_array($cons_clas);
      $filas_clasif=pg_numrows($cons_clas); 
      for($cont_clai=0;$cont_clai<$filas_clasif;$cont_clai++) { 
          $clasi=$clasi.trim($regclasf['tipo_clas']).'='.trim($regclasf['clasificacion']).'; ';
          $regclasf = pg_fetch_array($cons_clas);      }
      $pdf->MultiCell(135,5,'(51)'.'     '.$clasi,0,'J',0);     
  
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
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Publiquese,',0,'L',0);
       $pdf->ln(20); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
       

} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='PATENTES DE MEJORAS';}
if($counter==3) { $tipo_derecho='E'; $titulo='PATENTES DE MODELO INDUSTRIAL';}
if($counter==4) { $tipo_derecho='G'; $titulo='PATENTES DE DISEÑO INDUSTRIAL';}
if($counter==5) { $tipo_derecho='B'; $titulo='PATENTES DE DIBUJO INDUSTRIAL';}
if($counter==6) { $tipo_derecho='D'; $titulo='PATENTES DE INTRODUCCION';}
if($counter==7) { $tipo_derecho='F'; $titulo='PATENTES DE MODELOS DE UTILIDAD';}
if($counter==8) { $tipo_derecho='V'; $titulo='PATENTES DE VARIEDADES VEGETALES';}
}//fin del while

}//fin de concedidas

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA
//****************************************************************************************
if($priop==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2025'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_prio)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDAD EXTINGUIDA SOLICITUDES DE PATENTES '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_prio)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de Registro de Patentes de '.$subpate.', que a continuación se especifican, y por cuanto los interesados no consignaron en este Despacho, dentro del término que señala la Ley, todos los requisitos legales que le fueron exigidos mediante los respectivos oficios de devolución, se declara Extinguida la Prioridad de las mencionadas solicitudes de Registro de Patentes de '.$subpate.' según lo preceptuado en el artículo 61 de la Ley de Propiedad Industrial.'),0,'J',0);      
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
    //   $pdf->MultiCell(190,5,utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);    
              
 } //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while

}//fin de PRIORIDAD EXTINGUIDA

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA EXTEMPORANEA
//****************************************************************************************
if($prio_extep==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2023'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_prio_exte)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDADES EXTINGUIDAS PUBLICADAS EN PRENSA EXTEMPORANEA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_prio_exte)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de patentes '.$subpate.', que a continuación se especifican; y por cuanto los interesados no cumplieron con los requisitos de presentación contenidos en el Articulo 71 de la Ley de Propiedad Industrial; y en concordancia con el Articulo 75 de la Ley de Propiedad Industrial, este despacho declara la Prioridad Extinguida.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 } //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_prio_defe)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDADES EXTINGUIDAS PUBLICADAS EN PRENSA DEFECTUOSA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_prio_defe)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de patentes '.$subpate.', que a continuación se especifican; y por cuanto los interesados no cumplieron con los requisitos de presentación contenidos en el Articulo 71 de la Ley de Propiedad Industrial; y en concordancia con el Articulo 75 de la Ley de Propiedad Industrial, este despacho declara la Prioridad Extinguida Defectuosa.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(15); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 } //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2030'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_peri)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PERIMIDAS POR NO PUBLICAR EN PRENSA '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_peri)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con el artículo 64 de la Ley Orgánica de Procedimientos Administrativos y por cuanto los interesados no cumplieron de acuerdo a la Ley con las Ordenes de Publicación en Prensa que se hiciera en el Boletín de la Propiedad Industrial correspondiente, se procede a declarar la perención de las siguientes solicitudes de registro de patentes.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2119'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_dene)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTES DENEGADAS '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_dene)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('XXXXXXXXX.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else

 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  DENEGADAS

//****************************************************************************************
//  DESISTIDAS
//****************************************************************************************
if($desip==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2910'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'P'
	AND c.nro_derecho = b.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");
		
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_desi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('SOLICITUDES DE PATENTES DESISTIDAS '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en los Artículos 78 y 79 de la Ley de la Propiedad Industrial, y considerando que los solicitantes no contestaron las observaciones en el lapso legal establecido, se declaran las solicitudes detalladas a continuación como desistidas por disposición de la ley.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_aban)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('ABANDONADAS POR NO SOLICITAR EXAMEN TECNICO '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_aban)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('XXXXXXX.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de  ABANDONADAS

//****************************************************************************************
//  ABANDONADAS X NO PAGO
//****************************************************************************************
if($aband==1) {
$counter= 1;
$tipo_derecho='A';
$titulo='DE INVENCIÓN';
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_aban)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('ABANDONADAS POR NO PAGO '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_aban)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('XXXXXXX.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
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

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Oposiciones '.$titulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_opos)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PATENTES NEGADAS '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_opos)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Se hace del conocimiento de los usuarios e interesados en las solicitudes de patente, que a continuación se señalan, publicadas como solicitadas en el Boletín de la Propiedad Industrial, que deben comparecer por ante este Servicio Autónomo a fin de retirar copia fotostática de el/los escritos de oposición que le fue formuladas a dichas solicitudes, a efectos que se notifiquen y contesten las mismas si lo estimaren conveniente en un lapso de treinta (30) días hábiles, contados a partir de la fecha, de conformidad con el artículo 63 de la Ley de Propiedad Industrial.'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT stzderec.solicitud, stzderec.nro_derecho, stzderec.nombre, stzderec.tramitante, stzderec.agente 
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($$fecp_reha)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REHABILITACION DE PATENTES '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_reha)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('XXXXX'),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);           
 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_desi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PATENTES SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode(   
      'Se le notifica a los interesados y/o solicitantes, a fin de dar cumplimiento a lo establecido en el artículo 18 de la Ley de Propiedad Industrial, que las solicitudes de registro que a continuación se detallan, no consignaron el pago de las anualidades establecido en el artículo 49 iusdem, por lo que esta Oficina Registral, declara que las mismas han quedado sin efecto, de conformidad con lo establecido en el artículo 17 literal "d", de la misma ley, en vista que los solicitantes no hicieron uso del Derecho de Rehabilitación, regulado por el artículo 19 de la Ley de Propiedad Industrial, las patentes señaladas se declaran de dominio público.'
      ),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else
 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
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
$subpate='invención';
while ( $counter <= 8) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, b.tipo_derecho	
	FROM  stzderec b, stztmpbo c
	WHERE c.estatus='2918'
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
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fecp_desi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PATENTES SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD '.$titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($titp_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode(   
      'Se le notifica a los interesados y/o solicitantes, a fin de dar cumplimiento a lo establecido en el artículo 18 de la Ley de Propiedad Industrial, que las solicitudes de registro que a continuación se detallan, no consignaron el pago de las anualidades establecido en el artículo 49 iusdem, por lo que esta Oficina Registral, declara que las mismas han quedado sin efecto, de conformidad con lo establecido en el artículo 17 literal "d", de la misma ley, en vista que los solicitantes no hicieron uso del Derecho de Rehabilitación, regulado por el artículo 19 de la Ley de Propiedad Industrial, las patentes señaladas se declaran de dominio público.'
      ),0,'J',0);
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
	      $titular= $titular.trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'. Nacionalidad: '.trim($pais_nombre).'. Domicilio: '.trim($regt['domicilio']); }                
	      	 $regt = pg_fetch_array($res_titular);
	}  
	$data[2]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       $pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         
 }//fin del else
 
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='C'; $titulo='DE MEJORAS'; $subpate='mejoras';}
if($counter==3) { $tipo_derecho='E'; $titulo='DE MODELO INDUSTRIAL'; $subpate='modelo industrial';}
if($counter==4) { $tipo_derecho='G'; $titulo='DE DISEÑO INDUSTRIAL'; $subpate='diseño industrial';}
if($counter==5) { $tipo_derecho='B'; $titulo='DE DIBUJO INDUSTRIAL'; $subpate='dibujo industrial';}
if($counter==6) { $tipo_derecho='D'; $titulo='DE INTRODUCCION'; $subpate='introducción';}
if($counter==7) { $tipo_derecho='F'; $titulo='DE MODELOS DE UTILIDAD'; $subpate='modelos de utilidad';}
if($counter==8) { $tipo_derecho='V'; $titulo='DE VARIEDADES VEGETALES'; $subpate='variedades vegetales';}
}//fin del while 

}//fin de Sin Efecto por falta de pago 


// falta Titulos de Patentes (no existen en la base de datos los eventos para que carguen los titulos)

//Salida del Reporte
echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'> $mensaje</p></H3>"; 

$pdf->Output("../../boletin/boletin_pat.pdf");

return $nro_resoluc;

}
       
?>
