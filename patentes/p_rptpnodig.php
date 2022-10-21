<?php
// *************************************************************************************
// Programa: p_rptpnodig.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2011 I Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo  = "p_rptpnodig.php";

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Consulta de Memorias NO Digitalizadas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Carga el tipo de patente para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='INVENCION';
 $arraytipo[2]='DIBUJO INDUSTRIAL';
 $arraytipo[3]='MODELO INDUSTRIAL';
 $arraytipo[4]='MODELO DE UTILIDAD';
 $arraytipo[5]='DISENO INDUSTRIAL';
 $arraytipo[6]='VARIEDAD VEGETAL';
 $arraytipo[7]='MEJORA';
 $arraytipo[8]='INDUCCION';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Estatus
$resestatus=pg_exec("SELECT estatus,descripcion FROM stzstder WHERE tipo_mp ='P' ORDER BY estatus");

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

//Paso de variables de datos
$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' desde:');
$smarty->assign('campoh',' hasta:');
$smarty->assign('campo2','Registro:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Estatus:');
$smarty->assign('varfocus','foravztra.vsol1'); 
$smarty->display('p_rptpnodig.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
