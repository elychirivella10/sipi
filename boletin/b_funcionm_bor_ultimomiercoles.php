<?php
// *************************************************************************************
// Programa: b_funcionm.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
 function marcas($nbol,$anoi,$anof,$nro_resol,$soli,$fec_soli,$conc,$fec_conc,$tit_conc,$orde,$fec_orde,$tit_orden,$devu,$fec_devu,$tit_devu,$obse,$fec_obse,$tit_obse,$obse_scon,$prio,$fec_prio,$tit_prio,$prio_exte,$fec_prio_exte, $tit_prio_exte, $prio_defe,$fec_prio_defe,$tit_prio_defe, $peri, $fec_peri,$tit_peri,$cadu,$fec_cadu,$tit_cadu,$desi,$fec_desi,$tit_desi,$desi_mejo,$fec_desi_mejo,$tit_desi_mejo, $desi_ley,$fec_desi_ley,$tit_desi_ley,$cadu_nren, $fec_cadu_nren,$tit_cadu_nren, $regi,$fec_regi, $tit_regi, $devu_scon,$desi_anom,$fec_desi_anom, $tit_desi_anom, $devo_regi,$fec_devo_regi,$tit_devo_regi,$rein_devam,$fec_rein_devam,$tit_rein_devam, $nega,$fec_nega,$tit_nega,$cert,$fec_cert, $tit_cert,$anot, $fec_anot, $tit_anot, $desi_obse, $fec_desi_obse, $tit_desi_obse,$noti,$fec_noti,$tit_noti) {

 $boletin = $nbol;
 $numbol = $boletin;
 global $numbol,$pagina,$boletin,$nro_resoluc,$registrador1,$registrador2,$registrador3,$registrador4;
 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol-1;
 $registrador1= "MARIA ALEJANDRA MEDINA MAZARELLI";
 $registrador2= "Registradora de la Propiedad Industrial (E)";
 $registrador3= "Resolución N° DM/N· 088'";
 $registrador4= "Gaceta Oficial No.39.520 de Fecha 29-09-2010"; 


//****************************************************************************************
//Solicitadas de marcas
//****************************************************************************************
if($soli==1) {

class PDF extends PDF_Rotate
{
function Header()
{
     global $title,$pagina,$numbol;
     $this->SetFont('Arial','I',8);
     $this->SetTextColor(128);
     $this->SetY(10);
     $this->Cell(0,5,utf8_decode('Boletín de la Propiedad Industrial'.'                                                                                                                                                                           No. '.$numbol),0,0,'J');
     $this->SetY(8);
  //   $this->Cell(0,5,'______________________________________________________________________________________________________________________',0,1,'J');
      $this->SetFont('Arial','B',8);
      $w=$this->GetStringWidth($title)+6;
      $this->SetX((210-$w)/2);
 //   $this->Cell($w,2,$this->PageNo(),0,1,'C',0);
      $this->Ln(10);
      //Guardar ordenada
      $this->y0=$this->GetY();




	//Put the watermark
	$this->SetFont('Arial','B',90);
	$this->SetTextColor(255,192,203);
	$this->RotatedText(35,190,'BORRADOR',45);
//	$this->RotatedText(35,190,'BORRADOR',45);
}

function RotatedText($x, $y, $txt, $angle)
{
	//Text rotated around its origin
	$this->Rotate($angle,$x,$y);
	$this->Text($x,$y,$txt);
	$this->Rotate(0);
}
}
//Inicio del Pdf
$pdf=new PDF('P','mm','Letter');
//$pdf=new PDF_Tablebol('P','mm','Letter');
$pdf->Open();
$pdf->AliasNbPages();

// Armando el query segun las opciones
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, b.fecha_solic, a.modalidad,a.clase, a.distingue 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1006'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.'* No se genero Solicitadas  ';} 
      $pdf->AddPage();
// Montando los resultados en el formato boletin solicitadas
      $nro_resoluc = $nro_resoluc+1;
      $pdf->Setfont('Arial','B',20);
      $pdf->MultiCell(190,5,utf8_decode('MARCAS SOLICITADAS'),0,'C',0);
      $pdf->ln(6); 
     // $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_soli)),0,'J',0);     $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,'MARCAS COMERCIALES SOLICITADAS',0,'C',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Esta Autoridad Administrativa, en cumplimiento a lo establecido en los articulos 76 y 77 de la Ley de Propiedad Industrial, una vez cumplidos los requisitos de Ley ordena la publicación en el Boletín: de marcas comerciales, denominaciones comerciales y lemas comerciales solicitadas; a los efectos de que los interesados presenten sus observaciones, en un lapso de treinta (30) días hábiles a la publicación del presente Boletín, de acuerdo a lo establecido en el artículo 77.'),0,'J',0);
     
   for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      $modalidad= $registro['modalidad'];
      $x = $pdf->Getx();
      $y = $pdf->Gety();
      if ($y >= 245) {  $pdf->AddPage(); }
       $pdf->Setfont('Arial','B',12);
       $pdf->MultiCell(190,4,'_______________________________________________________________________________',0,'J',0);
       $pdf->Setfont('Arial','B',8);
            
      $pdf->MultiCell(135,4,'Insc. '. $registro['solicitud'].' del '.Cambiar_fecha_mes($registro['fecha_solic']),0,'J',0);
       $pdf->Setfont('Arial','',8);
      if ($modalidad == 'M') { //Nombre de la marca en caso de que sea mixta
         $pdf->MultiCell(135,4,'NOMBRE: '.trim(utf8_decode($registro['nombre'])),0,'J',0); 	 
      } 
                     
    	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	

         $texto= $pdf->Setfont('Arial','B',8)."SOLICITADA POR: ".$pdf->Setfont('Arial','',9);
         $y = $pdf->Gety(); 
         $pdf->MultiCell(135,4,$texto.utf8_decode($titular),0,'J',0); 


            //imagen
		$varsol1=substr($nsolic,-11,4);
		$varsol2=substr($nsolic,-6,6);
		$nameimage=ver_imagen($varsol1,$varsol2,'M');

		if (file($nameimage)) {   
		   $x = $pdf->Getx();
                   $y = $pdf->Gety();
		   if ($y >= 240) {
		       $pdf->AddPage();
	               $pdf->Image("$nameimage",160,15,26,24,'JPG');
                       $y = $pdf->Gety(); 	
                       $pdf->SetXY($x,$y+5); 		 
                       }
                   else{	
                       $pdf->Image("$nameimage",160,$y,26,24,'JPG');
                       $y = $pdf->Gety(); 	
                       $pdf->SetXY($x,$y+12); 
		   
                       }
                   
		}
                else {	
   		   $pdf->Setfont('Arial','B',8);
   		   $numbol = $nbol;
   		   $x = 150;
   		   $y = $pdf->Gety(); 
   		   $pdf->SetXY(150,$y+1);
    	           $pdf->MultiCell(50,4,trim(utf8_decode($registro['nombre'])),0,'C',0);  
	           $pdf->Setfont('Arial','',8);
   	        } 
   	
   	//busqueda del distingue
	$pdf->Setfont('Arial','',8);
        $pdf->MultiCell(135,4,'PARA DISTINGUIR: '.trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$registro['clase'],0,'J',0);
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
	$pdf->MultiCell(135,4,'TRAMITANTE: '. trim(utf8_decode($tram)),0,'J',0); 
 
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
       $pdf->MultiCell(190,5,'Publiquese,',0,'L',0);
       $pdf->ln(20); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
       
       
//Salida del Reporte
$pdf->Output("../../boletin/boletin_sol.pdf");        
          
} // fin de solicitadas

//Inicio del Pdf


//$pdf=new PDF('P','mm','Letter');
$pdf=new PDF_tablebol_bor('P','mm','Letter');
$pdf->Open();
//$pdf->AddPage();
$pdf->AliasNbPages();

//****************************************************************************************
//orden de publicación
//****************************************************************************************
if($orde==1) {
//Inicio del Pdf
//$pdf=new PDF_Tablebol('P','mm','Letter');
//$pdf->Open();
//$pdf->AddPage();
//$pdf->AliasNbPages();
//Armando el query
  $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stmmarce.clase, stzderec.nro_derecho
		FROM  stmmarce, stztmpbo, stzderec
		WHERE stztmpbo.boletin = '$boletin'
		AND stztmpbo.nro_derecho = stzderec.nro_derecho 
		AND stzderec.nro_derecho = stmmarce.nro_derecho 
		AND stzderec.estatus = '1002'
		AND stztmpbo.tipo = 'M'
		ORDER BY stzderec.solicitud");
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$cantreg=$filas_resultado;
$total=$filas_resultado;

if ($filas_resultado==0) {$mensaje= $mensaje.' - No se genero Orden de Publicación  ';} else {
     $pdf->AddPage();
// Montando los resultados en el formato boletin orden de publicacion
      $nro_resoluc = $nro_resoluc+1;
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_orde)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->ln(4); 
       $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,utf8_decode('ORDEN DE PUBLICACIÓN EN PRENSA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_orde)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en el artículo 76 de la Ley de la Propiedad Industrial, se ordena la publicación de las marcas comerciales, denominaciones comerciales y lemas comerciales, que a continuación se especifican en los diarios de circulación nacional: VEA o ULTIMAS NOTICIAS. La mencionada publicación en prensa se efectuara dentro de dos (02) meses a partir de la vigencia del presente Boletín, quedará perimida la solicitud, según lo establecido en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
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
		$header_type[$i]['WIDTH'] = 22;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE ");
		$header_type[$i]['WIDTH'] = 75;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 76;

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
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	
	
	$data[3]['TEXT'] = utf8_decode($titular);	

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

}//fin del else
}// fin de orden de publicacion

//****************************************************************************************
//  Devueltas  x forma 
//****************************************************************************************
if($devu==1) {

$resultado=pg_exec("SELECT b.solicitud,b.nombre,b.nro_derecho,b.agente,b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1200'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");	

		
$registro_devu = pg_fetch_array($resultado);
$filas_resultadod=pg_numrows($resultado); 
$cantreg=$filas_resultadod;
$totald=$filas_resultadod;

if ($filas_resultadod==0) {$mensaje= $mensaje.' - No se genero Devueltas de Forma';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_devu)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DEVUELTAS DE FORMA POR REQUISITOS MINIMOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_devu)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de Marcas Comerciales, Nombres Comerciales y Lemas Comerciales, que a continuación se especifican, y por cuanto los interesados no cumplieron con los Requisitos formales de presentación, se devuelven dichas solicitudes a fin de que se de cumplimiento a lo exigido  en los correspondientes oficios de devolución dentro de un lapso de treinta (30) días hábiles contados a partir de la fecha, de conformidad con lo establecido en el Artículo 75 de la Ley de Propiedad Industrial; de no darse cumplimiento a la contestación se procederá a declarar la Prioridad Extinguida.'),0,'J',0);
      $pdf->ln(4); 
      
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
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultadod;$cont++) { 
      $nsolic=$registro_devu['solicitud'];
      $nagen=$registro_devu['agente'];
      $nderec=$registro_devu['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_devu['solicitud'];
	$data[1]['TEXT'] = $registro_devu['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_devu['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_devu['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

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
 }//fin del else

}//fin de Devueltas 


//****************************************************************************************
//  Observadas
//****************************************************************************************
if($obse==1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1003'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");	
		
$registro_obse = pg_fetch_array($resultado);
$filas_resultado_obse=pg_numrows($resultado); 
$cantreg=$filas_resultado_obse;
$total_obse=$filas_resultado_obse;

if ($filas_resultado_obse==0) {$mensaje= $mensaje.' - No se genero Observadas';} else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_obse)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('OBSERVADAS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_obse)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Se hace del conocimiento de los interesados y/o apoderados en las solicitudes del Registro de las Marcas Comerciales, Denominaciones Comerciales y Lemas Comerciales  que a continuación se señalan publicadas como solicitadas en los boletines de la Propiedad Industrial, que deben comparecer  por ante este Servicio Autónomo a fin de retirar la copia fotostática de escrito(s) de oposición(es),  que le fue formulada  a dicha  solicitud, a efectos de "Informarse de aquella en el plazo de quince días hábiles a contar desde la publicación" y contestar "Vencido dicho plazo comenzará a correr un lapso de quince días hábiles para que el solicitante aduzca lo que estime conveniente a sus derechos".  Contados a partir de la fecha de vigencia del presente Boletín, de conformidad con el Artículo 78 de la Ley de Propiedad Industrial.'),0,'J',0);
      $pdf->ln(4); 
      
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
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_obse['solicitud'];
	$data[1]['TEXT'] = $registro_obse['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_obse['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_obse['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

        $registro_obse = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
  
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_obse,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de Observadas


//****************************************************************************************
//OBSERVADAS SIN CONTESTACION DESISTIDAS X LEY (SEGUN ROMULO SON LAS DESISTIDAS X LEY)
//****************************************************************************************
//****************************************************************************************
//  DESISTIDAS X LEY
//****************************************************************************************
if($desi_ley==1) {
$nro_resoluc = $nro_resoluc+1;
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1914'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Desistidas de Observacion por Ley';} 
else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_ley)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DESISTIDAS POR MEJOR DERECHO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_ley)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en los Artículos 78 y 79 de la Ley de la Propiedad Industrial, y considerando que los solicitantes no contestaron las observaciones en el lapso legal establecido, se declaran las solicitudes detalladas a continuación como desistidas por disposición de la ley.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(10); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  DESISTIDAS X LEY



//****************************************************************************************
// CONCEDIDAS
//****************************************************************************************
if($conc==1) {
$counter= 1;
$estatus=1101;
$tipo_derecho='M';
$indrec==0;
$titulo='MARCAS COMERCIALES CONCEDIDAS DE PRODUCTOS';
while ( $counter <= 12) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante,a.clase
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='$estatus'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	AND b.tipo_derecho= '$tipo_derecho' 
	ORDER BY b.solicitud");	
		
$registro_conc = pg_fetch_array($resultado);
$filas_resultadoc=pg_numrows($resultado); 
$cantreg=$filas_resultadoc;
$totalc=$filas_resultadoc;

if ($filas_resultadoc==0) {$mensaje= $mensaje.'  - No se genero Concedidas de '.$titulo;} else {     $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_conc)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode($titulo),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_conc)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Cumplidos como han sido los extremos legales exigidos, este despacho acuerda el registro de '.$titulo.' que a continuación se mencionan.'),0,'J',0);
      $pdf->ln(4); 

//si no son reclasificadas
if ($indrec==0){
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
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultadoc;$cont++) { 
      $nsolic=$registro_conc['solicitud'];
      $nagen=$registro_conc['agente'];
      $nderec=$registro_conc['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_conc['solicitud'];
	$data[1]['TEXT'] = $registro_conc['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_conc['nombre']));
	
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
			
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_conc['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_conc = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
}
//si son reclasificadas
if ($indrec==1){	
$pdf->Table_Init(6);
//set table style
$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (255,255,255) ,
						'BRD_SIZE' => 0
					));

//set header style
$header_type = array(			0=>array(
				'WIDTH' => 15,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'SOLICITUD',
			   ),
			1=>array(
				'WIDTH' => 15,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'CLASE(N)',
				),
			2=>array(
				'WIDTH' => 60,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'NOMBRE',
				),
			3=>array(
				'WIDTH' => 50,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'TITULAR',
				),
			4=>array(
				'WIDTH' => 40,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'TRAMITANTE',
				),
			5=>array(
				'WIDTH' => 15,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => 'B',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.4,
				'BRD_TYPE' => '1',
				'TEXT' => 'CLASE(I)',
				)
);
	  
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = array (
		0=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		1=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'C',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		2=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		3=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		4=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			),
		5=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 7,
			'T_FONT' => 'Arial',
			'T_ALIGN' => 'L',
			'T_TYPE' => '',
			'LN_SIZE' => 4,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.5,
			'BRD_TYPE' => '1',
			)
);

$pdf->Set_Data_Type($data_type);
//draw the first header
$pdf->Draw_Header();
$tsize = 6;
$rr = 255;
//Dibujando la Tabla para el pdf
 for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	

      $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro['solicitud'];
	$data[1]['TEXT'] = $registro['clase'];
	$data[2]['TEXT'] = trim($registro['nombre']);
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = $titular;

	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
        
        $blanco='';
	$data[5]['TEXT'] = $blanco;
	$registro = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }
  
}       
   // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$totalc,0,'J',0);
       $pdf->Setfont('Arial','B',8);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(25); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 
} //fin del else si no hay resultado (filas_resultado)
$counter = $counter + 1; 
if($counter==2) { $tipo_derecho='N'; $titulo='MARCAS COMERCIALES CONCEDIDAS DE NOMBRES';}
if($counter==3) { $tipo_derecho='L'; $titulo='MARCAS COMERCIALES CONCEDIDAS DE LEMAS';}
if($counter==4) { $tipo_derecho='S'; $titulo='MARCAS COMERCIALES CONCEDIDAS DE SERVICIOS';}
if($counter==5) { $tipo_derecho='C'; $titulo='MARCAS COMERCIALES CONCEDIDAS COLECTIVAS';}
if($counter==6) { $tipo_derecho='D'; $titulo='MARCAS COMERCIALES CONCEDIDAS DENOMINACIÓN DE ORIGEN';}
if($counter==7) { $tipo_derecho='M'; $estatus=1390; $indrec=1; $titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS DE PRODUCTOS';}
if($counter==8) { $tipo_derecho='N'; $estatus=1390; $indrec=1; $titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS DE NOMBRES';}
if($counter==9) { $tipo_derecho='L'; $estatus=1390; $indrec=1; $titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS DE LEMAS'; }
if($counter==10) { $tipo_derecho='S'; $estatus=1390; $indrec=1; $titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS DE SERVICIOS';}
if($counter==11) { $tipo_derecho='C'; $estatus=1390; $indrec=1; $titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS COLECTIVAS';}
if($counter==12) { $tipo_derecho='D'; $estatus=1390; $indrec=1; $titulo='RECLASIFICADAS MARCAS COMERCIALES CONCEDIDAS DENOMINACIÓN DE ORIGEN'; }


}//fin del while

}//fin de concedidas

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA
//****************************************************************************************
if($prio==1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre, b.nro_derecho, b.agente, b.tramitante, a.clase 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1025'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Prioridades Extinguidas';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_prio)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDAD EXTINGUIDA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_prio)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de Marcas Comerciales, Denominacion Comercial y Lemas Comerciales que a continuación se especifican; y por cuanto los interesados no cumplieron con los requisitos de presentación contenidos en el Articulo 71 de la Ley de Propiedad Industrial; y en concordancia con el Articulo 75 de la Ley de Propiedad Industrial, este despacho declara la Prioridad Extinguida.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
 }//fin del else

}//fin de PRIORIDAD EXTINGUIDA

