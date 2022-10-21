<?php
//Para trabajar con Operaciones de Bases de Datos
//include ("../z_includes.php");

//Llamada a pantalla de inicial
include ("$include_lib/librar_cert.php");

$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Certificados de Registro de Marcas');

$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado.tpl');

//Conexion
$sql = new mod_db();
$sql->connection();

//Se obtiene el valor para el secuencial a guardara partir de stzsistem

//Se obtiene el proximo valor para el secuencial a guardara partir de stzsistem
//$obj_query = $sql->query("update stzsystem set ncertmar=nextval('stzsystem_ncertmar_seq')");

$obj_query=$sql->query("select last_value from stzsystem_ncertmar_seq");
$objs= $sql->objects('',$obj_query);
$ncertmar=$objs->last_value;
 
//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Nro. Registro:');
$smarty->assign('campo2','Nro. Solicitud:');
$smarty->assign('ncertmar',$ncertmar);
$smarty->assign('varfocus','forcertif.vreg1d'); 
$smarty->display('m_certdigt.tpl');
$smarty->display('pie_pag.tpl');

?>
