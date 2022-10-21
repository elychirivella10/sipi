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

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();

//Conexion
$sql = new mod_db();
$sql->connection($login);

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

$smarty->assign('titulo',$substmar);
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
    mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');    
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
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');   
     $smarty->display('pie_pag.tpl');
     $sql->disconnect(); exit(); } 
$reg = pg_fetch_array($resultado);

//tipo de marca
$vtip=tipo_marca($reg['tipo_marca']);



//Inicio del Pdf
$pdf=new FPDF('P','mm','A4');
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);

//Datos del certificado
	
  for($cont=0;$cont<$filas_found;$cont++)   { 
    $varsol=$reg['solicitud'];
    $nderec=$reg['nro_derecho'];
// Continuacion de los titulares

    $resultado3 = pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio
       FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$nderec'
			                AND stmmarce.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
    $filas_found3=pg_numrows($resultado3);
    $reg_tit = pg_fetch_array($resultado3);
    $fil=14; $inc=4; 
    if ($filas_found3>1) {$pdf->Multicell(120,4,utf8_decode('Continuación de Titulares '));}

    for($cont_tit=1;$cont_tit<$filas_found3;$cont_tit++)   { 
       $reg_tit = pg_fetch_array($resultado3);
       $titular=$titular.trim($reg_tit['nombre']); 
       $pais_nombre=pais($reg_tit['nacionalidad']);
       $pais=$pais.trim($pais_nombre);
       $domi=$domi.trim($reg_tit['domicilio']);

       $pdf->SetXY(14,$fil+($inc*1));$pdf->Cell(0,0,'TITULAR:  '.utf8_decode($titular));
       $pdf->SetXY(14,$fil+($inc*2));$pdf->Cell(0,0,'NACIONALIDAD:  '.utf8_decode($pais));
       $pdf->SetXY(14,$fil+($inc*3));$pdf->Cell(0,0,'DOMICILIO:  '.utf8_decode($domi));
       $fil=$fil+($inc*4);

   }

//Continuacion del distingue o etiqueta

    //descripcion de la etiqueta
    $resultado1=pg_exec("SELECT * FROM stmlogos WHERE nro_derecho='$nderec'");
    $filas_found1=pg_numrows($resultado1);
    $reg_etiq = pg_fetch_array($resultado1);
    $num_letras=strlen(trim($reg_etiq['descripcion']));
    $pdf->SetX(14);
    $pdf->Ln(4);
    if ($num_letras>710)
    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg_etiq['descripcion'],710,5000));
       //$str = substr($str, 0, 1480-strlen(strrchr($str, " ")));
       $str = ' Cont. Etiqueta *****    '.strtoupper($str);
       $pdf->MultiCell(180,4,utf8_decode($str),0,'J'); 
       $pdf->Ln(3);
    }
     
    //descripcion del distingue
    $pdf->SetX(14);
    $pdf->Ln(4);
    $num_letras=strlen(trim($reg['distingue'])); 

    //if ($num_letras>1470)
    if ($num_letras>1320)
    {
       //no corta la palabra lo deja en el espacio anterior del limite
       $str = trim(substr($reg['distingue'],1320,3000));
       //$str = substr($str, 0, 1480-strlen(strrchr($str, " ")));
       $str = 'Cont. Distingue *****     '.strtoupper($str);
       $pdf->MultiCell(180,4,utf8_decode($str),0,'J'); 
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
