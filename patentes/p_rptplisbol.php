<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}
//Conexion
$sql = new mod_db();
//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "a_rptplisbol.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Listados para la Emisi&oacute;n del Bolet&iacute;n');
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
 $arraytipo[2]='CONCEDIDAS';
 $arraytipo[3]='DEVUELTAS FORMA';
 $arraytipo[4]='DEVUELTAS FONDO';
 $arraytipo[5]='PRIORIDAD EXTINGUIDA';
 $arraytipo[6]='PRIORIDAD EXT. PRENSA EXTEMP.';
 $arraytipo[7]='PRIORIDAD EXT. PRENSA DEFECT.';
 $arraytipo[8]='PERIMIDAS X NO PUBLICACION PRENSA';
 $arraytipo[9]='DENEGADAS'; 
 $arraytipo[10]='DESISTIDAS'; 
 $arraytipo[11]='DESISTIDAS X REGISTRO';
 $arraytipo[12]='ABANDONADAS';
 $arraytipo[13]='ABANDONADAS X NO PAGO';
 $arraytipo[14]='NEGADAS';
 $arraytipo[15]='OPOSICIONES';
 $arraytipo[16]='SIN EFECTO POR FALTA DE PAGO DE ANUALIDAD';
 $arraytipo[17]='SIN EFECTO POR VENCIMIENTO';
 $arraytipo[18]='SIN EFECTO POR FALTA DE PAGO DE CONCESION';

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
$smarty->display('p_rptplisbol.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
