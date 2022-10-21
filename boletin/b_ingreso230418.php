<script language="JavaScript">
function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: b_ingreso.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "b_ingreso.php";

// Definicion de Tablas 
$tbname_1 = "stzboletin";
$tbname_2 = "stzdetbol";

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$nbol          =$_POST['nbol'];
//$vder          =$_POST['vder'];
$accion        =$_POST['accion'];

$fecha_pub     =$_POST['fecha_pub'];
//$fecha_ven     =$_POST['fecha_ven'];
$anoi	       =$_POST['anoi'];
$anof          =$_POST['anof'];
$anor          =$_POST['anor'];

//marcas
$tit_soli   =$_POST['tit_soli'];
$fec_soli   =$_POST['fec_soli'];
$tit_orden  =$_POST['tit_orden'];
$fec_orde   =$_POST['fec_orde'];
$tit_conc   =$_POST['tit_conc'];
$fec_conc   =$_POST['fec_conc'];
$tit_devu   =$_POST['tit_devu'];  
$fec_devu   =$_POST['fec_devu'];
$tit_obse   =$_POST['tit_obse'];
$fec_obse   =$_POST['fec_obse'];
$tit_obse_scon =$_POST['tit_obse_scon'];
$fec_obse_scon =$_POST['fec_obse_scon'];
$tit_prio      =$_POST['tit_prio'];
$fec_prio      =$_POST['fec_prio'];
$tit_prio_exte =$_POST['tit_prio_exte'];
$fec_prio_exte =$_POST['fec_prio_exte'];
$tit_prio_defe =$_POST['tit_prio_defe'];
$fec_prio_defe =$_POST['fec_prio_defe'];
$tit_peri      =$_POST['tit_peri'];
$fec_peri      =$_POST['fec_peri'];
$tit_cadu      =$_POST['tit_cadu'];
$fec_cadu      =$_POST['fec_cadu']; 
$tit_desi      =$_POST['tit_desi'];
$fec_desi      =$_POST['fec_desi'];
$tit_desi_mejo =$_POST['tit_desi_mejo'];  
$fec_desi_mejo =$_POST['fec_desi_mejo'];
$tit_desi_ley  =$_POST['tit_desi_ley'];
$fec_desi_ley  =$_POST['fec_desi_ley'];
$tit_cadu_nren =$_POST['tit_cadu_nren'];
$fec_cadu_nren =$_POST['fec_cadu_nren'];
$tit_regi      =$_POST['tit_regi'];
$fec_regi      =$_POST['fec_regi'];
$tit_devu_scon =$_POST['tit_devu_scon'];
$fec_devu_scon =$_POST['fec_devu_scon'];
$tit_desi_anom =$_POST['tit_desi_anom'];
$fec_desi_anom =$_POST['fec_desi_anom'];
$tit_devo_regi =$_POST['tit_devo_regi'];
$fec_devo_regi =$_POST['fec_devo_regi'];
$tit_rein_devam =$_POST['tit_rein_devam'];
$fec_rein_devam =$_POST['fec_rein_devam']; 
$tit_nega      =$_POST['tit_nega'];
$fec_nega      =$_POST['fec_nega'];
$tit_cert      =$_POST['tit_cert'];
$fec_cert      =$_POST['fec_cert'];
$tit_anot      =$_POST['tit_anot'];
$fec_anot      =$_POST['fec_anot'];
$tit_noti      =$_POST['tit_noti'];
$fec_noti      =$_POST['fec_noti'];
$tit_desi_obse  =$_POST['tit_desi_obse'];
$fec_desi_obse  =$_POST['fec_desi_obse'];
//Colocado por Romulo Mendoza 07/03/2012 Devueltas por fondo
$tit_fondo   =$_POST['tit_fondo'];  
$fec_fondo   =$_POST['fec_fondo']; 

