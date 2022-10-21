<?php
// *************************************************************************************
// Programa: z_rptroles.php 
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
$modulo = "z_rptroles.php";
$sql    = new mod_db();

$tbname1 = "stzroles";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
$vopc   = $_GET['vopc']; 

$vrol        = $_POST['vrol']; 
$nombre      = trim($_POST['nombre']);
$descripcion = trim($_POST['descripcion']);
$fechac      = $_POST['fecha_crea'];
$horac       = $_POST['hora_crea'];
$estado      = $_POST['estado'];

$smarty->assign('titulo','M&oacute;dulo de Configuraci&oacute;n');
$smarty->assign('subtitulo','Administraci&oacute;n de Roles - Consulta/Reporte');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');


//echo "&#1051; o &#x41B &#1083; o &#x43B;";

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

//Obtención de los Roles
$obj_query = $sql->query("SELECT * FROM $tbname1 order by role");
if (!$obj_query) { 
    mensajenew("AVISO: Problema al intentar realizar la consulta en la tabla $tbname1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
    mensajenew("ERROR: Tabla de Roles Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
$arrayrole[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $arrayrole[$cont]=$objs->role;
    $arraynombre[$cont]=trim($objs->nombre)." -- ".$objs->role;
    $objs = $sql->objects('',$obj_query);
  }

if ($vopc==2) {
  if (empty($vrol)) {
    Mensajenew("AVISO: NO selecciono ning&uacute;n C&oacute;digo del Rol ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  //Verificación del valor
  if (!empty($vrol)) {
    $obj_query = $sql->query("SELECT * FROM $tbname1 WHERE role='$vrol'"); }

  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found == 0) {
    mensajenew("AVISO: Codigo del Rol NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $objs        = $sql->objects('',$obj_query);
  $nombre      = trim($objs->nombre); 
  $descripcion = trim($objs->descripcion); 
  $creacion    = $objs->fecha_crea." - ".$objs->hora_crea;
  $id_estado   = $objs->estado;
  $estado      = "Activo";
  if ($id_estado!="A") { $estado="Inactivo"; }

  $smarty->assign("modo2","readonly");

  //Desconexion de la Base de Datos
  $sql->disconnect();

}

$smarty->assign('campo1','C&oacute;digo del Rol:');
$smarty->assign('campo2','Nombre Rol:');
$smarty->assign('campo3','Descripci&oacute;n:');
$smarty->assign('campo4','Creaci&oacute;n Rol:');
$smarty->assign('campo5','Estatus:');

$smarty->assign('vrol',$vrol);
$smarty->assign('nombre',$nombre);
$smarty->assign('codigo',$vrol);
$smarty->assign('estado',$estado);
$smarty->assign('descripcion',$descripcion);
$smarty->assign('creacion',$creacion);
$smarty->assign('arrayrole',$arrayrole);
$smarty->assign('arraynombre',$arraynombre);

$smarty->assign('varfocus','forcronol.vrol'); 
$smarty->display('z_rptroles.tpl');
$smarty->display('pie_pag.tpl');
?>


