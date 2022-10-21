<?php
ob_start();
// *************************************************************************************
// Programa: z_gbuser.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("$include_lib/m_mail.php");

//Variables
$fecha   = fechahoy();
$sql      = new mod_db();
$tbname_i = "stzusuar";
$tbname_2 = "stzhispw";
$ExisUser = 0;
$estado   = 1;
$fecha1   = hoy();
$hora     = hora();
$nivel    = 1;

//Validacion de Entrada
$cedula   = $_POST["cedula"];
$nombre   = $_POST["nombre"];
$email    = $_POST["email"];
$cuenta   = $_POST["cuenta"];
$passwd   = $_POST["passwd"];
$rpasswd  = $_POST["rpasswd"];
$depto_id = $_POST["depto_id"];
$usuario  = $_POST["usuario"];
$nconex   = $_POST['nconex'];
$na_conex = $_POST['na_conex'];

$smarty->assign('subtitulo','Mantenimiento de Usuarios / Ingreso');
//$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de que los campos requeridos esten llenos...
$req_fields = array("cedula","nombre","email","cuenta","passwd","rpasswd","depto_id");
$valores = array($cedula,$nombre,$email,$cuenta,$passwd,$rpasswd,$depto_id);
$vacios = check_empty_fields();
if (!$vacios) { 
    mensajenew("AVISO: Hay Informacion en el formulario Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

//Verificacion del email
$valemail = 0;
$valemail = check_email($email);
if ($valemail==2) { 
  mensajenew("ERROR: La direccion e-mail no es valido ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

//Verificación de la Cedula
$obj_query = $sql->query("SELECT * FROM $tbname_i WHERE cedula='$cedula'");
if (!$obj_query) { 
  mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_i ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found != 0) {
  mensajenew("ERROR: Cedula del Usuario YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

//Verificación de la Cuenta del Usuario
$ExisUser=Ex_user($cuenta);
if ($ExisUser != 0)  {
  mensajenew("ERROR: Cuenta del Usuario YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

//Verificacion del Password
if ($passwd != $rpasswd)  { 
  mensajenew("ERROR: Password o Clave Incorrecto ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

//Uso de md5 para encriptar el password
$clave = md5($passwd);

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");

$turno = "2";
$vsede = "1";
$ins_user = true;
//,'$vsede','$turno' 
//Inserto Datos en la tabla de Usuario
$column_str ="id,cedula,nombre,cod_depto,usuario,pass,role,fecha_ing,hora_ing,estatus,nivel_acceso,email,sede,turno,seguridad,supervisor";
$insert_str = "nextval('stzusuar_id_seq'),'$cedula','$nombre','$depto_id','$cuenta','$clave','','$fecha1','$hora','$estado','$nivel','$email','$vsede','$turno','N','N'";
$ins_user = $sql->insert("$tbname_i","$column_str","$insert_str","");

$ins_clave   = true;
$columna_str = "cntrlpwd,usuario,pass,fecha_pass,hora_pass";
$insert_str  = "nextval('stzhispw_cntrlpwd_seq'),'$cuenta','$clave','$fecha1','$hora'";
$ins_clave   = $sql->insert("$tbname_2","$columna_str","$insert_str","");

// Verificacion y actualizacion real de los Datos en BD 
if (($ins_user) AND ($ins_clave)) {
  pg_exec("COMMIT WORK"); 
    
  //Creacion de Usuario en la Base de Datos
  $res_usr = pg_exec("CREATE USER $cuenta WITH PASSWORD '67890' SUPERUSER NOCREATEDB NOCREATEROLE NOINHERIT LOGIN");
  
  //Desconexion de la Base de Datos
  $sql->disconnect();
  Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","../comun/z_ingusua.php?conx=0&na_conex=$na_conex&nconex=$nconex","S");
  $smarty->display('pie_pag.tpl'); exit(); }

else {
  pg_exec("ROLLBACK WORK");

  //Desconexion de la Base de Datos
  $sql->disconnect();

  if (!$ins_user) { $error_user = " - Usuarios o HIstorico de Claves "; } 
  Mensajenew("ERROR: Falla de Actualizaci&oacute;n de Datos en la BD $error_user ...!!!","z_usuarios.php","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

?>
