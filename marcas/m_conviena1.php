<?php
// *************************************************************************************
// Programa: m_conviena1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010 I Semestre BD Relacional
// *************************************************************************************

//CREATE TABLE stmpvie99 (
//    fecha date not null,
//    hora  character(11) not null,
//    usuario character(12),
//    control character(11),
//    solicitud character(11),
//    clase smallint,
//    ind_claseni character(1)
//);
//CREATE INDEX stmpvie99_control ON stmpvie99 USING btree (control);
//CREATE INDEX stmpvie99_solicitud ON stmpvie99 USING btree (solicitud);

//Para trabajar con Operaciones de Bases de Datos y Smarty 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];

$sql  = new mod_db();
$tbname_1 = "stmviena";
$tbname_2 = "stmccvma";
$tbname_3 = "stmtmpccv";
$fecha    = fechahoy();
$ntabla1  = "vienaext";
$ntabla2  = "stmpvie99";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','B&uacute;squeda de Logotipos por Viena');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Variables
$vopc     = $_GET['vopc'];
$vcontrol = $_POST['v1'];
$v1 = $_POST['v1'];

//Verificando conexion
$sql->connection($usuario);

$obj_query=true;
if ($vopc==1) {
  $fechahoy=Hoy();
  $horahoy= Hora(); 

  //Creacion de Tabla Temporal
  pg_exec("CREATE TEMPORARY TABLE $ntabla1 (solicitud char(11)); CREATE INDEX vienaext_sol ON vienaext USING btree (solicitud)");

  // Llenado de Tabla temporal de Clasificaciones de Viena asignados 
  $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE solicitud='$vcontrol'");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  if ($obj_filas==0) {
    Mensajenew('ERROR: NO selecciono ningun Codigo de Viena para la b&uacute;squeda ...!!!','m_conviena.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  for($i=0;$i<$obj_filas;$i++) { 
    $varsolc = $objs->ccv;
    $resultado=pg_exec("INSERT INTO $ntabla1 SELECT stzderec.solicitud FROM stmccvma,stzderec 
                        WHERE stzderec.nro_derecho = stmccvma.nro_derecho 
                        AND stzderec.tipo_mp = 'M' AND stmccvma.ccv='$varsolc'");
    $objs = $sql->objects('',$obj_query); 
  }

   $universo = 0;
   $respuesta=pg_exec("SELECT DISTINCT $ntabla1.solicitud FROM $ntabla1");   
   $filas_found=pg_numrows($respuesta);
   $fila=1;
   while ( $fila <= $filas_found )
   {
     $regis = pg_fetch_array($respuesta);
     $vs1=trim($regis['solicitud']);
     $obj_query = $sql->query("SELECT solicitud,clase,ind_claseni FROM stmmarce,stzderec 
                               WHERE stzderec.solicitud='$vs1'
                               AND stmmarce.nro_derecho=stzderec.nro_derecho 
                               AND stzderec.tipo_mp='M'");
     $objs = $sql->objects('',$obj_query);
     $vclase = $objs->clase;
     $vindcl = $objs->ind_claseni;
     $insert_str = "'$fechahoy','$horahoy','$usuario','$vcontrol','$vs1',$vclase,'$vindcl'";
     $reg_inser = $sql->insert("$ntabla2","","$insert_str","");
     $fila++;
   }

  //Cantidad de Solicitudes de Marcas con el Codigo de Viena asociado 
  $universo = $filas_found;
  if ($universo==0) {
    mensajenew('ERROR: NO Existen Datos asociados al Codigo de Viena ...!!!','m_conviena.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $smarty->assign('universo',$universo);

}

//Asignación de variables para pasarlas a Smarty
$camposquery = "solicitud,clase,ind_claseni";
$camposname= "solicitud,clase,ind_claseni,imagen";
$tablas    = $ntabla2;
$condicion = "control=v1"; 
$orden     = "1";
$modo      = "Imprimir";
$modoabr   = "Sel.";
$vurl      = "m_conviena.php";
$new_windows="N";
   
$smarty ->assign('camposquery',$camposquery);
$smarty ->assign('camposname',$camposname);
$smarty ->assign('tablas',$tablas);
$smarty ->assign('condicion',$condicion);
$smarty ->assign('orden',$orden); 
$smarty ->assign('modo',$modo); 
$smarty ->assign('modoabr',$modoabr); 
$smarty ->assign('vurl',$vurl);
$smarty ->assign('new_windows',$new_windows);

$smarty->assign('campo1','  B&uacute;squeda Control No.:');
$smarty->assign('lcviena','C&oacute;digos de Viena '); 

$smarty->assign('vopc',$vopc); 
$smarty->assign('modo1','readonly'); 
$smarty->assign('modo2','disabled');  
$smarty->assign('usuario',$usuario);
$smarty->assign('vcontrol',$v1);
$smarty->assign('universo',$universo);

$smarty->display('m_conviena1.tpl');
$smarty->display('pie_pag.tpl');
?>
