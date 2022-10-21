<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Sesiones
if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpestfon8.php";

//Encabezados
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Listado de Marcas en Estatus 8 pendiente de Fondo o Examen de Registrabilidad');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Operador logico para el pais 
$arrayopelog[0]='=';
$arrayopelog[1]='<>';

//Orden 
//$arrayorden[0]='';
$arrayorden[0]='solicitud';
$arrayorden[1]='fecha_event';
$arrayorden[2]='fecha_trans';
$arrayorden[3]='documento';

//Paso de variables de datos
$smarty->assign('arrayplus',array(1,2));
$smarty->assign('arraydesplus',array('SI','NO'));

$smarty->assign('arraycplus',array(1,2));
$smarty->assign('arraydescplus',array('=','<>'));

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('tipo_or',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Que no tengan el(los) Boletin(es):');
$smarty->assign('campo2','Ordenada por:');

$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->display('m_rptpestfon8.tpl');
$smarty->display('pie_pag.tpl');

?>
