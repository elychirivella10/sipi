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
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Solicitudes Formato Bolet&iacute;n por Estatus');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Solicitudes Formato Boletín";

//Validacion de Entrada
//$fecsold=$_POST["fecsold"];
//$fecsolh=$_POST["fecsolh"];
//$usuario=$_POST["usuario"];
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$registrod1=$_POST["vreg1d"];
$registroh1=$_POST["vreg2d"];
$registrod2=$_POST["vreg1h"];
$registroh2=$_POST["vreg2h"];
$estatus=$_POST["estatus"];

$vsold=($vsol1.'-'.$vsol2);
$vsolh=($vsol1h.'-'.$vsol2h);

$registrod= $registrod1.$registroh1;
$registroh= $registrod2.$registroh2;

if ($vsolh <$vsold) { 
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');    
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Conexion a la base de datos  
$sql = new mod_db();
$sql->connection($login);

$desc_est = estatus($estatus);
$titulo='';
$titulo1= " ESTATUS: ".($estatus-1000)." - ".$desc_est;

 $where = "stzderec.tipo_mp='M' ";
 $where = $where." and (stzderec.estatus='$estatus')";

 $punt=0;
 if ($vsold == "-") { $punt=1; }
 if ($vsolh == "-") { $punt=1; }

 if (($punt!=1) and (!empty($vsold) and !empty($vsolh))) { 
 	$where = $where." and ((stzderec.solicitud >= '$vsold') and (stzderec.solicitud <='$vsolh'))"; 
   $titulo= $titulo." Desde Solicitud:"." $vsold"." Hasta:"." $vsolh";
   $orderby = 'stzderec.solicitud';
 }

 if(!empty($registrod) and !empty($registroh)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzderec.registro >= '$registrod') and (stzderec.registro <='$registroh'))";
 	   $titulo= $titulo." Desde Registro:"." $registrod"." Hasta:"." $registroh";
	}
	else { 
		$where = $where." ((stzderec.registro >= '$registrod') and (stzderec.registro <='$registroh'))";
 	   $titulo= $titulo." Desde Registro:"." $registrod"." Hasta:"." $registroh";
	}
  $orderby = 'stzderec.registro';
 }

 $where = $where." and stzderec.nro_derecho=stmmarce.nro_derecho";

// Armando el query
$resultado=pg_exec("SELECT stzderec.solicitud,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.poder,stzderec.estatus
 FROM  stzderec, stmmarce WHERE $where ORDER BY 1"); 
 
 //$que="counter=$counter , SELECT stzderec.solicitud,stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.estatus
 //FROM  stzderec, stmmarce WHERE $where ORDER BY 1";
 //echo "$que";
 //exit();

//verificando los resultados
if (!$resultado)    { 
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','mb_rptpsolpre.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','mb_rptpsolpre.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

$cantidad=pg_exec("SELECT  DISTINCT ON (stzderec.solicitud) stzderec.nombre,stzderec.nro_derecho,stzderec.fecha_solic,stzderec.agente,stzderec.tramitante,stmmarce.clase,stmmarce.ind_claseni,stmmarce.modalidad,stmmarce.distingue,stzderec.tipo_derecho,stzderec.poder,stzderec.estatus 
 FROM  stzderec, stmmarce WHERE $where "); 

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
   $pdf->Setfont('Arial','B',18);
   $pdf->MultiCell(190,5,utf8_decode('MARCAS , NOMBRES, LEMAS Y SERVICIOS COMERCIALES'),0,'C',0);
   $pdf->ln(6); 
   // $pdf->MultiCell(190,5,'_______________________________________________________________________________',0,'J',0);
   $pdf->Setfont('Arial','B',8);
   $pdf->MultiCell(190,5,'REPUBLICA BOLIVARIANA DE VENEZUELA, MINISTERIO DEL PODER POPULAR PARA EL COMERCIO - SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL - REGISTRO DE LA PROPIEDAD INDUSTRIAL',0,'J',0);
   $pdf->Setfont('Arial','',8);
   $pdf->ln(2); 
   $pdf->MultiCell(190,5,'Caracas, '.strtolower(Cambiar_fecha_mes($fechahoy)),0,'J',0); $pdf->Setfont('Arial','B',7);
   $pdf->ln(4); 
   $pdf->MultiCell(190,5,$titulo.' y '.$titulo1,0,'C',0);
   $pdf->Setfont('Arial','B',8);
   $pdf->ln(4); 
     
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
      
   //busqueda del Tramitante (poder, agente o tramitante)
   $poder = trim($registro['poder']);
   $tram = agente_tramp($nagen,trim($registro['tramitante']),$poder);
   $texto_tramitante= "[b]TRAMITANTE:  "."[/b] ".trim(utf8_decode($tram));        
   $pdf->JLCell("$texto_tramitante",135,'j'); 
   if (!empty($poder)) {
     $texto_poder= "[b]PODER NO:  [/b] ".$poder;
     $pdf->JLCell("$texto_poder",135,'j');       
   }
   $registro = pg_fetch_array($resultado);
  }
 
  // Fin de Pagina (Firma del Registrador)
   $pdf->ln(6); 
   $pdf->Setfont('Arial','B',8);
   $pdf->MultiCell(190,5,'Total de Solicitudes: '.$total,0,'J',0);
   $pdf->Setfont('Arial','B',8);

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
//Salida del Reporte
$pdf->Output();
          
} // fin de solicitadas

?>
