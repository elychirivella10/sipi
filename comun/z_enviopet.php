<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de enviar la Informacion del Peticionario por Correo ?'); }

</script>

<?php
// *************************************************************************************
// Programa: z_enviopet.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Año: 2017 I Semestre
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
$tbname_1 = "stzbuspet";
$tbname_2 = "stzusuar";
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

$smarty->assign('subtitulo','ENVIO DE ARCHIVOS BUSQUEDAS PETICIONARIO PDF WEBPI POR CORREO');
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
 //$obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE estado='2' ORDER BY nro_tramite,tipo_busq,nro_pedido,ref_busq");
 $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE estado='2' ORDER BY nro_tramite,tipo_busq,nro_pedido,ref_busq");
 $filas_found=$sql->nums('',$obj_query); //echo "$filas_found";
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
 $fechahoy = hoy();
 for($cont=0;$cont<$filas_found;$cont++) {
   $cuenta  = trim($objs->usuario);
   $tramite = trim($objs->nro_tramite);
   $tipo    = trim($objs->tipo_busq);
   $refbusq = trim($objs->ref_busq);
   $nombre  = trim($objs->solicitante);
   $nropedido=trim($objs->nro_pedido);
   $npedido       = "BP".$tipo.str_pad($nropedido,6,"0",STR_PAD_LEFT); 

   //$archivo   = $rutafinal.trim($npedido).".pdf";
   
   $horactual = Hora();
   $vruta="/apl/webpi/peticionario/";
   if ((($usrant!=$cuenta) || ($tramant!=$tramite)) || ($indc==1)) {
     //echo " nueva cuenta = $cuenta, con $tramite y $refbusq $nombre $tipo ";
     $adjuntos = array();
     $count = count($adjuntos);
     //$filepdf = $vruta.trim($refbusq).".pdf";
     $filepdf = $vruta.trim($npedido).".pdf"; 
     //echo " archivo $filepdf existe ";
     //if (file_exists($filepdf)) { echo " archivo $filepdf existe "; } else { echo " archivo $filepdf NO EXISTE "; } 
     $adjuntos[$count+1]['filename']=$vruta.trim($npedido).".pdf";
     //$adjuntos[$count+1]['filename']=$vruta.trim($refbusq).".pdf";
     $adjuntos[$count+1]['ruta']=$vruta;
     //$adjuntos[$count+1]['ref']=trim($refbusq);
     $indc = 0;
     //$update_str = "estado='3'";
     //$act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite=$tramite  AND tipo_busq='$tipo' AND ref_busq=$refbusq AND estado='2'");
     $resveri = pg_exec("UPDATE stzbuspet SET estado='3',fecha_envio='$fechahoy',hora_envio='$horactual',user_envio='$usuario' WHERE usuario='$cuenta' AND nro_tramite=$tramite  AND tipo_busq='$tipo' AND ref_busq=$refbusq");
     // Verificacion de actualizacion BD  
     if ($act_user) { }
     else { $numerror = $numerror + 1; }
   }
   else {
     //echo " misma cuenta = $cuenta, con $tramite y $refbusq ";
     $count = count($adjuntos); 
     $filepdf = $vruta.trim($npedido).".pdf";
     //$filepdf = $vruta.trim($refbusq).".pdf";
     //if (file_exists($filepdf)) { echo " archivo $filepdf existe "; } else { echo " archivo $filepdf NO EXISTE "; }
     //$adjuntos[$count+1]['filename']=$vruta.trim($refbusq).".pdf";
     $adjuntos[$count+1]['filename']=$vruta.trim($npedido).".pdf";
     $adjuntos[$count+1]['ruta']=$vruta;
     //$adjuntos[$count+1]['ref']=trim($refbusq);
     //$update_str = "estado='3'";
     //$act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite=$tramite AND tipo_busq='$tipo' AND ref_busq=$refbusq AND estado='2'"); 
     $resveri = pg_exec("UPDATE stzbuspet SET estado='3',fecha_envio='$fechahoy',hora_envio='$horactual',user_envio='$usuario' WHERE usuario='$cuenta' AND nro_tramite=$tramite  AND tipo_busq='$tipo' AND ref_busq=$refbusq");
     // Verificacion de actualizacion BD  
     if ($act_user) { }
     else { $numerror = $numerror + 1; }
   }
   //Envio al correo del archivo ...  
   $objs = $sql->objects('',$obj_query);
   if ($usrant!=trim($objs->usuario) || $tramant!=trim($objs->nro_tramite)) {  
     //echo "cuenta anterior= $usrant con archivos adjuntos: ";
     if (!empty($adjuntos)) {
       foreach ($adjuntos as $attachment) {
         if (empty($attachment['ruta'])) {
           //$mail->AddAttachment($attachment['filename']);
         } else {
           //$mail->AddAttachment($attachment['filename'], $attachment['ruta']);
           //echo $attachment['filename']."  ".$attachment['ruta']."  ";
           //echo $attachment['filename'];
           
           //echo $attachment['ref'];
           //$nref = $attachment['ref']; 
           //echo "$cuenta-$tipo-$tramite"; 
           //$update_str = "estado='3'";
           //$act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite='$tramite' AND tipo_busq='$tipo' AND ref_busq='$nref'");
           //$resveri = pg_exec("UPDATE stmbusweb SET estado='3' WHERE usuario='$cuenta' AND nro_tramite=$tramite  AND tipo_busq='$tipo' AND ref_busq=$refbusq");
         }
       }
     } 
     //echo " busqueda del nombre ";
     //$obj_usr = $sql->query("SELECT nombres,apellidos FROM $tbname_2 WHERE usuario='$usrant'");
     //$objsusr = $sql->objects('',$obj_usr);
     //$nombre  = trim($objsusr->nombres)." ".trim($objsusr->apellidos);

     //Actualizacion de Estatus del tramite en Webpi y envio por Correo
     $vcant = 0;
     $obj_bus = $sql->query("SELECT count(*) AS veredo FROM stzbuspet WHERE estado IN ('1','2') AND nro_tramite='$tramite'");
     $objebus = $sql->objects('',$obj_bus);
     $vcant   = $objebus->veredo;  
     //echo "ARCHIVOS REVISADOS = $vcant de: $usrant".$tramite;

     if ($vcant==0) { 
       //echo " entro a enviar ";
       $actbusq    = true;
       $update_str = "estatus_tra='57',fecha_estatus='$fechahoy'"; 
       $actbusq    = $sql1->update1("stztramite","$update_str","nro_tramite='$tramite' AND estatus_tra='56'");
       correo($sql_mail,$usrant,$nombre,$tramite,$adjuntos);
     } else {
       $update_str = "estado='2'";
       $act_user = $sql->update("$tbname_1","$update_str","usuario='$cuenta' AND nro_tramite='$tramite' AND estado='3'");
     }
     $usrant = trim($objs->usuario); $indc = 1; 
     $tramant = trim($objs->nro_tramite);
   }
 }

 if ($numerror==0) { 
   pg_exec("COMMIT WORK"); 
   $vmessage="RESULTADOS DE BUSQUEDAS WEBPI ENVIADOS CORRECTAMENTE POR CORREO(S) ...!!";
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

$smarty->display('z_enviopet.tpl');
$smarty->display('pie_pag.tpl');

//************************************************************************************
function correo($sql_mail,$vemail,$nombre,$tramite,$adjuntos) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 //$mail->CharSet = "UTF­8";
 //$mail->Encoding= "quoted­printable";

 //Otros Valores
 //$mail->Mailer = "smtp";
 //$mail->SMTPDebug  = 0;
 //$mail->Host = "ssl://172.16.0.2"; 

 //************************************************
 // Valores anteriores
 //$mail->Username = "msystem";  	// usuario SMTP
 //$mail->Password = "M6ccs9Ve"; 	// clave SMTP
 //************************************************

 //Valores Nuevos 
 $mail->Port = 587;
 $mail->SMTPSecure = "tls";
 $mail->Username = "adminbusqsipi@sapi.gob.ve";  	// usuario SMTP
 $mail->Password = "mssbsip1"; 	// clave SMTP

 $mail->From = "adminbusqsipi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema Busqueda WEBPI - SAPI";
 $mail->Subject = "Envio de Solicitud(es) de Busqueda(s) Peticionario(s) en Linea, Tramite WEBPI No. ".$tramite;
 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminbusqsipi@sapi.gob.ve','Administrador del Sistema Busqueda WEBPI - SAPI');
 //$mail->AddBCC('romulo.mendoza@sapi.gob.ve','Administrador del Sistema Busqueda WEBPI - SAPI');
 //$mail->AddBCC('mendozaromulo04@gmail.com','Administrador Sistemas');
 //$mail->AddBCC('mendozaromulo04@hotmail.com','Administrador Sistemas');

 //Verificando conexion
 $sql = new mod_db();
 $sql->connection();
 $tbname_1 = "stzbuspet";

 if (!empty($adjuntos)) {
   foreach ($adjuntos as $attachment) {
     $mail->AddAttachment($attachment['filename']);
   }
 } 

 $body  = "<strong>Estimada(o) Usuaria(o): </strong>".$nombre." <br><br>";

 $body .= "Anexo al presente, le hacemos llegar el(los) resultado(s) de la(s) b&uacute;squeda(s) de peticionario(s) solicitada(s) por usted en el Webpi, y relacionada(s) al tramite n&uacute;mero <strong>".$tramite."</strong>.<br><br>";
 $body .= "Si el correo enviado llego sin el(los) archivo(s) PDF con el(los) resultado(s) adjunto(s), favor comuniquese a trav&eacute;s del correo electr&oacute;nico: adminbusqsipi@sapi.gob.ve e indique el N&uacute;mero de Tr&aacute;mite, N&uacute;mero de Pedido y referencia(s) de archivo(s) asociado(s) que no llegaron. Una vez recibido su reclamo, le ser&aacute; atendido prontamente.<br><br>";
 $body .= "Gracias por usar nuestro servicio en l&iacute;nea.<br><br>";

 $body .= "<table width='100%' border='1'>";
 $body .= " <tr>";
 $obj_filas = 0;
 $obj_fone  = $sql->query("SELECT * FROM $tbname_1 where nro_tramite='$tramite' ORDER BY nro_pedido");
 $obj_filas = $sql->nums('',$obj_fone); //echo "correo $obj_filas ";
 if ($obj_filas>0) {
   $body .= "   <tr>";
   $body .= "     <td colspan='5' align='left'><b><H3><I>Relaci&oacute;n de Peticionarios Solicitados</I></H3></b></td>";
   $body .= "   </tr>";
   $body .= "   <tr>";
   $body .= "     <td width='12%' align='left'><b>Pedido Nro.</b></td>";
   $body .= "     <td width='12%' align='left'><b>Referencia</b></td>";
   $body .= "     <td width='58%' align='left'><b>Titular</b></td>";
   $body .= "     <td width='07%' align='left'><b>Tipo</b></td>";
   $body .= "     <td width='12%' align='left'><b>Fecha Solicitud</b></td>";
   $body .= "   </tr>";

   $cont = 0;
   $objs = $sql->objects('',$obj_fone);
   for ($cont=0;$cont<$obj_filas;$cont++) {
     $bnombre = trim(utf8_decode($objs->peticionario));
     $body .= "   <tr>";
     $body .= "     <td width='12%' align='left'>$objs->nro_pedido</td>";
     $body .= "     <td width='12%' align='left'>$objs->ref_busq</td>";
     $body .= "     <td width='58%' align='left'>$bnombre</td>";
     $body .= "     <td width='07%' align='left'>$objs->tipo_busq</td>";
     $body .= "     <td width='12%' align='left'>$objs->fecha_bus</td>";
     $body .= "   </tr>";
     $objs = $sql->objects('',$obj_fone); 
   }
   $body .= "   <tr>";
   $body .= "     <td colspan='5' align='left'><b><I>Total B&uacute;squedas.: $obj_filas</I></b></td>";
   $body .= "   </tr>";
 }
 $body .= " </tr>";
 $body .= "</table>";

 $body .= "IMPORTANTE: Le recordamos que para ingresar de manera exitosa en el sistema WEBPI debe tener activada la opci&oacute;n de visualizaci&oacute;n de ventanas emergentes (popup) en su navegador web.<br><br>";
 $body .= "Para mayor informaci&oacute;n o realizar alg&uacute;n reclamo y/o sugerencia, comun&iacute;quese con nosotros por la central telef&oacute;nica (0212) 481.64.78 / 484.29.07 y con gusto le atenderemos.<br><br>";

 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - S.A.P.I.<br/>";
 $body .= " Ministerio del Poder Popular de Comercio Nacional - MPPCN<br/>";
 $body .= " Portal: www.sapi.gob.ve<br>";
 $body .= "<font color='red'>NOTA: Esta es una direcci&oacute;n de correo NO Monitoreada, por favor no responda ni reenv&iacute;e mensajes a esta cuenta.</font>";

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
