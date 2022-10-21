<?php
ob_start();
// *************************************************************************************
// Programa: z_gbrolus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables
$sql      = new mod_db();
$tbname_i = "stzuserol";
$tbname_1 = "stzusuar";
$fechahoy = hoy();
$fecha    = fechahoy(); 

//Validacion de Entrada
$usuario  = $_POST["usuario"];
$rol_id   = $_POST["rol_id"];
$rol_user = $_POST["rol_user"];
$nconex   = $_POST['nconex'];
$na_conex = $_POST['na_conex'];

$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Mantenimiento de Roles / Asignaci&oacute;n a Usuario');
$smarty->assign('login',$usuario); 
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificacion de que los campos requeridos esten llenos...
$req_fields = array("rol_id");
$valores = array($rol_id);
$vacios = check_empty_fields();
if (!$vacios) { 
  Mensage_Error("Hay Informacion en el formulario requerida que esta Vacia ...");
  $smarty->display('pie_pag.tpl'); exit(); }

//Cuento cuantos usuarios fueron seleccionados
$nousersel = count($rol_user);

//Se verifican si el arreglo trae valores
$selu=0;
for ($cont=0;$cont<$nousersel;$cont++)
 { 
   $val_user = $rol_user[$cont]; 
   if (!empty($val_user)) { $selu=1; }
 }

//Se verifica que hayan elementos seleccionados
if (($rol_id=="0") || ($selu==0)) {
   Mensajenew("Hay Informacion en el formulario requerida que esta Vacia ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); }

//Nos Conectamos a la base de datos
$sql->connection();

// Comienzo de Transaccion 
pg_exec("BEGIN WORK");

$ins_usrol==0; 
$upd_usrol==0;
if ($selu!=0)
 {
  $horahoy = hora(); 
  for ($cont=0;$cont<$nousersel;$cont++)
  { 
    $exuserol = 0;
    $val_user = trim($rol_user[$cont]); 
    $exuserol = Verirolusr($val_user);
    if ($exuserol==0)
     {
       //Inserto Datos en la tabla de Rol por Usuario
       $column_str = "usuario,fecha_role,role,estado,hora_asig";
       $insert_str = "'$val_user','$fechahoy','$rol_id','A','$horahoy'";
       $resinsert  = $sql->insert("$tbname_i","$column_str","$insert_str","");
       if (!$resinsert) { $ins_usrol = $ins_usrol + 1; }
       //Actualizo Datos en la tabla de Usuario
       $update_str = "role='$rol_id'";
       $resupdate  = $sql->update("$tbname_1","$update_str","usuario='$val_user'");
       if (!$resupdate) { $upd_usrol = $upd_usrol + 1; }
     }  
  }  
 }


// Verificacion y actualizacion real de los Datos en BD 
if (($ins_usrol==0) and ($upd_usrol==0)) {
  pg_exec("COMMIT WORK"); 
    
  //Desconexion de la Base de Datos
  $sql->disconnect();
  Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","../comun/z_asgusrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","S");
  $smarty->display('pie_pag.tpl'); exit(); }

else {
  pg_exec("ROLLBACK WORK");

  //Desconexion de la Base de Datos
  $sql->disconnect();

  Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","z_asigrol.php","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

?>
