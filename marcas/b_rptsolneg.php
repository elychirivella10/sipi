<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("$include_lib/jlpdf_neg.php");
require ("$include_lib/PDF_tableneg.php");
require("$include_lib/MPDF45/mpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();
$fechahoy = hoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitudes Negadas Formato Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Solicitudes Negadas Formato Boletín";

//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];

//Query para buscar las opciones deseadas
$from = " stzderec, stmmarce, stzevtrd, stmliaor ";
$where='stzderec.estatus IN (1102) AND stzevtrd.evento=1225 ';
$titulo='';

/*
// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecsold","fecsolh");
  $valores = array($fecsold,$fecsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

//Verificacion del rango de fechas
$esmayor=compara_fechas($fecsold,$fecsolh);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
*/


if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzevtrd.fecha_trans >= '$fecsold') and (stzevtrd.fecha_trans <='$fecsolh'))";
	   $titulo= $titulo." DESDE:"." $fecsold"." HASTA:"." $fecsolh";
	}
	else { 
		$where = $where." ((stzevtrd.fecha_trans >= '$fecsold') and (stzevtrd.fecha_trans <='$fecsolh'))";
      $titulo= $titulo." DESDE:".$fecsold." HASTA:".$fecsolh;
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.usuario = '$usuario')";
  	   $titulo= $titulo." USUARIO:"."$usuario";  
	}
	else { 
		$where = $where." (stzevtrd.usuario = '$usuario')";
 	   $titulo= $titulo." USUARIO:"."$usuario";
	}
}

$where = $where." and stzderec.nro_derecho=stmmarce.nro_derecho";
$where = $where." and stzderec.nro_derecho=stzevtrd.nro_derecho";
$where = $where." and stzderec.nro_derecho=stmliaor.nro_derecho";
$where = $where." and stzderec.tipo_mp='M'";

//Conexion a la base de datos  
$sql = new mod_db();
$sql->connection($login);

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus
 FROM  stzderec, stmmarce, stzevtrd, stmliaor 
 WHERE $where  ORDER BY 1"); 
 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_rptpsolneg.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','m_rptpsolneg.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

