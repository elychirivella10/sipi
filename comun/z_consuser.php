<?php
// *************************************************************************************
// Programa: z_consuser.php 
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
$tbname1  = "stzusuar";
$tbname2  = "stzdepto";
$tbname3  = "stzroles";
$tbname4  = "stzconex";
$modulo   = "z_consuser.php";

// Obtencion de variables de los campos del tpl 
$vuser  = $_GET['vuser'];
$vmodo  = $_GET['vmod'];
$vtip   = $_GET['vtip'];
$vmodal = $_GET['vmodal'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];

$n_conex = $_POST['n_conex'];
$navega  = $_POST['navega'];

$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Consulta de Usuario');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($navega=='S') { 
  $salir=1; 
  $nconex = $n_conex; 
  $vmodal = $_POST['vmodal'];
  $vmodo  = $_POST['vmodo'];
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
  $cuanto = 10;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['inicio'] = $inicio;
$hiddenvars['cuanto'] = $cuanto;
$hiddenvars['total']  = $total;

if ($vtip==2) {
  $vuser = $_POST['vuser']; }

if (empty($vuser)) {
  Mensajenew("C&oacute;digo de Usuario Vacio ...!!!","../comun/z_usuarios.php?conx=0&na_conex=$nconex&nconex=0","S");
  $smarty->display('pie_pag.tpl'); exit(); } 

//Verificando conexion
$sql->connection();

