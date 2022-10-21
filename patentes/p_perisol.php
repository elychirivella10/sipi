<?php
// *************************************************************************************
// Programa: p_perisol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado  II Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos

include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Perenci&oacute;n de Patentes por NO Consignar Publicaci&oacute;n en Prensa x Rango');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario); 

//Carga el Estatus para mostrarlo en el combo
$resestatus=pg_exec("select estatus,descripcion FROM stzstder WHERE tipo_mp ='P' AND estatus in (2004,2005,2011) ORDER BY estatus");

$cont = 0;
$arrayestatus[$cont]=0;
$arraydescri1[$cont]='';
$filas_res_estatus=pg_numrows($resestatus);
$regest = pg_fetch_array($resestatus);
for($cont=1;$cont<=$filas_res_estatus;$cont++) 
  { 
    $arrayestatus[$cont]=$regest[estatus];
    $arraydescri1[$cont]=sprintf("%03d",($regest[estatus]-2000))." ".substr($regest[descripcion],0,70);
    $regest = pg_fetch_array($resestatus);
  }  
  
//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo2','Estatus:');

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus',0);

$smarty->assign('varfocus','forcaduca.vsol1'); 
$smarty->display('p_perisol.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
