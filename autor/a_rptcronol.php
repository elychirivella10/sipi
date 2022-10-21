<?php
// Programa de Cronologia de DNDA
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

// Encabezados de pantallas
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Cronologia Administrativa');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//PDF Encabezados
$encab_principal= "Sistema de Derecho de Autor";
$encabezado= "Cronologia Administrativa";

function consultar($idsol,$nderec,$tipo) 
{
 echo "$idsol,$nderec,$tipo"; 
 if ($tipo == 'AUTOR'){
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobaut.domicilio, stzsolic.telefono1  FROM stzsolic,stdobaut
WHERE stzsolic.titular = '$idsol' and stdobaut.nro_derecho = '$nderec' and stzsolic.titular = stdobaut.titular ");
	$regis = pg_fetch_array($resul_sol);
        $nombre= trim(utf8_decode($regis['nombre'])); $cedula=$regis['identificacion']; $domicilio=trim(utf8_decode($regis['domicilio'])).' / '.trim($regis['telefono1']);
	return array($cedula,$nombre,$domicilio);
 }

 if ($tipo == 'ARTISTA'){
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobart.domicilio, stzsolic.telefono1  FROM stzsolic,stdobart
WHERE  stzsolic.titular = '$idsol' and stdobart.nro_derecho = '$nderec' and stzsolic.titular = stdobart.titular ");
	$regis = pg_fetch_array($resul_sol);
        $nombre= trim(utf8_decode($regis['nombre'])); $cedula=$regis['identificacion']; $domicilio=trim(utf8_decode($regis['domicilio'])).' / '.trim($regis['telefono1']);
	return array($cedula,$nombre,$domicilio);
 }

 if ($tipo == 'TITULAR'){ echo "entre titular";
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobtit.domicilio, stzsolic.telefono1 FROM stzsolic,stdobtit WHERE stzsolic.titular = '$idsol' and stdobtit.nro_derecho = '$nderec' and stzsolic.titular = stdobtit.titular ");
	$regis = pg_fetch_array($resul_sol);
   $nombre= trim(utf8_decode($regis['nombre'])); 
   $cedula= $regis['identificacion']; 
   $domicilio=trim(utf8_decode($regis['domicilio'])).' / '.trim($regis['telefono1']);
   return array($cedula,$nombre,$domicilio);
 }
 if ($tipo == 'SOLICITANTE'){
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1   FROM stzsolic,stdobsol WHERE  stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular and stzsolic.titular='$idsol'");
	$regis = pg_fetch_array($resul_sol);
        $nombre= trim(utf8_decode($regis['nombre'])); $cedula=$regis['identificacion']; $domicilio=trim(utf8_decode($regis['domicilio'])).' / '.trim($regis['telefono1']);

	return array($cedula,$nombre,$domicilio);
 }
 if ($tipo == 'PRODUCTOR'){
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobpro.domicilio, stzsolic.telefono1   FROM stzsolic,stdobpro WHERE stzsolic.titular = '$idsol' and stdobpro.nro_derecho = '$nderec' and stzsolic.titular = stdobpro.titular  ");
	$regis = pg_fetch_array($resul_sol);
        $nombre= trim(utf8_decode($regis['nombre'])); $cedula=$regis['identificacion']; $domicilio=trim(utf8_decode($regis['domicilio'])).' / '.trim($regis['telefono1']);

	return array($cedula,$nombre,$domicilio);
 }

 if ($tipo == 'EDITOR'){
	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdedici.domicilio, stzsolic.telefono1   FROM stzsolic, stdedici WHERE stzsolic.titular = '$idsol' and stdedici.nro_derecho = '$nderec'   ");
	$regis = pg_fetch_array($resul_sol);
        $nombre= trim(utf8_decode($regis['nombre'])); $cedula=$regis['identificacion']; $domicilio=trim(utf8_decode($regis['domicilio'])).' / '.trim($regis['telefono1']);

	return array($cedula,$nombre,$domicilio);
 }
 exit();
}

//Validacion de Entrada
$varsol=$_POST["vsol1"];
if (empty($varsol)) {$varsol=$_GET["vsol1"]; }
$varreg=$_POST["vreg1"];
$planilla= $_POST["planilla"]; 
$nconex = $_POST['nconex'];

//Query para buscar por solicitud
if((!empty($varsol)) ) {
   $resultado=pg_exec("SELECT * FROM stdobras WHERE stdobras.solicitud = '$varsol'" );
}

if((!empty($varreg)) ) {
   $resultado=pg_exec("SELECT * FROM stdobras WHERE stdobras.registro = '$varreg'" );
}

if((!empty($planilla))) {
   $resultado=pg_exec("SELECT * FROM stdobras WHERE stdobras.nplanilla = '$planilla'" );
}

