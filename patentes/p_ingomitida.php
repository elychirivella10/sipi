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
$tbname_2 = "stppatee";
$tbname_3 = "stzottid";
$tbname_4 = "stpinved";
$tbname_5 = "stzevtrd";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Solicitud de Patente Omitida');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
  $vsol1  = $_POST['vsol1'];
  $vsol2  = $_POST['vsol2'];
  $vfecha = $_POST['fecha_solic'];

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
    mensajenew("No introdujo ningún valor de Expediente ...!!!","p_ingomitida.php?vopc=1","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($vfecha)) {
    mensajenew("No introdujo ningún valor para la Fecha del Expediente ...!!!","p_ingomitida.php?vopc=1","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $varsol=$vsol1."-".$vsol2;

  //Verificando conexion
  $sql  = new mod_db();
  $sql->connection($usuario);

  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al Procesar la Verificacion de Solicitud en la Base de Datos ...!!!','p_ingomitida.php?vopc=1','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found!=0) {
     mensajenew("Existen Datos asociados a ese Numero de Expediente en la Base de Datos ...!!!","p_ingomitida.php?vopc=1","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } else {
    $vnom       = "SOLICITUD OMITIDA";
    $vtra       = "SAPI";
    $estatus    = '2999';
    $tipo_patente = "A";
    $vpoder     = "";
    $vcodpais   = "VE";
    $vcodage    = 0;
    $fecha_solic= $vfecha;

    //Descripcion del Evento de Ingreso Inicial ...
    $obj_query = $sql->query("SELECT * FROM stzevder WHERE evento=2200");
    if (!$obj_query) { 
      mensajenew('ERROR: Problema al Procesar la Verificacion de Evento de Carga Inicial en la Base de Datos ...!!!','p_ingomitida.php?vopc=1','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) {
      mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","p_ingomitida.php?vopc=1","N");
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
    $insert_str = "'$prox_derecho','$tipo_patente','$varsol','$fecha_solic','P','$vnom',$estatus,'$vcodpais','$vpoder','$vtra','$vcodage'";
    $insderecho = $sql->insert("$tbname_1","$col_campos","$insert_str","");
    if ($insderecho) { }
    else { $numerror = $numerror + 1; }  

    //Insercion del Registro Nuevo en la Maestra de Marcas   
    $col_campos = "nro_derecho,edicion,anualidad,resumen";
    $resumen = "SOLICITUD OMITIDA";
    $edicion = "0";
    $anualidad = 1;
    $insert_str = "'$prox_derecho','$edicion','$anualidad','$resumen'";
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

    $vinventor = "SAPI";
    //Insercion del Inventor   
    $col_campos = "nro_derecho,nombre_inv,nacionalidad,domicilio,pais_domicilio";
    $insert_str = "'$prox_derecho','$vinventor','$vpais','$vdomi','$vpais'";
    $ins_inven = $sql->insert("$tbname_4","$col_campos","$insert_str","");
    if ($ins_inven) { }
    else { $numerror = $numerror + 1; }  

    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy  = hoy();
    $horactual = Hora();

    // Tabla de Eventos de Tramite  
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$prox_derecho',2200,'$fecha_solic',nextval('stzevtrd_secuencial_seq'),2000,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");
    if ($instram) { }
    else { $numerror = $numerror + 1; }  

    if ($numerror==0) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew("SOLICITUD OMITIDA INGRESADA CORRECTAMENTE ...!!!","p_ingomitida.php?vopc=1","S");
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

$smarty->display('p_ingomitida.tpl');
$smarty->display('pie_pag.tpl');
?>
