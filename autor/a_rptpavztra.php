<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "a_rptpavztra.php";

//Encabezados
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Muestra el evento
$resevento=pg_exec("SELECT stdevobr.evento,stdevobr.descripcion FROM stdevobr ORDER BY evento");
$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<$filas_res_evento;$cont++) 
  { 
    $arrayevento[$cont]=$regeve['evento'];
    //$arraydescri[$cont]=substr($regeve['descripcion'],0,70);
    $arraydescri[$cont]=sprintf("%03d",$regeve['evento'])." ".substr($regeve['descripcion'],0,70);
    $regeve = pg_fetch_array($resevento);
  }

//Orden 
$arrayorden[0]='solicitud';
$arrayorden[1]='fecha_event';
$arrayorden[2]='fecha_trans';

//Paso de variables de datos
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('evento',0);

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('orden',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Transaccion:');
$smarty->assign('campo7','DESDE:');
$smarty->assign('campo8','HASTA:');
$smarty->assign('campo1','Rango de Fechas de Evento:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo3','Evento:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo9','Ordenada por:');

$smarty->assign('varfocus','foravztra.desdec'); 
$smarty->display('a_rptpavztra.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
