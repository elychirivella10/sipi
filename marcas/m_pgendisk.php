<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variables de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_pgendisk.php";

//Encabezados
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Generacion de Archivos TXT');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
//Carga el tipo de de listado en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='SOLICITADAS';
 $arraytipo[2]='CONCEDIDAS';
 $arraytipo[3]='CONCEDIDAS RECLASIFICADAS';


//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);


//Paso de asignacion de variables de encabezados
$smarty->assign('campo1',' Generar Archivos de: ');
$smarty->assign('campo2',' Nro. de Boletin: ');
$smarty->assign('campo3',' Fecha de Publicaci&oacute;n para Solicitadas: ');
$smarty->assign('varfocus','foravztra.desdet'); 
$smarty->display('m_gendisk.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
