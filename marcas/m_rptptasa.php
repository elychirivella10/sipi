<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptptasa.php";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reporte Control de Pagos de Derechos / Marca Concedida');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

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

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Fechas:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campo3','HASTA:');
$smarty->assign('campo4','Evento:');
$smarty->assign('campo5','Bolet&iacute;n:');
$smarty->assign('campo6','Usuario:');
$smarty->assign('campo7','Sede:');
$smarty->assign('campo8','Factura Nro.:');
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 

$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->display('m_rptptasa.tpl');
$smarty->display('pie_pag.tpl');

?>