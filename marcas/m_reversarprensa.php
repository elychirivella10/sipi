<?php
// *************************************************************************************
// Programa: m_reversoprensa.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Año: 2020 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Variable
$tbname_1 = "stzderec";
$tbname_2 = "stzevtrd";

$vopc    = $_GET['vopc'];
$resultado = false;

//Encabezados
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reverso de Actualizacion de Prensa mal ejecutada');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//mensajenew('AVISO: Opci&oacute;n del sistema Bloqueada  ...!!!','../index1.php','N');
//$smarty->display('pie_pag.tpl'); exit();

if ($vopc==2) 
{
  //Verificando conexion
  $sql = new mod_db();
  $sql->connection($usuario);

  $condicion = "SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.estatus FROM stzderec,stzevtrd";
  $lcwhere = " WHERE tipo_mp='M' AND stzderec.estatus=1005 AND (stzderec.nro_derecho=stzevtrd.nro_derecho) AND stzevtrd.evento in (1022) AND stzevtrd.estat_ant in (1004) AND stzevtrd.usuario='chernandez' AND stzevtrd.fecha_trans>='01/07/2020' AND stzevtrd.fecha_trans<='09/10/2020'";
  $orderby = " ORDER BY stzevtrd.fecha_trans,stzderec.solicitud";

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere$orderby");
  
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','../index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado);
  //echo "$condicion$lcwhere$orderby - $filas_found"; 
  //exit(); 
  if ($filas_found==0) {
    mensajenew('AVISO: NO existen DATOS Asociados ...!!!','../index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $regsol = pg_fetch_array($resultado); //$filas_found
    for($cont=0;$cont<$filas_found;$cont++) 
    { 
      $del_datos= true;
      $act_dere = true;
      $vder = trim($regsol['nro_derecho']);
      $del_datos = $sql->del("$tbname_2","stzevtrd.nro_derecho='$vder' AND stzevtrd.evento in (1022) AND stzevtrd.estat_ant IN (1004) AND stzevtrd.usuario='chernandez'");
      //echo " $vder , $regsol[solicitud] "; //exit();
      $regestfin = 1004;
      $update_str = "estatus='$regestfin'";
      //Se actualiza Maestra Principal de Derecho 
      if (!empty($update_str)) { 
        $act_dere = $sql->update("$tbname_1","$update_str","nro_derecho='$vder' AND estatus=1005 AND tipo_mp='M'"); 
      } 

      if ($del_datos AND $act_dere) { }
      else { $numerror = $numerror + 1; }  
        
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","../index1.php","S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); exit();
  }
}

$smarty->display('m_reversarprensa.tpl');
$smarty->display('pie_pag.tpl');
$sql->disconnect();

?>