//****************************************************************************************
//  PRIORIDAD EXTINGUIDA EXTEMPORANEA
//****************************************************************************************
if($prio_exte==1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1023'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_obse=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Prioridades Extinguidas Extemporaneas';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_prio_exte)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDAD EXTINGUIDA EXTEMPORANEA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_prio_exte)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas  las solicitudes de marcas comerciales, denominaciones comerciales y lemas comerciales que a continuación se especifican, y por cuanto los interesados no consignaron en el plazo establecido por ley, este Despacho declara, en virtud del articulo 41  de la Ley Orgánica de Procedimientos Administrativos, la extemporaneidad de la consignación de la publicación en prensa  de las solicitudes que se relacionan a continuación.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de PRIORIDAD EXTINGUIDA EXTEMPORANEA


//****************************************************************************************
//  PRIORIDAD EXTINGUIDA DEFECTUOSA
//****************************************************************************************
if($prio_defe==1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1024'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Prioridades Extinguidas Defectuosa';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_prio_defe)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PRIORIDAD EXTINGUIDA DEFECTUOSA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_prio_defe)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes que a continuación se especifican; y por cuanto los interesados no cumplieron con los requisitos de presentación contenidos en el Articulo 71 de la Ley de Propiedad Industrial; y en concordancia con el Articulo 75 de la Ley de Propiedad Industrial, este despacho declara la Prioridad Extinguida.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(8); 
       $pdf->Setfont('Arial','',8);
       $pdf->MultiCell(190,5,utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
       $pdf->ln(5); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de PRIORIDAD EXTINGUIDA DEFECTUOSA


//****************************************************************************************
//  PERIMIDAS POR NO PUBLICACION EN PRENSA
//****************************************************************************************
if($peri==1) {

$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase 	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1030'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Perimidas por no Publicación en Prensa';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_peri)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('PERIMIDAS POR NO PUBLICAR EN PRENSA'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_peri)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vistas las solicitudes de marcas comerciales, denominaciones comerciales y lemas comerciales que a continuación se especifican, y por cuanto los interesados no cumplieron con la consignación de la publicación en prensa ante el Registro de la Propiedad Industrial; Este Despacho declara la Perención de las presentes solicitudes, de acuerdo a lo establecido en el artículo 64 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

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
 }//fin del else

}//fin de  PERIMIDAS POR NO PUBLICACION EN PRENSA


