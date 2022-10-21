<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

 function habilagen(vcampo,vtipo)
 {
   if (vtipo.value == "A") {
     alert('Debe estar registrado como Agente y poseer numero asignado ...!!!');
     vcampo.disabled = false;
     vcampo.focus() }
   else { vcampo.value=0; vcampo.disabled = true
          }
   if (vtipo.value == "P") {
     alert('Debe presentar Documento Poder en el SAPI para poder tramitar Solicitud(es) de Marca(s) ...!!!');
   }
 }

function cntrlpago(var1,var2,var3,var4,var5) {
  open("adm_ctrlpagos.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&vbol="+var5.value,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function buscarprensa(var1,var2,var3,var4,var5) {
  open("adm_prensa.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&vbol="+var5.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<script language="javascript" type="text/javascript">
//RELOJ 12 HORAS
//
//Autor: Iván Nieto Pérez
//Este script y otros muchos pueden
//descarse on-line de forma gratuita
//en El Código: www.elcodigo.com

var RelojID12 = null
var RelojEjecutandose12 = false

function DetenerReloj12 () {
	if(RelojEjecutandose12)
		clearTimeout(RelojID12)
	RelojEjecutandose12 = false
}

function MostrarHora12 () {
	var ahora = new Date()
	var horas = ahora.getHours()
	var minutos = ahora.getMinutes()
	var segundos = ahora.getSeconds()
	var meridiano

	//ajusta las horas
	if (horas > 12) {
		horas -= 12
		meridiano = " P.M."
	} else {
		meridiano = " A.M."
      	}
        	
   	//establece las horas
	if (horas < 10)
		ValorHora = "0" + horas
	else
		ValorHora = "" + horas

	//establece los minutos
	if (minutos < 10)
		ValorHora += ":0" + minutos
	else
		ValorHora += ":" + minutos
        	
	//establece los segundos
	if (segundos < 10)
		ValorHora += ":0" + segundos
	else
		ValorHora += ":" + segundos
        
	ValorHora += meridiano
 	document.reloj12.digitos.value = ValorHora

	//si se desea tener el reloj en la barra de estado, reemplazar la anterior por esta
  	//window.status = ValorHora

   	RelojID12 = setTimeout("MostrarHora12()",1000)
  	RelojEjecutandose12 = true
}

function IniciarReloj12 () {
   	DetenerReloj12()
  	MostrarHora12()
}

window.onload = IniciarReloj12;
if (document.captureEvents) {			//N4 requiere invocar la funcion captureEvents
	document.captureEvents(Event.LOAD)
}

</script>

<?php
// *************************************************************************************
// Programa: m_pagoderecho.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año 2012 I Semestre
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include("$include_lib/class.phpmailer.php"); 
include("../setting.mysql.php"); 

//Clase que sube el archivo
include ("$include_lib/upload_class.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();
$tbname_1  = "stmmarce";
$tbname_2  = "stzevder";
$tbname_3  = "stzstder";
$tbname_4  = "stzevuserv";
$tbname_5  = "stzusuar";
$tbname_6  = "stzsystem";
$tbname_7  = "stzderec";
$tbname_8  = "stmpagocon";

$vopc      = $_GET['vopc'];
$factura   = $_POST["factura"]; 
$boletin   = $_POST["boletin"];
$resultado = false;
$subtitulo = "Carga de Pagos de Derechos de Marcas";

$smarty->assign('titulo',$substmar);
$smarty->assign('login',$usuario);
$smarty->assign('subtitulo','Relaci&oacute;n de Pagos de Derechos de Registro');
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl'); 
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

//Verificando conexion a Mysql para consulta a facturacion
$mysql = new mod_mysql_db(); 
$mysql->connection_mysql();

//Verificando conexion
$sql->connection();

//Carga el tipo de marca para mostrarlo en el combo
$blanco='';

if ($vopc==3) {
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo','readonly=readonly');

  $vhora_inim = "08:29:00 AM";
  $vhora_finm = "12:01:00 PM";
  $vhora_init = "13:29:00 PM";
  $vhora_fint = "16:01:00 PM";

  //Hora Actual 
  $horactual = Hora();
  //$tiempotrab1 = 1;
  //$tiempotrab2 = 1;
  $tiempotrab1 = Compara_Hora($horactual,$vhora_inim);
  $tiempotrab2 = Compara_Hora($horactual,$vhora_finm); 

  $tiempotrab3 = Compara_Hora($horactual,$vhora_init);
  $tiempotrab4 = Compara_Hora($horactual,$vhora_fint); 

  //Verificacion del Dia que no sea Sabado, Domingo ni Feriado 
  $diahoyes = hoy();
  $dia =substr($diahoyes,0,2);
  $mes =substr($diahoyes,3,2);
  $anio=substr($diahoyes,6,4);
  $fechactual = mktime(0,0,0,$mes,$dia,$anio);  
  $diasemana=date("w", $fechactual);  // 0= Sabado, 6= Domingo 
  $nroferiado = feriado(date("d/m/Y",$fechactual),"1");

  //echo "Dia=$diasemana, $nroferiado, Hora actual=".$horactual."  ".$tiempotrab1."  ".$tiempotrab2."  ".$tiempotrab3."  ".$tiempotrab4;
  //if ((($tiempotrab1==2) && ($tiempotrab2==1)) && (($diasemana != 6) && ($diasemana != 0) && ($nroferiado==0))) { //Sigue Trabajando

  //modificado el 15/07/2011 antes de salir de vacaciones otra vez ....
  //$tiempotrab1=2;
  //$tiempotrab2=1;
 
  if (((($tiempotrab1==2) && ($tiempotrab2==1)) || (($tiempotrab3==2) && ($tiempotrab4==1))) && (($diasemana != 6) && ($diasemana != 0) && ($nroferiado==0))) { //Sigue Trabajando 

  }
  else { 
    $subtitulo = "HORARIO RESTRINGIDO";
    echo "<br><br>";
    echo "<table width='100%'>";
    echo " <tr>";
    echo "  <td width='35%' class='der2-color'>";
    echo "    <font face='MS Sans Serif' size='-1'>&nbsp;&nbsp;Hora:{$horactual}</font>";
    echo "  </td>";
    echo "  <td width='30%' class='cnt-color3'>";
    echo "    <font face='MS Sans Serif' size='-1'>{$subtitulo}</font>";
    echo "  </td>";
    echo "  <td width='35%' class='izq-color'>";
    echo "    <font face='MS Sans Serif' size='-1'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font>";
    echo "  </td>";
    echo "  </tr>";
    echo "</table>";
    echo "&nbsp;";
    echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>El Horario para realizar estas transacciones son de 08:00:00 AM a 12:00:00 PM</b></font></p>";
    echo "<p align='center'><font size='3' face='Tahoma' color='#0000FF'><b>Y de 01:30:00 PM a 04:00:00 PM ...!!!</b></font></p>";

    echo "<p align='center'><a href='../index1.php'><input type='button' name='salir' value='Salir' class='boton_rojo' onclick='window.close()'>&nbsp;&nbsp;</a></p>";        
    exit();
  }
   
}   

if ($vopc==5) {
  $smarty->assign('modo1','readonly=readonly');

  $factura   = $_POST["factura"];
  $nfac = 'F0'.$factura;
  //Datos de la Factura 
  $objquery = $mysql->query_mysql("SELECT fac_id,cli_id,fac_fecha FROM sfa_factura WHERE fac_num='$nfac'"); 
  $objfilas = $mysql->nums_mysql('',$objquery);
  $objsfac  = $mysql->objects_mysql('',$objquery);
  $fac_id   = $objsfac->fac_id;
  $fechafac = $objsfac->fac_fecha;
  $cli_id   = $objsfac->cli_id;
 
  //Datos del Detalle 
  $objdetalle = $mysql->query_mysql("SELECT dtalle1_cantidad_ser FROM sfa_dtalles_1 WHERE ser_id='0107' AND fac_id=$fac_id"); 
  $objtotdtalle = $mysql->nums_mysql('',$objdetalle);
  $objsdta = $mysql->objects_mysql('',$objdetalle);
  $cant_fac = $objsdta->dtalle1_cantidad_ser;
  
  //Datos del Cliente 
  $objcliente = $mysql->query_mysql("SELECT cli_rifci,cli_nombre,cli_direccion,cli_tlfn1 FROM sfa_cliente WHERE cli_id=$cli_id"); 
  $objtotclie = $mysql->nums_mysql('',$objcliente);
  $objsdta = $mysql->objects_mysql('',$objcliente);
  $crifci  = $objsdta->cli_rifci;
  $nombre  = $objsdta->cli_nombre;
  $domicilio = $objsdta->cli_direccion;
  $telefono  = $objsdta->cli_tlfn1;
  
  $smarty->assign('factura',$nfac);
  $smarty->assign('fechafac',$fechafac);
  $smarty->assign('cisolicita',$crifci);
  $smarty->assign('solicitante',$nombre);  
  $smarty->assign('domicilio',$domicilio);
  $smarty->assign('telefono',$telefono);
  $smarty->assign('cantidad',$cant_fac);  
}   
   
if ($vopc==2) {
  $factura    = $_POST['factura'];
  $fechafac   = $_POST['fechafac'];
  $solicitante= $_POST['solicitante'];
  $cisolicita = $_POST['cisolicita'];
  $domicilio  = $_POST['domicilio'];
  $telefono   = $_POST['telefono'];
  $cantidad   = $_POST['cantidad'];
  $boletin    = $_POST['boletin'];


  echo "valores= $solicitante, $cisolicita, $agente, $impreabg, $boletin, $tomo, $resolucion, $empresa, $domicilio, $vpoder";
  exit();
  
  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();

  //Validacion de los campos
  if (empty($boletin)) {
    mensajenew('ERROR: No introdujo el No de Bolet&iacute;n ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //Datos del Boletín 
  $obj_querybol = $sql->query1("SELECT fecha_vig,fecha_ven FROM stzboletin WHERE nro_boletin= $boletin");
  $objsbol = $sql->objects1('',$obj_querybol);
  $vf_ven = $objsbol->fecha_ven;
  $vf_vig = $objsbol->fecha_vig;

  $esmayor=compara_fechas($fechahoy,$vf_ven);
  if ($esmayor==1) {
    mensajenew("ERROR: La Fecha tope para presentar Pagos de Derechos de Registros del Bolet&iacute;n $boletin era hasta el $vf_ven ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $insevser  = true;
  $insoponent = true;
  $vcod=$_POST['factura'];

  $resultado=pg_exec("SELECT * FROM stmtmpopo WHERE control = '$vcod'");
  $filas_found=pg_numrows($resultado);    

  if ($filas_found == 0) {
    mensajenew('ERROR: No introdujo Expedientes publicados como Solicitados en estatus 8 ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

    //$fechahoy  = hoy();
    $horactual = hora();

    $insert_str = "$vcod,1040,'$usuario','$fechahoy','$horactual','ESCRITO DE OPOSICION','1',$vf_ven";  
    $insevser   = $sql->insert1("$tbname_4","","$insert_str",""); 

    $insert_str = "$vcod,'$solicitante','$cisolicita','$agente','$impreabg','$boletin','$datosbol','$empresa','$domicilio','$vpoder'";  
    $insoponent = $sql->insert1("$tbname_8","","$insert_str",""); 
 
    $errorgrabar = 0;
    for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $instsol = true;
       $vcod = $reg[control];
       $vder = $reg[nro_derecho];
       $vsol = $reg[solicitud];
       //Inserto Datos en la tabla de Control de Certificado 
       $insert_str = "$vcod,'$vder','$vsol'";
       $instsol = $sql->insert1("$tbname_9","","$insert_str",""); 
          
       if ($instsol) { }
       else {
         $errorgrabar = $errorgrabar+1; }
    }  
   
    // Verificacion y actualizacion real de los Datos en BD 
    if (($insevser) AND ($insoponent) AND ($errorgrabar == 0)) {    //Validacion del Numero de Solicitud
       pg_exec("COMMIT WORK");
       // Vector Datos Usuario 
       $obj_usr = $sql->query("SELECT nombres,apellidos FROM $tbname_5 WHERE usuario='$usuario'");
       $objs = $sql->objects('',$obj_usr);
       $persona = trim($objs->nombres)." ".trim($objs->apellidos);

       //correo($sql_mail,$persona,$usuario,$vcod,$boletin,$vf_vig,$vf_ven);    
       //Desconexion de la Base de Datos
       $sql->disconnect1();
       //Msgrptimp("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_oposicion.php?vopc=3","m_rptctrlcert.php?vped=$vcod&vusr=$usuario");
       Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_pagoderecho.php?vopc=3","S");
       $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect1();
      //if (!$instcer) { $error_cer  = " - Control de Certificados "; } 
      //if (!$instreg) { $error_reg  = " - Expedientes  "; }
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
  }

//Paso de variables de datos
$smarty->assign('vopc',$vopc);

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Factura No.:');
$smarty->assign('campo2','Fecha de Factura:');
$smarty->assign('campo3','Nombre o Raz&oacute;n Social:');
$smarty->assign('campo4','C.I. &oacute; Rif.:');
$smarty->assign('campo5','Domicilio:');
$smarty->assign('campo6','Telefono:');
$smarty->assign('campo7','Cantidad de Registros Pagados:');
$smarty->assign('campo8','Bolet&iacute;n:');
$smarty->assign('campo9','Relaci&oacute;n de Expedientes:');

$smarty->assign('usuario',$usuario);
$smarty->assign('factura',$nfac); 

$smarty->display('m_pagoderecho.tpl');
$smarty->display('pie_pag.tpl');


function correo($sql_mail,$nombre,$vemail,$escrito,$boletin,$vf_vig,$vf_ven) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail; 
 $mail->SMTPAuth = true;     		// activar la identificacín SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 //Verificando conexion
 $sql = new mod_db();
 $sql->connection();
 $tbname_1  = "stmsolopo";
 $tbname_2  = "stmmarce";
 $tbname_3  = "stzderec";

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema WEBPI - SAPI";
 $mail->Subject = "Pre Carga de Escrito de Oposición En Línea, Escrito No. ".$escrito;
 
 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminwebpi@sapi.gob.ve','Administrador Webpi');

 $body  = "<strong>Estimada(o): </strong>".$nombre." <br><br>";

 $body .= " Su Pre Carga de datos correspondiente al(los) Escrito(s) de Oposici&oacute;n a expedientes publicados como solicitadas en el Bolet&iacute;n No. ".$boletin." a presentar en nuestra oficina ha sido recibida bajo el n&uacute;mero de control: <strong>".$escrito."</strong>. ";   
 $body .= " <br>";
 $body .= "<table width='100%' border='1'>";
 $body .= " <tr>";

 $obj_filas = 0;
 $obj_fone = $sql->query1("SELECT * FROM stmsolopo,stmmarce,stzderec where control='$escrito' AND stmsolopo.nro_derecho=stmmarce.nro_derecho AND
stzderec.nro_derecho=stmmarce.nro_derecho");
 $obj_filas = $sql->nums1('',$obj_fone);
 if ($obj_filas>0) {
   $body .= "   <tr>";
   $body .= "     <td colspan='3' align='left'><b><H3><I>Expedientes a Observar:</I></H3></b></td>";
   $body .= "   </tr>";
   $body .= "   <tr>";
   $body .= "     <td width='14%' align='left'><b>No. Solicitud</b></td>";
   $body .= "     <td width='60%' align='left'><b>Denominaci&oacute;n</b></td>";
   $body .= "     <td width='08%' align='left'><b>Clase</b></td>";
   $body .= "   </tr>";

   $cont = 0;
   $objs = $sql->objects1('',$obj_fone);
   for ($cont=0;$cont<$obj_filas;$cont++) {
     $bnombre = trim(utf8_decode($objs->denominacion));
     $body .= "   <tr>";
     $body .= "     <td width='14%' align='left'>$objs->solicitud</td>";
     $body .= "     <td width='60%' align='left'>$objs->nombre</td>";
     $body .= "     <td width='08%' align='left'>$objs->clase</td>";
     $body .= "   </tr>";
     $objs = $sql->objects1('',$obj_fone); 
   }
   $body .= "   <tr>";
   $body .= "   </tr>";
 }

 $body .= " </tr>";
 $body .= "</table>";

 //Datos del Boletín 
 //$obj_querybol = $sql->query1("SELECT fecha_vig,fecha_ven FROM stzboletin WHERE nro_boletin= $boletin");
 //$objsbol = $sql->objects('',$obj_querybol);
 //$vf_ven = $objsbol->fecha_ven;
 //$vf_vig = $objsbol->fecha_vig;

 $body .= "<br><br>";
 $body .= "Le recordamos que en aras  de facilitar y agilizar el proceso, tiene hasta el ".$vf_ven." para consignar el o los escritos de Oposici&oacute;n en nuestra oficina, indicando en la taquilla el n&uacute;mero de control antes mencionado a principio de este correo.<br><br>";

 $body .= "IMPORTANTE: Le recordamos que para ingresar de manera exitosa en el sistema WEBPI debe tener activada la opción de visualización de ventanas emergentes (popup) en su navegador web.<br><br>";
 $body .= "Si desea enviarnos alg&uacute;n comentario, sugerencia o recomendaci&oacute;n comuniquese directamente con nosotros a sugerencias@sapi.gob.ve o dirijase a nuestra oficina ubicada en el ";
 $body .= " Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela.";
 $body .= " Horario de Atenci&oacute;n al P&uacute;blico: 8:00am a 1:30pm. o por nuestra Central Telef&oacute;nica (0212) 481.64.78 / 484.29.07<br><br>"; 
 $body .= " Para mayor informaci&oacute;n consulte nuestra pagina <strong>www.sapi.gob.ve</strong>";
 $body .= "<br><br>";
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
}

?>
