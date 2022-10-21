<script language="Javascript"> 

function confirmar() { 
  return confirm('Estas seguro de enviar la Informacion ?'); }

</script>

<?php
// *************************************************************************************
// Programa: m_mailbusqext.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollo: Año: II Semestre 2013
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include("$include_lib/class.phpmailer.php"); 
include("$include_lib/class.smtp.php");

?>
<html>
<body>

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables 
$login    = $_SESSION['usuario_login'];
$tbname_1 = "stmbusqueda";
$fecha    = fechahoy();
$vopc     = $_GET['vopc'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','ENVIO DE RESULTADOS BUSQUEDAS FONETICAS EXTERNAS PDF POR CORREO');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('campo1','Nro. de Pedido:');
$smarty->assign('campo2','Fecha de Pedido:');
$smarty->assign('campo3','Fecha de Carga:');
$smarty->assign('campo4','Usuario:');
$smarty->assign('campo5','N&uacute;mero de Factura:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.recibo'); 
}

if ($vopc==2) {
 //Verificando conexion SIPI
 $sql = new mod_db();
 $sql->connection($login);

 //Validacion de Entrada
 $pedido1  = $_POST["pedido1"];
 $pedido2  = $_POST["pedido2"];
 $fecharec = $_POST["fecharec"];
 $desdec   = $_POST["desdec"]; 
 $hastac   = $_POST["hastac"];
 $usuario  = trim($_POST["usuario"]);
 $factura  = trim($_POST['recibo']);

 //Query para buscar las opciones deseadas
 $where=" estatus_envio='N' AND envio='S' "; 

if(empty($pedido1) && empty($pedido2) && empty($fecharec) && empty($desdec) && empty($hastac) && empty($usuario) && empty($factura)) {
    mensajenew('ERROR: NO ingreso ning&uacute;n valor para filtrar el envio ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(!empty($pedido1) && !empty($pedido2)) {
  if ($pedido1 > $pedido2) {
    mensajenew('ERROR: Rango de Pedido erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($where)) {
    $where = $where." (stmbusqueda.nro_pedido>=$pedido1 AND stmbusqueda.nro_pedido<=$pedido2)"; }
  else {
    $where = $where." AND (stmbusqueda.nro_pedido>=$pedido1 AND stmbusqueda.nro_pedido<=$pedido2)"; }
}

if (!empty($fecharec)) {
  $where = $where." AND (stmbusqueda.f_pedido='$fecharec')"; 
}

if(!empty($desdec) && !empty($hastac)) {
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if(empty($where)) {
  $where = $where." (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')"; }
else {
  $where = $where." AND (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')"; }
}

if (!empty($usuario)) { 
  $where = $where." AND (stmbusqueda.usuario='$usuario')"; 
}

if(!empty($factura)) { 
   $where = $where." AND"." (stmbusqueda.nro_recibo='$factura')"; 
}

 // Obtencion de los Registros o Filas   
 $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE $where ORDER BY nro_recibo,nro_pedido");
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   Mensajenew("ERROR: No hay archivos PDF que Enviar por Correo Electr&oacute;nico ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $numerror = 0;
 $act_bus  = true;
 $fechahoy = hoy();
 $horactual=hora();
 //echo "son =$filas_found $pedido1 $pedido2 $fecharec $desdec $hastac $usuario ";
 //exit();
 
 // Comienzo de Transaccion   
 pg_exec("BEGIN WORK");
 $objs = $sql->objects('',$obj_query);
 $usrant = trim($objs->email);
 $tramant = trim($objs->nro_recibo);
 $indc = 1;
 $tipo = 'F';
 $vruta="/home/fonetica/pdfext/fonetica/";
 $vruta="/var/www/apl/sipi/documentos/busquedas/pdfext/fonetica/";
 for($cont=0;$cont<$filas_found;$cont++) {
   $cuenta  = trim($objs->email);
   $factura = trim($objs->nro_recibo);
   $refbusq = trim($objs->nro_pedido);
   $nombre  = trim($objs->solicitante);
   //if ($tipo=="F") { $vruta="/home/fonetica/pdfext/fonetica/"; }   
   //if ($tipo=="G") { $vruta="/home/fonetica/pdfext/grafica/"; }
   if ((($usrant!=$cuenta) || ($tramant!=$factura)) || ($indc==1)) {
     //echo " then nueva cuenta = $cuenta, con $factura y $refbusq $nombre ";
     $adjuntos = array();
     $count = count($adjuntos);
     $filepdf = $vruta.trim($refbusq).".pdf";
     //if (file_exists($filepdf)) { echo " archivo $filepdf existe "; } else { echo " archivo $filepdf NO EXISTE "; } 
     $adjuntos[$count+1]['filename']=$vruta.trim($refbusq).".pdf";
     $adjuntos[$count+1]['ruta']=$vruta;
     $rutafile = $vruta.trim($refbusq).".pdf"; 
     //echo "es = $rutafile";
     //$adjuntos[$count+1]['ref']=trim($refbusq);
     $indc = 0;
     $update_str = "estatus_envio='E',usuario_envio='$login'";
     $act_bus = $sql->update("$tbname_1","$update_str","nro_pedido='$refbusq' AND estatus_envio='N'");
     // Verificacion de actualizacion BD  
     if ($act_bus) { }
     else { $numerror = $numerror + 1; }
   }
   else {
     //echo " else misma cuenta = $cuenta, con $factura y $refbusq ";
     $count = count($adjuntos); 
     $filepdf = $vruta.trim($refbusq).".pdf";
     //if (file_exists($filepdf)) { echo " archivo $filepdf existe "; } else { echo " archivo $filepdf NO EXISTE "; }
     $rutafile = $vruta.trim($refbusq).".pdf"; 
     //echo "es = $rutafile";
     $adjuntos[$count+1]['filename']=$vruta.trim($refbusq).".pdf";
     $adjuntos[$count+1]['ruta']=$vruta;
     //$adjuntos[$count+1]['ref']=trim($refbusq);
     $update_str = "estatus_envio='E',usuario_envio='$login'";
     //$act_bus = $sql->update("$tbname_1","$update_str","nro_pedido='$refbusq' AND nro_recibo='$factura' AND estatus_envio='N'");
     $act_bus = $sql->update("$tbname_1","$update_str","nro_pedido='$refbusq' AND estatus_envio='N'");
     // Verificacion de actualizacion BD  
     if ($act_bus) { }
     else { $numerror = $numerror + 1; }
   }
   //Envio al correo del archivo ...  
   $objs = $sql->objects('',$obj_query);
   if ($usrant!=trim($objs->email) || $tramant!=trim($objs->nro_recibo)) {  
     //echo "envio cuenta anterior= $usrant con archivos adjuntos: ";
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
         }
       }
     } 
     $actbusq    = true;
     $update_str = "estatus_envio='E',fecha_envio='$fechahoy',hora_envio='$horactual',usuario_envio='$login'"; 
     $actbusq    = $sql->update("stmbusqueda","$update_str","nro_recibo='$factura' AND envio='S'");
     if ($numerror==0) { 
       pg_exec("COMMIT WORK"); } 

     correo($sql_mail,$usrant,$nombre,$factura,$adjuntos);
     $usrant = trim($objs->email); $indc = 1; 
     $tramant = trim($objs->nro_recibo);
   }
 }
 $rutapdf = $vruta."*.pdf";
 $rutarespdf = "/home/fonetica/respdffon/";
 ////$cmd = "mv $rutapdf $rutarespdf";
 //$cmd = "cp $ruta $imgfinal";
 //echo "$cmd";
 ////exec($cmd,$salida);
 ////foreach($salida as $line) { 
 //// echo "Hola<br>";	
 //// echo "$line<br>"; }    
 
 
 if ($numerror==0) { 
   pg_exec("COMMIT WORK"); 
   $vmessage="RESULTADO(S) DE BUSQUEDA(S) PDF ENVIADO(S) CORRECTAMENTE POR CORREO(S) ...!!";
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
   //echo "<p align='center'><a href='../index1.php'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";
   echo "<p align='center'><a href='../comun/m_mailbusqext.php?vopc=1'><input type='image' name='continuar' value='Continuar' onclick='window.close()' src='../imagenes/apply_f2.png' alt='Continuar' align='middle' border='0' />Continuar</a></p>";
   echo "<br>";
   
   $smarty->display('pie_pag.tpl'); 
   //Desconexion de la Base de Datos
   $sql->disconnect(); exit();    
 }
 else {
   pg_exec("ROLLBACK WORK"); }
 
 //Desconexion de la Base de Datos
 $sql->disconnect();   
}

