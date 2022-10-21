<?php
// *************************************************************************************
// Programa: p_elibolact.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Creado Año: 2015 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}

$usuario = $_SESSION['usuario_login'];
$fecha    = fechahoy();

//Variable
$sql = new mod_db();
$tbname_1 = "stppatee";
$tbname_2 = "stzevder";
$tbname_3 = "stzevtrd";
$tbname_4 = "stzderec";

$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$resultado = false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Eliminaci&oacute;n de Actualizaci&oacute;n por Bolet&iacute;n');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$boletin = '999'

//Verificando conexion
$sql->connection($usuario);

mensajenew('Error programa bloqueado ...!!!','javascript:history.back();','N');
$smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();

if ($vopc==2) 
{
  $update_str="estatus=2102";
  $condicion = "SELECT stzderec.nro_derecho,stzderec.solicitud FROM stzevtrd,stzderec "; 
  $lcwhere   = " WHERE evento=2123 AND estat_ant=2102 AND estatus=2500 AND fecha_trans='01/10/2015' AND usuario='mvelasquez' AND documento=$boletin
                   AND stzevtrd.nro_derecho=stzderec.nro_derecho ORDER BY 2";

  if (empty($boletin)) {
     mensajenew('Error en el N&uacute;mero de Bolet&iacute;n o esta vacio ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $comentario = "";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
  
  $resultado=pg_exec("$condicion$lcwhere");
  echo "query = $condicion$lcwhere";
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','p_eliactbol','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  //echo "son $filas_found "; exit();
  if ($filas_found==0) {
    mensajenew('ERROR: NO existen DATOS Asociados ...!!!','p_eliactbol','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $regsol = pg_fetch_array($resultado);
    //for($cont=0;$cont<1;$cont++) 
    for($cont=0;$cont<$filas_found;$cont++) 
    {
      $del_datos = true;
      $vder = trim($regsol['nro_derecho']);
      $vsolicitud = $regsol['solicitud'];
      
      //echo "Solicitud= $vsolicitud";

      $del_datos = $sql->del("$tbname_3","nro_derecho='$vder' AND evento=2123 AND estat_ant=2102 AND fecha_trans='01/10/2015' AND usuario='mvelasquez' AND documento=$boletin");

      //Se actualiza Maestra Principal de Derecho 
      if (!empty($update_str))
        { $act_dere = $sql->update("$tbname_4","$update_str","nro_derecho='$vder' AND estatus=2500"); }

      if ($del_datos AND $act_dere) { }
      else { $numerror = $numerror + 1; }  

      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' SOLICITUDES ACTUALIZADAS CORRECTAMENTE ...!!!","p_eliactbol.php","S");
    $smarty->display('pie_pag.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

}

?>
