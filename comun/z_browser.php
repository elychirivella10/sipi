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
$tbname_2 = "stzeveser";
$tbname_3 = "stzevuserv";
$tbname_4 = "stmoposicion";
$tbname_5 = "stztramite";
$tbname_6 = "stmsolopo";
$tbname_7 = "stzevtrd";

$smarty->assign('titulo',$titulo);
$smarty->assign('subtitulo','Recepci&oacute;n y Verificaci&oacute;n de Escritos');
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
$hiddenvars['fecdep1']=$fecdep1;
$hiddenvars['fecdep2']=$fecdep2;
$hiddenvars['control']=$control;
$hiddenvars['escrito']=$escrito;

$sql->connection(); 

$vectorcampos=explode(",",$camposname);
$cantcampos=substr_count($camposname,',')+1;
if (!empty($condicion)) {
   $condicion = $condicion." AND stzeveser.evento=stzevuserv.codigo AND stzevuserv.control=stmsolopo.control AND stzevuserv.estatus='1' "; }
 else {
   $condicion = "stzeveser.evento=stzevuserv.codigo AND stzevuserv.control=stmsolopo.control AND stzevuserv.estatus='1' "; }

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
       $condicion = $condicion." AND stzeveser.evento=$escrito"; }
     else {
       $condicion = "stzeveser.evento=$escrito"; } 
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
        $condicion = $condicion." AND (stzevuserv.fecha_trans >='$fecdep1' AND stzevuserv.fecha_trans <='$fecdep2')";
     }
  } else {
     if (!empty($fecdep1) && !empty($fecdep2)) { 
        $orden='1';
        $condicion = $condicion." AND (stzevuserv.fecha_trans >='$fecdep1' AND stzevuserv.fecha_trans <='$fecdep2')";
     }   
  }
} else {
  if (!empty($condicion)) {
     $condicion = $condicion." AND stzevuserv.control=$control"; }
  else {
     $condicion = "stzevuserv.control=$control"; } 
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
     $estado = "";
     $vtrami = $regv[control];
     $vesta  = $regv[estatus]; 
     $veven  = $regv[evento];
     $venci  = $regv[fecha_venc];
     
     $nradio = 'radio'.$cont;
     $vradio = $_POST['radio'.$cont];

     if ($vradio=='A') { 
       $actprim = true;
       $instram = true;
       $actevser= true;
       $estado = "RECIBIDO"; 
       //echo " tram=$vtrami, $veven, $venci, $vesta ".$estado." "."</p>";

       $num_error = 0;
       // ESCRITO DE OPOSICION 
       if ($veven==1040) { 
         //$esmayor=compara_fechas($fechahoy,$venci); 
         //if ($esmayor==1) {
         //  mensajenew("ERROR: Presentaci&oacute;n de Escrito de Oposici&oacute;n EXTEMPORANEO, ten&iacute;a plazo hasta el $venci ...!!!","javascript:history.back();","N");
         //  $smarty->display('pie_pag.tpl'); exit(); 
         //}
         $obj_oponent = $sql->query("SELECT oponente,ci_oponente,boletin,empresa,domicilio FROM $tbname_4 WHERE control='$vtrami'");
         $objs     = $sql->objects('',$obj_oponent);
         $vopnombre = trim($objs->oponente);
         $vci_opo = trim($objs->ci_oponente); 
         $vboletin  = $objs->boletin;
         $empresa = trim($objs->empresa);
         $domiemp = trim($objs->domicilio);
         $comentario = "$vopnombre con C.I.: = $vci_opo";      
         $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
         if (!empty($empresa)) {
           $comentario = $comentario.", Representante o Apoderado de: ".$empresa."."; }
         //Verificacion de extemporaneidad del escrito 
         $esmayor=compara_fechas($fechahoy,$venci); 
         if ($esmayor==1) {
           $comentario = $comentario." Presentaci&oacute;n de Escrito de Oposici&oacute;n EXTEMPORANEO."; }
         //echo " Presentado por: $comentario, del bol= $vboletin ";
         list($vmensaje,$tipo,$tipo_plz,$plazo,$infor,$tcome,$tdocu) = Datos_evento($veven);
         //echo "deve= $vmensaje,$tipo,$tipo_plz,$plazo,$infor,$tcome,$tdocu ";          
         $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE control='$vtrami'");
         $obj_filas = $sql->nums('',$obj_query);
         $objs = $sql->objects('',$obj_query);
         for($i=0;$i<$obj_filas;$i++) { 
           $vder = $objs->nro_derecho;
           $vsol = $objs->solicitud;
           $est_anterior = Actual_estatus($vder);
           $est_final = estatus_final($veven,$est_anterior,'M'); 
           $update_str = "estatus=$est_final";
           $actprim = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");
           $insert_str = "'$vder','$veven','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$est_anterior','$vboletin','$fechahoy','$login','$vmensaje','$comentario','$horactual'";
           $instram = $sql->insert("$tbname_7","$col_campos","$insert_str","");
           //verifica si las transaccion fue exitosa 
           if (($actprim) && ($instram)) { }
           else { $num_error = $num_error + 1; }
           //siguiente registro  
           $objs = $sql->objects('',$obj_query);
         }
       }
       //FIN ESCRITO DE OPOSICION 
       // ESCRITO VARIOS 
       if ($veven==1160) { 
         $obj_solici= $sql->query("SELECT comentario FROM $tbname_3 WHERE control='$vtrami'");
         $objs     = $sql->objects('',$obj_solici);
         $vcomenta = trim($objs->comentario);
         $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
         list($vmensaje,$tipo,$tipo_plz,$plazo,$infor,$tcome,$tdocu) = Datos_evento($veven);
         $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE control='$vtrami'");
         $obj_filas = $sql->nums('',$obj_query);
         $objs = $sql->objects('',$obj_query);
         for($i=0;$i<$obj_filas;$i++) { 
           $vder = $objs->nro_derecho;
           $vsol = $objs->solicitud;
           $est_anterior = Actual_estatus($vder);
           $insert_str = "'$vder','$veven','$fechahoy',nextval('stzevtrd_secuencial_seq'),'$est_anterior',0,'$fechahoy','$login','$vmensaje','$vcomenta','$horactual'";
           $instram = $sql->insert("$tbname_7","$col_campos","$insert_str","");
           //verifica si las transaccion fue exitosa 
           if ($instram) { }
           else { $num_error = $num_error + 1; }
           //siguiente registro  
           $objs = $sql->objects('',$obj_query);
         }
       }
       //FIN ESCRITO VARIOS 

       //Actualizacion de estatus de escrito solicitado y procesado o traspasado al sipi         
       $update_str ="estatus='2',fecha_envtra='$fechahoy',hora_envtra='$horactual'";
       $actevser = $sql->update("stzevuserv","$update_str","control='$vtrami'");
       //Verificacion de transaccion 
       if ($actevser) { }
       else { $num_error = $num_error + 1; } 
       // Vector Datos Usuario y envio por correo del estado del tramite 
       //$obj_mail = $sql->query("SELECT usuario FROM $tbname_5 WHERE nro_tramite='$vtrami'");
       //$objs     = $sql->objects('',$obj_mail);
       //$usuar    = trim($objs->usuario);
       //$obj_usr = $sql->query("SELECT nombres,apellidos FROM $tbname_6 WHERE usuario='$usuar'");
       //$objs    = $sql->objects('',$obj_usr);
       //$persona = trim($objs->nombres)." ".trim($objs->apellidos);
       //correo($sql_mail,$persona,$usuar,$vtrami,$veven);    
     } 
     if ($vradio=='R') { } 
     $regv=pg_fetch_array($cantidad);
   }

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
   echo "<form name='formab' method='POST' action='z_browser.php?vopc=2&vtp=1'>";
   echo "<input type ='hidden' name='usuario' value={$vusua}>";

   for($cont=0;$cont<$cantcampos;$cont++) {
      $uppercampo=strtoupper($vectorcampos[$cont]);
      echo "<td class='colbrow1'><b>$uppercampo</b></td>";   
   }

   // 1er ciclo de variables ocultas fuera del rango de chequeos leidos
   for($cont=1;$cont<=$inicio;$cont++) { 
       //$vtmp  = $_POST['check'.$cont];  
       //$vtmp1 = $_POST['vcheck'.$cont];  
       //$nombrecheck='check'.$cont;
       //$nombre1check='vcheck'.$cont;
       //$vcheck[$cont]='';
       //$vcheck1[$cont]='';
       $vtra = $reg[control];
       //if ($vtmp=='on') {
       //    echo "<input type='hidden' name='$nombrecheck' value='on'>";      
       //    $checkarray[$cont]=$vtmp;
       //    $vcheck[$cont]='checked';}
       //if ($vtmp1=='on') {
       //    echo "<input type='hidden' name='$nombre1check' value='on'>";      
       //    $check1array[$cont]=$vtmp1;
       //    $vcheck1[$cont]='checked';}  
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
       //$vtmp = $_POST['check'.$cont];  
       //$vtmp1 = $_POST['vcheck'.$cont];  
       //$nombrecheck='check'.$cont;
       //$nombre1check='vcheck'.$cont;
       //$vcheck[$cont]='';
       //$vcheck1[$cont]='';
       $vtra = $reg[control];
       //if ($vtmp=='on') {
       //    echo "<input type='hidden' name='$nombrecheck' value='on'>";      
       //    $checkarray[$cont]=$vtmp;
       //    $vcheck[$cont]='checked'; }
       //if ($vtmp1=='on') {
       //    echo "<input type='hidden' name='$nombre1check' value='on'>";      
       //    $check1array[$cont]=$vtmp1;
       //    $vcheck1[$cont]='checked'; } 
       $vradio = $_POST['radio'.$cont];
       $nradio = 'radio'.$cont;
       if ($vradio=='A') { 
         echo "<input type='hidden' name='$nradio' value='A' checked  />"; } 
       if ($vradio=='R') { 
         echo "<input type='hidden' name='$nradio' value='R' checked />"; }
       if ($vradio=='E') { 
         echo "<input type='hidden' name='$nradio' value='E' checked />"; }
   }

   // rango normal de chequeos   
   //for($cont=0;$cont<$filas_resultado;$cont++) {
   for($cont=1;$cont<=$filas_resultado;$cont++) {
      echo "<tr>"; 
      $puntero=$inicio+$cont;
      //$puntero=$inicio+$cont+1;
      //echo " puntero=$puntero ";
      //$nombrecheck='check'.$puntero;
      //$nombre1check='vcheck'.$puntero;
      //$vtmp = $_POST['check'.$puntero];
      //$vtmp1 = $_POST['vcheck'.$puntero];
      //if ($vtmp=='on') {$vcheck[$puntero]='checked';} else {$vcheck[$puntero]='';}
      //if ($vtmp1=='on') {$vcheck1[$puntero]='checked';} else {$vcheck1[$puntero]='';}
      $vtra = $reg[control];

      $vcheck2[$puntero]='checked';
      $nradio = 'radio'.$puntero;
      $vradio = $_POST['radio'.$puntero];
      if ($vradio=='A') { $vcheck[$puntero]='checked'; $vcheck1[$puntero]=''; $vcheck2[$puntero]=''; } 
      if ($vradio=='R') { $vcheck[$puntero]=''; $vcheck1[$puntero]='checked'; $vcheck2[$puntero]=''; }  
      if ($vradio=='E') { $vcheck[$puntero]=''; $vcheck1[$puntero]=''; $vcheck2[$puntero]='checked'; }  
      echo "<td width='9%' class='celda_centro'>$reg[control]"; 
      echo "</td>";
      echo "<td width='8%' class='celda_der'>$reg[fecha_trans]"; 
      echo "</td>";
      echo "<td width='9%' class='celda_der'>$reg[hora_trans]"; 
      echo "</td>";
      echo "<td width='8%' class='celda_centro'>$reg[evento]"; 
      echo "</td>";
      echo "<td width='24%' class='celda_izq'>$reg[nombre]"; 
      echo "</td>";
      echo "<td width='10%' class='celda_centro'>$reg[solicitud]"; 
      echo "</td>";
      echo "<td width='23%' class='celda_centro'>$reg[usuario]";
      echo "</td>";
      echo "<td width='12%'>";
      echo "&nbsp;&nbsp;";
      $vtra = $reg[control];
      //echo "<input name=$vtra type='radio' value='A' onclick='color1(this);'/><font color='#000000' size='1'>Aprobado</font>";
      //echo "<input name=$vtra type='radio' value='R' onclick='color2(this);'/><font color='#000000' size='1'>Rechazado</font>";
      //echo "<input name=$nradio type='radio' value='A' $vcheck[$puntero] onclick='color1(this);'/><img src='../imagenes/tick.png' border='0'><font color='#000000' size='1'>Aprobado</font>";
      //echo "<input name=$nradio type='radio' value='R' $vcheck1[$puntero] onclick='color2(this);'/><img src='../imagenes/publish_x.png' border='0'><font color='#000000' size='1'>Rechazado</font>";

      echo "<input name=$nradio type='radio' value='A' $vcheck[$puntero] onclick='color1(this);' /><img src='../imagenes/tick.png' border='0'>&nbsp;&nbsp;&nbsp;";
      //echo "<input name=$nradio type='radio' value='R' $vcheck1[$puntero] onclick='color2(this);' /><img src='../imagenes/publish_x.png' border='0'>&nbsp;&nbsp;&nbsp;";
      echo "<input name=$nradio type='radio' value='E' $vcheck2[$puntero] onclick='color3(this);' /><img src='../imagenes/reloj_espera.png' border='0'>";
      echo "</td>";
      echo "<td width='18%' class='celda_centro'>$reg[fecha_venc]";
      echo "</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 
//echo " </p>";
//echo " <p align='left'>";
   echo "<div align='left'>";
   //echo "<td style='text-align: right'>";
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../imagenes/tick.png' border='0'>Entregado&nbsp;&nbsp;<img src='../imagenes/publish_x.png' border='0'>Por Recibir&nbsp;&nbsp;<img src='../imagenes/reloj_espera.png' border='0'>En espera";
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../imagenes/tick.png' border='0'>Entregado&nbsp;&nbsp;&nbsp;<img src='../imagenes/reloj_espera.png' border='0'>En espera";
   //echo "</td>";
//echo " </p>";
   echo "</div>";

   //echo "<br>";
   $vurl1= "z_browser.php?vopc=5";
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

function correo($sql_mail,$nombre,$vemail,$tramite,$veven) {
 $mail = new PHPMailer();
 $mail->IsSMTP();              	// enviar vía SMTP
 $mail->Host = $sql_mail;
 $mail->SMTPAuth = true;     	// activar la identificacín SMTP
 $mail->Username = "msystem";  	// usuario SMTP
 $mail->Password = "M6ccs9Ve"; 	// clave SMTP

 $mail->From = "adminwebpi@sapi.gob.ve";
 $mail->FromName = "Administrador del Sistema WEBPI - SAPI";
 //if ($vesta=='01') {
 $mail->Subject = "Verificacion y Carga de Escrito(s) En Linea, Tramite No. ".$tramite; 
 //}

 $mail->AddAddress($vemail,$nombre);
 $mail->AddBCC('adminwebpi@sapi.gob.ve','Administrador Webpi');

 $body  = "<strong>Estimada(o): </strong>".$nombre." <br><br>";

 if ($veven==1160) { $tram_esc = "ESCRITO(S) VARIO(S)"; }
 if ($veven==1040) { $tram_esc = "ESCRITO DE OPOSICION"; }
 
 $body .= " Le informamos que, los datos relacionados al tramite n&uacute;mero <strong>".$tramite.", concerniente a ".$tram_esc." </strong> fueron verificados contra documento(s) original(es) y cargado(s) satisfactoriamente por el Servicio Aut&oacute;nomo de la Propiedad Intelectual - SAPI.<br><br>";
 //$body .= " Si Ud, considera que los datos bancarios relacionados al tramite son correctos, dirijase a la instituci&oacute;n en el Centro Sim&oacute;n Bol&iacute;var, Edificio Norte, Piso 4, El Silencio. Al lado de la Plaza Caracas. Apto. Postal 1844 - C&oacute;d. Postal 1010 - Caracas-Venezuela. Horario de Atenci&oacute;n al P&uacute;blico: 8:00am a 1:30pm.<br><br>";
 //$body .= " NOTA: Tiene tres (3) d&iacute;as para proceder a la correci&oacute;n a partir de la presente notificaci&oacute;n, de lo contrario su tramite ser&aacute; eliminado autom&aacute;ticamente por el sistema.<br><br>"; 

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
