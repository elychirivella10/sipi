<script language="Javascript"> 

function gestionvienap(var1,var3,var4) {
  open("adm_bviena.php?vsol="+var1.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<?php
// *************************************************************************************
// Programa: m_conviena.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año: 2010 I Semestre BD Relacional
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos y Smarty 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$sql      = new mod_db();
$fecha    = fechahoy();

$vopc   = $_GET['vopc'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','B&uacute;squeda de Logotipos por Viena');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

//$tnumera='conviena';
//Se obtiene el proximo valor segun stzsystem
//$sys_actual = next_sys("$tnumera");
//$vauxnum = grabar_sys("$tnumera",$sys_actual);
$obj_query = $sql->query("update stzsystem set conviena=nextval('stzsystem_conviena_seq')");
$obj_query = $sql->query("select last_value from stzsystem_conviena_seq");
$objs = $sql->objects('',$obj_query);
$sys_actual = $objs->last_value;
$vauxnum = $sys_actual;
$vcontrol="C".str_pad($vauxnum,10,"0",STR_PAD_LEFT);
$smarty->assign('vcontrol',$vcontrol); 
$smarty->assign('modo1','readonly'); 

//Desconexion a la BD
$sql->disconnect();

$smarty->assign('lcviena','C&oacute;digos de Viena '); 
$smarty->assign('campo1','  B&uacute;squeda Control No.:');
$smarty->assign('vopc',$vopc); 
$smarty->assign('varfocus','formarcas1.vviena'); 
$smarty->assign('usuario',$usuario);

$smarty->display('m_conviena.tpl');
$smarty->display('pie_pag.tpl');
?>
