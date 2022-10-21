<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");
$titulo="";

ob_start();

include ("../z_includes.php");

//Table Base Classs
require_once("$include_lib/class.fpdf_table.php");
	
//Class Extention for header and footer	
//require_once("$include_lib/header_footer.inc");

//Variables de sesion
$login = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$fecha = fechahoy();
$subtitulo = "Orden de Publicaci&oacute;n en Prensa.";

//Conexion
$sql = new mod_db();
$sql->connection();

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }
;

//PDF Encabezados
$encab_principal= "República Bolivariana de Venezuela";
$encabezado= "Ministerio del Poder Popular para el Comercio";
//$linea="_________________________________________________________________________________________________";
$titulo="Servicio Autónomo de la Propiedad Intelectual";
$parrafo = "De conformidad con el articulo 76 de la Ley de Propiedad Industrial, se ordena la publicación ";

//Pantalla Titulos
//$smarty->assign('titulo','Sistema de Marcas');
//$smarty->assign('subtitulo','Cronologia Administrativa');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado2.tpl');

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
echo " <td>";
echo "   <i><b><font>$subtitulo</font></b></i>";
echo " </td>";
echo "</table>"; 

//Validacion de Entrada
$vsol=$_GET["vsol"];
$varsol1=$_POST["vsol1"];
if (empty($varsol1)) {$varsol1=$_GET["vsol1"];}
$varsol2=$_POST["vsol2"];
if (empty($varsol2)) {$varsol2=$_GET["vsol2"];}
$varreg1=$_POST["vreg1"];
if (empty($varreg1)) {$varreg1=$_GET["vreg1"];}
$varreg2=$_POST["vreg2"];
if (empty($varreg2)) {$varreg2=$_GET["vreg2"];}

//Formateando los campos solicitud y registro
$varreg= $varreg1.$varreg2;
//$varsol=($varsol1.'-'.$varsol2);
if (empty($vsol)) {
$varsol=($varsol1.'-'.$varsol2);} else { $varsol=$vsol;}

//Query para buscar las opciones deseadas
if((!empty($varsol1)) and (!empty($varsol2)) or (!empty($varsol))) {
  $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stmmarce a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='M' 
		        AND b.solicitud= '$varsol' and b.solicitud!=''");
  //$titulo= $titulo." Solicitud:"." $varsol"; 	
}
else {
if(!empty($varreg)) { 
 $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stmmarce a, stzderec b
                        WHERE a.nro_derecho=b.nro_derecho 
		     	AND tipo_mp='M' 
			AND b.registro= '$varreg' 
			AND b.registro!=''");
 //$titulo= $titulo." Registro:"." $varreg";
}
}