$cantidad=pg_exec("SELECT  DISTINCT ON (stzderec.solicitud) stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus 
 FROM  stzderec, stmmarce, stzevtrd, stmliaor
 WHERE $where "); 

$filas_res=pg_numrows($cantidad); 
$total=$filas_res;

//echo $total; exit();

if ($filas_resultado==0) {
  $mensaje= $mensaje.'* No se genero Negadas  ';

} 
else {

$counter = 1;
$articulo = 27;
$titulo='Articulo 27';

//Inicio del Pdf
$pdf=new JLPDF('P','mm','Letter');
$pdf->Open();
$pdf->AliasNbPages();

while ( $counter <= 4) {
  switch ($articulo) {
     case 27:
       $tituloneg = "Negadas Nacionales (Artículo 27 L.P.I)";
       $encabezado = "Considerando que las solicitudes de registro detalladas a continuación se encuentran incursas en la disposición establecida en el artículo 27 de la Ley de Propiedad Industrial G.O. N° 25.227, de fecha 10/12/1956, este Despacho decide negarlas de oficio.";
       break;
     case 28:
       $tituloneg = "Negadas Nacionales (Artículo 28 L.P.I)";
       $encabezado = "Considerando que las solicitudes de registro detalladas a continuación se encuentran incursas en la disposición establecida en el artículo 28 de la Ley de Propiedad Industrial G.O. N° 25.227, de fecha 10/12/1956, este Despacho decide negarlas de oficio.";
       break;
     case 29:
       $tituloneg = "Negadas Nacionales (Artículo 29 L.P.I)";
       $encabezado = "Considerando que las solicitudes de registro detalladas a continuación se encuentran incursas en la disposición prohibitiva establecida en el artículo 29 de la Ley de Propiedad Industrial G.O. N° 25.227, de fecha 10/12/1956, este Despacho decide negarlas de oficio.";
       break;
     case 35:
       $tituloneg = "Negadas Nacionales (Artículo 35 L.P.I)";
       $encabezado = "Considerando que las solicitudes de registro detalladas a continuación se encuentran incursas en la disposición (es) prohibitiva(s) establecida(s) en el artículo 35, de la Ley de Propiedad Industrial, este Despacho decide negarlas de oficio.";
       break;
  }       


  //Query reporte boletin
  $resultado=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud, stzderec.tipo_derecho, stzderec.fecha_solic, stzderec.nombre, stzderec.tramitante, stzderec.agente, stzderec.poder, stmmarce.clase, stmmarce.ind_claseni, stmmarce.modalidad, stmmarce.distingue, stzevtrd.comentario, stmliaor.*, stzderec.tramitewebpi,stzevtrd.fecha_trans
		FROM $from 
		WHERE $where 
		AND stmliaor.articulo = '$articulo'
		ORDER BY stzderec.solicitud");

  $registro_conc = pg_fetch_array($resultado);
  $filas_resultadoc=pg_numrows($resultado); 
  $cantreg=$filas_resultadoc;
  $totalc=$filas_resultadoc;

  if ($filas_resultadoc==0) { $mensaje= $mensaje.' - No se generaron Negadas'.$articulo; } 
  else {
    $pdf->AddPage();
    // Montando los resultados en el formato boletin 
    $nro_resoluc = $nro_resoluc+1;
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTÓNOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL'),0,'J',0);  
    $pdf->Setfont('Arial','',8);
    $pdf->ln(2); 
    $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_nega)),0,'J',0);           
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode(trim($tituloneg))),0,'C',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(4); 
    $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode($encabezado)),0,'J',0);
    $pdf->ln(4); 
     
    for($cont=0;$cont<$filas_resultadoc;$cont++) { 
      $nsolic=$registro_conc['solicitud'];
      $nagen=$registro_conc['agente'];
      $nderec=$registro_conc['nro_derecho'];
      $modalidad= $registro_conc['modalidad'];
      $ntipom=$registro_conc['tipo_derecho'];
      $clase= $registro_conc['clase'];
      if ($clase == 46) { $clase='NC';}
      if ($clase == 47) { $clase='LC';}	
      $solwebpi = trim($registro_conc['tramitewebpi']);
      $x = $pdf->Getx();
      $y = $pdf->Gety();
      if ($y >= 245) {  $pdf->AddPage(); }
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,4,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
            
      //$pdf->MultiCell(135,4,'Insc. '. $registro_conc['solicitud'].' del '.Cambiar_fecha_mes($registro_conc['fecha_solic']),0,'J',0);
      $pdf->MultiCell(135,4,'Insc. '. $registro_conc['solicitud'].' del '.Cambiar_fecha_mes($registro_conc['fecha_solic']).'      Modalidad:  '.$modalidad.',      Tipo:  '.$ntipom,0,'J',0);

      $pdf->Setfont('Arial','',8);
      if ($modalidad == 'M') { //Nombre de la marca en caso de que sea mixta
        $texto_nombre= "[b]NOMBRE DE LA MARCA:  [/b] ".trim(utf8_decode($registro_conc['nombre']));
        $pdf->JLCell("$texto_nombre",135,'j');       
      } 
                     
    	//busqueda del titular y sus datos
	   $titular='';
  	   $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
         FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho AND stzsolic.titular = stzottid.titular");
	   $filas_found1=pg_numrows($res_titular);
	   $regt = pg_fetch_array($res_titular);
	   for($cont1=0;$cont1<$filas_found1;$cont1++) { 
	     if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	     else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	     if ($cont1=='0') {
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	     $regt = pg_fetch_array($res_titular);
	   } 
	
      $y = $pdf->Gety(); 
      $texto_titular= "[b]SOLICITADA POR:   "."[/b] ".$titular;
      $pdf->JLCell("$texto_titular",135,'j');

      //imagen
      $varsol1=substr($nsolic,-11,4);
      $varsol2=substr($nsolic,-6,6);
      $nameimage=ver_imagen($varsol1,$varsol2,'M');

      if ((file($nameimage)) AND ($modalidad!='D')) {   
	$x = $pdf->Getx();
        $y = $pdf->Gety();
	if ($y >= 240) {
	  $pdf->AddPage();
	  $pdf->Image("$nameimage",160,15,26,24,'JPG');
          $y = $pdf->Gety(); 	
          $pdf->SetXY($x,$y+5); 		 
        }
        else {	
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
    	  $pdf->MultiCell(50,4,trim(utf8_decode($registro_conc['nombre'])),0,'C',0);  
	  $pdf->Setfont('Arial','',8);
   	} 
   	/*
   	//busqueda del clase
	   $pdf->Setfont('Arial','',8);
	   if ($clase == 46) { $clase='NC';}
	   if ($clase == 47) { $clase='LC';}			
	   //$distingue= trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$clase;
      $texto_clase= "[b]EN CLASE:   "."[/b] ".$clase;
      $pdf->JLCell("$texto_clase",135,'j');        
      //$pdf->MultiCell(135,4,'Para distinguir: '.trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$clase,0,'J',0);
*/

   	//busqueda del Distingue y Clase
	$pdf->Setfont('Arial','',8);
	
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}			
	$distingue= trim(mb_strtoupper(utf8_decode($registro_conc['distingue']))).'[b] En Clase: '.$clase.' [/b] ';
	//$distingue= trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$clase;
        $texto_distingue= "[b]PARA DISTINGUIR:   "."[/b] ".$distingue;
        $pdf->JLCell("$texto_distingue",135,'j');        

        $etiqueta='';
        // Obtencion de la Etiqueta
        if (($modalidad=="G") || ($modalidad=="M")) {
          $obj_querye = $sql->query("SELECT * FROM stmlogos WHERE nro_derecho ='$nderec'");
          $obj_filase = $sql->nums('',$obj_querye);
          if ($obj_filase!=0) {
            $objse = $sql->objects('',$obj_querye);
            $etiqueta = trim(mb_strtoupper(utf8_decode($objse->descripcion)));
            $texto_etiqueta= "[b]ETIQUETA:   "."[/b] ".$etiqueta;
            $pdf->JLCell("$texto_etiqueta",135,'j');        
          }
        }
      
      //busqueda del Tramitante (poder, agente o tramitante)
      $poder = trim($registro_conc['poder']);
      $tram = agente_tramp($nagen,trim($registro_conc['tramitante']),$poder);
      $texto_tramitante= "[b]TRAMITANTE:  "."[/b] ".trim(utf8_decode($tram));        
      $pdf->JLCell("$texto_tramitante",135,'j'); 
  
      //verificando si debe ir registros negantes
      if (($registro_conc['literal']== '11') or  ($registro_conc['literal']== '12')) {
	//Registros Negantes 
	$reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.tipo_derecho,stzderec.fecha_solic,stzderec.nombre,
stzderec.tramitewebpi,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue
FROM stzderec,stmmarce WHERE registro='$registro_conc[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   
        $reg = pg_fetch_array($reg_neg);
        $regneg=trim($registro_conc['reg_base']);

        if (!empty($regneg)) {
       	  //busqueda del titular y sus datos
	  $titular_neg='';
  	  $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.domicilio, stzottid.pais_domicilio
	                          FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			          AND stmmarce.nro_derecho=stzottid.nro_derecho
                                  AND stzsolic.titular = stzottid.titular");

	  $filas_found1=pg_numrows($res_titular);
	  $regt = pg_fetch_array($res_titular);
	  for($cont1=0;$cont1<$filas_found1;$cont1++) { 
             $pais_nombre=pais($regt['pais_domicilio']);
 	     if ($cont1=='0') {
	       $titular_neg= $titular_neg.trim($regt['nombre']).' con Domicilio: '.trim($regt['domicilio']).' País: '.trim($pais_nombre); }
	     else { 
               $titular_neg= $titular_neg."; ".trim($regt['nombre']).' con Domicilio: '.trim($regt['domicilio']).' País: '.trim($pais_nombre); }                
	     $regt = pg_fetch_array($res_titular);
	  } 
          //$negativa = $registro_conc['reg_base'].' Clase: '.$reg['clase'].'  '.utf8_decode(trim($reg['nombre'])).' Titular: '.utf8_decode($titular_neg);          

          $negativa = $registro_conc['reg_base'].', Solicitud: '.$reg['solicitud'].' de Fecha: '.$reg['fecha_solic'].', Modalidad: '.$reg['modalidad'].', Clase: '.$reg['clase'].'  ';          


          $texto_negante= "[b]REGISTRO NEGANTE:  "."[/b] ".$negativa;
          $pdf->JLCell("$texto_negante",135,'j');  

          $nombre_negante= "[u]Nombre Marca:"."[/u]   ".utf8_decode(trim($reg['nombre']));
          $pdf->JLCell("$nombre_negante",135,'j');  

          $titular_negante= "[u]Titular:"."[/u]   ".utf8_decode($titular_neg);
          $pdf->JLCell("$titular_negante",135,'j');  

	  $distingue_negante= trim(mb_strtoupper(utf8_decode($reg['distingue'])));
          $txt_distingue_neg= "[u]DISTINGUE:"."[/u]   ".$distingue_negante;
          $pdf->JLCell("$txt_distingue_neg",135,'j');        

	}
      }
      else {
	   //comentario
           $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro_conc[nro_derecho]' AND evento='1225' ORDER BY fecha_trans DESC");   
	   $reg_com = pg_fetch_array($reg_com);
           $texto_negante= "[b]COMENTARIO:   "."[/b] ".trim(utf8_decode($reg_com['comentario']));
           $pdf->JLCell("$texto_negante",135,'j');        
      }
      $texto_carga= "[b]FECHA TRANSACCION:   "."[/b] ".trim(utf8_decode($reg_com['fecha_trans']));
      $pdf->JLCell("$texto_carga",135,'j');        
 
      $registro_conc = pg_fetch_array($resultado);
    } //Fin del For 

    // Fin de Pagina (Firma del Registrador)
    $pdf->ln(8); 
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'Total de Solicitudes : '.$totalc,0,'J',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(8); 

  } //fin del else si no hay resultado (filas_resultadoc)
  $counter = $counter + 1; 
  if($counter==2) { $articulo= 28; $titulo='Articulo 28';}
  if($counter==3) { $articulo= 29; $titulo='Articulo 29';}
  if($counter==4) { $articulo= 35; $titulo='Articulo 35';}
}//fin del while

