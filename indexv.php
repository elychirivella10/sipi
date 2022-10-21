<?
//Para trabajar con Operaciones de Bases de Datos de Produccion
include ("setting.inc.php");
require('include.php');

$smarty->assign('titulop','');
$smarty->assign('titulo','');
$smarty->display('encabezado.tpl');

$sql = new mod_db(); 

//Conexion a la Base de Datos  
$sql->connection();   

//Variables 
$tbname_1 = "stzedobd";

// Obtencion del Estado de la Base de Datos  
$obj_query = $sql->query("SELECT * FROM $tbname_1");
if (!$obj_query) { 
  Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensajenew("ERROR:NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$objs = $sql->objects('',$obj_query);
$vestado = $objs->estado;

if ($vestado!=0) {
  echo"<div align='center'>";
  echo "<table><tr><td>";
  echo "<a href='index.php'><img src='mantenimiento.jpg' border='0'>";
  echo "</a></td></tr></table></div>"; }
else {  
  require ('index_acc.php'); }
   
$smarty->display('pie_pag.tpl');
?>
