<script language="javascript">
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: z_asgusrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$fecha    = fechahoy();
$sql      = new mod_db();
$tbname_1 = "stzroles";
$tbname_2 = "stzusuar";
$modulo   = "z_asgusrol.php";

$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Asignaci&oacute;n de Usuarios a Rol');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$vopc     = $_GET['vopc'];
$conx     = $_GET['conx'];
$salir    = $_GET['salir'];
$nconex   = $_GET['nconex'];
$na_conex = $_GET['na_conex'];

if ($conx==0) { 
  $smarty->assign('n_conex',$nconex); 
  $smarty->assign('na_conex',$na_conex); }
else {
    $res_conex = insconex($usuario,$modulo,'I');
    $smarty->assign('n_conex',$res_conex); }

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
  $smarty->assign('n_conex',$na_conex); 
}

//Obtención de los Roles
$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
    mensajenew("Tabla de Roles Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
$arrayrole[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $arrayrole[$cont]=$objs->role;
    $arraynombre[$cont]=trim($objs->nombre)." -/- ".$objs->role;
    $objs = $sql->objects('',$obj_query);
  }

//Obtención de los Usuarios 
$obj_query = $sql->query("SELECT usuario,nombre FROM $tbname_2 WHERE estatus='1' order by nombre");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
$totalevm=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Usuarios Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
//$marrayevento[$cont]=0;
//$marraydescev[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arraylogin[$cont]=$objs->usuario;
    $arrayusuario[$cont]=trim($objs->nombre)." [".trim($objs->usuario)."]";
    $objs = $sql->objects('',$obj_query);
  }


$smarty->assign('arrayrole',$arrayrole);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('rol_id',0);
$smarty->assign('arraylogin',$arraylogin);
$smarty->assign('arrayusuario',$arrayusuario);
$smarty->assign('user_r',0);
$smarty->assign('totalusr',$totalusr);

$smarty->assign('campo1','Role:');
$smarty->assign('campo2','*** USUARIOS ***');
$smarty->assign('varfocus','forevrol.rol'); 
$smarty->assign('login',$usuario);
$smarty->assign('na_conex',$na_conex);

$smarty->display('z_asgusrol.tpl');
$smarty->display('pie_pag.tpl');
?>
