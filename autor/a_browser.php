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

</script>

<html>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
// *************************************************************************************
// Programa: z_browser.php 
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
if(substr_count($fmodo,'Asignar')>0)
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
   $condicion = $condicion." stdseraut.estatus IN ('1','2') "; }
 else {
   $condicion = "stdseraut.estatus IN ('1','2') "; }

$fechahoy = Hoy();

 //echo "Var= $control, $escrito, $fecdep1, $fecdep2 ";

 //if (!empty($escrito)) {
 //  if (!empty($condicion)) {
 //    if ($escrito!='Todos') { 
 //      $condicion = $condicion." AND stzeveser.evento=$escrito"; } 
 //  }
 //  else {
 //    if ($escrito!='Todos') { 
 //      $condicion = "stzeveser.evento=$escrito"; } 
 //  }
 //}

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
  //echo " entra en el else $condicion ";
} 

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

   $cantidad =pg_exec("$query");
   $total=pg_numrows($cantidad); 
   $regv=pg_fetch_array($cantidad);
   //Comienzo de Transaccion 
   pg_exec("BEGIN WORK");
   for($cont=1;$cont<=$total;$cont++) { 
     //$vtrami = $regv[control];
     $vtrami = $_POST['vtram'.$cont];
     $vfuncionario = $_POST['funcio'.$cont];
     $vesta = $_POST['vesta'.$cont];

     $actprim= true;
     if ($vesta=='1') { $update_str = "estatus='3',funcionario='$vfuncionario',fecha_asigna='$fechahoy',hora_asigna='$horactual'"; }
     if ($vesta=='2') { $update_str = "estatus='4',funcionario='$vfuncionario',fecha_asigna='$fechahoy',hora_asigna='$horactual'"; }
     //$update_str = "funcionario='$vfuncionario',fecha_asigna='$fechahoy',hora_asigna='$horactual'";
     if ($vfuncionario!="ninguno") {
       $actprim = $sql->update("$tbname_2","$update_str","control='$vtrami'"); }
     if ($actprim) { }
     else { $num_error = $num_error + 1; }

     $regv=pg_fetch_array($cantidad);
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
   echo "<table id='tabla' border='1' cellpadding='0' cellspacing='0' width='90%'>";
   echo "<tr>";
   echo "<form name='formab' method='POST' action='a_browser.php?vopc=2&vtp=1'>";
   echo "<input type ='hidden' name='usuario' value={$vusua}>";

   for($cont=0;$cont<$cantcampos;$cont++) {
      $uppercampo=strtoupper($vectorcampos[$cont]);
      echo "<td class='colbrow1'><b>$uppercampo</b></td>";   
   }

   for($cont=1;$cont<=$filas_resultado;$cont++) {
      echo "<tr>"; 
      $vtramite[$cont] = $reg[control];
      $vestatus[$cont] = $reg[estatus];
      echo "<td width='9%' class='celda_centro'><input type='text' style='text-align: center' readonly name='vtram$cont' value='$vtramite[$cont]' size='7'>";  
      echo "</td>";
      echo "<td width='8%' class='celda_der'>$reg[fecha_trans]"; 
      echo "</td>";
      echo "<td width='9%' class='celda_centro'>$reg[tipo_servicio]"; 
      echo "</td>";
      echo "<td width='8%' class='celda_centro'>$reg[solicitud]"; 
      echo "</td>";
      echo "<td width='8%' class='celda_der'>$reg[registro]"; 
      echo "</td>";
      echo "<td width='32%' class='celda_izq'>$reg[titulo_obra]";
      echo "</td>";
      echo "<td width='26%' class='celda_izq'>$reg[solicitante]";
      echo "</td>";
      echo "<td width='9%' class='celda_centro'><input type='text' style='text-align: center' readonly name='vesta$cont' value='$vestatus[$cont]' size='5'>";  
      echo "</td>";
      echo "<td width='12%'>";
      echo "&nbsp;&nbsp;";
      //$vtra = $reg[control];
      echo "<select size='1' name='funcio$cont'>";
      $obj_query = $sql->query("SELECT usuario,nombre FROM $tbname_5 WHERE cod_depto='06' AND estatus='1' ORDER BY nombre");
      $filas_found=$sql->nums('',$obj_query);
      
      //while ($objs=$sql->objects('',$obj_query)) {  
      //  echo '<option value="'.$objs->usuario.'">'.trim($objs->nombre).'</option>';  
      //}
      $arraylogin[0]="ninguno";
      $arrayusuar[0]="";
      $objs = $sql->objects('',$obj_query);
      for($cont1=1;$cont1<=$filas_found;$cont1++) 
      { 
         $arraylogin[$cont1]=$objs->usuario;
         $arrayusuario[$cont1]=trim($objs->nombre); 
         $objs = $sql->objects('',$obj_query);
      }
      
      for($cont1=0;$cont1<=$filas_found;$cont1++) { 
        echo '<option value="'.$arraylogin[$cont1].'">'.$arrayusuario[$cont1].'</option>'; }
      echo "   </select>";
      echo "</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 
   $vurl1= "a_browser.php?vopc=5";
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

function correo($sql_mail,$nombre,$vemail,$tramite,$estado,$vesta) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema WEBPI - SAPI";
 if ($vesta=='01') {
   $mail->Subject = "Verificacion de Solicitud(es) de Busqueda(s) En Linea, Tramite No. ".$tramite; }
 if ($vesta=='09') {
   $mail->Subject = "Verificacion de Solicitud(es) de Marca(s) En Linea, Tramite No. ".$tramite; }

 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminwebpi@sapi.gob.ve','Administrador Webpi');

 $body  = "<strong>Estimada(o): </strong>".$nombre." <br><br>";

 if ($estado=='APROBADO') {  
   $body .= " Le informamos que los datos bancarios relacionados al tramite n&uacute;mero <strong>".$tramite." fue ".$estado." </strong> por el Servicio Aut&oacute;nomo de la Propiedad Intelectual - SAPI.<br><br>"; }
 if ($estado=='RECHAZADO') {  
   $body .= " Le informamos que los datos bancarios relacionados al tramite n&uacute;mero <strong>".$tramite." fue ".$estado." </strong> por el Servicio Aut&oacute;nomo de la Propiedad Intelectual - SAPI.<br><br>";
   $body .= " Lo invitamos a que ingrese a la opci&oacute;n 'Consulta de Servicios' y corrija los datos bancarios.<br><br>";
   $body .= " Si Ud, considera que los datos bancarios relacionados al tramite son correctos, dirijase a la instituci&oacute;n en el Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela. Horario de Atenci&oacute;n al P&uacute;blico: 8:00am a 1:30pm.<br><br>";
   $body .= " NOTA: Tiene tres (3) d&iacute;as para proceder a la correci&oacute;n a partir de la presente notificaci&oacute;n, de lo contrario su tramite ser&aacute; eliminado autom&aacute;ticamente por el sistema.<br><br>"; 
 }

 $body .= "<br>";
 
 $body .= "IMPORTANTE: Le recordamos que para ingresar de manera exitosa en el sistema WEBPI debe tener activada la opci&oacute;n de visualizaci&oacute;n de ventanas emergentes (popup) en su navegador web.<br><br>";

 $body .= "Para mayor informaci&oacute;n &oacute; realizar alg&uacute;n reclamo, comun&iacute;quese con nosotros por la central telef&oacute;nica (0212) 481.64.78 / 484.29.07 &oacute; a trav&eacute;s del correo electr&oacute;nico: sugerencias@sapi.gob.ve<br><br>";

 $body .= " Ministerio del poder Popular para el Comercio - MPPC.<br/>";
 $body .= " Servicio Autonomo de la Propiedad Intelectual - S.A.P.I.<br/>";
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
