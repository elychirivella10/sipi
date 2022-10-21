<html>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
// *************************************************************************************
// Programa: z_browfon.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2015 I Semestre  
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$new_windows=$_POST['new_windows']; 
if ($new_windows=='S') { echo "<body onload='centrarwindows()'>"; }


if (($_SERVER['HTTP_REFERER']=="")) { 
   echo "Acceso Denegado..."; exit(); } 
   
//Variables
$login    = $_SESSION['usuario_login'];
$sql      = new mod_db();
$fecha    = fechahoy();
$tbname_1 = "stmbusqueda"; 
$tbname_2 = "stmbusplan";

$smarty->assign('titulo',$titulo);
$smarty->assign('subtitulo','Verificaci&oacute;n de Env&iacute;o de Resultados B&uacute;squedas Foneticas');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Parametros
$desdec = trim($_POST['desdec']);
$hastac = trim($_POST['hastac']);
$pedido1= trim($_POST['pedido1']);
$pedido2= trim($_POST['pedido2']);
$recibo  = trim($_POST['recibo']);
$planilla  = trim($_POST['planilla']);
$envio  = trim($_POST['envio']);

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
if(substr_count($fmodo,'Ingresar')>0)
  $vopc=5;
  
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total =  $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 12;

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
$hiddenvars['desdec']=$desdec;
$hiddenvars['hastac']=$hastac;
$hiddenvars['pedido1']=$pedido1;
$hiddenvars['pedido2']=$pedido2;
$hiddenvars['recibo']=$recibo;
$hiddenvars['planilla']=$planilla;
$hiddenvars['envio']=$envio;

$sql->connection(); 

$vectorcampos=explode(",",$camposname);
$cantcampos=substr_count($camposname,',')+1;
if (!empty($condicion)) {
   $condicion = $condicion." AND stmbusplan.tipo_busq='F' AND stmbusqueda.nro_pedido=stmbusplan.nro_pedido "; }
 else {
   $condicion = "stmbusplan.tipo_busq='F' AND stmbusqueda.nro_pedido=stmbusplan.nro_pedido "; }

$fechahoy = Hoy();

