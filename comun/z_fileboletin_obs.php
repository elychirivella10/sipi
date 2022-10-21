<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de enviar la Informacion por Correo ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_fileboletin_obs.php 
// Realizado por el Analista de Sistema Nelson Gonzalez 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2017
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include("$include_lib/class.phpmailer.php"); 
include("$include_lib/class.smtp.php");

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
$boletin  = $_POST['boletin'];

$smarty->assign('subtitulo','ENVIO DE ARCHIVOS PARA MENSAJES DE TEXTOS ASOCIADOS AL BOLETIN');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fechahoy);
$smarty->display('encabezado1.tpl');

if ($vopc==2) {
 //Verificando conexion Webpi
 $sql1 = new mod_db();
 $sql1->connection1();

 //Verificando conexion SIPI
 $sql = new mod_db();
 $sql->connection();

 $ejecute1 = pg_exec("SELECT substr(trim(telefono1),2,3) as t1, substr(trim(telefono1),6,7) as telefono, concat('SAPI INFORMA: SU SOLICITUD ',solicitud,' FUE NOTIFICADA COMO OBSERVADA EN EL BOLETIN ',$boletin,'. PARA MAYOR INFORMACION INGRESE EN WEBPI.') as mensaje
 FROM stzderec a, stzevtrd b, stzottid c, stzsolic d
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              a.nro_derecho=c.nro_derecho and c.titular=d.titular and c.titular>0 and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento=$boletin and
              trim(d.telefono1)<>'' and substr(trim(d.telefono1),1,4) in ('0414','0424','0416','0426','0412')
UNION
SELECT substr(trim(telefono2),2,3) as t1, substr(trim(telefono2),6,7) as telefono, concat('SAPI INFORMA: SU SOLICITUD ',solicitud,' FUE NOTIFICADA COMO OBSERVADA EN EL BOLETIN ',$boletin,'. PARA MAYOR INFORMACION INGRESE EN WEBPI.') as mensaje
 FROM stzderec a, stzevtrd b, stzottid c, stzsolic d
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              a.nro_derecho=c.nro_derecho and c.titular=d.titular and c.titular>0 and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento=$boletin and
              trim(d.telefono2)<>'' and substr(trim(d.telefono2),1,4) in ('0414','0424','0416','0426','0412')
UNION
SELECT substr(trim(telefono1),2,3) as t1, substr(trim(telefono1),6,7) as telefono, concat('SAPI INFORMA: SU SOLICITUD ',solicitud,' FUE NOTIFICADA COMO OBSERVADA EN EL BOLETIN ',$boletin,'. PARA MAYOR INFORMACION INGRESE EN WEBPI.') as mensaje
 FROM stzderec a, stzevtrd b, stztramr d
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              a.idtramitante=d.idtramitante and a.idtramitante>0 and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento=$boletin and
              trim(d.telefono1)<>'' and substr(trim(d.telefono1),1,4) in ('0414','0424','0416','0426','0412')
UNION
SELECT substr(trim(telefono2),2,3) as t1, substr(trim(telefono2),6,7) as telefono, concat('SAPI INFORMA: SU SOLICITUD ',solicitud,' FUE NOTIFICADA COMO OBSERVADA EN EL BOLETIN ',$boletin,'. PARA MAYOR INFORMACION INGRESE EN WEBPI.') as mensaje
 FROM stzderec a, stzevtrd b, stztramr d
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              a.idtramitante=d.idtramitante and a.idtramitante>0 and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento=$boletin and
              trim(d.telefono2)<>'' and substr(trim(d.telefono2),1,4) in ('0414','0424','0416','0426','0412')
UNION
SELECT substr(trim(telefono1),2,3) as t1, substr(trim(telefono1),6,7) as telefono, concat('SAPI INFORMA: SU SOLICITUD ',solicitud,' FUE NOTIFICADA COMO OBSERVADA EN EL BOLETIN ',$boletin,'. PARA MAYOR INFORMACION INGRESE EN WEBPI.') as mensaje
 FROM stzderec a, stzevtrd b, stzagenr d
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              a.agente=d.agente and a.agente>0 and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento=$boletin and
              trim(d.telefono1)<>'' and substr(trim(d.telefono1),1,4) in ('0414','0424','0416','0426','0412')
UNION
SELECT substr(trim(telefono2),2,3) as t1, substr(trim(telefono2),6,7) as telefono, concat('SAPI INFORMA: SU SOLICITUD ',solicitud,' FUE NOTIFICADA COMO OBSERVADA EN EL BOLETIN ',$boletin,'. PARA MAYOR INFORMACION INGRESE EN WEBPI.') as mensaje
 FROM stzderec a, stzevtrd b, stzagenr d
	WHERE a.nro_derecho=b.nro_derecho and a.tipo_mp='M' and
              a.agente=d.agente and a.agente>0 and
              b.evento=1122 and b.estat_ant=1003 and 
              b.documento=$boletin and
              trim(d.telefono2)<>'' and substr(trim(d.telefono2),1,4) in ('0414','0424','0416','0426','0412')");

//Crea el archivo
$vruta="../../sms/";
$txt=$vruta.'Boletin'.$boletin.'_sms_observadas.txt';
$open=fopen($vruta.'Boletin'.$boletin.'_sms_observadas.txt',"w+");
$filas=pg_numrows($ejecute1);
//Llena el archivo
for($cont=0;$cont<$filas;$cont++) {
   $reg = pg_fetch_array($ejecute1);
   $ntel=ltrim(rtrim($reg['telefono']));
   if (strlen($ntel)==7) {
      $linea=$reg['t1'].';'.$reg['telefono'].';'.$reg['mensaje']."\n";
      fputs($open,"$linea");
   }
}
//Cierra el archivo
fclose($open);  

 $numerror = 0;
 $act_user = true;
 $adjuntos = array();
 $count = count($adjuntos);
 $adjuntos[$count+1]['filename']=$vruta.'Boletin'.$boletin.'_sms_observadas.txt';
 $adjuntos[$count+1]['ruta']=$vruta;

 $usrant='nelson.gonzalez@sapi.gob.ve';
 $nombre='Nelson Gonzalez';

 if (file_exists($filetxt)) { $fexiste="SI"; } else { $fexiste="NO"; }

 $vvar= correo($sql_mail,$usrant,$nombre,$fechahoy,$adjuntos,$filetxt,$fexiste,$boletin);
 
 if ($numerror==0) { 
   pg_exec("COMMIT WORK"); 
   $vmessage="ARCHIVO ENVIADO CORRECTAMENTE POR CORREO...!!";
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
//   pg_exec("ROLLBACK WORK"); }
 
 //Desconexion de la Base de Datos
 $sql->disconnect();   

 //Desconexion de la Base de Datos
 $sql1->disconnect1();   }
}

$smarty->assign('varfocus','forsolpre.boletin'); 
$smarty->display('z_fileboletin_obs.tpl');
$smarty->display('pie_pag.tpl');

//************************************************************************************
function correo($sql_mail,$vemail,$nombre,$fechahoy,$adjuntos,$filetxt,$fexiste,$boletin) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 $mail->Port = 587;
 $mail->SMTPSecure = "tls";
// $mail->Username = "adminbusqsipi@sapi.gob.ve";  	// usuario SMTP
 $mail->Username = "nelson.gonzalez@sapi.gob.ve";  	// usuario SMTP
// $mail->Password = "mssbsip1"; 	// clave SMTP
 $mail->Password = "ng.519333"; 	// clave SMTP
// $mail->From = "adminbusqsipi@sapi.gob.ve";
 $mail->From = "nelson.gonzalez@sapi.gob.ve";
// $mail->FromName = "Administrador del Sistema Busqueda WEBPI - SAPI";
// $mail->Subject = "Envio de Solicitud(es) de Busqueda(s) en Linea, Tramite WEBPI No. ".$tramite;
 $mail->FromName = "Nelson Gonzalez";
 $mail->Subject = "SAPI - Mensajes de Texto - Boletin ".$boletin." - OBSERVADAS de MARCAS";
// $mail->AddAddress($vemail,$nombre);
 $mail->AddAddress('bestalia.romero@sapi.gob.ve','Bestalia Romero');
 $mail->AddBCC('despachocasos84@gmail.com','Bestalia Romero');
 $mail->AddBCC('nelson.gonzalez@sapi.gob.ve','Nelson Gonzalez');
// $mail->AddBCC('ricardo.chacon@tecno-red.com.ve','Tecno-Red');
// $mail->AddBCC('albert@tecno-red.com.ve','Tecno-Red');
// $mail->AddBCC('eduardo.finol@tecno-red.com.ve','Tecno-Red');
// $mail->AddBCC('joaquin@tecno-red.com.ve','Tecno-Red');
// $mail->AddBCC('eurdaneta@hotmail.com','Tecno-Red');
 //$mail->AddBCC('romulo.mendoza@sapi.gob.ve','Administrador del Sistema Busqueda WEBPI - SAPI');
 //$mail->AddBCC('mendozaromulo04@gmail.com','Administrador Sistemas');
 //$mail->AddBCC('mendozaromulo04@hotmail.com','Administrador Sistemas');

 //Verificando conexion
 $sql = new mod_db();
 $sql->connection();
// $tbname_1 = "stmbusweb";

 if (!empty($adjuntos)) {
   foreach ($adjuntos as $attachment) {
     $mail->AddAttachment($attachment['filename']);
   }
 } 
//  $mail->AddAttachment($filetxt);

 $body  = "<strong>Estimados Se&ntilde;ores: </strong><br><br>";
 $body .= "Anexo al presente, se hace entrega de archivo plano con los datos de las solicitudes de marcas publicadas como OBSERVADAS ";
 $body .= "en el Boletin de la Propiedad Industrial No. ".$boletin.", ";
 $body .= "con la finalidad de que se realice el envio de los mensajes de texto correspondientes.<br/><br/>";
 $body .= "Nelson Gonzalez<br/>";
 $body .= "Jefe de divisi&oacute;n del Area de Desarrollo de Sistemas<br>";
 $body .= "Direcci&oacute;n de Sistemas y Tecnolog&iacute;as de la Informaci&oacute;n<br>";
 $body .= "Servicio Autonomo de la Propiedad Intelectual (SAPI)<br>";
// $body .= "<br>".$filetxt."<br>Archivo Existe?:".$fexiste;

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
