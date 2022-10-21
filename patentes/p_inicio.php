<?php
// Programa de Documentos de PDF 
// Realizado por: Ing. Karina Perez

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

require ("$include_lib/PDF_tablesep.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Conexion
$sql = new mod_db();
$sql->connection($login);

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Documentos PDF');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$tipo=$_POST["tipo"];
$varsol=trim(sprintf("%04d-%06d",$varsol1,$varsol2));
$nconex = $_POST['nconex'];

//if ($varsol1=='' || $varsol2=='' || $varsol=='' || $tipo=='') {
if ($varsol1=='' || $varsol2=='' || $varsol=='') {
	 echo "<br><br>";
    mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";   
    $smarty->display('pie_pag.tpl');
    $sql->disconnect(); exit(); 
}

//Buscando la solicitud
  $resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='P' 
		        AND b.solicitud= '$varsol' and b.solicitud!=''");
$registro = pg_fetch_array($resultado);


 $nderec=$registro['nro_derecho'];
 $varsol=$registro['solicitud'];
 $nregis=$registro['registro'];
 $nagen=$registro['agente'];

//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
$nameimage=ver_imagen($varsol1,$varsol2,'P');

$descripcion=estatus($registro['estatus']);

$pais_nombre=pais($registro['pais_resid']);

$cons_inv=pg_exec("SELECT * FROM stpinved WHERE nro_derecho = '$nderec'");
$cons_clas=pg_exec("SELECT * FROM stpclsfd WHERE nro_derecho = '$nderec' order by tipo_clas");
$cons_clasl=pg_exec("SELECT * FROM stplocad WHERE nro_derecho = '$nderec'");
$cons_pri=pg_exec("SELECT * FROM stzpriod WHERE nro_derecho='$nderec'");
$cons_palc=pg_exec("SELECT * FROM stppacld WHERE nro_derecho='$nderec'");

$reg_inv = pg_fetch_array($cons_inv);
   $filas_cons_inv=pg_numrows($cons_inv); 
$regclasf = pg_fetch_array($cons_clas);
   $filas_clasif=pg_numrows($cons_clas); 
$reg_clasl = pg_fetch_array($cons_clasl);
   $filas_cons_clasl=pg_numrows($cons_clasl);
$reg_pri = pg_fetch_array($cons_pri);
   $filas_cons_pri=pg_numrows($cons_pri);

$vtip=tipo_patente($registro['tipo_paten']);

$result = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio   FROM stzottid, stzsolic, stzderec 
		     WHERE stzottid.nro_derecho='$nderec'
		     AND stzderec.nro_derecho=stzottid.nro_derecho
                     AND stzsolic.titular = stzottid.titular");
$res = pg_fetch_array($result);
$filas_found_tit=pg_numrows($result);

$res_bol=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' and evento='2124' " );   
$reg_bol = pg_fetch_array($res_bol);


//verificando los resultados
if (!$resultado)    { 
     mensajenew('ERROR: Problema al Procesar la Busquedad ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit();    }
   $filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N'); 
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();     exit();    } 
//Incio de la Clase de PDF para generar los reportes


//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex); 
function Cambiar_fecha($fechaini)
 {
 if (!empty($fechaini)) {
    $dia=substr($fechaini,0,2);
    $mes=substr($fechaini,3,2);
    $anio=substr($fechaini,6,4);
    return date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio));
   }
 }

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
//$pdf->SetMargins(20,20,20);
$pdf->SetFont('Times','',10);
$pdf->Table_Init(3);
//set table style$pdf->Set_Table_Type(					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,0,102) ,
						'BRD_SIZE' => 0.5
					));
