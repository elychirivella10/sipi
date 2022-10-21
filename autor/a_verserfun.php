<?php
// ************************************************************************************* 
// Programa: z_veriserv.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Llamada al PDF
define('FPDF_FONTPATH',$root_path.'/font/');
//require ("$include_path/fpdf.php");

ob_start();

include ("../z_includes.php");

//Variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido"; exit();
}

$login = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "a_veriserv.php";

//Encabezados
$smarty->assign('titulo','SubSistema de Derecho de Autor');
$smarty->assign('subtitulo','Recepci&oacute;n y Verificaci&oacute;n de Servicios');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection1();

$contobji=0;
$vcodser[$contobji] = 'Todos';
$vnomser[$contobji] = 'TODOS';
$objquery = $sql->query1("SELECT * FROM stzservicios WHERE cod_servi LIKE 'DA%' AND cod_servi NOT IN ('DA11','DA15')");
$objfilas = $sql->nums1('',$objquery);
$objs = $sql->objects1('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodser[$contobji] = $objs->cod_servi;
  $vnomser[$contobji] = trim($objs->nom_servi);
  $objs = $sql->objects1('',$objquery); }	  

//Asignación de variables para pasarlas a Smarty
$camposquery= "control,fecha_trans,tipo_servicio,solicitud,registro,titulo_obra,solicitante,estatus";
$camposname = "Control No.,Fecha Tramite,Tramite,Solicitud,Registro,Titulo Obra,Usuario,Estatus,Accion";
$tablas     = "stdseraut";
$condicion  = "";
$orden      = "1";
$modo       = "Procesar";
$modoabr    = "Sel.";
//$vurl       = "z_rptverifica.php";
$vurl       = "../index1.php";
$new_windows= "N";
   
$smarty->assign('camposquery',$camposquery);
$smarty->assign('camposname',$camposname);
$smarty->assign('tablas',$tablas);
$smarty->assign('condicion',$condicion);
$smarty->assign('orden',$orden); 
$smarty->assign('modo',$modo); 
$smarty->assign('modoabr',$modoabr); 
$smarty->assign('vurl',$vurl);
$smarty->assign('new_windows',$new_windows);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Control de Servicio No:');
$smarty->assign('campo2','Tipo de Servicio:');
$smarty->assign('campo3','Fecha de Transacci&oacute;n:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' hasta:');
$smarty->assign('varfocus','forsolpre.control'); 
$smarty->assign('vcodser',$vcodser);
$smarty->assign('vnomser',$vnomser); 

$smarty->display('a_verserfun.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect1();
?>