//verificando los resultados
if (!$resultado)    { 
     mensajenew('ERROR AL PROCESAR LA BUSQUEDAD ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit();  }

$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect();
     exit();  }  

$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF para generar los reportes
$smarty->assign('n_conex',$nconex);  

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial','',8);
for($cont=0;$cont<$filas_found;$cont++) 
{
 
$descripcion=estatus_dnda($reg['estatus']);
$pais_nombre=pais($reg['pais_origen']);
$idioma=idioma_dnda($reg['cod_idioma']);
$tipo=tipo_obra($reg['tipo_obra']);
 
 $varsol=$reg['solicitud'];
 $nregis=$reg['registro'];
 $nderec=$reg['nro_derecho'];

//Datos comunes a todas las planillas Encabezado
    $pdf->Cell(15,8,'Solicitud:',0,0); 
    $pdf->Cell(100,8,$varsol,0,0);
    $pdf->Cell(30,8,'Fecha de Solicitud:',0,0);
    $pdf->Cell(100,8,$reg['fecha_solic'],0,1);
    $pdf->Cell(25,8,'Tipo de Obra:',0,0);
    $pdf->Cell(90,8,$reg['tipo_obra'].'-'.$tipo,0,0);
    $pdf->Cell(25,8,'Nro Planilla: ',0,0);
    $pdf->Cell(80,8,trim($reg['nplanilla']),0,1);
    $pdf->Cell(30,8,'Num. de Registro:',0,0);
    $pdf->Cell(85,8,$reg['registro'],0,0);
    $pdf->Cell(30,8,'Fecha de Registro:',0,0);
    $pdf->Cell(80,8,$reg['fecha_regis'],0,1);

//Datos comunes a todas las planillas exceptuando AC, IEA
if ($reg['tipo_obra']=='OL' or $reg['tipo_obra']=='OM' or $reg['tipo_obra']=='OE' or $reg['tipo_obra']=='AV' or $reg['tipo_obra']=='AR' or $reg['tipo_obra']=='PC' or $reg['tipo_obra']=='PF') {
    $pdf->Cell(35,8,'Pais:',0,0);
    $pdf->Cell(80,8,trim($reg['pais_origen']).'-'.trim($pais_nombre),0,0);
    $pdf->Cell(12,8,'Idioma:',0,0); 
    $pdf->Cell(8,8,trim($reg['cod_idioma']).'-'.$idioma,0,1);
    $pdf->Cell(40,8,trim(utf8_decode('Traducción: ')),0,0);
    $pdf->Cell(75,8,trim($reg['traduccion']),0,0);
    $pdf->MultiCell(0,4,'Estatus: '.$reg['estatus'].' '.trim($descripcion),0,1); 
    $pdf->ln(4); 
    $pdf->MultiCell(0,4,'Titulo: '.trim(utf8_decode($reg['titulo_obra'])),0,'J');
   // $pdf->MultiCell(0,4,trim(utf8_decode($reg['titulo_obra'])),0,'J');
}

// if ($tipo == 'SOLICITANTE'){

//	$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1  FROM stzsolic,stdobsol WHERE stzsolic.identificacion = '$idsol' and stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular  ");
//	$regis = pg_fetch_array($resul_sol);
//        $nombre= $regis['nombre']; $cedula=$regis['identificacion']; $domicilio=trim($regis['domicilio']).' / '.trim($regis['telefono1']);
//	return array($cedula,$nombre,$domicilio);
// }

//Planilla AC
if ($reg['tipo_obra']=='AC') {
    $resul_actos=pg_exec("SELECT * FROM stdactos WHERE nro_derecho = '$nderec'");
    $regac = pg_fetch_array($resul_actos);
    $pdf->MultiCell(0,4,'Naturaleza del Acto o Contrato:'.trim(utf8_decode($regac['naturaleza'])),0,'J');
    $pdf->ln(2); 
    $pdf->MultiCell(0,4,'Partes que intervienen: '.trim(utf8_decode($regac['partes'])),0,'J'); 
    $pdf->ln(2);
    $pdf->MultiCell(0,4,'Objeto: '.trim(utf8_decode($regac['objeto'])),0,'J'); 
    $pdf->ln(2);
    $pdf->MultiCell(0,4,utf8_decode('Derechos o Modalidades de Explotación: ').trim(utf8_decode($regac['derechos'])),0,'J'); 
    $pdf->ln(2);
    if ($regac['tipo_cuantia']=='G') {$pdf->Cell(100,8,utf8_decode('Cuantia del Acto o Contrato: A título gratuito'),0,1);}
    if ($regac['tipo_cuantia']=='O') {$pdf->Cell(100,8,utf8_decode('Cuantia del Acto o Contrato: A título oneroso'),0,1);}
    $pdf->MultiCell(0,4,utf8_decode('Especificar Cuantía: ').trim(utf8_decode($regac['espec_cuantia'])),0,'J'); 
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15,8,utf8_decode('Características del Acto o Contrato:'),0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(15,8,utf8_decode('Duración/Plazo: ').trim(utf8_decode($regac['duracion'])),0,1);
 
    $pdf->MultiCell(0,4,utf8_decode('Lugar de la Firma: ').trim(utf8_decode($regac['domicilio'])),0,'J'); 
    $pdf->ln(2);
    $pdf->Cell(15,8,utf8_decode('Fecha de la Firma: ').trim($regac['fecha_firma']),0,1);
    $pdf->MultiCell(0,4,utf8_decode('Datos de Registro/Notaria: ').trim(utf8_decode($regac['datosregistro'])),0,'J');     $pdf->ln(2);
}

//Datos planilla principal IEA
if ($reg['tipo_obra']=='IE') {
    $pdf->MultiCell(0,4,'Estatus: '.$reg['estatus'].' '.trim($descripcion),0,1); 
    $res_grupo=pg_exec("SELECT * FROM stdgrupo WHERE nro_derecho = '$nderec'");
    $resgru = pg_fetch_array($res_grupo);
    $pdf->MultiCell(0,4,utf8_decode('Nombre de la Agrupación:  ').$resgru['nombre_grupo'],0,1); 
   // $pdf->Cell(30,8,utf8_decode('Nombre de la Agrupación:'),0,0);
   // $pdf->Cell(120,8,$resgru['nombre_grupo'],0,0);
    $res_gen=pg_exec("SELECT * FROM stdgenero WHERE cod_genero ='$resgru[tipo_agrupa]'");
    $resgen = pg_fetch_array($res_gen);
    $pdf->Cell(30,8,utf8_decode('Tipo de Agrupación:'),0,0);
    $pdf->Cell(80,8,$resgen['desc_genero'],0,1);

    $resul_sol=pg_exec("SELECT *, stzottid.domicilio, stzottid.nacionalidad FROM stzsolic, stzottid WHERE identificacion = '$resgru[doc_director]'");
    $regis = pg_fetch_array($resul_sol);
    $pdf->Cell(35,8,'Director:',0,0);
    $pdf->Cell(80,8,trim(utf8_decode($regis['nombre'])),0,0);
    $pdf->Cell(40,8,'Documento de Ident.:',0,0); 
    $pdf->Cell(75,8,$regis['identificacion'],0,1);
    $pdf->Cell(40,8,'Nacionalidad: ',0,0);
    $pdf->Cell(75,8,trim($regis['nacionalidad']),0,1);
    $pdf->Cell(12,8,'Domicilio:',0,0);
    $pdf->Cell(8,8,$regis['domicilio'],0,1);
    $pdf->Cell(12,8,'Telefono:',0,0);
    $pdf->Cell(70,8,$regis['telefono1'],0,0);
    $pdf->Cell(30,8,'Fax:',0,0);
    $pdf->Cell(8,8,$regis['fax'],0,1);
}

//Resto de la informacion solo para las planillas OL, OM, OE, AV, AR, PC
if ($reg['tipo_obra']=='OL' or $reg['tipo_obra']=='OM' or $reg['tipo_obra']=='OE' or $reg['tipo_obra']=='AV' or $reg['tipo_obra']=='AR' or $reg['tipo_obra']=='PC') {
    $pdf->ln(2);
//    $pdf->Cell(20,8,utf8_decode('Descripción:'),0,0);
	//$pdf->MultiCell(0,4,utf8_decode('Descripción: ').trim(utf8_decode($reg['descrip_obra'])));
	$pdf->MultiCell(0,4,trim(utf8_decode('Descripción: '.$reg['descrip_obra'])));
	$pdf->ln(2); 
        $pdf->Cell(30,8,utf8_decode('Clasificación: '),0,0); 
	if ($reg['clase']=='I') {$clase='Inedita';}
	if ($reg['clase']=='P') {$clase='Publicada';}
	if ($reg['origen']=='O') {$origen='Originaria';}
	if ($reg['origen']=='D') {$origen='Derivada';}
	if ($reg['forma']=='I') {$forma='Individual';}
	if ($reg['forma']=='E') {$forma='En colaboración';}
	if ($reg['forma']=='C') {$forma='Colectiva';}
        $pdf->Cell(100,8,$clase.'  '.$origen.'  '.utf8_decode($forma),0,1);
}

if ($reg['tipo_obra']=='PF' or $reg['tipo_obra']=='IE') {
    $res_pf=pg_exec("SELECT * FROM stdfijac WHERE nro_derecho = '$nderec'");
    $respf = pg_fetch_array($res_pf);
    if ($reg['tipo_obra']=='IE'){
     //  $pdf->Cell(15,8,utf8_decode('Tipo de Fijación:'),0,0); 
       if ($respf['tipo_fijacion']=='S') {$pdf->Cell(15,8,'Tipo de Fijación: Sonora',0,0);}
       if ($respf['tipo_fijacion']=='A') {$pdf->Cell(15,8,'Tipo de Fijación:  Audiovisual',0,0);}}
    $pdf->Cell(60,8,utf8_decode('Año de Primera Publicación:'),0,0); 
    $pdf->Cell(40,8,$anno_1publica,0,0);
    $pdf->Cell(100,8,utf8_decode('Año de Fijación:'),0,0);
   $pdf->Cell(30,8,$respf['anno_fijacion'],0,1);
}

if ($reg['tipo_obra']== 'OM' ) {
    $res_music=pg_exec("SELECT * FROM stdmusic WHERE nro_derecho = '$nderec'");
    $resmusic = pg_fetch_array($res_music); 
    $pdf->Cell(30,8,utf8_decode('Letra: '),0,0);
    $vvlet=$resmusic['letra'];
    if ($vvlet=='t') {$pdf->Cell(30,8,'Con letra',0,0);}   
    else { $pdf->Cell(30,8,'Sin letra',0,0);}   
    $genero=$resmusic[cod_genero];
    $res_gen=pg_exec("SELECT * FROM stdgener WHERE cod_genero = '$genero' ");
    $resgen = pg_fetch_array($res_gen);
    $pdf->Cell(30,8,utf8_decode('Género: '),0,0);
    $pdf->Cell(100,8,trim($resgen['desc_genero']),0,1);
    $pdf->Cell(30,8,utf8_decode('Ritmo: '),0,0);
    $pdf->Cell(50,8,trim($resmusic['ritmo']),0,1);

    if(!empty($resmusic['dat_produ_fon'])) {
     $pdf->SetFont('Arial','B',8);$pdf->Cell(40,8,'Obra Fijada con Distribucion Comercial',0,1);   
     $pdf->SetFont('Arial','',8);
     $pdf->Cell(30,8,utf8_decode('Productor Fonografico: '),0,0);
     $pdf->Cell(100,8,trim($resmusic['dat_produ_fon']),0,1);
     $pdf->Cell(30,8,utf8_decode('Año de Fijación Sonora: '),0,0);
     $pdf->Cell(100,8,trim($resmusic['anno_fija_sono']),0,1);}
}

//En caso de ser Obra Derivada para las planillas OL,OM,OE,AV,AR,PC
if ($reg['tipo_obra']=='OL' or $reg['tipo_obra']=='OM' or $reg['tipo_obra']=='OE' or $reg['tipo_obra']=='AV' or $reg['tipo_obra']=='AR' or $reg['tipo_obra']=='PC') {

if ($reg['obradrivada']== 'V') {
   $res_deriv=pg_exec("SELECT * FROM stdderiv WHERE nro_derecho = '$nderec'");
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'OBRA DERIVADA',0,1);   $pdf->SetFont('Arial','',8);

$pdf->Table_Init(5);
$columns=5;

//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Obra Originaria ");
		$header_type[$i]['WIDTH'] = 75;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Autor ");
		$header_type[$i]['WIDTH'] = 60;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo de Obra");
		$header_type[$i]['WIDTH'] = 20;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Año Public.");
		$header_type[$i]['WIDTH'] = 20;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nro Versiones");
		$header_type[$i]['WIDTH'] = 20;

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

    $filas_found_regder =pg_numrows($res_deriv);
    for($cont3=0;$cont3<$filas_found_regder;$cont3++)  {
      $resderiv = pg_fetch_array($res_deriv);
      $data = Array();
      $data[0]['TEXT'] = trim($resderiv['titulo_original']);
      $data[1]['TEXT'] = $resderiv['datos_autor'];   
      $data[2]['TEXT'] = $resderiv['tipo_obra_deri'];
      $data[3]['TEXT'] = $resderiv['anno_pub_orig'];
      $data[4]['TEXT'] = $resderiv['n_versiones_aut'];
      $pdf->Draw_Data($data);
      $pdf->ln(1);
    }  
   $pdf->ln(2);
}
 $pdf->Draw_Table_Border();
}

//Caso para Obra Escenica datos del tipo de obra escenica
if ($reg['tipo_obra']== 'OE' ) {
    $res_esc=pg_exec("SELECT * FROM stdescen WHERE nro_derecho = '$nderec'");
    $resesc = pg_fetch_array($res_esc);
 
    if ($regesc['tipoobraesc'] == 'D') {$tipoe = utf8_decode('Dramática');}
    if ($regesc['tipoobraesc'] == 'C') {$tipoe = utf8_decode('Coreografáa');}
    if ($regesc['tipoobraesc'] == 'M') {$tipoe = utf8_decode('Dramático-Musical');  }
    if ($regesc['tipoobraesc'] == 'O') {$tipoe = utf8_decode('Otro');}

    $pdf->Cell(30,8,utf8_decode('Tipo de Obra: ').$tipoe.$regesc['tipoobraesc'],0,1); 
    if ($regesc['tipoobraesc'] == 'O') {$pdf->Cell(100,8,trim($otraobraesc),0,1); }
    $pdf->ln(2);
    $pdf->MultiCell(0,4,utf8_decode('Breve descripción de Argumento: '.trim($resesc['argumento'])),0,'J'); 
    $pdf->ln(2);
    $pdf->MultiCell(0,4,utf8_decode('Breve descripción de Musica: '.trim($resesc['musica'])),0,'J'); 
    $pdf->ln(2);
    $pdf->MultiCell(0,4,utf8_decode('Breve descripción de Movimiento: '.trim($resesc['movimiento'])),0,'J'); 
    $pdf->ln(2);
}
//Caso para Obra Escenica datos de la fijacion
if ($reg['tipo_obra']== 'OE' ) {
    $res_fij=pg_exec("SELECT * FROM stdfijac WHERE nro_derecho = '$nderec'");
    $resfij = pg_fetch_array($res_fij);
if ($resfij)    { 
    if ($regfij['tipo_fijacion']=='S') {$tipof='Sonora';}
    if ($regfij['tipo_fijacion']=='M') {$tipof='Audiovisual';}
   $pdf->SetFont('Arial','B',8); $pdf->Cell(40,8,'FIJACION',0,1); $pdf->SetFont('Arial','',8);
   $pdf->Cell(30,8,utf8_decode('Año de Fijación: '.$resfij['anno_fijacion'].'                   '.'Tipo de Fijación: '.$tipof.'   '),0,1);
   $pdf->Cell(100,8,'Ficha Tecnica: '.$resfij['ficha_datos'],0,1);
}
}

//Caso para Obra Arte Visual datos de exhibicion de la obra
if ($reg['tipo_obra']== 'AV' ) {
    $res_exc=pg_exec("SELECT * FROM stdvisua WHERE nro_derecho = '$nderec'");
    $resexc = pg_fetch_array($res_exc);
   if ($resexc['exhibida']==='t' or $resexc['publicada']==='t' or $resexc['edificada']==='t') {
    $pdf->SetFont('Arial','B',8); $pdf->Cell(40,8,'Exhibida, Publicada y Edificada',0,1); $pdf->SetFont('Arial','',8);}
   if ($resexc['exhibida']==='t') {
   $pdf->Cell(30,8,utf8_decode('Exhibida Permantenmente: '.$resexc['ubica_exhibi']),0,1);}
   if ($resexc['publicada']==='t') {
   $pdf->Cell(30,8,utf8_decode('La Obra ha sido publicada: '.$resexc['datos_public']),0,1);}
   if ($resexc['edificada']==='t') {
   $pdf->Cell(30,8,utf8_decode('La Obra ha sido Edificada: '.$resexc['ubica_edifica']),0,1);}
}

// AUTOR solo para las planillas OL, OM, OE, AV, PC, AR
if ($reg['tipo_obra']=='OL' or $reg['tipo_obra']=='OM' or $reg['tipo_obra']=='OE' or $reg['tipo_obra']=='AV' or $reg['tipo_obra']=='PC' or $reg['tipo_obra']=='AR') {

   $res_autor=pg_exec("SELECT * FROM stdobaut WHERE nro_derecho = '$nderec' ");
   $resautor = pg_fetch_array($res_autor);
   $filas_found_regaut =pg_numrows($res_autor);
if ($filas_found_regaut <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'AUTOR(ES)',0,1); $pdf->SetFont('Arial','',8);

$pdf->Table_Init(5);
$columns=5;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula / Rif ");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Autor ");
		$header_type[$i]['WIDTH'] = 70;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 50;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 30;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 18;

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

    $tipo='AUTOR';
    for($cont3=0;$cont3<$filas_found_regaut;$cont3++)  {
      //Busqueda de los datos del Autor
      $idsol= trim($resautor['titular']);
      $info = consultar($idsol,$nderec,$tipo);
      $data = Array();
      $data[0]['TEXT'] = $info[0];
      $data[1]['TEXT'] = $info[1];   
      $data[2]['TEXT'] = $info[2];
      if ($resautor['tipo_autor']=='AU') {$tipo_autor='Autor';}
      if ($resautor['tipo_autor']=='CD') {$tipo_autor='Coautor Director o Realizador';}
      if ($resautor['tipo_autor']=='CA') {$tipo_autor='Coautor Argumento de la Adaptacion';}
      if ($resautor['tipo_autor']=='CG') {$tipo_autor='Coautor del Guion o Dialogos';}
      if ($resautor['tipo_autor']=='CM') {$tipo_autor='Coautor Musica Compuesta';}
      $data[3]['TEXT'] = $tipo_autor;
      $data[4]['TEXT'] = $idsol;
      $pdf->Draw_Data($data);
      $resautor = pg_fetch_array($res_autor);
    }   
}
 $pdf->Draw_Table_Border();
}

