<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//sesiones
if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "p_rptpavztra_reg.php";

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones x Registro');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

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

//Carga el tipo de Patente para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='INVENCION';
 $arraytipo[2]='DIBUJO INDUSTRIAL';
 $arraytipo[3]='DISENO INDUSTRIAL';
 $arraytipo[4]='MODELO DE UTILIDAD';
 $arraytipo[5]='MODELO INDUSTRIAL';
 $arraytipo[6]='VARIEDAD VEGETAL';
 $arraytipo[7]='MEJORA';
 $arraytipo[8]='INTRODUCCION';

//Paso de variables de datos
$smarty->assign('arrayplus',array(1,2));
$smarty->assign('arraydesplus',array('SI','NO'));
$smarty->assign('campo72','tengan cargado el Evento:');

//Orden 
$arrayorden[0]='solicitud';
$arrayorden[1]='fecha_event';
$arrayorden[2]='document';
$arrayorden[3]='registro';

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('tipo_or',0);

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

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
$smarty->assign('campo9','Bolet&iacute;n:');
$smarty->assign('campo12','Tipo de Patente:');
$smarty->assign('campo10','Clasificaci&oacute;n Locarno:');
$smarty->assign('campo11','Clasificaci&oacute;n CIP:');
$smarty->assign('campo13','Orden:');


$smarty->assign('varfocus','foravztra.desdec'); 
$smarty->display('p_rptpavztra_reg.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