$smarty->display('m_mailbusqext.tpl');
$smarty->display('pie_pag.tpl');

//************************************************************************************
function correo($sql_mail,$vemail,$nombre,$tramite,$adjuntos) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 
 //Valores Anteriores
 //$mail->Username = "msystem";  	// usuario SMTP
 //$mail->Password = "M6ccs9Ve"; 	// clave SMTP

 //Valores Nuevos 
 $mail->Port = 587;
 $mail->SMTPSecure = "tls";
 $mail->Username = "adminbusqsipi@sapi.gob.ve";  	// usuario SMTP
 $mail->Password = "mssbsip1"; 	// clave SMTP

 $mail->From = "adminbusqsipi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema Busqueda SIPI - SAPI";
 $mail->Subject = "Envio de Solicitud(es) de Busqueda(s) Fonetica(s) SAPI, Factura No. ".$tramite;

 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminbusqsipi@sapi.gob.ve','Administrador Busqueda Sipi');

 //Verificando conexion
 $sql = new mod_db();
 $sql->connection();
 $tbname_1 = "stmbusqueda";

 if (!empty($adjuntos)) {
   foreach ($adjuntos as $attachment) {
     $mail->AddAttachment($attachment['filename']);
   }
 } 
 $body  = "<strong>Estimada(o) Usuaria(o): </strong>".$nombre." <br><br>";
 $body .= "Anexo al presente, le hacemos llegar el(los) resultado(s) de la(s) b&uacute;squeda(s) fon&eacute;tica(s) solicitada(s) por usted en el Sapi, y relacionada(s) a la Factura n&uacute;mero <strong>".$tramite."</strong>.<br><br>";

 $body .= "<table width='100%' border='1'>";
 $body .= " <tr>";
 $obj_filas = 0;
 $obj_fone  = $sql->query("SELECT * FROM $tbname_1 where nro_recibo='$tramite' ORDER BY nro_pedido");
 $obj_filas = $sql->nums('',$obj_fone);
 if ($obj_filas>0) {
   $body .= "   <tr>";
   $body .= "     <td colspan='4' align='left'><b><H3><I>B&uacute;squedas Foneticas Solicitadas</I></H3></b></td>";
   $body .= "   </tr>";
   $body .= "   <tr>";
   $body .= "     <td width='14%' align='left'><b>Pedido No</b></td>";
   $body .= "     <td width='60%' align='left'><b>Denominaci&oacute;n</b></td>";
   $body .= "     <td width='08%' align='left'><b>Clase</b></td>";
   $body .= "     <td width='12%' align='left'><b>Fecha Solicitud</b></td>";
   $body .= "   </tr>";

   $cont = 0;
   $objs = $sql->objects('',$obj_fone);
   for ($cont=0;$cont<$obj_filas;$cont++) {
     $bnombre = trim(utf8_decode($objs->denominacion));
     $body .= "   <tr>";
     $body .= "     <td width='14%' align='left'>$objs->nro_pedido</td>";
     $body .= "     <td width='60%' align='left'>$bnombre</td>";
     $body .= "     <td width='08%' align='left'>$objs->clase</td>";
     $body .= "     <td width='08%' align='left'>$objs->f_pedido</td>";
     $body .= "   </tr>";
     $objs = $sql->objects('',$obj_fone); 
   }
   $body .= "   <tr>";
   $body .= "     <td colspan='4' align='left'><b><I>Total B&uacute;squedas.: $obj_filas</I></b></td>";
   $body .= "   </tr>";
 }
 $body .= " </tr>";
 $body .= "</table>";

 $body .= "Si la informaci&oacute;n enviada no esta completa, favor comuniquese a trav&eacute;s del correo electr&oacute;nico: adminbusqsipi@sapi.gob.ve e indique que N&uacute;mero(s) de Pedido(s) de b&uacute;squeda(s) no llegaron. Una vez recibido su reclamo, le sera atendido prontamente.<br><br>";

 $body .= "Se le informa que desde el 02/09/2014 se puso a disposici&oacute;n del usuario en el WEBPI la posibilidad de solicitar su Tr&aacute;mite de B&uacute;squeda Fon&eacute;tica o Gr&aacute;fica desde la comodidad de su Hogar u Oficina, para lo cual previamente deber&aacute; cancelar en la Entidad Bancaria autorizada el costo del servicio, dado que es requisito inicial en la carga de las b&uacute;squedas.<br><br>";
 $body .= "Para que el dep&oacute;sito sea v&aacute;lido en nuestro sistema, el usuario deber&aacute; depositar el monto correspondiente a la(s) b&uacute;squeda(s) al menos con 24 Horas de anticipaci&oacute;n a los efectos de poder conciliar el pago. Es por ello que ser&aacute;n v&aacute;lidos todos los dep&oacute;sitos a partir del d&iacute;a Lunes 01/09/2014.";
 $body .= " As&iacute; mismo deber&aacute;n pagar en dep&oacute;sitos separados lo concernientes a las b&uacute;squedas fon&eacute;ticas o gr&aacute;ficas como actualmente se lleva a cabo directamente en nuestras taquillas, por tanto se entiende que la carga al sistema se har&aacute; por n&uacute;meros de dep&oacute;sitos distintos, es decir un dep&oacute;sito esta relacionado solamente a un tipo de b&uacute;squeda bien sea Fon&eacute;tica o Gr&aacute;fica.<br><br>";
 $body .= "El Costo de una B&uacute;squeda de Antecedentes Fon&eacute;tico es de <b>Bs. 1.500,00</b> mas <b>Bs. 50,00</b> del costo de la planilla b&uacute;squeda por cada clase a buscar y el de una B&uacute;squeda de Antecedentes Gr&aacute;fico de <b>Bs. 1.500,00</b> mas <b>Bs. 50,00</b> del costo de la planilla b&uacute;squeda por cada clase a buscar.";
 $body .= " En el caso de que la B&uacute;squeda sea Gr&aacute;fica, el logotipo o imagen debe estar en formato <b>jpg</b> de <b>4x4 cms</b> y que no exceda el <b>tama&ntilde;o de 512 Kb</b>.<br><br>";
 $body .= "Una vez introducidos todos los datos y grabada su solicitud de b&uacute;squeda, autom&aacute;ticamente le llegar&aacute; un correo confirmando el tr&aacute;mite, y en los pr&oacute;ximos d&iacute;as, recibir&aacute; el resultado de la b&uacute;squeda en su cuenta correo electr&oacute;nico.";
 $body .= " Es importante que usted llene correctamente el formulario, porque despues de grabar el tr&aacute;mite, no podr&aacute; realizar ninguna modificaci&oacute;n.<br><br>";

 $body .= " <b>IMPORTANTE: Se informa al p&uacute;blico general, que a partir del 15/05/2015 la(s) solicitud(es) de b&uacute;squeda(s) de antecedentes tanto fon&eacute;tica como gr&aacute;fica ser&aacute;n &uacute;nicamente tramitadas v&iacute;a internet, por medio del Servicio en L&iacute;nea (Webpi) en el portal del Sapi; es por ello, que se les recomienda registrarse lo mas pronto posible y comenzar a disfrutar de los beneficios suministrados por esta v&iacute;a.</b><br><br>";
 
 $body .= "Si desea enviarnos alg&uacute;n comentario, sugerencia o recomendaci&oacute;n comuniquese directamente con nosotros a adminbusqsipi@sapi.gob.ve o dirijase a nuestra oficina ubicada en el ";
 $body .= " Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela.";
 $body .= " Horario de Atenci&oacute;n al P&uacute;blico: 8:30AM a 12:00M y de 1:30PM a 4:00PM o por nuestra Central Telef&oacute;nica (0212) 481.64.78 / 484.29.07<br><br>"; 
 $body .= " Para mayor informaci&oacute;n consulte nuestra pagina <strong>www.sapi.gob.ve</strong>";
 $body .= "<br><br>";

 $body .= " Ministerio del poder Popular de Econom&iacute;a y Finanzas.<br/>";
 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - S.A.P.I.<br/>";
 $body .= " Portal: www.sapi.gob.ve<br>";

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