// ARTISTA INTERPRETES O EJECUTANTES solo para las planilla IEA
if ($reg['tipo_obra']=='IE') {
   $res_autor=pg_exec("SELECT * FROM stdobart WHERE nro_derecho = '$nderec'");
   $resautor = pg_fetch_array($res_autor);
   $filas_found_regaut =pg_numrows($res_autor);
if ($filas_found_regaut <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'ARTISTAS , INTERPRETES O EJECUTANTES',0,1); $pdf->SetFont('Arial','',8);
$pdf->Table_Init(5);
$columns=5;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 70;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Seudonimo");
		$header_type[$i]['WIDTH'] = 30;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 50;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 18;

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

    $filas_found_regaut =pg_numrows($res_autor);
    $tipo='ARTISTA';
    for($cont3=0;$cont3<$filas_found_regaut;$cont3++)  {
  	//Busqueda de los datos del Artista
	$idsol= trim($resautor['titular']);
	$info = consultar($idsol,$nderec,$tipo);
      $data = Array();
      $data[0]['TEXT'] = $info[0];
      $data[1]['TEXT'] = $info[1];   
      $data[2]['TEXT'] = $info[2];
      $data[3]['TEXT'] = $info[2];
      $data[4]['TEXT'] = $idsol;
      $pdf->Draw_Data($data);
      $resautor = pg_fetch_array($res_autor);
    }  
 
}
 $pdf->Draw_Table_Border();
}