//****************************************************************************************
//  CADUCAS
//****************************************************************************************
if($cadu==1) {
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1750'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Caducas';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_cadu)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('MARCAS CADUCAS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_cadu)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Por cuanto las solicitudes de Marcas Comerciales, Denominaciones Comerciales y Lemas Comerciales, que a continuación se especifican, publicadas en Boletin de la Propiedad Industrial, no consignaron dentro del plazo legalmente establecido los derechos de Registros correspondientes, esta oficina de Registro declara la Caducidad de las mismas, de conformidad con lo dispuesto en el artículo 83 de la Ley de la Propiedad Industrial.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
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
       $pdf->MultiCell(190,5,utf8_decode('Se notifica a los interesados que podrán ejercer contra el presente acto administrativo el recurso de reconsideración por ante este Despacho dentro de los quinces (15) días hábiles siguientes, a partir de la fecha de la publicación del Boletín de la Propiedad Industrial de conformidad a lo establecido en el artículo 94 de la Ley Orgánica de Procedimientos Administrativos.'),0,'J',0);
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  CADUCAS


//****************************************************************************************
//  DESISTIDAS
//****************************************************************************************
if($desi==1) {
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1910'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Desistidas';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DESISTIDAS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en los Artículos 78 y 79 de la Ley de la Propiedad Industrial, y considerando que los solicitantes no contestaron las observaciones en el lapso legal establecido, se declaran las solicitudes detalladas a continuación como desistidas por disposición de la ley.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  DESISTIDAS


//****************************************************************************************
//  DESISTIMIENTO DE OBSERVACIONES
//****************************************************************************************
if($desi_obse==1) {
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1125'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Desistimiento de Observaciones';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12); 
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

      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DESISTIMIENTO DE OBSERVACIONES'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en los Artículos 78 y 79 de la Ley de la Propiedad Industrial, y considerando que los solicitantes no contestaron las observaciones en el lapso legal establecido, se declaran las solicitudes detalladas a continuación como desistidas por observaciones.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  DESISTIMIENTO DE OBSERVACIONES

//****************************************************************************************
//  DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO
//****************************************************************************************
if($desi_mejo==1) {
$resultado=pg_exec("SELECT b.solicitud, b.nombre,b.nro_derecho,b.agente, b.tramitante, a.clase	
	FROM  stmmarce a, stzderec b, stztmpbo c
	WHERE c.estatus='1130'
    	AND c.boletin = '$boletin'
   	AND c.tipo = 'M'
	AND c.nro_derecho = b.nro_derecho 
	AND c.nro_derecho = a.nro_derecho 
	ORDER BY b.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Desistidas de Observacion por Mejor Derecho';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_mejo)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DESISTIDAS POR MEJOR DERECHO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_mejo)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('De conformidad con lo establecido en los Artículos 78 y 79 de la Ley de la Propiedad Industrial, y considerando que los solicitantes no contestaron las observaciones en el lapso legal establecido, se declaran las solicitudes detalladas a continuación como desistidas por disposición de la ley.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
		
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  DESISTIMIENTO POR mejor derecho



//****************************************************************************************
//   NEGADAS
//****************************************************************************************
if($nega==1) {
$counter = 1;
$articulo = 27;
$titulo='Articulo 27';
while ( $counter <= 3) {

$resultado=pg_exec("SELECT stmmarce.clase,stztmpbo.solicitud, stmliaor.*,stzderec.tramitante, stzderec.agente, stzderec.nombre
			FROM stmmarce,stmliaor, stztmpbo, stzderec
			WHERE stztmpbo.estatus = '1102'
			AND stztmpbo.boletin = '$boletin'
			AND stztmpbo.tipo = 'M'
			AND stmliaor.articulo = '$articulo'
			AND stmmarce.nro_derecho = stztmpbo.nro_derecho
			AND stztmpbo.nro_derecho = stmliaor.nro_derecho
			AND stztmpbo.nro_derecho = stzderec.nro_derecho
			ORDER BY stztmpbo.solicitud");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Negadas'.$articulo;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_nega)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_nega)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Negadas.'.$articulo),0,'J',0);
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
		$header_type[$i]['WIDTH'] = 20;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCA ");
		$header_type[$i]['WIDTH'] = 85;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DEL TITULAR ");
		$header_type[$i]['WIDTH'] = 72;
		
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
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
	$pdf->Draw_Data($data);
	$x = $pdf->Getx();
	$y = $pdf->Gety();	
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
     	$pdf->MultiCell(180,5,'Tramitante: '. trim(utf8_decode($tram)),0,'J',0);
	
	//verificando si debe ir registros negantes
        if (($registro_prio['literal']== '11') or  ($registro_prio['literal']== '12'))         
         {
	   //Registros Negantes 
	   $reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.nombre, stmmarce.clase FROM stzderec, stmmarce WHERE registro='$registro_prio[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   
           $reg = pg_fetch_array($reg_neg);
           $regneg=trim($registro_prio['reg_base']);
           if (!empty($regneg)){
       	   //busqueda del titular y sus datos
	   $titular_neg='';
  	   $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
				   FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	   $filas_found1=pg_numrows($res_titular);
	   $regt = pg_fetch_array($res_titular);
	   for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	      if ($cont1=='0'){
	         $titular_neg= $titular_neg.trim($regt['nombre']); }
	      else { $titular_neg= $titular_neg."; ".trim($regt['nombre']); }                
	      $regt = pg_fetch_array($res_titular);
	   } 
           $pdf->MultiCell(180,5,'Registros Negantes: '.$registro_prio['reg_base'].' Clase: '.$reg['clase'].'  '.utf8_decode(trim($reg['nombre'])).' Titular: '.utf8_decode($titular_neg),0,'J',0);
	 }
        }
	else {
	//comentario
	 $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro_prio[nro_derecho]' and evento='1225' ");   
	$reg_com = pg_fetch_array($reg_com);
	//$pdf->Cell($x+10,5,'Registros Negantes: ',0,0);
        $pdf->MultiCell(180,5,'Comentario: '.trim($reg_com['comentario']),0,1);	
        }
        $pdf->ln(4); 
	$registro_prio = pg_fetch_array($resultado);

  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(10); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 

 }//fin del else

$counter = $counter + 1; 
if($counter==2) { $articulo= 28; $titulo='Articulo 28';}
if($counter==3) { $articulo= 35; $titulo='Articulo 35';}

}//fin del while

// NEGADAS PARA ARTICULOS 33 Y 34
$articulo = 33;
$titulo='Articulo 33';
$counter=1;
while ( $counter <= 2) {
if ($articulo == 33) { $tope = 12;}
if ($articulo == 34) { $tope = 2;}

for($contl=1;$contl<$tope;$contl++) { 
$resultado=pg_exec("SELECT stmmarce.clase,stztmpbo.solicitud, stmliaor.*,stzderec.tramitante, stzderec.agente, stzderec.nombre
			FROM stmmarce,stmliaor, stztmpbo, stzderec
			WHERE stztmpbo.estatus = '1102'
			AND stztmpbo.boletin = '$boletin'
			AND stztmpbo.tipo = 'M'
			AND stmliaor.articulo = '$articulo'
			AND stmliaor.literal = '$contl'
			AND stmmarce.nro_derecho = stztmpbo.nro_derecho
			AND stztmpbo.nro_derecho = stmliaor.nro_derecho
			AND stztmpbo.nro_derecho = stzderec.nro_derecho
			ORDER BY stztmpbo.solicitud");

$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Negadas de Articulo '.$articulo.' Literal '.$contl;} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_nega)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_nega)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Negadas '.' Articulo '.$articulo.' Literal '.$contl),0,'J',0);
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
		$header_type[$i]['WIDTH'] = 20;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCA ");
		$header_type[$i]['WIDTH'] = 85;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DEL TITULAR ");
		$header_type[$i]['WIDTH'] = 72;
		
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
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['solicitud'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	$data[3]['TEXT'] = utf8_decode($titular);	
	$pdf->Draw_Data($data);
	$x = $pdf->Getx();
	$y = $pdf->Gety();	
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
     	$pdf->MultiCell(180,5,'Tramitante: '. trim(utf8_decode($tram)),0,'J',0);
	
	//verificando si debe ir registros negantes
        if (($registro_prio['literal']== '11') or  ($registro_prio['literal']== '12'))         
         {
	   //Registros Negantes 
	   $reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.nombre, stmmarce.clase FROM stzderec, stmmarce WHERE registro='$registro_prio[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   
           $reg = pg_fetch_array($reg_neg);
           $regneg=trim($registro_prio['reg_base']);
           if (!empty($regneg)){
       	   //busqueda del titular y sus datos
	   $titular_neg='';
  	   $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
				   FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	   $filas_found1=pg_numrows($res_titular);
	   $regt = pg_fetch_array($res_titular);
	   for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
 	      if ($cont1=='0'){
	         $titular_neg= $titular_neg.trim($regt['nombre']); }
	      else { $titular_neg= $titular_neg."; ".trim($regt['nombre']); }                
	      $regt = pg_fetch_array($res_titular);
	   } 
           $pdf->MultiCell(180,5,'Registros Negantes: '.$registro_prio['reg_base'].' Clase: '.$reg['clase'].'  '.utf8_decode(trim($reg['nombre'])).' Titular: '.utf8_decode($titular_neg),0,'J',0);
	 }
        }
	else {
	//comentario
	 $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro_prio[nro_derecho]' and evento='1225' ");   
	$reg_com = pg_fetch_array($reg_com);
	//$pdf->Cell($x+10,5,'Registros Negantes: ',0,0);
        $pdf->MultiCell(180,5,'Comentario: '.trim($reg_com['comentario']),0,1);	
        }
        $pdf->ln(4); 
	$registro_prio = pg_fetch_array($resultado);

  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(10); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 

 }//fin del else
}// fin del primer for 
$counter = $counter + 1; 
if($counter==2) { $articulo= 34; $titulo='Articulo 34';}
}//fin del while

}//fin de  NEGADAS


//****************************************************************************************
//  CERTIFICADOS ELABORADOS
//****************************************************************************************
if($cert==1) {
$resultado=pg_exec("select DISTINCT ON(a.registro) a.nro_derecho,a.solicitud,a.registro,b.clase,trim(a.nombre) as marca,trim(d.nombre) as titular,c.documento, e.domicilio, e.nacionalidad
from stzderec a,stmmarce b,stzevtrd c,stzsolic d,stzottid e,stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1563' and 
      c.evento = '1838' and
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = c.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular");
			   		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Certificados Elaborados';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_cert)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('CERTIFICADOS DE REGISTROS DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_mejo)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Dando cumplimiento a lo establecido en el artículo 86 de la Ley de Propiedad Industrial, se le notifica a los titulares de los Certificados de Marcas y otros signos distintivos concedidos en diversos boletines relacionados a continuación, que los mismos podran ser retirados por ante el Registro de la Propiedad Industrial.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 5 columns
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITUD ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 18;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LA MARCA ");
		$header_type[$i]['WIDTH'] = 65;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 55;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("DOC ");
		$header_type[$i]['WIDTH'] = 12;

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

        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['solicitud'];
	$data[2]['TEXT'] = $registro_prio['clase'];
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[4]['TEXT'] = trim(utf8_decode($registro_prio['titular'])).'. Nacionalidad: '.trim(utf8_decode($registro_prio['nacionalidad']).'. Domicilio: '.trim(utf8_decode($registro_prio['domicilio'])).'. ');
	//$data[4]['TEXT'] =  trim(utf8_decode($registro_prio['titular']));
        $data[5]['TEXT'] = $registro_prio['documento']; 

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
      // $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
    //   $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  CERTIFICADOS ELABORADOS


//****************************************************************************************
//  NOTIFICACION DE CANCELACION POR FALTA DE USO
//****************************************************************************************
if($noti==1) {
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular,c.comentario, e.domicilio, e.nacionalidad
from stzderec a,stmmarce b,stzevtrd c,stzsolic d,stzottid e,stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1566' and 
      c.evento = '1301' and
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = c.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

			   		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Notificaciones de Cancelación por Falta de Uso';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_cert)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('NOTIFICACIÓN DE CANCELACIÓN POR FALTA DE USO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_mejo)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Se notifica a los titulares de las marcas y lemas comerciales que a continuación se especifican que deberan comparecer por ante esta Oficina Registral dentro de un plazo de sesenta(60) dáis hábiles contados a partir de la presente notificación en el Boletín de la Propiedad Industrial, a fin de que hagan valer los alegatos y las pruebasque estimen convenientes.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 60;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("PROPIETARIO ");
		$header_type[$i]['WIDTH'] = 60;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("SOLICITANTE DE LA CANCELACIÓN ");
		$header_type[$i]['WIDTH'] = 53;

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

        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] =trim(utf8_decode($registro_prio['marca']));
	$data[1]['TEXT'] = $registro_prio['registro'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['titular'])).'. '.trim(utf8_decode($registro_prio['domicilio'])).'. '.trim(utf8_decode($registro_prio['nacionalidad']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['comentario']));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
    //   $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de  Notificacion de cancelacion por falta de uso

