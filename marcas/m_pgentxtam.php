<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

//Variables
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_pgentxtam.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generaci&oacute;n  de Anotaciones Marginales para Ventura');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

mensajenew('AVISO: Opci&oacute;n del sistema Bloqueada por Obsoleto, contactar al Administrador ...!!!','../index1.php','N');
$smarty->display('pie_pag.tpl'); exit();

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='RENOVACIONES';
 $arraytipo[2]='CAMBIO DE NOMBRE';
 $arraytipo[3]='CAMBIO DE DOMICILIO';
 $arraytipo[4]='CESIONES';
 $arraytipo[5]='FUSIONES';
 $arraytipo[6]='LICENCIAS';
 $arraytipo[7]='DESTMTO. RENOVACIONES';
 $arraytipo[8]='DESTMTO. CAMBIO DE NOMBRE';
 $arraytipo[9]='DESTMTO. CAMBIO DE DOMICILIO';
 $arraytipo[10]='DESTMTO. CESIONES';
 $arraytipo[11]='DESTMTO. FUSIONES';
 $arraytipo[12]='DESTMTO. LICENCIAS';
 
//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Paso de asignacion de variables de encabezados
$smarty->assign('campo4','Tipo de Anotaci&oacute;n Marginal:');
$smarty->assign('campo3','Nro. Bolet&iacute;n:');
$smarty->assign('varfocus','forlisbol.vsol1'); 
$smarty->display('m_gentxtam.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
