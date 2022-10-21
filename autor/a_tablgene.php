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
$nombre  = $_POST['nombre'];

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Mantenimiento de Generos / '.$accion); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Generos / Ingreso'); }
if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Generos / Modificacion'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==1 && $accion=='Modificacion') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmstatus2.nombre');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdgener WHERE cod_genero='$estatus'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!",'a_tablgene.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $estatus=$reg[cod_genero];
  $nombre=trim($reg[desc_genero]);
  
  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('nombre',$nombre);
}

if ($vopc==1 && $accion=='Ingreso') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',1);
  $smarty->assign('varfocus','frmstatus2.nombre');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdgener WHERE cod_genero='$estatus'");
  $filas_found=pg_numrows($resultado);
  if ($filas_found>0) { 
    mensajenew("EL GENERO YA ESTA REGISTRADO...!!!",'a_tablgene.php?vopc=3',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  
  //Paso a Smarty los Valores
  $smarty->assign('estatus',$estatus);
  $smarty->assign('nombre',$nombre);
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
  if (empty($nombre)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  pg_exec("BEGIN WORK");
  //al Incluir
  if ($accion==1) {
    pg_exec("LOCK TABLE stdgener IN SHARE ROW EXCLUSIVE MODE");
    $insert_cam = "cod_genero,desc_genero";
    $insert_str = "'$estatus','$nombre'";
    $sql->insert("stdgener","$insert_cam","$insert_str","");
  }
  //al Modificar
  if ($accion==2) {
    // Actualizo en Maestra de Eventos
    pg_exec("LOCK TABLE stdgener IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "desc_genero='$nombre'";
    $sql->update("stdgener","$update_str","cod_genero='$estatus'");
  }
  pg_exec("COMMIT WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==1) {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tablgene.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tablgene.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

$smarty->assign('campo1','Codigo del Genero:');
$smarty->assign('campo2','Descripcion:');
$smarty->assign('vopc',$vopc);
$smarty->assign('estatus',$estatus);
$smarty->display('a_tablgene.tpl');
$smarty->display('pie_pag.tpl');
?>
