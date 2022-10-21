<script language='javascript' type='text/javascript'> 
  function checkKey(evt){
   if (evt.keyCode == '17')  
     {alert("Comando No Permitido ...!!!");
     return false;}
   return true; }
   
  function cerrarwindows() {
     window.close(); }
  
</script>

<?php
// *************************************************************************************
// Programa: m_evpagoexo.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2013
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo  = "m_eveind.php";

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Pago de Derechos Exonerados');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','forevind1.vsol1');
$smarty ->assign('vmodo',''); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro:');

$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Nombre:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Evento:');
$smarty->assign('varfocus','forevind1.vsol1'); 
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);

$smarty->display('m_evpagoexo.tpl');
$smarty->display('pie_pag.tpl');
?>