//set header style
$header_type = array(			0=>array(
				'WIDTH' => 73,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => '',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => '',
			   ),
			1=>array(
				'WIDTH' => 5,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => '',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => '',
				),
		   2=>array(
				'WIDTH' => 73,
				'T_COLOR' => array(0,0,0),
				'T_SIZE' => 8,
				'T_FONT' => 'Arial',
				'T_ALIGN' => 'C',
				'T_TYPE' => '',
				'LN_SIZE' => 6,
				'BG_COLOR' => array(255,255,255),
				'BRD_COLOR' => array(0,0,0),
				'BRD_SIZE' => 0.5,
				'BRD_TYPE' => '1',
				'TEXT' => '',
				),
);
$pdf->Set_Header_Type($header_type);
//set data style
$data_type = array (
		0=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 10,
			'T_FONT' => 'Times',
			'T_ALIGN' => 'J',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.2,
			'BRD_TYPE' => '1',
			),
		1=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 10,
			'T_FONT' => 'Times',
			'T_ALIGN' => 'J',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.2,
			'BRD_TYPE' => '1',
			),
		2=>array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 10,
			'T_FONT' => 'Times',
			'T_ALIGN' => 'J',
			'T_TYPE' => '',
			'LN_SIZE' => 5,
			'BG_COLOR' => array(255,255,255),
			'BRD_COLOR' => array(255,255,255),
			'BRD_SIZE' => 0.2,
			'BRD_TYPE' => '1',
			),
);
$pdf->Set_Data_Type($data_type);
//draw the first header
//$pdf->Draw_Header();
$tsize = 2;
$rr = 255;
    //Imagen del sapi
    $pdf->Setxy(30,20);
    $pdf->Cell(5,4,'(19)',0,0);
	 $pdf->Setxy(35,20);
	 $pdf->Image("../imagenes/Gob_Bolivariano.jpg",45,20,45,50,'JPG');
    //Texto
    $pdf->Setxy(110,20);
