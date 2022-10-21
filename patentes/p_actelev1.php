<?php
// *************************************************************************************
// Programa: p_actelev1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$tbname_1 = "stppatee";
$tbname_2 = "stzstder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzottid";
$tbname_5 = "stzsolic";
$tbname_6 = "stzderec";

$sql     = new mod_db();
$fecha   = fechahoy();
$login   = $_SESSION['usuario_login'];

//Validacion de Entrada
$vopc  = $_GET['vopc'];
$vsol1 = $_POST["vsol1"];
$vsol2 = $_POST["vsol2"];
$vreg1 = $_POST["vreg1"];
$vreg2 = $_POST["vreg2"];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Patentes');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
      mensajenew("AVISO: No introdujo ning&uacute;n valor de Expediente ...!!!","p_actelev.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}
if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2)) {
      mensajenew("AVISO: No introdujo ning&uacute;n valor de Expediente ...!!!","p_actelev.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}

//Verificando conexion
$sql->connection($login);

//Armado de Numero de Expediente
if ($vopc==1) {
  $varsol=$vsol1."-".$vsol2;
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='P'"); }
if ($vopc==2) {
  $vreg='';
  if (!empty($vreg1) && !empty($vreg2)) {
    $vreg = $vreg1.$vreg2; }
    $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$vreg' AND registro!='' AND tipo_mp='P'"); }

if (!$resultado) { 
     mensajenew("Nro. de Expediente ingresado NO existe en la Base de Datos ...!!!","p_actelev.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     mensajenew("No existen Datos asociados al Expediente en Maestra de Marcas ...!!!","p_actelev.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
$reg = pg_fetch_array($resultado);

if ($reg['tipo_derecho']=='A') {$vtipo_paten='INVENCION';}
if ($reg['tipo_derecho']=='B') {$vtipo_paten='DIBUJO INDUSTRIAL';}
if ($reg['tipo_derecho']=='C') {$vtipo_paten='DE MEJORA';}
if ($reg['tipo_derecho']=='D') {$vtipo_paten='DE INTRODUCCION';}
if ($reg['tipo_derecho']=='E') {$vtipo_paten='MODELO INDUSTRIAL';}
if ($reg['tipo_derecho']=='F') {$vtipo_paten='MODELO DE UTILIDAD';}
if ($reg['tipo_derecho']=='G') {$vtipo_paten='DISEÑO INDUSTRIAL';}

$vder    = $reg['nro_derecho']; 
$varsol  = $reg['solicitud'];
$nombre  = $reg['nombre'];
$tipo_paten = $reg['tipo_derecho'];
$estatus = $reg['estatus'];
$fecha_solic = $reg['fecha_solic'];
$fecha_venci = $reg['fecha_venc'];
$vreg    = $reg['registro'];
$fecha_regis = $reg['fecha_regis'];
$fecha_publi = $reg['fecha_publi'];
$tramitante  = $reg['tramitante'];
$poder   = $reg['poder'];
$agente  = $reg['agente'];
$dirano  = substr($varsol,-11,4);
$vexp    = $dirano."-".substr($varsol,-6,6);
$numero  = substr($varsol,-6,6);
$vsol    = $varsol;
$nameimage   = ver_imagen($vsol1,$vsol2,'P');

// Obtencion del Nombre del Agente  
$nbagente = agente_tram($agente,$tramitante,1);
if ($agente > 0) { $tramitante = $nbagente; }

//Obtención de la Descripción del Estatus 
$descripcion = estatus($estatus);

//Obtención de los Eventos de la Solicitud de Patentes
$obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder' ORDER BY fecha_event"); 
if (!$obj_query) { 
  Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
$filas_found=$sql->nums('',$obj_query);
$totalevm=$filas_found;
if ($filas_found==0) {
  mensajenew("No existen Eventos de Tramite para la Solicitud ...!!!","index.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
} 

$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arrayevento[$cont]=$objs->secuencial;
    $arraydescri[$cont]=sprintf("%03d",$objs->evento-2000)."&nbsp;&nbsp;&nbsp;".$objs->fecha_event."&nbsp;&nbsp;&nbsp;".$objs->fecha_trans."&nbsp;&nbsp;&nbsp;".sprintf("%08d",$objs->secuencial)."&nbsp;&nbsp;&nbsp;&nbsp;".sprintf("%03d",$objs->estat_ant-2000)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".substr(trim($objs->comentario),0,65);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención del(los) Titular(es) de la Solicitud de Patentes
$obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad 
                          FROM stzottid a,stzsolic b 
                          WHERE (a.titular=b.titular) AND a.nro_derecho='$vder'");

if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla Stpottid o Stztitur...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
$filas_found=$sql->nums('',$obj_query);
$totalevm=$filas_found;
if ($filas_found==0) {
  mensajenew("No existen Titular(es) para la Solicitud ...!!!","index.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
} 
$cont = 0;
$objs = $sql->objects('',$obj_query);
$titular=$objs->titular; 
$tnombre=trim($objs->nombre);
$tdomicilio=trim($objs->domicilio);
$pais=$objs->nacionalidad;
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arraytitular[$cont]=$objs->titular;
    $espacios=39-strlen(trim(substr($objs->nombre,0,39)));
    $nombretit=str_pad(trim(substr($objs->nombre,0,39)),39,"*");
    $direccion=$objs->domicilio." - / - ".$objs->nacionalidad;
    $arraynombre[$cont]=sprintf("%06d",$objs->titular)."&nbsp;&nbsp;&nbsp;".$nombretit."&nbsp;&nbsp;&nbsp;".$direccion."&nbsp";
    $objs = $sql->objects('',$obj_query);
  }

//Desconexion de la BD 
$sql->disconnect();

$smarty->assign('vder',$vder);
$smarty->assign('vopc',$vopc); 
$smarty->assign('anno',$dirano);
$smarty->assign('numero',$numero);
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venci',$fecha_venci);
$smarty->assign('fecha_publi',$fecha_publi);
$smarty->assign('fecha_regis',$fecha_regis);
$smarty->assign('tipo_paten',$tipo_paten);
$smarty->assign('vtipo_paten',$vtipo_paten);
$smarty->assign('estatus',$estatus-2000);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('registro',$vreg);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('tramitante',$tramitante);
$smarty->assign('poder',$poder);
$smarty->assign('agente',$agente);
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('secuencial',0);
$smarty->assign('arraytitular',$arraytitular);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('titular',$titular);
$smarty->assign('tnombre',$tnombre);
$smarty->assign('tdomicilio',$tdomicilio);
$smarty->assign('tpais_resid',$pais); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Registro:');
$smarty->assign('campo7','Fecha Registro:');
$smarty->assign('campo8','Fecha Vencimiento:');
$smarty->assign('campo9','Fecha Publicacion:');
$smarty->assign('campo10','Poder:');
$smarty->assign('campo11','Agente:');
$smarty->assign('campo12','Tramitante:');

$smarty->display('p_actelev1.tpl');
$smarty->display('pie_pag.tpl');
?>
