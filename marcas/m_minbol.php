<?php
// *************************************************************************************
// Programa: php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();

include ("../z_includes.php");

//include ("$include_path/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");
	
//Class Extention for header and footer	
//require_once("$include_lib/header_footer.inc");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Resumen del Boletin');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$boletin=$_POST["vbol"];
$nconex = $_POST['nconex'];

if (empty($boletin)) {
  mensajenew("ERROR: El N&uacute;mero de Bolet&iacute;n esta Vacio ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); } 

//PDF Encabezados
$encab_principal= "Resumen del Boletin No. ".$boletin;


$smarty->assign('n_conex',$nconex);
$titulo='';

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');	
$pdf->Open();
$pdf->AliasNbPages(); 
$sumpor=0;
$tot= 0;   
// Solicitadas X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1006
		group by 1
		order by 1 ");	
		
		
$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1006
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
   $encabezado= "SOLICITADAS POR TITULAR";
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;		
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
}

$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
 $sumpor=0;
 $tot= 0;      
// Solicitadas X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1006
		group by 1
		order by 1 ");	
                      
$filasfound=pg_numrows($resultado);

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1006
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}		
  
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITADAS POR PAIS";
  $pdf->AddPage();
                
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
  } 
$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;	
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
}

$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;  
// Orden de publicacion X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1002
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1002
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                    
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "ORDEN DE PUBLICACION POR TITULAR";  
  $pdf->AddPage();
                
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;			
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }

$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;  
}

// orden de publicacion X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1002
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1002
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "ORDEN DE PUBLICACION POR PAIS";  
  $pdf->AddPage();
                
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;	
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
 $sumpor=0;
 $tot= 0;  
}

// devueltas X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1200
		group by 1
		order by 1 ");	
		
$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1200
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DEVUELTAS POR TITULAR";  
  $pdf->AddPage();
               
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;  
}

// devueltas de forma X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1200
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1200
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DEVUELTAS POR PAIS";  
  $pdf->AddPage();
               
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// OBSERVADAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1003
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1003
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES OBSERVADAS POR TITULAR";  
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 50;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// OBSERVADAS de forma X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1003
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1003
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES OBSERVADAS POR PAIS";  
  $pdf->AddPage();
                   
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// DESISTIDAS X LEY (OBSERVADAS SIN CONTESTACION) X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1914
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1914
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES OBSERVADAS SIN CONTESTACIÓN, POR TITULAR"; 
  $pdf->AddPage();
                 
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// DESISTIDAS X LEY (OBSERVADAS SIN CONTESTACIÓN) X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1914
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1914
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES OBSERVADAS SIN CONTESTACIÓN, POR PAIS"; 
  $pdf->AddPage();
                 
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// CONCEDIDAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1101
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1101
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}

$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CONCEDIDAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// CONCEDIDAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1101
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1101
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                    
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CONCEDIDAS, POR PAIS"; 
  $pdf->AddPage();
                   
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

//PRIORIDAD EXTINGUIDA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1025
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1025
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                      
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDA, POR TITULAR"; 
  $pdf->AddPage();
                 
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PRIORIDAD EXTINGUIDA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)), count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1025
		group by 1
		order by 1 ");	

$resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1025
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("País");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0;
}

// PRIORIDAD EXTINGUIDA EXTEMPORANEA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1023
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1023
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDAD EXTEMPORANEA, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PRIORIDAD EXTINGUIDA EXTEMPORANEA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1023
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1023
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDAD EXTEMPORANEA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PRIORIDAD EXTINGUIDA DEFECTUOSA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDAD DEFECTUOSA, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PRIORIDAD EXTINGUIDA DEFECTUOSA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDAD DEFECTUOSA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PERIMIDAS POR NO PUBLICACION EN PRENSA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1030
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1030
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES PERIMIDAS POR NO PUBLICACION EN PRENSA , POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PERIMIDAS POR NO PUBLICACION EN PRENSA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1030
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1030
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES PERIMIDAS POR NO PUBLICACION EN PRENSA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// CADUCAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1750
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1750
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CADUCAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// CADUCAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1750
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1750
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CADUCAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DESISTIDAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1910
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1910
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DESISTIDAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DESISTIDAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1910
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1910
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DEFECTUOSA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DESISTIMIENTO DE OBSERVACIONES X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1125
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1125
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON DESISTIMIENTO DE OBSERVACIONES, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DESISTIMIENTO DE OBSERVACIONES X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1125
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1125
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON DESISTIMIENTO DE OBSERVACIONES, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1130
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1130
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1130
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1130
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON DESISTIMIENTO DE OBSERVACION POR MEJOR DERECHO, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}





























