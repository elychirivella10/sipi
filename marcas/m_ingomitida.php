<?php
// *************************************************************************************
// Programa: m_ingomitida.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Desarrollado Año: 2019 II Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

//Variables
$vopc     = $_GET['vopc'];
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$fecha    = fechahoy();

//Tablas
$tbname_1 = "stzderec";
$tbname_2 = "stmmarce";
$tbname_3 = "stzottid";
$tbname_4 = "stmclnac";
$tbname_5 = "stzevtrd";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Solicitud de Marca Omitida');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
  $vsol1  = $_POST['vsol1'];
  $vsol2  = $_POST['vsol2'];
  $vfecha = $_POST['fecha_solic'];

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
    mensajenew("No introdujo ningún valor de Expediente ...!!!","m_ingomitida.php?vopc=1","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($vfecha)) {
    mensajenew("No introdujo ningún valor para la Fecha del Expediente ...!!!","m_ingomitida.php?vopc=1","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $varsol=$vsol1."-".$vsol2;

  //Verificando conexion
  $sql  = new mod_db();
  $sql->connection($usuario);

  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='M'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al Procesar la Verificacion de Solicitud en la Base de Datos ...!!!','m_ingomitida.php?vopc=1','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found!=0) {
     mensajenew("Existen Datos asociados a ese Numero de Expediente en la Base de Datos ...!!!","m_ingomitida.php?vopc=1","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } else {
    $vnom       = "SOLICITUD OMITIDA";
    $vtra       = "SAPI";
    $estatus    = '1999';
    $tipo_marca = "M";
    $vpoder     = "";
    $vcodpais   = "VE";
    $vcodage    = 0;
    $fecha_solic= $vfecha;

    //Descripcion del Evento de Ingreso Inicial ...
    $obj_query = $sql->query("SELECT * FROM stzevder WHERE evento=1200");
    if (!$obj_query) { 
      mensajenew('ERROR: Problema al Procesar la Verificacion de Evento de Carga Inicial en la Base de Datos ...!!!','m_ingomitida.php?vopc=1','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) {
      mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","m_ingomitida.php?vopc=1","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $objs = $sql->objects('',$obj_query);
    $vdes=trim($objs->mensa_automatico);
    $documento=0;
    $comentario="";

    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    //Proximo valor del Numero de Derecho ...
    $obj_query = $sql->query("update stzsystem set nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("select last_value from stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $prox_derecho = $objs->last_value; }

    //Insercion del Registro Nuevo en la Maestra de Derecho 
    $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,pais_resid,poder,tramitante,agente";
    $insert_str = "'$prox_derecho','$tipo_marca','$varsol','$fecha_solic','M','$vnom',$estatus,'$vcodpais','$vpoder','$vtra','$vcodage'";
    $insderecho = $sql->insert("$tbname_1","$col_campos","$insert_str","");
    if ($insderecho) { }
    else { $numerror = $numerror + 1; }  

    //Insercion del Registro Nuevo en la Maestra de Marcas   
    $col_campos = "nro_derecho,clase,ind_claseni,modalidad,distingue";
    $distingue = "SOLICITUD OMITIDA";
    $modalidad = "D";
    $vclase    = 1;
    $insert_str = "'$prox_derecho','$vclase','I','$modalidad','$distingue'";
    $insmarce = $sql->insert("$tbname_2","$col_campos","$insert_str","");
    if ($insmarce) { }
    else { $numerror = $numerror + 1; }  

    $vpais   = "VE";
    $titular = 781566;
    $vdomi   = "Caracas, Distrito Capital.";
    //Insercion del Titular   
    $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
    $insert_str = "'$prox_derecho','$titular','$vpais','$vdomi','$vpais'";
    $ins_titur = $sql->insert("$tbname_3","$col_campos","$insert_str","");
    if ($ins_titur) { }
    else { $numerror = $numerror + 1; }  

    $insclanac= true;
    $vclnac   = 50;
    //Insercion de la Clase Nacional   
    $col_campos = "nro_derecho,clase_nac";
    $insert_str = "'$prox_derecho','$vclnac'";
    $insclanac  = $sql->insert("$tbname_4","$col_campos","$insert_str","");
    if ($insclanac) { }
    else { $numerror = $numerror + 1; }  

    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy  = hoy();
    $horactual = Hora();

    // Tabla de Eventos de Tramite  
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$prox_derecho',1200,'$fecha_solic',nextval('stzevtrd_secuencial_seq'),1000,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");
    if ($instram) { }
    else { $numerror = $numerror + 1; }  

    if ($numerror==0) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew("SOLICITUD OMITIDA INGRESADA CORRECTAMENTE ...!!!","m_ingomitida.php?vopc=1","S");
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
  }
}

$smarty->assign('campo1','Nro. Expediente:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('varfocus','formarcas2.vsol1'); 

$smarty->display('m_ingomitida.tpl');
$smarty->display('pie_pag.tpl');
?>
