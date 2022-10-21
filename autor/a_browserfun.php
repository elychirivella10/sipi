<script>

function validar1(dcheck,dcheck1) {
  //Compruebo si la casilla está marcada
  if (dcheck.checked==true) {
   dcheck1.checked=false;
   return
  }
}

function validar2(dcheck,dcheck1) {
  //Compruebo si la casilla está marcada
  if (dcheck1.checked==true) {
   dcheck.checked=false;
   return
  }
}

function color1(obj) {
  tab = document.getElementById('tabla');
  //for (i=0; ele = tab.getElementsByTagName('input')[i]; i++)
  //  if (ele!=obj) ele.checked = false;
  //for (i=0; ele = tab.getElementsByTagName('tr')[i]; i++)
  //  ele.style.background = '#fff';
  if (obj.checked)
    obj.parentNode.parentNode.style.background = '#CEF6CE'; //#F5D0A9 #F6E3CE
  else 
    obj.parentNode.parentNode.style.background = '#F9F7ED'; 
}

function color2(obj) {
  tab = document.getElementById('tabla');
  //for (i=0; ele = tab.getElementsByTagName('input')[i]; i++)
  //  if (ele!=obj) ele.checked = false;
  //for (i=0; ele = tab.getElementsByTagName('tr')[i]; i++)
  //  ele.style.background = '#fff';
  if (obj.checked)
    obj.parentNode.parentNode.style.background = '#F4FA58'; //#81BEF7 #CEE3F6
  else 
    obj.parentNode.parentNode.style.background = '#F9F7ED'; 
}

function color3(obj) {
  tab = document.getElementById('tabla');
  //for (i=0; ele = tab.getElementsByTagName('input')[i]; i++)
  //  if (ele!=obj) ele.checked = false;
  //for (i=0; ele = tab.getElementsByTagName('tr')[i]; i++)
  //  ele.style.background = '#fff';
  if (obj.checked)
    obj.parentNode.parentNode.style.background = '#F9F7ED'; //#81BEF7 #CEE3F6
}

