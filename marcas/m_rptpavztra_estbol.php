<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpavzrestbol.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Reporte de Marcas Registradas X Boletin');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

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

$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Carga el orden del listado
 $blanco='';
 $arrayorde[0]='';
 $arrayorde[1]='solicitud';
 $arrayorde[2]='registro';
//Paso de variables de datos

$smarty->assign('arrayorde',$arrayorde);
$smarty->assign('orde_id',0);

// Control de acceso: Entrada y Salida al Modulo 
//if ($conx==0) { 
//  $smarty->assign('n_conex',$nconex);      }
//else {
//  $opra='C'; 
//  $res_conex = insconex($usuario,$modulo,$opra);
//  $smarty->assign('n_conex',$res_conex);   }

//if (($salir==0) && ($nconex>0)) {
//  $logout = salirconx($nconex);
//}

$smarty->assign('campo12','Tipo de Marca:');
$smarty->assign('campo6','Boletin:');
$smarty->assign('campo7','Ordenado Por:');

$smarty->assign('varfocus','foravztra.desdet'); 
$smarty->display('m_rptpavztra_estbol.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
