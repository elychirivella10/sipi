<?php
// *************************************************************************************
// Programa: z_elmrolus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");


if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$login     = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$tbname_1  = "stzroles";
$tbname_2  = "stzusuar";
$tbname_3  = "stzuserol";
$sql       = new mod_db();
$modulo    = "z_elmrolus.php";
$uselecion = 0;

$vopc     = $_GET['vopc'];
$conx     = $_GET['conx'];
$rol_id   = $_GET['valor'];
$nconex   = $_GET['n_conex'];
$salir    = $_POST['salir'];

$na_conex = $_POST['na_conex'];
$totalusr = $_POST["totalusr"];
$idm_user = $_POST["idm_user"];

if ($vopc==2) { $nconex   = $_POST['nconex']; }

if ($conx==0) { 
  $smarty->assign('n_conex',$nconex); 
  $smarty->assign('na_conex',$na_conex); }
else {
  if ($conx==1) {
    $salir=1;
    $res_conex = insconex($login,$modulo,'E');
    $smarty->assign('n_conex',$res_conex);
    $na_conex = $nconex; 
    $smarty->assign('na_conex',$na_conex); }
}    

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
  $smarty->assign('n_conex',$na_conex); 
}

$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Administraci&oacute;n de Usuarios por Rol');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('modo1','');
$smarty->assign('modo2','readonly');

//Obtención de los Roles
$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","../comun/z_asigrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
    Mensajenew("Tabla de Roles Vacia ...!!!","../comun/z_asigrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$arrayrole[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arrayrole[$cont]=$objs->role;
    $arraynombre[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }

if ($vopc==1) {
  $smarty->assign('modo1','readonly');
  $smarty->assign('modo2','');
  $smarty->assign('campo2','Usuarios a Eliminar: ');

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("rol_id");
  $valores = array($rol_id);
  $vacios = check_empty_fields();
  if (!$vacios) { 
    Mensajenew("Hay Informacion en el formulario Vacia ...!!!","javascript:history.back();","N");    
    $smarty->display('pie_pag.tpl'); exit(); }
  
  //Obtención de los Usuarios asignados el Rol
  $totalusr=0;
  $obj_query = $sql->query("SELECT usuario,nombre FROM $tbname_2 where role='$rol_id' and estatus='1' order by nombre");
  if (!$obj_query) { 
      Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","../comun/z_asigrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");
      $smarty->display('pie_pag.tpl'); 
      $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);

  $totalusr=$filas_found;
  if ($filas_found>0) {
  $cont = 0;
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
      $uarraylogins[$cont]=$objs->usuario;
      $uarraynombre[$cont]=$objs->usuario." - ".trim($objs->nombre);
      $objs = $sql->objects('',$obj_query);
  }
  }

  if ($filas_found==0) { 
    Mensajenew("El Rol $rol_id NO posee usuarios asociados ...!!!","../comun/z_asigrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}

if ($vopc==2) {
  $rol_id   = $_POST['rol_id'];
  $nconex   = $_POST['nconex'];
  $na_conex = $_POST['na_conex'];

  $fechahoy = hoy();
  //Cuento cuantos usuarios fueron seleccionados
  $uselecion = count($idm_user);

  //Se verifica si el arreglo trae valor
  $selu=0;
  for ($cont=0;$cont<$uselecion;$cont++)
  { 
     $val_user= $idm_user[$cont];
     if (!empty($val_user)) { $selu=1; }
  }

  //Se verifica que hayan elementos seleccionados
  if (($rol_id=="0") || ($selu==0)) {
    Mensajenew("Hay Informacion en el formulario Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $hora = hora();
  // Eliminacion de Eventos de Marcas asociados al Rol seleccionado
  $elm1_usr = 0;
  $elm2_usr = 0;
  if ($selu!=0) {
    for ($cont=0;$cont<$uselecion;$cont++) { 
      $val_user= $idm_user[$cont];
      //if ($idm_user[$cont].checked==true) { echo " provea evento=$val_user "; }
      $update_str = "role='',estatus='2',fecha_elim='$fechahoy',hora_elim='$hora'";
      $upd_usrol  = $sql->update("$tbname_2","$update_str","usuario='$val_user' and estatus='1'");
      $update_str = "estado='E',fecha_elim='$fechahoy',hora_elim='$hora'";
      $del_usrol  = $sql->update("$tbname_3","$update_str","usuario='$val_user' and estado='A'");
      if (!$upd_usrol) { $elm1_usr = $elm1_usr + 1; }  
      if (!$del_usrol) { $elm2_usr = $elm2_usr + 1; }  
    }  
  }

  // Verificacion y actualizacion real de los Datos en BD 
  if (($elm1_usr==0) && ($elm2_usr==0)) {
    pg_exec("COMMIT WORK"); 
    
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew("DATOS ELIMINADOS CORRECTAMENTE...!","../comun/z_asigrol.php?conx=1&na_conex=$na_conex&nconex=$nconex&salir=0","S");
    $smarty->display('pie_pag.tpl'); exit(); }

  else {
    pg_exec("ROLLBACK WORK");

    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","z_asigrol.php?conx=0&na_conex=$nconex&nconex=$nconex&salir=0","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

}

$smarty->assign('arrayrole',$arrayrole);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('rol_id',$rol_id);
$smarty->assign('uarraylogins',$uarraylogins);
$smarty->assign('uarraynombre',$uarraynombre);
$smarty->assign('login_id',0);
$smarty->assign('totalusr',$totalusr);
$smarty->assign('na_conex',$na_conex);
$smarty->assign('campo1','Role:');
$smarty->assign('varfocus','forrole.rol_id'); 

$smarty->display('z_elmrolus.tpl');
$smarty->display('pie_pag.tpl');
?>
