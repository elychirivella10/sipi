<?php
// *************************************************************************************
// Programa: z_enviobusq.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include("$include_lib/class.phpmailer.php"); 

?>
<html>
<head>
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables 
$usuario  = $_SESSION['usuario_login'];
$tbname_1 = "stmbusweb";
$tbname_2 = "stzusuar";
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

$smarty->assign('subtitulo','ENVIO DE ARCHIVOS BUSQUEDAS POR CORREO');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
 //Verificando conexion Webpi
 $sql1 = new mod_db();
 $sql1->connection1();

 //Verificando conexion SIPI
 $sql = new mod_db();
 $sql->connection();

 // Obtencion de los Registros o Filas   
 $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE estado='2' ORDER BY nro_tramite,ref_busq");
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   Mensajenew("ERROR: No hay archivos que transferir ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $numerror = 0;
 $act_user = true;
 $fechahoy = hoy();

 // Comienzo de Transaccion   
 pg_exec("BEGIN WORK");
 $objs = $sql->objects('',$obj_query);
 $usrant = trim($objs->usuario);
 $tramant = trim($objs->nro_tramite);
 $indc = 1;
 echo " son $filas_found <br/ >";
 for($cont=0;$cont<$filas_found;$cont++) {
   $cuenta  = trim($objs->usuario);
   $tramite = trim($objs->nro_tramite);
   $tipo    = trim($objs->tipo_busq);
   $refbusq = trim($objs->ref_busq);
   if ($tipo=="F") { $vruta="/home/fonetica/webpi/"; }
   if ($tipo=="G") { $vruta="/apl/webpi/graficas/"; }
   echo "tram= $tramite, $tramant, tipo= $tipo, $refbusq, $vruta ";

   if (($usrant!=$cuenta) || ($indc==1)) {
   //if (($tramant!=$tramite) || ($indc==1)) {
     //echo " nueva cuenta = $cuenta, con $tramite y $refbusq ";
     $adjuntos = array();
     $filepdf = $vruta.trim($refbusq).".pdf";
     echo " archivo = $filepdf <br/ >";
     if (file_exists($filepdf)) { 
       $count = count($adjuntos); 
       $adjuntos[$count+1]['filename']=$vruta.trim($refbusq).".pdf";
       $adjuntos[$count+1]['ruta']=$vruta;
       $indc = 0;
       $update_str = "estado='3'";
       $act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite='$tramite' AND tipo_busq='$tipo' AND ref_busq='$refbusq'"); 
       // Verificacion de actualizacion BD  
       if ($act_user) { }
       else { $numerror = $numerror + 1; }
     }  
   }
   else {
     //echo " misma cuenta = $cuenta, con $tramite y $refbusq ";
     $filepdf = $vruta.trim($refbusq).".pdf";
     echo " archivo = $filepdf <br/ >";
     if (file_exists($filepdf)) { 
       $count = count($adjuntos); 
       $adjuntos[$count+1]['filename']=$vruta.trim($refbusq).".pdf";
       $adjuntos[$count+1]['ruta']=$vruta;
       $update_str = "estado='3'";
       $act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite='$tramite' AND tipo_busq='$tipo' AND ref_busq='$refbusq'"); 
       // Verificacion de actualizacion BD  
       if ($act_user) { }
       else { $numerror = $numerror + 1; }
     }       
   }
   //Envio al correo de la Nueva Clave...  

   $objs = $sql->objects('',$obj_query);
   if ($usrant!=trim($objs->usuario)) {  
   //if ($tramant!=$objs->nro_tramite) {  
     //echo "cuenta anterior= $usrant con archivos adjuntos: ";
     if (!empty($adjuntos)) {
       foreach ($adjuntos as $attachment) {
         if (empty($attachment['ruta'])) {
           //$mail->AddAttachment($attachment['filename']);
         } else {
           //$mail->AddAttachment($attachment['filename'], $attachment['ruta']);
           //echo $attachment['filename']."  ".$attachment['ruta']."  ";
           //echo $attachment['filename'];
         }
       }
     } 
     $obj_usr = $sql->query("SELECT * FROM $tbname_2 WHERE usuario='$usrant'");
     $objsusr = $sql->objects('',$obj_usr);
     $nombre  = trim($objsusr->nombres)." ".trim($objsusr->apellidos);

     //Actualizacion de Estatus del tramite en Webpi y envio por Correo 
     $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_tramite='$tramite' AND estado='3'"); 
     $filas_tram=$sql->nums('',$obj_query); echo " tramite $tramite tiene=$filas_tram archivos <br/ >";
     if ($filas_tram==0) {
       $actbusq    = true;
       $update_str = "estatus_tra='06',fecha_estatus='$fechahoy'"; 
       $actbusq    = $sql1->update1("stztramite","$update_str","nro_tramite='$tramite'");
       correo($sql_mail,$usrant,$nombre,$tramite,$adjuntos);
     }
     $usrant = trim($objs->usuario); $indc = 1; 
     //$tramant = trim($objs->nro_tramite); $indc = 1;
     //echo "cuenta nueva= $usrant ";
   }
 }

 if ($numerror==0) { 
   pg_exec("COMMIT WORK"); 
   $vmessage="DATOS ENVIADOS CORRECTAMENTE ...!!";
   $vmessage1="";
   echo "<br><br>";
   echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
   echo "   <tr>";
   echo "     <td colspan='2' height='60'>";
   echo "        <img src='../imagenes/messagebox_info.png' align='middle'>";
   echo "     </td>";
   echo "     <td colspan='2' height='60'>";
   echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>$vmessage<br><br><font color='#FFFF00'></b></font>";
   echo "       </div>";
   echo "     </td>";
   echo "   </tr>";
   echo "</table>";
   echo "<p align='center'><a href='../index1.php'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";
   echo "<br>";
   
   $smarty->display('pie_pag.tpl'); 
   //Desconexion de la Base de Datos
   $sql->disconnect(); exit();    
 }
 else {
   pg_exec("ROLLBACK WORK"); }
 
 //Desconexion de la Base de Datos
 $sql->disconnect();   

 //Desconexion de la Base de Datos
 $sql1->disconnect1();   
}

