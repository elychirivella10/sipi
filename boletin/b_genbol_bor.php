<?php
// *************************************************************************************
// Programa: b_genbol.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("b_funcionm_bor.php");
include ("b_funcionp_bor.php");
include ("b_resolucm.php");
include ("$include_lib/jlpdf_bol_bor.php");
require ("$include_lib/PDF_tablebol.php");
require ("$include_lib/PDF_tablebol_bor.php");
require("$include_lib/MPDF45/mpdf.php");
require("$include_lib/rotation.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "b_genbol_bor.php";

// Definicion de Tablas 
$tbname_1 = "stzboletin";
$tbname_2 = "stzdetbol";

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];
//$conx   = $_GET['conx']; 
//$nconex = $_GET['nconex'];
//$salir  = $_GET['salir']; 
//$nbol   = $_POST['nbol'];
//$boletin=$nbol;
// ************************************************************************************
$smarty->assign('titulo',$substbol);
$smarty->assign('subtitulo','Generación de Borrador de Boletín ');

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
//if ($conx==0) { 
//  $smarty->assign('n_conex',$nconex);      }
//else {
//  if ($vopc == 3) { $opra='I'; }
//  if ($vopc == 5) { $opra='M'; }
//  $res_conex = insconex($usuario,$modulo,$opra);
//  $smarty->assign('n_conex',$res_conex);   }

//if (($salir==0) && ($nconex>0)) {
//  $logout = salirconx($nconex);
//}

// ************************************************************************************  
//Verificando conexion
 $sql->connection($usuario);

// ************************************************************************************
if ($vopc==4) {
  $smarty->assign('varfocus','forboletin1.nbol');
}

