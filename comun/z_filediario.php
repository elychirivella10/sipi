<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de enviar la Informacion por Correo ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_filediario.php 
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
$fechahoy = $_POST['fechahoy'];
if (empty($fechahoy)) { $fechahoy = hoy(); }

$smarty->assign('subtitulo','ENVIO DE ARCHIVOS PARA MENSAJES DE TEXTOS DIARIOS');
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

 $ejecute1 = pg_exec("select '9999000000' as solicitud,'M' as tipo,'0414-3115457' as tel1,'0416-6205196' as tel2,
'SAPI informa: su solicitud de marca 9999-000000 ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(c.telefono1) as tel1,
trim(c.telefono2) as tel2,'SAPI informa: su solicitud de marca '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from stzderec a, stzottid b, stzsolic c 
 where a.nro_derecho=b.nro_derecho and  b.titular=c.titular and 
       a.nro_derecho in (select nro_derecho from stzevtrd where evento=1200 and fecha_trans='$fechahoy') and
       (trim(c.telefono1)<>'' or trim(c.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(b.telefono1) as tel1,trim(b.telefono2) as tel2,
'SAPI informa: su solicitud de marca '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from stzderec a, stztramr b 
 where a.idtramitante=b.idtramitante and 
       a.nro_derecho in (select nro_derecho from stzevtrd where evento=1200 and fecha_trans='$fechahoy') and
       (trim(b.telefono1)<>'' or trim(b.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(c.telefono1) as tel1,trim(c.telefono2) as tel2,
'SAPI informa: su solicitud de marca '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from stzderec a, stzautod b, stzagenr c 
 where a.nro_derecho=b.nro_derecho and  b.agente=c.agente and 
       a.nro_derecho in (select nro_derecho from stzevtrd where evento=1200 and fecha_trans='$fechahoy') and
       (trim(c.telefono1)<>'' or trim(c.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(a.telefono1) as tel1,trim(a.telefono2) as tel2,
'SAPI informa: su solicitud de marca '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from webpisipi_sms a, stzderec b
 where a.solicitud=b.solicitud and a.tipo_mp=b.tipo_mp and
       b.nro_derecho in (select nro_derecho from stzevtrd where evento=1200 and fecha_trans='$fechahoy') and
       (trim(a.telefono1)<>'' or trim(a.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(c.telefono1) as tel1,trim(c.telefono2) as tel2,
'SAPI informa: su solicitud de Patente '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from stzderec a, stzottid b, stzsolic c 
 where a.nro_derecho=b.nro_derecho and  b.titular=c.titular and 
       a.nro_derecho in (select nro_derecho from stzevtrd where evento=2200 and fecha_trans='$fechahoy') and
       (trim(c.telefono1)<>'' or trim(c.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(b.telefono1) as tel1,trim(b.telefono2) as tel2,
'SAPI informa: su solicitud de Patente '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from stzderec a, stztramr b 
 where a.idtramitante=b.idtramitante and 
       a.nro_derecho in (select nro_derecho from stzevtrd where evento=2200 and fecha_trans='$fechahoy') and
       (trim(b.telefono1)<>'' or trim(b.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(c.telefono1) as tel1,trim(c.telefono2) as tel2,
'SAPI informa: su solicitud de Patente '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from stzderec a, stzautod b, stzagenr c 
 where a.nro_derecho=b.nro_derecho and  b.agente=c.agente and 
       a.nro_derecho in (select nro_derecho from stzevtrd where evento=2200 and fecha_trans='$fechahoy') and
       (trim(c.telefono1)<>'' or trim(c.telefono2)<>'')
union
select substring(a.solicitud,1,4)||substring(a.solicitud,6,6) as solicitud,a.tipo_mp as tipo,trim(a.telefono1)as tel1,trim(a.telefono2) as tel2,
'SAPI informa: su solicitud de Patente '||a.solicitud||' ha sido presentada. Para mayor informacion visite http://webpi.sapi.gob.ve' as comentario
  from webpisipi_sms a, stzderec b
 where a.solicitud=b.solicitud and a.tipo_mp=b.tipo_mp and
       b.nro_derecho in (select nro_derecho from stzevtrd where evento=2200 and fecha_trans='$fechahoy') and
       (trim(a.telefono1)<>'' or trim(a.telefono2)<>'')
union
select a.solicitud,'D' as tipo,trim(c.telefono1) as tel1,trim(c.telefono2) as tel2,
'SAPI informa: su solicitud de obra '||a.solicitud||' ha sido cargada en sistema. Para consultar estatus visite http://webpi.sapi.gob.ve' as comentario
  from stdobras a, stdobsol b, stzsolic c 
 where a.nro_derecho=b.nro_derecho and  b.titular=c.titular and 
       a.nro_derecho in (select nro_derecho from stdevtrd where evento=200 and fecha_trans='$fechahoy') and
       (trim(c.telefono1)<>'' or trim(c.telefono2)<>'')
union
select a.solicitud,'D' as tipo,trim(c.telefono1) as tel1,trim(c.telefono2) as tel2,
'SAPI informa: su solicitud de obra '||a.solicitud||' ha sido cargada en sistema. Para consultar estatus visite http://webpi.sapi.gob.ve' as comentario
  from stdobras a, stdobtit b, stzsolic c 
 where a.nro_derecho=b.nro_derecho and  b.titular=c.titular and 
       a.nro_derecho in (select nro_derecho from stdevtrd where evento=200 and fecha_trans='$fechahoy') and
       (trim(c.telefono1)<>'' or trim(c.telefono2)<>'')
order by 1");

//Crea el archivo
$vruta="../../intelcon/smsdiarios/";
$fechaesp=substr($fechahoy,6,4).substr($fechahoy,3,2).substr($fechahoy,0,2);
$txt=$vruta.'sms_presentadas_'.$fechaesp;
$open=fopen($vruta.'sms_presentadas_'.$fechaesp,"w+");
$filas=pg_numrows($ejecute1);
//Llena el archivo
for($cont=0;$cont<$filas;$cont++) {
   $reg = pg_fetch_array($ejecute1);
   $linea=$reg['solicitud'].'|'.$reg['tipo'].'|'.$reg['tel1'].'|'.$reg['tel2'].'|'.$reg['comentario']."\n";
   fputs($open,"$linea");
}
//Cierra el archivo
fclose($open);  

 $numerror = 0;
 $act_user = true;
 $adjuntos = array();
 $count = count($adjuntos);
 $adjuntos[$count+1]['filename']=$vruta."sms_presentadas_".$fechaesp;
 $adjuntos[$count+1]['ruta']=$vruta;

 $usrant='nelson.gonzalez@sapi.gob.ve';
 $nombre='Nelson Gonzalez';

 if (file_exists($filetxt)) { $fexiste="SI"; } else { $fexiste="NO"; }

 $vvar= correo($sql_mail,$usrant,$nombre,$fechahoy,$adjuntos,$filetxt,$fexiste);
 
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

$smarty->display('z_filediario.tpl');
$smarty->display('pie_pag.tpl');

//************************************************************************************
function correo($sql_mail,$vemail,$nombre,$fechahoy,$adjuntos,$filetxt,$fexiste) {
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
 $mail->Subject = "SAPI - Mensajes de Texto - ".$fechahoy;
// $mail->AddAddress($vemail,$nombre);
 $mail->AddAddress('nelson.gonzalez@sapi.gob.ve','Nelson Gonzalez');
// $mail->AddBCC('juan.cartaya@tecno-red.com.ve','Tecno-Red');
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
 $body .= "Anexo al presente, le hacemos entrega del archivo plano con los datos de las diferentes solicitudes presentadas ante el S.A.P.I. ";
 $body .= "el dia de hoy ".$fechahoy.", ";
 $body .= "con la finalidad de que se realice en envio de los mensajes de voz y de texto correspondientes.<br/><br/>";
 $body .= "Nelson Gonzalez<br/>";
 $body .= "Coordinaci&oacute;n de Inform&aacute;tica<br>";
 $body .= "Servicio Autonomo de la Propiedad Intelectual<br>";
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