//Caso para Obra Escenica, OE, AR, PF, PC datos de los PRODUCTORES
if ($reg['tipo_obra']== 'OE' or $reg['tipo_obra']=='AR' or $reg['tipo_obra']=='PF' or $reg['tipo_obra']=='PC') {
   $res_prod=pg_exec("SELECT * FROM stdobpro WHERE nro_derecho='$nderec'");
   $resprod = pg_fetch_array($res_prod);
   $filas_found_regprod = pg_numrows($res_prod);
if ($filas_found_regprod <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'PRODUCTOR(ES)',0,1); $pdf->SetFont('Arial','',8);
$pdf->Table_Init(4);
$columns=4;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula / Rif");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Productor");
		$header_type[$i]['WIDTH'] = 80;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 18;

$pdf->Set_Header_Type($header_type);

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

    $filas_found_regprod =pg_numrows($res_prod);
    $tipo='PRODUCTOR';
    for($cont3=0;$cont3<$filas_found_regprod;$cont3++)  {
  	//Busqueda de los datos del Productor
     $idsol= trim($resprod['titular']);
	$info = consultar($idsol,$nderec,$tipo);
      $data = Array();
      $data[0]['TEXT'] = $info[0];
      $data[1]['TEXT'] = $info[1];   
      $data[2]['TEXT'] = $info[2];
      $data[3]['TEXT'] = $idsol;
      $pdf->Draw_Data($data);
      //$resautor = pg_fetch_array($resprod);
      $resprod = pg_fetch_array($res_prod);

    }   
}
 $pdf->Draw_Table_Border();
}

