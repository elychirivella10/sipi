<?php
// ************************************************************************************* 
// Programa: z_modpass.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login    = $_SESSION['usuario_login'];
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stzusuar";
$tbname_2 = "stzhispw";
$tbname_3 = "stzbitac";

$vopc=$_GET['vopc'];
$passwant=$_POST['passwant'];
$passwd=$_POST['passwd'];
$rpasswd=$_POST['rpasswd'];
$vstring=$_POST['vstring'];

$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Mantenimiento de Password / Modificaci&oacute;n');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('modo2','');

//Verificando conexion
$sql->connection();

$statusbd = Edo_bd();
if ($statusbd=="2") {
   mensajenew("Base de Datos en Mantenimiento, comunicarse con el Administrador del Sistema ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vopc==2) {
  $fechahoy = hoy();
  $horactual= Hora();
  
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($passwd) || empty($rpasswd) || empty($passwant)) { 
    Mensajenew("Hay Informacion requerida en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }
  
  //Verificando conexion
  //$sql->connection();
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE usuario='$login'");
  if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found == 0) {
    mensajenew("Usuario NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $objs = $sql->objects('',$obj_query);
  $passw1=trim($objs->pass);
  $pviejo = md5($passwant);

  //Verificacion del Password Anterior
  if ($passw1 != $pviejo) { 
    mensajenew("ERROR: Password o Clave anterior Incorrecto ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  //Verificacion del Password
  if ($passwd != $rpasswd) { 
    mensajenew("ERROR: Nuevo Password y confirmacion de la misma no coinciden ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  //Encriptamiento de la clave 
  $clave = md5($passwd);
    //Verificación de uso de Clave
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE usuario='$login' AND pass='$clave'");
  if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found != 0) {
    Mensajenew("AVISO: Clave ya usada anteriormente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $upd_usr = true;
  $ins_clave = true;
  //Actualizo Datos en la tabla de Usuario
  $update_str = "pass='$clave'";
  $upd_usr = $sql->update("$tbname_1","$update_str","usuario='$login'");

  $columna_str = "cntrlpwd,usuario,pass,fecha_pass,hora_pass";
  $insert_str  = "nextval('stzhispw_cntrlpwd_seq'),'$login','$clave','$fechahoy','$horactual'";
  $ins_clave   = $sql->insert("$tbname_2","$columna_str","$insert_str","");

  // Verificacion y actualizacion real de los Datos en BD 
  if (($upd_usr) AND ($ins_clave)) {
    pg_exec("COMMIT WORK"); 
    
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE ..!','../comun/z_modpass.php','S');
    $smarty->display('pie_pag.tpl'); exit(); }

  else {
    pg_exec("ROLLBACK WORK");

    //Desconexion de la Base de Datos
    $sql->disconnect();
    if (!$upd_usr) { $error_usr  = " - Usuarios "; } 
    Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_usr ...!!!","../comun/z_modpass.php","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }
}

$smarty->assign('campo1','Password Anterior:');
$smarty->assign('campo2','Password Nuevo:');
$smarty->assign('campo3','Confirmar Password:');
$smarty->assign('varfocus','forusing1.passwant'); 
$smarty->assign('passwant',$passwant);
$smarty->assign('passwd',$passwd);
$smarty->assign('rpasswd',$rpasswd);

$smarty->display('z_modpass.tpl');
$smarty->display('pie_pag.tpl');
?>
