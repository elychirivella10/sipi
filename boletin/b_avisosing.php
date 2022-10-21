<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include("../fckeditor/fckeditor.php") ;
if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "b_avisosing.php";
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Ingreso de Avisos');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$titulo  = $_POST['titulo']; 
  if (empty($titulo)) {
    mensajenew("AVISO: No introdujo ningún titulo para el documento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag1.tpl'); exit(); } 
    
$sql  = new mod_db();
$sql -> connection();
//nro de aviso
   $ressys=pg_exec("SELECT MAX(nro_aviso) FROM stzavisos  ");
   $filasys_found=pg_numrows($ressys); 
   $sysact = pg_fetch_array($ressys); 
   $sys_act=$sysact['max'];
   $naviso=$sys_act +1 ; 


//Campos
$smarty ->assign('campo','Aviso o Documentos:'); 

//Valores
$smarty->assign('naviso',$naviso);
$smarty->assign('titulo',$titulo);
$smarty->assign('campo1','Nro. Aviso:');
$smarty->assign('campo2','Titulo:');
$smarty->display('b_avisosing.tpl');
$smarty->display('pie_pag1.tpl');
?>
