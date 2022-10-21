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
$modulo= "m_rptpavzcri.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Listado de Orden de Publicaci&oacute;n x Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

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

 $arraymodal[0]='';
 $arraymodal[1]='DENOMINATIVA';
 $arraymodal[2]='GRAFICA';
 $arraymodal[3]='MIXTA';

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arraymodal',$arraymodal);
$smarty->assign('modal_id',0);

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
$smarty->assign('campo2','Tipo de Marca:');
$smarty->assign('campo3','Modalidad:');
$smarty->assign('campo7','Boletin:');
$smarty->assign('varfocus','foravzcri.vsol1'); 

$smarty->display('m_rptpprensa.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