//****************************************************************************************
//ANOTACIONES MARGINALES
//****************************************************************************************
//Nomenclatura para el tipo de marca 
function tipo_marca_am($var) {
  if ($var=='M') {return "MP";}
  if ($var=='N') {return "NC";}
  if ($var=='L') {return "LC";}
  if ($var=='S') {return "MS";}
}
//Nomenclatura para la clase N - I
function clase($clas,$ind,$vtip) {
  if ($vtip=='LC') {return "LC";}
  if ($vtip=='NC' and $ind == 'I') {return "NC";}
  if ($vtip=='NC' and $ind == 'N') {return "DC";}
  if ($vtip=='MP' or $vtip == 'MS') {return $clas.' '.$ind;}
}

if($anot==1) {
// RENOVACIONES
   $resultado=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzmargi,stzderec
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'R'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.solicitud ");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros de Anotaciones Marginales de Renovación';} 
else {
      $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_anot)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('RENOVACIONES DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_anot)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vista las solicitudes de RENOVACION, presentada por los interesados, y cumplidos como han sido los requisitos establecidos en la Ley de Propiedad Industrial; éste Despacho en ejercicio de las atribuciones que le confiere el artículo 42 literales "b" y "j" de la Ley de Propiedad Industrial Nro. 25.227 del 10 de diciembre 1956, notifica las siguientes RENOVACIONES:'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla 5 columns
$pdf->Table_Init(7);
$columns=7;
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
		$header_type[$i]['TEXT'] = utf8_decode("TIPO ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 40;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE INT");
		$header_type[$i]['WIDTH'] = 20;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ");
		$header_type[$i]['WIDTH'] = 40;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("VIGENTE ");
		$header_type[$i]['WIDTH'] = 20;
		$i=6;
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$vtip=tipo_marca_am($registro_prio['tipo_derecho']);
	$data[1]['TEXT'] = $vtip;
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['claseint']));	
        $data[4]['TEXT'] = trim(utf8_decode($registro_prio['titular2']));
	$data[5]['TEXT'] = trim(utf8_decode($registro_prio['vencimiento']));	
        $data[6]['TEXT'] = trim(utf8_decode($registro_prio['tramitante']));
	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else
 
