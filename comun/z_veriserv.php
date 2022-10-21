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
$modulo  = "z_veriserv.php";

//Encabezados
$smarty->assign('titulo','SubSistema de Marcas');
$smarty->assign('subtitulo','Recepci&oacute;n y Verificaci&oacute;n de Escritos');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection();

$contobji=0;
$vcodser[$contobji] = 'Todos';
$vnomser[$contobji] = 'TODOS';
$objquery = $sql->query("SELECT * FROM stzeveser WHERE tipo_derecho='M'");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodser[$contobji] = $objs->evento;
  $vnomser[$contobji] = trim($objs->nombre);
  $objs = $sql->objects('',$objquery); }	  

//Asignación de variables para pasarlas a Smarty
$camposquery= "stzevuserv.control,fecha_trans,hora_trans,stzeveser.evento,nombre,solicitud,usuario,estatus,fecha_venc";
$camposname = "Control No.,Fecha Tramite,Hora Tramite,Codigo Evento,Tipo de Documento,Solicitud,Usuario,Estado,Vencimiento";
$tablas     = "stzeveser,stzevuserv,stmsolopo";
$condicion  = "";
$orden      = "1";
$modo       = "Ingresar";
$modoabr    = "Sel.";
//$vurl       = "z_rptverifica.php";
//$vurl       = "../index1.php";
$vurl       = "z_veriserv.php";
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
$smarty->assign('campo1','Control de Escrito:');
$smarty->assign('campo2','Tipo de Escrito:');
$smarty->assign('campo3','Fecha de Transacci&oacute;n:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('varfocus','forsolpre.control'); 
$smarty->assign('vcodser',$vcodser);
$smarty->assign('vnomser',$vnomser); 

$smarty->display('z_veriserv.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();
?>