// Titulares solo para las planillas OL, OM, AR, AV, PC, IE
if ($reg['tipo_obra']=='OL' or $reg['tipo_obra']=='OM' or $reg['tipo_obra']=='AV' or $reg['tipo_obra']=='AR' or $reg['tipo_obra']=='PC' or $reg['tipo_obra']=='IE' ) {

   $res_tit=pg_exec("SELECT * FROM stdobtit WHERE nro_derecho='$nderec'");
   $restit = pg_fetch_array($res_tit);
   $filas_found_regtit =pg_numrows($res_tit);
 if ($filas_found_regtit <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'TITULAR(ES)',0,1); $pdf->SetFont('Arial','',8);
   $pdf->Table_Init(4);
   $columns=4;
 //set table style 
 $pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

 //set header style
 $header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula / Rif");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular ");
		$header_type[$i]['WIDTH'] = 70;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titulo");
		$header_type[$i]['WIDTH'] = 30;

 $pdf->Set_Header_Type($header_type);

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

  //$filas_found_regtit =pg_numrows($res_tit);
  $tipo='TITULAR';
  for($cont3=0;$cont3<$filas_found_regtit;$cont3++)  {
	 $idsol= trim($restit['titular']);
	 $info = consultar($idsol,$nderec,$tipo);
    $data = Array();
    $data[0]['TEXT'] = $info[0];
    $data[1]['TEXT'] = $info[1];   
    $data[2]['TEXT'] = $info[2];
    $data[3]['TEXT'] = $restit['titulo_presun'];
    $pdf->Draw_Data($data);
    $restit = pg_fetch_array($res_tit);
  }  
 }
 $pdf->Draw_Table_Border();
}

