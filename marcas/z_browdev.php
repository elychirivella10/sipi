<html>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
// *************************************************************************************
// Programa: z_browdev.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Modificado Año 2008 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$new_windows=$_POST['new_windows']; 
if ($new_windows=='S') { echo "<body onload='centrarwindows()'>"; }


if (($_SERVER['HTTP_REFERER']=="")) { 
   echo "Acceso Denegado..."; exit(); } 
   
//Variables
$login = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy(); 

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Oficios de Devoluci&oacute;n de Anotaciones Marginales');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Parametros
//$vsol1=$_POST["vsol1"];
$fecsold=$_POST["fecsold"];
$fecsolh=$_POST["fecsolh"];
$vusua  =$_POST["usuario"];

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
if(substr_count($fmodo,'Imprimir')>0)
  $vopc=5;
  
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total =  $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 11;

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
$hiddenvars['fecsold']=$fecsold;
$hiddenvars['fecsolh']=$fecsolh;

$sql->connection($login); 

$vectorcampos=explode(",",$camposname);
$cantcampos=substr_count($camposname,',')+1;

$fechahoy = Hoy();
$tablas   = "stmtmpam";

if (empty($fecsold) and empty($fecsolh)) {
  mensajenew("AVISO: Informacion Vacia ...!!!","javascript:history.back();","N");
  $smarty->display('pie_pag.tpl'); exit(); 
}

 if ($vopc==1) {
   //Creando tabla temporal
   //pg_exec("CREATE TEMPORARY TABLE $tablas ( solicitud char(11) NOT NULL,registro char(7),nombre char(200),clase int2,ind_claseni char(1),evento int2 NOT NULL,fecha_event date NOT NULL,documento int4,comentario char(300),usuario char(10))");
   //$resultado=pg_exec("INSERT INTO $tablas SELECT stzderec.solicitud,stzderec.registro,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stzevtrd.evento, stzevtrd.fecha_event,stzevtrd.documento,stzevtrd.comentario,'$usuario',stzevtrd.fecha_trans FROM stzevtrd,stzderec,stmmarce WHERE (stzevtrd.evento=1502 AND stzevtrd.nro_derecho=stzderec.nro_derecho AND stmmarce.nro_derecho = stzderec.nro_derecho AND (stzevtrd.fecha_trans between '$fecsold' AND '$fecsolh'))");
   pg_exec("DELETE FROM $tablas WHERE fecha_carga < '$fechahoy'");
   $resultado=pg_exec("INSERT INTO $tablas SELECT stzderec.solicitud,stzderec.registro,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stzevtrd.evento, stzevtrd.fecha_event,stzevtrd.documento,stzevtrd.comentario,stzevtrd.usuario,stzevtrd.fecha_trans,'$fechahoy' FROM stzevtrd,stzderec,stmmarce WHERE (stzevtrd.evento=1502 AND stzevtrd.nro_derecho=stzderec.nro_derecho AND stmmarce.nro_derecho = stzderec.nro_derecho AND (stzevtrd.fecha_trans between '$fecsold' AND '$fecsolh'))");
 }

 //$resultado=pg_exec("INSERT INTO $tablas SELECT stzderec.solicitud,stzderec.registro,stzderec.nombre,stmmarce.clase,stmmarce.ind_claseni,stmmarce.evento, stmmarce.fecha_event,stmmarce.documento,stmmarce.comentario FROM stzderec, stmevtrd,stmmarce WHERE (stzevtrd.evento=1502 and stzevtrd.nro_derecho=stzderec.nro_derecho and stmmarce.nro_derecho = stzderec.nro_derecho  and (stzevtrd.fecha_trans between '$fecsold' and '$fecsolh'))");
 $condicion = " stmtmpam.usuario='$vusua' AND (stmtmpam.fecha_trans between '$fecsold' AND '$fecsolh')";
 //$query='SELECT '.$camposquery.' FROM '.$tablas.' WHERE '.$condicion.' ORDER BY '.$orden;
 $query='SELECT DISTINCT '.$camposquery.' FROM '.$tablas.' WHERE '.$condicion.' ORDER BY '.$orden;
 //$query='SELECT '.$camposquery.' FROM '.$tablas.' ORDER BY '.$orden;
 //echo "q=$query ";
 $resultado=pg_exec("$query OFFSET $inicio LIMIT $cuanto");
 $cantidad =pg_exec("$query");
 $total=pg_numrows($cantidad); 
 $reg=pg_fetch_array($resultado);
 $filas_resultado=pg_numrows($resultado);
 //echo " total=$total / filas=$filas_resultado ";
 if ($filas_resultado==0) {
   mensajenew("AVISO: No Hay Informacion encontrada ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); exit(); 
 }
 
 if ($vopc==5) {
   $fechahoy=Hoy();
   $horahoy= Hora();

   $reg=pg_fetch_array($cantidad);
   pg_exec("LOCK TABLE stzsystem IN ROW EXCLUSIVE MODE");
   $update_str = "orden_dev = nextval('stzsystem_orden_dev_seq')";
   $upd_sys = $sql->update("stzsystem","$update_str","");    
     
   $obj_query = $sql->query("SELECT * FROM stzsystem");
   $objs  = $sql->objects('',$obj_query);
   $vorden = $objs->orden_dev;
   pg_exec("DELETE FROM stzofdev WHERE fecha_carga < '$fechahoy'");
   for($cont=1;$cont<=$total;$cont++) { 
     $nombrecheck='check'.$cont;
     $vtmp = $_POST['check'.$cont];
     $vsolh= $reg[solicitud];
     //$vder = $reg[nro_derecho];
     $vdoc = $reg[documento];
     if ($vtmp=='on') {
       $insert_val = "$vorden,'$vsolh',$vdoc,'N','M','$fechahoy'";
       $sql->insert("stzofdev","","$insert_val","");
     }
     $reg=pg_fetch_array($cantidad);
   }
   Mensaje4("DATOS GUARDADOS CORRECTAMENTE con la Orden $vorden ...!!!","$vurl","m_ofidevreg.php?orden=$vorden","");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
 }

   ?>
   <p align='center'>
   <b><font size='3' face='Tahoma' align='center' >Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Registros Encontrados </font></b>
   <!-- </p>-->
   <?php
   echo "<table border='1' cellpadding='0' cellspacing='0' width='150%'>";
   echo "<tr>";
   echo "<form name='formab' method='POST' action='z_browdev.php?vopc=2&vtp=1'>";
   echo "<input type ='hidden' name='vsol1' value={$vsol1}>";
   echo "<input type ='hidden' name='usuario' value={$vusua}>";

   for($cont=0;$cont<$cantcampos;$cont++) {
      $uppercampo=strtoupper($vectorcampos[$cont]);
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font><b>$uppercampo</b></td>";   
   }

   // 1er ciclo de variables ocultas fuera del rango de chequeos leidos
   for($cont=1;$cont<=$inicio;$cont++) { 
       $vtmp = $_POST['check'.$cont];  
       $nombrecheck='check'.$cont;
       $vcheck[$cont]='';
       if ($vtmp=='on') {
           echo "<input type='hidden' name='$nombrecheck' value='on'>";      
           $checkarray[$cont]=$vtmp;
           $vcheck[$cont]='checked';} }
   // 2do ciclo de variables ocultas fuera del rango de chequeos leidos	   
   for($cont=$inicio+$filas_resultado+1;$cont<=$total;$cont++) { 
       $vtmp = $_POST['check'.$cont];  
       $nombrecheck='check'.$cont;
       $vcheck[$cont]='';
       if ($vtmp=='on') {
           echo "<input type='hidden' name='$nombrecheck' value='on'>";      
           $checkarray[$cont]=$vtmp;
           $vcheck[$cont]='checked';} }

   // rango normal de chequeos   
   for($cont=0;$cont<$filas_resultado;$cont++) {
      echo "<tr>";
      $puntero=$inicio+$cont+1;
      $nombrecheck='check'.$puntero;
      $vtmp = $_POST['check'.$puntero];
      if ($vtmp=='on') {$vcheck[$puntero]='checked';} else {$vcheck[$puntero]='';}
      for($cont2=0;$cont2<$cantcampos;$cont2++) {
          $namecampo=$vectorcampos[$cont2];
          switch ($namecampo) {
            case "Solicitud":
              $vs1=substr(trim($reg['solicitud']),-11,4);
              $vs2=substr(trim($reg['solicitud']),-6);
              $dirano=substr(trim($reg['solicitud']),-11,4);
              $nameimagen="../graficos/marcas/ef".$dirano."/".$vs1.$vs2.".jpg"; 
              break;
            case "Clase":
              $vclase = $reg['clase'];
              break;
            case "Ind":
              $vind = $reg['ind_claseni'];
              break;
            case "Nombre":
              $vname = substr($reg['nombre'],0,20);
              break;
          }
      } 
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='10%'><font color='#000000'><a href='m_cronol1.php?vsol={$vs1}-{$vs2}'>$vs1-$vs2</font></a>";
      echo "</td>";
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='12%'><font color='#000000'>$reg[registro]</font>"; 
      echo "<input type='checkbox' name='$nombrecheck' $vcheck[$puntero]> Sel.</font>";
      echo "</td>";
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='28%'><font color='#000000'>$vname</font>"; 
      echo "</td>";
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='6%'><font color='#000000'> $vclase $reg[ind_claseni]</font>"; 
      echo "</td>";
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='9%'><font color='#000000'>$reg[fecha_event]</font>"; 
      echo "</td>";
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='10%'><font color='#000000'>$reg[documento]</font>"; 
      echo "</td>";
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center' width='30%'><font color='#000000'>$reg[comentario]</font>"; 
      echo "</td>";
      echo "</tr>";
      $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 
   $vurl1= "z_browdev.php?vopc=5";
   ?>

   <input type='submit' name='fmodo' value='<?=$modo?>' /> 
   <? if ($new_windows=='S') { ?>
      <input type="button" img="../imagenes/salir_f2.png" value="Salir" onclick="cerrarwindows();"> </font></p> 

   <? } else { ?>  
      <input type="button" img="../imagenes/salir_f2.png" value="Salir" onclick="location.href='<?=$vurl?>'"> </font></p> 
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
   <input type="hidden" name="vsol1" value="vsol1">   
   
   <?
   foreach($hiddenvars as $var => $val) {
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

     <? } 
   echo "</form>";
   //Desconexion de la Base de Datos
   $sql->disconnect();

   $smarty->display('pie_pag.tpl');   
   ?>
</body>   
</html>
