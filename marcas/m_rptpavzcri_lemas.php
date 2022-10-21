<?php
// *************************************************************************************
// Programa: m_rptpavzcri_lemas.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año: 2006 - Modificado Año 2018 BD Relacional MPPCPN
// *************************************************************************************

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
$modulo= "m_rptpavzcri.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Consulta Avanzada por Criterios - Lemas');
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
    $arraynombre[$cont]=$Blanco1;

for($cont=1;$cont<$filas_res_pais;$cont++) 
  { 
    $arraypais[$cont]=$regpai[pais];
    $arraynombre[$cont]=substr($regpai[nombre],0,60);
    $regpai = pg_fetch_array($respais);
  }

//Carga el Estatus para mostrarlo en el combo
$resestatus=pg_exec("select estatus,descripcion from stzstder WHERE estatus=1104 AND tipo_mp ='M' order by estatus");

$cont = 0;
$arrayestatus[$cont]=0;
$arraydescri1[$cont]='';
$filas_res_estatus=pg_numrows($resestatus);
$regest = pg_fetch_array($resestatus);
for($cont=0;$cont<$filas_res_estatus;$cont++) 
  { 
    $arrayestatus[$cont]=$regest[estatus];
    $arraydescri1[$cont]=sprintf("%03d",($regest[estatus]-1000))." ".substr($regest[descripcion],0,70);
    $regest = pg_fetch_array($resestatus);
  }

//Carga el tipo de marca para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='MARCA DE PRODUCTO';
 $arraytipo[2]='NOMBRE COMERCIAL';
 $arraytipo[3]='LEMA COMERCIAL';
 $arraytipo[4]='MARCA DE SERVICIO';
 $arraytipo[5]='MARCA COLECTIVA';
 $arraytipo[6]='DENOMINACION COMERCIAL';
 $arraytipo[7]='DENOMINACION DE ORIGEN';

//Orden 
 $arrayorden[0]='';
 $arrayorden[1]='solicitud';
 $arrayorden[2]='registro';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arraypais',$arraypais);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('pais_id',0);

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('tipo_or',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo3','Registro:');
$smarty->assign('campo5','Fecha de Solicitud:');
$smarty->assign('campo7','Fecha Publicacion:');
$smarty->assign('campo9','Fecha de Vencimiento:');
$smarty->assign('campo8','Poder Nro:');
$smarty->assign('campo11','Estatus:');
$smarty->assign('campo12','Tipo de Marca:');
$smarty->assign('campo13','Clase:');
$smarty->assign('campo14','Pais:');
$smarty->assign('campo15','Nombre de la Marca:');
$smarty->assign('campo16','Codigo del titular:');
$smarty->assign('campo17','Codigo del Agente:');
$smarty->assign('campo18','Nombre del Tramitante:');
$smarty->assign('campo19','Ordenada por:');

$smarty->assign('varfocus','foravzcri.vsol1'); 

$smarty->display('m_rptpavzcri_lemas.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
