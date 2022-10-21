<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();
include ("../z_includes.php");

require ("$include_lib/PDF_tablesep.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables de sesion
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Impresi&oacute;n de Oficios de Devoluci&oacute;n Ley 55');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Validacion de Entrada
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vsol1h=$_POST["vsol1h"];
$vsol2h=$_POST["vsol2h"];
$nconex = $_POST['nconex'];

$vsold=($vsol1.'-'.$vsol2);
$vsolh=($vsol1h.'-'.$vsol2h);

if ($vsold=='-' and $vsolh=='-') {
   $vsold=$_GET["vsol"];
   $vsolh=$_GET["vsol"];
}

// Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("vsold","vsolh");
  $valores = array($vsold,$vsolh);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $smarty->display('encabezado1.tpl');
     mensajenew("Hay Informacion asociada que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

if ($vsold=='-' || $vsolh=='-' ) {
    $smarty->display('encabezado1.tpl');
    mensajenew('Datos Incorrectos o Vacios ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vsolh < $vsold) { 
    $smarty->display('encabezado1.tpl');
    mensajenew('Rango de solicitudes erroneo ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }


 //Query para buscar las opciones deseadas para oficio 
 if(!empty($vsold) and !empty($vsolh) and ($vsold!='0000-000000') and ($vsolh!='0000-000000')) { 
   $resultado=pg_exec("SELECT b.solicitud, b.tramitante, b.nombre, b.agente,b.nro_derecho,b.registro,b.estatus    				
			FROM stmmarce a, stzderec b 
   			WHERE  a.nro_derecho = b.nro_derecho
			AND b.solicitud between '$vsold' and '$vsolh' 
			AND tipo_mp='M' 
   			AND b.estatus in (1200,1113,1116,1118)
			ORDER BY b.solicitud");
 }

//verificando los resultados
if (!$resultado)  { 
    $smarty->display('encabezado1.tpl');
    mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)  {
    $smarty->display('encabezado1.tpl');
    mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();  } 
$reg = pg_fetch_array($resultado);

//Incio de la Clase de PDF 
$smarty->assign('n_conex',$nconex); 

//Inicio del Pdf
$pdf=new PDF_Table('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',10);

for($cont=0;$cont<$filas_found;$cont++)   { 
   $varsol=$reg['solicitud'];
   $nregis=$reg['registro'];
   $nagen=$reg['agente'];
   $nderec=$reg['nro_derecho'];
   $tipo_esta=$reg['estatus'];

    $pdf->MultiCell(0,4,'      REPUBLICA BOLIVARIANA DE VENEZUELA.- MINISTERIO DEL PODER POPULAR PARA EL COMERCIO.- SERVICIO AUTONOMO DE LA PROPIEDAD INTELECTUAL.- REGISTRO DE LA PROPIEDAD INDUSTRIAL.',0,1,'C');
    $pdf->ln(3);
    $pdf->Cell(115,9,'CIUDADANO(A): ',0,0);
    $pdf->Cell(59,4,utf8_decode('OFICIO DE DEVOLUCION A SOLICITUD N° '),0,0,'R');
    $pdf->Cell(209,4,$reg['solicitud'],0,1);
    $tram = agente_tram($nagen,$reg['tramitante']);
    $pdf->Cell(42,10,utf8_decode($tram),0,1);
    $pdf->Cell(15,4,'Marca:',0,0);
    $pdf->Cell(20,4,$reg['nombre'],0,1);
    $pdf->ln(2);
    $pdf->MultiCell(198,4,utf8_decode('         Esta Autoridad Administrativa fundamentada en el artículo 1 de la Ley Organica de Procedimientos Administrativos (L.O.P.A.), una vez practicado el examen correspondiente a la solicitud en referencia, decide de conformidad con lo establecido en los artículos 50 (ejusdem), 71, 72, 75 de la Ley de Propiedad Industrial, devolver dicha solicitud a los fines de que el interesado se sirva subsanar las omisiones señaladas con una (X) en el presente oficio; y una vez contestado correctamente el oficio de devolución, se proceda a ordenar la publicación en prensa de conformidad con el artículo 76 de la Ley de Propiedad Industrial y en el Boletín de la Propiedad Industrial:'),0,'J',0);


    if (($tipo_esta==1200) || ($tipo_esta==1113)) {  
      $res_des=pg_exec("SELECT  c.nro_derecho,c.cod_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
 					  FROM stmmarce a, stzderec b, stzcaded c
 					  WHERE c.nro_derecho = '$nderec' 
					  AND c.nro_derecho= b.nro_derecho  
 					  AND b.nro_derecho = a.nro_derecho 
					  AND c.derecho = 'M'
					  AND c.grupo = 'M'
					  AND c.tipo_dev = 'M'
 					  ORDER BY c.cod_causa"); }

    if (($tipo_esta==1116) || ($tipo_esta==1118)) {  
      $res_des=pg_exec("SELECT  c.nro_derecho,c.cod_causa,c.derecho,c.grupo,b.solicitud, b.tramitante, b.nombre, b.agente 
 					  FROM stmmarce a, stzderec b, stzcaded c
 					  WHERE c.nro_derecho = '$nderec' 
					  AND c.nro_derecho= b.nro_derecho  
 					  AND b.nro_derecho = a.nro_derecho 
					  AND c.derecho = 'M'
					  AND c.grupo = 'M'
					  AND c.tipo_dev = 'D'
 					  ORDER BY c.cod_causa"); }

    $filas_found1= pg_numrows($res_des); 
    $regdes = pg_fetch_array($res_des);

    $res_coded=pg_exec("SELECT * FROM stzcoded WHERE derecho = 'M' AND grupo = 'M' order by cod_causa");
    $filas_coded= pg_numrows($res_coded);
    $reg_coded = pg_fetch_array($res_coded);

    $pdf->ln(3);

    for ($j=0; $j<$filas_coded; $j++) {
	//echo "coded: ".$reg_coded['cod_causa']."des: ".$regdes['cod_causa'];
         if ($reg_coded['cod_causa'] == $regdes['cod_causa']) {
		$pdf->MultiCell(198,6,'(X) '.utf8_decode($reg_coded['desc_causa']),0,'J',0);
	        $regdes = pg_fetch_array($res_des);
 	 }
	 //else {
	 //	$pdf->MultiCell(198,6,$reg_coded['cod_causa'].') '.utf8_decode($reg_coded['desc_causa'].'( )'),0,'J',0); }

        $reg_coded = pg_fetch_array($res_coded);
     }
	 

    $res_otros=pg_exec("SELECT * FROM stzotrde WHERE nro_derecho = '$nderec' AND derecho = 'M' AND grupo = 'M'");
    $filas_otros= pg_numrows($res_otros);
if($filas_otros!=0){
   $regotr=pg_fetch_array($res_otros);
   $pdf->MultiCell(198,6,'(X) Otros: '.$regotr['otros'],0,'J',0);}

//Nota al pie
    $pdf->SetFont('Arial','',10);
    $pdf->ln(6);
 $pdf->ln(1);
    $pdf->MultiCell(198,4,'   Atentamente,                                                                    Fecha de Entrega:',0,'J',0);
    $pdf->ln(4);
    $pdf->MultiCell(198,4,utf8_decode('   El Registrador(a) de la Propiedad Industrial                    Retirado por: '),0,'J',0);
    
    $pdf->MultiCell(198,4,utf8_decode('                                                                                            C.I. No:                                                  Firma:'),0,'J',0);
    $pdf->ln(6);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(198,4,utf8_decode('NOTA: EL ESCRITO DE CONTESTACIÓN A LA PRESENTE DEVOLUCIÓN SOLO PRODRÁ PRESENTARSE ANTE ESTA INSTITUCIÓN UNA VEZ NOTIFICADA LA DEVOLUCIÓN, EN EL PRÓXIMO BOLETIN DE LA PROPIEDAD INDUSTRIAL, SEGÚN LO ESTABLECIDO EN EL ARTÍCULO 75 DE LA LEY DE PROPIEDAD INDUSTRIAL,  DE HACERLO DE FORMA ANTICIPADA, LA SOLICITUD SE TENDRÁ POR NO CONTESTADA Y SE LE DECLARARÁ LA PRIORIDAD EXTINGUIDA.'),0,'J',0);   
	
    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage();    //$reg = pg_fetch_array($resultado);
    }
  }     

//Desconexion a la base de datos
$sql->disconnect();

ob_end_clean(); 
$pdf->Output();

?>