//Verificando los resultados
if (!$resultado) 
   { 
     mensajenew('Error al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect1();
     exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) 
   {
     mensajenew('No existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect1();
     exit(); 
   } 

$reg = pg_fetch_array($resultado);
$varsol=$reg['solicitud'];
$nregis=$reg['registro'];
$nagen=$reg['agente'];
$nderec=$reg['nro_derecho'];
$modal = $reg['modalidad'];

$tipo_marca = $reg['tipo_marca'];
switch ($tipo_marca) {
  case "M":
    $parrafo = $parrafo."de la Marca Comercial siguiente: ";
    break;
  case "S":
    $parrafo = $parrafo."de la Marca de Servicio siguiente: ";
    break;
  case "N":
    $parrafo = $parrafo."de la Denominación Comercial siguiente: ";
    break;
  case "L":
    $parrafo = $parrafo."del Lema Comercial siguiente: ";
    break;
  case "D":
    $parrafo = $parrafo."de la Denominación Comercial siguiente: ";
    break;
  case "C":
    $parrafo = $parrafo."de la Marca Comercial siguiente: ";
    break;
}       

if (($modal="G") || ($modal="M")) {
  $varsolj = $varsol1.$varsol2;  
  //$cmd="scp -P  3535 www-data@172.16.0.30:/var/www/apl/sipi2011/graficos/marcas/ef".$varsol1."/".$varsolj.".jpg  /var/www/apl/certificatmp/";
  //exec($cmd,$salida);
  //foreach($salida as $line) { 
  //echo "Holaa<br>";	
  //echo "$line<br>"; }

  $nameimagen="../graficos/marcas/ef".$varsol1."/".$varsolj.".jpg"; 
}

$respub = pg_exec("SELECT fecha_event FROM stzevtrd WHERE nro_derecho='$nderec' AND evento=1201");
$regpub = pg_fetch_array($respub);
//$fpublica = fechasindia($regpub['fecha_event']);
$fpublica = Cambiar_fecha_mes($regpub['fecha_event']);
$publicacion = "CARACAS, ".$fpublica; 

//Busqueda de Tablas necesarias
//imagen
$varsol1=substr($varsol,-11,4);
$varsol2=substr($varsol,-6,6);
//$nameimage=ver_imagen($varsol1,$varsol2,'M');
//$nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";

$descripcion=estatus($reg['estatus']);

$pais_nombre=pais($reg['pais_resid']);

$vmod=modalida_marca($reg['modalidad']);

$vtip=tipo_marca($reg['tipo_marca']);

$vcla=ind_clase($reg['ind_claseni']);

//$vporc='83%';
//if ($reg['modalidad']!="D")
//   {$vporc='55%';} 

$rescln = pg_exec("SELECT clase_nac FROM stmclnac WHERE nro_derecho='$nderec'");
$regcln = pg_fetch_array($rescln);
$clanac = $regcln['clase_nac'];

//Incio de la Clase de PDF para generar los reportes
class pdf_usage extends fpdf_table
{
	public function Header()
	{
		global $encab_principal;
		global $encabezado;
		global $titulo;
		global $total;
		global $publicacion;
		global $parrafo; 
		
		//Title
		$this->SetFont('Arial','',14);
		$this->Cell(0,6,utf8_decode($encab_principal),0,1,'C');
		$this->Cell(0,6,utf8_decode($encabezado),0,1,'C');
   	$this->Cell(0,7,utf8_decode($titulo),0,1,'C');
		$this->SetFont('Arial','',9);
   	$this->Cell(0,7,$publicacion,0,1,'C');
   	$this->ln(2); 
   	//$this->Cell(0,7,utf8_decode($parrafo),0,1,'C');
   	$this->MultiCell(0,4,utf8_decode($parrafo),0,'J',0);
   	       
	  	$this->SetFont('Arial','',9);
   	$this->ln(3); 
	}	
	
	public function Footer()
	{
	    //Posición: a 2,0 cm del final
	    $this->SetY(-20);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);
	    //Número de página
	    ///$this->Cell(0,27,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	    //$this->Text(10,273,"Fecha:");
	    //$this->text(20,273,date('d/m/y'),0,1); 
	    //$this->Text(185,273,"Hora:");
	    //$this->text(192,273,date('h:i A'),0,1); 
	}
} 


//Inicio del Pdf
$pdf = new pdf_usage('P','mm','Letter');		
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetMargins(10, 10, 20);
$pdf->AddPage();
$pdf->AliasNbPages(); 

if ($reg['modalidad']!="D") {
 if (file($nameimagen)) {
   $pdf->SetFillColor(192);
   $pdf->RoundedRect(87, 46, 33, 30, 3.5, 'D');
   //$pdf->RoundedRect(175, 46, 33, 30, 3.5, 'D');
   //$pdf->Image("$nameimagen",176,48,30,25,'JPG');
   $pdf->Image("$nameimagen",88,48,30,25,'JPG');  }
} else {
    $pdf->ln(10);
    $pdf->SetFont('Arial','B',13);
    //$pdf->Cell(20,8,utf8_decode($reg['nombre']),0,1);
    $pdf->MultiCell(0,4,utf8_decode($reg['nombre']),0,'C',0);
    $pdf->SetFont('Arial','',9);

}

   //Muestra campos principales de la cronologia
   if ($reg['modalidad']!="D") {
    $pdf->ln(30); }
   else {
    $pdf->ln(15); }
    //$pdf->Cell(20,8,utf8_decode('Inscripción:'),0,0); 
    $pdf->Cell(15,8,utf8_decode('Inscripción: ').$varsol,0,1);
    //$pdf->Cell(40,8,utf8_decode('Fecha de Presentación:'),0,0);
    $pdf->Cell(15,8,utf8_decode('Fecha de Presentación: ').$reg['fecha_solic'],0,1);

   $solicitante = "";
   // Buscando los Titulares de la solicitud
   $result = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
                      FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			             AND stmmarce.nro_derecho=stzottid.nro_derecho
                      AND stzsolic.titular = stzottid.titular");

   $res = pg_fetch_array($result);
   $filas_found=pg_numrows($result);
	for ($j=0; $j<$filas_found; $j++)
	{
	   $pais_nombre=pais($res['nacionalidad']);
      $solicitante = $solicitante.trim(utf8_decode($res['nombre']))." Domicilio: ".utf8_decode(trim($res['domicilio']))." - ".utf8_decode($pais_nombre);
		$res = pg_fetch_array($result);
	}

   //$pdf->Cell(22,8,utf8_decode('Solicitada por: '),0,0); 
   //$pdf->Cell(16,8,$solicitante,0,1);
   $pdf->MultiCell(0,4,'Solicitada por: '.utf8_decode($solicitante),0,'J',0); 
	$pdf->Ln(3);

   //$pdf->Cell(35,8,'Clase Internacional:',0,0);
   $pdf->Cell(10,8,'Clase Internacional: '.$reg['clase'],0,1);    
   //$pdf->Cell(35,8,'Clase Nacional: ',0,0);
   $pdf->Cell(10,8,'Clase Nacional: '.$clanac,0,1);    

   //$pdf->Cell(22,8,utf8_decode('Para Distinguir: '),0,0); 
   //$pdf->MultiCell(16,8,utf8_decode($reg['distingue']),0,1);
   $pdf->MultiCell(0,4,utf8_decode('Para Distinguir: ').utf8_decode($reg['distingue']),0,'J',0);
	$pdf->Ln(6);
   
   $pdf->MultiCell(0,4,'Registradora de la Propiedad Industrial',0,'C',0); 

// Leyenda para taquilla integral
$pdf->Ln(6);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0,4,utf8_decode('NOTA: EL PRESENTE CLISEP SÓLO PODRÁ; PUBLICARSE EN LOS DIARIOS ``VEA´´ O ``CIUDAD CARACAS´´, UNA VEZ SE ORDENE LA PUBLICACIÓN EN EL PRÓXIMO BOLETÍN DE LA PROPIEDAD INDUSTRIAL, DE ACUERDO A LO ESTABLECIDO EN LOS ARTÍCULOS 76 DE LA LEY DE PROPIEDAD INDUSTRIAL Y 64 DE LA LEY ORGÁNICA DE PROCEDIMIENTOS ADMINISTRATIVOS, DE HACERL0 ANTICIPADAMENTE LA PUBLICACIÓN QUEDARÍA SIN EFECTO.'),0,'J',0);   


	//output the table data to the pdf
	//$pdf->tbOuputData();	
	//draw the Table Border
	//$pdf->tbDrawBorder();
	$pdf->Ln(6);

//Desconexion a la base de datos
$sql->disconnect1();

ob_end_clean(); 

$pdf->Output();

?>