// CAMBIO DE NOMBRE
   $resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'N'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.solicitud ");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros de Anotaciones Marginales de Cambio de Nombre';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_anot)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('CAMBIO DE NOMBRE DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_anot)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vista las solicitudes de CAMBIO DE NOMBRE, presentada por los interesados, y cumplidos como han sido los requisitos establecidos en la Ley de Propiedad Industrial; éste Despacho en ejercicio de las atribuciones que le confiere el artículo 42 literales "b" y "j" de la Ley de Propiedad Industrial Nro. 25.227 del 10 de diciembre 1956, notifica los siguientes CAMBIOS DE NOMBRE:'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla columns
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TIPO ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 50;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ANTERIOR");
		$header_type[$i]['WIDTH'] = 40;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR ACTUAL");
		$header_type[$i]['WIDTH'] = 40;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 35;		
		
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
	$data[0]['TEXT'] = $registro_prio['registro'];
	$vtip=tipo_marca_am($registro_prio['tipo_derecho']);
	$data[1]['TEXT'] = $vtip;
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['titular1']));	
        $data[4]['TEXT'] = trim(utf8_decode($registro_prio['titular2']));
        $data[5]['TEXT'] = trim(utf8_decode($registro_prio['tramitante']));
	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(10); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else
 
 
 // CESIONES
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'C'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.solicitud ");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros de Anotaciones Marginales de Cesiones';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_anot)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('CESIONES DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_anot)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vista las solicitudes de CESION DE MARCAS, presentada por los interesados, y cumplidos como han sido los requisitos establecidos en la Ley de Propiedad Industrial; éste Despacho en ejercicio de las atribuciones que le confiere el artículo 42 literales "b" y "j" de la Ley de Propiedad Industrial. Notifica las siguientes CESION DE MARCAS.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla columns
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TIPO ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 50;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CEDENTE");
		$header_type[$i]['WIDTH'] = 40;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CESIONARIO");
		$header_type[$i]['WIDTH'] = 40;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 35;		
		
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
	$data[0]['TEXT'] = $registro_prio['registro'];
	$vtip=tipo_marca_am($registro_prio['tipo_derecho']);
	$data[1]['TEXT'] = $vtip;
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['titular1']));	
        $data[4]['TEXT'] = trim(utf8_decode($registro_prio['titular2']));
        $data[5]['TEXT'] = trim(utf8_decode($registro_prio['tramitante']));
	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else
 
