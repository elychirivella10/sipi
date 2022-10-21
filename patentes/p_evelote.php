<?php
// *************************************************************************************
// Programa: p_evelote.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2006
// Modificado Año 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$role   = $_SESSION['usuario_rol'];
$fecha  = fechahoy();

$sql = new mod_db();
$tbname_1 = "stppatee";
$tbname_2 = "stzevder";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzmigrr";
$tbname_6 = "stzsystem";
$tbname_7 = "stzderec";

$vopc=$_GET['vopc'];
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vuser=$_POST['vuser'];
$vsola=$_POST['vsola'];
$vsolb=$_POST['vsolb'];
$est_id1=$_POST['est_id1'];
$est_id2=$_POST['est_id2'];
$fechat1=$_POST['fechat1'];
$fechat2=$_POST['fechat2'];
$evento_id=$_POST['evento_id'];
$evento_id=$_POST['evento2_id'];
$fechaeven=$_POST['fechaeven'];
$vdoc=$_POST['vdoc'];
$vcomenta=$_POST['vcomenta'];
$documento=$_POST['documento'];

$vsola=$vsol1."-".sprintf("%06d",$vsol2);
$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Actualizacion de Expedientes por Lotes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

//Obtención de los Estatus
$obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE tipo_mp = 'P' ORDER BY estatus");
if (!$obj_query) { 
  mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!','p_evelote.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  mensajenew('La Tabla de Estatus esta Vacia ...!!!','p_evelote.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
$cont = 0;
$arrayest1[$cont]=0;
$arraynom1[$cont]='';
$arrayest2[$cont]=0;
$arraynom2[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
  $arrayest1[$cont]=$objs->estatus-2000;
  $arraynom1[$cont]=sprintf("%03d",$objs->estatus-2000)."  ".substr(trim($objs->descripcion),0,75);
  $arrayest2[$cont]=$objs->estatus-2000;
  $arraynom2[$cont]=sprintf("%03d",$objs->estatus-2000)."  ".substr(trim($objs->descripcion),0,75);
  $objs = $sql->objects('',$obj_query);
}

//Obtención de los Eventos 
$obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE tipo_mp = 'P' ORDER BY evento");
if (!$obj_query) { 
  mensajenew('Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!','p_evelote.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  mensajenew('La Tabla de Eventos esta Vacia ...!!!','p_evelote.php','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
  $arrayevento[$cont]=$objs->evento-2000;
  $arraydescri[$cont]=sprintf("%03d",$objs->evento-2000)."  ".substr(trim($objs->descripcion),0,75);
  $objs = $sql->objects('',$obj_query);
}

//Desconexion de la Base de Datos
$sql->disconnect();

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Rango de Expedientes:');
$smarty->assign('campo2','Evento aplicado:');
$smarty->assign('campo3','En Estatus actual:');
$smarty->assign('campo4','En Estatus anterior:');
$smarty->assign('campo5','Cargados por:');
$smarty->assign('campo6','Fecha de Transaccion:');
$smarty->assign('campo7','con Fecha de Evento:');
$smarty->assign('campo8','con Documento Nro.:');
$smarty->assign('campo9','Evento a aplicar:');
$smarty->assign('campo10','Fecha de Publicacion:');
$smarty->assign('campo11','Fecha de Vencimiento:');

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsola',$vsola);
$smarty->assign('vsolb',$vsolb);
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol3',$vsol3); 
$smarty->assign('vsol4',$vsol4); 
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('evento_id',$evento_id);
$smarty->assign('evento2_id',$evento2_id);
$smarty->assign('arrayest1',$arrayest1);
$smarty->assign('arraynom1',$arraynom1);
$smarty->assign('arrayest2',$arrayest2);
$smarty->assign('arraynom2',$arraynom2);
$smarty->assign('est_id1',$est_id1);
$smarty->assign('est_id2',$est_id2);

$smarty->display('p_evelote.tpl');
$smarty->display('pie_pag.tpl');

?>
