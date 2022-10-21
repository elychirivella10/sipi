<script language="JavaScript">
function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion para el Nuevo Boletin ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: b_newbol.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Desarrollado Año: 2010
// Modificado Año 2018 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$sql      = new mod_db();
$fecha    = fechahoy();
$modulo   = "b_ingreso.php";

// Definicion de Tablas 
$tbname_1 = "stzboletin";
$tbname_2 = "stzdetbol";

// Obtencion de variables de los campos del tpl 
$vopc           = $_GET['vopc'];
$conx           = $_GET['conx']; 
$nconex         = $_GET['nconex'];
$salir          = $_GET['salir']; 

$nbol           =$_POST['nbol'];
//$vder         =$_POST['vder'];
$accion         =$_POST['accion'];

$fecha_pub      =$_POST['fecha_pub'];
//$fecha_ven    =$_POST['fecha_ven'];
$anoi	          =$_POST['anoi'];
$anof           =$_POST['anof'];
$anor           =$_POST['anor'];
$tipobol        =$_POST['aplica'];

//marcas
$tit_soli       =$_POST['tit_soli'];
$fec_soli       =$_POST['fec_soli'];
$tit_orden      =$_POST['tit_orden'];
$fec_orde       =$_POST['fec_orde'];
$tit_conc       =$_POST['tit_conc'];
$fec_conc       =$_POST['fec_conc'];
$tit_devu       =$_POST['tit_devu'];  
$fec_devu       =$_POST['fec_devu'];
$tit_obse       =$_POST['tit_obse'];
$fec_obse       =$_POST['fec_obse'];
$tit_obse_scon  =$_POST['tit_obse_scon'];
$fec_obse_scon  =$_POST['fec_obse_scon'];
$tit_prio       =$_POST['tit_prio'];
$fec_prio       =$_POST['fec_prio'];
$tit_prio_exte  =$_POST['tit_prio_exte'];
$fec_prio_exte  =$_POST['fec_prio_exte'];
$tit_prio_defe  =$_POST['tit_prio_defe'];
$fec_prio_defe  =$_POST['fec_prio_defe'];
$tit_peri       =$_POST['tit_peri'];
$fec_peri       =$_POST['fec_peri'];
$tit_cadu       =$_POST['tit_cadu'];
$fec_cadu       =$_POST['fec_cadu']; 
$tit_desi       =$_POST['tit_desi'];
$fec_desi       =$_POST['fec_desi'];
$tit_desi_mejo  =$_POST['tit_desi_mejo'];  
$fec_desi_mejo  =$_POST['fec_desi_mejo'];
$tit_desi_ley   =$_POST['tit_desi_ley'];
$fec_desi_ley   =$_POST['fec_desi_ley'];
$tit_cadu_nren  =$_POST['tit_cadu_nren'];
$fec_cadu_nren  =$_POST['fec_cadu_nren'];
$tit_regi       =$_POST['tit_regi'];
$fec_regi       =$_POST['fec_regi'];
$tit_devu_scon  =$_POST['tit_devu_scon'];
$fec_devu_scon  =$_POST['fec_devu_scon'];
$tit_desi_anom  =$_POST['tit_desi_anom'];
$fec_desi_anom  =$_POST['fec_desi_anom'];
$tit_devo_regi  =$_POST['tit_devo_regi'];
$fec_devo_regi  =$_POST['fec_devo_regi'];
$tit_rein_devam =$_POST['tit_rein_devam'];
$fec_rein_devam =$_POST['fec_rein_devam']; 
$tit_nega       =$_POST['tit_nega'];
$fec_nega       =$_POST['fec_nega'];
$tit_cert       =$_POST['tit_cert'];
$fec_cert       =$_POST['fec_cert'];
$tit_anot       =$_POST['tit_anot'];
$fec_anot       =$_POST['fec_anot'];
$tit_noti       =$_POST['tit_noti'];
$fec_noti       =$_POST['fec_noti'];
$tit_desi_obse  =$_POST['tit_desi_obse'];
$fec_desi_obse  =$_POST['fec_desi_obse'];
//Colocado por Romulo Mendoza 07/03/2012 Devueltas por fondo
$tit_fondo      =$_POST['tit_fondo'];  
$fec_fondo      =$_POST['fec_fondo']; 

//patentes
$titp_soli      =$_POST['titp_soli'];
$fecp_soli      =$_POST['fecp_soli'];
$titp_orden     =$_POST['titp_orden'];
$fecp_orde      =$_POST['fecp_orde'];
$titp_conc      =$_POST['titp_conc'];
$fecp_conc      =$_POST['fecp_conc'];
$titp_devu      =$_POST['titp_devu'];  
$fecp_devu      =$_POST['fecp_devu'];
$titp_prio      =$_POST['titp_prio'];
$fecp_prio      =$_POST['fecp_prio'];
$titp_prio_exte =$_POST['titp_prio_exte'];
$fecp_prio_exte =$_POST['fecp_prio_exte'];
$titp_prio_defe =$_POST['titp_prio_defe'];
$fecp_prio_defe =$_POST['fecp_prio_defe'];
$titp_peri      =$_POST['titp_peri'];
$fecp_peri      =$_POST['fecp_peri'];
$titp_dene      =$_POST['titp_dene'];
$fecp_dene      =$_POST['fecp_dene'];
$titp_desi      =$_POST['titp_desi'];
$fecp_desi      =$_POST['fecp_desi'];
$titp_aban      =$_POST['titp_aban'];
$fecp_aban      =$_POST['fecp_aban']; 
$titp_nega      =$_POST['titp_nega'];
$fecp_nega      =$_POST['fecp_nega'];
$titp_opos      =$_POST['titp_opos'];  
$fecp_opos      =$_POST['fecp_opos'];
$titp_reha      =$_POST['titp_reha'];
$fecp_reha      =$_POST['fecp_reha'];
$titp_titu      =$_POST['titp_titu'];
$fecp_titu      =$_POST['fecp_titu'];
//Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto   
$titp_sefp      =$_POST['titp_sefp'];
$fecp_sefp      =$_POST['fecp_sefp'];
$titp_sevt      =$_POST['titp_sevt'];
$fecp_sevt      =$_POST['fecp_sevt'];

//Colocado por Romulo Mendoza 16/04/2018 Patentes sin efecto x NO Pago de Derechos de Concesion
$titp_derp      =$_POST['titp_derp'];
$fecp_derp      =$_POST['fecp_derp'];

//Recursos Marcas - Asesoria Juridica Colocado por PIII - Ing. Romulo Mendoza 24/09/2018 
$tit_800        =$_POST['tit_800'];
$fec_800        =$_POST['fec_800'];
$tit_801        =$_POST['tit_801'];
$fec_801        =$_POST['fec_801'];
$tit_802        =$_POST['tit_802'];
$fec_802        =$_POST['fec_802'];
$tit_803        =$_POST['tit_803'];
$fec_803        =$_POST['fec_803'];
$tit_804        =$_POST['tit_804'];
$fec_804        =$_POST['fec_804'];
$tit_805        =$_POST['tit_805'];
$fec_805        =$_POST['fec_805'];
$tit_806        =$_POST['tit_806'];
$fec_806        =$_POST['fec_806'];
$tit_807        =$_POST['tit_807'];
$fec_807        =$_POST['fec_807'];
$tit_808        =$_POST['tit_808'];
$fec_808        =$_POST['fec_808'];
$tit_809        =$_POST['tit_809'];
$fec_809        =$_POST['fec_809'];
$tit_821        =$_POST['tit_821'];
$fec_821        =$_POST['fec_821'];
$tit_822        =$_POST['tit_822'];
$fec_822        =$_POST['fec_822'];
$tit_823        =$_POST['tit_823'];
$fec_823        =$_POST['fec_823'];
$tit_824        =$_POST['tit_824'];
$fec_824        =$_POST['fec_824'];
$tit_825        =$_POST['tit_825'];
$fec_825        =$_POST['fec_825'];
$tit_830        =$_POST['tit_830'];
$fec_830        =$_POST['fec_830'];
$tit_831        =$_POST['tit_831'];
$fec_831        =$_POST['fec_831'];
$tit_833        =$_POST['tit_833'];
$fec_833        =$_POST['fec_833'];
$tit_835        =$_POST['tit_835'];
$fec_835        =$_POST['fec_835'];
$tit_836        =$_POST['tit_836'];
$fec_836        =$_POST['fec_836'];
$tit_837        =$_POST['tit_837'];
$fec_837        =$_POST['fec_837'];
$tit_838        =$_POST['tit_838'];
$fec_838        =$_POST['fec_838'];

//Recursos Patentes - Asesoria Juridica Colocado por PIII - Ing. Romulo Mendoza 23/10/2018
$ptit_800       =$_POST['ptit_800'];
$pfec_800       =$_POST['pfec_800'];
$ptit_801       =$_POST['ptit_801'];
$pfec_801       =$_POST['pfec_801'];
$ptit_802       =$_POST['ptit_802'];
$pfec_802       =$_POST['pfec_802'];
$ptit_804       =$_POST['ptit_804'];
$pfec_804       =$_POST['pfec_804'];
$ptit_805       =$_POST['ptit_805'];
$pfec_805       =$_POST['pfec_805'];
$ptit_806       =$_POST['ptit_806'];
$pfec_806       =$_POST['pfec_806'];
$ptit_809       =$_POST['ptit_809'];
$pfec_809       =$_POST['pfec_809'];
$ptit_821       =$_POST['ptit_821'];
$pfec_821       =$_POST['pfec_821'];
$ptit_833       =$_POST['ptit_833'];
$pfec_833       =$_POST['pfec_833'];
$ptit_835       =$_POST['ptit_835'];
$pfec_835       =$_POST['pfec_835'];
$ptit_836       =$_POST['ptit_836'];
$pfec_836       =$_POST['pfec_836'];
$ptit_837       =$_POST['ptit_837'];
$pfec_837       =$_POST['pfec_837'];
$ptit_838       =$_POST['ptit_838'];
$pfec_838       =$_POST['pfec_838'];
$ptit_840       =$_POST['ptit_840'];
$pfec_840       =$_POST['pfec_840'];
$ptit_921       =$_POST['ptit_921'];
$pfec_921       =$_POST['pfec_921'];
$ptit_922       =$_POST['ptit_922'];
$pfec_922       =$_POST['pfec_922'];

//Avisos Oficiales
$ubicacion      =$_POST['ubicacion'];

