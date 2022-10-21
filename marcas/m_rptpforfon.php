<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Sesiones
if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpforfon.php";

//Encabezados
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Consulta/Reporte de Decisiones Forma/Fondo Marcas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Estatus
$resestatus=pg_exec("select estatus,descripcion from stzstder where tipo_mp ='M' order by estatus");

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


//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arraytipom',array(V,C,D,F,B));
$smarty->assign('arraynotip',array('','CONCEDIDA','DETENIDA','SIN DECISION','BLANCO'));

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Decision:');
$smarty->assign('campo9','DESDE:');
$smarty->assign('campo8','HASTA:');
$smarty->assign('campo5','Estatus Actual:');
$smarty->assign('campo10','Tipo de Decision:');

$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->display('m_rptpforfon.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
