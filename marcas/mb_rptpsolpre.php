<?php

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "mb_rptpsolpre.php";

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Reporte de Solicitudes Formato Bolet&iacute;n por Estatus');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Carga el Estatus para mostrarlo en el combo
$resestatus=pg_exec("SELECT estatus,descripcion FROM stzstder WHERE tipo_mp ='M' ORDER BY estatus");
$cont = 0;
$arrayestatus[$cont]=0;
$arraydescri1[$cont]='';
$filas_res_estatus=pg_numrows($resestatus);
$regest = pg_fetch_array($resestatus);
for($cont=1;$cont<$filas_res_estatus;$cont++) 
  { 
    $arrayestatus[$cont]=$regest[estatus];
    $arraydescri1[$cont]=sprintf("%03d",($regest[estatus]-1000))." ".substr($regest[descripcion],0,70);
    $regest = pg_fetch_array($resestatus);
  }

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Rango de Solicitudes:');
$smarty->assign('campo2','Rango de Registros:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo3','Estatus:');
$smarty->assign('campo4','Fecha de Solicitud:');
$smarty->assign('campo5','Usuario:');

$sql->disconnect();

$smarty->assign('varfocus','forsolpre.vsol1'); 
$smarty->display('mb_rptpsolpre.tpl');
$smarty->display('pie_pag.tpl');

?>
