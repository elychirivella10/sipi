<?php
// *************************************************************************************
// Programa: z_envioclave.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Para trabajar con Smarty 
require ("$root_path/include.php");
//LLamadas a funciones de Libreria 
include ("$include_lib/library.php");
include("$include_lib/class.phpmailer.php"); 
require("$include_lib/class.password.generator.php");

?>
<html>
<head>
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<?php
 //<body onload="javascript:history.back();" bgcolor="#D8E6FF"> //Variables 
 $tbname_1 = "stzusuar";
 $fecha    = fechahoy();
 $usuario  = "Administrador";
 
 $smarty->assign('subtitulo','ENVIO DE CLAVE POR CORREO');
 $smarty->assign('login',$usuario);
 $smarty->assign('fechahoy',$fecha);
 $smarty->display('encabezado1.tpl');

 //Variable Clase de Conexion 
 $sql = new mod_db();
 //Verificando conexion
 $sql->connection();

if ($usuario!='rmendoza') {
  if ($usuario!='ngonzalez') {	 
    Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  }  
}  

//Verifica si el programa esta en mantenimiento
$manphp = vman_php("z_envioclave.php");
if ($manphp==1)  {
  MensageError('AVISO: Modulo en Mantenimiento temporalmente ...!!!','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

 // Obtencion de los Registros o Filas   
 $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE usuario='admin' ORDER BY usuario");
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   Mensajenew("ERROR: La Tabla de Usuarios esta Vacia ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $numerror = 0;
 $act_user = true;
 $fechahoy = hoy();
 // Comienzo de Transaccion   
 pg_exec("BEGIN WORK");
 $objs = $sql->objects('',$obj_query);
 for($cont=0;$cont<$filas_found;$cont++) {
   $cuenta  = trim($objs->usuario);
   $nombre  = trim($objs->nombre);
   $vemail  = trim($objs->email);
    
   //echo "$cuenta, son $filas_found ,$nombre, $vemail";
   $horactual=hora();

   //Verificacion del Correo 
   //$emailval = check_email_address($vemail);
   //if (!$emailval) {  
   //  mensajenew("ERROR: Cuenta Correo Invalida ...!!!","javascript:history.back();","N");
   //  $smarty->display('pie_pag.tpl'); exit(); }

   $passwordgen = $DOZPASSGEN->genPassword();
   //Uso de md5 para encriptar el password
   $clave = md5($passwordgen); 

   $update_str = "pass='$clave',fecha_pass='$fechahoy',hora_pass='$horactual'";
   $act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta'");

   // Verificacion de actualizacion BD  
   if ($act_user) { }
   else { $numerror = $numerror + 1; }
   //Envio al correo de la Nueva Clave...  
   correo($nombre,$vemail,$passwordgen);

   $objs = $sql->objects('',$obj_query);
 }
 if ($numerror==0) { 
   pg_exec("COMMIT WORK"); 
   $vmessage="DATOS ACTUALIZADOS CORRECTAMENTE ...!!";
   //$vmessage1="Ahora puede acceder a su Cuenta correo a revisar su Nueva Clave ...!!";
   $vmessage1="";
   echo "<br><br><br><br><br><br>";
   echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
   echo "   <tr bgcolor='#4682B4'>";
   echo "     <td colspan='2' height='60'>";
   echo "        <img src='../imagenes/messagebox_info.png' align='middle'>";
   echo "     </td>";
   echo "     <td colspan='2' height='60'>";
   echo "       <div align='center'><font face='Arial' color='#FFFFFF' size='2'><b>$vmessage<br><br><font color='#FFFF00'></b></font>";
   echo "       </div>";
   echo "       <div align='center'><font face='Arial' color='#FFFFFF' size='2'><b>$vmessage1<br><br><font color='#FFFF00'></b></font>";
   echo "       </div>";
   echo "     </td>";
   echo "   </tr>";
   echo "</table>";
   //echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
   echo "<p align='center'><a href='../index1.php'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";

   
   $smarty->display('pie_pag.tpl'); 
   //Desconexion de la Base de Datos
   $sql->disconnect(); exit();    
 }
 else {
   pg_exec("ROLLBACK WORK"); }
 //Desconexion de la Base de Datos
 $sql->disconnect();   
//}

function correo($nombre,$vemail,$clave){
 $mail = new PHPMailer();
 $mail->IsSMTP();              		// enviar vía SMTP
 $mail->Host = "172.16.0.2";
 $mail->SMTPAuth = true;     		// activar la identificacín SMTP
 $mail->Username = "msystem";  		// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 		// clave SMTP

 $mail->From = "adminsipi@sapi.gob.ve";
 $mail->FromName = "Administrador de Sistema SIPI";
 $mail->Subject = "Bienvenido(a) al Sistema SIPI SAPI";

 //echo " dentro de correo= $nombre,$vemail,$clave "; 
 $mail->AddAddress($vemail,$nombre);

 $fechahoy = Hoy();
 $horactual= Hora();

 $body  = "<strong>Estimado Usuario(a): </strong>".$nombre." <br><br>";
 $body .= " Le informamos que el d&iacute;a ".$fechahoy." a las ".$horactual.", se le realiz&oacute; el cambio de su clave de acceso al sistema SIPI";
 $body .= " de manera satisfactoria.<br>";
 $body .= "<br><br>Su nueva clave es: <strong>".$clave."</strong><br>";
 $body .= "<br><br>Clave la cual podr&aacute; cambiar por otra si lo desea en la Opci&oacute;n: <strong>Cambio de Clave del menu Mantenimiento</strong><br>";
 $body .= " Atentamente<br>";
 $body .= " Administrador<br>";
 $body .= " Sistema de Informaci&oacute;n de Propiedad Intelectual - SIPI <br><br>";
 $body .= "<font color='red'>NOTA: Esta es una cuenta de correo NO Monitoreada, por favor no responda.</font>";
 $mail->Body = $body;
 $mail->AltBody = "x PHPMailer\n";

 $exito = $mail->Send();
 $intentos=1;
 while ((!$exito) && ($intentos < 5)) {
   sleep(5);
   $exito = $mail->Send();
   $intentos=$intentos+1;
 }
 if (!$exito) { echo " Problemas al enviar el correo al usuario= $nombre "; }
// if (!$exito) { 
//   echo "<br><br><br>";
//   echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
//   echo "   <tr bgcolor='#4682B4'>";
//   echo "     <td colspan='2' height='60'>";
//   echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
//   echo "     </td>";
//   echo "     <td colspan='1' height='60'>";
//   echo "       <div align='center'><font face='Arial' color='#FFFFFF' size='2'><b>ERROR: Problemas al enviar el correo, intente de nuevo ...!!!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><font color='#FFFF00'></b></font>";
//   echo "       </div>";
//   echo "     </td>";
//   echo "   </tr>";
//   echo "</table>";
//   //echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
//   echo "<p align='center'><a href='../index1.php'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";

//   echo "<div align='center'>";
//   echo "<tr><td>&nbsp;</td></tr>";
//   echo "<tr><td>&nbsp;</td></tr>";
//   echo "<p>";
//   echo "<font size='-2'>Coordinaci&oacute;n de Inform&aacute;tica - SAPI <p></b>&nbsp;Caracas, Venezuela - CopyLeft 2010 / Decreto No. 3.390 </font></p>";
//   echo "<hr />   ";
//   echo "</div>";
//   exit();
// }

}

function correomalo($nombre,$vemail,$clave){
 $mail = new PHPMailer();
 $mail->IsSMTP();              		// enviar vía SMTP
 $mail->Host = "172.16.0.2";
 $mail->SMTPAuth = true;     		// activar la identificacín SMTP
 $mail->Username = "msystem";  		// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 		// clave SMTP

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador de Sistema SIPI del SAPI";
 $mail->Subject = "Cambio de Clave Sistema SIPI del SAPI";
 
 $mail->AddAddress($vemail,$nombre);

 $fechahoy = Hoy();
 $horactual= Hora();

 $body  = "<strong>Estimado Usuario(a): </strong>".$nombre." <br><br>";
 $body .= " Le informamos que el d&iacute;a ".$fechahoy." a las ".$horactual.", se le realiz&oacute; el cambio de su clave de acceso al sistema SIPI";
 $body .= " de manera satisfactoria.<br>";
 $body .= "<br><br>Su nueva clave es: <strong>".$clave."</strong><br>";
 $body .= "<br><br>Clave la cual podr&aacute; cambiar por otra si lo desea en la Opci&oacute;n: <strong>Cambio de Clave del menu Mantenimiento</strong><br>";
 $body .= " Atentamente<br>";
 $body .= " Administrador<br>";
 $body .= " Sistema de Informaci&oacute;n de Propiedad Intelectual - SIPI <br><br>";
 $body .= "<font color='red'>NOTA: Esta es una cuenta de correo NO Monitoreada, por favor no responda.</font>";
 $mail->Body = $body;
 $mail->AltBody = "x PHPMailer\n";

 $exito = $mail->Send();
 $intentos=1;
 while ((!$exito) && ($intentos < 5)) {
   sleep(5);
   $exito = $mail->Send();
   $intentos=$intentos+1;
 }
 
 if (!$exito) { 
   echo "<br><br><br>";
   echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
   echo "   <tr bgcolor='#4682B4'>";
   echo "     <td colspan='2' height='60'>";
   echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
   echo "     </td>";
   echo "     <td colspan='1' height='60'>";
   echo "       <div align='center'><font face='Arial' color='#FFFFFF' size='2'><b>ERROR: Problemas al enviar el correo, intente de nuevo ...!!!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><font color='#FFFF00'></b></font>";
   echo "       </div>";
   echo "     </td>";
   echo "   </tr>";
   echo "</table>";
   //echo "<p align='center'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</p>";
   echo "<p align='center'><a href='../index1.php'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";



   echo "<div align='center'>";
   echo "<tr><td>&nbsp;</td></tr>";
   echo "<tr><td>&nbsp;</td></tr>";
   echo "<p>";
   echo "<font size='-2'>Coordinaci&oacute;n de Inform&aacute;tica - SAPI <p></b>&nbsp;Caracas, Venezuela - CopyLeft 2010 / Decreto No. 3.390 </font></p>";
   echo "<hr />   ";
   echo "</div>";
   exit();

 }
  
}

?>
</body>
</html>
