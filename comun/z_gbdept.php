<?php
ob_start();
// *************************************************************************************
// Programa: z_gbdepto.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_i = "stzdepto";

//Validacion de Entrada
$codigo   = $_POST["codigo"];
$nombre   = $_POST["nombre"];
$usuario  = $_POST["usuario"];
$nconex   = $_POST['nconex'];
$na_conex = $_POST['na_conex'];

$smarty->assign('titulo','Modulo de Acceso');
$smarty->assign('subtitulo','Mantenimiento de Unidades / Ingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de que los campos requeridos esten llenos...
$req_fields = array("codigo","nombre");
$valores = array($codigo,$nombre);
$vacios = check_empty_fields();
if (!$vacios) { 
  mensajenew("Hay Informacion en el formulario requerida que esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); 
  }

//Verificación del Codigo
$obj_query = $sql->query("SELECT * FROM $tbname_i WHERE cod_depto='$codigo'");
if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_i ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found != 0) {
   mensajenew("Codigo de Unidad YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");

//Inserto Datos en la tabla de Departamentos
$insert_str = "'$codigo','$nombre'";
$ins_unid = $sql->insert("$tbname_i","","$insert_str","");

// Verificacion y actualizacion real de los Datos en BD 
if ($ins_unid) {
  pg_exec("COMMIT WORK"); 
    
  //Desconexion de la Base de Datos
  $sql->disconnect();
  Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","../comun/z_ingdep.php?conx=0&na_conex=$na_conex&nconex=$nconex","S");
  $smarty->display('pie_pag.tpl'); exit(); }

else {
  pg_exec("ROLLBACK WORK");

  //Desconexion de la Base de Datos
  $sql->disconnect();

  if (!$ins_unid)  { $error_unid  = " - Unidades "; } 
  mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_unid ...!!!","z_unidad.php","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

?>
