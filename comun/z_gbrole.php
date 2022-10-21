<?php
ob_start();
// *************************************************************************************
// Programa: z_gbrole.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_i = "stzroles";
$fechahoy = hoy();

//Validacion de Entrada
$codigo   = $_POST["codigo"];
$nombre   = $_POST["nombre"];
$descrip  = $_POST["descripcion"];
$usuario  = $_POST["usuario"];
$nconex   = $_POST['nconex'];
$na_conex = $_POST['na_conex'];

$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Mantenimiento de Roles / Ingreso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de que los campos requeridos esten llenos...
$req_fields = array("codigo","nombre","descripcion");
$valores= array($codigo,$nombre,$descrip);
$vacios = check_empty_fields();
if (!$vacios)
  { 
    Mensajenew("Hay Informacion en el formulario requerida que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

//Verificación del Codigo
$obj_query = $sql->query("SELECT * FROM $tbname_i WHERE role='$codigo'");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_i ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found != 0) {
   Mensajenew("Codigo de Rol YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
 } 

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");

$horactual = hora();

//Inserto Datos en la tabla de Roles
$columnas_str = "role,nombre,estado,descripcion,fecha_crea,hora_crea";
$insert_str = "'$codigo','$nombre','A','$descrip','$fechahoy','$horactual'";
$ins_role = $sql->insert("$tbname_i","$columnas_str","$insert_str","");

// Verificacion y actualizacion real de los Datos en BD 
if ($ins_role) {
  pg_exec("COMMIT WORK"); 
    
  //Desconexion de la Base de Datos
  $sql->disconnect();
  Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","../comun/z_ingrol.php?conx=0&na_conex=$na_conex&nconex=$nconex","S");
  $smarty->display('pie_pag.tpl'); exit(); }

else {
  pg_exec("ROLLBACK WORK");

  //Desconexion de la Base de Datos
  $sql->disconnect();

  if (!$ins_role) { $error_role = " - ROLES "; } 
  mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_role ...!!!","z_roles.php?conx=1&na_conex=$na_conex&nconex=$nconex","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

?>
