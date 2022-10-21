<?php
// *************************************************************************************
// Programa: z_rptuser.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010 I Semestre BD Relacional
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$login  = $_SESSION['usuario_login'];
$fecha  = fechahoy();
$modulo = "z_rptuser.php";
$sql    = new mod_db();

$tbname1 = "stzusuar";
$tbname2 = "stzdepto";
$tbname3 = "stzroles";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
$vopc   = $_GET['vopc']; 

$nombre   = trim($_POST['nombre']);
$email    = trim($_POST['email']);
$depto_id = $_POST['depto_id'];
$estado   = $_POST['estado'];
$unidad   = $_POST['unidad'];
$vuser    = $_POST['vuser'];
$cedula   = $_POST['cedula'];

$smarty->assign('titulo','Administraci&oacute;n de Usuarios');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($login);

// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  $opra='C'; 
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

if ($vopc==2) {
  if ((empty($vuser)) && (empty($cedula))) {
    Mensajenew("AVISO: NO Introdujo C&eacute;dula o C&oacute;digo del Usuario ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  //Verificación del valor
  if (!empty($vuser)) {
    $obj_query = $sql->query("SELECT * FROM $tbname1 WHERE usuario='$vuser'"); }
  if (!empty($cedula)) {
    $obj_query = $sql->query("SELECT * FROM $tbname1 WHERE cedula='$cedula'"); }

  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found == 0) {
    mensajenew("AVISO: Cedula o Codigo del Usuario NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $objs      = $sql->objects('',$obj_query);
  $cedula    = trim($objs->cedula);
  $nombre    = trim($objs->nombre);
  $email     = trim($objs->email);
  $vuser     = trim($objs->usuario);
  $rol       = trim($objs->role);
  $fecha_ing = $objs->fecha_ing;
  $hora_ing  = $objs->hora_ing;
  $id_estado = $objs->estatus;
  $depto_id  = $objs->cod_depto;
  $estado    = "Activo";
  if ($id_estado!=1) { $estado="Inactivo"; }
  $ingreso   = $objs->fecha_ing." - ".$objs->hora_ing;

  //Obtención de los Departamentos 
  $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE cod_depto='$depto_id'");
  if (!$obj_query) { 
    Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("ERROR: Tabla de Departamentos Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $objs = $sql->objects('',$obj_query);
  $unidad=trim($objs->nombre);

  $obj_query = $sql->query("SELECT * FROM $tbname3 WHERE role='$rol'");
  $objs        = $sql->objects('',$obj_query);
  $namrol      = trim($objs->nombre); 
  $descripcion = trim($objs->descripcion); 
  $creacion   = $objs->fecha_crea." - ".$objs->hora_crea;

  $smarty->assign("modo2","readonly");

  //Desconexion de la Base de Datos
  $sql->disconnect();

}

$smarty->assign('campo1','C&oacute;digo de Usuario:');
$smarty->assign('campo2','Nro. de C&eacute;dula:');
$smarty->assign('campo3','Nombre completo:');
$smarty->assign('campo4','E-Mail:');
$smarty->assign('campo5','Ubicacion:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Rol:');
$smarty->assign('campo8','Descripci&oacute;n:');
$smarty->assign('campo9','Creaci&oacute;n Rol:');
$smarty->assign('campo10','Ingreso al Sistema:');


$smarty->assign('cedula',$cedula);
$smarty->assign('nombre',$nombre);
$smarty->assign('email',$email);
$smarty->assign('vuser',$vuser);
$smarty->assign('depto_id',$depto_id);
$smarty->assign('estado',$estado);
$smarty->assign('id_estado',$id_estado);
$smarty->assign('unidad',$unidad);
$smarty->assign('rol',$rol);
$smarty->assign('namrol',$namrol); 
$smarty->assign('descripcion',$descripcion);
$smarty->assign('creacion',$creacion);
$smarty->assign('ingreso',$ingreso);

$smarty->assign('varfocus','forcronol.vuser'); 
$smarty->display('z_rptpusuar.tpl');
$smarty->display('pie_pag.tpl');
?>
