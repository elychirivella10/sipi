<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("$include_lib/jlpdf_pres.php");
require ("$include_lib/PDF_tablepres.php");
require("$include_lib/MPDF45/mpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$fecha = fechahoy();
$fechahoy = hoy();

//Pantalla Titulos
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Solicitudes Presentadas Formato Bolet&iacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Solicitudes Presentadas Formato Boletín";

//Validacion de Entrada
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$usuario=$_POST["usuario"];

//Query para buscar las opciones deseadas
$where='stzderec.estatus IN (1001,1002,1004,1005,1006) AND stzevtrd.evento=1200 ';
$titulo='';

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


if(!empty($fecsold) and !empty($fecsolh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
	   $titulo= $titulo." DESDE:"." $fecsold"." HASTA:"." $fecsolh";
	}
	else { 
		$where = $where." ((stzderec.fecha_solic >= '$fecsold') and (stzderec.fecha_solic <='$fecsolh'))";
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
$where = $where." and stzderec.tipo_mp='M'";

//Conexion a la base de datos  
$sql = new mod_db();
$sql->connection($login);

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus
 FROM  stzderec, stmmarce, stzevtrd 
 WHERE $where  ORDER BY 1"); 
 
//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_rptpsolpre.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','m_rptpsolpre.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

$cantidad=pg_exec("SELECT  DISTINCT ON (stzderec.solicitud) stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus 
 FROM  stzderec, stmmarce, stzevtrd 
 WHERE $where "); 

$filas_res=pg_numrows($cantidad); 
$total=$filas_res;

//Inicio del Pdf
$pdf=new JLPDF('P','mm','Letter');
$pdf->Open();
$pdf->AliasNbPages();

if ($filas_resultado==0) {
  $mensaje= $mensaje.'* No se genero Solicitadas  ';

} 
else {
   $pdf->AddPage();
   // Montando los resultados en el formato boletin solicitadas
   //$nro_resoluc = $nro_resoluc+1;
   $pdf->Setfont('Arial','B',20);
   $pdf->MultiCell(190,5,utf8_decode('MARCAS PRESENTADAS'),0,'C',0);
   $pdf->ln(6); 
   // $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
   $pdf->Setfont('Arial','B',8);
   $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
   $pdf->Setfont('Arial','',8);
   $pdf->ln(2); 
   $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fechahoy)),0,'J',0); $pdf->Setfont('Arial','B',8);
   //$pdf->MultiCell(190,5,$anoi.' y '.$anof,0,'J',0);
   //$pdf->MultiCell(190,5,utf8_decode('RESOLUCIÓN N° '.$nro_resoluc),0,'J',0);
   $pdf->ln(4); 
   $pdf->MultiCell(190,5,'MARCAS COMERCIALES PRESENTADAS '.$titulo,0,'C',0);
   $pdf->Setfont('Arial','B',8);
   $pdf->ln(4); 
   //$pdf->MultiCell(190,5,mb_strtoupper(utf8_decode('Esta Autoridad Administrativa, en cumplimiento con lo establecido en los artículos 70, 71 y 76 de la Ley de Propiedad Industrial, ordena la publicación en el presente Boletín de las marcas y lemas comerciales solicitadas; a los efectos de que los interesados puedan objetar dicha solicitud y oponerse a la concesión de la marca, con fundamento a lo establecido en el artículo 77 ejusdem, dentro de un lapso de treinta (30) días hábiles contados desde la presente publicación:')),0,'J',0);
     
   for($cont=0;$cont<$filas_resultado;$cont++) { 
      $nsolic=$registro['solicitud'];
      $nagen=$registro['agente'];
      $nderec=$registro['nro_derecho'];
      $ntipom=$registro['tipo_derecho'];
      $modalidad= $registro['modalidad'];
      $clase= $registro['clase'];
      $x = $pdf->Getx();
      $y = $pdf->Gety();
      if ($y >= 245) {  $pdf->AddPage(); }
       $pdf->Setfont('Arial','B',12);
       $pdf->MultiCell(190,4,'_______________________________________________________________________________',0,'J',0);
       $pdf->Setfont('Arial','B',8);
            
      $pdf->MultiCell(135,4,'Insc. '. $registro['solicitud'].' del '.Cambiar_fecha_mes($registro['fecha_solic']).'      Modalidad:  '.$modalidad.',      Tipo:  '.$ntipom,0,'J',0);
      $pdf->Setfont('Arial','',8);
      if ($modalidad == 'M') { //Nombre de la marca en caso de que sea mixta
        $texto_nombre= "[b]NOMBRE DE LA MARCA:  [/b] ".trim(utf8_decode($registro['nombre']));
        $pdf->JLCell("$texto_nombre",135,'j');       
       //  $pdf->MultiCell(135,4,'NOMBRE DE LA MARCA: '.trim(utf8_decode($registro['nombre'])),0,'J',0); 	 
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
	      $titular= $titular.utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }
	   else { $titular= $titular.", ".utf8_decode(trim($regt['nombre'])).' Domicilio: '.utf8_decode(trim($regt['domicilio'])).utf8_decode(' País: ').utf8_decode(trim($pais_nombre)); }                
	   $regt = pg_fetch_array($res_titular);
	} 
	
         $y = $pdf->Gety(); 
       //  $texto= $pdf->Setfont('Arial','B',8)."SOLICITADA POR: ".$pdf->Setfont('Arial','',9);
       //  $pdf->MultiCell(135,4,$texto.utf8_decode($titular),0,'J',0); 
        $texto_titular= "[b]SOLICITADA POR:   "."[/b] ".$titular;
        $pdf->JLCell("$texto_titular",135,'j');

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
	
	if ($clase == 46) { $clase='NC';}
	if ($clase == 47) { $clase='LC';}			
	$distingue= trim(mb_strtoupper(utf8_decode($registro['distingue']))).'[b] Clase: '.$clase.' [/b] ';
	//$distingue= trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$clase;
   $texto_distingue= "[b]PARA DISTINGUIR:   "."[/b] ".$distingue;
   $pdf->JLCell("$texto_distingue",135,'j');        
   //  $pdf->MultiCell(135,4,'Para distinguir: '.trim(strtolower(utf8_decode($registro['distingue']))).' Clase '.$clase,0,'J',0);
      
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
   $poder = $registro['poder'];
   $tram = agente_tramp($nagen,$registro['tramitante'],$poder);
   $texto_tramitante= "[b]TRAMITANTE:  "."[/b] ".trim(utf8_decode($tram));        
   $pdf->JLCell("$texto_tramitante",135,'j'); 
   $registro = pg_fetch_array($resultado);
  }
 
  // Fin de Pagina (Firma del Registrador)
   $pdf->ln(6); 
   $pdf->Setfont('Arial','B',8);
   $pdf->MultiCell(190,5,'Total de Solicitudes Presentadas : '.$total,0,'J',0);
   $pdf->Setfont('Arial','B',8);
   //$pdf->Setfont('Arial','B',12);
   //$pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
   //$pdf->Setfont('Arial','B',8);
   //$pdf->MultiCell(190,5,'Publiquese,',0,'L',0);
   //$pdf->ln(20); 
   //$pdf->MultiCell(190,5,utf8_decode($registrador1),0,'C',0);
   //$pdf->Setfont('Arial','B',7);
   //$pdf->MultiCell(190,5,utf8_decode($registrador2),0,'C',0);
   //$pdf->MultiCell(190,5,utf8_decode($registrador3),0,'C',0);       
   //$pdf->MultiCell(190,5,utf8_decode($registrador4),0,'C',0); 
   //$pdf->MultiCell(190,5,utf8_decode($registrador5),0,'C',0);         

ob_end_clean(); 
//Salida del Reporte
$pdf->Output();
          
} // fin de solicitadas

//Desconexion a la base de datos
$sql->disconnect();

?>