// ARTISTA solo para la planilla  AR
if ($reg['tipo_obra']== 'AR' ) {
   $res_art=pg_exec("SELECT * FROM stdartar WHERE nro_derecho='$nderec'");
   $resart = pg_fetch_array($res_art);
   $filas_found_regart =pg_numrows($res_art);
if ($filas_found_regart <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'ARTISTA(S)',0,1); $pdf->SetFont('Arial','',8);

$pdf->Table_Init(1);
$columns=1;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Artista");
		$header_type[$i]['WIDTH'] = 195;

$pdf->Set_Header_Type($header_type);

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

    for($cont3=0;$cont3<$filas_found_regart;$cont3++)  {
      $data = Array();
      $data[0]['TEXT'] = $resart[artista];
      $pdf->Draw_Data($data);
      $pdf->ln(1);
      $resart = pg_fetch_array($res_art);
    }  
   $pdf->ln(2);
}
 $pdf->Draw_Table_Border();
}

// Edicion Editores o Impresores para las planillas Obras literarias y Programas y base de datos

if ($reg['tipo_obra']=='OL' or $reg['tipo_obra']=='PC') {

   $res_edt=pg_exec("SELECT * FROM stdedici WHERE nro_derecho='$nderec'");
   $resedt = pg_fetch_array($res_edt);
   $filas_found_regedt = pg_numrows($res_edt);
if ($filas_found_regedt <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'EDITOR(ES) / IMPRESORES',0,1);  $pdf->SetFont('Arial','',8);

   if (trim($resedt['editor_impres'])=='E') {$tipoe='Editor';}
   if (trim($resedt['editor_impres'])=='I') {$tipoe='Impresor';}
   $pdf->Cell(15,8,utf8_decode('Tipo: '.$tipoe.'                   '.'Año de Publicación: '.$resedt['anno_publica'].'                   '.'Nro. de Edición: '.$resedt['n_edicion'].'                   '.'Nro. de Ejemplares: '.$resedt['n_ejemplares']),0,1); 
   $pdf->Cell(30,8,'Caracteristicas:'.$resedt['caracteristicas'],0,1);

$pdf->Table_Init(4);
$columns=4;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula / Rif");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Editor/Impresor");
		$header_type[$i]['WIDTH'] = 80;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 18;

$pdf->Set_Header_Type($header_type);

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
    $filas_found_regedt =pg_numrows($res_edt);
    $tipo= 'EDITOR';
    for($cont3=0;$cont3<$filas_found_regedt;$cont3++)  {
  	//Busqueda de los datos del editor/impresor
	$idsol= trim($resedt['titular']);
	$info = consultar($idsol,$nderec,$tipo);
      $data = Array();
      $data[0]['TEXT'] = $info[0];
      $data[1]['TEXT'] = $info[1];   
      $data[2]['TEXT'] = $info[2];
      $data[3]['TEXT'] = $idsol;
      $pdf->Draw_Data($data);
      $resedt = pg_fetch_array($res_edt);
    }  
}
 $pdf->Draw_Table_Border();
}

