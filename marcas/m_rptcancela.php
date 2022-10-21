<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")){
echo "Acceso Indebido";
exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();
$modulo= "m_rptcancela.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 
//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Aviso de Cancelaci&oacute;n x Bolet&iacute;n por Falta de Uso');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql = new mod_db();
$sql->connection();

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
$smarty->assign('campot','Rango de Fechas de Transaccion:');
$smarty->assign('campo7','DESDE:');
$smarty->assign('campo8','HASTA:');
$smarty->assign('campo3','Bolet&iacute;n:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('varfocus','foravztra.desdet'); 
$smarty->display('m_rptcancela.tpl');
$smarty->display('pie_pag.tpl');

$sql->disconnect();
?>
