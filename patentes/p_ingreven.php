<?php
// ************************************************************************************* 
// Programa: p_ingreven.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año 2006
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$tbname_1 = "stppatee";
$tbname_2 = "stzstder";
$tbname_3 = "stzderec";
$sql     = new mod_db();
$fecha   = fechahoy();

//Validacion de Entrada
$vopc    = $_GET['vopc'];
$usuario = $_POST['usuario'];
$role    = $_POST['role'];
$vsol1   = $_POST["vsol1"];
$vsol2   = $_POST["vsol2"];
$vreg1   = $_POST["vreg1"];
$vreg2   = $_POST["vreg2"];
$vcodeve = $_POST['vcodeve'];
$eventos_id = $_POST['eventos_id'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
      mensajenew("ERROR: No introdujo ning&uacute;n valor de Expediente ...!!!","p_eveind.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}
if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2)) {
      mensajenew("ERROR: No introdujo ning&uacute;n valor de Expediente ...!!!","p_eveind.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}

//Verificando conexion
$sql->connection($usuario);

//Armado de Numero de Expediente
if ($vopc==1) {
  $varsol=sprintf("%02d-%06d",$vsol1,$vsol2);
  $resultado=pg_exec("SELECT * FROM $tbname_3 WHERE solicitud='$varsol' and solicitud!='' AND tipo_mp='P'"); }
if ($vopc==2) {
  $vreg='';
  if (!empty($vreg1) && !empty($vreg2)) {
    $vreg = $vreg1.$vreg2; }
  $resultado=pg_exec("SELECT * FROM $tbname_3 WHERE registro='$vreg' and registro!='' AND tipo_mp='P'"); }

if (!$resultado) { 
     mensajenew("ERROR: Nro. de Expediente ingresado NO existe en la Base de Datos ...!!!","p_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0) {
     mensajenew("ERROR: No existen Datos asociados al Expediente en Maestra de Patentes ...!!!","p_eveind.php","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
   } 
$reg = pg_fetch_array($resultado);

if ($reg['tipo_derecho']=='A') {$tipo_paten='INVENCION';}
if ($reg['tipo_derecho']=='B') {$tipo_paten='DIBUJO INDUSTRIAL';}
if ($reg['tipo_derecho']=='C') {$tipo_paten='DE MEJORA';}
if ($reg['tipo_derecho']=='D') {$tipo_paten='DE INTRODUCCION';}
if ($reg['tipo_derecho']=='E') {$tipo_paten='MODELO INDUSTRIAL';}
if ($reg['tipo_derecho']=='F') {$tipo_paten='MODELO DE UTILIDAD';}
if ($reg['tipo_derecho']=='G') {$tipo_paten='DISEÑO INDUSTRIAL';}
if ($reg['tipo_derecho']=='V') {$tipo_paten='VARIEDAD VEGETAL';}

$vder   = $reg['nro_derecho']; 
$varsol = $reg['solicitud'];
$nombre = $reg['nombre'];
$estatus= $reg['estatus'];
$fecha_solic= $reg['fecha_solic'];
$fecha_venc = $reg['fecha_venc'];
$vreg   = trim($reg['registro']); 
$dirano=substr($varsol,-11,4);
$vexp=$dirano."-".substr($varsol,-6,6);
$numero=substr($varsol,-6,6);
$vsol=$varsol;

//Obtención de la Descripción del Estatus 
$obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE estatus='$estatus'");
$objs = $sql->objects('',$obj_query);
$descripcion = $objs->descripcion;

//Obtención de los posibles eventos a aplicar al Expediente según el estatus de la marca 
if (empty($vreg)) {
  $resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = '$estatus' and
                            stzmigrr.tipo_mp = 'P' and
                            stzmigrr.evento=stzevder.evento and 
                            stzevder.tipo_mp = 'P' and
                            stzevder.aplica in ('T','A')
                      UNION
                      SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = 2888 and
                            stzmigrr.tipo_mp = 'P' and
                            stzmigrr.evento=stzevder.evento and
                            stzevder.tipo_mp = 'P' and  
                            stzevder.aplica in ('T','A')                      
                      UNION 
                      SELECT stzevder.evento,stzevder.descripcion FROM stzevder 
                      WHERE  stzevder.tipo_evento='N' and stzevder.tipo_mp = 'P'");
}
else {
  $resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = '$reg[estatus]' and
                            stzmigrr.tipo_mp = 'P' and
                            stzmigrr.evento=stzevder.evento and
                            stzevder.tipo_mp = 'P' and 
                            stzevder.aplica in ('R','A')
                      UNION
                      SELECT stzevder.evento,stzevder.descripcion FROM stzmigrr,stzevder 
                      WHERE stzmigrr.estatus_ini = 2888 and
                            stzmigrr.tipo_mp = 'P' and
                            stzmigrr.evento=stzevder.evento and
                            stzevder.tipo_mp = 'P' and 
                            stzevder.aplica in ('R','A')                      
                      UNION 
                      SELECT stzevder.evento,stzevder.descripcion FROM stzevder 
                      WHERE  stzevder.tipo_evento='N' and stzevder.tipo_mp = 'P'"); 
}

$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<=$filas_res_evento;$cont++) 
  { 
    $arrayevento[$cont]=$regeve[evento]-2000;
    //$arraydescri[$cont]=substr($regeve[descripcion],0,70);
    $arraydescri[$cont]=sprintf("%03d",$regeve[evento]-2000)." ".substr($regeve[descripcion],0,70);
    $regeve = pg_fetch_array($resevento);
  }

//Desconexion de la BD 
$sql->disconnect();

$smarty->assign('vder',$vder);
$smarty->assign('vopc',$vopc); 
$smarty->assign('anno',$dirano);
$smarty->assign('numero',$numero);
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venc',$fecha_venc);
$smarty->assign('tipo_paten',$tipo_paten);
$smarty->assign('estatus',$estatus-2000);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('registro',$vreg);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vcodeve',$vcodeve);
$smarty->assign('eventos_id',$eventos_id);

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Titulo:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Registro:');
$smarty->assign('campo7','Evento:');

$smarty->display('p_ingreven.tpl');
$smarty->display('pie_pag.tpl');
?>