// FUSIONES
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'F'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.solicitud ");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros de Anotaciones Marginales de Fusiones';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_anot)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('FUSIONES DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_anot)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vista las solicitudes de FUSIONES DE MARCAS, presentada por los interesados, y cumplidos como han sido los requisitos establecidos en la Ley de Propiedad Industrial; éste Despacho en ejercicio de las atribuciones que le confiere el artículo 42 literales "b" y "j" de la Ley de Propiedad Industrial. Notifica las siguientes FUSIONES DE MARCAS.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla columns
$pdf->Table_Init(7);
$columns=7;
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
		$header_type[$i]['TEXT'] = utf8_decode("TIPO ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 40;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("EMPRESA A FUSIONARSE");
		$header_type[$i]['WIDTH'] = 30;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("EMPRESA SOBREVIVIENTE");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("DOMICILIO DEL SOBREVIVIENTE ");
		$header_type[$i]['WIDTH'] = 35;	
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 25;		
		
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
	$data[0]['TEXT'] = $registro_prio['registro'];
	$vtip=tipo_marca_am($registro_prio['tipo_derecho']);
	$data[1]['TEXT'] = $vtip;
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['titular1']));	
        $data[4]['TEXT'] = trim(utf8_decode($registro_prio['titular2']));
        $data[5]['TEXT'] = trim(utf8_decode($registro_prio['domicilio']));
        $data[6]['TEXT'] = trim(utf8_decode($registro_prio['tramitante']));
	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else
 
 
 
