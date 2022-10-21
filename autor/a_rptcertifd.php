<?php
//Programa de Certificados de Derecho de Autor. Todas las Planillas menos las de Actos y Contratos.
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
require ("$include_lib/PDF_table.php");
require ("$include_lib/jlpdf.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Formato de Cedulas
function cedula($ced){
  $cadena=(string)$ced;
  $letra=substr($cadena,-10,1);
  if ($letra=='V' or $letra=='E') {
  $ult3=substr($cadena,7,3);
  $ant3=substr($cadena,4,3);
  $pri2=substr($cadena,1,3);
  $cedula= $letra.'-'.(string)(int)$pri2.'.'.$ant3.'.'.$ult3;}
  else {
  $pri=substr($cadena,1,9);
  $cedula= $letra.'-'.(string)(int)$pri;}
return ($cedula);
}

function consultar($idsol,$nderec) {
	$resul_tit=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion FROM stzsolic,stdobtit WHERE stzsolic.identificacion = '$idsol' and stdobtit.nro_derecho = '$nderec' and stzsolic.titular = stdobtit.titular ");
	$regis = pg_fetch_array($resul_tit);
        $nombre= $regis['nombre']; $cedula=$regis['identificacion']; 
   return array($cedula,$nombre);
 }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$vsold=$_POST["vsold"];
$vsolh=$_POST["vsolh"];
$log=substr($login,0,2);

if ($vsold=='' || $vsolh=='') {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl');
	 $sql->disconnect(); exit(); 
}

//Query para buscar los certificados de dnda en el rango correspondiente
if(!empty($vsold) and !empty($vsolh)) {  
   $resultado=pg_exec("SELECT * FROM stdobras WHERE stdobras.solicitud BETWEEN '$vsold' AND '$vsolh' ORDER BY solicitud");
}

//verificando los resultados
if (!$resultado) { 
     $smarty->display('encabezado1.tpl');
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); } 

$reg = pg_fetch_array($resultado);


//Inicio del Pdf
$pdf=new JLPDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Times','',11);
	
