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
$modulo= "m_rptpavztra.php";

//Encabezados
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Consulta Avanzada de Transacciones por Solicitud');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Carga el pais para mostrarlo en el combo
$respais=pg_exec("SELECT * FROM stzpaisr order by nombre");
$filas_res_pais=pg_numrows($respais);
$regpai = pg_fetch_array($respais);
$blanco=0;
$blanco1='';
$cont=0;

    $arraypais[$cont]=$blanco;
    $arraynombre[$cont]=$blanco1;

for($cont=1;$cont<$filas_res_pais;$cont++) 
  { 
    $arraypais[$cont]=$regpai[pais];
    $arraynombre[$cont]=substr($regpai[nombre],0,60);
    $regpai = pg_fetch_array($respais);
  }


//Operador logico para el pais 
$arrayopelog[0]='=';
$arrayopelog[1]='<>';

//Muestra el evento
$resevento=pg_exec("SELECT stzevder.evento,stzevder.descripcion FROM stzevder WHERE tipo_mp ='M'order by evento");

$cont = 0;
$arrayevento[$cont]=0;
$arraydescri[$cont]='';
$filas_res_evento=pg_numrows($resevento);
$regeve = pg_fetch_array($resevento);
for($cont=1;$cont<$filas_res_evento;$cont++) 
  { 
    $arrayevento[$cont]=$regeve[evento];
    $arraydescri[$cont]=sprintf("%03d",($regeve[evento]-1000))." ".substr($regeve[descripcion],0,70);
    $regeve = pg_fetch_array($resevento);
  }


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

//Orden 
//$arrayorden[0]='';
$arrayorden[0]='solicitud';
$arrayorden[1]='fecha_event';
$arrayorden[2]='fecha_trans';
$arrayorden[3]='documento';

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('eventos_id',0);

$smarty->assign('arrayplus',array(1,2));
$smarty->assign('arraydesplus',array('SI','NO'));

$smarty->assign('arraycplus',array(1,2));
$smarty->assign('arraydescplus',array('=','<>'));

$smarty->assign('arraytipom',array(V,M,N,L,S,C));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA'));

$smarty->assign('arraypais',$arraypais);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('pais_id',0);

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('tipo_or',0);

$smarty->assign('arraybusfone',array('N','S'));
$smarty->assign('arraydesbusfone',array('NO','SI'));
$smarty->assign('arraybusgraf',array('N','S'));
$smarty->assign('arraydesbusgraf',array('NO','SI'));

//Paso de asignacion de variables de encabezados
$smarty->assign('campot','Rango de Fechas de Transaccion/Carga:');
$smarty->assign('campo9','DESDE:');
$smarty->assign('campo8','HASTA:');
$smarty->assign('campo1','Rango de Fechas de Evento:');
$smarty->assign('campo2','DESDE:');
$smarty->assign('campoh','HASTA:');
$smarty->assign('campo3','Evento:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','Estatus Actual:');
$smarty->assign('campo51','Estatus Anterior:');
$smarty->assign('campo6','Boletin:');
$smarty->assign('campo7','Modalidad:');
$smarty->assign('campo71','Indole:');
$smarty->assign('campo72','tengan cargado el Evento:');
$smarty->assign('campo82','Con Clase Internacional');
$smarty->assign('campo10','Tipo de Marca:');
$smarty->assign('campo11','Pa&iacute;s:');
$smarty->assign('campo19','Ordenada por:');
$smarty->assign('campo15','Fecha de Vencimiento:');

$smarty->assign('varfocus','formarcas2.desdec'); 
$smarty->display('m_rptpavztra.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
