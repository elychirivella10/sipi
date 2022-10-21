<?php
// *************************************************************************************
// Programa: p_rptcomen.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollo Año: 2010 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "p_rptcomen.php";

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Listado de Observaciones a Solicitud de Patente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Estatus
$resestatus=pg_exec("SELECT estatus,descripcion FROM stzstder WHERE tipo_mp ='P' ORDER BY estatus"); 
$cont = 0;
$arrayestatus[$cont]=0;
$arraydescri1[$cont]='';
$filas_res_estatus=pg_numrows($resestatus);
$regest = pg_fetch_array($resestatus);
for($cont=1;$cont<$filas_res_estatus;$cont++) 
  { 
    $arrayestatus[$cont]=$regest[estatus];
    $arraydescri1[$cont]=sprintf("%03d",($regest[estatus]-2000))." ".substr($regest[descripcion],0,70);
    $regest = pg_fetch_array($resestatus);
  }

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Rango de Fechas de Transacci&oacute;n:');
$smarty->assign('campo3','Usuario:');
$smarty->assign('campo4','Estatus:');
$smarty->assign('varfocus','forcoment.vsol1'); 
$smarty->display('p_rptcomen.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>