//patentes
$titp_soli     =$_POST['titp_soli'];
$fecp_soli     =$_POST['fecp_soli'];
$titp_orden    =$_POST['titp_orden'];
$fecp_orde     =$_POST['fecp_orde'];
$titp_conc     =$_POST['titp_conc'];
$fecp_conc     =$_POST['fecp_conc'];
$titp_devu     =$_POST['titp_devu'];  
$fecp_devu     =$_POST['fecp_devu'];
$titp_prio     =$_POST['titp_prio'];
$fecp_prio     =$_POST['fecp_prio'];
$titp_prio_exte   =$_POST['titp_prio_exte'];
$fecp_prio_exte   =$_POST['fecp_prio_exte'];
$titp_prio_defe   =$_POST['titp_prio_defe'];
$fecp_prio_defe   =$_POST['fecp_prio_defe'];
$titp_peri        =$_POST['titp_peri'];
$fecp_peri        =$_POST['fecp_peri'];
$titp_dene        =$_POST['titp_dene'];
$fecp_dene        =$_POST['fecp_dene'];
$titp_desi        =$_POST['titp_desi'];
$fecp_desi        =$_POST['fecp_desi'];
$titp_aban        =$_POST['titp_aban'];
$fecp_aban        =$_POST['fecp_aban']; 
$titp_nega        =$_POST['titp_nega'];
$fecp_nega        =$_POST['fecp_nega'];
$titp_opos        =$_POST['titp_opos'];  
$fecp_opos        =$_POST['fecp_opos'];
$titp_reha        =$_POST['titp_reha'];
$fecp_reha        =$_POST['fecp_reha'];
$titp_titu        =$_POST['titp_titu'];
$fecp_titu        =$_POST['fecp_titu'];
//Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto   
$titp_sefp        =$_POST['titp_sefp'];
$fecp_sefp        =$_POST['fecp_sefp'];
$titp_sevt        =$_POST['titp_sevt'];
$fecp_sevt        =$_POST['fecp_sevt'];

//Avisos Oficiales
$ubicacion=$_POST['ubicacion'];

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
//Colocado por Romulo Mendoza 07/03/2012 Devueltas por fondo   
$texto=$texto.'tit_fondo';
$texto1=$texto1."'$tit_fondo'";
if (!empty($fec_fondo)) {$texto = $texto.'fec_fondo,';  $texto1 = $texto1."'$fec_fondo',";}

// ************************************************************************************
$smarty->assign('titulo',$substbol);
$smarty->assign('subtitulo','Boletín de la Propiedad Industrial');
if ($vopc==3 || $vopc==4) {
  $smarty->assign('subtitulo','Ingreso de Boletin '); }