// CAMBIO DE DOMICILIO
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'D'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.solicitud ");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros de Anotaciones Marginales de Cambio de Domicilio';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_anot)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('CAMBIO DE DOMICILIO DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_anot)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vista las solicitudes de CAMBIOS DE DOMICILIOS, presentada por los interesados, y cumplidos como han sido los requisitos establecidos en la Ley de Propiedad Industrial; éste Despacho en ejercicio de las atribuciones que le confiere el artículo 42 literales "b" y "j"  de la Ley de Propiedad Industrial Nro. 25.227 del 10 de diciembre 1956. Notifica los siguientes CAMBIOS DE DOMICILIOS.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla columns
$pdf->Table_Init(7);
$columns=7;
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
		$header_type[$i]['TEXT'] = utf8_decode("TIPO ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 40;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TITULAR");
		$header_type[$i]['WIDTH'] = 30;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("DOMICILIO ANTERIOR");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("DOMICILIO ACTUAL");
		$header_type[$i]['WIDTH'] = 35;	
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 25;		
		
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
	$data[0]['TEXT'] = $registro_prio['registro'];
	$vtip=tipo_marca_am($registro_prio['tipo_derecho']);
	$data[1]['TEXT'] = $vtip;
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['titular2']));	
        $data[4]['TEXT'] = trim(utf8_decode($registro_prio['domicilio_ant']));
        $data[5]['TEXT'] = trim(utf8_decode($registro_prio['domicilio']));
        $data[6]['TEXT'] = trim(utf8_decode($registro_prio['tramitante']));
	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else CAMBIO DE DOMICILIO
 

// LICENCIAS
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.tipo_derecho, stzderec.registro,stzmargi.*
			FROM  stzderec, stzmargi
			WHERE stzmargi.boletin = '$boletin'
			AND stzmargi.tipo_tramite = 'L'
			AND stzmargi.verificado = 'S'
      			AND stzderec.nro_derecho=stzmargi.nro_derecho 
			ORDER BY stzderec.solicitud ");
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros de Anotaciones Marginales de Licencias';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_anot)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('LICENCIAS DE USO DE MARCAS Y OTROS SIGNOS DISTINTIVOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_anot)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Vista las solicitudes de LICENCIAS DE USO, presentada por los interesados, y cumplidos como han sido los requisitos establecidos en la Ley de Propiedad Industrial; éste Despacho en ejercicio de las atribuciones que le confiere el artículo 42 literales "b" y "j"  de la Ley de Propiedad Industrial. Notifica los siguientes LICENCIAS DE USO.'),0,'J',0);
      $pdf->ln(4); 
      
// dibujando la tabla columns
$pdf->Table_Init(7);
$columns=7;
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
		$header_type[$i]['TEXT'] = utf8_decode("TIPO ");
		$header_type[$i]['WIDTH'] = 10;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("MARCA ");
		$header_type[$i]['WIDTH'] = 40;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("LICENCIANTE");
		$header_type[$i]['WIDTH'] = 30;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("LICENCIATARIO");
		$header_type[$i]['WIDTH'] = 30;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("DOMICILIO DEL LICENCIATARIO");
		$header_type[$i]['WIDTH'] = 35;	
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("TRAMITANTE ");
		$header_type[$i]['WIDTH'] = 25;		
		
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
	$data[0]['TEXT'] = $registro_prio['registro'];
	$vtip=tipo_marca_am($registro_prio['tipo_derecho']);
	$data[1]['TEXT'] = $vtip;
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['titular1']));	
        $data[4]['TEXT'] = trim(utf8_decode($registro_prio['titular2']));
        $data[5]['TEXT'] = trim(utf8_decode($registro_prio['domicilio']));
        $data[6]['TEXT'] = trim(utf8_decode($registro_prio['tramitante']));
	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else LICENCIAS
 

}//fin de ANOTACIONES MARGINALES