// PRIORIDAD EXTINGUIDA DEFECTUOSA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDAD DEFECTUOSA, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// PRIORIDAD EXTINGUIDA DEFECTUOSA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1024
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON PRIORIDAD EXTINGUIDAD DEFECTUOSA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// NEGADAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1102
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1102
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES NEGADAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// NEGADAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1102
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1102
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES NEGADAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//CERTIFICADOS ELABORADOS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1563
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1563
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON CERTIFICADOS ELABORADOS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// CERTIFICADOS ELABORADOS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1563
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1563
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON CERTIFICADOS ELABORADOS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// NOTIFICACION DE CANCELACION POR FALTA DE USO X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1566
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1566
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON NOTIFICACION DE CANCELACION POR FALTA DE USO, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// NOTIFICACION DE CANCELACION POR FALTA DE USO X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1566
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1566
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON  NOTIFICACION DE CANCELACION POR FALTA DE USO, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DEVOLUCION DE REGISTROS A PUBLICAR X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1564
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1564
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON DEVOLUCION DE REGISTROS A PUBLICAR, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// DEVOLUCION DE REGISTROS A PUBLICAR X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1564
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1564
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON DEVOLUCION DE REGISTROS A PUBLICAR, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// REINGRESOS DE DEVOLUCION DE ANOTACIONES MARGINALES X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1565
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1565
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON REINGRESOS DE DEVOLUCION DE ANOTACIONES MARGINALES, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// REINGRESOS DE DEVOLUCION DE ANOTACIONES MARGINALES X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1565
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1565
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON REINGRESOS DE DEVOLUCION DE ANOTACIONES MARGINALES, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// REGISTROS NO RENOVADOS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1913
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1913
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON REGISTROS NO RENOVADOS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// REGISTROS NO RENOVADOS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1913
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stmmarce c, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = c.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 1913
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES CON REGISTROS NO RENOVADOS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

// ****************** patentes ********************************
//SOLICITADAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2006
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2006
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES SOLICITADAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//SOLICITADAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2006
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2006
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES SOLICITADAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//ORDEN DE PUBLICACION X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2002
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2002
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES PENDIENTES DE PUBLICACION, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//SOLICITADAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2002
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2002
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES PENDIENTES DE PUBLICACION, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}


//DEVUELTAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2200
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2200
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES DEVUELTAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//DEVUELTAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2200
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2200
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES DEVUELTAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PRIORIDAD EXTINGUIDA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2025
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2025
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES CON PRIORIDAD EXTINGUIDA, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PRIORIDAD EXTINGUIDA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2025
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2025
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES CON PRIORIDAD EXTINGUIDA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PRIORIDAD EXTINGUIDA EXTEMPORANEA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2023
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2023
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES CON PRIORIDAD EXTINGUIDA EXTEMPORANEA, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PRIORIDAD EXTINGUIDA EXTEMPORANEA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2023
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2023
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES CON PRIORIDAD EXTINGUIDA EXTEMPORANEA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PRIORIDAD EXTINGUIDA DEFECTUOSA X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2024
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2024
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES CON PRIORIDAD EXTINGUIDA DEFECTUOSA, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PRIORIDAD EXTINGUIDA DEFECTUOSA X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2024
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2024
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES CON PRIORIDAD EXTINGUIDA DEFECTUOSA, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PERIMIDAS POR NO PUBLICACION EN PRENSA  X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2030
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2030
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES PERIMIDAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PERIMIDAS POR NO PUBLICACION EN PRENSA  X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2030
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2030
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES PERIMIDAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//DENEGADAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2119
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2119
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES DENEGADAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//DENEGADAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2119
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2119
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES DENEGADAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//DESISTIDAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2910
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2910
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES DESISTIDAS, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//DESISTIDAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2910
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2910
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES DESISTIDAS, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//ABANDONADAS X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2090
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2090
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES ABANDONADAS POR NO SOLICITAR EXAMEN TECNICO, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//ABANDONADAS POR NO SOLICITAR EXAMEN TECNICO X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2090
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2090
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "PATENTES ABANDONADAS POR NO SOLICITAR EXAMEN TECNICO, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//ABANDONADAS X NO PAGO X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2750
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2750
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES ABANDONADAS POR NO PAGO, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//ABANDONADAS X NO PAGO X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2750
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2750
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES ABANDONADAS POR NO PAGO, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//OPOSICIONES X TITULAR
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2009
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2009
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES CON OBSERVACION, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PATENTES NEGADAS X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2009
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2009
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE PATENTES CON OBSERVACION, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//PATENTES EN REHABILITACION
$resultado=pg_exec("SELECT distinct(trim(e.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2555
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(e.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2555
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE REHABILITACION DE PATENTES, POR TITULAR"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//REHABILITACION DE PATENTES X PAIS
$resultado=pg_exec("SELECT distinct(trim(f.nombre)),  count(*)
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2555
		group by 1
		order by 1 ");	
 
 $resulcont=pg_exec("SELECT distinct(trim(f.nombre)), count(*) as cantidad
		FROM stztmpbo a, stzottid b, stzderec d, stzsolic e, stzpaisr f
		WHERE a.nro_derecho = b.nro_derecho AND
		a.nro_derecho = d.nro_derecho AND
		b.titular = e.titular AND
		b.nacionalidad = f.pais AND
		a.boletin = '$boletin' AND 
		a.estatus = 2555
		group by 1
		order by 1 ");
$filasfound1=pg_numrows($resulcont);
$regcont = pg_fetch_array($resulcont);
for($cont1=0;$cont1<$filasfound1;$cont1++) { 
   $tot = $tot+$regcont['cantidad'];
   $regcont = pg_fetch_array($resulcont);
}
                     
$filasfound=pg_numrows($resultado);
if ($filasfound==0)    { } 
else {  
  $reg = pg_fetch_array($resultado);
  $encabezado= "SOLICITUDES DE REHABILITACION DE PATENTES, POR PAIS"; 
  $pdf->AddPage();
                  
//initialize the table 
$pdf->Table_Init(3);
$columns=3;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));

//set header style
 $table_default_header_type = array(
	'WIDTH' => 6,				
	'T_COLOR' => array(0,0,0),		
	'T_SIZE' => 8,				
	'T_FONT' => 'Arial',			
	'T_ALIGN' => 'C',	
	'V_ALIGN' => 'M',	
	'T_TYPE' => 'B',	
	'LN_SIZE' => 5,		
	'BG_COLOR' => array(255, 249, 204),	
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.2,			
	'BRD_TYPE' => '1',	
	'TEXT' => '',		
  );

$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 140;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cantidad");
		$header_type[$i]['WIDTH'] = 25;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Porcentaje %");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//Mostarndo los datos en la Tabla
 for($cont=0;$cont<$filasfound;$cont++) { 
	$data = Array();
	//Arreglando el formato de la fecha
	$data[0]['TEXT'] = utf8_decode($reg['btrim']);
	$data[1]['T_ALIGN'] = 'C';
	$data[1]['TEXT'] = $reg['count'];
	$data[2]['T_ALIGN'] = 'C';
	$valor = (($reg['count']*100)/$tot);
	$porc= round($valor * 100) / 100 ;
	$data[2]['TEXT'] = $porc;
	$sumpor= $sumpor + $valor;
	$pdf->Draw_Data($data);
        $reg = pg_fetch_array($resultado);
  }
$pdf->ln(2); 
$pdf->Setfont('Arial','',9);
$pdf->MultiCell(190,5,' Total:                                                                                                                                                                    '.$tot.'                 '.$sumpor,0,'J',0);
$pdf->Setfont('Arial','',8);
$sumpor=0;
$tot= 0; 
}

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
