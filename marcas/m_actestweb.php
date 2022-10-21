<?php
// *************************************************************************************
// Programa: m_actestweb.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// creado: 2017 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha    = fechahoy();

//Variable
$sql = new mod_db();
$tbname_1 = "stmbusweb";

$vopc    = $_GET['vopc'];
$tramite = $_POST['tramite'];
$resultado = false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Cambio de Estatus a Tramite B&uacute;squeda Webpi para Reenvio');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  if (empty($tramite)) {
    mensajenew('ERROR: N&uacute;mero de Tramite esta vacio ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  $estatus    = '2';
  $update_str = "estado='$estatus'"; 
  $condicion  = "nro_tramite='$tramite' AND estado='3'";
  $seleccion  = "SELECT nro_tramite FROM $tbname_1";
  $lcwhere    = " WHERE nro_tramite='$tramite' AND estado='3'";

  $resultado=pg_exec("$seleccion$lcwhere");
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_actestbusweb.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 

  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','m_actestbusweb.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  {
    //Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $act_dere = true;
    //Se actualiza Maestra Principal de Busqueda 
    if (!empty($update_str))
      { $act_dere = $sql->update("$tbname_1","$update_str","$condicion"); }

    if ($act_dere) { }
    else { $numerror = $numerror + 1; }  

    if ($numerror==0) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","m_actestbusweb.php","S");
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

?>
