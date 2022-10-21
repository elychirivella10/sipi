<?php
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
$modulo= "p_rptpavztra.php";

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Muestra el evento
$resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzevder WHERE tipo_mp ='P' ORDER BY evento");
$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<$filas_res_evento;$cont++) 
  { 
    $arrayevento[$cont]=$regeve[evento];
    $arraydescri[$cont]=sprintf("%03d",($regeve[evento]-2000))." ".substr($regeve[descripcion],0,70);
    $regeve = pg_fetch_array($resevento);
  }

//Estatus
$resestatus=pg_exec("SELECT estatus,descripcion FROM stzstder where tipo_mp ='P' ORDER BY estatus");
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

$smarty->assign('arrayplus',array(1,2));
$smarty->assign('arraydesplus',array('SI','NO'));
$smarty->assign('campo72','tengan cargado el Evento:');

$smarty->assign('arraytipop',array(N,A,B,C,D,E,F,G,V));
$smarty->assign('arraynotip',array('','INVENCION','DIBUJO INDUSTRIAL','DE MEJORA','DE INTRODUCCION','MODELO INDUSTRIAL','MODELO DE UTILIDAD','DISEÑO INDUSTRIAL','VARIEDADES VEGETALES'));

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Transaccion/Carga:');
$smarty->assign('campo7','DESDE:');
$smarty->assign('campo8','HASTA:');
$smarty->assign('campo1','Rango de Fechas de Evento:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo3','Evento:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Boletin:');
$smarty->assign('campo9','Tipo de Patente:');
$smarty->assign('varfocus','foravztra.desdec'); 
$smarty->display('p_rptpavztra1.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
