<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_lib/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
//require ("$include_lib/PDF_table.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

//Pantalla Titulos
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Impresi&oacute;n de Certificados');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);

//Validacion de Entrada
$registrod1=$_POST["vreg1d"];
$registroh1=$_POST["vreg2d"];
$registrod2=$_POST["vreg1h"];
$registroh2=$_POST["vreg2h"];

$registrod= $registrod1.$registroh1;
$registroh= $registrod2.$registroh2;

if ($registrod=='' || $registroh=='') {
    $smarty->display('encabezado1.tpl');
    mensajenew('DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl');
	 $sql->disconnect(); exit(); 
}

//Query para buscar los certificados de marcas en el rango correspondiente
if(!empty($registrod) and !empty($registroh)) {  
   $resultado=pg_exec("SELECT clase,ind_claseni,modalidad,distingue,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_marca,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                       FROM stmmarce a, stzderec b 
                       WHERE a.nro_derecho=b.nro_derecho
		       AND tipo_mp='M' 
		       AND b.registro BETWEEN '$registrod' AND '$registroh'
   		       ORDER BY registro");
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


//Incio de la Clase de PDF para generar los reportes

//Inicio del Pdf
$pdf=new FPDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);

	
  for($cont=0;$cont<$filas_found;$cont++)   { 

	//tipo de marca
	$vtip=tipo_marca($reg['tipo_marca']);

	if ($reg['clase']=='46') {$vclas='NC';}
	if ($reg['clase']=='47') {$vclas='LC';}
	if (($reg['clase']!='46') and ($reg['clase']!='47')) {$vclas=$reg['clase'];}

    $varsol=$reg['solicitud'];
    $nderec=$reg['nro_derecho'];
    $pdf->Setxy(45,22);
    $pdf->Cell(20,4,$reg['registro'],0,1); 
    $pdf->Setxy(45,26);
    $pdf->Cell(20,4,$reg['fecha_regis'],0,1);
    $pdf->Setxy(45,30);
    $pdf->Cell(75,4,$reg['fecha_venc'],0,0);
    $pdf->Setxy(132,32);
    $pdf->Cell(60,4,$vtip,0,0);
    $pdf->Setxy(204,32);
    $pdf->Cell(40,4,$vclas,0,1);
    $pdf->Setxy(45,34);
    $pdf->Cell(20,4,$reg['solicitud'],0,1);

    // titular
    $titular='';
    $pais='';
    $domi='';

    $result_tit = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");

    $res_tit = pg_fetch_array($result_tit);
    $filas_tit=pg_numrows($result_tit);
    if ($filas_tit>1) { 
       $titular=$titular.'  '.trim($res_tit['nombre']).', cont ***';
       $pais_nombre=pais($res_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($res_tit['domicilio']);
    }
    else {
       $titular=$titular.trim($res_tit['nombre']); 
       $pais_nombre=pais($res_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($res_tit['domicilio']);
    } 
       
myTruncate($cadena, $long_min, $cadena_corte, $coletilla)
  $pdf->Setxy(45,48);
  $pdf->Cell(40,4,utf8_decode($titular));
  $pdf->Setxy(45,52);  
  $pdf->Cell(30,4,utf8_decode($pais));
  $pdf->Setxy(45,56);
  $pdf->Cell(50,4,utf8_decode($domi));

//Nombre de la Marca
    $pdf->Setxy(12,79);   
    $pdf->MultiCell(85,4,trim(utf8_decode($reg['nombre'])),0,'J');
   
    //descripcion de la etiqueta
    $resultado1=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$nderec'");
    $filas_found1=pg_numrows($resultado1);
    $reg_etiq = pg_fetch_array($resultado1);
    $pdf->Setxy(8,102); 
    $num_letras=strlen(trim($reg_etiq['descripcion']));

    if ($num_letras>680)
    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg_etiq['descripcion'],0,680));
       //$str = substr($str, 0, 680-strlen(strrchr($str, " ")));
       $str = $str.' *****';
       $pdf->MultiCell(98,4,utf8_decode($str),0,'J'); 
    }

    if ($num_letras<680) {$pdf->MultiCell(98,4, trim(utf8_decode($reg_etiq['descripcion'])),0,'J');}

    //imagen
		$varsol1=substr($varsol,-11,4);
		$varsol2=substr($varsol,-6,6);
	      //  $nameimage=ver_imagen($varsol1,$varsol2,'M');
	        $nameimage = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".jpg";
             $nameimagemay = "../graficos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".JPG";
		if ($reg['modalidad']!="D" { 
             if (file($nameimage)) { $pdf->Image("$nameimage",128,83,80,80,'JPG'); } else {
             if (file($nameimagemay)) { $pdf->Image("$nameimagemay",128,83,80,80,'JPG'); }   }
          }
    //descripcion del distingue
    $pdf->Setxy(8,180);  
    $num_letras=strlen(trim(utf8_decode($reg['distingue']))); 

    if ($num_letras>1470)    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg['distingue'],0,1470));
       //$str = substr($str, 0, 1480-strlen(strrchr($str, " ")));
       $str = $str.' *****';
      
       
       $pdf->MultiCell(188,4,utf8_decode($str),0,'J'); 
    }
    
    if ($num_letras<1470) { $pdf->MultiCell(188,4,trim(utf8_decode($reg['distingue'])),0,'J');}

    // Datos del recibo
    $resultado4=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento-1000 = '65' ");   
    $filas_found4=pg_numrows($resultado4);
    $reg4 = pg_fetch_array($resultado4);
    $resultado5=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$nderec' AND evento-1000 = '795' ");   
    $filas_found5=pg_numrows($resultado5);
    $reg5 = pg_fetch_array($resultado5);
    if ($filas_found4!= 0) 
       {$pdf->Setxy(175,251);   
        $pdf->Cell(20,4,trim($reg4['documento']),0,1);
        $pdf->Setxy(175,255);
        $pdf->Cell(20,4,$reg4['fecha_event'],0,1);
        $pdf->Setxy(175,259);
        //$pdf->Cell(20,4,number_format($reg5['documento']),0,1);
       }
    
    $reg = pg_fetch_array($resultado);
    if  ($cont+1!=$filas_found) {$pdf->AddPage();}

   }     
   
//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();
?>
