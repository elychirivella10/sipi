<?php
// *************************************************************************************
// Programa: m_rptctrlcer.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Auditor&iacute;a de Control de Certificados de Marcas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

// Obtencion de las Sedes 
$contobji=0;
$vcodsede[$contobji] = '';
$vnomsede[$contobji] = '';
$objquery = $sql->query("SELECT * FROM stzsede ORDER BY sede");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodsede[$contobji] = $objs->sede;
  $vnomsede[$contobji] = trim(sprintf("%02d",$objs->sede)." ".trim($objs->nombre));
  $objs = $sql->objects('',$objquery); }	  

//Desconexion de la Base de Datos
$sql->disconnect();

$vsede = "0";

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas de Carga:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campo3','HASTA:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','N&uacute;mero de Control:');
$smarty->assign('campo6','Sede:');
$smarty->assign('campo7','Tipo:');

$smarty->assign('arraytipom',array('T','F','C'));
$smarty->assign('arraynotip',array('AMBAS','FIRMAR','CORREGIR'));
$smarty->assign('varfocus','formarcas2.fechfon1'); 
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);

$smarty->display('m_rptctrlcer.tpl');
$smarty->display('pie_pag.tpl');
?>
