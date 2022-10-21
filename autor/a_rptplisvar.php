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
$modulo= "a_rptplisvar.php";

//Encabezados
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Carga el tipo de marca para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='LITERARIAS';
 $arraytipo[2]='ARTE VISUAL';
 $arraytipo[3]='ESCENICAS';
 $arraytipo[4]='MUSICALES';
 $arraytipo[5]='AUDIOVISUALES Y RADIOFONICAS';
 $arraytipo[6]='PROGRAMAS DE COMPUTACION Y BASE DE DATOS';
 $arraytipo[7]='PRODUCIONES FONOGRAFICAS'; 
 $arraytipo[8]='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';
 $arraytipo[9]='ACTOS Y CONTRATOS';

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
    //$arraydescri[$cont]=substr($regeve[descripcion],0,70);
    $arraydescri[$cont]=sprintf("%03d",$regeve['evento'])." ".substr($regeve['descripcion'],0,70);
    $regeve = pg_fetch_array($resevento);
  }

//Estatus
$resestatus=pg_exec("SELECT estatus,descripcion FROM stdstobr ORDER BY estatus");
$cont = 0;
$arrayestatus[$cont]=0;
$arraydescri1[$cont]='';
$filas_res_estatus=pg_numrows($resestatus);
$regest = pg_fetch_array($resestatus);
for($cont=1;$cont<$filas_res_estatus;$cont++) 
  { 
    $arrayestatus[$cont]=$regest['estatus'];
    $arraydescri1[$cont]=sprintf("%03d",$regest['estatus'])." ".substr($regest['descripcion'],0,70);
    $regest = pg_fetch_array($resestatus);
  }

//Orden 
$arrayorden[0]='solicitud';
$arrayorden[1]='registro';
$arrayorden[2]='fecha_event';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);

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
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo9','Tipo de Obra:');
$smarty->assign('varfocus','foravztra.desdec'); 
$smarty->assign('campo10','Ordenada por:');

$smarty->display('a_rptplisvar.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
