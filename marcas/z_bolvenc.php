<?
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$sql = new mod_db();
$fecha=fechahoy();
$hora=hora();

$modulo = 'm_bolvenc.php';

$smarty ->assign('titulo',$titulo); 
$smarty ->assign('subtitulo','Actualizacion de Vencimientos del Boletin'); 
$smarty ->assign('login',$usuario);       
$smarty ->assign('fechahoy',$fecha);   
    
$vuser = $usuario;
     
//Captura Variables leidas en formulario inicial
$vopc=$_GET['vopc'];
$vbol=$_POST['vbol'];
$vfpub=$_POST['vfpub'];
$vfvig=$_POST['vfvig'];
$vfven15=$_POST['vfven15'];
$vfven30=$_POST['vfven30'];
$vfven2m=$_POST['vfven2m'];
$resultado=false;
$tipobol=$_POST['aplica'];
   
$sql->connection($login);   

 if ($vopc==1) {
      if ($tipobol=='N') {
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR: DEBE SELECCIONAR EL TIPO DE BOLETIN ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
 	
      if ($vbol=='' || $vfpub=='' || $vfvig=='' || $vfven15=='' || $vfven30=='' || $vfven2m=='') {
         $sql->disconnect();
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL INTENTAR PROCESAR: - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); exit(); }
       
      //Actualizacion en tablas maestras
      $can_error=0;
      pg_exec("BEGIN WORK");

      // *** Datos del Boletin *** 
      $update_str = "fecha_pub='$vfpub', fecha_vig='$vfvig', fecha_ven='$vfven30',fecha_2meses='$vfven2m'";
      pg_exec("LOCK TABLE stzboletin IN SHARE ROW EXCLUSIVE MODE");
      $valbol=$sql->update("stzboletin","$update_str","nro_boletin='$vbol' AND tipo_boletin='$tipobol'");
      if (!$valbol) { $can_error = $can_error + 1; }

      // *** 15 dias ***
      $update_str = "fecha_venc='$vfven15'";
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      $val15=$sql->update("stzderec","$update_str","nro_derecho IN (SELECT stzevtrd.nro_derecho FROM stzderec,stzevtrd WHERE evento IN (1062,1123,1125,2123) and stzderec.nro_derecho=stzevtrd.nro_derecho and stzderec.fecha_venc=stzevtrd.fecha_venc AND documento='$vbol')");
      if (!$val15) { $can_error = $can_error + 1; }

      $update_str = "fecha_event='$vfvig',fecha_venc='$vfven15'";
      pg_exec("LOCK TABLE stzevtrd IN SHARE ROW EXCLUSIVE MODE");
      $val15=$sql->update("stzevtrd","$update_str","evento IN (1062,1123,1125,2123) AND documento='$vbol'");
      if (!$val15) { $can_error = $can_error + 1; }

      // *** 30 dias ***
      $update_str = "fecha_venc='$vfven30'";
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
//      $val30=$sql->update("stzderec","$update_str","nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento IN (1122,1124,2122,2124,2126) AND documento='$vbol')");
      $val30=$sql->update("stzderec","$update_str","nro_derecho IN (SELECT stzevtrd.nro_derecho FROM stzderec,stzevtrd WHERE evento IN (1097,1122,1124,2097,2122,2124,2126) and stzderec.nro_derecho=stzevtrd.nro_derecho and stzderec.fecha_venc=stzevtrd.fecha_venc AND documento='$vbol')");

      if (!$val30) { $can_error = $can_error + 1; }

      $update_str = "fecha_event='$vfvig',fecha_venc='$vfven30'";
      pg_exec("LOCK TABLE stzevtrd IN SHARE ROW EXCLUSIVE MODE");
      $val30=$sql->update("stzevtrd","$update_str","evento IN (1097,1122,1124,2097,2122,2124,2126) AND documento='$vbol'");
      if (!$val30) { $can_error = $can_error + 1; }

      // *** 2 Meses ***
      $update_str = "fecha_venc='$vfven2m'";
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      $val2m=$sql->update("stzderec","$update_str","nro_derecho IN (SELECT stzevtrd.nro_derecho FROM stzderec,stzevtrd WHERE evento IN (1201,2201) and stzderec.nro_derecho=stzevtrd.nro_derecho and stzderec.fecha_venc=stzevtrd.fecha_venc AND documento='$vbol')");
      if (!$val2m) { $can_error = $can_error + 1; }

      $update_str = "fecha_event='$vfvig',fecha_venc='$vfven2m'";
      pg_exec("LOCK TABLE stzevtrd IN SHARE ROW EXCLUSIVE MODE");
      $val2m=$sql->update("stzevtrd","$update_str","evento IN (1201,2201) AND documento='$vbol'");
      if (!$val2m) { $can_error = $can_error + 1; }

      // Actualización adicional para todas aquellas solicitudes con registros **************
      $plazoley=15;
      $vfven=calculo_fechas($vfvig,$plazoley,"A","/");
      $update_str = "fecha_regis='$vfvig',fecha_venc='$vfven'";
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      $valreg=$sql->update("stzderec","$update_str","registro!='' and nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento IN (1122,2122) AND documento='$vbol')");
      if (!$valreg) { $can_error = $can_error + 1; }

      // Actualización adicional para todas aquellas solicitudes publicadas ***************
      $update_str = "fecha_publi='$vfpub'";
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      $valreg=$sql->update("stzderec","$update_str","nro_derecho IN (SELECT nro_derecho FROM stzevtrd WHERE evento IN (1124,2124) AND estat_ant in (1006,2006) and documento='$vbol')");
      if (!$valreg) { $can_error = $can_error + 1; }

      // Mensaje final 
      if ($can_error==0) {
           pg_exec("COMMIT WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("DATOS ACTUALIZADOS CORRECTAMENTE ...",'z_bolvenc.php','S');
           $smarty->display('pie_pag.tpl'); exit();   
      } else { 
           pg_exec("ROLLBACK WORK"); $sql->disconnect();
           $smarty->display('encabezado1.tpl');
           mensajenew("ERROR: Falla de Actualizacion en la B.D. Transacciones Abortadas...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); exit(); }
 }      
      
   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('varfocus','formarcas2.vbol'); 
   $smarty->assign('opcion',$vopc); 
   $smarty->assign('vfbol',$vfbol); 
   $smarty->assign('aplica',$tipobol);
   //$smarty->assign('apli_inf',array('N','O','E'));
   //$smarty->assign('apli_def',array('--- Seleccione Tipo Boletin ---','Ordinario','Extraordinario'));
   $smarty->assign('apli_inf',array('N','O'));
   $smarty->assign('apli_def',array('--- Seleccione Tipo Boletin ---','Ordinario'));
   
   $smarty->assign('Campo1','Bolet&iacute;n de la P.I. No.:'); 
   $smarty->assign('Campo2','Fecha de Vencimiento 15 D&iacute;as:');
   $smarty->assign('Campo3','Fecha de Vencimiento 30 D&iacute;as:');  
   $smarty->assign('Campo4','Fecha de Vencimiento  2 Meses:');  
   $smarty->assign('Campo5','Fecha de Publicaci&oacute;n:');  
   $smarty->assign('Campo6','Fecha de Vigencia:');  
   $smarty->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('z_bolvenc.tpl'); 
   $smarty->display('pie_pag.tpl');
?>

