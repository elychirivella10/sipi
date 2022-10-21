<?php
// ************************************************************************************* 
// Programa: z_elimunid.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");

//Variables  
$idcod=$_POST['elimina'];

$nbtabla1="stzdepto";
$nbtabla2="stzusuar";
$sql = new mod_db();

//echo "entro eliminar= $idcod ";

exit;
//Verificando conexion
$sql->connection();
 
// Verificacion en Tabla si no posee Usuarios Asignados...  
$obj_query = $sql->query("SELECT * FROM $nbtabla2 WHERE cod_depto='$vopc'");
if ($obj_query) { 
  $filas_found = $sql->nums('',$obj_query); }
  if ($filas_found==0) {
    $result = $sql->del($nbtabla1,"cod_depto='$idcod'"); }

//Desconexion de la Base de Datos
$sql->disconnect();

//header ("Location: z_unidad.php");
?>