$smarty->display('z_enviobusq.tpl');
$smarty->display('pie_pag.tpl');

//************************************************************************************
function correo($sql_mail,$vemail,$nombre,$tramite,$adjuntos) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema WEBPI - SAPI";
 $mail->Subject = "Envio de Solicitud(es) de Busqueda(s) En Linea del Tramite No. ".$tramite;

 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminwebpi@sapi.gob.ve','Administrador Webpi');

 if (!empty($adjuntos)) {
   foreach ($adjuntos as $attachment) {
     $mail->AddAttachment($attachment['filename']);
   }
 } 

 $body  = "<strong>Estimada(o) Usuaria(o): </strong>".$nombre." <br><br>";

 $body .= "Anexo al presente, le hacemos llegar el(los) resultado(s) de la(s) b&uacute;squeda(s) fon&eacute;tica(s) y/o gr&aacute;fica(s) solicitada(s) por usted en l&iacute;nea, y relacionada(s) al tramite n&uacute;mero <strong>".$tramite."</strong>.<br>";
 $body .= "Si la informaci&oacute;n enviada no esta completa, favor comuniquese a trav&eacute;s del correo electr&oacute;nico: sugerencias@sapi.gob.ve e indique que tr&aacute;mite y referencia(s) de archivo(s) no llegaron.<br>";
 $body .= "Gracias por usar nuestro servicio en l&iacute;nea.<br><br>";

 $body .= "IMPORTANTE: Le recordamos que para ingresar de manera exitosa en el sistema WEBPI debe tener activada la opci&oacute;n de visualizaci&oacute;n de ventanas emergentes (popup) en su navegador web.<br><br>";
 $body .= "Para mayor informaci&oacute;n &oacute; realizar alg&uacute;n reclamo, comun&iacute;quese con nosotros por la central telef&oacute;nica (0212) 481.64.78 / 484.29.07 &oacute; a trav&eacute;s del correo electr&oacute;nico: sugerencias@sapi.gob.ve<br><br>";

 $body .= " Ministerio del poder Popular para el Comercio - MPPC.<br/>";
 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - S.A.P.I.<br/>";
 $body .= " Portal: www.sapi.gob.ve<br>";
 $body .= "<font color='red'>NOTA: Esta es una cuenta de correo NO Monitoreada, por favor no responda ni reenv&iacute;e mensajes a esta cuenta.</font>";

 $mail->Body = $body;
 $mail->AltBody = "x PHPMailer\n";

 $exito = $mail->Send();
 $intentos=1;
 while ((!$exito) && ($intentos < 5)) {
   sleep(5);
   $exito = $mail->Send();
   $intentos=$intentos+1;
 }

 if (!$exito) { echo "Problemas al enviar el correo"; }
 return;
}

?>
</body>
</html>