if ($vmodo=='id')      { $where = "id=".$vuser; }
if ($vmodo=='cedula')  { $where = "cedula=".$vuser; }  
if ($vmodo=='usuario') { $where = "usuario='".$vuser."'"; }  

 $filasfound = 0;
 $obj_query = $sql->query("SELECT * FROM $tbname1 WHERE $where");
 if ($obj_query) { 
   $filasfound = $sql->nums('',$obj_query); 
   if ($filasfound==1) {
     $objs     = $sql->objects('',$obj_query);
     $id       = $objs->id;
     $cedula   = $objs->cedula;
     $nombre   = trim($objs->nombre);
     $email    = trim($objs->email);
     $depto_id = $objs->cod_depto;
     $usuario  = trim($objs->usuario);
     $role     = trim($objs->role);
     $estatus  = $objs->estatus;
     $ingreso  = $objs->fecha_ing." - ".$objs->hora_ing;
     $elimina  = $objs->fecha_elim." - ".$objs->hora_elim;

     //Obtencion del Nombre de la Ubicacion o Departamento
     $obj_query = $sql->query("SELECT * FROM $tbname2 WHERE cod_depto='$depto_id'");
     $filas_found=$sql->nums('',$obj_query);
     if ($filas_found = 0) { $vunidad = "No tiene Unidad asignado"; }
     else {
       $objs = $sql->objects('',$obj_query);
       $vunidad = trim($objs->nombre); }

     //Obtencion del Nombre del Role 
     $obj_query = $sql->query("SELECT * FROM $tbname3 WHERE role='$role'");
     $filas_found=$sql->nums('',$obj_query);
     if ($filas_found = 0) { $vnbrol = "No tiene Rol asignado"; }
     else {
       $objs = $sql->objects('',$obj_query);
       $vnbrol = trim($objs->nombre);
       $desrol = trim($objs->descripcion); }
     
     $resultado   = pg_exec("SELECT * FROM stzconex WHERE usuario='$usuario' ORDER BY fecha_conex desc,conex desc OFFSET 0 LIMIT 10"); 
     $cantidad    = pg_exec("SELECT * FROM stzconex WHERE usuario='$usuario'");
     $total       = pg_numrows($cantidad);
     $filas_conex = pg_numrows($resultado);
     //if ($total==0) {
     //  if ($vmodal==1) {
     //    $vmensaje = "La Tabla de Conexiones esta Vacia ...!!!";
     //    MsgErrorCerrar($vmensaje); }
     //  else {
     //    Mensajenew("La Tabla de Conexiones esta Vacia ...!","../comun/z_usuarios.php?conx=1&na_conex=$nconex&nconex=0","S"); }
     //  $smarty->display('pie_pag.tpl'); exit(); }
    
     $cont = 0;
     $arr_user = array();
     $reg=pg_fetch_array($resultado);
     for($cont=0;$cont<$filas_conex;$cont++) {
       $arr_conx10[$cont] = $reg['conex'];
       $arr_conx11[$cont] = $reg['fecha_conex'];
       $arr_conx12[$cont] = $reg['modulo'];
       $arr_conx13[$cont] = $reg['oper'];
       $arr_conx14[$cont] = $reg['hora_entrada'];
       $arr_conx15[$cont] = $reg['hora_salida'];
       $reg=pg_fetch_array($resultado);
     }
     $smarty->assign('arr_conx10',$arr_conx10);
     $smarty->assign('arr_conx11',$arr_conx11);
     $smarty->assign('arr_conx12',$arr_conx12);
     $smarty->assign('arr_conx13',$arr_conx13);
     $smarty->assign('arr_conx14',$arr_conx14);
     $smarty->assign('arr_conx15',$arr_conx15);
     $smarty->assign('vrowshow',10);

     $resultado   = pg_exec("SELECT * FROM $tbname4 WHERE usuario='$usuario' ORDER BY fecha_conex desc,conex desc OFFSET $inicio LIMIT $cuanto"); 
     $cantidad    = pg_exec("SELECT * FROM $tbname4 WHERE usuario='$usuario'");
     $total       = pg_numrows($cantidad);
     $filas_conex = pg_numrows($resultado);
       
     //if ($total==0) {
     //  Mensajenew("La Tabla de Conexiones esta Vacia ...!!!","javascript:history.back();","N");
     //  $smarty->display('pie_pag.tpl'); exit(); }
    
     $cont = 0;
     $arr_user = array();
     $reg=pg_fetch_array($resultado);
     for($cont=0;$cont<$filas_conex;$cont++) {
       $arr_conx1[$cont] = $reg['conex'];
       $arr_conx2[$cont] = $reg['fecha_conex'];
       $arr_conx3[$cont] = $reg['modulo'];
       $arr_conx4[$cont] = $reg['oper'];
       $arr_conx5[$cont] = $reg['hora_entrada'];
       $arr_conx6[$cont] = $reg['hora_salida'];
       $reg=pg_fetch_array($resultado);
     }

     $smarty->assign('id',$id);
     $smarty->assign('cedula',$cedula);
     $smarty->assign('nombre',$nombre);
     $smarty->assign('depto_id',$depto_id);
     $smarty->assign('vunidad',$vunidad);
     $smarty->assign('email',$email);
     $smarty->assign('usuario',$usuario);
     $smarty->assign('rol',$role);
     $smarty->assign('vnbrol',$vnbrol);
     $smarty->assign('desrol',$desrol);
     $smarty->assign('estatus',$estatus);
     $smarty->assign('ingreso',$ingreso);
     $smarty->assign('elimina',$elimina);

     $smarty->assign('arr_conx1',$arr_conx1);
     $smarty->assign('arr_conx2',$arr_conx2);
     $smarty->assign('arr_conx3',$arr_conx3);
     $smarty->assign('arr_conx4',$arr_conx4);
     $smarty->assign('arr_conx5',$arr_conx5);
     $smarty->assign('arr_conx6',$arr_conx6);
     $smarty->assign('vnumrows',$filas_conex);

     $minprev = min($inicio, $cuanto);
     $minsig  = min(($total - ($inicio + $cuanto)), $cuanto);
     $inicial = min($inicio + $cuanto, $total);
     $smarty->assign('minprev',$minprev);
     $smarty->assign('minsig',$minsig);
     $smarty->assign('inicial',$inicial); 

   }
 }

$smarty->assign('campo1','Id.');
$smarty->assign('campo2','Nombre completo:');
$smarty->assign('campo3','No. Cedula');
$smarty->assign('campo4','Cuenta:');
$smarty->assign('campo5','E-Mail:');
$smarty->assign('campo6','Ubicaci&oacute;n:');
$smarty->assign('campo7','Rol:');
$smarty->assign('campo8','Descripci&oacute;n Rol:');
$smarty->assign('campo9','Estatus:');
$smarty->assign('campo10','Ingreso:');
$smarty->assign('modo','readonly');

$smarty->assign('inicio',$inicio);
$smarty->assign('cuanto',$cuanto);
$smarty->assign('total',$total);
$smarty->assign('vuser',$vuser);
$smarty->assign('vmodo',$vmodo);
$smarty->assign('nconex',$nconex);
$smarty->assign('vtip',$vtip);

$smarty->display('z_consuser.tpl');
$smarty->display('pie_pag.tpl');
?>