if ($vopc==5 || $vopc==6) {
  $smarty->assign('subtitulo','Modificaci&oacute;n de Boletín'); } 

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


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

  if (empty($nbol)) {
    mensajenew("No introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 

  $res_boletin = pg_exec("select * from $tbname_1 where nro_boletin='$nbol'");
  $nfil = pg_numrows($res_boletin);
  if ($nfil>0) {
   mensajenew("Número de Boletín $nbol ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
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
  if (empty($nbol)) {
    mensajenew("No introdujo ningún número de Boletín ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 

  // Obtencion de los datos del boletín 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_boletin='$nbol' ");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    
    $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);

  if ($filas_found==0) {
    mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); } 
  $objs = $sql->objects('',$obj_query);
	$fecha_pub     = $objs->fecha_pub;
	//$fecha_ven     = $objs->fecha_ven;
	$anoi	       = $objs->anoi;
	$anof        = $objs->anof;
	$anor        = $objs->anor;
    
  //Obtencion de detalle del boletin
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_boletin='$nbol'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found > 0) {

    $objs = $sql->objects('',$obj_query);
	//marcas
	$tit_soli   = trim($objs->tit_soli);
	$fec_soli   = trim($objs->fec_soli);
	$tit_orden  = trim($objs->tit_orden);
	$fec_orde   = trim($objs->fec_orde);
	$tit_conc   = trim($objs->tit_conc);
	$fec_conc   = trim($objs->fec_conc);
	$tit_devu   = trim($objs->tit_devu);  
	$fec_devu   = trim($objs->fec_devu);
	$tit_obse   = trim($objs->tit_obse);
	$fec_obse   = trim($objs->fec_obse);
	$tit_obse_scon = trim($objs->tit_obse_scon);
	$fec_obse_scon = trim($objs->fec_obse_scon);
	$tit_prio      = trim($objs->tit_prio);
	$fec_prio      = trim($objs->fec_prio);
	$tit_prio_exte = trim($objs->tit_prio_exte);
	$fec_prio_exte = trim($objs->fec_prio_exte);
	$tit_prio_defe = trim($objs->tit_prio_defe);
	$fec_prio_defe = trim($objs->fec_prio_defe);
	$tit_peri      = trim($objs->tit_peri);
	$fec_peri      = trim($objs->fec_peri);
	$tit_cadu      = trim($objs->tit_cadu);
	$fec_cadu      = trim($objs->fec_cadu); 
	$tit_desi      = trim($objs->tit_desi);
	$fec_desi      = trim($objs->fec_desi);
	$tit_desi_mejo = trim($objs->tit_desi_mejo);  
	$fec_desi_mejo = trim($objs->fec_desi_mejo);
	$tit_desi_ley  = trim($objs->tit_desi_ley);
	$fec_desi_ley  = trim($objs->fec_desi_ley);
	$tit_cadu_nren = trim($objs->tit_cadu_nren);
	$fec_cadu_nren = trim($objs->fec_cadu_nren);
	$tit_regi      = trim($objs->tit_regi);
	$fec_regi      = trim($objs->fec_regi);
	$tit_devu_scon = trim($objs->tit_devu_scon);
	$fec_devu_scon = trim($objs->fec_devu_scon);
	$tit_desi_anom = trim($objs->tit_desi_anom);
	$fec_desi_anom = trim($objs->fec_desi_anom);
	$tit_devo_regi = trim($objs->tit_devo_regi);
	$fec_devo_regi = trim($objs->fec_devo_regi);
	$tit_rein_devam = trim($objs->tit_rein_devam);
	$fec_rein_devam = trim($objs->fec_rein_devam);
	$tit_nega      = trim($objs->tit_nega);
	$fec_nega      = trim($objs->fec_nega);
	$tit_cert      = trim($objs->tit_cert);
	$fec_cert      = trim($objs->fec_cert);
	$tit_anot      = trim($objs->tit_anot);
	$fec_anot      = trim($objs->fec_anot);
	
	$tit_desi_obse  = trim($objs->tit_desi_obse);
	$fec_desi_obse  = trim($objs->fec_desi_obse);
	$tit_noti      = trim($objs->tit_noti);
	$fec_noti      = trim($objs->fec_noti);
	$tit_fondo   = trim($objs->tit_fondo);  
	$fec_fondo   = trim($objs->fec_fondo); 

	//patentes
	$titp_soli     = trim($objs->titp_soli);
	$fecp_soli     = trim($objs->fecp_soli);
	$titp_orden    = trim($objs->titp_orden);
	$fecp_orde     = trim($objs->fecp_orde);
	$titp_conc     = trim($objs->titp_conc);
	$fecp_conc     = trim($objs->fecp_conc);
	$titp_devu     = trim($objs->titp_devu);  
	$fecp_devu     = trim($objs->fecp_devu);
	$titp_prio     = trim($objs->titp_prio);
	$fecp_prio     = trim($objs->fecp_prio);
	$titp_prio_exte   = trim($objs->titp_prio_exte);
	$fecp_prio_exte   = trim($objs->fecp_prio_exte);
	$titp_prio_defe   = trim($objs->titp_prio_defe);
	$fecp_prio_defe   = trim($objs->fecp_prio_defe);
	$titp_peri        = trim($objs->titp_peri);
	$fecp_peri        = trim($objs->fecp_peri);
	$titp_dene        = trim($objs->titp_dene);
	$fecp_dene        = trim($objs->fecp_dene);
	$titp_desi        = trim($objs->titp_desi);
	$fecp_desi        = trim($objs->fecp_desi);
	$titp_aban        = trim($objs->titp_aban);
	$fecp_aban        = trim($objs->fecp_aban); 
	$titp_nega        = trim($objs->titp_nega);
	$fecp_nega        = trim($objs->fecp_nega);
	$titp_opos        = trim($objs->titp_opos);  
	$fecp_opos        = trim($objs->fecp_opos);
	$titp_reha        = trim($objs->titp_reha);
	$fecp_reha        = trim($objs->fecp_reha);
	$titp_titu        = trim($objs->titp_titu);
	$fecp_titu        = trim($objs->fecp_titu);
   //Colocado por Romulo Mendoza 19/09/2011 Patentes sin efecto
   $titp_sefp        = trim($objs->titp_sefp);
   $fecp_sefp        = trim($objs->fecp_sefp); 
   $titp_sevt        = trim($objs->titp_sevt);
   $fecp_sevt        = trim($objs->fecp_sevt);}
   
  $valores_fields = array($fecha_pub, $anoi, $anof,$tit_soli,$fec_soli, $tit_orden,$fec_orde, $tit_conc, $fec_conc, $tit_devu, $fec_devu, $tit_obse, $fec_obse, $tit_obse_scon, $fec_obse_scon, $tit_prio, $fec_prio, $tit_prio_exte, $fec_prio_exte, $tit_prio_defe, $fec_prio_defe, $tit_peri, $fec_peri,$tit_cadu, $fec_cadu, $tit_desi, $fec_desi, $tit_desi_mejo, $fec_desi_mejo,$tit_desi_ley, $fec_desi_ley,  $tit_cadu_nren, $fec_cadu_nren, $tit_regi, $fec_regi,  $tit_devu_scon, $fec_devu_scon,  $tit_desi_anom, $fec_desi_anom, $tit_devo_regi,$fec_devo_regi,$tit_rein_devam, $fec_rein_devam,$tit_nega, $fec_nega, $tit_cert, $fec_cert,  $tit_anot,$fec_anot, $tit_desi_obse,$fec_desi_obse, $tit_noti,$fec_noti, $titp_soli, $fecp_soli,$titp_orden, $fecp_orde, $titp_conc, $fecp_conc, $titp_devu, $fecp_devu, $titp_prio, $fecp_prio, $titp_prio_exte, $fecp_prio_exte, $titp_prio_defe,$fecp_prio_defe, $titp_peri, $fecp_peri, $titp_dene, $fecp_dene,  $titp_desi, $fecp_desi,$titp_aban, $fecp_aban, $titp_nega, $fecp_nega,$titp_opos, $fecp_opos, $titp_reha, $fecp_reha, $titp_titu, $fecp_titu, $titp_sefp, $fecp_sefp, $titp_sevt, $fecp_sevt, $tit_fondo, $fec_fondo);

  $campos = "fecha_pub |anoi |anof |anor |tit_soli |fec_soli |tit_orden|fec_orde |tit_conc |fec_conc |tit_devu |fec_devu |tit_obse |fec_obse |tit_obse_scon |fec_obse_scon |tit_prio |fec_prio |tit_prio_exte |fec_prio_exte |tit_prio_defe |fec_prio_defe |tit_peri |fec_peri |tit_cadu |fec_cadu |tit_desi |fec_desi |tit_desi_mejo |fec_desi_mejo|tit_desi_ley |fec_desi_ley |tit_cadu_nren |fec_cadu_nren|tit_regi |fec_regi |tit_devu_scon |fec_devu_scon |tit_desi_anom |fec_desi_anom |tit_devo_regi|fec_devo_regi |tit_rein_devam |fec_rein_devam |tit_nega |fec_nega |tit_cert |fec_cert |tit_anot|fec_anot |tit_desi_obse|fec_desi_obse|  tit_noti|fec_noti |titp_soli |fecp_soli|titp_orden |fecp_orde |titp_conc |fecp_conc |titp_devu |fecp_devu|titp_prio |fecp_prio|titp_prio_exte |fecp_prio_exte |titp_prio_defe|fecp_prio_defe |titp_peri |fecp_peri |titp_dene |fecp_dene |titp_desi |fecp_desi|titp_aban |fecp_aban |titp_nega |fecp_nega |titp_opos |fecp_opos |titp_reha |fecp_reha |titp_titu |fecp_titu|titp_sefp |fecp_sefp |titp_sevt |fecp_sevt |tit_fondo |fec_fondo";
  $smarty->assign('string',$string);
   
  $smarty->assign('campos',$campos);
  $smarty->assign('modo','disabled'); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==6  


// ************************************************************************************ 
//Opcion Grabar...
if ($vopc==2) {
  $n_conex = $_POST['nconex'];
  // La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= hora();

  // Comparación de la fecha de Solicitud
  $esmayor=compara_fechas($fecha_pub,$fechahoy);
  if ($esmayor==0) {
    mensajenew("La Fecha de Publicación No puede ser menor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); }

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
      mensajenew("Número de Boletín $nbol ya existe en la Base de Datos ...!!!","b_ingreso.php?vopc=3","N");
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
    $col_campos = "nro_boletin,fecha_pub,fecha_gen, hora_gen, anoi, anof, anor, resoluci,usuario,generado";
    $insert_str = "'$nbol','$fecha_pub','$fechahoy','$horactual','$anoi','$anof','$anor' ,'$resoluci','$usuario','N'";
    $ins_boletin = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Detalle del Boletin 
    $col_camposd = $texto;

    $insert_strd = $texto1;
    $ins_detalle = $sql->insert("$tbname_2","$col_camposd","$insert_strd","");

    if ($ins_boletin AND $ins_detalle) {
      pg_exec("COMMIT WORK"); }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$ins_boletin) { $error_boletin  = " - Boletin "; }
      if (!$ins_detalle) { $error_detalle  = " - Detalle "; }

      Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_boletin $error_detalle ...!!!","javascript:history.back();","N");
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
$texto3=$texto3."tit_fondo    = '$tit_fondo'";
if (!empty($fec_fondo)) {$texto3 = $texto3.",fec_fondo    = '$fec_fondo'"; }
if (empty($fec_fondo)) {pg_exec("update stzdetbol SET fec_fondo=NULL WHERE nro_boletin= '$nbol'"); }

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

      mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_detalle  ...!!!","javascript:history.back();","N");
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
$smarty->assign('campo9','Resoluciones de Marcas y Patentes / ');
$smarty->assign('campo10',' Busque el archivo escaneado con los avisos oficiales en pdf para subirlo a boletin');
$smarty->assign('campo11','Avisos Oficiales / ');
$smarty->assign('campot','Titulo:  ');
$smarty->assign('campof','Fecha:');

$smarty->assign('vopc',$vopc);
$smarty->assign('nbol',$nbol);
$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
$smarty->assign('accion',$accion);

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

$smarty->display('b_ingreso.tpl');
$smarty->display('pie_pag1.tpl');
?>
