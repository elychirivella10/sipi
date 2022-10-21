<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>   
<?php 
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$usuario = $_SESSION['usuario_login'];

$new_windows=$_POST['new_windows']; 
if ($new_windows=='S') { echo "<body onload='centrarwindows()'>"; }

$sql = new mod_db();
$fecha = fechahoy();
$fechahoy = hoy();
$hora = Hora();
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Seleccion de Avisos o Ducumentos para el Boletin');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// Parametros utilizados para armar la condicion
$v1=$_POST["v1"];
$v2=$_POST["v2"];
$v3=$_POST["v3"];
$v4=$_POST["v4"];
$v5=$_POST["v5"];

// Parametros utilizados para dar funcionalidad al browse
$camposquery=$_POST["camposquery"];
$camposname= $_POST["camposname"];
$tablas=     $_POST["tablas"];
$condic=     $_POST["condicion"];
$condic2=    $_POST["condicion2"];
$orden=      $_POST["orden"];
$vurl=       $_POST["vurl"];
$modo=       $_POST["modo"];
$modoabr=    $_POST["modoabr"];
$fmodo=      $_POST["fmodo"];
$tabladel=   $_POST["tabladel"];
$tablains=   $_POST["tablains"];
$camposins=  $_POST["camposins"];
$valoresins= $_POST["valoresins"];
$vopc=       $_GET["vopc"];
if(($vopc==0 || empty($vopc)) && empty($v1)) {$v1=0;} 
$valoresins=str_replace("\'","'",$valoresins);
$valoresins=str_replace("v1","'$v1'",$valoresins);
$valoresins=str_replace("v2","'$v2'",$valoresins);
$valoresins=str_replace("v3","'$v3'",$valoresins);
$valoresins=str_replace("v4","'$v4'",$valoresins);
$valoresins=str_replace("v5","'$v5'",$valoresins);

// condicion para visualizar los datos
$condicion=str_replace("\'","'",$condic);
$condicion=str_replace("v1","'$v1'",$condicion);
$condicion=str_replace("v2","'$v2'",$condicion);
$condicion=str_replace("v3","'$v3'",$condicion);
$condicion=str_replace("v4","'$v4'",$condicion);
$condicion=str_replace("v5","'$v5'",$condicion);
// condicion para eliminar / incluir
$condicion2=str_replace("\'","'",$condic2);
$condicion2=str_replace("v1","'$v1'",$condicion2);
$condicion2=str_replace("v2","'$v2'",$condicion2);
$condicion2=str_replace("v3","'$v3'",$condicion2);
$condicion2=str_replace("v4","'$v4'",$condicion2);
$condicion2=str_replace("v5","'$v5'",$condicion2);

$sql->connection($usuario); 

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
  
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total =  $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 51;

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

   $vectorcampos=explode(",",$camposname);
   $cantcampos=substr_count($camposname,',')+1;
   echo $vpalabra;  


   $query='SELECT '.$camposquery.' FROM '.$tablas.' where '.$condicion.' ORDER BY '.$orden;
   $resultado=pg_exec("$query OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("$query");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
 

if ($vopc==2) {
   $reg=pg_fetch_array($cantidad);
   for($cont=1;$cont<=$total;$cont++) {
       $condic=$condicion2;
       $v6=$reg[nro_aviso]; // Utilizada solo para solicitudes
       $v7=''; //libre
       $v8=''; //Libre
       $v9=''; //libre
       $v10=''; //Libre
       $condic=str_replace('v6',"'$v6'",$condic);
       $condic=str_replace('v7',"'$v7'",$condic);
       $condic=str_replace('v8',"'$v8'",$condic);
       $condic=str_replace('v9',"'$v9'",$condic);
       $condic=str_replace('v10',"'$v10'",$condic);
       $vtmp = $_POST['check'.$cont];
       if ($vtmp=='on') {
          $sql->del("$tabladel","$condic");
	  }
       $reg=pg_fetch_array($cantidad);
   }
   if ($new_windows=='S') { mensajebrowse('Datos Eliminados Correctamente.',"$vurl"); }
   else { mensajenew('Datos Eliminados Correctamente.',"$vurl",'S'); }
   $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); 
}