// NEGADAS PARA ARTICULOS 33 Y 34
$counter = 1;
$articulo = 33;
$titulo='Articulo 33';

while ( $counter <= 2) {
  if ($articulo == 33) { $tope = 12; $tituloneg = "Negadas Nacionales (Artículo 33 L.P.I)"; }
  if ($articulo == 34) { $tope = 2;  $tituloneg = "Negadas Nacionales (Artículo 34 L.P.I)"; }

  for($contl=1;$contl<=$tope;$contl++) {
    $encabezado = "Considerando que las solicitudes de registro detalladas a continuación se encuentran incursas en la disposición(es) prohibitiva(s) establecida(s) en el artículo ".$articulo.", numeral ".$contl.", de la Ley de Propiedad Industrial, G.O. N° 25.227, de fecha 10/12/1956, este Despacho decide negarlas de oficio.";

  //Query reporte boletin
  $resultado=pg_exec("SELECT stzderec.nro_derecho, stzderec.solicitud, stzderec.tipo_derecho, stzderec.fecha_solic, stzderec.nombre, stzderec.tramitante, stzderec.agente, stzderec.poder, stmmarce.clase, stmmarce.ind_claseni, stmmarce.modalidad, stmmarce.distingue, stzevtrd.comentario, stmliaor.*, stzderec.tramitewebpi,stzevtrd.fecha_trans
			FROM $from 
			WHERE $where 
			AND stmliaor.literal = '$contl'
			AND stmliaor.articulo = '$articulo'
			ORDER BY stzderec.solicitud");

    $registro_conc = pg_fetch_array($resultado);
    $filas_resultadoc=pg_numrows($resultado); 
    $cantreg=$filas_resultadoc;
    $totalc=$filas_resultadoc;

  if ($filas_resultadoc==0) { $mensaje= $mensaje.' - No se generaron Negadas de Articulo '.$articulo.' Literal '.$contl; } 
  else {
    $pdf->AddPage();
    // Montando los resultados en el formato boletin 
    $nro_resoluc = $nro_resoluc+1;
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA, '.$ministerio.' - SERVICIO AUTÓNOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL'),0,'J',0);  
    $pdf->Setfont('Arial','',8);
    $pdf->ln(2); 
    $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fec_nega)),0,'J',0);           
    $pdf->Setfont('Arial','B',12);
    $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode(trim($tituloneg))),0,'C',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(4); 
    $pdf->MultiCell(190,5,mb_strtoupper(utf8_decode($encabezado)),0,'J',0);
    $pdf->ln(4); 
     
    for($cont=0;$cont<$filas_resultadoc;$cont++) { 
      $nsolic=$registro_conc['solicitud'];
      $nagen=$registro_conc['agente'];
      $nderec=$registro_conc['nro_derecho'];
      $modalidad= $registro_conc['modalidad'];
      $ntipom=$registro_conc['tipo_derecho'];
      $clase= $registro_conc['clase'];
      if ($clase == 46) { $clase='NC';}
      if ($clase == 47) { $clase='LC';}	
      $solwebpi = trim($registro_conc['tramitewebpi']);
      $x = $pdf->Getx();
      $y = $pdf->Gety();
      if ($y >= 245) {  $pdf->AddPage(); }
      $pdf->Setfont('Arial','B',12);
      $pdf->MultiCell(190,4,'_______________________________________________________________________________',0,'J',0);
      $pdf->Setfont('Arial','B',8);
            
      //$pdf->MultiCell(135,4,'Insc. '. $registro_conc['solicitud'].' del '.Cambiar_fecha_mes($registro_conc['fecha_solic']),0,'J',0);
      $pdf->MultiCell(135,4,'Insc. '. $registro_conc['solicitud'].' del '.Cambiar_fecha_mes($registro_conc['fecha_solic']).'      Modalidad:  '.$modalidad.',      Tipo:  '.$ntipom,0,'J',0);
      $pdf->Setfont('Arial','',8);
      if ($modalidad == 'M') { //Nombre de la marca en caso de que sea mixta
        $texto_nombre= "[b]NOMBRE DE LA MARCA:  [/b] ".trim(utf8_decode($registro_conc['nombre']));
        $pdf->JLCell("$texto_nombre",135,'j');       
      } 
                     
    	//busqueda del titular y sus datos
	$titular='';
  	$res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio
                                FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			        AND stmmarce.nro_derecho=stzottid.nro_derecho AND stzsolic.titular = stzottid.titular");
	   $filas_found1=pg_numrows($res_titular);
	   $regt = pg_fetch_array($res_titular);
	   for($cont1=0;$cont1<$filas_found1;$cont1++) { 
	     if($solwebpi=="S") { $pais_nombre=pais($regt['pais_domicilio']); $codpais=trim($regt['pais_domicilio']); }
	     else { $pais_nombre=pais($regt['nacionalidad']); $codpais=trim($regt['nacionalidad']); }
 	     if ($cont1=='0') {
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	     $regt = pg_fetch_array($res_titular);
	   } 
	
      $y = $pdf->Gety(); 
      $texto_titular= "[b]SOLICITADA POR:   "."[/b] ".$titular;
      $pdf->JLCell("$texto_titular",135,'j');

      //imagen
      $varsol1=substr($nsolic,-11,4);
      $varsol2=substr($nsolic,-6,6);
      $nameimage=ver_imagen($varsol1,$varsol2,'M');

      if ((file($nameimage)) AND ($modalidad!='D')) {   
	$x = $pdf->Getx();
        $y = $pdf->Gety();
	if ($y >= 240) {
	  $pdf->AddPage();
	  $pdf->Image("$nameimage",160,15,26,24,'JPG');
          $y = $pdf->Gety(); 	
          $pdf->SetXY($x,$y+5); 		 
        }
        else {	
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
    	  $pdf->MultiCell(50,4,trim(utf8_decode($registro_conc['nombre'])),0,'C',0);  
	     $pdf->Setfont('Arial','',8);
   	} 
   	
   	/* //busqueda del clase
        $pdf->Setfont('Arial','',8);
        if ($clase == 46) { $clase='NC';}
        if ($clase == 47) { $clase='LC';}			
        $texto_clase= "[b]EN CLASE:   "."[/b] ".$clase;
        $pdf->JLCell("$texto_clase",135,'j');     */

   	//busqueda del Distingue y Clase
	$pdf->Setfont('Arial','',8);
	
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}			
	$distingue= trim(mb_strtoupper(utf8_decode($registro_conc['distingue']))).'[b] En Clase: '.$clase.' [/b] ';
	//$distingue= trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$clase;
        $texto_distingue= "[b]PARA DISTINGUIR:   "."[/b] ".$distingue;
        $pdf->JLCell("$texto_distingue",135,'j');        

        $etiqueta='';
        // Obtencion de la Etiqueta
        if (($modalidad=="G") || ($modalidad=="M")) {
          $obj_querye = $sql->query("SELECT * FROM stmlogos WHERE nro_derecho ='$nderec'");
          $obj_filase = $sql->nums('',$obj_querye);
          if ($obj_filase!=0) {
            $objse = $sql->objects('',$obj_querye);
            $etiqueta = trim(mb_strtoupper(utf8_decode($objse->descripcion)));
            $texto_etiqueta= "[b]ETIQUETA:   "."[/b] ".$etiqueta;
            $pdf->JLCell("$texto_etiqueta",135,'j');        
          }
        }
      
      //busqueda del Tramitante (poder, agente o tramitante)
      $poder = trim($registro_conc['poder']);
      $tram = agente_tramp($nagen,trim($registro_conc['tramitante']),$poder);
      $texto_tramitante= "[b]TRAMITANTE:  "."[/b] ".trim(utf8_decode($tram));        
      $pdf->JLCell("$texto_tramitante",135,'j'); 
 
	   //verificando si debe ir registros negantes
	   //Modificado el 09/01/2014, segun sandra el 12 es por comentario y no por registro. Req. 584734
      //if (($registro_prio['literal']== '11') or  ($registro_prio['literal']== '12'))         
      if ($registro_conc['literal']== '11') {
	     //Registros Negantes 
	     $reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.tipo_derecho,stzderec.fecha_solic,stzderec.nombre,
stzderec.tramitewebpi,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue
FROM stzderec,stmmarce WHERE registro='$registro_conc[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   

	     //$reg_neg=pg_exec("SELECT stzderec.solicitud,stzderec.nro_derecho,stzderec.nombre,stzderec.tramitewebpi,stmmarce.clase FROM stzderec, stmmarce WHERE registro='$registro_conc[reg_base]' AND stmmarce.nro_derecho = stzderec.nro_derecho");   

        $reg = pg_fetch_array($reg_neg);

        $regneg=trim($registro_conc['reg_base']);
        $derneg=trim($registro_conc['reg_base']);

        if (!empty($regneg)) {
       	 //busqueda del titular y sus datos
	       $titular_neg='';
  	       $res_titular = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.domicilio, stzottid.pais_domicilio
				       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$reg[nro_derecho]'
			               AND stmmarce.nro_derecho=stzottid.nro_derecho
                                       AND stzsolic.titular = stzottid.titular");
	       $filas_found1=pg_numrows($res_titular);
	       $regt = pg_fetch_array($res_titular);
	       for($cont1=0;$cont1<$filas_found1;$cont1++) { 
                 $pais_nombre=pais($regt['pais_domicilio']);
 	         if ($cont1=='0'){
	           $titular_neg= $titular_neg.trim($regt['nombre']).' con Domicilio: '.trim($regt['domicilio']).' País: '.trim($pais_nombre); }
	         else { $titular_neg= $titular_neg."; ".trim($regt['nombre']).' con Domicilio: '.trim($regt['domicilio']).' País: '.trim($pais_nombre); }                
	         $regt = pg_fetch_array($res_titular);
	       } 
          //$negativa = $registro_conc['reg_base'].' Clase: '.$reg['clase'].'  '.utf8_decode(trim($reg['nombre'])).' Titular: '.utf8_decode($titular_neg);          

          $negativa = $registro_conc['reg_base'].', Solicitud: '.$reg['solicitud'].' de Fecha: '.$reg['fecha_solic'].', Modalidad: '.$reg['modalidad'].', Clase: '.$reg['clase'];          

          $texto_negante= "[b]REGISTRO NEGANTE:  "."[/b] ".$negativa;
          $pdf->JLCell("$texto_negante",135,'j');        

          $nombre_negante= "[u]Nombre Marca:"."[/u]   ".utf8_decode(trim($reg['nombre']));
          $pdf->JLCell("$nombre_negante",135,'j');  

          $titular_negante= "[u]Titular:"."[/u]   ".utf8_decode($titular_neg);
          $pdf->JLCell("$titular_negante",135,'j');  

	  $distingue_negante= trim(mb_strtoupper(utf8_decode($reg['distingue'])));
          $txt_distingue_neg= "[u]DISTINGUE:"."[/u]   ".$distingue_negante;
          $pdf->JLCell("$txt_distingue_neg",135,'j');        

          //Imagen Negante
          $vsoln1=substr($reg['solicitud'],-11,4);
          $vsoln2=substr($reg['solicitud'],-6,6);
          $nameimageneg=ver_imagen($vsoln1,$vsoln2,'M');

          if ((file($nameimageneg)) AND ($reg['modalidad']!='D')) {   
	    $x = $pdf->Getx();
            $y = $pdf->Gety();
	    if ($y >= 240) {
	      $pdf->AddPage();
	      $pdf->Image("$nameimageneg",160,15,26,24,'JPG');
              $y = $pdf->Gety(); 	
              $pdf->SetXY($x,$y+5); 		 
            }
            else {	
              $pdf->Image("$nameimageneg",160,$y,26,24,'JPG');
              $y = $pdf->Gety(); 	
              $pdf->SetXY($x,$y+12); 
            }
            $y = $pdf->Gety(); 	
            $pdf->SetXY($x,$y+12); 
            //if ($y >= 245) {  $pdf->AddPage(); }

          }

        $etiqueta_neg='';
        // Obtencion de la Etiqueta
        if ($reg['modalidad']!='D') {
          $obj_queryneg = $sql->query("SELECT * FROM stmlogos WHERE nro_derecho ='$reg[nro_derecho]'");
          $obj_filasneg = $sql->nums('',$obj_queryneg);
          if ($obj_filasneg!=0) {
            $objsneg = $sql->objects('',$obj_queryneg);
            $etiqueta_neg = trim(mb_strtoupper(utf8_decode($objsneg->descripcion)));
            $texto_etiqueta_neg= "[u]ETIQUETA:"."[/u]    ".$etiqueta_neg;
            $pdf->JLCell("$texto_etiqueta_neg",135,'j');        
          }
        }



	     }
      }
	   else {
	     //comentario
        $reg_com=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$registro_conc[nro_derecho]' AND evento='1225' ORDER BY fecha_trans DESC");   
	     $reg_com = pg_fetch_array($reg_com);
        $texto_negante= "[b]COMENTARIO:   "."[/b] ".trim(utf8_decode($reg_com['comentario']));
        $pdf->JLCell("$texto_negante",135,'j');        
      }
      $texto_carga= "[b]FECHA TRANSACCION:   "."[/b] ".trim(utf8_decode($registro_conc['fecha_trans']));
      $pdf->JLCell("$texto_carga",135,'j');        
 
      $registro_conc = pg_fetch_array($resultado);
    } //Fin del For 

    // Fin de Pagina (Firma del Registrador)
    $pdf->ln(8); 
    $pdf->Setfont('Arial','B',8);
    $pdf->MultiCell(190,5,'Total de Solicitudes : '.$totalc,0,'J',0);
    $pdf->Setfont('Arial','',8);
    $pdf->ln(8); 

  }//fin del else
  }// fin del primer for 
  $counter = $counter + 1; 
  if($counter==2) { $articulo= 34; $titulo='Articulo 34'; $tituloneg = "Negadas Artículo 34"; }
}//fin del while

ob_end_clean(); 
//Salida del Reporte
$pdf->Output();

} // fin de Negadas


//Desconexion a la base de datos
$sql->disconnect();

?>
