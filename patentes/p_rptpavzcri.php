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
$modulo= "p_rptpavzcri.php";

//Encabezados
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Consulta Avanzada por Criterios');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

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
$resestatus=pg_exec("SELECT estatus,descripcion FROM stzstder WHERE tipo_mp ='P' ORDER BY estatus");
$cont = 0;
$arrayestatus[$cont]=0;
$arraydescri1[$cont]='';
$filas_res_estatus=pg_numrows($resestatus);
$regest = pg_fetch_array($resestatus);
for($cont=1;$cont<=$filas_res_estatus;$cont++) 
  { 
    $arrayestatus[$cont]=$regest[estatus];
    $arraydescri1[$cont]=sprintf("%03d",($regest[estatus]-2000))." ".substr($regest[descripcion],0,70);
    $regest = pg_fetch_array($resestatus);
  }

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
 $arraytipo[8]='INTRODUCCION';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arraypais',$arraypais);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('pais_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo3','Registro:');
$smarty->assign('campo5','Fecha de Solicitud:');
$smarty->assign('campo7','Fecha Publicacion:');
$smarty->assign('campo9','Fecha de Vencimiento:');
$smarty->assign('campo11','Estatus:');
$smarty->assign('campo12','Tipo de Patente:');
$smarty->assign('campo14','Pais:');
$smarty->assign('campo15','Titulo de la Patente:');
$smarty->assign('campo16','Codigo del titular:');
$smarty->assign('campo17','Codigo del Agente:');
$smarty->assign('campo18','Nombre del Tramitante:');
$smarty->assign('varfocus','foravzcri.vsol1'); 

$smarty->display('p_rptpavzcri.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
