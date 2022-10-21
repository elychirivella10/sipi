<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("$include_lib/jlpdf.php");
require ("$include_lib/PDF_Negadas.php");
require("$include_lib/MPDF45/mpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$login   = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo  = "m_lnegarlit.php";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listado de Marcas Negadas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

$desde =$_POST["desdet"];
$hasta =$_POST["hastat"];
$vsol1 =$_POST['vsol1'];
$vsol2 =$_POST['vsol2'];
$vsol3 =$_POST['vsol3'];
$vsol4 =$_POST['vsol4'];
$vsola =sprintf($vsol1.'-'.$vsol2);
$vsolb =sprintf($vsol3.'-'.$vsol4);
$articulo = $_POST["articulo"];
$literal  = $_POST["literal"];
$boletin  = $_POST["boletin"];
$usuario  = $_POST["usuario"];

if (($boletin=='') OR ($vsola=='-' OR $vsolb=='-' ))  { 
    $smarty->display('encabezado1.tpl');
    mensajenew('AVISO: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Conexion
$sql = new mod_db();
$sql->connection($login);

class PDF extends JLPDF
{
//Columna actual
var $col=0;
//Ordenada de comienzo de la columna
var $y0;

function Header()
{
    //Cabacera
    global $title,$pagina,$numbol;
     $this->SetFont('Arial','I',8);
     $this->SetTextColor(128);
     $this->SetY(10);
     $this->Cell(0,5,utf8_decode('Listado de Negadas'),0,0,'J');
     $this->SetY(8);
     $this->SetFont('Arial','B',8);
     $w=$this->GetStringWidth($title)+6;
     $this->SetX((210-$w)/2);
     $this->Ln(10);
     //Guardar ordenada
     $this->y0=$this->GetY();
}

function Footer()
{
    //Pie de página
    global $numbol;
    $this->SetY(-15);
    $this->SetFont('Arial','B',15);   
}

function SetCol($col)
{
    //Establecer la posición de una columna dada
    $this->col=$col;
    $x=15+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    //Método que acepta o no el salto automático de página
    if($this->col<2)
    {
        //Ir a la siguiente columna
        $this->SetCol($this->col+1);
        //Establecer la ordenada al principio
        $this->SetY($this->y0);
        //Seguir en esta página
        return false;
    }
    else
    {
        //Volver a la primera columna
        $this->SetCol(0);
        //Salto de página
        return true;
    }
}

function ChapterTitle($title,$subtitle)
{
    //Título
    $this->SetFont('Arial','B',30);
  //  $this->SetFillColor(200,220,255);
    $this->Ln(4);
    $this->Cell(0,6,$title,0,0,'C',0);
    $this->Ln(4);
    $this->Cell(0,6,$subtitle,0,0,'C',0);
    $this->Ln(20);
    //Guardar ordenada
    $this->y0=$this->GetY();
}

}

//Inicio del Pdf
$pdf=new PDF_Negadas('P','mm','Letter');
$pdf->Open();
//$pdf->AddPage();
$pdf->AliasNbPages();

$counter = 1;
$articulo = 27;
$titulo='Articulo 27';
while ( $counter <= 3) {
  $resultado=pg_exec("SELECT stmmarce.clase,stztmpbo.solicitud, stmliaor.*,stzderec.tramitante, stzderec.agente, stzderec.nombre
			FROM stmmarce,stmliaor, stztmpbo, stzderec
			WHERE stztmpbo.estatus = '1102'
			AND stztmpbo.boletin = '$boletin'
			AND stztmpbo.tipo = 'M'
         AND stztmpbo.solicitud between '$vsola' AND '$vsolb'			
			AND stmliaor.articulo = '$articulo'
			AND stmmarce.nro_derecho = stztmpbo.nro_derecho
			AND stztmpbo.nro_derecho = stmliaor.nro_derecho
			AND stztmpbo.nro_derecho = stzderec.nro_derecho
			ORDER BY stztmpbo.solicitud");

  $registro_prio = pg_fetch_array($resultado);
  $filas_resultado_prio=pg_numrows($resultado); 
  $cantreg=$filas_resultado_prio;
  $total_prio=$filas_resultado_prio;

  if ($filas_resultado_prio==0) {  } 
  else { 
    $pdf->AddPage();
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
    $pdf->Setfont('Arial','',8);
    $pdf->ln(2); 
    $pdf->Setfont('Arial','B',8);
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,utf8_decode(trim($tit_nega)),0,'C',0);
    $pdf->ln(4); 
    $pdf->MultiCell(190,5,utf8_decode('ARTICULO: '.$articulo),0,'J',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(4); 
      
    // dibujando la tabla 5 columns
    $pdf->Table_Init(4);
    $columns=4;
    //set table style
    $pdf->Set_Table_Type(array(
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
      if (empty($nagen)) { $nagen=0; }	
      $titular ='';	
	   $data = Array();
	   $data[0]['TEXT'] = $registro_prio['solicitud'];
	   $data[1]['TEXT'] = $registro_prio['clase'];
	   $data[2]['TEXT'] = trim(utf8_decode($registro_prio['nombre']));
	
	   //busqueda del titular y sus datos
	   $titular='';
  	   $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
                              FROM stzottid, stzsolic,stmmarce 
                              WHERE stzottid.nro_derecho='$nderec'
			                      AND  stmmarce.nro_derecho=stzottid.nro_derecho
                               AND  stzsolic.titular = stzottid.titular");
	   $filas_found1=pg_numrows($res_titular);
	   $regt = pg_fetch_array($res_titular);
      for($cont1=0;$cont1<$filas_found1;$cont1++) { 
	     $pais_nombre=pais($regt['nacionalidad']);
 	     if ($cont1=='0') {
	       $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	     else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
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
      if (($registro_prio['literal']== '11') OR ($registro_prio['literal']== '12')) {
	     //Registros Negantes 
	     $reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni FROM stzderec, stmmarce WHERE registro='$registro_prio[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   
        $reg = pg_fetch_array($reg_neg);
        $regneg=trim($registro_prio['reg_base']);
        if (!empty($regneg)){
          //busqueda del titular y sus datos
	       $titular_neg='';
  	       $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
				                      FROM stzottid, stzsolic,stmmarce 
				                      WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			                          AND stmmarce.nro_derecho=stzottid.nro_derecho
                                   AND stzsolic.titular = stzottid.titular");
	       $filas_found1=pg_numrows($res_titular);
	       $regt = pg_fetch_array($res_titular);
	       for($cont1=0;$cont1<$filas_found1;$cont1++) { 
 	         if ($cont1=='0') {
	           $titular_neg= $titular_neg.trim($regt['nombre']); }
	         else { $titular_neg= $titular_neg."; ".trim($regt['nombre']); }                
	         $regt = pg_fetch_array($res_titular);
	       } 
          $pdf->Setfont('Arial','B',7);
          $pdf->MultiCell(180,5,'Registros Negantes: '.$registro_prio['reg_base'].' Clase: '.$reg['clase'].' '.$reg['ind_claseni'].'  Nombre: '.utf8_decode(trim($reg['nombre'])).' Titular: '.utf8_decode($titular_neg),0,'J',0);
          $pdf->Setfont('Arial','',7);
	     }
      }
	   else {
	     //comentario
	     $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro_prio[nro_derecho]' and evento='1225' ");   
	     $reg_com = pg_fetch_array($reg_com);
        $pdf->Setfont('Arial','B',7);
        $pdf->MultiCell(180,5,'Comentario: '.trim($reg_com['comentario']),0,1);	
        $pdf->Setfont('Arial','',7);
      }
      $pdf->ln(4); 
	   $registro_prio = pg_fetch_array($resultado);
    }//fin del for
    // Fin de Pagina 
    $pdf->ln(8); 
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'Total de Solicitudes : '.$total_prio,0,'J',0);
    $pdf->ln(10); 
    $pdf->Setfont('Arial','B',8);
    $pdf->ln(30); 
    $pdf->Setfont('Arial','B',7);
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
         AND stztmpbo.solicitud between '$vsola' and '$vsolb'			
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

    if ($filas_resultado_prio==0) {  } 
    else { 
      $pdf->AddPage();
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
      $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);  
      $pdf->Setfont('Arial','',8);
      $pdf->ln(2); 
      $pdf->Setfont('Arial','B',8);
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,5,utf8_decode(trim($tit_nega)),0,'C',0);
      $pdf->ln(4); 
      $pdf->MultiCell(190,5,utf8_decode('ARTICULO: '.$articulo.' Literal: '.$contl),0,'J',0);
      $pdf->Setfont('Arial','',8);
      $pdf->ln(4); 
      
      // dibujando la tabla 5 columns
      $pdf->Table_Init(4);
      $columns=4;
      //set table style
      $pdf->Set_Table_Type( array(
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
       									FROM stzottid, stzsolic,stmmarce 
       									WHERE stzottid.nro_derecho='$nderec'
			                			AND stmmarce.nro_derecho=stzottid.nro_derecho
                                 AND stzsolic.titular = stzottid.titular");
			$filas_found1=pg_numrows($res_titular);
			$regt = pg_fetch_array($res_titular);
			for($cont1=0;$cont1<$filas_found1;$cont1++) { 
	   	  $pais_nombre=pais($regt['nacionalidad']);
 	   	  if ($cont1=='0') {
	      	  $titular= $titular.trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }
	   	  else { $titular= $titular.", ".trim($regt['nombre']).'.'.trim($regt['domicilio']).','.trim($pais_nombre); }                
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
	   		$reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni FROM stzderec, stmmarce WHERE registro='$registro_prio[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   
           	$reg = pg_fetch_array($reg_neg);
           	$regneg=trim($registro_prio['reg_base']);
           	if (!empty($regneg)) {
       	   	//busqueda del titular y sus datos
	   			$titular_neg='';
  	   			$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre
				   								FROM stzottid, stzsolic,stmmarce 
				   								WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			                					 AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
	   			$filas_found1=pg_numrows($res_titular);
	   			$regt = pg_fetch_array($res_titular);
	   			for($cont1=0;$cont1<$filas_found1;$cont1++) { 
 	      		  if ($cont1=='0') {
	         		 $titular_neg= $titular_neg.trim($regt['nombre']); }
	              else { $titular_neg= $titular_neg."; ".trim($regt['nombre']); }                
	              $regt = pg_fetch_array($res_titular);
	            }
               $pdf->Setfont('Arial','B',7);
               $pdf->MultiCell(180,5,'Registros Negantes: '.$registro_prio['reg_base'].' Clase: '.$reg['clase'].' '.$reg['ind_claseni'].'  Nombre: '.utf8_decode(trim($reg['nombre'])).' Titular: '.utf8_decode($titular_neg),0,'J',0);
               $pdf->Setfont('Arial','',7);
	         }
         }
	      else {
	        //comentario
	 		  $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro_prio[nro_derecho]' and evento='1225' ");   
	        $reg_com = pg_fetch_array($reg_com);
	        //$pdf->Cell($x+10,5,'Registros Negantes: ',0,0);
           $pdf->Setfont('Arial','B',7);
           $pdf->MultiCell(180,5,'Comentario: '.trim($reg_com['comentario']),0,1);
           $pdf->Setfont('Arial','',7);
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
      $pdf->ln(30); 
      $pdf->Setfont('Arial','B',7);
     }//fin del else
  }// fin del primer for 
  $counter = $counter + 1; 
  if($counter==2) { $articulo= 34; $titulo='Articulo 34';}
}//fin del while

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
