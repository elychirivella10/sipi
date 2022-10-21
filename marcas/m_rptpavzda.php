<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpavzda.php";

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones (Eventos) cargadas por Solicitud con Titular');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Maestra de evento
$resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzevder WHERE tipo_mp ='M' ORDER BY evento");
$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<$filas_res_evento;$cont++) 
  { 
    $arrayevento[$cont]=$regeve[evento];
    //$arraydescri[$cont]=substr($regeve[descripcion],0,70);
    $arraydescri[$cont]=sprintf("%03d",($regeve[evento]-1000))." ".substr($regeve[descripcion],0,70);
    $regeve = pg_fetch_array($resevento);
  }

//Maestra de Estatus
$resestatus=pg_exec("select estatus,descripcion FROM stzstder WHERE tipo_mp ='M' ORDER BY estatus");
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

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION DE ORIGEN'));

$smarty->assign('arrayindol',array(V,N,P,G,O,C));
$smarty->assign('arraynoind',array('','PERSONA NATURAL','PERSONA JURIDICA','SECTOR PUBLICO','COMUNAL','COOPERATIVA'));

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Transacci&oacute;n/Carga:');
$smarty->assign('campo1','Rango de Fechas de Evento:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo3','Evento:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Estatus:');
$smarty->assign('campo6','Boletin:');
$smarty->assign('campo7','Tipo de Marca:');
$smarty->assign('campo8','Indole del Solicitante/Titular:');
$smarty->assign('varfocus','formarcas2.desdec'); 

$smarty->display('m_rptpavzda.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
