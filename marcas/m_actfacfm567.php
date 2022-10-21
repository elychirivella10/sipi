<?php
// *************************************************************************************
// Programa: m_facfm567.php 
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
$tbname_1 = "stzfactram1";
$tbname_2 = "stzfactram";
$tbname_3 = "stzevtrd";

$vopc    = $_GET['vopc'];
$boletin = $_POST['boletin'];
$resultado = false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizacion de Facturas de Tramites WEBPI x Pruebas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

if ($vopc==2) 
{
  $condicion = "SELECT * FROM stzfactram1";
  $lcwhere = " WHERE nro_factura='F0123456' AND tipo_tram='FM06'";

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $resultado=pg_exec("$condicion$lcwhere");
  
  if (!$resultado) { 
    mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','m_facfm567.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); echo "tramites total: $filas_found"; 
  if ($filas_found==0) {
    mensajenew('AVISO: NO existen DATOS Asociados ...!!!','m_facfm567.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  else 
  { 
    $numerror = 0;
    $filas_found = 1;
    $regsol = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
    { 
      $act_fac   = true;
      $act_cron  = true;
      $vtram     = trim($regsol['nro_tramite']);
      $tipo_tram = trim($regsol['tipo_tram']);
      $nderecho  = $regsol['nro_derecho'];
      $vuser     = trim($regsol['usuario']);
      $fechacarga= trim($regsol['fecha_carga']);      
      $vsol      = $regsol['solicitud'];
      
      switch ($tipo_tram) {
        case "FM05":
          $evento= 1205;
          break;
        case "FM06":
          $evento= 1208;
          break;
        case "FM07":
          $evento= 1207;
          break;
      }
      
      $res_fac=pg_exec("SELECT * FROM sfafactura WHERE tramite = '$vtram' AND servicio='$tipo_tram'");
      $filas_fac = pg_numrows($res_fac);
      if ($filas_fac!=0) {
        $regfac = pg_fetch_array($res_fac);
        $nfactura = $regfac['nro_factura'];  
        $fechafac = $regfac['fecha_factura'];
        $ncantidad= $regfac['cantidad'];
      }

      $res_even=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho = '$nderecho' AND usuario='$vuser' AND fecha_trans='$fechacarga' AND evento=$evento");
      $filas_even = pg_numrows($res_even);
      if ($filas_even!=0) {
        $regeven = pg_fetch_array($res_even);
        $vcomentario = $regeven['comentario'];  
      }

      $update_str = "nro_factura='$nfactura',fecha_factura='$fechafac'";
      
      $pagotasa='S/Factura: '.$nfactura.', de fecha: '.$fechafac;
      
      $vtasa = str_replace("S/Factura: F0123456, de fecha: 18/06/2019",$pagotasa,$vcomentario);
      
      echo "tramite= $vtram, $tipo_tram, $update_str, $vsol, $nderecho, comenta=$vcomentario, $vtasa";

      //exit();
      //Se actualiza Stzfactram1 con factura y fecha factura 
      if (!empty($update_str)) { 
        $act_fac = $sql->update("$tbname_2","$update_str","nro_tramite='$vtram' AND servicio='$tipo_tram' AND nro_derecho='$nderecho'"); 
      } 
      if ($act_fac) { }
      else { $numerror = $numerror + 1; }  

      if ($numerror==0) {
        //Se actualiza Stzevtrd con el comentario actualizado con la factura y fecha factura correcta 
        $update_str = "comentario='$vcomentario'";
        if (!empty($update_str)) { 
          $act_cron = $sql->update("$tbname_3","$update_str","nro_derecho = '$nderecho' AND usuario='$vuser' AND fecha_trans='$fechacarga' AND evento=$evento"); 
        } 
        if ($act_cron) { }
        else { $numerror = $numerror + 1; }
      }    
        
      $regsol = pg_fetch_array($resultado);
    }
  }

  if ($numerror==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
   
    Mensajenew("'$filas_found' REGISTROS ACTUALIZADOS CORRECTAMENTE ...!!!","m_facfm567.php","S");
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