//**************************************************************************************
//Verificacion de campos fechas llenos
$texto='nro_boletin,  tit_soli,';
$texto1="'$nbol', '$tit_soli',";
if (!empty($fec_soli)) {$texto = $texto.'fec_soli,'; $texto1 = $texto1."'$fec_soli',"; }
$texto=$texto.' tit_orden,';
$texto1=$texto1."'$tit_orden',";
if (!empty($fec_orde)) { $texto = $texto.'fec_orde,'; $texto1 = $texto1."'$fec_orde',"; }
$texto=$texto.' tit_conc,';
$texto1=$texto1."'$tit_conc',";
if (!empty($fec_conc)) {$texto = $texto.'fec_conc,'; $texto1 = $texto1."'$fec_conc',"; }
$texto=$texto.' tit_devu,';
$texto1=$texto1."'$tit_devu',";
if (!empty($fec_devu)) {$texto = $texto.'fec_devu,'; $texto1 = $texto1."'$fec_devu',"; }
$texto=$texto.'tit_obse,';
$texto1=$texto1."'$tit_obse',";
if (!empty($fec_obse)) {$texto = $texto.'fec_obse,'; $texto1 = $texto1."'$fec_obse',"; }
$texto=$texto.'tit_obse_scon,';
$texto1=$texto1."'$tit_obse_scon',";
if (!empty($fec_obse_scon)) {$texto = $texto.'fec_obse_scon,'; $texto1 = $texto1."'$fec_obse_scon',";  }
$texto=$texto.'tit_prio,';
$texto1=$texto1."'$tit_prio',";
if (!empty($fec_prio)) {$texto = $texto.'fec_prio,'; $texto1 = $texto1."'$fec_prio',";}
$texto=$texto.'tit_prio_exte,';
$texto1=$texto1." '$tit_prio_exte',";
if (!empty($fec_prio_exte)) {$texto = $texto.'fec_prio_exte,'; $texto1 = $texto1."'$fec_prio_exte',"; }
$texto=$texto.'tit_prio_defe,';
$texto1=$texto1." '$tit_prio_defe',";
if (!empty($fec_prio_defe)) {$texto = $texto.'fec_prio_defe,'; $texto1 = $texto1."'$fec_prio_defe',";}
$texto=$texto.'tit_peri,';
$texto1=$texto1." '$tit_peri', ";
if (!empty($fec_peri)) {$texto = $texto.'fec_peri,'; $texto1 = $texto1."'$fec_peri',";}
$texto=$texto.' tit_cadu,';
$texto1=$texto1."'$tit_cadu',";
if (!empty($fec_cadu)) {$texto = $texto.'fec_cadu,'; $texto1 = $texto1."'$fec_cadu',";}
$texto=$texto.' tit_desi,';
$texto1=$texto1."'$tit_desi', ";
if (!empty($fec_desi)) {$texto = $texto.'fec_desi,'; $texto1 = $texto1."'$fec_desi',";}
$texto=$texto.'tit_desi_mejo,';
$texto1=$texto1."'$tit_desi_mejo',";
if (!empty($fec_desi_mejo)) {$texto = $texto.'fec_desi_mejo,'; $texto1 = $texto1."'$fec_desi_mejo',";}
$texto=$texto.' tit_desi_ley,';
$texto1=$texto1."'$tit_desi_ley',";
if (!empty($fec_desi_ley)) {$texto = $texto.'fec_desi_ley,'; $texto1 = $texto1."'$fec_desi_ley',"; }
$texto=$texto.'tit_cadu_nren,';
$texto1=$texto1." '$tit_cadu_nren',";
if (!empty($fec_cadu_nren)) {$texto = $texto.'fec_cadu_nren,'; $texto1 =  $texto1."'$fec_cadu_nren',";}
$texto=$texto.'  tit_regi,';
$texto1=$texto1."'$tit_regi',";
if (!empty($fec_regi)) {$texto = $texto.'fec_regi,';  $texto1 = $texto1."'$fec_regi',";}
$texto=$texto.'tit_devu_scon,';
$texto1=$texto1."'$tit_devu_scon',";
if (!empty($fec_devu_scon)) {$texto = $texto.'fec_devu_scon,'; $texto1 = $texto1."'$fec_devu_scon',"; }
$texto=$texto.' tit_desi_anom,';
$texto1=$texto1."'$tit_desi_anom',";
if (!empty($fec_desi_anom)) {$texto = $texto.'fec_desi_anom,'; $texto1 = $texto1."'$fec_desi_anom',";}
$texto=$texto.' tit_devo_regi,';
$texto1=$texto1." '$tit_devo_regi',";
if (!empty($fec_devo_regi)) {$texto = $texto.'fec_devo_regi,'; $texto1 = $texto1."'$fec_devo_regi',";}
$texto=$texto.'tit_rein_devam,';
$texto1=$texto1."'$tit_rein_devam',";
if (!empty($fec_rein_devam)) {$texto = $texto.'fec_rein_devam,'; $texto1 = $texto1."'$fec_rein_devam',";}
$texto=$texto.'tit_nega,';
$texto1=$texto1." '$tit_nega',";
if (!empty($fec_nega)) {$texto = $texto.'fec_nega,'; $texto1 = $texto1."'$fec_nega',";}
$texto=$texto.'tit_cert,';
$texto1=$texto1."'$tit_cert', ";
if (!empty($fec_cert)) {$texto = $texto.'fec_cert,';  $texto1 = $texto1."'$fec_cert',";}
$texto=$texto.' tit_anot,';
$texto1=$texto1." '$tit_anot',";
if (!empty($fec_anot)) {$texto = $texto.'fec_anot,';  $texto1 = $texto1."'$fec_anot',";}
$texto=$texto.'tit_desi_obse,';
$texto1=$texto1."'$tit_desi_obse',";
if (!empty($fec_desi_obse)) {$texto = $texto.'fec_desi_obse,';  $texto1 = $texto1."'$fec_desi_obse',";}
$texto=$texto.'tit_noti,';
$texto1=$texto1."'$tit_noti',";
if (!empty($fec_noti)) {$texto = $texto.'fec_noti,';  $texto1 = $texto1."'$fec_noti',";}

//Colocado por Romulo Mendoza 24/09/2018 Recursos, Nulidades y Cancelaciones Asesoría Jurídica - Marcas   
$texto=$texto.'tit_800,';
$texto1=$texto1."'$tit_800',";
if (!empty($fec_800)) {$texto = $texto.'fec_800,';  $texto1 = $texto1."'$fec_800',";}
$texto=$texto.'tit_801,';
$texto1=$texto1."'$tit_801',";
if (!empty($fec_801)) {$texto = $texto.'fec_801,';  $texto1 = $texto1."'$fec_801',";}
$texto=$texto.'tit_802,';
$texto1=$texto1."'$tit_802',";
if (!empty($fec_802)) {$texto = $texto.'fec_802,';  $texto1 = $texto1."'$fec_802',";}
$texto=$texto.'tit_803,';
$texto1=$texto1."'$tit_803',";
if (!empty($fec_803)) {$texto = $texto.'fec_803,';  $texto1 = $texto1."'$fec_803',";}
$texto=$texto.'tit_804,';
$texto1=$texto1."'$tit_804',";
if (!empty($fec_804)) {$texto = $texto.'fec_804,';  $texto1 = $texto1."'$fec_804',";}
$texto=$texto.'tit_805,';
$texto1=$texto1."'$tit_805',";
if (!empty($fec_805)) {$texto = $texto.'fec_805,';  $texto1 = $texto1."'$fec_805',";}
$texto=$texto.'tit_806,';
$texto1=$texto1."'$tit_806',";
if (!empty($fec_806)) {$texto = $texto.'fec_806,';  $texto1 = $texto1."'$fec_806',";}
$texto=$texto.'tit_807,';
$texto1=$texto1."'$tit_807',";
if (!empty($fec_807)) {$texto = $texto.'fec_807,';  $texto1 = $texto1."'$fec_807',";}
$texto=$texto.'tit_808,';
$texto1=$texto1."'$tit_808',";
if (!empty($fec_808)) {$texto = $texto.'fec_808,';  $texto1 = $texto1."'$fec_808',";}
$texto=$texto.'tit_809,';
$texto1=$texto1."'$tit_809',";
if (!empty($fec_809)) {$texto = $texto.'fec_809,';  $texto1 = $texto1."'$fec_809',";}
$texto=$texto.'tit_821,';
$texto1=$texto1."'$tit_821',";
if (!empty($fec_821)) {$texto = $texto.'fec_821,';  $texto1 = $texto1."'$fec_821',";}
$texto=$texto.'tit_822,';
$texto1=$texto1."'$tit_822',";
if (!empty($fec_822)) {$texto = $texto.'fec_822,';  $texto1 = $texto1."'$fec_822',";}
$texto=$texto.'tit_823,';
$texto1=$texto1."'$tit_823',";
if (!empty($fec_823)) {$texto = $texto.'fec_823,';  $texto1 = $texto1."'$fec_823',";}
$texto=$texto.'tit_824,';
$texto1=$texto1."'$tit_824',";
if (!empty($fec_824)) {$texto = $texto.'fec_824,';  $texto1 = $texto1."'$fec_824',";}
$texto=$texto.'tit_825,';
$texto1=$texto1."'$tit_825',";
if (!empty($fec_825)) {$texto = $texto.'fec_825,';  $texto1 = $texto1."'$fec_825',";}
$texto=$texto.'tit_830,';
$texto1=$texto1."'$tit_830',";
if (!empty($fec_830)) {$texto = $texto.'fec_830,';  $texto1 = $texto1."'$fec_830',";}
$texto=$texto.'tit_831,';
$texto1=$texto1."'$tit_831',";
if (!empty($fec_831)) {$texto = $texto.'fec_831,';  $texto1 = $texto1."'$fec_831',";}
$texto=$texto.'tit_833,';
$texto1=$texto1."'$tit_833',";
if (!empty($fec_833)) {$texto = $texto.'fec_833,';  $texto1 = $texto1."'$fec_833',";}
$texto=$texto.'tit_835,';
$texto1=$texto1."'$tit_835',";
if (!empty($fec_835)) {$texto = $texto.'fec_835,';  $texto1 = $texto1."'$fec_835',";}
$texto=$texto.'tit_836,';
$texto1=$texto1."'$tit_836',";
if (!empty($fec_836)) {$texto = $texto.'fec_836,';  $texto1 = $texto1."'$fec_836',";}
$texto=$texto.'tit_837,';
$texto1=$texto1."'$tit_837',";
if (!empty($fec_837)) {$texto = $texto.'fec_837,';  $texto1 = $texto1."'$fec_837',";}
$texto=$texto.'tit_838,';
$texto1=$texto1."'$tit_838',";
if (!empty($fec_838)) {$texto = $texto.'fec_838,';  $texto1 = $texto1."'$fec_838',";}