// Obras Fijadas solo para las planillas PF. IEA
if ($reg['tipo_obra']=='PF' or $reg['tipo_obra']=='IE') {
   $res_fij=pg_exec("SELECT * FROM stdfijin WHERE nro_derecho='$nderec'");
   $resfij = pg_fetch_array($res_fij);
   $filas_found_regfij =pg_numrows($res_fij);
if ($filas_found_regfij <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8); 
   if ($reg['tipo_obra']=='PF'){
   $pdf->Cell(40,8,'OBRAS FIJADAS',0,1); $pdf->SetFont('Arial','',8);}
   if ($reg['tipo_obra']=='IE'){
   $pdf->Cell(40,8,'OBRAS FIJADAS',0,1); $pdf->SetFont('Arial','',8);}
$pdf->Table_Init(5);
$columns=5;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();

		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titulo");
		$header_type[$i]['WIDTH'] = 40;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Autor");
		$header_type[$i]['WIDTH'] = 45;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Arreglos");
		$header_type[$i]['WIDTH'] = 45;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Interprete");
		$header_type[$i]['WIDTH'] = 45;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Tipo");
		$header_type[$i]['WIDTH'] = 20;
$pdf->Set_Header_Type($header_type);

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

    for($cont3=0;$cont3<$filas_found_regfij;$cont3++)  {
      $data = Array();
      $data[0]['TEXT'] = $resfij['titulo_obfija'];
      $data[1]['TEXT'] = $resfij['nombre_autor'];   
      $data[2]['TEXT'] = $resfij['arreglista'];
      $data[3]['TEXT'] = $resfij['interprete'];
      $data[4]['TEXT'] = $resfij['tipo_obfija'];
      $pdf->Draw_Data($data);
      $resfij = pg_fetch_array($res_fij);
   }  
 $pdf->Draw_Table_Border();
}
}

// Solicitante para todas las planillas

   $res_sol=pg_exec("SELECT * FROM stdobsol WHERE nro_derecho='$nderec'");
   $ressol = pg_fetch_array($res_sol);
   $filas_found_regsol =pg_numrows($res_sol);
if ($filas_found_regsol <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'SOLICITANTE',0,1);  $pdf->SetFont('Arial','',8);
   if (trim($ressol['caracter'])=='A') {$tipoc='Autor';}
   if (trim($ressol['caracter'])=='N') {$tipoc='En nombre del titular';}
   if (trim($ressol['caracter'])=='T') {$tipoc='Como titular derivado';}
   if (trim($ressol['caracter'])=='P') {$tipoc='Partes que intervienen';}
   if (trim($ressol['caracter'])=='C') {$tipoc='Por cesion';}
   if (trim($ressol['caracter'])=='H') {$tipoc='Heredero';}
   if (trim($ressol['caracter'])=='O') {$tipoc='Otro';}
   $pdf->Cell(15,8,'Caracter con el que actua: '.$tipoc,0,1); 
   $pdf->Cell(15,8,'Otro Caracter con el que actua: '.$ressol['otro_caracter'],0,1);
   $pdf->Cell(30,8,'Prueba, Representancion,Transferencia, Derechos: ',0,1);
   $pdf->MultiCell(0,4,utf8_decode($ressol['prueba_repres']),0,'J');
   $pdf->ln(2);

$pdf->Table_Init(4);
$columns=4;
//set table style 
$pdf->Set_Table_Type(
					array(
						'TB_ALIGN' => 'C',
						'BRD_COLOR' => array (0,92,177) ,
						'BRD_SIZE' => 0.3
					));
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

//set header style
$header_type = Array();
		$i=0;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cedula / Rif");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Solicitante");
		$header_type[$i]['WIDTH'] = 80;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Domicilio");
		$header_type[$i]['WIDTH'] = 70;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Titular");
		$header_type[$i]['WIDTH'] = 18;

$pdf->Set_Header_Type($header_type);

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

    //$filas_found_regsol =pg_numrows($res_sol);
    $tipo= 'SOLICITANTE';
    for($cont3=0;$cont3<$filas_found_regsol;$cont3++)  {
  	//Busqueda de los datos solicitante
	//$idsol= trim($ressol['nro_derecho']);
     $idsol= trim($ressol['titular']);
	//$from= 'stzsolic, stdobsol';
	//$where= 'stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular'
	$info = consultar($idsol,$nderec,$tipo);
      $data = Array();
      $data[0]['TEXT'] = $info['0'];
      $data[1]['TEXT'] = $info['1'];   
      $data[2]['TEXT'] = $info['2'];
      $data[3]['TEXT'] = $ressol['titular'];
      $pdf->Draw_Data($data);
      //$resedt = pg_fetch_array($res_edt);
      $ressol = pg_fetch_array($res_sol);
    }  
 $pdf->Draw_Table_Border();
}

// Transferencia para las planillas PF, IE,AR,PC,AV,OE,OM,OL
if ($reg['tipo_obra']='OL' or $reg['tipo_obra']=='OM' or $reg['tipo_obra']=='AV' or $reg['tipo_obra']=='AR' or $reg['tipo_obra']=='PC' or $reg['tipo_obra']=='IE' or $reg['tipo_obra']=='OE' or $reg['tipo_obra']=='PF' ) {
   $res_tran=pg_exec("SELECT * FROM stdtrans WHERE nro_derecho='$nderec'");
   $restran = pg_fetch_array($res_tran);
   $filas_found_regtran =pg_numrows($res_tran);
if ($filas_found_regtran <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'TRANSFERENCIA',0,1);  $pdf->SetFont('Arial','',8);
   $pdf->MultiCell(0,4,utf8_decode($restran['transferencia']),0,'J'); 
}
}