if (empty($desdec) && empty($hastac) && empty($recibo) && empty($planilla) && empty($pedido1) && empty($pedido2)) {
  mensajenew("Debe seleccionar o escribir las condiciones para la busqueda de informacion ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

if(!empty($desdec) && !empty($hastac)) {
  $titulo= $titulo." Cargado Desde el: "."$desdec"." Hasta: "."$hastac";
  $esmayor=compara_fechas($desdec,$hastac);
  if ($esmayor==1) {
    mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if(empty($condicion)) {
    $condicion = $condicion." (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')"; }
  else {
    $condicion = $condicion." AND (stmbusqueda.f_transac>='$desdec' AND stmbusqueda.f_transac<='$hastac')"; }
}

 // Validacion de las fechas que no sean mayor al dia  
 $esmayor=compara_fechas($desdec,$fechahoy);
 if ($esmayor==1) {
   mensajenew("La Fecha de Carga No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); }

 $esmayor=compara_fechas($hastac,$fechahoy);
 if ($esmayor==1) {
   mensajenew("La Fecha de Carga No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); }

if(!empty($recibo)) { 
  if(!empty($condicion)) {
     $condicion = $condicion." AND"." (stmbusqueda.nro_recibo='$recibo')";
     $titulo= $titulo." Factura No: "."$recibo";  }
}

if(!empty($planilla)) { 
  if(!empty($condicion)) {
     $condicion = $condicion." AND"." stmbusplan.cod_planilla='$planilla'";
     $titulo= $titulo." Planilla No: "."$planilla";  }
}

if (($pedido1!='')&&($pedido2!='')){
  $titulo= $titulo." Pedido No. desde el: "."$pedido1"." Hasta: "."$pedido2";
  if ($pedido1>$pedido2) {
     $smarty->display('encabezado1.tpl');
     mensajenew('Error: Rango de Pedidos Erroneos ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }
  if (empty($condicion)) {  
     $condicion = " stmbusqueda.nro_pedido BETWEEN '$pedido1' AND '$pedido2' "; }
  else {  
     $condicion = $condicion." AND stmbusqueda.nro_pedido BETWEEN '$pedido1' AND '$pedido2' "; }
}

if ($envio=='N') {
  if(!empty($condicion)) {
     $condicion = $condicion." AND"." (stmbusqueda.envio='N')";
     $titulo= $titulo." Solicitado por: Impresora";  }
}

if ($envio=='S') {
  if(!empty($condicion)) {
     $condicion = $condicion." AND"." (stmbusqueda.envio='S')";
     $titulo= $titulo." Solicitado por: Correo";  }
}

 $query='SELECT '.$camposquery.',email'.' FROM '.$tablas.' WHERE '.$condicion.' ORDER BY '.$orden;
 //echo " QUERY= $query $envio "; 
 $resultado=pg_exec("$query OFFSET $inicio LIMIT $cuanto");
 $cantidad =pg_exec("$query");
 $total=pg_numrows($cantidad); 
 $filas_resultado=pg_numrows($resultado);
 $reg=pg_fetch_array($resultado);

 if ($filas_resultado==0) {
   mensajenew("AVISO: No se encontr&oacute informaci&oacute;n alguna ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); 
 }

 if ($vopc==5) {
   $fechahoy=Hoy();
   $horactual= Hora();
 }

 ?>
 <p align='center'>
 <b><font><? echo $titulo; ?></font></b> 
 <br> <br>
 <b><font class='navega1'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Registros Encontrados </font></b> 
 <br>
 <?php
   echo "<table id='tabla' border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo "<form name='formab' method='POST' action='z_browfon.php?vopc=2&vtp=1'>";
   echo "<input type ='hidden' name='usuario' value={$vusua}>";

   for($cont=0;$cont<$cantcampos;$cont++) {
      $uppercampo=strtoupper($vectorcampos[$cont]);
      echo "<td class='colbrow1'><b>$uppercampo</b></td>";   
   }

   for($cont=0;$cont<$filas_resultado;$cont++) {
      echo "<tr>"; 
      $tipoenvio = $reg[envio];
      $pedpdf=trim($reg[nro_pedido]);
      $archivo= "/var/www/apl/sipi/documentos/busquedas/pdfext/fonetica/$pedpdf.pdf";
      $estenvio = $reg[estatus_envio];
      if($estenvio=='E') { $estado='Enviada'; } else { $estado='No Enviada'; } 
	   if (!file($archivo)) { 	        
		  echo "<td width='04%' class='celda_centro_bus'>$reg[nro_pedido]</td>"; $estado='No Enviada'; }
	   else {		
        echo "<td width='04%' class='celda_centro_bus'><a href='../documentos/busquedas/pdfext/fonetica/$pedpdf.pdf' target='_blank'>$reg[nro_pedido]</a></td>"; 
      }
      $correo = trim($reg[email]);
      echo "<td width='05%' class='celda_centro'>$reg[nro_recibo]</td>"; 
      echo "<td width='06%' class='celda_centro'>$reg[f_pedido]</td>"; 
      echo "<td width='05%' class='celda_centro'>$reg[cod_planilla]</td>";
      if($tipoenvio=='S') { echo "<td width='17%' class='celda_izq'>$reg[solicitante] / $correo</td>"; }
      if($tipoenvio=='N') { echo "<td width='17%' class='celda_izq'>$reg[solicitante]</td>"; }      
      echo "<td width='17%' class='celda_izq'>$reg[denominacion]</td>";
      echo "<td width='04%' class='celda_centro'>$reg[clase]</td>";
      echo "<td width='05%' class='celda_centro'>$reg[f_transac]</td>";
      echo "<td width='06%' class='celda_centro'>$reg[hora_c]</td>";
      echo "<td width='06%' class='celda_centro'>$reg[f_proceso]</td>";
      echo "<td width='06%' class='celda_centro'>$reg[hora_proceso]</td>";
      if($tipoenvio=='S') { $entrega = 'Correo'; } 
      if($tipoenvio=='N') { $entrega = 'Impresora'; $estado=''; }
      echo "<td width='04%' class='celda_centro'>$entrega</td>";
      echo "<td width='04%' class='celda_centro'>$estado</td>";
      echo "<td width='05%' class='celda_centro'>$reg[fecha_envio]</td>";
      echo "<td width='07%' class='celda_centro'>$reg[hora_envio]</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 

   $vurl1= "z_browfon.php?vopc=5";
   ?>
    &nbsp;
   <div align='center'>
   <? if ($new_windows=='S') { ?>
      <input type="button" img="../imagenes/boton_salir_azul.png" value="Salir" onclick="cerrarwindows();" class="botones"> </font></p> 

   <? } else { ?>  
      <!-- <input type="button" img="../imagenes/boton_salir_azul.png" value="Salir2" class="botones" onclick="location.href='<?=$vurl?>'"> </font></p> --> 
      <img src='../imagenes/boton_salir_rojo.png' onclick="location.href='<?=$vurl?>'">&nbsp;&nbsp;</p>

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
     ?>
     <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
     <? }
   if($inicio > 0) {
     ?>
     <input type="image" src="../imagenes/boton_previos_azul.png" name='fmodo' value="Anteriores <?= min($inicio, $cuanto) ?> " /> <?= min($inicio, $cuanto) ?>   
     <? }
   if($total - $inicio > $cuanto) {
     ?>
     <input type='image' src="../imagenes/boton_siguiente_azul.png" name='fmodo' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' /> <?= min(($total - ($inicio + $cuanto)), $cuanto)?>
     </div>
     <? } 
   echo "</form>";

   //Desconexion de la Base de Datos
   $sql->disconnect();

   $smarty->display('pie_pag.tpl');   
   ?>

   
</body>   
</html>