function cntrlpago(var1,var2) {
  open("a_admcosto.php?vcod="+var1.value+"&vser="+var2.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function cntrlfact(var1,var2) {
  open("a_admfactura.php?vcod="+var1.value+"&vser="+var2.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<html>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
// *************************************************************************************
// Programa: a_browserfun.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2012 I Semestre  
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include("$include_lib/class.phpmailer.php"); 

$new_windows=$_POST['new_windows']; 
if ($new_windows=='S') { echo "<body onload='centrarwindows()'>"; }


if (($_SERVER['HTTP_REFERER']=="")) { 
   echo "Acceso Denegado..."; exit(); } 
   
//Variables
$login    = $_SESSION['usuario_login'];
$sql      = new mod_db();
$fecha    = fechahoy();
$tbname_1 = "stzderec"; 
$tbname_2 = "stdseraut";
$tbname_3 = "stdautorser";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzusuar";

$smarty->assign('titulo',$titulo);
$smarty->assign('subtitulo','Recepci&oacute;n y Verificaci&oacute;n de Solicitudes de Servicios');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Parametros
$fecdep1 = $_POST["fecdep1"];
$fecdep2 = $_POST["fecdep2"];
$control = trim($_POST["control"]);
$escrito = $_POST["escrito"];

// Parametros utilizados para armar la condicion
$v1=$_POST["v1"];
$v2=$_POST["v2"];
$v3=$_POST["v3"];
$v4=$_POST["v4"];
$v5=$_POST["v5"];

// Parametros utilizados para dar funcionalidad al browse
$vopc       = $_GET["vopc"];
$vtp        = $_GET["vtp"]; 
$camposquery= $_POST["camposquery"];
$camposname = $_POST["camposname"];
$tablas     = $_POST["tablas"];
$condic     = $_POST["condicion"];
$condic2    = $_POST["condicion2"];
$orden      = $_POST["orden"];
$vurl       = $_POST["vurl"];
$modo       = $_POST["modo"];
$modoabr    = $_POST["modoabr"];
$fmodo      = $_POST["fmodo"];
$tabladel   = $_POST["tabladel"];
$tablains   = $_POST["tablains"];
$camposins  = $_POST["camposins"];
$valoresins = $_POST["valoresins"];

if(($vopc==0 || empty($vopc)) && empty($v1)) {$v1=0;} 

$valoresins=str_replace("\'","'",$valoresins);
$valoresins=str_replace("v1","'$v1'",$valoresins);
$valoresins=str_replace("v2","'$v2'",$valoresins);
$valoresins=str_replace("v3","'%$v3%'",$valoresins);
$valoresins=str_replace("v4","'$v4'",$valoresins);
$valoresins=str_replace("v5","'$v5'",$valoresins);

// condicion para visualizar los datos
$condicion=str_replace("\'","'",$condic);
$condicion=str_replace("v1","'$v1'",$condicion);
$condicion=str_replace("v2","'$v2'",$condicion);
$condicion=str_replace("v3","'%$v3%'",$condicion);
$condicion=str_replace("v4","'$v4'",$condicion);
$condicion=str_replace("v5","'$v5'",$condicion);
// condicion para eliminar / incluir
$condicion2=str_replace("\'","'",$condic2);
$condicion2=str_replace("v1","'$v1'",$condicion2);
$condicion2=str_replace("v2","'$v2'",$condicion2);
$condicion2=str_replace("v3","'%$v3%'",$condicion2);
$condicion2=str_replace("v4","'$v4'",$condicion2);
$condicion2=str_replace("v5","'$v5'",$condicion2);

if(substr_count($fmodo,'Siguientes')>0 && strlen($fmodo) > 0)
  $adelante = "1";
if(substr_count($fmodo,'Anteriores')>0 && strlen($fmodo) > 0)
  $atras = "1";
if(substr_count($fmodo,'Eliminar')>0)
  $vopc=2;
if(substr_count($fmodo,'Incluir')>0)
  $vopc=3;
if(substr_count($fmodo,'Guardar')>0)
  $vopc=4;
if(substr_count($fmodo,'Procesar')>0)
  $vopc=5;
  
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total =  $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 100;

if(!empty($adelante))
  $inicio += $cuanto;
if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['camposquery']=$camposquery;
$hiddenvars['camposname']=$camposname;
$hiddenvars['tablas']=$tablas;
$hiddenvars['condicion']=$condicion;
$hiddenvars['condicion2']=$condicion2;
$hiddenvars['orden']=$orden;
$hiddenvars['vurl']=$vurl;
$hiddenvars['modo']=$modo;
$hiddenvars['modoabr']=$modoabr;
$hiddenvars['tabladel']=$tabladel;
$hiddenvars['tablains']=$tablains;
$hiddenvars['camposins']=$camposins;
$hiddenvars['valoresins']=$valoresins;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$cuanto;
$hiddenvars['total']=$total;
$hiddenvars['new_windows']=$new_windows;
$hiddenvars['v1']=$v1;
$hiddenvars['v2']=$v2;
$hiddenvars['v3']=$v3;
$hiddenvars['v4']=$v4;
$hiddenvars['v5']=$v5;
$hiddenvars['fecdep1']=$fecdep1;
$hiddenvars['fecdep2']=$fecdep2;
$hiddenvars['control']=$control;
$hiddenvars['escrito']=$escrito;

$sql->connection(); 

$vectorcampos=explode(",",$camposname);
$cantcampos=substr_count($camposname,',')+1;
if (!empty($condicion)) {
   $condicion = $condicion." stdseraut.estatus IN ('3','4','5') AND funcionario='$login' "; }
 else {
   $condicion = "stdseraut.estatus IN ('3','4','5') AND funcionario='$login' "; }

$fechahoy = Hoy();

if (empty($control)) { 
 if (!empty($escrito)) {
   if ($escrito!='Todos') { 
     if (!empty($condicion)) {
       $condicion = $condicion." AND stdseraut.tipo_servicio='$escrito'"; }
     else {
       $condicion = "stdseraut.tipo_servicio=$escrito"; } 
   }
 }

 if (!empty($fecdep1) && !empty($fecdep2)) { 
   $titulo= $titulo." Transacci&oacute;n Desde el: "."$fecdep1"." Hasta: "."$fecdep2";
   $esmayor=compara_fechas($fecdep1,$fecdep2);
   if ($esmayor==1) {
     mensajenew('ERROR: Rango de Fechas erroneo en la Transacci&oacute;n ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } }

  // Validacion de las fechas que no sean mayor al dia  
  $esmayor=compara_fechas($fecdep1,$fechahoy);
  if ($esmayor==1) {
    mensajenew("La Fecha de Deposito No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fecdep2,$fechahoy);
  if ($esmayor==1) {
    mensajenew("La Fecha de Deposito No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($escrito=="Todos") {
     if (!empty($fecdep1) && !empty($fecdep2)) { 
        $orden='1';
        $condicion = $condicion." AND (stdseraut.fecha_trans >='$fecdep1' AND stdseraut.fecha_trans <='$fecdep2')";
     }
  } else {
     if (!empty($fecdep1) && !empty($fecdep2)) { 
        $orden='1';
        $condicion = $condicion." AND (stdseraut.fecha_trans >='$fecdep1' AND stdseraut.fecha_trans <='$fecdep2')";
     }   
  }
} else {
  if (!empty($condicion)) {
     $condicion = $condicion." AND stdseraut.control=$control"; }
  else {
     $condicion = "stdseraut.control=$control"; } 
} 

 $camposquery = $camposquery.",inf_adicional,nombre";
 $query='SELECT '.$camposquery.' FROM '.$tablas.' WHERE '.$condicion.' ORDER BY '.$orden;
 //echo " QUERY= $query ";
 $resultado=pg_exec("$query OFFSET $inicio LIMIT $cuanto");
 $cantidad =pg_exec("$query");
 $total=pg_numrows($cantidad); 
 $filas_resultado=pg_numrows($resultado);
 $reg=pg_fetch_array($resultado);
 $regv=pg_fetch_array($cantidad);

 if ($filas_resultado==0) {
   mensajenew("AVISO: No se encontr&oacute informaci&oacute;n alguna ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); 
 }

 if ($vopc==5) {
   $num_error = 0;
   $fechahoy=Hoy();
   $horactual= Hora();

   //$cantidad =pg_exec("$query");
   $cantidad =$sql->query("$query");
   //$total=pg_numrows($cantidad);
   $total=$sql->nums('',$cantidad); 
   //$regv=pg_fetch_array($cantidad);
   $objs=$sql->objects('',$cantidad);
   //Comienzo de Transaccion 
   pg_exec("BEGIN WORK");
   for($cont=1;$cont<=$total;$cont++) { 
     $vtrami = $_POST['vtram'.$cont];
     $vesta = $_POST['vesta'.$cont];
     $vusr = $_POST['vuser'.$cont];
     
     $actprim= true;
     $nradio = 'radio'.$cont;
     $vradio = $_POST['radio'.$cont];
     if ($vradio=='A') { 
       $actprim = true;
       $inf_costo = trim($objs->inf_adicional);
       $persona = trim($objs->nombre); 

       $update_str = "estatus='5',fecha_envprecio='$fechahoy',hora_envprecio='$horactual'"; 
       $actprim = $sql->update("$tbname_2","$update_str","control='$vtrami'");
       if ($actprim) { }
       else { $num_error = $num_error + 1; } 
       correo($sql_mail,$persona,$vusr,$vtrami,$inf_costo);
     } 
     if ($vradio=='R') {  
       $actprim = true;

       $update_str = "estatus='6',fecha_retiro='$fechahoy',hora_retiro='$horactual'"; 
       $actprim = $sql->update("$tbname_2","$update_str","control='$vtrami'");
       if ($actprim) { }
       else { $num_error = $num_error + 1; } 
     } 
     //$regv=pg_fetch_array($cantidad);
     $objs=$sql->objects('',$cantidad);
   }

   //Verificacion de transaccion  
   if ($num_error==0) { 
     pg_exec("COMMIT WORK"); }
   else {
     pg_exec("ROLLBACK WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect();

     Mensajenew("ERROR: Falla de Inserci&oacute;n de Datos en la BD ...!!!","../index1.php","N");
     $smarty->display('pie_pag.tpl'); exit();
   }
   
   Mensajenew('DATOS VERIFICADOS CORRECTAMENTE ...!!!','../index1.php','S');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
 }

 ?>
 <p align='center'>
 <b><font class='navega1'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Registros Encontrados </font></b> 

 <?php
   echo "<table id='tabla' border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo "<form name='formab' method='POST' action='a_browserfun.php?vopc=2&vtp=1'>";
   echo "<input type ='hidden' name='usuario' value={$vusua}>";

   for($cont=0;$cont<$cantcampos;$cont++) {
      $uppercampo=strtoupper($vectorcampos[$cont]);
      echo "<td class='colbrow1'><b>$uppercampo</b></td>";   
   }

   // 1er ciclo de variables ocultas fuera del rango de chequeos leidos
   for($cont=1;$cont<=$inicio;$cont++) { 
       $vtra = $reg[control];
       $vradio = $_POST['radio'.$cont];
       $nradio = 'radio'.$cont;
       if ($vradio=='A') { 
         echo "<input type='hidden' name='$nradio' value='A' checked />"; } 
       if ($vradio=='R') { 
         echo "<input type='hidden' name='$nradio' value='R' checked />"; }
       if ($vradio=='E') { 
         echo "<input type='hidden' name='$nradio' value='E' checked />"; }
   }
   // 2do ciclo de variables ocultas fuera del rango de chequeos leidos	   
   for($cont=$inicio+$filas_resultado+1;$cont<=$total;$cont++) { 
       $vtra = $reg[control];
       $vradio = $_POST['radio'.$cont];
       $nradio = 'radio'.$cont;
       if ($vradio=='A') { 
         echo "<input type='hidden' name='$nradio' value='A' checked  />"; } 
       if ($vradio=='R') { 
         echo "<input type='hidden' name='$nradio' value='R' checked />"; }
       if ($vradio=='E') { 
         echo "<input type='hidden' name='$nradio' value='E' checked />"; }
   }


   for($cont=1;$cont<=$filas_resultado;$cont++) {
      echo "<tr>"; 
      $puntero=$inicio+$cont;
      $vtra = $reg[control];

      $vcheck2[$puntero]='checked';
      $nradio = 'radio'.$puntero;
      $vradio = $_POST['radio'.$puntero];
      if ($vradio=='A') { $vcheck[$puntero]='checked'; $vcheck1[$puntero]=''; $vcheck2[$puntero]=''; } 
      if ($vradio=='R') { $vcheck[$puntero]=''; $vcheck1[$puntero]='checked'; $vcheck2[$puntero]=''; }  
      if ($vradio=='E') { $vcheck[$puntero]=''; $vcheck1[$puntero]=''; $vcheck2[$puntero]='checked'; }  
      
      $vtramite[$cont] = $reg[control];
      $vestatus[$cont] = $reg[estatus];
      $vsolicitud[$cont] = $reg[solicitud];
      $vregistro[$cont] = $reg[registro];
      $vtiposerv[$cont] = $reg[tipo_servicio];
      $vusuario[$cont] = trim($reg[solicitante]);
      echo "<td width='8%' class='celda_centro'><input type='text' style='text-align: center' readonly name='vtram$cont' value='$vtramite[$cont]' size='7'>";  
      echo "</td>";
      echo "<td width='8%' class='celda_centro'>$reg[fecha_trans]"; 
      echo "</td>";
      echo "<td width='7%' class='celda_centro'><input type='text' style='text-align: center' readonly name='vserv$cont' value='$vtiposerv[$cont]' size='7'>"; 
      echo "</td>";
      echo "<td width='7%' class='celda_centro'><input type='text' style='text-align: center' readonly name='vsol$cont' value='$vsolicitud[$cont]' size='7'>"; 
      echo "</td>";
      echo "<td width='7%' class='celda_centro'><input type='text' style='text-align: right' readonly name='vreg$cont' value='$vregistro[$cont]' size='7'>"; 
      echo "</td>";
      echo "<td width='24%' class='celda_izq'>$reg[titulo_obra]";
      echo "</td>";
      echo "<td width='18%' class='celda_izq'><input type='text' style='text-align: left' readonly name='vuser$cont' value='$vusuario[$cont]' size='25'>";
      echo "</td>";
      echo "<td width='6%' class='celda_centro'><input type='text' style='text-align: center' readonly name='vesta$cont' value='$vestatus[$cont]' size='5'>";  
      echo "</td>";
      echo "<td width='15%'>";
      $vtra = $reg[control];
      $vest = $reg[estatus];
      if ((($reg[tipo_servicio]=='DA12') || ($reg[tipo_servicio]=='DA14')) && ($vest=='4')) {  
        echo "<input name=$nradio type='radio' value='A' $vcheck[$puntero] onclick='color1(this);cntrlpago(document.formab.vtram$cont,document.formab.vserv$cont);' /><img src='../imagenes/tick.png' border='0'>&nbsp;&nbsp;"; }
      else {
        echo "<input name=$nradio type='radio' value='A' $vcheck[$puntero] onclick='color1(this); disable' /><img src='../imagenes/tick.png' border='0'>&nbsp;&nbsp;"; }
      echo "<input name=$nradio type='radio' value='R' $vcheck1[$puntero] onclick='color2(this);cntrlfact(document.formab.vtram$cont,document.formab.vserv$cont);' /><img src='../imagenes/publish_x.png' border='0'>&nbsp;&nbsp;";
      echo "<input name=$nradio type='radio' value='E' $vcheck2[$puntero] onclick='color3(this);' /><img src='../imagenes/reloj_espera.png' border='0'>";
      echo "</td>";

      echo "</tr>";
      $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 

   echo "<div align='left'>";
   //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../imagenes/tick.png' border='0'>Enviar Precio Final&nbsp;&nbsp;<img src='../imagenes/publish_x.png' border='0'>Entregado&nbsp;&nbsp;<img src='../imagenes/reloj_espera.png' border='0'>En espera";
   echo "</div>";
   
   $vurl1= "a_browserfun.php?vopc=5";
   ?>
    &nbsp;
   <div align='center'>
   <input type='submit' name='fmodo' class="botones" value='<?=$modo?>' /> 
   <!-- <input type='reset' name='Limpiar' class="botones" value='Limpiar' />  -->
   <? if ($new_windows=='S') { ?>
      <input type="button" img="../imagenes/salir_f2.png" value="Salir" onclick="cerrarwindows();" class="botones"> </font></p> 

   <? } else { ?>  
      <input type="button" img="../imagenes/salir_f2.png" value="Salir" class="botones" onclick="location.href='<?=$vurl?>'"> </font></p> 
   <? } ?>
   <input type="hidden" name="camposquery" value="$camposquery">
   <input type="hidden" name="camposname" value="$camposname">
   <input type="hidden" name="tablas" value="$tablas">
   <input type="hidden" name="condicion" value="$condicion">
   <input type="hidden" name="condicion2" value="$condicion2">
   <input type="hidden" name="orden" value="$orden">
   <input type="hidden" name="vurl" value="$vurl">
   <input type="hidden" name="modo" value="$modo">
   <input type="hidden" name="modoabr" value="$modoabr">
   <input type="hidden" name="tabladel" value="$tabladel">
   <input type="hidden" name="v1" value="$v1">
   <input type="hidden" name="v2" value="$v2">
   <input type="hidden" name="v3" value="$v3">
   <input type="hidden" name="v4" value="$v4">
   <input type="hidden" name="v5" value="$v5">
   
   <?
   foreach($hiddenvars as $var => $val) {
     //echo " Inicio=$inicio, Cuanto=$cuanto, Anteriores=min($inicio,$cuanto), Siguientes=min(($total-($inicio + $cuanto)),$cuanto) ";
     ?>
     <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
     <? }
   if($inicio > 0) {
     ?>
     <input type="image" src="../imagenes/back_f2.png" name='fmodo' value="Anteriores <?= min($inicio, $cuanto) ?> " /> Anteriores <?= min($inicio, $cuanto) ?>   
     <? }
   if($total - $inicio > $cuanto) {
     ?>
     <input type='image' src="../imagenes/next_f2.png" name='fmodo' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' /> Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>
     </div>
     <? } 
   echo "</form>";

   //Desconexion de la Base de Datos
   $sql->disconnect();

   $smarty->display('pie_pag.tpl');   
   ?>

<?php

function correo($sql_mail,$nombre,$vemail,$tramite,$infcosto) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema WEBPI - SAPI";
 $mail->Subject = "InformaciÓn de Precio Final del Servicio En LÍnea, Trámite No. ".$tramite;

 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminwebpi@sapi.gob.ve','Administrador Webpi');

 $body  = "<strong>Estimada(o): </strong>".$nombre." <br><br>";

 $body .= " En relaci&oacute;n a su Solicitud de Tr&aacute;mite No.: ".$tramite." le informamos que debe cancelar en los Bancos Autorizados por el servicio solicitado la cantidad de Bs.: ".$infcosto." .<br><br>";

 $body .= "IMPORTANTE: Le recordamos que para ingresar de manera exitosa en el sistema WEBPI debe tener activada la opci&oacute;n de visualizaci&oacute;n de ventanas emergentes (popup) en su navegador web.<br><br>";
 $body .= "Si desea enviarnos alg&uacute;n comentario, sugerencia o recomendaci&oacute;n comuniquese directamente con nosotros a sugerencias@sapi.gob.ve o dirijase a nuestra oficina ubicada en el ";
 $body .= " Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela.";
 $body .= " Horario de Atenci&oacute;n al P&uacute;blico: 8:00am a 1:30pm. o por nuestra Central Telef&oacute;nica (0212) 481.64.78 / 484.29.07<br><br>"; 
 $body .= " Para mayor informaci&oacute;n consulte nuestra pagina <strong>www.sapi.gob.ve</strong>";
 $body .= "<br><br>";
 $body .= "<b><i> Ministerio del poder Popular para el Comercio - MPPC.<br/>";
 $body .= " Servicio Aut&oacute;nomo de la Propiedad Intelectual - S.A.P.I.<br/>";
 $body .= " Portal: www.sapi.gob.ve</b></i><br>";
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
