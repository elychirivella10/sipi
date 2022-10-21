<?php
// ************************************************************************************* 
// Programa: z_veribusq.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2015 BD - Relacional I Semestre
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
$modulo  = "m_veribusfon.php";

//Encabezados
$smarty->assign('titulo','SubSistema de Marcas');
$smarty->assign('subtitulo','Verificaci&oacute;n de Env&iacute;o de Resultados B&uacute;squedas Foneticas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection();

//Asignación de variables para pasarlas a Smarty
$camposquery= "stmbusqueda.nro_pedido,nro_recibo,f_pedido,stmbusplan.cod_planilla,solicitante,denominacion,clase,f_transac,hora_c,f_proceso,hora_proceso,envio,estatus_envio,fecha_envio,hora_envio";
$camposname = "Pedido No.,Factura,Fecha Factura,Planilla,Solicitante,Denominacion,Clase,F. Carga,H. Carga,F. Proceso,H. Proceso,Entrega,Estatus Entrega,F. Envio  ,H. Envio  ";
$tablas     = "stmbusqueda,stmbusplan";
$condicion  = "";
$orden      = "1";
$modo       = "Ingresar";
$modoabr    = "Sel.";
//$vurl       = "z_rptverifica.php";
//$vurl       = "../index1.php";
$vurl       = "m_veribusfon.php";
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
$smarty->assign('campo1','Rango de Fechas de Carga:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campo3','HASTA:');
$smarty->assign('campo4','N&uacute;mero de Factura:');
$smarty->assign('campo5','N&uacute;mero de Pedido:');
$smarty->assign('campo6','C&oacute;digo de Planilla:');
$smarty->assign('campo7','Modo de Env&iacute;o:');
$smarty->assign('arrayplus',array('V','N','S'));
$smarty->assign('arraydesplus',array('','IMPRESORA','CORREO'));
$smarty->assign('varfocus','formarcas2.desdec'); 

$smarty->display('m_veribusfon.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();
?>