if ($vopc==3) {
   $reg=pg_fetch_array($cantidad);
   for($cont=1;$cont<=$total;$cont++) { 
       $valori=$valoresins;
       $v6=$reg[nro_aviso];
       $v7=$usuario; 
       $v8=$fechahoy;
       $v9=$hora; 
       $va='';
       $vb='';
       $vc='';
       $vd='';
       //Libre y se pueden continuar v11,v12...etc
       $valori=str_replace('v6',"'$v6'",$valori);
       $valori=str_replace('v7',"'$v7'",$valori);
       $valori=str_replace('v8',"'$v8'",$valori);
       $valori=str_replace('v9',"'$v9'",$valori);
       $valori=str_replace('va',"'$va'",$valori);
       $valori=str_replace('vb',"'$vb'",$valori);
       $valori=str_replace('vc',"'$vc'",$valori);
       $valori=str_replace('vd',"'$vd'",$valori);
       $vtmp = $_POST['check'.$cont];
       if ($vtmp=='on') {
          $insert_campos=$camposins; 
	  $insert_valores=$valori;
	  
 	  $res_boletin = pg_exec("select * from stztmpav where boletin='$v3' and nro_aviso = '$v6'");
	  $filas_found = pg_numrows($res_boletin);
	  if ($filas_found==0) {    	    
    	     $sql->insert("$tablains","$insert_campos","$insert_valores","");}
	  }
       $reg=pg_fetch_array($cantidad);
   }
   if ($new_windows=='S') { mensajebrowse('Datos Incluidos Correctamente.',"$vurl"); }
   else { mensajenew('Datos Incluidos Correctamente.',"$vurl",'S'); }
   $smarty->display('pie_pag1.tpl'); $sql->disconnect(); exit(); 
}

if ($vopc==4) {
   $reg=pg_fetch_array($cantidad);
   for($cont=1;$cont<=$total;$cont++) { 
       $vtmp = $_POST['check'.$cont];
       $vsolh= $reg[solicitud];
       $valor= $reg[verificado];
       $vnam = $reg[nanota];
       if ($vtmp=='on') {
          if ($valor=='S') {$update_str = "verificado='N'";} else {$update_str = "verificado='S'";}
	  $sql->update("stzantma","$update_str","solicitud='$vsolh' and nanota='$vnam' and evento='$v2'");
       }
       $reg=pg_fetch_array($cantidad);
   }
   if ($new_windows=='S') { mensajebrowse('Datos Guardados Correctamente.',"$vurl"); }
   else { mensajenew('Datos Guardados Correctamente.',"$vurl",'S'); }
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
   
}
      
   ?>
   <p align='center'><b><font size='3' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b></p>
   <?php
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   
   // Encabezado de la tabla
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font        
   color='#000000'></font><b>$modoabr</b></td>";
   for($cont=0;$cont<$cantcampos;$cont++) {
      $uppercampo=strtoupper($vectorcampos[$cont]);
      echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font     color='#000000'></font><b>$uppercampo</b></td>";   
   }
//   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font     
//color='#000000'></font><b>$modoabr</b></td>";
   echo "</tr>";
   
   echo "<form name='formab' method='POST' action='z_browbol.php?vopc=1&nveces={$nveces}&nconexion={$nconexion}'>"; 
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
     $puntero=$inicio+$cont+1;
     $nombrecheck='check'.$puntero;
     $vtmp = $_POST['check'.$puntero];
     if ($vtmp=='on') {$vcheck[$puntero]='checked';} else {$vcheck[$puntero]='';}
     echo "<tr>";

// Cambio de lugar del checkbox
     echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>
     <input type='checkbox' name='$nombrecheck' $vcheck[$puntero]></font></td>";

     for($cont2=0;$cont2<$cantcampos;$cont2++) {
         $namecampo=$vectorcampos[$cont2];
	 echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'> 
         $reg[$namecampo]</font></td>";} 
     echo "</tr>"; 
//     echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>
//     <input type='checkbox' name='$nombrecheck' $vcheck[$puntero]></font></td></tr>";
     $reg = pg_fetch_array($resultado);
   }
   echo "</table>"; 
   echo "<p align='center'><font color='#0000FF'>";
   ?>
   
   <input type='submit' name='fmodo' value='<?=$modo?>' /> 
   <? if ($new_windows=='S') { ?>
      <input type="button" img="imagenes/salir_f2.png" value="Salir" onclick="cerrarwindows();"> </font></p> 
     <!--  <input type='button' value='Salir' name='salir' onclick="cerrarwindows();"></font></p> -->
   <? } else { ?>  
      <input type="button" img="imagenes/salir_f2.png" value="Salir" onclick="location.href='<?=$vurl?>'"> </font></p> 
     <!--  <input type='button' value='Salir' name='salir' onclick="location.href='<?=$vurl?>'"></font></p> -->
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
     <input type="submit" name='fmodo' value="Anteriores <?= min($inicio, $cuanto) ?>" />
     <? }
   if($total - $inicio > $cuanto) {
     ?>
     <input type='submit' name='fmodo' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
     <? } 
   echo "</form>";
   $smarty->display('pie_pag.tpl');   
   ?>
</body>   
</html>