//Representantes Legal en caso de tenerlo todas las planillas
   $res_leg=pg_exec("SELECT * FROM stdrepre WHERE nro_derecho='$nderec'");
   $resleg = pg_fetch_array($res_leg);
   $filas_found_regleg =pg_numrows($res_leg);
if ($filas_found_regleg <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'REPRESENTATES LEGALES',0,1); $pdf->SetFont('Arial','',8);

$pdf->Table_Init(4);
$columns=4;
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
		$header_type[$i]['TEXT'] = utf8_decode("Cedula");
		$header_type[$i]['WIDTH'] = 25;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Nombre ");
		$header_type[$i]['WIDTH'] = 65;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Cualidad");
		$header_type[$i]['WIDTH'] = 35;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Prueba");
		$header_type[$i]['WIDTH'] = 70;
		
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

  for($cont_regleg=0;$cont_regleg<$filas_found_regleg;$cont_regleg++)   { 
      $data = Array();
      $data[0]['TEXT'] = $resleg['cedula_repre'];
      $data[1]['TEXT'] = utf8_decode($resleg['nombre_repre']);
      $data[2]['TEXT'] = utf8_decode($resleg['cualidad_repre']);
      $data[3]['TEXT'] = utf8_decode($resleg['prueba']);
      $resleg = pg_fetch_array($res_leg);
      $reg_cronol = pg_fetch_array($resultado_cronol);
      $pdf->Draw_Data($data);
  }
 $pdf->Draw_Table_Border();

}

//Deposito todas las planillas
   $res_dep=pg_exec("SELECT * FROM stdobras WHERE nro_derecho='$nderec'");
   $resdep = pg_fetch_array($res_dep);
   $filas_found_regdep =pg_numrows($res_dep);
if ($filas_found_regdep <> 0)  { 
   $pdf->ln(2);
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(40,8,'DEPOSITO',0,1); $pdf->SetFont('Arial','',8);
   $pdf->Cell(15,8,'Nro. de Ejemplares Depositados: '.$resdep['n_ejemplares'],0,1); 
   $pdf->Cell(15,8,'Tipo de Soporte Material: '.utf8_decode($resdep['tipo_soporte']),0,1); 
   $pdf->MultiCell(0,4,'Observaciones: '.utf8_decode($resdep['observacion']),0,'J'); 
   $pdf->Cell(15,8,'Nro. de Hojas Adicionales: '.$resdep['n_hojas_adic'],0,1);
   $pdf->MultiCell(0,4,'Datos Ampliados en Hojas Adicionales: '.trim(utf8_decode($resdep['datos_ampli'])),0,'J'); 
   $pdf->ln(2);
   $pdf->MultiCell(0,4,'Datos Adicionales: '.trim(utf8_decode($resdep['datos_adicio'])),0,'J'); 
   $pdf->ln(2);
}
// Buscando la Cronologia de la solicitud 

$pdf->SetFont('Arial','B',8);
$pdf->ln(3);
$pdf->Cell(40,8,'CRONOLOGIA DE LA SOLICITUD',0,1);
$pdf->SetFont('Arial','',8);

//initialize the table with columns
$pdf->Table_Init(7);
$columns=7;
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
		$header_type[$i]['TEXT'] = utf8_decode("Fecha Evento");
		$header_type[$i]['WIDTH'] = 15;
		$i=1;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Transacción ");
		$header_type[$i]['WIDTH'] = 20;
		$i=2;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Usuario");
		$header_type[$i]['WIDTH'] = 18;
		$i=3;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Documento");
		$header_type[$i]['WIDTH'] = 20;
		$i=4;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Evento");
		$header_type[$i]['WIDTH'] = 12;
		$i=5;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Descripción");
		$header_type[$i]['WIDTH'] = 70;
		$i=6;
		$header_type[$i] = $table_default_header_type;
		$header_type[$i]['TEXT'] = utf8_decode("Comentario");
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
	'BRD_COLOR' => array(0,92,177),		
	'BRD_SIZE' => 0.1,			
	'BRD_TYPE' => '1',		
    );
   }

$pdf->Set_Data_Type($data_type);

//draw the first header
$pdf->Draw_Header();

//$pdf->SetFont('Arial','',8);
   $resultado_cronol=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' 
   			  order by fecha_event,secuencial");   
   $filas_found_cronol=pg_numrows($resultado_cronol);
   $reg_cronol = pg_fetch_array($resultado_cronol);
   
   for($cont_cronol=0;$cont_cronol<$filas_found_cronol;$cont_cronol++)   { 
      $data = Array();
      $data[0]['TEXT'] = $reg_cronol['fecha_event'];
      $data[1]['TEXT'] = $reg_cronol['fecha_trans'];
      $data[2]['TEXT'] = trim($reg_cronol['usuario']);
      $data[3]['TEXT'] = $reg_cronol['documento'];
      $data[4]['TEXT'] = $reg_cronol['evento'];
      $data[5]['TEXT'] = trim(sprintf($reg_cronol['desc_evento']));
      $data[6]['TEXT'] = trim(sprintf($reg_cronol['comentario']));
      $reg_cronol = pg_fetch_array($resultado_cronol);

      $pdf->Draw_Data($data);
     
   }
 $pdf->Draw_Table_Border();

//$pdf->SetFont('Arial','',8);  

$reg = pg_fetch_array($resultado);
if  ($cont+1!=$filas_found) {$pdf->AddPage();}

}
   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>

