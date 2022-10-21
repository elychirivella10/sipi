<?
//Para trabajar con Operaciones de Bases de Datos de Produccion
include ("setting.inc.php");
require('include.php');
//LLamadas a funciones de Libreria 
include ("$include_lib/library.php");

$smarty->display('encabezado_login.tpl');

//Conexion a la Base de Datos  
$sql = new mod_db(); 
$sql->connection();   

//Variables 
$tbname_1 = "stzedobd";

// Obtencion del Estado de la Base de Datos  
$obj_query = $sql->query("SELECT * FROM $tbname_1");
if (!$obj_query) { 
  $vmessage = "AVISO: Problema al intentar realizar la consulta en la Base de Datos o esta NO existe ...!!!";
  echo "<H3><p><img src='imagenes/messagebox_warning.png' align='middle'>$vmessage</p></H3>";
  echo "<input type='image' name='salir' value='Cerrar' onclick='javascript:history.back();' src='imagenes/restore_f2.png' align='middle' border='0'/>";  
  echo "<p align='center'><img src='imagenes/restore_f2.png' border='0' onclick='windows.close();'>Cerrar</p>"; 
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  $vmessage = "ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!";
  echo "<H3><p><img src='imagenes/messagebox_warning.png' align='middle'>$vmessage</p></H3>"; 
  echo "<p align='center'><img src='imagenes/restore_f2.png' border='0' onclick='windows.close();'>Cerrar</p>"; 
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$objs = $sql->objects('',$obj_query);
$vestado = $objs->estado;

if ($vestado==2) {
  echo"<div align='center'>";
  echo "<table><tr><td>";
  echo "<a href='index.php'><img src='mantenimiento.jpg' border='0'>";
  echo "</a></td></tr></table></div>"; }
else {  
  require ('index_acc.php'); }
  
$smarty->display('pie_pag.tpl');
?>