$texto=$texto.'titp_soli,';
$texto1=$texto1."'$titp_soli',";
if (!empty($fecp_soli)) {$texto = $texto.'fecp_soli,'; $texto1 = $texto1."'$fecp_soli',";}
$texto=$texto.'titp_orden,';
$texto1=$texto1."'$titp_orden',";
if (!empty($fecp_orde)) {$texto = $texto.'fecp_orde,'; $texto1 = $texto1."'$fecp_orde',";}
$texto=$texto.'titp_conc,';
$texto1=$texto1." '$titp_conc',";
if (!empty($fecp_conc)) {$texto = $texto.'fecp_conc,'; $texto1 = $texto1."'$fecp_conc',";}
$texto=$texto.'titp_devu,';
$texto1=$texto1."'$titp_devu',";
if (!empty($fecp_devu)) {$texto = $texto.'fecp_devu,'; $texto1 = $texto1."'$fecp_devu',";}
$texto=$texto.'titp_prio,';
$texto1=$texto1."'$titp_prio',";
if (!empty($fecp_prio)) {$texto = $texto.'fecp_prio,'; $texto1 = $texto1."'$fecp_prio',";}
$texto=$texto.'titp_prio_exte,';
$texto1=$texto1." '$titp_prio_exte',";
if (!empty($fecp_prio_exte)) {$texto = $texto.'fecp_prio_exte,'; $texto1 = $texto1."'$fecp_prio_exte',";}
$texto=$texto.'titp_prio_defe,';
$texto1=$texto1."'$titp_prio_defe',";
if (!empty($fecp_prio_defe)) {$texto = $texto.'fecp_prio_defe,'; $texto1 = $texto1."'$fecp_prio_defe',";}
$texto=$texto.'titp_peri,';
$texto1=$texto1."'$titp_peri',";
if (!empty($fecp_peri)) {$texto = $texto.'fecp_peri,'; $texto1 = $texto1."'$fecp_peri',";}
$texto=$texto.' titp_dene,';
$texto1=$texto1." '$titp_dene',";
if (!empty($fecp_dene)) {$texto = $texto.'fecp_dene,'; $texto1 = $texto1."'$fecp_dene',";}
$texto=$texto.' titp_desi,';
$texto1=$texto1." '$titp_desi',";
if (!empty($fecp_desi)) {$texto = $texto.'fecp_desi,'; $texto1 = $texto1."'$fecp_desi',";}
$texto=$texto.' titp_aban,';
$texto1=$texto1." '$titp_aban',";
if (!empty($fecp_aban)) {$texto = $texto.'fecp_aban,'; $texto1 = $texto1."'$fecp_aban',";}
$texto=$texto.'titp_nega,';
$texto1=$texto1."'$titp_nega',";
if (!empty($fecp_nega)) {$texto = $texto.'fecp_nega,'; $texto1 = $texto1."'$fecp_nega',";}
$texto=$texto.'titp_opos,';
$texto1=$texto1."'$titp_opos',";
if (!empty($fecp_opos)) {$texto = $texto.'fecp_opos,'; $texto1 = $texto1."'$fecp_opos',";}
$texto=$texto.' titp_reha,';
$texto1=$texto1." '$titp_reha',";
if (!empty($fecp_reha)) {$texto = $texto.'fecp_reha,'; $texto1 = $texto1."'$fecp_reha',";}
$texto=$texto.'titp_titu,';
$texto1=$texto1." '$titp_titu',";
if (!empty($fecp_titu)) {$texto = $texto.'fecp_titu,'; $texto1 = $texto1."'$fecp_titu',";}

//Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto   
$texto=$texto.'titp_sefp,';
$texto1=$texto1." '$titp_sefp',";
if (!empty($fecp_sefp)) {$texto = $texto.'fecp_sefp,'; $texto1 = $texto1."'$fecp_sefp',";}
$texto=$texto.'titp_sevt,';
$texto1=$texto1." '$titp_sevt',";
if (!empty($fecp_sevt)) {$texto = $texto.'fecp_sevt,'; $texto1 = $texto1."'$fecp_sevt',";}

//Colocado por Romulo Mendoza 23/10/2018 Recursos, Nulidades y Cancelaciones Asesoría Jurídica - Patentes   
$texto=$texto.'ptit_800,';
$texto1=$texto1."'$ptit_800',";
if (!empty($pfec_800)) {$texto = $texto.'pfec_800,';  $texto1 = $texto1."'$pfec_800',";}
$texto=$texto.'ptit_801,';
$texto1=$texto1."'$ptit_801',";
if (!empty($pfec_801)) {$texto = $texto.'pfec_801,';  $texto1 = $texto1."'$pfec_801',";}
$texto=$texto.'ptit_802,';
$texto1=$texto1."'$ptit_802',";
if (!empty($pfec_802)) {$texto = $texto.'pfec_802,';  $texto1 = $texto1."'$pfec_802',";}
$texto=$texto.'ptit_804,';
$texto1=$texto1."'$ptit_804',";
if (!empty($pfec_804)) {$texto = $texto.'pfec_804,';  $texto1 = $texto1."'$pfec_804',";}
$texto=$texto.'ptit_805,';
$texto1=$texto1."'$ptit_805',";
if (!empty($pfec_805)) {$texto = $texto.'pfec_805,';  $texto1 = $texto1."'$pfec_805',";}
$texto=$texto.'ptit_806,';
$texto1=$texto1."'$ptit_806',";
if (!empty($pfec_806)) {$texto = $texto.'pfec_806,';  $texto1 = $texto1."'$pfec_806',";}
$texto=$texto.'ptit_809,';
$texto1=$texto1."'$ptit_809',";
if (!empty($pfec_809)) {$texto = $texto.'pfec_809,';  $texto1 = $texto1."'$pfec_809',";}
$texto=$texto.'ptit_821,';
$texto1=$texto1."'$ptit_821',";
if (!empty($pfec_821)) {$texto = $texto.'pfec_821,';  $texto1 = $texto1."'$pfec_821',";}
$texto=$texto.'ptit_833,';
$texto1=$texto1."'$ptit_833',";
if (!empty($pfec_833)) {$texto = $texto.'pfec_833,';  $texto1 = $texto1."'$pfec_833',";}
$texto=$texto.'ptit_835,';
$texto1=$texto1."'$ptit_835',";
if (!empty($pfec_835)) {$texto = $texto.'pfec_835,';  $texto1 = $texto1."'$pfec_835',";}
$texto=$texto.'ptit_836,';
$texto1=$texto1."'$ptit_836',";
if (!empty($pfec_836)) {$texto = $texto.'pfec_836,';  $texto1 = $texto1."'$pfec_836',";}
$texto=$texto.'ptit_837,';
$texto1=$texto1."'$ptit_837',";
if (!empty($pfec_837)) {$texto = $texto.'pfec_837,';  $texto1 = $texto1."'$pfec_837',";}
$texto=$texto.'ptit_838,';
$texto1=$texto1."'$ptit_838',";
if (!empty($pfec_838)) {$texto = $texto.'pfec_838,';  $texto1 = $texto1."'$pfec_838',";}
$texto=$texto.'ptit_840,';
$texto1=$texto1."'$ptit_840',";
if (!empty($pfec_840)) {$texto = $texto.'pfec_840,';  $texto1 = $texto1."'$pfec_840',";}
$texto=$texto.'ptit_921,';
$texto1=$texto1."'$ptit_921',";
if (!empty($pfec_921)) {$texto = $texto.'pfec_921,';  $texto1 = $texto1."'$pfec_921',";}
$texto=$texto.'ptit_922,';
$texto1=$texto1."'$ptit_922',";
if (!empty($pfec_922)) {$texto = $texto.'pfec_922,';  $texto1 = $texto1."'$pfec_922',";}

//Colocado por Romulo Mendoza 07/03/2012 Devueltas por fondo   
$texto=$texto.'tit_fondo,';
$texto1=$texto1."'$tit_fondo',";
if (!empty($fec_fondo)) {$texto = $texto.'fec_fondo,';  $texto1 = $texto1."'$fec_fondo',";}

//Colocado por Romulo Mendoza 16/04/2018 Patentes sin efecto x Falta de Pago de Derechos de Concesion   
$texto=$texto.'titp_derp';
$texto1=$texto1."'$titp_derp'";
if (!empty($fecp_derp)) {$texto = $texto.'fecp_derp,';  $texto1 = $texto1."'$fecp_derp',";}

// ************************************************************************************
$smarty->assign('titulo',$substrpi);
$smarty->assign('subtitulo','Boletín de la Propiedad Industrial del R.P.I.');
if ($vopc==3 || $vopc==4) {
  $smarty->assign('subtitulo','Ingreso de Nuevo Boletin del R.P.I. a Generar '); }
if ($vopc==5 || $vopc==6) {
  $smarty->assign('subtitulo','Modificaci&oacute;n de Boletín del R.P.I.'); } 

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//if (($usuario!='rmendoza') AND ($usuario!='ngonzalez')) {
//  mensajenew('AVISO: Opci&oacute;n del sistema en Mantenimiento, Comuniquese con el Administrador del Sistema SIPI ...!!!','javascript:history.back();','N');
//  $smarty->display('pie_pag.tpl'); exit();
//}

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  if ($vopc == 3) { $opra='I'; }
  if ($vopc == 5) { $opra='M'; }
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

// ************************************************************************************  
//Verificando conexion
 $sql->connection($usuario);

