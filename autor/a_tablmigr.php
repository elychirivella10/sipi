<?php
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$fecha   = fechahoy();

$vopc    = $_GET['vopc'];
$accion  = $_POST['accion'];
$estatus = $_POST['estatus'];
$inicial = $_POST['inicial'];
$final   = $_POST['final'];

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Mantenimiento de Migraciones / '.$accion); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Migraciones / Ingreso'); }
if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Migraciones / Modificacion'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==1 && $accion=='Modificacion') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmstatus2.inicial');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdmigrr WHERE evento='$estatus'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!",'a_tablmigr.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $estatus=$reg[evento];
  $inicial =$reg[estatus_ini];
  $final   =$reg[estatus_fin];  

  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('inicial',$inicial);
  $smarty->assign('final',$final);
}

if ($vopc==1 && $accion=='Ingreso') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',1);
  $smarty->assign('varfocus','frmstatus2.inicial');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdevobr WHERE evento='$estatus'");
  $filas_found=pg_numrows($resultado);
  if ($filas_found==0) { 
    mensajenew("EL EVENTO NO ESTA REGISTRADO...!!!",'a_tablmigr.php?vopc=3',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  
  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('inicial',$inicial);
  $smarty->assign('final',$final);
}

if ($vopc==3) {
  $smarty->assign('varfocus','frmstatus1.estatus'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',1);
}

if ($vopc==4) {
  $smarty->assign('varfocus','frmstatus1.estatus'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Opcion Grabar...
if ($vopc==2) {
  //Verificando conexion
  $sql->connection();

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($inicial) || empty($final)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $resultado=pg_exec("SELECT * FROM stdmigrr WHERE evento='$estatus' and 
                      estatus_ini='$inicial' and estatus_fin='$final'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found>0) {
    mensajenew("Esta Migración ya esta Registrada...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  
  // Verifica que exista el estatus inicial
  $resfinal=pg_exec("SELECT * FROM stdstobr WHERE estatus='$inicial'");
  $filas_final=pg_numrows($resfinal);
  if ($filas_final==0) {
    mensajenew("No existe el Estatus Inicial...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  // Verifica que exista el estatus final
  $resfinal=pg_exec("SELECT * FROM stdstobr WHERE estatus='$final'");
  $filas_final=pg_numrows($resfinal);
  if ($filas_final==0) {
    mensajenew("No existe el Estatus Final...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  pg_exec("BEGIN WORK");
  //al Incluir
  if ($accion==1) {
    pg_exec("LOCK TABLE stdmigrr IN SHARE ROW EXCLUSIVE MODE");
    $insert_cam = "evento,estatus_ini,estatus_fin";
    $insert_str = "$estatus,$inicial,$final";
    $sql->insert("stdmigrr","$insert_cam","$insert_str","");
  }
  //al Modificar
  if ($accion==2) {
    // Actualizo en Maestra de Eventos
    pg_exec("LOCK TABLE stdmigrr IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "estatus_ini=$inicial,estatus_fin=$final";
    $sql->update("stdmigrr","$update_str","evento='$estatus'");
  }
  pg_exec("COMMIT WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==1) {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tablmigr.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tablmigr.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

$smarty->assign('campo1','Evento de Migraci&oacute;n:');
$smarty->assign('campo2','Estatus Inicial:');
$smarty->assign('campo3','Estatus Final:');
$smarty->assign('vopc',$vopc);
$smarty->assign('estatus',$estatus);
$smarty->display('a_tablmigr.tpl');
$smarty->display('pie_pag.tpl');
?>
