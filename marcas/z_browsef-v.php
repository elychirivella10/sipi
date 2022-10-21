<html>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
<?php
$new_windows=$_POST['new_windows']; 
if ($new_windows=='S') { echo "<body onload='centrarwindows()'>"; }

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }
   
//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

$sql = new mod_db();
$fecha = fechahoy();
$vtp = $_GET["vtp"];

$smarty->assign('titulo',$substmar);
if ($vtp==0) {
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); }
else {
  $smarty->assign('subtitulo','B&uacute;squeda Interna de Elemento Figurativo'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Parametros del Recibo
$vsol1=$_POST["vsol1"];
$recibo=$_POST["recibo"];
$clase=$_POST["clase"];
$fecharec=$_POST["fecharec"];
$solicitant=$_POST["solicitant"];
$prioridad=$_POST["prioridad"];
$C1=$_POST["C1"];
$C2=$_POST["C2"];
$C3=$_POST["C3"];
$C4=$_POST["C4"];
$C5=$_POST["C5"];
$C6=$_POST["C6"];
$C7=$_POST["C7"];
$C8=$_POST["C8"];
$nameimage=$_POST["nameimage"];
$vindcla=$_POST["vindcla"];

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
if(substr_count($fmodo,'Imprimir')>0)
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

$hiddenvars['vsol1']=$vsol1;
$hiddenvars['clase']=$clase;
$hiddenvars['recibo']=$recibo;
$hiddenvars['solicitant']=$solicitant;
$hiddenvars['fecharec']=$fecharec;
$hiddenvars['prioridad']=$prioridad;
$hiddenvars['vindcla']=$vindcla;
$hiddenvars['C1']=$C1;
$hiddenvars['C2']=$C2;
$hiddenvars['C3']=$C3;
$hiddenvars['C4']=$C4;
$hiddenvars['C5']=$C5;
$hiddenvars['C6']=$C6;
$hiddenvars['C7']=$C7;
$hiddenvars['C8']=$C8;

   $vectorcampos=explode(",",$camposname);
   $cantcampos=substr_count($camposname,',')+1;

   //$query='SELECT '.$camposquery.' FROM '.$tablas.' WHERE '.$condicion.' ORDER BY '.$orden;
   $query='SELECT '.$camposquery.' FROM '.$tablas.' ORDER BY '.$orden;
   $resultado=pg_exec("$query OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("$query");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);

   $C[0] = '';
   $C[1] = '';
   $C[2] = '';
   $C[3] = '';
   $C[4] = '';
   $C[5] = '';
   $C[6] = '';
   $C[7] = '';

if ($vopc==5) {
  if ($vtp==0) {
   // Imprimir PDF Busqueda Externa
   $fechahoy=Hoy();
   $horahoy= Hora();

   //echo " guardo en stmaudef $vsol1 externa ";

   // Obtencion de Codigos de Viena     
   $obj_query = $sql->query("SELECT * FROM stmtmpccv WHERE stmtmpccv.solicitud='$vsol1'ORDER BY stmtmpccv.ccv");
   $obj_filas = $sql->nums('',$obj_query);
   if ($obj_filas > 0) {  
     $objs = $sql->objects('',$obj_query);
     for ($contobj=0;$contobj<$obj_filas;$contobj++) {
       $vcod = $objs->ccv; 
       $C[$contobj]=$vcod;
       $objs = $sql->objects('',$obj_query); }	  
   }
   $insert_val = "'$fechahoy','$horahoy','$usuario',$vsol1,$clase,'$C[0]','$C[1]','$C[2]','$C[3]','$C[4]','$C[5]','$C[6]','$C[7]',$total,'S','E'";
   $sql->insert("stmaudef","","$insert_val","");
   $reg=pg_fetch_array($cantidad);
   for($cont=1;$cont<=$total;$cont++) { 
       $vtmp = $_POST['check'.$cont];
       $vsolh= $reg[solicitud];
       $valor= $reg[verificado];
       if ($vtmp=='on') {
          if ($valor=='S') { 
            $update_str = "verificado='N'"; } 
          else {
            $insert_val = "$vsol1,'$vsolh','P'";
            $sql->insert("stmpsovi","","$insert_val",""); }
       }
       $reg=pg_fetch_array($cantidad);
   }
   //$insert_tmp = "'$fechahoy','$horahoy','$usuario','$tablas','E'";
   //$sql->insert("stmtmpef","","$insert_tmp","");
   $droptable=pg_exec("drop table $tablas");
   Mensaje3("DATOS GUARDADOS CORRECTAMENTE ...!!!","$vurl","m_rpt1bexef.php?vped=$vsol1&vusr=$usuario","m_rpt1bexsr.php?vped=$vsol1&vusr=$usuario");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
    // Imprimir PDF Busqueda Interna
    $fechahoy=Hoy();
    $horahoy= Hora();
    //echo " guardo en stmaudef $vsol1 interna ";

    // Obtencion de Codigos de Viena     
    $obj_query = $sql->query("SELECT * FROM stmtmpccv WHERE stmtmpccv.solicitud='$vsol1'ORDER BY stmtmpccv.ccv");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas > 0) {  
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<$obj_filas;$contobj++) {
        $vcod = $objs->ccv; 
        $C[$contobj]=$vcod;
        $objs = $sql->objects('',$obj_query); }	  
    }

    $insert_val = "'$fechahoy','$horahoy','$usuario','$vsol1',$clase,'$C[0]','$C[1]','$C[2]','$C[3]','$C[4]','$C[5]','$C[6]','$C[7]',$total,'S','I'";
    $sql->insert("stmaudef","","$insert_val","");
    $reg=pg_fetch_array($cantidad);
    for($cont=1;$cont<=$total;$cont++) { 
       $vtmp = $_POST['check'.$cont];
       $vsolh= $reg[solicitud];
       $valor= $reg[verificado];
       if ($vtmp=='on') {
          if ($valor=='S') { 
            $update_str = "verificado='N'"; } 
          else {
            $insert_val = "'$vsol1','$vsolh','P'";
            $sql->insert("stmpsovi","","$insert_val",""); }
       }
       $reg=pg_fetch_array($cantidad);
    }
    //$insert_tmp = "'$fechahoy','$horahoy','$usuario','$tablas','I'";
    //$sql->insert("stmtmpef","","$insert_tmp","");
    $droptable=pg_exec("drop table $tablas");
    Mensaje3("DATOS GUARDADOS CORRECTAMENTE ...!!!","$vurl","m_rpt1binef.php?vped=$vsol1&vusr=$usuario","m_rpt1binsr.php?vped=$vsol1&vusr=$usuario");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  }
}

if ($vopc==2) {
   $reg=pg_fetch_array($cantidad);
   for($cont=1;$cont<=$total;$cont++) { 
       $condic=$condicion2;
       $v6=$reg[solicitud]; // Utilizada solo para solicitudes
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
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
}

if ($vopc==3) {
   $reg=pg_fetch_array($cantidad);
   for($cont=1;$cont<=$total;$cont++) { 
       $valori=$valoresins;
       $v6=$reg[solicitud];
       $v7='M'; 
       $v8=$reg[titular];
       $v9=''; 
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
   	  $sql->insert("$tablains","$insert_campos","$insert_valores","");
	  }
       $reg=pg_fetch_array($cantidad);
   }
   if ($new_windows=='S') { mensajebrowse('Datos Incluidos Correctamente.',"$vurl"); }
   else { mensajenew('Datos Incluidos Correctamente.',"$vurl",'S'); }
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
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
   <!--<p align='center'>-->
   <b><font size='3' face='Tahoma' align='center' >Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b>
   <!--</p>-->
   <?php
   echo "<table border='0' cellpadding='0' cellspacing='0' width='150%'>";
   echo "<tr valign='top'>";
   if ($vtp==0) {
     // Encabezado de la tabla
     $imagenbusq="../graficos/logbext/".$vsol1.".jpg";
     echo "<td align='center' width='50%'>";
     echo "<font color='#000000'>&nbsp;</font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;Pedido Nro : $vsol1</font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;Recibo Nro : $recibo</font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;de Fecha   : $fecharec</font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;en Clase   : $clase I </font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;Solicitante: $solicitant </font></br>";
     echo "</td>";
     echo "<td align='center' width='50%'>";
     echo "&nbsp;";
     echo "</td>";
     echo "<td align='right' width='50%'>";
     echo "<font color='#000000'>Imagen a Buscar:&nbsp;</font>";
     echo "<a href='$imagenbusq' target='_blank'><img border='1' src='$imagenbusq' width='150' height='150'></a>"; 
     echo "</td>";
   }
   if ($vtp==1) {
     // Encabezado de la tabla
     $vs1=substr(trim($vsol1),-11,4);
     $vs2=substr(trim($vsol1),-6);
     $dirano=substr(trim($vsol1),-11,4);
     $imagenbusq="../graficos/marcas/ef".$dirano."/".$vs1.$vs2.".jpg"; 
     echo "<td align='center' width='50%'>";
     echo "<font color='#000000'>&nbsp;</font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;Solicitud No: $vsol1</font></br>";
     echo "<font color='#000000'>&nbsp;&nbsp;en Clase    : $clase $vindcla</font></br>";
     echo "</td>";
     echo "<td align='center' width='50%'>";
     echo "&nbsp;";
     echo "</td>";
     echo "<td align='right' width='50%'>";
     echo "<font color='#000000'>Imagen a Buscar:&nbsp;</font>";
     echo "<a href='$imagenbusq' target='_blank'><img border='1' src='$imagenbusq' width='150' height='150'></a>"; 
     echo "</td>";
   }
   echo "</tr>";
   echo "</table>"; 
   echo "<table border='1' cellpadding='0' cellspacing='0' width='150%'>";
   echo "<tr>";
   if ($vtp==1) {
     echo "<form name='formab' method='POST' action='z_browsef.php?vopc=1&vtp=1'>"; }
   else {
     echo "<form name='formab' method='POST' action='z_browsef.php?vopc=1&vtp=0'>"; }
   echo "<input type ='hidden' name='vsol1' value={$vsol1}>";
  
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

   $vexp=1;
   $totalf=((int)($total/6))+1;
   // rango normal de chequeos   
   //for($cont=0;$cont<$filas_resultado;$cont++) {
   $cont=0;
   while ( $cont < $filas_resultado ) {
    $fila = 1;
    while ( $fila <= 2 ) {
     echo "<tr>";
     $colu=1;
     while ( $colu <= 6 )
     {
       if ($vexp<=$filas_resultado) {
         $puntero=$inicio+$cont+1;
         $nombrecheck='check'.$puntero;
         $vtmp = $_POST['check'.$puntero];
         if ($vtmp=='on') {$vcheck[$puntero]='checked';} else {$vcheck[$puntero]='';}
         for($cont2=0;$cont2<$cantcampos;$cont2++) {
             $namecampo=$vectorcampos[$cont2];
  	          switch ($namecampo) {
               case "solicitud":
                 $vs1=substr(trim($reg['solicitud']),-11,4);
                 $vs2=substr(trim($reg['solicitud']),-6);
                 $dirano=substr(trim($reg['solicitud']),-11,4);
                 $nameimagen="../graficos/marcas/ef".$dirano."/".$vs1.$vs2.".jpg"; 
                 break;
               case "clase":
                 $vclase = $reg['clase'];
                 break;
               case "ind_claseni":
                 $vind = $reg['ind_claseni'];
                 break;
             }
         } 
         echo "<td bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Solicitud:<a href='m_rptcronol.php?vsol1={$vs1}&vsol2={$vs2}'>$vs1-$vs2</font></a>";
         echo "<a href='$nameimagen' target='_blank'><img border='1' src='$nameimagen' width='160' height='160'></a>"; 
         echo "<font color='#000000'>  Clase:  $vclase  $vind  </font>";
         echo "<input type='checkbox' name='$nombrecheck' $vcheck[$puntero]> Sel. </font>";
         echo "</td>";
         $reg = pg_fetch_array($resultado);
         $cont++;
       }
       $colu++;
       $vexp++;
     }        
     echo "</tr>";
    $fila++;
    } 
   }
   echo "</table>"; 
   $vurl1= "z_browsef.php?vopc=5";
   ?>

   <input type='submit' name='fmodo' value='<?=$modo?>' /> 
   <? if ($new_windows=='S') { ?>
      <input type="button" img="../imagenes/salir_f2.png" value="Salir" onclick="cerrarwindows();"> </font></p> 

     <!--  <input type='button' value='Salir' name='salir' onclick="cerrarwindows();"></font></p> -->
   <? } else { ?>  
      <input type="button" img="../imagenes/salir_f2.png" value="Salir" onclick="location.href='<?=$vurl?>'"> </font></p> 
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
   <input type="hidden" name="vsol1" value="vsol1">   
   <input type="hidden" name="clase" value="clase">   
   <input type="hidden" name="recibo" value="recibo">   
   <input type="hidden" name="solicitant" value="solicitant">   
   <input type="hidden" name="fecharec" value="fecharec">   
   <input type="hidden" name="prioridad" value="prioridad">   
   <input type="hidden" name="vindcla" value="vindcla">   
   <input type="hidden" name="C1" value="$C1">
   <input type="hidden" name="C2" value="$C2">
   <input type="hidden" name="C3" value="$C3">
   <input type="hidden" name="C4" value="$C4">
   <input type="hidden" name="C5" value="$C5">
   <input type="hidden" name="C6" value="$C6">
   <input type="hidden" name="C7" value="$C7">
   <input type="hidden" name="C8" value="$C8">
   
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

   $smarty->display('pie_pag.tpl');   
   ?>
</body>   
</html>
