<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$tbname_1 = "stdobras";
$tbname_2 = "stdstobr";
$tbname_3 = "stdevtrd";
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
$smarty->assign('subtitulo','Mantenimiento de Eventos Cargados Autor');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection();

$statusbd = Edo_bd();
if ($statusbd=="2") {
   mensajenew("Base de Datos en Mantenimiento, comunicarse con el Administrador del Sistema ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","a_actelev.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}
if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg2)) {
      mensajenew("No introdujo ningún valor de Expediente ...!!!","a_actelev.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}

//Armado de Numero de Expediente
if ($vopc==1) {
  $varsol=$vsol2;
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$varsol' AND solicitud!=''"); }
if ($vopc==2) {
  $vreg='';
  if (!empty($vreg2)) {
    $vreg = trim($vreg2); }
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE registro='$vreg' AND registro!=''"); }

if (!$resultado) { 
     mensajenew("Nro. de Expediente ingresado NO existe en la Base de Datos ...!!!","a_actelev.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     mensajenew("No existen Datos asociados al Expediente en Maestra de Obras ...!!!","a_actelev.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
$reg = pg_fetch_array($resultado);

if ($reg['tipo_obra']=='OL') {$vtipo_marca='OBRA LITERARIA';}
if ($reg['tipo_obra']=='AV') {$vtipo_marca='ARTE VISUAL';}
if ($reg['tipo_obra']=='OE') {$vtipo_marca='OBRA ESCENICA';}
if ($reg['tipo_obra']=='OM') {$vtipo_marca='OBRA MUSICAL';}
if ($reg['tipo_obra']=='AR') {$vtipo_marca='OBRA AUDIOVISUAL Y RADIOFONICA';}
if ($reg['tipo_obra']=='PC') {$vtipo_marca='PROGRAMAS DE COMPUTACION Y B.D.';}
if ($reg['tipo_obra']=='PF') {$vtipo_marca='PRODUCCION FONOGRAFICA';}
if ($reg['tipo_obra']=='IE') {$vtipo_marca='INTERPRETACIONES Y EJECUCIONES A.';}
if ($reg['tipo_obra']=='AC') {$vtipo_marca='ACTOS Y CONTRATOS';}

$varsol = $reg['solicitud'];
$vder   = $reg['nro_derecho'];
$nombre = $reg['titulo_obra'];
$tipo_marca  = $reg['tipo_obra'];
$fecha_solic = $reg['fecha_solic'];
//$fecha_publi = $reg['fecha_publi'];
//$fecha_venci = $reg['fecha_venc'];
$fecha_regis = $reg['fecha_regis'];
$estatus = $reg['estatus'];
$vreg    = $reg['registro'];
//$tramitante = $reg['tramitante'];
//$poder   = $reg['poder'];
//$agente  = $reg['agente'];

// Obtencion del Nombre del Agente  
//$nbagente = agente_tram($agente,$tramitante,1);

//if ($agente > 0) { $tramitante = $nbagente; }
 
//Obtención de datos de la Marca 
//$obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
//$objs = $sql->objects('',$obj_query);
//$modalidad   = $objs->modalidad;
//$clase       = $objs->clase;
//$ind_claseni = $objs->ind_claseni;

//$dirano=substr($varsol,-11,4);
//$vexp=$dirano."-".substr($varsol,-6,6);
$numero=$varsol;
$vsol=$varsol;

//if ($modalidad=='D') { $tmodalidad='DENOMINATIVA'; }

//switch ($modalidad) {
//   case "G":
//      $tmodalidad='GRAFICA';
//      break;
//   case "M":
//      $tmodalidad='MIXTA';
//      break;
//}

//if ($modalidad=="D") {
//  $nameimage  = "../imagenes/sin_imagen.jpg"; }
//  else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

//if (!file_exists($nameimage)) {
//   $nameimage="../imagenes/sin_imagen.jpg"; }
//$smarty->assign('ubicacion',$nameimage);

// Obtencion de la Descripcion del Estatus
$descripcion='';
$resesta=pg_exec("select descripcion from stdstobr where estatus='$estatus'");
$regesta = pg_fetch_array($resesta);
$descripcion = rtrim(ltrim($regesta[descripcion]));

//Obtención de los Eventos de la Solicitud de Marcas
$obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder' ORDER BY fecha_event,secuencial");
if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}
$filas_found=$sql->nums('',$obj_query);
$totalevm=$filas_found;
if ($filas_found==0) {
  Mensajenew("No existen Eventos de Tramite para la Solicitud ...!!!","a_actelev.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
} 

$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arrayevento[$cont]=$objs->secuencial;
    $arraydescri[$cont]=sprintf("%03d",$objs->evento)."  ".$objs->fecha_event."  ".$objs->fecha_trans."   ".sprintf("%08d",$objs->secuencial)."   ".sprintf("%03d",$objs->estat_ant)."   ".substr(trim($objs->comentario),0,65);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención del(los) Titular(es) de la Solicitud de Marcas
//$obj_query = $sql->query("SELECT a.titular,b.nombre,a.domicilio,a.nacionalidad,c.nombre as //nombrep
//                          FROM stdobsol a,stdobras b,stzpaisr c 
//                         WHERE a.nro_derecho ='$vder' AND  
//                                a.titular=b.titular AND 
//                                a.nacionalidad=c.pais");
//if (!$obj_query) { 
//  mensajenew("Problema al intentar realizar la consulta en la tabla Stzottid o Stzsolic o Stzpaisr ...!!!","javascript:history.back();","N");
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
//$filas_found = $sql->nums('',$obj_query);
//$totalevm = $filas_found;
//if ($filas_found==0) {
//  Mensajenew("No existen Titular(es) para la Solicitud ...!!!","a_actelev.php","N");
//  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

//$cont = 0;
//$objs = $sql->objects('',$obj_query);
//$titular=$objs->titular; 
//$tnombre=trim($objs->nombre);
//$tdomicilio=trim($objs->domicilio);
//$pais=$objs->pais_resid;
//for($cont=1;$cont<=$filas_found;$cont++) { 
//    $arraytitular[$cont]=$objs->titular;
//    $espacios=39-strlen(trim(substr($objs->nombre,0,39)));
//    $nombretit=str_pad(trim(substr($objs->nombre,0,39)),39,"*");
//    $direccion=$objs->domicilio." - / - ".$objs->nacionalidad." - ".$objs->nombrep;
//    $arraynombre[$cont]=sprintf("%06d",$objs->titular)."&nbsp;&nbsp;&nbsp;".$nombretit."&nbsp;&nbsp;&nbsp;".$direccion."&nbsp";
//    $objs = $sql->objects('',$obj_query);
// }

$sql->disconnect();

$smarty->assign('vopc',$vopc); 
$smarty->assign('vder',$vder); 
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
$smarty->assign('estatus',$estatus);
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
$smarty->assign('campo4','Titulo:');
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

$smarty->display('a_actelev1.tpl');
$smarty->display('pie_pag.tpl');
?>
