<?php
ob_start();
// *************************************************************************************
// Programa: z_gbclave.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stzusuar";
$tbname_2 = "stzhispw";
$fecha1   = hoy();

$smarty->assign('subtitulo','Mantenimiento de Claves Historicas');
//$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($usuario!='rmendoza') {
  if ($usuario!='ngonzalez') {	 
    Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  }  
}  

//Verificando conexion
$sql->connection();

//Verifica si el programa esta en mantenimiento
$manphp = vman_php("z_gbclave.php");
if ($manphp==1)  {
  MensageError('AVISO: Modulo en Mantenimiento temporalmente ...!!!','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

// Obtencion de los Registros o Filas   
$resultado   = pg_exec("SELECT * FROM $tbname_1"); 
$filas_found = pg_numrows($resultado);
if ($filas_found==0) {
  Mensajenew("ERROR: La Tabla de Usuarios esta Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); }

$filas_found = 0;
$ins_user = 0;
// Comienzo de Transaccion 
pg_exec("BEGIN WORK");
echo "Son = $filas_found ";
$reg=pg_fetch_array($resultado);
for($cont=0;$cont<$filas_found;$cont++) {
  $vclave   = trim($reg['pass']);
  $vusuario = trim($reg['usuario']);
  $fechaing = $reg['fecha_ing'];
  $horactual= hora(); 

  $columna_str = "cntrlpwd,usuario,pass,fecha_pass,hora_pass";
  $insert_str  = "nextval('stzhispw_cntrlpwd_seq'),'$vusuario','$vclave','$fechaing','$horactual'";
  $ins_clave   = $sql->insert("$tbname_2","$columna_str","$insert_str","");
  if ($ins_clave) {}
  else { $ins_user = $ins_user + 1; }
  $reg=pg_fetch_array($resultado);
}
echo "despues del ciclo = $ins_user ";
// Verificacion y actualizacion real de los Datos en BD 
if ($ins_user==0) {
  pg_exec("COMMIT WORK"); 
    
  //Desconexion de la Base de Datos
  $sql->disconnect();
  Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","../index1.php","S");
  $smarty->display('pie_pag.tpl'); exit(); }

else {
  pg_exec("ROLLBACK WORK");

  //Desconexion de la Base de Datos
  $sql->disconnect();

  Mensajenew("ERROR: Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","../index1.php","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

?>
