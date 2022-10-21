<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//sesiones
if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "m_rptpavztra_reg.php";

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones x Registro');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Muestra el evento
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

//Orden 
$arrayorden[0]='registro';
$arrayorden[1]='fecha_event';
$arrayorden[2]='documento';

//Carga el tipo de marca para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='MARCA DE PRODUCTO';
 $arraytipo[2]='NOMBRE COMERCIAL';
 $arraytipo[3]='LEMA COMERCIAL';
 $arraytipo[4]='MARCA DE SERVICIO';
 $arraytipo[5]='MARCA COLECTIVA';
 $arraytipo[6]='DENOMINACION DE ORIGEN';

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);

$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('tipo_or',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Transaccion:');
$smarty->assign('campo7','DESDE:');
$smarty->assign('campo8','HASTA:');
$smarty->assign('campo1','Rango de Fechas de Evento:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo3','Evento:');
$smarty->assign('campo12','Tipo de Marca:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo19','Ordenada por:');

$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->display('m_rptpavztra_reg.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