//    $publica= 'VE '.$reg_bol['documento'].'-'.$varsol.' '.$tipo;
    $publica= 'VE '.$reg_bol['documento'].'-'.$varsol.' '.'A1';
    $pdf->Cell(10,4,utf8_decode('(11) No de publicación: ').$publica,0,1);
    $pdf->Setxy(110,30);
    $pdf->Cell(10,4,utf8_decode('(21) Número de solicitud: ').$varsol,0,1);
    $clasif='';
    for($cont=0;$cont<$filas_clasif;$cont++) { 
		$clasif= $clasif.$regclasf['clasificacion'];
		$regclasf = pg_fetch_array($cons_clas);
	 }
	 for($cont_loc=0;$cont_loc<$filas_cons_clasl;$cont_loc++) { 
	      $locarn=$locarn.trim($reg_clasl['clasi_locarno']).'; ';
		$reg_clasl = pg_fetch_array($cons_clasl);
         }
	 $pdf->Setxy(110,40);
    	 $pdf->MultiCell(78,4,'(51) Int. CI.: '.$clasif.$locarn,0,1);
  	 $pdf->Setxy(30,80);
  	 $pdf->Cell(10,4,'(12)',0,0); 

	 $vtip=tipo_patentei($registro['tipo_paten']);

	 $pdf->SetFont('Times','',14);
	 $pdf->Setxy(85,80);
  	 $pdf->Cell(10,4,'Patente de '.utf8_decode($vtip),0,1);  	   	 
	 $pdf->SetFont('Times','',10);
	 $pdf->Setxy(30,95);
	 $titular='';
	 for($cont=0;$cont<$filas_found_tit;$cont++) { 
	  if ($cont<($filas_found_tit-1)) {
	  	$titular= $titular.trim($res['nombre']).' con domicilio en '.trim($res['domicilio']).', '.trim($res['nacionalidad']).'; ';
	  }
	  else
    	{$titular= $titular.trim($res['nombre']).' con domicilio en '.trim($res['domicilio']).', '.trim($res['nacionalidad']);}
	$res = pg_fetch_array($result);
    }

 	 for($cont=0;$cont<$filas_cons_inv;$cont++) { 
 	 	if ($cont<($filas_cons_inv-1)) {
	       $inventor=$inventor.trim($reg_inv['nombre_inv']).' ('.trim($reg_inv['nacionalidad']).'); ';
	   }
	   else
	   {$inventor=$inventor.trim($reg_inv['nombre_inv']).' ('.trim($reg_inv['nacionalidad']).') ';}
	   $reg_inv = pg_fetch_array($cons_inv);
	 }
    $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$registro[agente]' ");
	 $regage = pg_fetch_array($res_agen);
	 //$pdf->Setxy(100,120);
         $ind=1;
         $agente = agente_tram($nagen,$registro['tramitante'],$ind);

	 $data = Array();
	 $data[0]['TEXT'] = utf8_decode('(22) Fecha de presentación: ').Cambiar_fecha($registro['fecha_solic']);
    $data[1]['TEXT'] = '';
    $data[2]['TEXT'] = utf8_decode('(73) Titular/es: ').trim($titular);
	 $pdf->Draw_Data($data);    
    $data = Array();
    $data[0]['TEXT'] = utf8_decode('(30) Prioridad: ').$reg_pri['prioridad'].' '.$reg_pri['pais_priori'].' '.Cambiar_fecha($reg_pri['fecha_priori']);
    $data[1]['TEXT'] = '';
	 $data[2]['TEXT'] = utf8_decode('(72) Inventor/es: ').$inventor;
 	 $pdf->Draw_Data($data);
	 $data = Array();
	 $data[0]['TEXT'] = utf8_decode('(45) Fecha de anuncio de la concesión: ').Cambiar_fecha($registro['fecha_regis']);
    $data[1]['TEXT'] = '';
    $data[2]['TEXT'] = utf8_decode('(74) Agente: ').trim($agente);
	 $pdf->Draw_Data($data);    
	 $data = Array();
	 $data[0]['TEXT'] = utf8_decode('(45) Fecha de la publicación del folleto de patente: ').Cambiar_fecha($reg_bol['fecha_event']);
    $data[1]['TEXT'] = '';
    $data[2]['TEXT'] = '';
    $pdf->Draw_Data($data);   
    $pdf->Draw_line; 
    
    $pdf->SetDrawColor(0,0,0); 
    $x = $pdf->Getx();
	 $y = $pdf->Gety();
    $pdf->Setxy($x+5,$y+5);
 	 $pdf->line(30,93,185,93);
    $pdf->line(105,93,105,$y+3);       
    $pdf->line(30,$y+3,185,$y+3);
    $pdf->Setxy(30,$y+10);
  	 $pdf->MultiCell(158,4,utf8_decode('(54) Título: '.trim($registro['nombre'])),0,'J');  	 
         $x = $pdf->Getx();
	 $y = $pdf->Gety();
	 
	 //imagen

      $vsol1=$varsol1;
      $vsol2=$varsol2;
      $nameimage = ver_imagen($vsol1,$vsol2,'P');

    if (file($nameimage)) 
       { $pdf->Setxy(30,$y+5);
			$pdf->MultiCell(158,4,utf8_decode('(57) Resumen: '),0,'J');
   		        $pdf->Setxy(30,$y+10);  	        	
			$pdf->MultiCell(158,4,trim(utf8_decode($registro['resumen'])),0,'J');
			$x = $pdf->Getx();
		        $y = $pdf->Gety();	       	
    	                $pdf->Image("$nameimage",$x+55,$y+20,50,50,'JPG');
       }
    else
    {    $pdf->Setxy(30,$y+5);
			$pdf->Cell(158,4,utf8_decode('(57) Resumen: '),0,1);  	      	
			$pdf->Setxy(30,$y+10);
			$pdf->MultiCell(158,4,trim(utf8_decode($registro['resumen'])),0,'J');	  
    	               // $pdf->Image("$nameimage",$x+115,$y+10,50,50,'JPG');      	
    }
    
//Desconexion de la Base de Datos
$sql->disconnect();
// Limpiar las salidas y emitir reporte
ob_end_clean(); 
$pdf->Output();
?>
