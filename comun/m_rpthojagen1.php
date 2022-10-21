<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');

ob_start();
include ("../z_includes.php");
include ("$include_lib/librepor.php");

//Table Base Classs
require ("$include_lib/PDF_acta.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "m_rptagente.php";

$desde=$_POST["fechfon1"];
$hasta=$_POST["fechfon2"];
$vagen1=$_POST["vagen1"];
$vagen2=$_POST["vagen2"];
$usuario=$_POST["usuario"];

//Query para buscar las opciones deseadas
$where='';
$titulo='';

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
  $smarty->assign('titulo',$substmar);
  $smarty->assign('subtitulo','Hoja de Actas de Agentes Cargados');
  $smarty->assign('login',$login);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
  $smarty->display('pie_pag.tpl'); exit(); }

if(!empty($desde) and !empty($hasta)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzagenr.fecha_ingre >= '$desde') and (stzagenr.fecha_ingre <='$hasta'))";
	   $titulo= $titulo." Fecha Carga:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stzagenr.fecha_ingre >= '$desde') and (stzagenr.fecha_ingre <='$hasta'))";
      $titulo= $titulo." Fecha Carga:"."$desde"." al: "."$hasta";
	}
}

$punt=0;
if ($vsol1 == '000000') { $punt=1; }
if ($vsol2 == '000000') { $punt=1; }

if (($punt!=1) and (!empty($vagen1) and !empty($vagen1))) { 

	if(!empty($where)) {
	   $where = $where." and"." ((stzagenr.agente >= '$vagen1') and (stzagenr.agente <='$vagen2'))";
	   $titulo= $titulo." Desde Solictud:"." $vagen1"." Hasta:"." $vagen2";
	}
	else { 
         $where = $where." ((stzagenr.agente >= '$vagen1') and (stzagenr.agente <='$vagen2'))";
         $titulo= $titulo." Desde Solicitud:"." $vagen1"." Hasta:"." $vagen2";
	}
}

if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzagenr.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stzagenr.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}

if (empty($where)) {
  $smarty->assign('titulo',$substmar);
  $smarty->assign('subtitulo','Hoja de Actas de Agentes Cargados');
  $smarty->assign('login',$login);
  $smarty->assign('fechahoy',$fecha);
  $smarty->display('encabezado1.tpl');
  Mensajenew("ERROR: No seleccion&oacute; ningun criterio para realizar la búsqueda de Informaci&oacute;n ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit();
}  

//Conexion
$sql = new mod_db();
$sql->connection();

$resultado=pg_exec("SELECT * FROM stzagenr WHERE $where ORDER BY agente");

//$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 

//verificando los resultados
if (!$resultado) { 
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: Procesando la B&uacute;squeda ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     
if ($filas_resultado==0) {
  $smarty->display('encabezado1.tpl');
  mensajenew('ERROR: No existe el Nro. de Registro o Solicitud ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

//PDF Encabezados
$encab_principal= "Sistema de Marcas y Patentes";
$encabezado= utf8_decode("Auditoria de Agentes Cargados");

//Inicio del Pdf
header('Content-type: application/pdf'); 
$pdf=new PDF_Table('L','mm','Letter');
$pdf->Open();
//$pdf->AddPage();
//$pdf->AliasNbPages();
//$pdf->Image('../imagenes/hojactagente.jpg',3,0,278,210,'JPEG');

for($cont=0;$cont<$filas_resultado;$cont++) { 
  $registro = pg_fetch_array($resultado);
  $pdf->AddPage();
  $pdf->AliasNbPages();
  $pdf->Image('../imagenes/hojactagente.jpg',3,0,278,210,'JPEG');
  $pdf->Setxy(232,58);
  $pdf->Cell(10,4,$registro['agente'],0,1); 
  $pdf->Setxy(57,72);
  $pdf->Cell(25,4,trim(utf8_decode($registro['nombre'])),0,0);
  $pdf->Setxy(230,72);
  $pdf->Cell(75,4,trim($registro['cedula']),0,0);
  
  $direccion1="";
  $domicilio2="";
  $dir = ""; $pos=0;
  $dir = trim($registro['domicilio']);
  $longitudir = strlen(trim($dir));
  if ($longitudir>75) {
    $domicilio1 = substr($dir,0,75);
    $pos = strripos($domicilio1,' ');
    if ($pos===false) { }
    else {
      $direccion1= substr($domicilio1,0,$pos);
    }
    $domicilio2 =  substr($dir,$pos,150);
  }
  else {
   $direccion1 = $dir;
   $domicilio2 = "";
  }
  $pdf->Setxy(35,84);
  $pdf->Cell(60,4,trim(utf8_decode($direccion1)),0,0);
  $pdf->Setxy(207,84);
  $pdf->Cell(40,4,$registro['nro_colegiado'],0,1);

  $pdf->Setxy(13,96);
  $pdf->Cell(60,4,trim(utf8_decode($domicilio2)),0,0);


  //$pdf->Setxy(35,84);
  //$pdf->Cell(60,4,trim(utf8_decode($registro['domicilio'])),0,0);
  //$pdf->Setxy(207,84);
  //$pdf->Cell(40,4,$registro['nro_colegiado'],0,1);
  
  $pdf->Setxy(196,96);
  $pdf->Cell(20,4,$registro['inpre'],0,1);
  $letraprof = trim($registro['profesion']);
  switch ($letraprof) {
    case "A":
      $vprofesion='Abogado';
      break;
    case "E":
      $vprofesion='Economista';
      break;
  }       
  $pdf->Setxy(38,109);
  $pdf->Cell(40,4,$vprofesion);
  $pdf->Setxy(54,121);  
  $pdf->Cell(30,4,trim(utf8_decode($registro['email'])));

  $telefonos = trim($registro['telefono1'])." - ".trim($registro['telefono2']);
  $pdf->Setxy(35,134);
  $pdf->Cell(50,4,$telefonos);

  //$registro = pg_fetch_array($resultado);
}

//Desconexion a la base de datos
$sql->disconnect();

header('Content-type: application/pdf');
ob_end_clean(); 
$pdf->Output();

?>
