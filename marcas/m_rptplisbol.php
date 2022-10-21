<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptplisbol.php";
//Conexion
$sql = new mod_db();

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Listados de Marcas para la Emisi&oacute;n del Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
//require ("example-hormenu.php");

//Verificando conexion
$sql->connection();

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='SOLICITADAS';
// $arraytipo[2]='CONCEDIDAS';
// $arraytipo[3]='CONCEDIDAS RECLASIF.';
 $arraytipo[2]='DEVUELTAS FORMA';
 $arraytipo[3]='DEVUELTAS FONDO';
 $arraytipo[4]='OBSERVADAS';
// $arraytipo[7]='CADUCAS';
// $arraytipo[8]='PRIORIDAD EXTINGUIDA';
 $arraytipo[5]='PERIMIDAS X PUBLICACION PRENSA EXTEMPORANEA';
 $arraytipo[6]='PRIORIDAD EXT.PRENSA DEFECTUOSA';
 $arraytipo[7]='PERIMIDAS X NO PUBLICACION EN PRENSA';
 $arraytipo[8]='DESISTIDAS'; 
 $arraytipo[9]='DESISTIMIENTO DE OBSERVACION'; 
 $arraytipo[10]='DESISTIM. OBSERVACION MEJOR DERECHO'; 
// $arraytipo[15]='NEGADAS';
// $arraytipo[16]='CAMBIO DE NOMBRE';
// $arraytipo[17]='CAMBIO DE DOMICILIO';
// $arraytipo[18]='CESIONES';
// $arraytipo[19]='FUSIONES';
// $arraytipo[20]='LICENCIAS';
// $arraytipo[21]='RENOVACIONES';
 $arraytipo[11]='ORDEN DE PUBLICACION';
 $arraytipo[12]='OBSERVADAS DESISTIDAS DE OFICIO'; 
// $arraytipo[24]='CADUCAS POR NO RENOVACION'; 
// $arraytipo[25]='REGISTROS NO RENOVADOS'; 
 
//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

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
$smarty->assign('campo2','Fecha Publicaci&oacute;n:');
$smarty->assign('campo4','Tipo de Listado:');
$smarty->assign('campo3','Nro. Bolet&iacute;n:');
$smarty->assign('varfocus','forlisbol.vsol1'); 
$smarty->display('m_rptplisbol.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
