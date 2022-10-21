<script language="javascript">
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: z_invevrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
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
$tbname_2 = "stzevder";
$tbname_3 = "stpevpar";
$tbname_4 = "stdevobr";
$modulo   = "z_ingevrol.php";

$smarty->assign('titulo',$substacc);
$smarty->assign('subtitulo','Asignaci&oacute;n de Eventos por Rol');
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
    $arraynombre[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención de los Eventos de Marcas
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname_2 WHERE tipo_mp='M' ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
$totalevm=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Marcas Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
//$marrayevento[$cont]=0;
//$marraydescev[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $marrayevento[$cont]=$objs->evento;
    $marraydescev[$cont]=($objs->evento-1000)." ".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención de los Eventos de Patentes
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname_2 WHERE tipo_mp='P' ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
$totalevp=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Patentes Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
//$parrayevento[$cont]=0;
//$parraydescev[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $parrayevento[$cont]=$objs->evento;
    $parraydescev[$cont]=($objs->evento-2000)." ".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query);
}

//Obtención de los Eventos de Derecho de Autor 
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname_4 ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_4 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
$totaleva=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Derecho de Autor Vacia ...!!!","../comun/z_ingevrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
//$aarrayevento[$cont]=0;
//$aarraydescev[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $aarrayevento[$cont]=$objs->evento;
    $aarraydescev[$cont]=$objs->evento." ".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención de los Eventos de IG
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname_2 WHERE tipo_mp='I' ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
$totalevi=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Indicaciones Geograficas Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $iarrayevento[$cont]=$objs->evento;
    $iarraydescev[$cont]=($objs->evento-3000)." ".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query);
  }


$smarty->assign('arrayrole',$arrayrole);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('rol_id',0);
$smarty->assign('marrayevento',$marrayevento);
$smarty->assign('marraydescev',$marraydescev);
$smarty->assign('evento_m',0);
$smarty->assign('parrayevento',$parrayevento);
$smarty->assign('parraydescev',$parraydescev);
$smarty->assign('evento_p',0);
$smarty->assign('aarrayevento',$aarrayevento);
$smarty->assign('aarraydescev',$aarraydescev);
$smarty->assign('evento_a',0);
$smarty->assign('iarrayevento',$iarrayevento);
$smarty->assign('iarraydescev',$iarraydescev);
$smarty->assign('evento_i',0);
$smarty->assign('totalevm',$totalevm);
$smarty->assign('totalevp',$totalevp);
$smarty->assign('totaleva',$totaleva);
$smarty->assign('totalevi',$totalevi);

$smarty->assign('campo1','Role:');
$smarty->assign('campo2','*** EVENTOS DE MARCAS ***');
$smarty->assign('campo3','*** EVENTOS DE PATENTES ***');
$smarty->assign('campo4','*** EVENTOS DE DERECHO DE AUTOR ***');
$smarty->assign('campo5','*** EVENTOS DE INDICACIONES GEOGRAFICAS ***');

$smarty->assign('varfocus','forevrol.rol'); 
$smarty->assign('login',$usuario);
$smarty->assign('na_conex',$na_conex);

$smarty->display('z_ingevrol.tpl');
$smarty->display('pie_pag.tpl');
?>