// ************************************************************************************
if ($vopc==3) {
  $smarty->assign('varfocus','forboletin.nbol');
  $smarty->assign('bmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $accion = "I";
}

// ************************************************************************************
if ($vopc==4) {
  $accion = "I";
  $nconex = $_POST['nconex'];
  $tipobol= $_POST['aplica'];

  if (empty($nbol)) {
    mensajenew("AVISO: No introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 

  if ($tipobol=='O') {
    if ($nbol<510) {
      mensajenew("AVISO: Por ser Bolet&iacute;n Ordinario NO puede ser menor al 510 ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); exit(); 
    }  	   
  } 

  $res_boletin = pg_exec("SELECT * FROM $tbname_1 WHERE nro_boletin='$nbol'");
  $nfil = pg_numrows($res_boletin);
  if ($nfil>0) {
   mensajenew("AVISO: Número de Boletín $nbol ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); } 

  //La Fecha de Hoy para la solicitud
  $fecha_gener = hoy();
  $smarty->assign('fecha_gener',$fecha_gener);
  $smarty->assign('bmodo',''); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==4 

// ************************************************************************************
if ($vopc==5) {
  $smarty->assign('varfocus','forboletin1.nbol');
  $smarty->assign('bmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $accion = "M";
}

// ************************************************************************************ 
if ($vopc==6) {
  $accion = "M";
  $nconex = $_POST['nconex'];
  $tipobol= $_POST['aplica'];
  
  if (empty($nbol)) {
    mensajenew("AVISO: NO introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 

  //echo "Aplica= $tipobol"; exit();

  // Obtencion de los datos del boletín 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_boletin='$nbol' AND tipo_boletin='$tipobol'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);

  if ($filas_found==0) {
    mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS AL BOLETIN INDICADO ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
  $fecha_pub   = $objs->fecha_pub;
  //$fecha_ven     = $objs->fecha_ven;
  $anoi	      = $objs->anoi;
  $anof        = $objs->anof;
  $anor        = $objs->anor;
    
  //Obtencion de detalle del boletin
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_boletin='$nbol' AND tipo_boletin='$tipobol'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found > 0) {

    $objs = $sql->objects('',$obj_query);
	//marcas
	$tit_soli       = trim($objs->tit_soli);
	$fec_soli       = trim($objs->fec_soli);
	$tit_orden      = trim($objs->tit_orden);
	$fec_orde       = trim($objs->fec_orde);
	$tit_conc       = trim($objs->tit_conc);
	$fec_conc       = trim($objs->fec_conc);
	$tit_devu       = trim($objs->tit_devu);  
	$fec_devu       = trim($objs->fec_devu);
	$tit_obse       = trim($objs->tit_obse);
	$fec_obse       = trim($objs->fec_obse);
	$tit_obse_scon  = trim($objs->tit_obse_scon);
	$fec_obse_scon  = trim($objs->fec_obse_scon);
	$tit_prio       = trim($objs->tit_prio);
	$fec_prio       = trim($objs->fec_prio);
	$tit_prio_exte  = trim($objs->tit_prio_exte);
	$fec_prio_exte  = trim($objs->fec_prio_exte);
	$tit_prio_defe  = trim($objs->tit_prio_defe);
	$fec_prio_defe  = trim($objs->fec_prio_defe);
	$tit_peri       = trim($objs->tit_peri);
	$fec_peri       = trim($objs->fec_peri);
	$tit_cadu       = trim($objs->tit_cadu);
	$fec_cadu       = trim($objs->fec_cadu); 
	$tit_desi       = trim($objs->tit_desi);
	$fec_desi       = trim($objs->fec_desi);
	$tit_desi_mejo  = trim($objs->tit_desi_mejo);  
	$fec_desi_mejo  = trim($objs->fec_desi_mejo);
	$tit_desi_ley   = trim($objs->tit_desi_ley);
	$fec_desi_ley   = trim($objs->fec_desi_ley);
	$tit_cadu_nren  = trim($objs->tit_cadu_nren);
	$fec_cadu_nren  = trim($objs->fec_cadu_nren);
	$tit_regi       = trim($objs->tit_regi);
	$fec_regi       = trim($objs->fec_regi);
	$tit_devu_scon  = trim($objs->tit_devu_scon);
	$fec_devu_scon  = trim($objs->fec_devu_scon);
	$tit_desi_anom  = trim($objs->tit_desi_anom);
	$fec_desi_anom  = trim($objs->fec_desi_anom);
	$tit_devo_regi  = trim($objs->tit_devo_regi);
	$fec_devo_regi  = trim($objs->fec_devo_regi);
	$tit_rein_devam = trim($objs->tit_rein_devam);
	$fec_rein_devam = trim($objs->fec_rein_devam);
	$tit_nega       = trim($objs->tit_nega);
	$fec_nega       = trim($objs->fec_nega);
	$tit_cert       = trim($objs->tit_cert);
	$fec_cert       = trim($objs->fec_cert);
	$tit_anot       = trim($objs->tit_anot);
	$fec_anot       = trim($objs->fec_anot);
	
	$tit_desi_obse  = trim($objs->tit_desi_obse);
	$fec_desi_obse  = trim($objs->fec_desi_obse);
	$tit_noti       = trim($objs->tit_noti);
	$fec_noti       = trim($objs->fec_noti);
	$tit_fondo      = trim($objs->tit_fondo);  
	$fec_fondo      = trim($objs->fec_fondo); 

	//patentes
	$titp_soli      = trim($objs->titp_soli);
	$fecp_soli      = trim($objs->fecp_soli);
	$titp_orden     = trim($objs->titp_orden);
	$fecp_orde      = trim($objs->fecp_orde);
	$titp_conc      = trim($objs->titp_conc);
	$fecp_conc      = trim($objs->fecp_conc);
	$titp_devu      = trim($objs->titp_devu);  
	$fecp_devu      = trim($objs->fecp_devu);
	$titp_prio      = trim($objs->titp_prio);
	$fecp_prio      = trim($objs->fecp_prio);
	$titp_prio_exte = trim($objs->titp_prio_exte);
	$fecp_prio_exte = trim($objs->fecp_prio_exte);
	$titp_prio_defe = trim($objs->titp_prio_defe);
	$fecp_prio_defe = trim($objs->fecp_prio_defe);
	$titp_peri      = trim($objs->titp_peri);
	$fecp_peri      = trim($objs->fecp_peri);
	$titp_dene      = trim($objs->titp_dene);
	$fecp_dene      = trim($objs->fecp_dene);
	$titp_desi      = trim($objs->titp_desi);
	$fecp_desi      = trim($objs->fecp_desi);
	$titp_aban      = trim($objs->titp_aban);
	$fecp_aban      = trim($objs->fecp_aban); 
	$titp_nega      = trim($objs->titp_nega);
	$fecp_nega      = trim($objs->fecp_nega);
	$titp_opos      = trim($objs->titp_opos);  
	$fecp_opos      = trim($objs->fecp_opos);
	$titp_reha      = trim($objs->titp_reha);
	$fecp_reha      = trim($objs->fecp_reha);
	$titp_titu      = trim($objs->titp_titu);
	$fecp_titu      = trim($objs->fecp_titu);
   //Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto
   $titp_sefp      = trim($objs->titp_sefp);
   $fecp_sefp      = trim($objs->fecp_sefp); 
   $titp_sevt      = trim($objs->titp_sevt);
   $fecp_sevt      = trim($objs->fecp_sevt);}
   //Colocado por Romulo Mendoza 16/04/2018 Patentes sin efecto x No Pago de Derechos de Concesion
   $titp_derp      = trim($objs->titp_derp);
   $fecp_derp      = trim($objs->fecp_derp); 

	//Colocado por PIII - Ing. Romulo Mendoza 24/09/2018 Asesoria Juridica Recursos, Nulidades y Cancelaciones Marcas 
	$tit_800        = trim($objs->tit_800);
	$fec_800        = trim($objs->fec_800);
	$tit_801        = trim($objs->tit_801);
	$fec_801        = trim($objs->fec_801);
	$tit_802        = trim($objs->tit_802);
	$fec_802        = trim($objs->fec_802);
	$tit_803        = trim($objs->tit_803);
	$fec_803        = trim($objs->fec_803);
	$tit_804        = trim($objs->tit_804);
	$fec_804        = trim($objs->fec_804);
	$tit_805        = trim($objs->tit_805);
	$fec_805        = trim($objs->fec_805);
	$tit_806        = trim($objs->tit_806);
	$fec_806        = trim($objs->fec_806);
	$tit_807        = trim($objs->tit_807);
	$fec_807        = trim($objs->fec_807);
	$tit_808        = trim($objs->tit_808);
	$fec_808        = trim($objs->fec_808);
	$tit_809        = trim($objs->tit_809);
	$fec_809        = trim($objs->fec_809);
	$tit_821        = trim($objs->tit_821);
	$fec_821        = trim($objs->fec_821);
	$tit_822        = trim($objs->tit_822);
	$fec_822        = trim($objs->fec_822);
	$tit_823        = trim($objs->tit_823);
	$fec_823        = trim($objs->fec_823);
	$tit_824        = trim($objs->tit_824);
	$fec_824        = trim($objs->fec_824);
	$tit_825        = trim($objs->tit_825);
	$fec_825        = trim($objs->fec_825);
	$tit_830        = trim($objs->tit_830);
	$fec_830        = trim($objs->fec_830);
	$tit_831        = trim($objs->tit_831);
	$fec_831        = trim($objs->fec_831);
	$tit_833        = trim($objs->tit_833);
	$fec_833        = trim($objs->fec_833);
	$tit_835        = trim($objs->tit_835);
	$fec_835        = trim($objs->fec_835);
	$tit_836        = trim($objs->tit_836);
	$fec_836        = trim($objs->fec_836);
	$tit_837        = trim($objs->tit_837);
	$fec_837        = trim($objs->fec_837);
	$tit_838        = trim($objs->tit_838);
	$fec_838        = trim($objs->fec_838);

	//Colocado por PIII - Ing. Romulo Mendoza 23/10/2018 Asesoria Juridica Recursos, Nulidades y Cancelaciones Patentes
	$ptit_800       = trim($objs->ptit_800);
	$pfec_800       = trim($objs->pfec_800);
	$ptit_801       = trim($objs->ptit_801);
	$pfec_801       = trim($objs->pfec_801);
	$ptit_802       = trim($objs->ptit_802);
	$pfec_802       = trim($objs->pfec_802);
	$ptit_804       = trim($objs->ptit_804);
	$pfec_804       = trim($objs->pfec_804);
	$ptit_805       = trim($objs->ptit_805);
	$pfec_805       = trim($objs->pfec_805);
	$ptit_806       = trim($objs->ptit_806);
	$pfec_806       = trim($objs->pfec_806);
	$ptit_809       = trim($objs->ptit_809);
	$pfec_809       = trim($objs->pfec_809);
	$ptit_821       = trim($objs->ptit_821);
	$pfec_821       = trim($objs->pfec_821);
	$ptit_833       = trim($objs->ptit_833);
	$pfec_833       = trim($objs->pfec_833);
	$ptit_835       = trim($objs->ptit_835);
	$pfec_835       = trim($objs->pfec_835);
	$ptit_836       = trim($objs->ptit_836);
	$pfec_836       = trim($objs->pfec_836);
	$ptit_837       = trim($objs->ptit_837);
	$pfec_837       = trim($objs->pfec_837);
	$ptit_838       = trim($objs->ptit_838);
	$pfec_838       = trim($objs->pfec_838);
	$ptit_840       = trim($objs->ptit_840);
	$pfec_840       = trim($objs->pfec_840);
	$ptit_921       = trim($objs->ptit_921);
	$pfec_921       = trim($objs->pfec_921);
	$ptit_922       = trim($objs->ptit_922);
	$pfec_922       = trim($objs->pfec_922);
 
  $valores_fields = array($fecha_pub, $anoi, $anof,$tit_soli,$fec_soli, $tit_orden,$fec_orde, $tit_conc, $fec_conc, $tit_devu, $fec_devu, $tit_obse, $fec_obse, $tit_obse_scon, $fec_obse_scon, $tit_prio, $fec_prio, $tit_prio_exte, $fec_prio_exte, $tit_prio_defe, $fec_prio_defe, $tit_peri, $fec_peri,$tit_cadu, $fec_cadu, $tit_desi, $fec_desi, $tit_desi_mejo, $fec_desi_mejo,$tit_desi_ley, $fec_desi_ley,  $tit_cadu_nren, $fec_cadu_nren, $tit_regi, $fec_regi,  $tit_devu_scon, $fec_devu_scon,  $tit_desi_anom, $fec_desi_anom, $tit_devo_regi,$fec_devo_regi,$tit_rein_devam, $fec_rein_devam,$tit_nega, $fec_nega, $tit_cert, $fec_cert,  $tit_anot,$fec_anot, $tit_desi_obse,$fec_desi_obse, $tit_noti,$fec_noti, $titp_soli, $fecp_soli,$titp_orden, $fecp_orde, $titp_conc, $fecp_conc, $titp_devu, $fecp_devu, $titp_prio, $fecp_prio, $titp_prio_exte, $fecp_prio_exte, $titp_prio_defe,$fecp_prio_defe, $titp_peri, $fecp_peri, $titp_dene, $fecp_dene,  $titp_desi, $fecp_desi,$titp_aban, $fecp_aban, $titp_nega, $fecp_nega,$titp_opos, $fecp_opos, $titp_reha, $fecp_reha, $titp_titu, $fecp_titu, $titp_sefp, $fecp_sefp, $titp_sevt, $fecp_sevt, $tit_fondo, $fec_fondo, $titp_derp, $fecp_derp);

  $campos = "fecha_pub |anoi |anof |anor |tit_soli |fec_soli |tit_orden|fec_orde |tit_conc |fec_conc |tit_devu |fec_devu |tit_obse |fec_obse |tit_obse_scon |fec_obse_scon |tit_prio |fec_prio |tit_prio_exte |fec_prio_exte |tit_prio_defe |fec_prio_defe |tit_peri |fec_peri |tit_cadu |fec_cadu |tit_desi |fec_desi |tit_desi_mejo |fec_desi_mejo|tit_desi_ley |fec_desi_ley |tit_cadu_nren |fec_cadu_nren|tit_regi |fec_regi |tit_devu_scon |fec_devu_scon |tit_desi_anom |fec_desi_anom |tit_devo_regi|fec_devo_regi |tit_rein_devam |fec_rein_devam |tit_nega |fec_nega |tit_cert |fec_cert |tit_anot|fec_anot |tit_desi_obse|fec_desi_obse|  tit_noti|fec_noti |titp_soli |fecp_soli|titp_orden |fecp_orde |titp_conc |fecp_conc |titp_devu |fecp_devu|titp_prio |fecp_prio|titp_prio_exte |fecp_prio_exte |titp_prio_defe|fecp_prio_defe |titp_peri |fecp_peri |titp_dene |fecp_dene |titp_desi |fecp_desi|titp_aban |fecp_aban |titp_nega |fecp_nega |titp_opos |fecp_opos |titp_reha |fecp_reha |titp_titu |fecp_titu|titp_sefp |fecp_sefp |titp_sevt |fecp_sevt |tit_fondo |fec_fondo |titp_derp |fecp_derp ";
  $smarty->assign('string',$string);
   
  $smarty->assign('campos',$campos);
  $smarty->assign('modo','disabled'); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==6  


// ************************************************************************************ 
//Opcion Grabar...
if ($vopc==2) {
  $n_conex = $_POST['nconex'];
  $tipobol = $_POST['aplica'];

  // La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= hora();

  // Comparación de la fecha de Solicitud
  if ($fecha_pub==$fechahoy) { } 
  else {
    $esmayor=compara_fechas($fecha_pub,$fechahoy);
    if ($esmayor==0) {
      mensajenew("AVISO: La Fecha de Publicación No puede ser menor a la de Hoy ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); exit(); }
  }

  // Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_pub","anoi","anof","anor");
  $valores = array($fecha_pub,$anoi,$anof);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("ERROR: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag1.tpl'); exit(); }
  
  if ($accion=="I") { //Comienzo de INCLUIR   

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    // Tabla Maestra de boletin 
    $resula=pg_exec("select * from $tbname_1 where nro_boletin='$nbol'");
    $rega= pg_fetch_array($resula);
    $nfil=pg_numrows($resula);
    if ($nfil>0) {
      mensajenew("AVISO: Número de Boletín $nbol ya existe en la Base de Datos ...!!!","b_ingreso.php?vopc=3","N");
      $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); }

    // La Hora actual para la transaccion
    $horactual= hora();

    // Comienzo de Transaccion Nuevamente 
    pg_exec("BEGIN WORK");
  
    //Busqueda de Numero de resolucion
    $resulr=pg_exec("select * from $tbname_1 where nro_boletin='$nbol'-1");
    $regr= pg_fetch_array($resulr);
    $resoluci= $regr['resolucf']+1;
  
    // Insertamos primero en la Tabla Maestra de Boletin
    $col_campos = "nro_boletin,fecha_pub,fecha_gen, hora_gen, anoi, anof, anor, resoluci,usuario,generado,tipo_boletin";
    $insert_str = "'$nbol','$fecha_pub','$fechahoy','$horactual','$anoi','$anof','$anor' ,'$resoluci','$usuario','N','$tipobol'";
    $ins_boletin = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Detalle del Boletin 
    $col_camposd = $texto.",tipo_boletin";

    $insert_strd = $texto1.",'$tipobol'";
    $ins_detalle = $sql->insert("$tbname_2","$col_camposd","$insert_strd","");

    if ($ins_boletin AND $ins_detalle) {
      pg_exec("COMMIT WORK"); }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$ins_boletin) { $error_boletin  = " - Boletin "; }
      if (!$ins_detalle) { $error_detalle  = " - Detalle "; }

      Mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_boletin $error_detalle ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); exit(); 
    }



    //Variable para la busqueda de la imagen en busqueda
    $ruta= "/apl/boletin/";
    $archivo = $_FILES['ubicacion']['name'];
    $vnewnombre="avisos";
    if (!empty($archivo)) {
       //Copiar archivo de avisos
       $max_size = 1; // the max. size for uploading	
       $my_upload = new file_upload;
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".pdf"); // specify the allowed extensions here
       $my_upload->max_length_filename = 250; // change this value to fit your field length in your database (standard 100)
       $my_upload->rename_file = true;
       $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
       $my_upload->the_file = $_FILES['ubicacion']['name'];
       $my_upload->http_error = $_FILES['ubicacion']['error'];
       $my_upload->validateExtension();
       if ($my_upload->upload($vnewnombre)) { 
	  echo '';		
       } 
       else {
	  //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); 
	  exit(); }
    }
   // else {
   //    mensajenew('Achivo aun NO seleccionado ...!!!','javascript:history.back();','N');
   //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
   // }

   //Incluir


  } // Final de Incluir 
  
  else { //Comienzo de MODIFICAR 

    // La Fecha de Hoy y Hora para la transaccion
    $fechahoy = hoy();
    $horactual= Hora();

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");
     //Busqueda de Numero de resolucion
    $resulr=pg_exec("select * from $tbname_1 where nro_boletin='$nbol'-1");
    $regr= pg_fetch_array($resulr);
    $resoluci= $regr['resoluci']+1;
    // Actualizacion de Tabla Maestra de Boletin 
    pg_exec("LOCK TABLE stzboletin IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "fecha_pub = '$fecha_pub',anoi= '$anoi', anof = '$anof', anor = '$anor', resoluci= '$resoluci'";
    $act_boletin = $sql->update("$tbname_1","$update_str","nro_boletin='$nbol'");

      // Actualizacion de la Tabla detalle de boletin
      pg_exec("LOCK TABLE stzdetbol IN SHARE ROW EXCLUSIVE MODE");
      
      //verificar los campos fechas
 //     $texto3=$texto3.'"';

if (!empty($fec_soli)) {$texto3 = $texto3."fec_soli  = '$fec_soli',"; }
$texto3=$texto3."tit_soli = '$tit_soli',";
if (empty($fec_soli)) {pg_exec("update stzdetbol SET fec_soli=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_orden   = '$tit_orden',";
if (!empty($fec_orde)) { $texto3 = $texto3."fec_orde    = '$fec_orde',"; }
if (empty($fec_orde)) {pg_exec("update stzdetbol SET fec_orde=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_conc    = '$tit_conc',";
if (!empty($fec_conc)) {$texto3 = $texto3."fec_conc    = '$fec_conc',";  }
if (empty($fec_conc)) {pg_exec("update stzdetbol SET fec_conc=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_devu    = '$tit_devu', ";
if (!empty($fec_devu)) {$texto3 = $texto3."fec_devu    = '$fec_devu',"; }
if (empty($fec_devu)) {pg_exec("update stzdetbol SET fec_devu=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_obse    = '$tit_obse',";
if (!empty($fec_obse)) {$texto3 = $texto3."fec_obse    = '$fec_obse',";  }
if (empty($fec_obse)) {pg_exec("update stzdetbol SET fec_obse=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_obse_scon  = '$tit_obse_scon',";
if (!empty($fec_obse_scon)) {$texto3 = $texto3."fec_obse_scon  = '$fec_obse_scon',"; }
if (empty($fec_obse_scon)) {pg_exec("update stzdetbol SET fec_obse_scon=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_prio       = '$tit_prio',";
if (!empty($fec_prio)) {$texto3 = $texto3."fec_prio       = '$fec_prio',"; }
if (empty($fec_prio)) {pg_exec("update stzdetbol SET fec_prio=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_prio_exte  = '$tit_prio_exte',";
if (!empty($fec_prio_exte)) {$texto3 = $texto3."fec_prio_exte  = '$fec_prio_exte',"; }
if (empty($fec_prio_exte)) {pg_exec("update stzdetbol SET fec_prio_exte=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_prio_defe  = '$tit_prio_defe',";
if (!empty($fec_prio_defe)) {$texto3 = $texto3."fec_prio_defe  = '$fec_prio_defe',"; }
if (empty($fec_prio_defe)) {pg_exec("update stzdetbol SET fec_prio_defe=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_peri       = '$tit_peri',";
if (!empty($fec_peri)) {$texto3 = $texto3."fec_peri       = '$fec_peri',"; }
if (empty($fec_peri)) {pg_exec("update stzdetbol SET fec_peri=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_cadu       = '$tit_cadu',";
if (!empty($fec_cadu)) {$texto3 = $texto3."fec_cadu       = '$fec_cadu', "; }
if (empty($fec_cadu)) {pg_exec("update stzdetbol SET fec_cadu=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_desi       = '$tit_desi',";
if (!empty($fec_desi)) {$texto3 = $texto3."fec_desi       = '$fec_desi',"; }
if (empty($fec_desi)) {pg_exec("update stzdetbol SET fec_desi=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_desi_mejo  = '$tit_desi_mejo',";
if (!empty($fec_desi_mejo)) {$texto3 = $texto3."fec_desi_mejo  = '$fec_desi_mejo',"; }
if (empty($fec_desi_mejo)) {pg_exec("update stzdetbol SET fec_desi_mejo=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_desi_ley   = '$tit_desi_ley',";
if (!empty($fec_desi_ley)) {$texto3 = $texto3."fec_desi_ley   = '$fec_desi_ley',";  }
if (empty($fec_desi_ley)) {pg_exec("update stzdetbol SET fec_desi_ley=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_cadu_nren  = '$tit_cadu_nren',";
if (!empty($fec_cadu_nren)) {$texto3 = $texto3."fec_cadu_nren  = '$fec_cadu_nren',"; }
if (empty($fec_cadu_nren)) {pg_exec("update stzdetbol SET fec_cadu_nren=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_regi       = '$tit_regi',";
if (!empty($fec_regi)) {$texto3 = $texto3."fec_regi       = '$fec_regi',";  }
if (empty($fec_regi)) {pg_exec("update stzdetbol SET fec_regi=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_devu_scon  = '$tit_devu_scon',";
if (!empty($fec_devu_scon)) {$texto3 = $texto3."fec_devu_scon  = '$fec_devu_scon',"; }
if (empty($fec_devu_scon)) {pg_exec("update stzdetbol SET fec_devu_scon=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_desi_anom  = '$tit_desi_anom',";
if (!empty($fec_desi_anom)) {$texto3 = $texto3."fec_desi_anom  = '$fec_desi_anom',"; }
if (empty($fec_desi_anom)) {pg_exec("update stzdetbol SET fec_desi_anom=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_devo_regi  = '$tit_devo_regi',";
if (!empty($fec_devo_regi)) {$texto3 = $texto3."fec_devo_regi  = '$fec_devo_regi',";}
if (empty($fec_devo_regi)) {pg_exec("update stzdetbol SET fec_devo_regi=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_rein_devam = '$tit_rein_devam',";
if (!empty($fec_rein_devam)) {$texto3 = $texto3."fec_rein_devam  = '$fec_rein_devam',";; }
if (empty($fec_rein_devam)) {pg_exec("update stzdetbol SET fec_rein_devam=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_nega       = '$tit_nega',";
if (!empty($fec_nega)) {$texto3 = $texto3."fec_nega       = '$fec_nega',"; }
if (empty($fec_nega)) {pg_exec("update stzdetbol SET fec_nega=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_cert       = '$tit_cert',";
if (!empty($fec_cert)) {$texto3 = $texto3."fec_cert       = '$fec_cert',";  }
if (empty($fec_cert)) {pg_exec("update stzdetbol SET fec_cert=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_anot       = '$tit_anot',";
if (!empty($fec_anot)) {$texto3 = $texto3."fec_anot       = '$fec_anot',"; }
if (empty($fec_anot)) {pg_exec("update stzdetbol SET fec_anot=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_desi_obse         = '$tit_desi_obse',";
if (!empty($fec_desi_obse)) {$texto3 = $texto3."fec_desi_obse         = '$fec_desi_obse',";}
if (empty($fec_desi_obse)) {pg_exec("update stzdetbol SET fec_desi_obse=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_noti         = '$tit_noti',";
if (!empty($fec_noti)) {$texto3 = $texto3."fec_noti         = '$fec_noti',";}
if (empty($fec_noti)) {pg_exec("update stzdetbol SET fec_noti=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_soli      = '$titp_soli',";
if (!empty($fecp_soli)) {$texto3 = $texto3."fecp_soli      = '$fecp_soli',"; }
if (empty($fecp_soli)) {pg_exec("update stzdetbol SET fecp_soli=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_orden     = '$titp_orden',";
if (!empty($fecp_orde)) {$texto3 = $texto3."fecp_orde      = '$fecp_orde',"; }
if (empty($fecp_orde)) {pg_exec("update stzdetbol SET fecp_orde=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_conc      = '$titp_conc',";
if (!empty($fecp_conc)) {$texto3 = $texto3."fecp_conc      = '$fecp_conc',"; }
if (empty($fecp_conc)) {pg_exec("update stzdetbol SET fecp_conc=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_devu      = '$titp_devu',";
if (!empty($fecp_devu)) {$texto3 = $texto3."fecp_devu      = '$fecp_devu',";}
if (empty($fecp_devu)) {pg_exec("update stzdetbol SET fecp_devu=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_prio      = '$titp_prio',";
if (!empty($fecp_prio)) {$texto3 = $texto3."fecp_prio      = '$fecp_prio',"; }
if (empty($fecp_prio)) {pg_exec("update stzdetbol SET fecp_prio=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_prio_exte    = '$titp_prio_exte',";
if (!empty($fecp_prio_exte)) {$texto3 = $texto3."fecp_prio_exte    = '$fecp_prio_exte',"; }
if (empty($fecp_prio_exte)) {pg_exec("update stzdetbol SET fecp_prio_exte=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_prio_defe    = '$titp_prio_defe',";
if (!empty($fecp_prio_defe)) {$texto3 = $texto3."fecp_prio_defe    = '$fecp_prio_defe',";}
if (empty($fecp_prio_defe)) {pg_exec("update stzdetbol SET fecp_prio_defe=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_peri         = '$titp_peri',";
if (!empty($fecp_peri)) {$texto3 = $texto3."fecp_peri         = '$fecp_peri',"; }
if (empty($fecp_peri)) {pg_exec("update stzdetbol SET fecp_peri=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_dene         = '$titp_dene',";
if (!empty($fecp_dene)) {$texto3 = $texto3."fecp_dene         = '$fecp_dene',"; }
if (empty($fecp_dene)) {pg_exec("update stzdetbol SET fecp_dene=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_desi         = '$titp_desi',";
if (!empty($fecp_desi)) {$texto3 = $texto3."fecp_desi         = '$fecp_desi',";}
if (empty($fecp_desi)) {pg_exec("update stzdetbol SET fecp_desi=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_aban         = '$titp_aban',";
if (!empty($fecp_aban)) {$texto3 = $texto3."fecp_aban         = '$fecp_aban', "; }
if (empty($fecp_aban)) {pg_exec("update stzdetbol SET fecp_aban=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_nega         = '$titp_nega',";
if (!empty($fecp_nega)) {$texto3 = $texto3."fecp_nega         = '$fecp_nega',"; }
if (empty($fecp_nega)) {pg_exec("update stzdetbol SET fecp_nega=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_opos         = '$titp_opos',";
if (!empty($fecp_opos)) {$texto3 = $texto3."fecp_opos         = '$fecp_opos',"; }
if (empty($fecp_opos)) {pg_exec("update stzdetbol SET fecp_opos=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_reha         = '$titp_reha',";
if (!empty($fecp_reha)) {$texto3 = $texto3."fecp_reha         = '$fecp_reha',";}
if (empty($fecp_reha)) {pg_exec("update stzdetbol SET fecp_reha=NULL WHERE nro_boletin= '$nbol'"); }

$texto3=$texto3."titp_titu         = '$titp_titu',";
if (!empty($fecp_titu)) {$texto3 = $texto3."fecp_titu         = '$fecp_titu',";}
if (empty($fecp_titu)) {pg_exec("update stzdetbol SET fecp_titu=NULL WHERE nro_boletin= '$nbol'"); }

//Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto
$texto3=$texto3."titp_sefp         = '$titp_sefp',";
if (!empty($fecp_sefp)) {$texto3 = $texto3."fecp_sefp         = '$fecp_sefp',";}
if (empty($fecp_sefp)) {pg_exec("update stzdetbol SET fecp_sefp=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."titp_sevt         = '$titp_sevt',";
if (!empty($fecp_sevt)) {$texto3 = $texto3."fecp_sevt         = '$fecp_sevt',";}
if (empty($fecp_sevt)) {pg_exec("update stzdetbol SET fecp_sevt=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_fondo    = '$tit_fondo',";
if (!empty($fec_fondo)) {$texto3 = $texto3."fec_fondo    = '$fec_fondo',"; }
if (empty($fec_fondo)) {pg_exec("update stzdetbol SET fec_fondo=NULL WHERE nro_boletin= '$nbol'"); }

//Colocado por Ing. Romulo Mendoza 24/09/2018 Asesoria Juridica - Marcas
$texto3=$texto3."tit_800    = '$tit_800',";
if (!empty($fec_800)) {$texto3 = $texto3."fec_800    = '$fec_800',"; }
if (empty($fec_800)) {pg_exec("update stzdetbol SET fec_800=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_801    = '$tit_801',";
if (!empty($fec_801)) {$texto3 = $texto3."fec_801    = '$fec_801',"; }
if (empty($fec_801)) {pg_exec("update stzdetbol SET fec_801=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_802    = '$tit_802',";
if (!empty($fec_802)) {$texto3 = $texto3."fec_802    = '$fec_802',"; }
if (empty($fec_802)) {pg_exec("update stzdetbol SET fec_802=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_803    = '$tit_803',";
if (!empty($fec_803)) {$texto3 = $texto3."fec_803    = '$fec_803',"; }
if (empty($fec_803)) {pg_exec("update stzdetbol SET fec_803=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_804    = '$tit_804',";
if (!empty($fec_804)) {$texto3 = $texto3."fec_804    = '$fec_804',"; }
if (empty($fec_804)) {pg_exec("update stzdetbol SET fec_804=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_805    = '$tit_805',";
if (!empty($fec_805)) {$texto3 = $texto3."fec_805    = '$fec_805',"; }
if (empty($fec_805)) {pg_exec("update stzdetbol SET fec_805=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_806    = '$tit_806',";
if (!empty($fec_806)) {$texto3 = $texto3."fec_806    = '$fec_806',"; }
if (empty($fec_806)) {pg_exec("update stzdetbol SET fec_806=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_807    = '$tit_807',";
if (!empty($fec_807)) {$texto3 = $texto3."fec_807    = '$fec_807',"; }
if (empty($fec_807)) {pg_exec("update stzdetbol SET fec_807=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_808    = '$tit_808',";
if (!empty($fec_808)) {$texto3 = $texto3."fec_808    = '$fec_808',"; }
if (empty($fec_808)) {pg_exec("update stzdetbol SET fec_808=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_809    = '$tit_809',";
if (!empty($fec_809)) {$texto3 = $texto3."fec_809    = '$fec_809',"; }
if (empty($fec_809)) {pg_exec("update stzdetbol SET fec_809=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_821    = '$tit_821',";
if (!empty($fec_821)) {$texto3 = $texto3."fec_821    = '$fec_821',"; }
if (empty($fec_821)) {pg_exec("update stzdetbol SET fec_821=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_822    = '$tit_822',";
if (!empty($fec_822)) {$texto3 = $texto3."fec_822    = '$fec_822',"; }
if (empty($fec_822)) {pg_exec("update stzdetbol SET fec_822=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_823    = '$tit_823',";
if (!empty($fec_823)) {$texto3 = $texto3."fec_823    = '$fec_823',"; }
if (empty($fec_823)) {pg_exec("update stzdetbol SET fec_823=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_824    = '$tit_824',";
if (!empty($fec_824)) {$texto3 = $texto3."fec_824    = '$fec_824',"; }
if (empty($fec_824)) {pg_exec("update stzdetbol SET fec_824=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_825    = '$tit_825',";
if (!empty($fec_825)) {$texto3 = $texto3."fec_825    = '$fec_825',"; }
if (empty($fec_825)) {pg_exec("update stzdetbol SET fec_825=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_830    = '$tit_830',";
if (!empty($fec_830)) {$texto3 = $texto3."fec_830    = '$fec_830',"; }
if (empty($fec_830)) {pg_exec("update stzdetbol SET fec_830=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_831    = '$tit_831',";
if (!empty($fec_831)) {$texto3 = $texto3."fec_831    = '$fec_831',"; }
if (empty($fec_831)) {pg_exec("update stzdetbol SET fec_831=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_833    = '$tit_833',";
if (!empty($fec_833)) {$texto3 = $texto3."fec_833    = '$fec_833',"; }
if (empty($fec_833)) {pg_exec("update stzdetbol SET fec_833=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_835    = '$tit_835',";
if (!empty($fec_835)) {$texto3 = $texto3."fec_835    = '$fec_835',"; }
if (empty($fec_835)) {pg_exec("update stzdetbol SET fec_835=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_836    = '$tit_836',";
if (!empty($fec_836)) {$texto3 = $texto3."fec_836    = '$fec_836',"; }
if (empty($fec_836)) {pg_exec("update stzdetbol SET fec_836=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_837    = '$tit_837',";
if (!empty($fec_837)) {$texto3 = $texto3."fec_837    = '$fec_837',"; }
if (empty($fec_837)) {pg_exec("update stzdetbol SET fec_837=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."tit_838    = '$tit_838',";
if (!empty($fec_838)) {$texto3 = $texto3."fec_838    = '$fec_838',"; }
if (empty($fec_838)) {pg_exec("update stzdetbol SET fec_838=NULL WHERE nro_boletin= '$nbol'"); }

//Colocado por Ing. Romulo Mendoza 23/10/2018 Asesoria Juridica - Patentes
$texto3=$texto3."ptit_800    = '$ptit_800',";
if (!empty($pfec_800)) {$texto3 = $texto3."pfec_800    = '$pfec_800',"; }
if (empty($pfec_800)) {pg_exec("update stzdetbol SET pfec_800=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_801    = '$ptit_801',";
if (!empty($pfec_801)) {$texto3 = $texto3."pfec_801    = '$pfec_801',"; }
if (empty($pfec_801)) {pg_exec("update stzdetbol SET pfec_801=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_802    = '$ptit_802',";
if (!empty($pfec_802)) {$texto3 = $texto3."pfec_802    = '$pfec_802',"; }
if (empty($pfec_802)) {pg_exec("update stzdetbol SET pfec_802=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_804    = '$ptit_804',";
if (!empty($pfec_804)) {$texto3 = $texto3."pfec_804    = '$pfec_804',"; }
if (empty($pfec_804)) {pg_exec("update stzdetbol SET pfec_804=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_805    = '$ptit_805',";
if (!empty($pfec_805)) {$texto3 = $texto3."pfec_805    = '$pfec_805',"; }
if (empty($pfec_805)) {pg_exec("update stzdetbol SET pfec_805=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_806    = '$ptit_806',";
if (!empty($pfec_806)) {$texto3 = $texto3."pfec_806    = '$pfec_806',"; }
if (empty($pfec_806)) {pg_exec("update stzdetbol SET pfec_806=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_809    = '$ptit_809',";
if (!empty($pfec_809)) {$texto3 = $texto3."pfec_809    = '$pfec_809',"; }
if (empty($pfec_809)) {pg_exec("update stzdetbol SET pfec_809=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_821    = '$ptit_821',";
if (!empty($pfec_821)) {$texto3 = $texto3."pfec_821    = '$pfec_821',"; }
if (empty($pfec_821)) {pg_exec("update stzdetbol SET pfec_821=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_833    = '$ptit_833',";
if (!empty($pfec_833)) {$texto3 = $texto3."pfec_833    = '$pfec_833',"; }
if (empty($pfec_833)) {pg_exec("update stzdetbol SET pfec_833=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_835    = '$ptit_835',";
if (!empty($pfec_835)) {$texto3 = $texto3."pfec_835    = '$pfec_835',"; }
if (empty($pfec_835)) {pg_exec("update stzdetbol SET pfec_835=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_836    = '$ptit_836',";
if (!empty($pfec_836)) {$texto3 = $texto3."pfec_836    = '$pfec_836',"; }
if (empty($pfec_836)) {pg_exec("update stzdetbol SET pfec_836=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_837    = '$ptit_837',";
if (!empty($pfec_837)) {$texto3 = $texto3."pfec_837    = '$pfec_837',"; }
if (empty($pfec_837)) {pg_exec("update stzdetbol SET pfec_837=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_838    = '$ptit_838',";
if (!empty($pfec_838)) {$texto3 = $texto3."pfec_838    = '$pfec_838',"; }
if (empty($pfec_838)) {pg_exec("update stzdetbol SET pfec_838=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_840    = '$ptit_840',";
if (!empty($pfec_840)) {$texto3 = $texto3."pfec_840    = '$pfec_840',"; }
if (empty($pfec_840)) {pg_exec("update stzdetbol SET pfec_840=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_921    = '$ptit_921',";
if (!empty($pfec_921)) {$texto3 = $texto3."pfec_921    = '$pfec_921',"; }
if (empty($pfec_921)) {pg_exec("update stzdetbol SET pfec_921=NULL WHERE nro_boletin= '$nbol'"); }
$texto3=$texto3."ptit_922    = '$ptit_922',";
if (!empty($pfec_922)) {$texto3 = $texto3."pfec_922    = '$pfec_922',"; }
if (empty($pfec_922)) {pg_exec("update stzdetbol SET pfec_922=NULL WHERE nro_boletin= '$nbol'"); }

//Colocado por Romulo Mendoza 16/04/2018 Patentes sin efecto x NO Pago de Derechos de Concesion
$texto3=$texto3."titp_derp    = '$titp_derp'";
if (!empty($fecp_derp)) {$texto3 = $texto3.",fecp_derp         = '$fecp_derp'";}
if (empty($fecp_derp)) {pg_exec("update stzdetbol SET fecp_derp=NULL WHERE nro_boletin= '$nbol'"); }

    //$texto3=$texto3.'"';
    $update_strd = $texto3;

    //echo " modi= $update_strd ";
    //exit();
    $act_detalle = $sql->update("$tbname_2","$update_strd","nro_boletin='$nbol'");

    // Verificacion y actualizacion real de los Datos en BD 
    if ($act_detalle AND $act_boletin)  {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$act_detalle)    { $error_detalle  = " - Detalle "; } 

      mensajenew("ERROR: Falla de Actualizaci&oacute;n de Datos en la BD $error_detalle  ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag1.tpl'); exit();
    }
    
    
    //Variable para la busqueda de la imagen en busqueda
    $ruta= "/apl/boletin/";
    $archivo = $_FILES['ubicacion']['name'];
    $vnewnombre="avisos";
    if (!empty($archivo)) {
       //Copiar archivo de avisos
       $max_size = 1; // the max. size for uploading	
       $my_upload = new file_upload;
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".pdf"); // specify the allowed extensions here
       $my_upload->max_length_filename = 250; // change this value to fit your field length in your database (standard 100)
       $my_upload->rename_file = true;
       $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
       $my_upload->the_file = $_FILES['ubicacion']['name'];
       $my_upload->http_error = $_FILES['ubicacion']['error'];
       $my_upload->validateExtension();
       if ($my_upload->upload($vnewnombre)) { 
	  echo '';		
       } 
       else {
	  //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); 
	  exit(); }
    }
    else {
     //  mensajenew('Achivo aun NO seleccionado ...!!!','javascript:history.back();','N');
     //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }
  }
  
  //Desconexion de la Base de Datos
  //$sql->disconnect();

  if ($accion=="I") { 
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","b_ingreso.php?vopc=3&nconex=$n_conex&salir=1&conx=0","S");}
  else {
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","b_ingreso.php?vopc=5&nconex=$n_conex&salir=1&conx=0","S"); }
  $smarty->display('pie_pag1.tpl'); exit();
   
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Boletin No.:');
$smarty->assign('campo2','Fecha de Publicaci&oacute;n:');
$smarty->assign('campo3','Fecha de Vencimiento:');
$smarty->assign('campo4','A&ntilde;os de Independencia:');
$smarty->assign('campo5','A&ntilde;os de Federaci&oacute;n:');
$smarty->assign('campo12','A&ntilde;os de Revoluci&oacute;n:');
$smarty->assign('campo6','Secciones de Bolet&iacute;n: Divisi&oacute;n Marcas /');
$smarty->assign('campo7','Secciones de Bolet&iacute;n: Divisi&oacute;n Patentes / ');
$smarty->assign('campo8','Indique las fechas de cada publicación y escriba los titulos adicionales de ser necesario ');
$smarty->assign('campo9','Resoluciones de Marcas y Patentes NO RATIFICADAS/ ');
$smarty->assign('campo10',' Busque el archivo escaneado con los avisos oficiales en pdf para subirlo a boletin');
$smarty->assign('campo11','Avisos Oficiales / ');
$smarty->assign('campot','Titulo:  ');
$smarty->assign('campof','Fecha:');

$smarty->assign('apli_inf',array(O,E));
$smarty->assign('apli_def',array('Ordinario','Extraordinario'));

$smarty->assign('vopc',$vopc);
$smarty->assign('nbol',$nbol);
$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
$smarty->assign('accion',$accion);
$smarty->assign('aplica',$tipobol);

$smarty->assign('fecha_pub',$fecha_pub);
//$smarty->assign('fecha_ven',$fecha_ven);
$smarty->assign('anoi',$anoi);
$smarty->assign('anof',$anof);
$smarty->assign('anor',$anor);

$smarty->assign('tit_soli',$tit_soli);
$smarty->assign('fec_soli',$fec_soli);
$smarty->assign('tit_orden',$tit_orden);
$smarty->assign('fec_orde',$fec_orde);
$smarty->assign('tit_conc',$tit_conc);
$smarty->assign('fec_conc',$fec_conc);
$smarty->assign('tit_devu',$tit_devu);  
$smarty->assign('fec_devu',$fec_devu);
$smarty->assign('tit_obse',$tit_obse);
$smarty->assign('fec_obse',$fec_obse);
$smarty->assign('tit_obse_scon',$tit_obse_scon);
$smarty->assign('fec_obse_scon',$fec_obse_scon);
$smarty->assign('tit_prio',$tit_prio);
$smarty->assign('fec_prio',$fec_prio);
$smarty->assign('tit_prio_exte',$tit_prio_exte);
$smarty->assign('fec_prio_exte',$fec_prio_exte);
$smarty->assign('tit_prio_defe',$tit_prio_defe);
$smarty->assign('fec_prio_defe',$fec_prio_defe);
$smarty->assign('tit_peri',$tit_peri);
$smarty->assign('fec_peri',$fec_peri);
$smarty->assign('tit_cadu',$tit_cadu);
$smarty->assign('fec_cadu',$fec_cadu); 
$smarty->assign('tit_desi',$tit_desi);
$smarty->assign('fec_desi',$fec_desi);
$smarty->assign('tit_desi_mejo',$tit_desi_mejo);  
$smarty->assign('fec_desi_mejo',$fec_desi_mejo);
$smarty->assign('tit_desi_ley',$tit_desi_ley);
$smarty->assign('fec_desi_ley',$fec_desi_ley);
$smarty->assign('tit_cadu_nren',$tit_cadu_nren);
$smarty->assign('fec_cadu_nren',$fec_cadu_nren);
$smarty->assign('tit_regi',$tit_regi);
$smarty->assign('fec_regi',$fec_regi);
$smarty->assign('tit_devu_scon',$tit_devu_scon);
$smarty->assign('fec_devu_scon',$fec_devu_scon);
$smarty->assign('tit_desi_anom',$tit_desi_anom);
$smarty->assign('fec_desi_anom',$fec_desi_anom);
$smarty->assign('tit_devo_regi',$tit_devo_regi);
$smarty->assign('fec_devo_regi',$fec_devo_regi);
$smarty->assign('tit_rein_devam',$tit_rein_devam);
$smarty->assign('fec_rein_devam',$fec_rein_devam);
$smarty->assign('tit_nega',$tit_nega);
$smarty->assign('fec_nega',$fec_nega);
$smarty->assign('tit_cert',$tit_cert);
$smarty->assign('fec_cert',$fec_cert);
$smarty->assign('tit_anot',$tit_anot);
$smarty->assign('fec_anot',$fec_anot);
$smarty->assign('titp_soli',$titp_soli);
$smarty->assign('fecp_soli',$fecp_soli);
$smarty->assign('titp_orden',$titp_orden);
$smarty->assign('fecp_orde',$fecp_orde);
$smarty->assign('titp_conc',$titp_conc);
$smarty->assign('fecp_conc',$fecp_conc);
$smarty->assign('titp_devu',$titp_devu);  
$smarty->assign('fecp_devu',$fecp_devu);
$smarty->assign('titp_prio',$titp_prio);
$smarty->assign('fecp_prio',$fecp_prio);
$smarty->assign('titp_prio_exte',$titp_prio_exte);
$smarty->assign('fecp_prio_exte',$fecp_prio_exte);
$smarty->assign('titp_prio_defe',$titp_prio_defe);
$smarty->assign('fecp_prio_defe',$fecp_prio_defe);
$smarty->assign('titp_peri',$titp_peri);
$smarty->assign('fecp_peri',$fecp_peri);
$smarty->assign('titp_dene',$titp_dene);
$smarty->assign('fecp_dene',$fecp_dene);
$smarty->assign('titp_desi',$titp_desi);
$smarty->assign('fecp_desi',$fecp_desi);
$smarty->assign('titp_aban',$titp_aban);
$smarty->assign('fecp_aban',$fecp_aban); 
$smarty->assign('titp_nega',$titp_nega);
$smarty->assign('fecp_nega',$fecp_nega);
$smarty->assign('titp_opos',$titp_opos);  
$smarty->assign('fecp_opos',$fecp_opos);
$smarty->assign('titp_reha',$titp_reha);
$smarty->assign('fecp_reha',$fecp_reha);
$smarty->assign('titp_titu',$titp_titu);
$smarty->assign('fecp_titu',$fecp_titu);
//Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto
$smarty->assign('titp_sefp',$titp_sefp);
$smarty->assign('fecp_sefp',$fecp_sefp);
$smarty->assign('titp_sevt',$titp_sevt);
$smarty->assign('fecp_sevt',$fecp_sevt);
//Colocado por Romulo Mendoza 07/03/2012 Devueltas por fondo 
$smarty->assign('tit_fondo',$tit_fondo);  
$smarty->assign('fec_fondo',$fec_fondo);

$smarty->assign('tit_desi_obse',$tit_desi_obse);
$smarty->assign('fec_desi_obse',$fec_desi_obse);
$smarty->assign('tit_noti',$tit_noti);
$smarty->assign('fec_noti',$fec_noti);

//Colocado por Romulo Mendoza 16/04/2018 Patentes sin efecto x NO Pago de Derechos de Concesion
$smarty->assign('titp_derp',$titp_derp);
$smarty->assign('fecp_derp',$fecp_derp);

//Colocado por Ing. Romulo Mendoza 25/09/2018 Recursos - Asesoría Jurídica - Marcas 
$smarty->assign('tit_800',$tit_800);  
$smarty->assign('fec_800',$fec_800);
$smarty->assign('tit_801',$tit_801);  
$smarty->assign('fec_801',$fec_801);
$smarty->assign('tit_802',$tit_802);  
$smarty->assign('fec_802',$fec_802);
$smarty->assign('tit_803',$tit_803);  
$smarty->assign('fec_803',$fec_803);
$smarty->assign('tit_804',$tit_804);  
$smarty->assign('fec_804',$fec_804);
$smarty->assign('tit_805',$tit_805);  
$smarty->assign('fec_805',$fec_805);
$smarty->assign('tit_806',$tit_806); 
$smarty->assign('fec_806',$fec_806);
$smarty->assign('tit_807',$tit_807);  
$smarty->assign('fec_807',$fec_807);
$smarty->assign('tit_808',$tit_808);  
$smarty->assign('fec_808',$fec_808);
$smarty->assign('tit_809',$tit_809);  
$smarty->assign('fec_809',$fec_809);
$smarty->assign('tit_821',$tit_821);  
$smarty->assign('fec_821',$fec_821);
$smarty->assign('tit_822',$tit_822);  
$smarty->assign('fec_822',$fec_822);
$smarty->assign('tit_823',$tit_823);  
$smarty->assign('fec_823',$fec_823);
$smarty->assign('tit_824',$tit_824);  
$smarty->assign('fec_824',$fec_824);
$smarty->assign('tit_825',$tit_825);  
$smarty->assign('fec_825',$fec_825);
$smarty->assign('tit_830',$tit_830);  
$smarty->assign('fec_830',$fec_830);
$smarty->assign('tit_831',$tit_831);  
$smarty->assign('fec_831',$fec_831);
$smarty->assign('tit_833',$tit_833);  
$smarty->assign('fec_833',$fec_833);
$smarty->assign('tit_835',$tit_835);  
$smarty->assign('fec_835',$fec_835);
$smarty->assign('tit_836',$tit_836);  
$smarty->assign('fec_836',$fec_836);
$smarty->assign('tit_837',$tit_837);  
$smarty->assign('fec_837',$fec_837);
$smarty->assign('tit_838',$tit_838);  
$smarty->assign('fec_838',$fec_838);

//Colocado por Ing. Romulo Mendoza 24/10/2018 Recursos - Asesoría Jurídica - Patentes 
$smarty->assign('ptit_800',$ptit_800);  
$smarty->assign('pfec_800',$pfec_800);
$smarty->assign('ptit_801',$ptit_801);  
$smarty->assign('pfec_801',$pfec_801);
$smarty->assign('ptit_802',$ptit_802);  
$smarty->assign('pfec_802',$pfec_802);
$smarty->assign('ptit_804',$ptit_804);  
$smarty->assign('pfec_804',$pfec_804);
$smarty->assign('ptit_805',$ptit_805);  
$smarty->assign('pfec_805',$pfec_805);
$smarty->assign('ptit_806',$ptit_806);  
$smarty->assign('pfec_806',$pfec_806);
$smarty->assign('ptit_809',$ptit_809);  
$smarty->assign('pfec_809',$pfec_809);
$smarty->assign('ptit_821',$ptit_821);  
$smarty->assign('pfec_821',$pfec_821);
$smarty->assign('ptit_833',$ptit_833);  
$smarty->assign('pfec_833',$pfec_833);
$smarty->assign('ptit_835',$ptit_835);  
$smarty->assign('pfec_835',$pfec_835);
$smarty->assign('ptit_836',$ptit_836);  
$smarty->assign('pfec_836',$pfec_836);
$smarty->assign('ptit_837',$ptit_837);  
$smarty->assign('pfec_837',$pfec_837);
$smarty->assign('ptit_838',$ptit_838);  
$smarty->assign('pfec_838',$pfec_838);
$smarty->assign('ptit_840',$ptit_840);  
$smarty->assign('pfec_840',$pfec_840);
$smarty->assign('ptit_921',$ptit_921);  
$smarty->assign('pfec_921',$pfec_921);
$smarty->assign('ptit_922',$ptit_922);  
$smarty->assign('pfec_922',$pfec_922);

$smarty->display('b_ingreso.tpl');
$smarty->display('pie_pag1.tpl');
?>
