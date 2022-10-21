<?php
// *************************************************************************************
// Programa: a_ingreven.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2008
// Modificado Año: 2009 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$tbname_q1 = "stdobras";
$tbname_q2 = "stdstobr";
$sql       = new mod_db();
$fecha     = fechahoy();

// Obtencion de variables de los campos del tpl
$vopc   = $_GET['vopc'];
$conx   = $_GET['conx'];
$salir  = $_GET['salir'];
$nconex = $_POST['nconex'];

$usuario    =$_POST['usuario'];
$role       =$_POST['role'];
$vsol1      =$_POST["vsol1"];
$vreg1      =$_POST["vreg1"];
$vcodeve    =$_POST['vcodeve'];
$eventos_id =$_POST['eventos_id'];

$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Ingreso de Evento Individual');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************
// Control de acceso: Entrada y Salida al Modulo
if ($conx==0) {
  $smarty->assign('n_conex',$nconex);      }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1)) {
      mensajenew("ERROR: No introdujo ningún valor de Expediente ...!!!","a_eveind.php?nconex={$nconex}&salir=1&conx=0","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}
if ($vopc==2) {
   //Validacion del Numero de Registro
   if (empty($vreg1)) {
      mensajenew("ERROR: No introdujo ningún valor de Expediente ...!!!","a_eveind.php?nconex={$nconex}&salir=1&conx=0","N");
      $smarty->display('pie_pag.tpl'); exit(); }
}

//Verificando conexion
$sql->connection($usuario);

//Armado de Numero de Expediente
if ($vopc==1) {
  $resultado=pg_exec("SELECT * FROM $tbname_q1 WHERE solicitud='$vsol1' and solicitud!=''"); }
if ($vopc==2) {
  if (!empty($vreg1)) {
  $resultado=pg_exec("SELECT * FROM $tbname_q1 WHERE registro='$vreg1' and registro!=''"); }
}
if (!$resultado) {
     mensajenew("ERROR: Nro. de Expediente ingresado NO existe en la Base de Datos ...!!!","a_eveind.php?nconex={$nconex}&salir=1&conx=0","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}
$filas_found=pg_numrows($resultado);
if ($filas_found==0) {
     mensajenew("ERROR: No existen Datos asociados al Expediente en Maestra de Obras ...!!!","a_eveind.php?nconex={$nconex}&salir=1&conx=0","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
   }
$reg = pg_fetch_array($resultado);

if ($reg['tipo_obra']=='OL') {$tipo_obra='OBRA LITERARIA';}
if ($reg['tipo_obra']=='AV') {$tipo_obra='ARTE VISUAL';}
if ($reg['tipo_obra']=='OE') {$tipo_obra='OBRA ESCENICA';}
if ($reg['tipo_obra']=='OM') {$tipo_obra='OBRA MUSICAL';}
if ($reg['tipo_obra']=='AR') {$tipo_obra='OBRA AUDIOVISUAL Y RADIOFONICA';}
if ($reg['tipo_obra']=='PC') {$tipo_obra='PROGRAMA DE COMPUTACION Y BASE DE DATOS';}
if ($reg['tipo_obra']=='PF') {$tipo_obra='PRODUCCION FONOGRAFICA';}
if ($reg['tipo_obra']=='AC') {$tipo_obra='ACTOS Y CONTRATOS';}
if ($reg['tipo_obra']=='IE') {$tipo_obra='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';}

$vsol=trim($reg['solicitud']);
$vder=trim($reg['nro_derecho']);
$nombre=$reg['titulo_obra'];
$estatus=$reg['estatus'];
$fecha_solic=$reg['fecha_solic'];
$fecha_venc=$reg['fecha_venc'];
$vreg=trim($reg['registro']);

//Obtención de la Descripción del Estatus
$obj_query = $sql->query("SELECT * FROM $tbname_q2 WHERE estatus='$estatus'");
$objs = $sql->objects('',$obj_query);
$descripcion = $objs->descripcion;

//Obtención de los posibles eventos a aplicar al Expediente según el estatus de la obra
if (!empty($vsol)) {
  $resevento=pg_exec("SELECT stdevobr.evento,stdevobr.descripcion FROM stdmigrr,stdevobr
                      WHERE stdmigrr.estatus_ini = '$estatus' and
                            stdmigrr.evento=stdevobr.evento and
                            stdevobr.aplica in ('T','A')
                      UNION
                      SELECT stdevobr.evento,stdevobr.descripcion FROM stdmigrr,stdevobr 
                      WHERE stdmigrr.estatus_ini = 888 and
                            stdmigrr.evento=stdevobr.evento and 
                            stdevobr.aplica in ('T','A')                      
                      UNION
                      SELECT stdevobr.evento,stdevobr.descripcion FROM stdevobr
                      WHERE  stdevobr.tipo_evento='N' ");
}
else {
  $resevento=pg_exec("SELECT stdevobr.evento,stdevobr.descripcion FROM stdmigrr,stdevobr
                      WHERE stdmigrr.estatus_ini = '$reg[estatus]' and
                            stdmigrr.evento=stdevobr.evento and
                            stdevobr.aplica in ('R','A')
                      UNION
                      SELECT stdevobr.evento,stdevobr.descripcion FROM stdmigrr,stdevobr 
                      WHERE stdmigrr.estatus_ini = 888 and
                            stdmigrr.evento=stdevobr.evento and 
                            stdevobr.aplica in ('T','A')                      
                      UNION
                      SELECT stdevobr.evento,stdevobr.descripcion FROM stdevobr
                      WHERE  stdevobr.tipo_evento='N' ");
}

$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<=$filas_res_evento;$cont++)
  {
    $arrayevento[$cont]=$regeve[evento];
    $arraydescri[$cont]=sprintf("%03d",$regeve[evento])." ".substr($regeve[descripcion],0,70);
    $regeve = pg_fetch_array($resevento);
  }

$sql->disconnect();

$smarty->assign('vopc',$vopc);
$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder); 
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('fecha_venc',$fecha_venc);
$smarty->assign('tipo_obra',$tipo_obra);
$smarty->assign('estatus',$estatus);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('registro',$vreg);
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
$smarty->assign('varfocus','forevento.input2');

$smarty->display('a_ingreven.tpl');
$smarty->display('pie_pag.tpl');
?>
