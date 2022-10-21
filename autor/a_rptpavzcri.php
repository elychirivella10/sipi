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
$modulo= "a_rptpavzcri.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','Sistema de Derecho de Autor');
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
    $arraynombre[$cont]=$blanco1;

for($cont=1;$cont<$filas_res_pais;$cont++) 
  { 
    $arraypais[$cont]=$regpai[pais];
    $arraynombre[$cont]=substr($regpai[nombre],0,60);
    $regpai = pg_fetch_array($respais);
  }

//Carga el Estatus para mostrarlo en el combo
$resestatus=pg_exec("SELECT estatus,descripcion FROM stdstobr order by estatus");

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

//Carga el tipo de obra para mostrarlo en el combo
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

//Carga la clase de obra para mostrarlo en el combo
 $blanco='';
 $arrayclase[0]='';
 $arrayclase[1]='INEDITA';
 $arrayclase[2]='PUBLICADA';

//Carga el origen de la obra para mostrarlo en el combo
 $blanco='';
 $arrayorigen[0]='';
 $arrayorigen[1]='ORIGINARIA';
 $arrayorigen[2]='DERIVADA';

//Carga la forma de la obra para mostrarlo en el combo
 $blanco='';
 $arrayforma[0]='';
 $arrayforma[1]='INDIVIDUAL';
 $arrayforma[2]='EN COLABORACION';
 $arrayforma[3]='COLECTIVA';

//Carga el tipo de letra de la cedula o rif para mostrarlo en el combo
 $blanco='';
 $arrayletra[0]='';
 $arrayletra[1]='V';
 $arrayletra[2]='E';
 $arrayletra[3]='P';
 $arrayletra[4]='J';
 $arrayletra[5]='G';
 $arrayletra[6]='I';

//Orden 
 $arrayorden[0]='';
 $arrayorden[1]='solicitud';
 $arrayorden[2]='registro';
 $arrayorden[3]='nplanilla';
 $arrayorden[4]='fecha_regis,registro';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arrayletra',$arrayletra);
$smarty->assign('letra_id',0);

$smarty->assign('arrayestatus',$arrayestatus);
$smarty->assign('arraydescri1',$arraydescri1);
$smarty->assign('estatus_id',0);

$smarty->assign('arraypais',$arraypais);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('pais_id',0);

$smarty->assign('arrayorden',$arrayorden);
$smarty->assign('orden',0);

$smarty->assign('arrayclase',$arrayclase);
$smarty->assign('clase',0);

$smarty->assign('arrayorigen',$arrayorigen);
$smarty->assign('origen',0);

$smarty->assign('arrayforma',$arrayforma);
$smarty->assign('forma',0);

// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  $opra='C'; 
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

//Paso de asignacion de variables de encabezados
$smarty->assign('campo1','Solicitud:');
$smarty->assign('campod',' DESDE:');
$smarty->assign('campoh',' HASTA:');
$smarty->assign('campo3','Registro:');
$smarty->assign('campo5','Fecha de Solicitud:');
$smarty->assign('campo6','Fecha de Registro:');
$smarty->assign('campo7','Clasificación: Clase:');
$smarty->assign('campo8','Origen:');
$smarty->assign('campo9','Forma:');
$smarty->assign('campo11','Estatus:');
$smarty->assign('campo12','Tipo de Obra:');
$smarty->assign('campo14','Pais:');
$smarty->assign('campo15','Titulo de la Obra:');
$smarty->assign('campo16','Doc. del Solicitante:');
$smarty->assign('campo19','Ordenada por:');
$smarty->assign('varfocus','foravzcri.vsol1'); 

$smarty->display('a_rptpavzcri.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
