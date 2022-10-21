<?php
// *************************************************************************************
// Programa: m_actelev1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// *************************************************************************************
 
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$tbname_1 = "stmmarce";
$tbname_2 = "stzstder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzottid";
$tbname_5 = "stzsolic";
$tbname_6 = "stzderec";

$sql     = new mod_db();
$fecha   = fechahoy();
$login = $_SESSION['usuario_login'];

//Validacion de Entrada
$vopc  = $_GET['vopc'];
$vsol1=$_POST["vsol1"];
$vsol2=$_POST["vsol2"];
$vreg1=$_POST["vreg1"];
$vreg2=$_POST["vreg2"];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Marcas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($login);

$statusbd = Edo_bd();
if ($statusbd=="2") {
   mensajenew("Base de Datos en Mantenimiento, comunicarse con el Administrador del Sistema ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","m_actelev.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}
if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","m_actelev.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}

//Armado de Numero de Expediente
if ($vopc==1) {
  $varsol=$vsol1."-".$vsol2;
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='M'"); }
if ($vopc==2) {
  $vreg='';
  if (!empty($vreg1) && !empty($vreg2)) {
    $vreg = trim($vreg1.$vreg2); }
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$vreg' AND registro!='' AND tipo_mp='M'"); }

if (!$resultado) { 
     mensajenew("Nro. de Expediente ingresado NO existe en la Base de Datos ...!!!","m_actelev.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     mensajenew("No existen Datos asociados al Expediente en Maestra de Marcas ...!!!","m_actelev.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
$reg = pg_fetch_array($resultado);

if ($reg['tipo_derecho']=='M') {$vtipo_marca='MARCA DE PRODUCTO';}
if ($reg['tipo_derecho']=='C') {$vtipo_marca='MARCA COLECTIVA';}
if ($reg['tipo_derecho']=='L') {$vtipo_marca='LEMA COMERCIAL';}
if ($reg['tipo_derecho']=='N') {$vtipo_marca='NOMBRE COMERCIAL';}
if ($reg['tipo_derecho']=='S') {$vtipo_marca='MARCA DE SERVICIO';}
if ($reg['tipo_derecho']=='D') {$vtipo_marca='DENOMINACION DE ORIGEN';}

$varsol = $reg['solicitud'];
$vder   = $reg['nro_derecho'];
$nombre = $reg['nombre'];
$tipo_marca  = $reg['tipo_derecho'];
$fecha_solic = $reg['fecha_solic'];
$fecha_publi = $reg['fecha_publi'];
$fecha_venci = $reg['fecha_venc'];
$fecha_regis = $reg['fecha_regis'];
$estatus = $reg['estatus'];
$vreg    = $reg['registro'];
$tramitante = $reg['tramitante'];
$poder   = $reg['poder'];
$agente  = $reg['agente'];

// Obtencion del Nombre del Agente  
$nbagente = agente_tram($agente,$tramitante,1);

if ($agente > 0) { $tramitante = $nbagente; }
 
//Obtención de datos de la Marca 
$obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
$objs = $sql->objects('',$obj_query);
$modalidad   = $objs->modalidad;
$clase       = $objs->clase;
$ind_claseni = $objs->ind_claseni;

$dirano=substr($varsol,-11,4);
$vexp=$dirano."-".substr($varsol,-6,6);
$numero=substr($varsol,-6,6);
$vsol=$varsol;

if ($modalidad=='D') { $tmodalidad='DENOMINATIVA'; }

switch ($modalidad) {
   case "G":
      $tmodalidad='GRAFICA';
      break;
   case "M":
      $tmodalidad='MIXTA';
      break;
}

if ($modalidad=="D") {
  $nameimage  = "../imagenes/sin_imagen.jpg"; }
  else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

if (!file_exists($nameimage)) {
   $nameimage="../imagenes/sin_imagen.jpg"; }
$smarty->assign('ubicacion',$nameimage);

// Obtencion de la Descripcion del Estatus
$descripcion='';
$descripcion = estatus($estatus);

//Obtención de los Eventos de la Solicitud de Marcas
$obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder' ORDER BY fecha_event,secuencial");
if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
$filas_found=$sql->nums('',$obj_query);
$totalevm=$filas_found;
if ($filas_found==0) {
  Mensajenew("No existen Eventos de Tramite para la Solicitud ...!!!","m_actelev.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
} 

$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arrayevento[$cont]=$objs->secuencial;
    $arraydescri[$cont]=sprintf("%03d",$objs->evento-1000)."&nbsp;&nbsp;&nbsp;".$objs->fecha_event."&nbsp;&nbsp;&nbsp;".$objs->fecha_trans."&nbsp;&nbsp;&nbsp;".sprintf("%08d",$objs->secuencial)."&nbsp;&nbsp;&nbsp;&nbsp;".sprintf("%03d",$objs->estat_ant-1000)."&nbsp;&nbsp;&nbsp;".str_pad(trim($objs->documento),10,"=",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".substr(trim($objs->comentario),0,65);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención del(los) Titular(es) de la Solicitud de Marcas
$obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad,c.nombre as nombrep
                          FROM stzottid a,stzsolic b,stzpaisr c 
                          WHERE a.nro_derecho ='$vder' AND  
                                a.titular=b.titular AND 
                                a.nacionalidad=c.pais");
if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla Stzottid o Stzsolic o Stzpaisr ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found = $sql->nums('',$obj_query);
$totalevm = $filas_found;
if ($filas_found==0) {
  Mensajenew("No existen Titular(es) para la Solicitud ...!!!","m_actelev.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

$cont = 0;
$objs = $sql->objects('',$obj_query);
$titular=$objs->titular; 
$tnombre=trim($objs->nombre);
$tdomicilio=trim($objs->domicilio);
$pais=$objs->pais_resid;
for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraytitular[$cont]=$objs->titular;
    $espacios=39-strlen(trim(substr($objs->nombre,0,39)));
    $nombretit=str_pad(trim(substr($objs->nombre,0,39)),39,"*");
    $direccion=$objs->domicilio." - / - ".$objs->nacionalidad." - ".$objs->nombrep;
    $arraynombre[$cont]=sprintf("%06d",$objs->titular)."&nbsp;&nbsp;&nbsp;".$nombretit."&nbsp;&nbsp;&nbsp;".$direccion."&nbsp";
    $objs = $sql->objects('',$obj_query);
 }

$sql->disconnect();

$smarty->assign('vopc',$vopc); 
$smarty->assign('vder',$vder); 
$smarty->assign('nroderecho',$vder);
$smarty->assign('anno',$dirano);
$smarty->assign('numero',$numero);
$smarty->assign('nombre',$nombre);
$smarty->assign('clase',$clase);
$smarty->assign('ind_claseni',$ind_claseni);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venci',$fecha_venci);
$smarty->assign('fecha_publi',$fecha_publi);
$smarty->assign('fecha_regis',$fecha_regis);
$smarty->assign('tipo_marca',$tipo_marca);
$smarty->assign('vtipo_marca',$vtipo_marca);
$smarty->assign('estatus',$estatus-1000);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('registro',$vreg);
$smarty->assign('tramitante',$tramitante);
$smarty->assign('poder',$poder);
$smarty->assign('agente',$agente);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('modalidad',$modalidad);
$smarty->assign('tmodalidad',$tmodalidad);
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('arraytitular',$arraytitular);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('secuencial',0);
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
$smarty->assign('campo9','Fecha de Publicacion:');
$smarty->assign('campo10','Modalidad:');
$smarty->assign('campo11','Poder:');
$smarty->assign('campo12','Agente:');
$smarty->assign('campo13','Agente/Tramitante:');
$smarty->assign('campo14','Clase:');
$smarty->assign('campo15','N&uacute;mero de Derecho Control:');

$smarty->display('m_actelev1.tpl');
$smarty->display('pie_pag.tpl');
?>
