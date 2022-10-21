<?php
// *************************************************************************************
// Programa: z_rptconpet.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2017 I Semestre
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
$smarty->assign('subtitulo','Auditor&iacute;a de B&uacute;squedas Peticionario WEBPI');
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
//Orden 
$arrayorden[0]='Pedido';
$arrayorden[1]='Factura';


//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas Factura:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campo3','HASTA:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Rango de Fechas de Carga:');
$smarty->assign('campo6','Sede:');
$smarty->assign('campo7','Prioridad:');
$smarty->assign('campo8','N&uacute;mero de Factura:');
$smarty->assign('campo9','C&oacute;digo de Planilla:');
$smarty->assign('campo10','Modo de Env&iacute;o:');
$smarty->assign('campo11','Ordenado por No.:');
$smarty->assign('campo12','Procesadas:');

$smarty->assign('arraytipom',array('T','B','A'));
$smarty->assign('arraynotip',array('AMBAS','NORMAL','HABILITADA'));
$smarty->assign('arrayplus',array('N','T','I','C'));
$smarty->assign('arraydesplus',array('','TODAS','IMPRESORA','CORREO'));
$smarty->assign('arraytipop',array('T','S','N'));
$smarty->assign('arraydescp',array('AMBAS','SI','NO'));
$smarty->assign('varfocus','formarcas2.fechfon1'); 
$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('tipo_or',0);

$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);

$smarty->display('z_rptconpet.tpl');
$smarty->display('pie_pag.tpl');
?>
