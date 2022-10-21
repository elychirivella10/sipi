<?php
// *************************************************************************************
// Programa: b_genbol.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año: 2013 II Semestre x Ing. Romulo Mendoza 
// Modificado Año: 2018 I Semestre x Ing. Romulo Mendoza / MPPCN 
// *************************************************************************************
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
require ("$include_path/fpdf.php");

//Comienzo del Programa por los encabezados del reporte
ob_start();
include ("../z_includes.php");

//Table Base Classs
include ("b_funcionm.php");
include ("b_funcionp.php");
include ("b_funcionrn.php");
include ("b_resolucm.php");
include ("$include_lib/jlpdf_bol.php");
require ("$include_lib/PDF_tablebol.php");
require("$include_lib/MPDF45/mpdf.php");
//require("$include_lib/rotation.php");
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "b_genbol.php";

// Definicion de Tablas 
$tbname_1 = "stzboletin";
$tbname_2 = "stzdetbol";
$tbname_3 = "stzbolgen";
$horactual= hora();
$fechahoy = hoy();

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];
//$nbol   = $_POST['nbol'];
//$boletin=$nbol;
// ************************************************************************************
$smarty->assign('titulo',$substbol);
$smarty->assign('subtitulo','Generación de Boletín de Nacionalidad VENEZOLANA');

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// AND ($usuario!='rtory')
//Autorizado por Romulo mendoza el 16/08/2019 para que todos tengan acceso al boletin
/*if (($usuario!='rmendoza') AND ($usuario!='ngonzalez') AND ($usuario!='rtory')) {
  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, Comuniquese con el Administrador del Sistema SIPI ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}*/

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
 

  if (empty($nbol)) {
    mensajenew("AVISO: No introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 
  //busco el nro-boletin en la tabla
  $res_boletin = pg_exec("select * from $tbname_1 where nro_boletin='$nbol'");
  $nfil = pg_numrows($res_boletin);
  if ($nfil==0) {
      mensajenew("ERROR: Número de Boletín $nbol no existe en la Base de Datos, Recuerde crearlo antes de Generar ...!!!","javascript:history.back();","N");
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
if (!empty($reg['fec_fondo'])) { $fondo=$fondo=1; $indr=1;}

//pregunto si existe algo de publicacion de marcas para sacar en el boletin
if ($indr== 1) {
$marcas=marcas($nbol,$reg_bol['anoi'],$reg_bol['anof'],$reg_bol['anor'],$reg_bol['resoluci'],$soli,$reg['fec_soli'],$conc,$reg['fec_conc'],$reg['tit_conc'],$orde,$reg['fec_orde'],$reg['tit_orde'],$devu,$reg['fec_devu'],$reg['tit_devu'],$obse,$reg['fec_obse'],$reg['tit_obse'],$obse_scon,$prio,$reg['fec_prio'],$reg['tit_prio'],$prio_exte,$reg['fec_prio_exte'],$reg['tit_prio_exte'], $prio_defe, $reg['fec_prio_defe'],$reg['tit_prio_exte'], $peri, $reg['fec_peri'],$reg['tit_peri'], $cadu, $reg['fec_cadu'],$reg['tit_cadu'],$desi,$reg['fec_desi'],$reg['tit_desi'],$desi_mejo,$reg['fec_desi_mejo'],$reg['tit_desi_mejo'], $desi_ley,$reg['fec_desi_ley'],$reg['tit_desi_ley'], $cadu_nren,$reg['fec_cadu_nren'],$reg['tit_cadu_nren'], $regi, $reg['fec_regi'], $reg['tit_regi'], $devu_scon,$desi_anom,$reg['fec_desi_anom'],$reg['tit_desi_anom'], $devo_regi,$reg['fec_devo_regi'],$reg['tit_devo_regi'], $rein_devam,$reg['fec_rein_devam'],$reg['tit_rein_devam'], $nega,$reg['fec_nega'],$reg['tit_nega'], $cert,$reg['fec_cert'],$reg['tit_cert'],$anot,$reg['fec_anot'], $reg['tit_anot'], $desi_obse,$reg['fec_desi_obse'], $reg['tit_desi_obse'], $noti,$reg['fec_noti'], $reg['tit_noti'], $fondo,$reg['fec_fondo'], $reg['tit_fondo']); 
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
if (!empty($reg['fecp_titu'])){ $titul=$titul=1; $indr=2;}
if (!empty($reg['fecp_sefp'])){ $psefp=$psefp=1; $indr=2;}
if (!empty($reg['fecp_sevt'])){ $psevt=$psevt=1; $indr=2;}
//Modificado por Ing. Romulo Mendoza 23/04/2018
if (!empty($reg['fecp_derp'])){ $pseder=$pseder=1; $indr=2;}

//pregunto si existe algo de publicacion de patentes para sacar en el boletin
if ($indr== 2) {
//$patentes=patentes($nbol,$reg_bol['anoi'],$reg_bol['anof'],$reg_bol['anor'],$nro_resoluc,$solip,$reg['fecp_soli'],$reg['titp_soli'],$concp,$reg['fecp_conc'],$reg['titp_conc'],$ordep,$reg['fecp_orde'],$reg['titp_orde'],$devup,$reg['fecp_devu'],$reg['titp_devu'],$priop,$reg['fecp_prio'],$reg['titp_prio'],$prio_extep,$reg['fecp_prio_exte'],$reg['titp_prio_exte'], $prio_defep, $reg['fecp_prio_defe'],$reg['titp_prio_exte'], $perip, $reg['fecp_peri'],$reg['titp_peri'], $denep, $reg['fecp_dene'],$reg['titp_dene'],$desip,$reg['fecp_desi'],$reg['titp_desi'], $aband,$reg['fecp_aban'],$reg['titp_aban'], $negad, $reg['fecp_nega'], $reg['titp_nega'], $oposi,$reg['fecp_opos'],$reg['titp_opos'], $rehab,$reg['fecp_reha'],$reg['titp_reha'], $titul,$reg['fecp_titu'],$reg['titp_titu'], $psefp,$reg['fecp_sefp'],$reg['titp_sefp'], $psevt,$reg['fecp_sevt'],$reg['titp_sevt']);
$patentes=patentes($nbol,$reg_bol['anoi'],$reg_bol['anof'],$reg_bol['anor'],$nro_resoluc,$solip,$reg['fecp_soli'],$reg['titp_soli'],$concp,$reg['fecp_conc'],$reg['titp_conc'],$ordep,$reg['fecp_orde'],$reg['titp_orde'],$devup,$reg['fecp_devu'],$reg['titp_devu'],$priop,$reg['fecp_prio'],$reg['titp_prio'],$prio_extep,$reg['fecp_prio_exte'],$reg['titp_prio_exte'], $prio_defep, $reg['fecp_prio_defe'],$reg['titp_prio_exte'], $perip, $reg['fecp_peri'],$reg['titp_peri'], $denep, $reg['fecp_dene'],$reg['titp_dene'],$desip,$reg['fecp_desi'],$reg['titp_desi'], $aband,$reg['fecp_aban'],$reg['titp_aban'], $negad, $reg['fecp_nega'], $reg['titp_nega'], $oposi,$reg['fecp_opos'],$reg['titp_opos'], $rehab,$reg['fecp_reha'],$reg['titp_reha'], $titul,$reg['fecp_titu'],$reg['titp_titu'], $psefp,$reg['fecp_sefp'],$reg['titp_sefp'], $psevt,$reg['fecp_sevt'],$reg['titp_sevt'], $pseder,$reg['fecp_derp'],$reg['titp_derp']);
}
else  { $msj= $msj.'    * No se genero Boletin de Patentes';}

$nro_resoluc= $patentes;

//*********************************  Asesoria Juridica Recursos Marcas y Patentes  *****************************************
//Colocado por Ing. Romulo Mendoza 25/09/2018 Asesoria Juridica
//Estatus de Marcas
if (!empty($reg['fec_800'])) { $a800=$a800=1; $indr=3;}
if (!empty($reg['fec_801'])) { $a801=$a801=1; $indr=3;}
if (!empty($reg['fec_802'])) { $a802=$a802=1; $indr=3;}
if (!empty($reg['fec_803'])) { $a803=$a803=1; $indr=3;}
if (!empty($reg['fec_804'])) { $a804=$a804=1; $indr=3;}
if (!empty($reg['fec_805'])) { $a805=$a805=1; $indr=3;}
if (!empty($reg['fec_806'])) { $a806=$a806=1; $indr=3;}
if (!empty($reg['fec_807'])) { $a807=$a807=1; $indr=3;}
if (!empty($reg['fec_808'])) { $a808=$a808=1; $indr=3;}
if (!empty($reg['fec_809'])) { $a809=$a809=1; $indr=3;}
if (!empty($reg['fec_821'])) { $a821=$a821=1; $indr=3;}
if (!empty($reg['fec_822'])) { $a822=$a822=1; $indr=3;}
if (!empty($reg['fec_823'])) { $a823=$a823=1; $indr=3;}
if (!empty($reg['fec_824'])) { $a824=$a824=1; $indr=3;}
if (!empty($reg['fec_825'])) { $a825=$a825=1; $indr=3;}
if (!empty($reg['fec_830'])) { $a830=$a830=1; $indr=3;}
if (!empty($reg['fec_831'])) { $a831=$a831=1; $indr=3;}
if (!empty($reg['fec_833'])) { $a833=$a833=1; $indr=3;}
if (!empty($reg['fec_835'])) { $a835=$a835=1; $indr=3;}
if (!empty($reg['fec_836'])) { $a836=$a836=1; $indr=3;}
if (!empty($reg['fec_837'])) { $a837=$a837=1; $indr=3;}
if (!empty($reg['fec_838'])) { $a838=$a838=1; $indr=3;}

//Estatus de Patentes
if (!empty($reg['pfec_800'])) { $p800=$p800=1; $indr=3;}
if (!empty($reg['pfec_801'])) { $p801=$p801=1; $indr=3;}
if (!empty($reg['pfec_802'])) { $p802=$p802=1; $indr=3;}
if (!empty($reg['pfec_804'])) { $p804=$p804=1; $indr=3;}
if (!empty($reg['pfec_805'])) { $p805=$p805=1; $indr=3;}
if (!empty($reg['pfec_806'])) { $p806=$p806=1; $indr=3;}
if (!empty($reg['pfec_809'])) { $p809=$p809=1; $indr=3;}
if (!empty($reg['pfec_821'])) { $p821=$p821=1; $indr=3;}
if (!empty($reg['pfec_833'])) { $p833=$p833=1; $indr=3;}
if (!empty($reg['pfec_835'])) { $p835=$p835=1; $indr=3;}
if (!empty($reg['pfec_836'])) { $p836=$p836=1; $indr=3;}
if (!empty($reg['pfec_837'])) { $p837=$p837=1; $indr=3;}
if (!empty($reg['pfec_838'])) { $p838=$p838=1; $indr=3;}
if (!empty($reg['pfec_840'])) { $p840=$p840=1; $indr=3;}
if (!empty($reg['pfec_921'])) { $p921=$p921=1; $indr=3;}
if (!empty($reg['pfec_922'])) { $p922=$p922=1; $indr=3;}

//Pregunto si existe algo de publicacion de Recursos sacar en el boletin
if ($indr== 3) {
$asesoria=asesoria($nbol,$reg_bol['anoi'],$reg_bol['anof'],$reg_bol['anor'],$reg_bol['resoluci'],$a800,$reg['fec_800'], $reg['tit_800'], $a801,$reg['fec_801'], $reg['tit_801'], $a802,$reg['fec_802'], $reg['tit_802'], $a803,$reg['fec_803'], $reg['tit_803'], $a804,$reg['fec_804'], $reg['tit_804'], $a805,$reg['fec_805'], $reg['tit_805'], $a806,$reg['fec_806'], $reg['tit_806'], $a807,$reg['fec_807'], $reg['tit_807'], $a808,$reg['fec_808'], $reg['tit_808'], $a809,$reg['fec_809'], $reg['tit_809'], $a821,$reg['fec_821'], $reg['tit_821'], $a822,$reg['fec_822'], $reg['tit_822'], $a823,$reg['fec_823'], $reg['tit_823'], $a824,$reg['fec_824'], $reg['tit_824'], $a825,$reg['fec_825'], $reg['tit_825'], $a830,$reg['fec_830'], $reg['tit_830'], $a831,$reg['fec_831'], $reg['tit_831'], $a833,$reg['fec_833'], $reg['tit_833'], $a835,$reg['fec_835'], $reg['tit_835'], $a836,$reg['fec_836'], $reg['tit_836'], $a837,$reg['fec_837'], $reg['tit_837'], $a838,$reg['fec_838'], $reg['tit_838'],$p800,$reg['pfec_800'], $reg['ptit_800'], $p801,$reg['pfec_801'], $reg['ptit_801'], $p802,$reg['pfec_802'], $reg['ptit_802'], $p804,$reg['pfec_804'], $reg['ptit_804'], $p805,$reg['pfec_805'], $reg['ptit_805'], $p806,$reg['pfec_806'], $reg['ptit_806'], $p809,$reg['pfec_809'], $reg['ptit_809'], $p821,$reg['pfec_821'], $reg['ptit_821'], $p833,$reg['pfec_833'], $reg['ptit_833'], $p835,$reg['pfec_835'], $reg['ptit_835'], $p836,$reg['pfec_836'], $reg['ptit_836'], $p837,$reg['pfec_837'], $reg['ptit_837'], $p838,$reg['pfec_838'], $reg['ptit_838'], $p840,$reg['pfec_840'], $reg['ptit_840'], $p921,$reg['pfec_921'], $reg['ptit_921'], $p922,$reg['pfec_922'], $reg['ptit_922']); 
}
else  { $msj= $msj.'    * No se genero Boletin de Recursos';}

$nro_resoluc= $asesoria;

//Guarda Informacion del Nro de Resolucion
    $resulr=pg_exec("select * from stzboletin where nro_boletin='$boletin'");
    $regr= pg_fetch_array($resulr);
    // Actualizacion de Tabla Maestra de Boletin 
    //pg_exec("LOCK TABLE stzboletin IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "resolucf= '$nro_resoluc'";
    $act_boletin = $sql->update("stzboletin","$update_str","nro_boletin='$boletin'");
    
    //$col_campos = "ctrlbolgen,nro_boletin,fecha_gen,hora_gen,usuario";
    $insert_str = "nextval('stzbolgen_ctrlbolgen_seq'),'$nbol','$fechahoy','$horactual','$usuario'";
    $ins_bolgen = $sql->insert("$tbname_3","","$insert_str","");
    $sql->disconnect();
  }
  
// Despligue de mensajes  
  echo "<H3><p> $msj </p></H3>"; 
  Mensajenew('BOLETIN DE NACIONALIDAD VENEZOLANA GENERADO CORRECTAMENTE !!!','b_genbol.php?vopc=5','S'); 
  $smarty->display('pie_pag.tpl'); exit();
  
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

$smarty->display('b_genbol.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>
