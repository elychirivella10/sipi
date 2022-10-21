<?php
// *************************************************************************************
// Programa: m_bfontxt.php 
// Realizado por el Analista de Sistema Ing. Maryury Bonilla
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Fecha: 25/05/2010 
// maryurybonilla20@gmail.com
// Modificado por el Ing. Romulo Mendoza -- Taquillas Multiples
// Fecha: 06/08/2010 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit();
}

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql = new mod_db();
$sql -> connection($usuario);
$fecha=fechahoy();
$modulo  = "m_abfontxt.php";

//Encabezado
//$substmar="Subsistema de Marcas";
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Generaci&oacute;n de Archivo TXT B&uacute;squeda Externa para sede Principal');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Focus
$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','form.vsol1');
$smarty ->assign('vmodo',''); 

// Obtencion de las Sedes 
$contobji=0;
$objquery = $sql->query("SELECT * FROM stzsede ORDER BY sede");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodsede[$contobji] = $objs->sede;
  $vnomsede[$contobji] = trim(sprintf("%02d",$objs->sede)." ".trim($objs->nombre));
  $objs = $sql->objects('',$objquery); }	  
  

//Campos
$smarty->assign('campo1','Nro. de Pedido:');
$smarty->assign('campo2','Fecha de Pedido:');
$smarty->assign('campo3','Por Sede:');
$smarty->assign('campo4','Fecha de Carga:');
$smarty->assign('campo5','Usuario:');
$smarty->assign('campo6','Modo de Env&iacute;o:');
$smarty->assign('campo7','Procesadas:');

//Values
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede);
$smarty->assign('arrayplus',array('N','S'));
$smarty->assign('arraydesplus',array('IMPRESORA','CORREO'));
$smarty->assign('arraytipop',array('T','S','N'));
$smarty->assign('arraydescp',array('AMBAS','SI','NO'));

//$smarty->assign('vsede',$vsede);

$smarty->display('m_abfontxt.tpl');
$smarty->display('pie_pag3.tpl');
?>