//****************************************************************************************
// DEVOLUCION DE REGISTROS A PUBLICAR
//****************************************************************************************
if($devo_regi==1) {

$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,b.clase, trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1564' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Devoluciones de Registros a Publicar';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_devo_regi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DEVOLUCIÓN DE REGISTROS A PUBLICAR'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_devo_regi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	$filas_found1=pg_numrows($res_titular);
	$regt = pg_fetch_array($res_titular);
        for($cont1=0;$cont1<$filas_found1;$cont1++)   { 
	   $pais_nombre=pais($regt['nacionalidad']);
 	   if ($cont1=='0'){
	      $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
	      	 $regt = pg_fetch_array($res_titular);
	} 
     
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de DEVOLUCION DE REGISTROS A PUBLICAR


//****************************************************************************************
// REINGRESOS DE DEVOLUCION DE ANOTACIONES MARGINALES
//****************************************************************************************
if($rein_devam==1) {

$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,b.clase, trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1565' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_rein_devam)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_rein_devam)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
      $titular ='';	
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = trim(utf8_decode($registro_prio['titular']));	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de REINGRESO DE DEVOLUCION DE ANOTACIONES MARGINALES


//****************************************************************************************
// DESISTIMIENTO DE ANOTACIONES MARGINALES
//****************************************************************************************
if($desi_anom==1) {
//Renovacion
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1557' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales de Renovaciones';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_anom)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES DE RENOVACION'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_anom)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

//Cesion
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1558' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales de Cesion';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_anom)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES DE CESION'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_anom)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

//Fusion
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1559' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales de Fusión';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_anom)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES DE FUSIÓN'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_anom)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

//Licencia de Uso
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1560' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales de Licencias de uso';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_anom)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES DE LICENCIAS DE USO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_anom)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

//Cambio de Nombre
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1561' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales de Cambio de Nombre';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_anom)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES DE CAMBIO DE NOMBRE'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_anom)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

//Cambio de Domicilio
$resultado=pg_exec("select a.nro_derecho,a.solicitud,a.registro,trim(a.nombre) as marca,trim(d.nombre) as titular, trim(a.tramitante) as tramitante, a.agente
from stzderec a,stmmarce b, stzsolic d, stzottid e, stztmpbor f
where f.boletin = '$boletin' and
      f.estatus = '1562' and 
      f.tipo = 'M' AND 
      a.nro_derecho = f.nro_derecho and
      a.nro_derecho = b.nro_derecho and
      a.nro_derecho = e.nro_derecho and
      d.titular = e.titular
      ORDER BY registro");

		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Reingresos de Devolucion de Anotaciones Marginales de Cambio de Domicilios';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_desi_anom)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REINGRESOS DE DEVOLUCIÓN DE ANOTACIONES MARGINALES DE CAMBIO DE DOMICILIO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_desi_anom)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
        $pdf->Ln(1);
        //busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
       	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['marca']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $data[4]['TEXT'] = trim(utf8_decode($tram)); 
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else



}//fin de DESISTIMIENTO DE ANOTACIONES MARGINALES



//****************************************************************************************
// REGISTROS NO RENOVADOS
//****************************************************************************************
if($regi==1) {
$resultado=pg_exec("SELECT b.nro_derecho, b.solicitud, b.nombre, a.clase, b.registro, b.agente, trim(tramitante) as tramitante
			FROM  stmmarce a, stzderec b, stztmpbo c
			WHERE c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1913'
			AND c.tipo = 'M'
			ORDER BY b.registro");	
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Registros No Renovados';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_regi)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('REGISTROS NO RENOVADOS'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_regi)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('Se les notifica a los interesados, que los registros que ha continuación se mencionan quedan sin efecto de conformidad a lo establecido en el articulo 36 literal b, de la Ley de la Propiedad Industrial, por no haber sido renovadas en el tiempo correspondiente.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');	

        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = trim(utf8_decode($titular));	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
	
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(10); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de REGISTROS NO RENOVADOS


//****************************************************************************************
//  CADUCAS X NO RENOVACION
//****************************************************************************************
if($cadu_nren==1) {
$resultado=pg_exec("SELECT b.nro_derecho, b.solicitud, b.nombre, a.clase, b.registro, e.nombre as titular, b.agente, trim(tramitante) as tramitante
			FROM  stmmarce a, stzderec b, stztmpbo c, stzottid d, stzsolic e
			WHERE c.boletin = '$boletin'
			AND c.nro_derecho = b.nro_derecho 
			AND b.nro_derecho = a.nro_derecho
			AND c.estatus = '1996'
			AND c.tipo = 'M'
			AND a.nro_derecho = d.nro_derecho
			AND e.titular = d.titular
			ORDER BY b.registro");	
		
$registro_prio = pg_fetch_array($resultado);
$filas_resultado_prio=pg_numrows($resultado); 
$cantreg=$filas_resultado_prio;
$total_prio=$filas_resultado_prio;

if ($filas_resultado_prio==0) {$mensaje= $mensaje.' - No se generaron Caducas por No Renovación';} 
else { $nro_resoluc = $nro_resoluc+1;
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_cadu_nren)),0,'J',0);           
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
      $pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
      $pdf->Setfont('Arial','B',12);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('DESISTIDAS POR MEJOR DERECHO'),0,'C',0);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_cadu_nren)),0,'C',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('.'),0,'J',0);
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
		$header_type[$i]['TEXT'] = utf8_decode("REGISTRO ");
		$header_type[$i]['WIDTH'] = 18;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("CLASE ");
		$header_type[$i]['WIDTH'] = 14;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("NOMBRE DE LAS MARCAS ");
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
 for($cont=0;$cont<$filas_resultado_prio;$cont++) { 
      $nsolic=$registro_prio['solicitud'];
      $nagen=$registro_prio['agente'];
      $nderec=$registro_prio['nro_derecho'];
      if (empty($nagen)) {$nagen=0;}	
	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
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
	//busqueda del tramitante
	$tram = agente_tram($nagen,$registro_prio['tramitante'],'1');
        $pdf->Ln(1);
	$data = Array();
	$data[0]['TEXT'] = $registro_prio['registro'];
	$data[1]['TEXT'] = $registro_prio['clase'];
	$data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	$data[3]['TEXT'] = utf8_decode($titular);	
        $data[4]['TEXT'] = trim(utf8_decode($tram));

	$registro_prio = pg_fetch_array($resultado);
	$pdf->Draw_Data($data);
  }//fin del for
      // Fin de Pagina (Firma del Registrador)
       $pdf->ln(8); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
       $pdf->ln(30); 
       $pdf->Setfont('Arial','B',8);
       $pdf->MultiCell(190,5,utf8_decode('Publíquese,'),0,'L',0);
       $pdf->ln(30); 
       $pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
       $pdf->Setfont('Arial','B',7);
       $pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
       $pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
       $pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
 }//fin del else

}//fin de CADUCAS X NO RENOVACION

//Salida del Reporte
echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'> $mensaje</p></H3>"; 

$pdf->Output("../../boletin/boletin.pdf");

return $nro_resoluc;


}
       
?>
