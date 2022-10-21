<?php
// *************************************************************************************
// Programa: z_genpasswd.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: I Semestre 2008
// Modificado el Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

require("$include_lib/class.password.generator.php");
require("$include_lib/class.phpmailer.php");
include("$include_lib/class.smtp.php");

?>
<html>
<head>
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body onload="javascript:history.back();" bgcolor="#D8E6FF">
<?php
 $tbname_1 = "stzusuar";
 $cedula = $_GET['ced'];
 $nombre = $_GET['nom'];
 $usuario= $_GET['usr'];
 $vemail = $_GET['email'];
 $passwordgen = trim($DOZPASSGEN->genPassword());
 
 $mail = new PHPMailer();
 $mail->IsSMTP();                      // enviar vía SMTP
 $mail->Host = "172.16.0.5";
 $mail->SMTPAuth = true;     				// activar la identificacín SMTP

 //Valores Anteriores
 //$mail->Username = "adminsipi";  			// usuario SMTP
 //$mail->Password = "sapi2014"; 		   // clave SMTP

 //Valores Nuevos 
 $mail->Port = 587;
 $mail->SMTPSecure = "tls";
 $mail->Username = "adminsipi@sapi.gob.ve";  	// usuario SMTP
 $mail->Password = "sipi2013"; 	// clave SMTP

 $mail->From = "adminsipi@sapi.gob.ve";
 $mail->FromName = "Administrador de Sistema";
 $mail->Subject = "Cambio de Clave - Usuario SIPI";
 
 $mail->AddAddress($vemail,$nombre);
 $mail->AddCC("adminsipi@sapi.gob.ve");

 $fecha = fechahoy();
 $hora  = hora();
 $body  = "<strong>Estimado Usuario(a): </strong>".$usuario." <br><br>";
 $body .= " Le informamos que el d&iacute;a ".$fecha." a las ".$hora.", se le realiz&oacute; el cambio de su clave a: <strong>".$passwordgen."</strong>";
 $body .= " de manera satisfactoria.<br><br>";
 $body .= " Atentamente<br>";
 $body .= " Administrador<br>";
 $body .= " Sistema de Marcas, Patentes y Derecho de Autor - SIPI<br><br>";
 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - SAPI<br/>";
 $body .= " Ministerio del poder Popular de Econom&iacute;a y Finanzas.<br/>";
 $body .= " Portal: www.sapi.gob.ve<br>";
  $body .= "<font color='red'>NOTA: Esta es una cuenta de correo NO Monitoreada, por favor no responda.</font>";
 $mail->Body = $body;
 $mail->AltBody = "x PHPMailer\n";

 //$mail->AddAttachment("images/foto.jpg", "foto.jpg");
 //$mail->AddAttachment("files/demo.zip", "demo.zip");

 $exito = $mail->Send();
 $intentos=1;
 while ((!$exito) && ($intentos < 5)) {
   sleep(5);
   $exito = $mail->Send();
   $intentos=$intentos+1;
 }

 //Uso de md5 para encriptar el password
 $clave = md5($passwordgen); 

 if (!$exito) { echo "Problemas al enviar el correo"; }
 else { 
   echo "Su mensaje ha sido entregado sin ningun problema";
   $sql = new mod_db();
   //Verificando conexion      
   $sql->connection();
   // Comienzo de Transaccion   
   pg_exec("BEGIN WORK");
   
   $update_str = "pass='$clave'";
   $act_user = $sql->update("$tbname_1","$update_str","cedula='$cedula'");

   // Verificacion y actualizacion real de los Datos en BD 
   if ($act_user) {
     pg_exec("COMMIT WORK"); }
   else {
     pg_exec("ROLLBACK WORK"); }
   //Desconexion de la Base de Datos
   $sql->disconnect(); exit();   
    
 }

//Desconexion de la Base de Datos
//$sql->disconnect();
?>
</body>
</html>
