<?php
// *************************************************************************************
// Programa: a_rptoficio.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza 
// Dirección de Sistemas y Tecnologias de la Información / SAPI / MPPCN
// Año: 2008 - 2009
// Modificado Año 2022 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");
include ("../phpqrcode/qrlib.php");

require ("$include_lib/PDF_tablesep.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit(); }

//Variables de sesion
$login = trim($_SESSION['usuario_login']);
$role  = $_SESSION['usuario_rol'];
$sql   = new mod_db();
$fecha     = fechahoy();
$fechahoy  = hoy();
$hh        = hora();

//Encabezados de Pantallas
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Oficios de Observacion (Despacho Saneador)');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Conexion
$sql->connection($login);

//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("vsol1","vsol2");
  $valores = array($vsol1,$vsol2);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("ERROR: Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

if ($vsol1 > $vsol2) { 
    mensajenew('ERROR: Rango de Solicitudes erroneo ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

 //Query para buscar las opciones deseadas para oficio de forma
 if(!empty($vsol1) and !empty($vsol2) and ($vsol1!='000000') and ($vsol2!='000000')) { 
   $resultado=pg_exec("SELECT stdobras.nro_derecho, stdobras.solicitud, stdobras.titulo_obra, stdobras.tipo_obra, stdobras.fecha_solic, stdobras.estatus 
   			FROM stdobras
   			WHERE ((stdobras.solicitud >='$vsol1') and (stdobras.solicitud <='$vsol2'))
   			AND stdobras.estatus in (3,7)
   			ORDER BY stdobras.solicitud");
 }

//verificando los resultados
if (!$resultado)  { 
    mensajenew('ERROR: PROBLEMA  AL PROCESAR LA BUSQUEDAD ...!!!','javascript:history.back();','N');   
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

$filas_found=pg_numrows($resultado); 
if ($filas_found==0)  {
    mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','javascript:history.back();','N');   
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  } 

  $diripmaq = getRealIP();

  $aa =substr($fechahoy,6,4);  
  $mm =substr($fechahoy,3,2);  
  $dd =substr($fechahoy,0,2);  

  $rutafinal = $ruta_devolucion."/autor/forma";
  $codesDir = "../documentos/devueltas/autor/imagen_qr/"; 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',9);

for($cont=0;$cont<$filas_found;$cont++)   { 
   $reg = pg_fetch_array($resultado);
   $varsol   = $reg['solicitud'];
   $nderec   = $reg['nro_derecho'];
   $vfechasol= $reg['fecha_solic'];
   $tipobra  = $reg['tipo_obra'];
   $estadobr = $reg['estatus'];
   $hh       = hora();

   $hor=substr($hh,0,2);    
   $min=substr($hh,3,2);  
   $seg=substr($hh,6,2);  
   $tur=substr($hh,9,2);  

   $aafs =substr($vfechasol,6,4);  
   $mmfs =substr($vfechasol,3,2);  
   $ddfs =substr($vfechasol,0,2);  
   
   /*
   if ((($login=='rfeghali') || ($login=='rmendoza')) AND ($estadobr==3)) {
     //Nombre del archivo del Oficio de Devolucion
     $archivo = $rutafinal."/".$varsol.".pdf";
     //Nombre del archivo QR 
     $filenameqr= $varsol.".png";
     //Codigo de 15 caracteres
     $codseg2=generarCodigo(15);
     //Codigo de Seguridad Completo      
     $codseg1=$nderec."A".$varsol.$dd.$mm.$aa.$hor.$min.$seg.$tur.'500'.$codseg2.$tipobra.$ddfs.$mmfs.$aafs;
     //Generacion del QR
     $content = "http://webpi.sapi.gob.ve/devolucion/verificadevobr.php?s=$varsol&c=$codseg2";
     QRcode::png($content,$codesDir.$filenameqr,QR_ECLEVEL_L,10,2);
     //Registro de Codigo de la Seguridad    
     $insert_campos="nro_derecho,codigo1,codigo2,usuario,fecha_gen,hora_gen,ip_acceso";
     $insert_valores ="$nderec,'$codseg1','$codseg2','$login','$fechahoy','$hh','$diripmaq'";
     $ins_otros = $sql->insert("stasegudev","$insert_campos","$insert_valores","");   
   }
   */
   
   // Encabezado del pdf
   $pdf->Image('../imagenes/cintillo_mppcn.jpg',10,4,190,12,'JPEG');
   $pdf->Image('../imagenes/logosapi.jpg',190,4,20,12,'JPEG');

   $y = $pdf->Gety();
   $pdf->SetXY(10,$y+10);

   $pdf->MultiCell(0,4,'DIRECCION NACIONAL DEL DERECHO DE AUTOR',0,1,'L');
   $pdf->MultiCell(0,4,'REGISTRO DE LA PRODUCCION INTELECTUAL',0,1,'L');

   $pdf->ln(4);
   $pdf->SetFont('Arial','B',9);
   //$pdf->MultiCell(198,4,utf8_decode('OFICIO DE DEVOLUCIÓN A SOLICITUD No.:  ').$reg['solicitud'],0,'R',0);
   $pdf->MultiCell(198,4,utf8_decode('DESPACHO SANEADOR A SOLICITUD No.:  ').$reg['solicitud'],0,'R',0);
   $pdf->SetFont('Arial','',9);

   /*
   if ((($login=='rfeghali') || ($login=='rmendoza')) AND ($estadobr==3)) {
     $pdf->SetFont('Arial','B',7);
     $pdf->Cell(198,3,$codseg1,0,1,'R');
     $pdf->SetFont('Arial','B',10);
   }
   */
   
   // Busqueda del Solicitante
   $resul_sol=pg_exec("SELECT stzsolic.nombre FROM stzsolic,stdobsol WHERE  stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular ");
   $regis = pg_fetch_array($resul_sol);

   //Cuerpo del Oficio de Devolucion
   $pdf->ln(4);
   $pdf->Cell(115,4,'CIUDADANO(A): ',0,1);
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(199,4,utf8_decode($regis['nombre']),0,1);
   $pdf->ln(2);
   $pdf->MultiCell(198,4,'TITULO DE LA OBRA: '.utf8_decode($reg['titulo_obra']),0,'L',0);
   $pdf->SetFont('Arial','',9);
   $pdf->ln(5);

   $pdf->MultiCell(198,5,utf8_decode('     Vista la solicitud presentada en fecha '.$vfechasol.' y realizado como ha sido el examen de la misma de conformidad a lo establecido en los artículos 39 al 52 y 55 al 57 del Reglamento de la Ley sobre el Derecho de Autor, esta Dirección Nacional de Derecho de Autor notifica del presente despacho saneador, a los fines de subsanar las omisiones siguientes:'),0,'J',0);
   $pdf->SetFont('Arial','B',9);

   $pdf->ln(1);
   $res_des=pg_exec("SELECT  a.nro_derecho,b.*
 			               FROM stdobras a,  stdcaded b
 			               WHERE b.nro_derecho = '$nderec' 
			                 AND b.nro_derecho= a.nro_derecho  
 			               ORDER BY b.cod_causa");

   $filas_found1= pg_numrows($res_des); 
   $regdes = pg_fetch_array($res_des);

   $res_coded=pg_exec("SELECT * FROM stdcoded order by cod_causa");
   $filas_coded= pg_numrows($res_coded);
   $reg_coded = pg_fetch_array($res_coded);

   $pdf->ln(3);
    
   for ($j=0; $j<$filas_coded; $j++) {
       if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
          $pdf->MultiCell(198,6,'- '.utf8_decode($reg_coded['desc_causa']),0,'J',0);
	        $regdes = pg_fetch_array($res_des);
 	     }
       $reg_coded = pg_fetch_array($res_coded);
   }

   $res_otros=pg_exec("SELECT * FROM stdotrde WHERE nro_derecho = '$nderec'");
   $filas_otros= pg_numrows($res_otros);

   // Busqueda de Causa de Devolucion (otros) 
   if ($filas_otros==0) {  }
   else { 
     $regotr = pg_fetch_array($res_otros);
     $str_otros = str_replace('“','"',$regotr['otros']);
     $str_otros = str_replace('”','"',$str_otros);
     $pdf->MultiCell(198,6,'- '.utf8_decode($str_otros),0,'J',0); 
   }
     
   //Nota al pie
   $pdf->ln(4);
   $pdf->SetFont('Arial','',9);
   $pdf->MultiCell(198,5,utf8_decode('     Finalmente y en atención a lo anterior hago de su conocimiento que transcurrido el lapso de 15 días hábiles establecido en el artículo 50 de la Ley Orgánica de Procedimientos Administrativos, sin que haya subsanado la omisión supra indicada, se procederá al cierre del expediente.'),0,'J',0);
   $pdf->ln(3);
   $vfecha_ccs=fecha_ccs();
   $pdf->MultiCell(198,5,'     En Caracas '.$vfecha_ccs,0,'J',0);
   $pdf->SetFont('');
   
   //$pdf->ln(20);
   //$pdf->SetFont('Arial','',10);
   //$pdf->MultiCell(198,5,'     Coordinadora                                                                          Recibido por:',0,'J',0);
   //$pdf->MultiCell(198,5,'                                                                                                     C.I.:',0,'J',0);
   //$pdf->MultiCell(198,5,'                                                                                                     Fecha:',0,'J',0);
   //$pdf->ln(4);
   //$pdf->SetFont('Arial','',7);
   //$pdf->MultiCell(198,5,'      Realizado por: '.$login,0,'J',0);

   /*
   if ((($login=='rfeghali') || ($login=='rmendoza')) AND ($estadobr==3)) {
     $y = $pdf->Gety();
     $pdf->SetXY(10,$y+10);
     $pdf->ln(5);
     $pdf->Image('../imagenes/firma_digital_dnda.jpg',45,$y,125,65,'JPEG');
     $pdf->Image('../documentos/devueltas/autor/imagen_qr/'.$filenameqr,170,$y+5,35,35,'PNG');
   }
   */
   
   //Creacion del Archivo en Servidor
   //$pdf->Output($archivo);
   if  ($cont+1!=$filas_found) {$pdf->AddPage();}
 }

//Desconexion a la Base de Datos
$sql->disconnect();
ob_end_clean(); 
$pdf->Output();

?>