for($cont=0;$cont<$filas_found;$cont++)   { 

 	//tipo de obra
	if ($reg['tipo_obra']=='OL') {$vtip= 'Registro de Obras Literarias';}
	if ($reg['tipo_obra']=='AV') {$vtip= 'Registro de Obras de Arte Visual';}
	if ($reg['tipo_obra']=='OE') {$vtip= 'Registro de Obras Escenicas';}
	if ($reg['tipo_obra']=='OM') {$vtip= 'Registro de Obras Musicales';}
	if ($reg['tipo_obra']=='AR') {$vtip= 'Registro de Obras Audiovisuales y Radiofónicas';}
	if ($reg['tipo_obra']=='PC') {$vtip= 'Programas de Computación y Base de Datos';}
	if ($reg['tipo_obra']=='PF') {$vtip= 'Registro de Obras de Producciones Fonografícas';}
	if ($reg['tipo_obra']=='IE') {$vtip= 'Registro de Interpretaciones y Ejecuciones Artisticas';}
	if ($reg['tipo_obra']=='AC') {$vtip= 'Actos y Contratos';}

 $varsol=$reg['solicitud'];
 $nregis=$reg['registro'];
 $nderec=$reg['nro_derecho'];

//Valores necesarios de fecha
$dia=substr($reg['fecha_regis'],-10,2);
$mes=substr($reg['fecha_regis'],-7,2);
$ano=substr($reg['fecha_regis'],-4,4);

if ($mes =='1') {$mes ='enero';}
if ($mes =='2') {$mes ='febrero';}
if ($mes =='3') {$mes ='marzo';}
if ($mes =='4') {$mes ='abril';}
if ($mes =='5') {$mes ='mayo';}
if ($mes =='6') {$mes ='junio';}
if ($mes =='7') {$mes ='julio';}
if ($mes =='8') {$mes ='agosto';}
if ($mes =='9') {$mes ='septiembre';}
if ($mes =='10') {$mes ='octubre';}
if ($mes =='11') {$mes ='noviembre';}
if ($mes =='12') {$mes ='diciembre';}

//Clasificación
if ($reg['clase']=='I') {$clase='inédita';}
if ($reg['clase']=='P') {$clase='publicada';}
if ($reg['origen']=='O') {$origen='originaria';}
if ($reg['origen']=='D') {$origen='derivada';}
if ($reg['forma']=='I') {$forma='individual';}
if ($reg['forma']=='E') {$forma='en colaboración';}
if ($reg['forma']=='C') {$forma='colectiva';}

//Depositos
$res_dep=pg_exec("SELECT * FROM stdobras WHERE nro_derecho='$nderec'");
$resdep = pg_fetch_array($res_dep);
if ($resdep['n_ejemplares'] == 1 ) {$deposito= '('.$resdep['n_ejemplares'].') ejemplar';}
else {$deposito= '('.$resdep['n_ejemplares'].') ejemplares';}
//Solicitante
$resul_sol=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobsol.domicilio, stzsolic.telefono1   FROM stzsolic,stdobsol WHERE  stdobsol.nro_derecho = '$nderec' and stzsolic.titular = stdobsol.titular ");
$regis_sol = pg_fetch_array($resul_sol);

//Autores
 $autor='';
 $resul_aut=pg_exec("SELECT DISTINCT ON (stzsolic.identificacion) stzsolic.identificacion, stzsolic.nombre, stdobaut.titular FROM stzsolic,stdobaut
WHERE stdobaut.nro_derecho = '$nderec' and stzsolic.titular = stdobaut.titular ");
 $regis_aut = pg_fetch_array($resul_aut);
 $filas_found_regaut =pg_numrows($resul_aut);
 for($cont3=0;$cont3<$filas_found_regaut;$cont3++) {
    $resul_seudo=pg_exec("SELECT seudonimo FROM stzdaper WHERE titular = '$regis_aut[titular]' ");
    $filas_found_seudo =pg_numrows($resul_seudo);
    $regis_seu = pg_fetch_array($resul_seudo);
    $ced=$regis_aut['identificacion'];
    $cedula=cedula($ced);
    $cadena_seudo= strlen(trim($regis_seu['seudonimo']));
    if ($cadena_seudo == 0)  {
       $autor= $autor." [b]".$regis_aut['nombre']."[/b], titular de la cédula de identidad [b]"."N° ".$cedula."[/b]";
    } 
    else {
       $autor= $autor." [b]".$regis_aut['nombre']."[/b], titular de la cédula de identidad [b]"."N° ".$cedula."[/b], cuyo seudonimo declara ser [b]".trim($regis_seu['seudonimo'])."[/b]";
    }
    $regis_aut = pg_fetch_array($resul_aut);
    if ($cont3+1!=$filas_found_regaut) {$autor= $autor." y";}
 }
// Verificando la exoneracion de pago
$resultado5=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '67' ");   
$filas_found5=pg_numrows($resultado5);
if ($filas_found5==0) {
   //Tasa inicial
   $resultado4=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '64' ");   
   $filas_found4=pg_numrows($resultado4);
   $reg4 = pg_fetch_array($resultado4);
   $plan_ini= $reg4['documento'];
   $fecha_ini= $reg4['fecha_event'];
   //Tasa Derechos
   $resultado3=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '65' ");   
   $filas_found3=pg_numrows($resultado3);
   if ($filas_found3==0) {
     $resultado3=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho='$nderec' AND evento = '66' ");   
   }
   $reg3 = pg_fetch_array($resultado3);
   $plan_der= $reg3['documento'];
   $fecha_der= $reg3['fecha_event'];
   $texto_tasa= "La tasa inicial según planilla "."[b]N° ".$plan_ini."[/b] de fecha ".$fecha_ini.", es de una unidad tributaria (U.T.1) y los Derechos de Registro según planilla "."[b]N° ".$plan_der."[/b] de fecha ".$fecha_der.", son: cinco unidades tributarias (U.T.5). ";
}
else {
   $texto_tasa= "Los derechos por concepto de Impuesto al Fisco Nacional quedan exentos. (Artículo 14 de la Ley Orgánica de Hacienda Pública Nacional). ";
}


//Encabezados del documento
$pdf->SetFont('Times','B',11);
$pdf->Ln(67);

$pdf->Cell(15,8,(utf8_decode('REGISTRO N° ').$reg['registro']),0,0);
$pdf->Ln(10);
$pdf->SetFont('Times','',11);
$pdf->MultiCell(0,5,utf8_decode('DIRECCIÓN NACIONAL DE DERECHO DE AUTOR.- REGISTRO DE LA PRODUCCIÓN INTELECTUAL.-'),0,'J');
$pdf->Ln(1);
$pdf->MultiCell(0,5,utf8_decode('Caracas, a los '.$dia.' días del mes de '.$mes.' del '.$ano),0,'J');
$pdf->Ln(6);
$pdf->MultiCell(0,5,utf8_decode('199° y 150°'),0,'C');
$pdf->Ln(6);

//coletilla del solicitante
$ced=$regis_sol['identificacion'];
$cedula_sol=cedula($ced);
$letra=substr($cedula_sol,0,1);
 if ($letra=='V' or $letra=='E') {
  $texto_solicitante= "ciudadano(a) [b]".$regis_sol['nombre']."[/b], titular de la Cédula de Identidad [b]N° ".$cedula_sol;}
 else {
  $texto_solicitante= "[b]".$regis_sol['nombre'].", Rif N° ".$cedula_sol;
 }

//verificando si tiene titulares de los derechos patrimoniales
$titular='';
$res_tit=pg_exec("SELECT * FROM stdobtit WHERE nro_derecho='$nderec'");
$restit = pg_fetch_array($res_tit);
$filas_found_regtit =pg_numrows($res_tit);
if ($filas_found_regtit <> 0)  { 
   $idsol= trim($restit['doc_titular']);
   $info = consultar($idsol,$nderec);
   $cedula_sol=cedula($info['0']);
   $letra=substr($cedula_sol,0,1);
   if ($letra=='V' or $letra=='E') {
       $titular=" y cuyo titular de los derechos patrimoniales declara ser: [b]".$info['1']."  N°".$cedula_sol."[/b]";}
   else { 
      if (trim($cedula_sol)=='' or empty($cedula_sol) or $cedula_sol=='J000000000') {
        $titular=" y cuyo titular de los derechos patrimoniales declara ser: [b]".$info['1']."[/b]"; }
      else { 
        $titular=" y cuyo titular de los derechos patrimoniales declara ser: [b]".$info['1']." Rif N°".$cedula_sol."[/b]";} }
}


//Texto Cuerpo Principal

$texto= "Vista la anterior solicitud de registro presentada por ".$texto_solicitante."[/b], para la inscripción de la obra [b]''".$reg['titulo_obra']."''[/b], en planilla de [b]".$vtip." N° ".$reg['solicitud']."[/b] y su respectivo depósito en ".$deposito." declarada como obra ".$clase.", ".$origen.", ".$forma.", cuyo autor(a) declara ser, ".$autor .$titular.", por ante el Registro de la Producción Intelectual, se otorga el presente Certificado. Agréguese la original al Protocolo respectivo del mes de ".$mes." junto a los recaudos presentados. ".$texto_tasa." Quedó registrada bajo el "."[b]N° ".trim($reg['registro'])."[/b], a los ".$dia." días del mes de ".$mes." del año ".$ano.". El Registro da fe de la existencia de la obra, producto o producción y del hecho de su divulgación o publicación. SE PRESUME, SALVO PRUEBA EN CONTRARIO, QUE LAS PERSONAS INDICADAS COMO TITULARES EN LA SOLICITUD, GOZAN DEL DERECHO EXCLUSIVO DE AUTOR." ;

$pdf->JLCell(utf8_decode("$texto"),188,'j');
$pdf->Ln(4);

$texto2= "El presente registro es meramente facultativo y declarativo no constitutivo de derecho. El Registro de una obra, producto o producción no prejuzga sobre la originalidad de lo declarado como obra ni sobre su autoría y titularidad. Solamente da fecha cierta de su presentación y de la(s) persona(s) solicitante(s). La omisión del registro no perjudica el goce y ejercicio de los derechos reconocidos por la ley. (Art. 107 L.S.D.A)";

$pdf->SetFont('Times','',10);
//$pdf->JLCell(utf8_decode("$texto2"),188,'j');
$pdf->MultiCell(0,5,utf8_decode($texto2),0,'J');
$pdf->Ln(3);

$texto3="Por delegación del ciudadano Ministro:";
//$pdf->JLCell(utf8_decode("$texto3"),188,'j');
$pdf->MultiCell(0,5,utf8_decode($texto3),0,'J');
$pdf->Ln(8);
$pdf->MultiCell(0,5,utf8_decode('ROSALBA FEGHALI GEBRAEL'),0,'C');
$pdf->SetFont('Times','B',11);
$pdf->MultiCell(0,5,utf8_decode('Directora Nacional de Derecho de Autor'),0,'C');
$pdf->MultiCell(0,5,utf8_decode('Resolución No 020/2022, de fecha 24/03/2022'),0,'C');
$pdf->MultiCell(0,5,utf8_decode('Publicado en Gaceta Oficial 42.352 de fecha 05/04/2022'),0,'C');
$pdf->SetFont('Times','',11);
$pdf->Ln(3);
//$pdf->MultiCell(0,5,utf8_decode('MM/'.$log),0,'J');

 $reg = pg_fetch_array($resultado);
 if  ($cont+1!=$filas_found) {$pdf->AddPage();}

}     
   
//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();
?>