// ************************************************************************************
if ($vopc==4) {
  $accion = "I";
  $nbol   = $_POST['nbol'];
  $boletin=$nbol;
 

  $nconex = $_POST['nconex'];
  if (empty($nbol)) {
    mensajenew("AVISO: No introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 
  //busco el nro-boletin en la tabla
  $res_boletin = pg_exec("select * from $tbname_1 where nro_boletin='$nbol'");
  $nfil = pg_numrows($res_boletin);
  if ($nfil==0) {
      mensajenew("ERROR: Número de Boletín $nbol no existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); } 
  else {  $reg_bol = pg_fetch_array($res_boletin);
  //Obtencion de detalle del boletin
     $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_boletin='$nbol'");
     $filas_found=$sql->nums('',$obj_query);
     $reg = pg_fetch_array($obj_query); }
     
     if ($filas_found = 0) {
        mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla tbname_2 ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     else {
       //La Fecha de Hoy para la solicitud
      $fecha_gener = hoy();
// cargo variables de marcas
//*********************************   Marcas  *******************************************
if (!empty($reg['fec_soli'])) { $soli=$soli=1; $indr=1;}
if (!empty($reg['fec_conc'])) { $conc=$conc=1; $indr=1;}
if (!empty($reg['fec_orde'])) { $orde=$orde=1; $indr=1;}
if (!empty($reg['fec_devu'])) { $devu=$devu=1; $indr=1;}
if (!empty($reg['fec_obse'])) { $obse=$obse=1; $indr=1;}
if (!empty($reg['fec_obse_scon'])) { $obse_scon=$obse_scon=1; $indr=1; }
if (!empty($reg['fec_prio'])) { $prio=$prio=1; $indr=1;}
if (!empty($reg['fec_prio_exte'])) { $prio_exte=$prio_exte=1; $indr=1;}
if (!empty($reg['fec_prio_defe'])) { $prio_defe=$prio_defe=1; $indr=1;}
if (!empty($reg['fec_peri'])) { $peri=$peri=1; $indr=1;}
if (!empty($reg['fec_cadu'])) { $cadu=$cadu=1; $indr=1;}
if (!empty($reg['fec_desi'])) { $desi=$desi=1; $indr=1;}
if (!empty($reg['fec_desi_mejo'])) { $desi_mejo=$desi_mejo=1; $indr=1;}
if (!empty($reg['fec_desi_ley'])) { $desi_ley=$desi_ley=1; $indr=1;}
if (!empty($reg['fec_cadu_nren'])) { $cadu_nren=$cadu_nren=1; $indr=1;}
if (!empty($reg['fec_regi'])) { $regi=$regi=1; $indr=1;}
//if (!empty($reg['fec_devu_scon'])) { $devu_scon=$devu_scon=1; $indr=1;}
if (!empty($reg['fec_desi_anom'])) { $desi_anom=$desi_anom=1; $indr=1;}
if (!empty($reg['fec_devo_regi'])) { $devo_regi=$devo_regi=1; $indr=1;}
if (!empty($reg['fec_rein_devam'])) { $rein_devam=$rein_devam=1; $indr=1;}
if (!empty($reg['fec_nega'])) { $nega=$nega=1; $indr=1;}
if (!empty($reg['fec_cert'])) { $cert=$cert=1; $indr=1;}
if (!empty($reg['fec_anot'])) { $anot=$anot=1; $indr=1;}
if (!empty($reg['fec_desi_obse'])) { $desi_obse=$desi_obse=1; $indr=1;}
if (!empty($reg['fec_noti'])) { $noti=$noti=1; $indr=1;}

//pregunto si existe algo de publicacion de marcas para sacar en el boletin
if ($indr== 1) {
$marcas=marcas($nbol,$reg_bol['anoi'],$reg_bol['anof'],$reg_bol['resoluci'],$soli,$reg['fec_soli'],$conc,$reg['fec_conc'],$reg['tit_conc'],$orde,$reg['fec_orde'],$reg['tit_orde'],$devu,$reg['fec_devu'],$reg['tit_devu'],$obse,$reg['fec_obse'],$reg['tit_obse'],$obse_scon,$prio,$reg['fec_prio'],$reg['tit_prio'],$prio_exte,$reg['fec_prio_exte'],$reg['tit_prio_exte'], $prio_defe, $reg['fec_prio_defe'],$reg['tit_prio_exte'], $peri, $reg['fec_peri'],$reg['tit_peri'], $cadu, $reg['fec_cadu'],$reg['tit_cadu'],$desi,$reg['fec_desi'],$reg['tit_desi'],$desi_mejo,$reg['fec_desi_mejo'],$reg['tit_desi_mejo'], $desi_ley,$reg['fec_desi_ley'],$reg['tit_desi_ley'], $cadu_nren,$reg['fec_cadu_nren'],$reg['tit_cadu_nren'], $regi, $reg['fec_regi'], $reg['tit_regi'], $devu_scon,$desi_anom,$reg['fec_desi_anom'],$reg['tit_desi_anom'], $devo_regi,$reg['fec_devo_regi'],$reg['tit_devo_regi'], $rein_devam,$reg['fec_rein_devam'],$reg['tit_rein_devam'], $nega,$reg['fec_nega'],$reg['tit_nega'], $cert,$reg['fec_cert'],$reg['tit_cert'],$anot,$reg['fec_anot'], $reg['tit_anot'], $desi_obse,$reg['fec_desi_obse'], $reg['tit_desi_obse'], $noti,$reg['fec_noti'], $reg['tit_noti']); 
}

//pregunto para colocar el numero correcto de resolucion 
if ($indr== 1) { $nro_resolucm= $marcas;} 
else {
 $msj= $msj.'* No se genero Boletin de Marcas';
 $nro_resolucm = $reg_bol['resoluci'];  }

//***************************************************************************************
//**************************   Resoluciones de Marcas ***********************************
$resolucion=resolucion($nbol,$reg_bol['anoi'],$reg_bol['anof'],$nro_resolucm);
$nro_resoluc= $resolucion;


//***************************************************************************************
//*********************************   Patentes  *****************************************
if (!empty($reg['fecp_soli'])) { $solip=$solip=1; $indr=2; }
if (!empty($reg['fecp_conc'])) { $concp=$concp=1; $indr=2;}
if (!empty($reg['fecp_orde'])) { $ordep=$ordep=1; $indr=2;}
if (!empty($reg['fecp_devu'])) { $devup=$devup=1; $indr=2;}
if (!empty($reg['fecp_prio'])) { $priop=$priop=1; $indr=2;}
if (!empty($reg['fecp_prio_exte'])) { $prio_extep=$prio_extep=1; $indr=2;}
if (!empty($reg['fecp_prio_defe'])) { $prio_defep=$prio_defep=1; $indr=2;}
if (!empty($reg['fecp_peri'])) { $perip=$perip=1; $indr=2;}
if (!empty($reg['fecp_dene'])) { $denep=$denep=1; $indr=2;}
if (!empty($reg['fecp_desi'])) { $desip=$desip=1; $indr=2;}
if (!empty($reg['fecp_aban'])) { $aband=$aband=1; $indr=2;}
if (!empty($reg['fecp_nega'])) { $negad=$negad=1; $indr=2;}
if (!empty($reg['fecp_opos'])) { $oposi=$oposi=1; $indr=2;}
if (!empty($reg['fecp_reha'])) { $rehab=$rehab=1; $indr=2;}
if (!empty($reg['fecp_titu '])){ $titul=$titul=1; $indr=2;}

//pregunto si existe algo de publicacion de patentes para sacar en el boletin
if ($indr== 2) {
$patentes=patentes($nbol,$reg_bol['anoi'],$reg_bol['anof'],$nro_resoluc,$solip,$reg['fecp_soli'],$reg['titp_soli'],$concp,$reg['fecp_conc'],$reg['titp_conc'],$ordep,$reg['fecp_orde'],$reg['titp_orde'],$devup,$reg['fecp_devu'],$reg['titp_devu'],$priop,$reg['fecp_prio'],$reg['titp_prio'],$prio_extep,$reg['fecp_prio_exte'],$reg['titp_prio_exte'], $prio_defep, $reg['fecp_prio_defe'],$reg['titp_prio_exte'], $perip, $reg['fecp_peri'],$reg['titp_peri'], $denep, $reg['fecp_dene'],$reg['titp_dene'],$desip,$reg['fecp_desi'],$reg['titp_desi'], $aband,$reg['fecp_aban'],$reg['titp_aban'], $negad, $reg['fecp_nega'], $reg['titp_nega'], $oposi,$reg['fecp_opos'],$reg['titp_opos'], $rehab,$reg['fecp_reha'],$reg['titp_reha'], $titul,$reg['fecp_titu'],$reg['titp_titu']);
}
else  { $msj= $msj.'    * No se genero Boletin de Patentes';}

$nro_resoluc= $patentes;

//Guarda Informacion del Nro de Resolucion
    $resulr=pg_exec("select * from stzboletin where nro_boletin='$boletin'");
    $regr= pg_fetch_array($resulr);
    // Actualizacion de Tabla Maestra de Boletin 
    pg_exec("LOCK TABLE stzboletin IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "resolucf= '$nro_resoluc'";
    $act_boletin = $sql->update("stzboletin","$update_str","nro_boletin='$boletin'");
    $sql->disconnect();
  }
  
// Despligue de mensajes  
  echo "<H3><p> $msj </p></H3>"; 
  Mensajenew('BOLETIN GENERADO CORRECTAMENTE !!!','b_genbol_bor.php?vopc=5','S'); 
  $smarty->display('pie_pag1.tpl'); exit();
  
} // final de $vopc==4

// ************************************************************************************ 

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Boletin No.:');
$smarty->assign('vopc',$vopc);
//$smarty->assign('nbol',$nbol);
//$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
//$smarty->assign('accion',$accion);
$smarty->assign('varfocus','forboletin1.nbol'); 

$smarty->display('b_genbol_bor.tpl');
$smarty->display('pie_pag1.tpl');
//ob_end_clean(); 
?>
