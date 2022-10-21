<?php
// *************************************************************************************
// Programa: z_consunid.php 
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
$login    = $_SESSION['usuario_login'];
$sql      = new mod_db();
$fecha    = fechahoy();
$tbname1  = "stzdepto";
$tbname2  = "stzusuar";
$tbname3  = "stzroles";
$modulo   = "z_consunid.php";

// Obtencion de variables de los campos del tpl 
$vunid  = $_GET['vunid'];
$vmodo  = $_GET['vmod'];
$vtip   = $_GET['vtip'];
$vmodal = $_GET['vmodal'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];

$n_conex = $_POST['n_conex'];
$navega  = $_POST['navega'];

$smarty->assign('titulo','M&oacute;dulo de Configuraci&oacute;n');
$smarty->assign('subtitulo','Consulta de Unidad / Departamento');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($navega=='S') { 
  $salir=1; 
  $nconex=$n_conex; 
  $vmodal = $_POST['vmodal'];
  $smarty->assign('na_conex',$nconex); }

if ($conx==0) { $salir=1; $smarty->assign('na_conex',$nconex); }
else {
  if ($conx==1) {
    $na_conex = $_GET['na_conex']; 
    $smarty->assign('n_conex',$na_conex);
  }
  else {
    if ($conx==2) { $salirphp = salirconx($nconex); 
    $res_conex = insconex($login,$modulo,'C');
    $smarty->assign('n_conex',$res_conex); }
  }
}    

if ($vopc==2) {
  $salir = 1;
  $nconex = $_POST['n_conex'];
  $smarty->assign('n_conex',$nconex);
}

if (($salir==0) && ($nconex>0)) {
  $salirphp = salirconx($nconex);
}

$smarty->assign('vmodal',$vmodal);

//Paginacion 
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";

$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total  = $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 6;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['inicio'] = $inicio;
$hiddenvars['cuanto'] = $cuanto;
$hiddenvars['total']  = $total;

if ($vtip==2) {
  $vunid = $_POST['vunid']; }

if (empty($vunid)) {
  Mensajenew("C&oacute;digo de Unidad Vacio ...!","../comun/z_unidad.php?conx=0&na_conex=$nconex&nconex=0","S");
  $smarty->display('pie_pag.tpl'); exit(); } 

//Verificando conexion
$sql->connection();

$where = " cod_depto=".$vunid;

 $filasfound = 0;
 $obj_query = $sql->query("SELECT * FROM $tbname1 WHERE cod_depto='$vunid'");
 if ($obj_query) { 
   $filasfound = $sql->nums('',$obj_query); 
   if ($filasfound==1) {
     $objs     = $sql->objects('',$obj_query);
     $vunidad  = trim($objs->nombre); 
     $vcreacion= $objs->fecha_crea." - ".$objs->hora_crea;

     //Obtencion de los Usuarios perteneciente a la Unidad o Departamento
     $resultado   = pg_exec("SELECT stzusuar.id,stzusuar.cedula,stzusuar.nombre,stzusuar.usuario,stzusuar.role,stzusuar.estatus,
stzusuar.fecha_ing,stzusuar.hora_ing,stzusuar.fecha_elim,stzusuar.hora_elim FROM stzdepto,stzusuar 
WHERE stzdepto.cod_depto=stzusuar.cod_depto AND stzusuar.cod_depto='$vunid' OFFSET $inicio LIMIT $cuanto"); 
     $cantidad    = pg_exec("SELECT stzusuar.id,stzusuar.cedula,stzusuar.nombre,stzusuar.usuario,stzusuar.role,stzusuar.estatus,
stzusuar.fecha_ing,stzusuar.hora_ing,stzusuar.fecha_elim,stzusuar.hora_elim FROM stzdepto,stzusuar 
WHERE stzdepto.cod_depto=stzusuar.cod_depto AND stzusuar.cod_depto='$vunid'");
     $total       = pg_numrows($cantidad);
     $filas_user = pg_numrows($resultado);
     if ($total==0) {
       $vusuario = "La Unidad No tiene Usuario(s) asignado(s)";
       Mensajenew("La Tabla de Unidades o Usuarios esta Vacia ...!","../comun/z_unidad.php?conx=0&na_conex=$nconex&nconex=0","S");
       $smarty->display('pie_pag.tpl'); exit(); }
    
     $cont = 0;
     $arr_user = array();
     $reg=pg_fetch_array($resultado);
     for($cont=0;$cont<$filas_user;$cont++) {
       $arr_user1[$cont] = $reg['id'];
       $arr_user2[$cont] = $reg['cedula'];
       $arr_user3[$cont] = trim($reg['nombre']);
       $arr_user4[$cont] = trim($reg['usuario']);
       $arr_user5[$cont] = trim($reg['role']);
       $arr_user6[$cont] = $reg['estatus'];
       $arr_user7[$cont] = $reg['fecha_ing']." - ".$reg['hora_ing'];
       $arr_user8[$cont] = $reg['fecha_elim']." - ".$reg['hora_elim'];
       $reg=pg_fetch_array($resultado);
     }
     $smarty->assign('arr_user1',$arr_user1);
     $smarty->assign('arr_user2',$arr_user2); 
     $smarty->assign('arr_user3',$arr_user3); 
     $smarty->assign('arr_user4',$arr_user4); 
     $smarty->assign('arr_user5',$arr_user5); 
     $smarty->assign('arr_user6',$arr_user6); 
     $smarty->assign('arr_user7',$arr_user7); 
     $smarty->assign('arr_user8',$arr_user8); 
     $smarty->assign('vnumrows',$filas_user);

     $minprev = min($inicio, $cuanto);
     $minsig  = min(($total - ($inicio + $cuanto)), $cuanto);
     $inicial = min($inicio + $cuanto, $total);
     $smarty->assign('minprev',$minprev);
     $smarty->assign('minsig',$minsig);
     $smarty->assign('inicial',$inicial); 

   }
 }

$smarty->assign('campo1','C&oacute;digo.');
$smarty->assign('campo2','Nombre Unidad:');
$smarty->assign('campo3','Creaci&oacute;n');
$smarty->assign('modo','readonly');

$smarty->assign('inicio',$inicio);
$smarty->assign('cuanto',$cuanto);
$smarty->assign('total',$total);
$smarty->assign('vunid',$vunid);
$smarty->assign('vunidad',$vunidad);
$smarty->assign('vcreacion',$vcreacion);
$smarty->assign('nconex',$nconex);
$smarty->assign('vtip',$vtip);

$smarty->display('z_consunid.tpl');
$smarty->display('pie_pag.tpl');
?>
