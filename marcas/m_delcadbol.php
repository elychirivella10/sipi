<?php
// *************************************************************************************
// Programa: m_delpriobol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2016 I Semestre
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
$sql = new mod_db();
$tbname_1 = "stzderec";
$tbname_2 = "stzevtrd";
$tbname_3 = "stztmpbo";

$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$resultado = false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Eliminaci&oacute;n de Caducas por Bolet&iacute;n mal Actualizada');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $condicion = "SELECT stzderec.nro_derecho,stzderec.solicitud,stzderec.estatus FROM stzderec,stzevtrd";
  $lcwhere = " WHERE tipo_mp='M' AND stzderec.estatus=1750 AND (stzderec.nro_derecho=stzevtrd.nro_derecho) AND stzevtrd.evento in (1075) AND stzevtrd.estat_ant in (1400) AND stzevtrd.usuario='kdelgado' AND stzevtrd.fecha_trans='14/12/2021'";

  if (!empty($boletin)) {
     $lcwhere = $lcwhere." AND stzevtrd.documento='$boletin'"; } 
  else {
     mensajenew('ERROR: Problema en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_reversarcadbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado);
  echo "$condicion$lcwhere - $filas_found"; //exit(); 
  if ($filas_found==0) {
    mensajenew('AVISO: NO existen DATOS Asociados ...!!!','m_reversarcadbol.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $regsol = pg_fetch_array($resultado); //$filas_found=1;
    for($cont=0;$cont<$filas_found;$cont++) 
    { 
      $del_datos= true;
      $act_dere = true;
      $del_datos1= true;
      $vder = trim($regsol['nro_derecho']);
      $del_datos = $sql->del("$tbname_2","stzevtrd.nro_derecho='$vder' AND stzevtrd.evento in (1075) AND stzevtrd.estat_ant IN (1400) AND stzevtrd.usuario='kdelgado' AND stzevtrd.fecha_trans='14/12/2021' AND documento=$boletin");
      //echo " $vder , $regsol[solicitud] ";
      $regestfin = 1400;
      $update_str = "estatus='$regestfin'";
      //Se actualiza Maestra Principal de Derecho 
      if (!empty($update_str)) { 
        $act_dere = $sql->update("$tbname_1","$update_str","nro_derecho='$vder' AND estatus=1750 AND tipo_mp='M'"); 
      } 
      //$del_datos1 = $sql->del("$tbname_3","nro_derecho='$vder");

      if ($del_datos AND $act_dere) { }
      else { $numerror = $numerror + 1; }  
        
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' REGISTROS ACTUALIZADOS CORRECTAMENTE ...!!!","m_reversarcadbol.php","S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

?>
