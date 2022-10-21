<script language="javascript">
function cerrarwindows2(){
window.opener.frames[1].location.reload();
window.close();
}
</script>

<?php
include ("../setting.inc.php");
require ("../include.php");
include ("/apl/librerias/library.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" bgcolor="#F9F9F9"> 

<?php

//Variable
//$usuario = $_SESSION['usuario_login'];
//$login = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$sql = new mod_db();

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vtip=$_GET['vtip'];

echo "<br />";
echo "<p align='center'><font class='nota5'><b>Solicitud: $vsol</b></font></p>";

if ($vsol=='-') { 
   echo "<br />";
   echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>Introduzca primero el numero de solicitud</b></font></p>";
   echo "<hr>";
   echo "<p align='center'><input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></p>";
   exit;
   }

//Verificando conexion
$sql->connection();

//Paginacion
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total = $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = 10;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;

echo "<br />";
 if ($vmod=='Buscar/Incluir' || $vmod=='Buscar')
  {$resultado=pg_exec("SELECT * FROM stzsolic WHERE nombre like '$vtex%' order by nombre OFFSET $inicio LIMIT $cuanto");
   $cantidad =pg_exec("SELECT * FROM stzsolic WHERE nombre like '$vtex%'");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font class='nota3'><b>INGRESO DE TITULAR NUEVO</p></font></b>"; 
       ?>
       <form action="updatitularp.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='Grabar Nuevo Titular'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<input type='hidden' name='vtip' value='$vtip'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='99%'>";
       echo "<tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>&nbsp;"; 
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";       
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>C&eacute;dula/Rif:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "&nbsp;<select size='1' name='vcodl'>";
       echo "  <option value='V'>V</option>";
       echo "  <option value='E'>E</option>";
       echo "  <option value='P'>P</option>";
       echo "  <option value='J'>J</option>";
       echo "  <option value='G'>G</option>";
       echo " </select>";
       echo "<input type='text' name='vcod' value='$vcod' size='9' maxlength='9' onKeyup='checkLength(event,this,9,document.formtitular.vnom)' onKeyPress='return acceptChar(event,3,this)' onchange='Rellena(document.formtitular.vcod,9)'></b></font>";
	    echo "<font size='1'>V= Venezolano  E= Extranjero  P= Pasaporte  J= Juridico  G= Gobierno</font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>* Nombre:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      &nbsp;<input type='text' name='vnom' value='$vtex' size='68' maxlength='200' onkeydown='codigotecla(document.formtitular.vdom)'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>* Nacionalidad:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
        for($cont=0;$cont<$filas_res_pais;$cont++) 
        { 
          echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
          $reg = pg_fetch_array($res_pais);
        }
       echo "      </select></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>* Domicilio:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vdom' size='68' maxlength='200'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>* Indole:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "&nbsp;<select size='1' name='vind'>";
       echo "  <option value='G'>Sector Publico</option>";
       echo "  <option value='C'>Cooperativas</option>";
       echo "  <option value='O'>Comunales</option>";
       echo "  <option value='P'>Empresa Privada</option>";
       echo "  <option value='N'>Persona Natural</option>";
       echo " </select></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tel&eacute;fono 1:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vtl1' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Tel&eacute;fono 2:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vtl2' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><small><font color='#FFFFFF' face='MS Sans Serif'><b>Fax:</b></font></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vfax' size='15' maxlength='15' onKeyPress='return acceptChar(event,9,this)' onKeyup='checkLength(event,this,14,document.forobfie.vfax)'>&nbsp;&nbsp;<small>Formato: (9999) 9999999</small></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>E-Mail:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vema' size='68' maxlength='200'></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";

       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<p align='center'><input type='image' name='incluir' value='Grabar Nuevo Titular' src='../imagenes/database_save.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
   }
   echo "<p align='center'><b>Seleccione el Titular que desea incluir:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CODIGO</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NAC.</font></td>";
   echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>DOMICILIO</font></td>";
   echo "</tr>";
   echo "<form name='formti' method='POST' action='updatitularp.php'>"; 
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><select size='1' name='vnac$cont' value='$reg[nacionalidad]' size='2' onkeydown='codigotecla(document.formti.vdom$cont)'>"; 
     $res_pais=pg_exec("SELECT pais,substr(nombre,1,15) as nombre FROM stzpaisr ORDER BY pais");
     $filas_res_pais=pg_numrows($res_pais); 
     $regpais = pg_fetch_array($res_pais);
     for($i=0;$i<$filas_res_pais;$i++) 
     {  if ($i==0) 
        {echo "<option value=' '> </option>"; } else  
        {echo "<option value=$regpais[pais]>$regpais[pais]-$regpais[nombre]</option>"; }
        $regpais = pg_fetch_array($res_pais);
     }
     echo "</select></font></td>";
     echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><input type='text' name='vdom$cont' value='$reg[domicilio]' onkeydown='codigotecla(document.formti.vpai$cont)'></font></td>";
     echo "</tr>";
     $titacum[$cont]=$reg[titular];
     $nomacum[$cont]=$reg[nombre];
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
      for($cont=0;$cont<$filas_resultado;$cont++) {
          echo "<input type='hidden' name='vtit$cont' value='$titacum[$cont]'>";
          echo "<input type='hidden' name='vnom$cont' value='$nomacum[$cont]'>";
         } 
      echo "<input type='hidden' name='vsol' value='$vsol'>";
      echo "<input type='hidden' name='vfil' value='$filas_resultado'>";
      echo "<input type='hidden' name='vmod' value='$vmod'>";
      echo "<input type='hidden' name='vtip' value='$vtip'>";
      echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='submit' class='boton_blue' value='Incluir' name='incluir'>
            <input type='button' class='boton_blue' value='Salir' name='salir' onclick='cerrarwindows2()'></font></p>"; 
   echo "</form>";
   echo "<form method='POST' action='act_titulard.php?vsol=$vsol&vmod=$vmod&vtex=$vtex'>"; 
   ?>
   <p align='center'><b><font size='3' face='Tahoma'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></p>
   <?php
   ?>
   <input type="hidden" name="adelante">
   <input type="hidden" name="atras">
   <?
   foreach($hiddenvars as $var => $val)
   {
   ?>
   <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
   <?
   }
   if($inicio > 0)
   {
   ?>
   <input type="submit" class="boton_blue" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
   <?
   }
   else
   {
   //espacio  &nbsp;
   }
   if($total - $inicio > $cuanto)
   {
   ?>
   <input type='submit' class='boton_blue' name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</form>";
   
  }
 
 if ($vmod=='Buscar/Eliminar'  || $vmod=='Eliminar')
  {$resultado=pg_exec("SELECT * FROM temptitu WHERE solicitud='$vsol'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="updatitularp.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<input type='hidden' name='vtip' value='$vtip'>";
   echo "<p align='center'><b>Seleccione los Titulares que desea eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CODIGO</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NACIONALIDAD</font></td>";
   echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>DOMICILIO</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     $res_pais=pg_exec("SELECT nombre FROM stzpaisr where pais='$reg[nacionalidad]'");
     $regpais = pg_fetch_array($res_pais);
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[nacionalidad]-$regpais[nombre]</font></td>";
     echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[domicilio]</font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[titular]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "<input type='hidden' name='nac$cont' value='$reg[nacionalidad]'>";
     echo "<input type='hidden' name='dom$cont' value='$reg[domicilio]'>";
     echo "<input type='hidden' name='pai$cont' value='$reg[pais_resid]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN TITULAR ASOCIADO</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='submit' class='boton_blue' value='Eliminar' name='eliminar' > 
            <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   echo "</form>";
  }

if ($vmod=='Cambiar Domicilio')
  {$resultado=pg_exec("SELECT * FROM temptitu WHERE solicitud='$vsol' and tipo_mp='$vtip' order by titular");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="updatitularp.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='Cambiar Domicilio'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<input type='hidden' name='vtip' value='$vtip'>";
   echo "<p align='center'><b>Seleccione y cambie el Domicilio del Titular:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CODIGO</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NACIONALIDAD</font></td>";
   echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>DOMICILIO</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'><select size='1' name='vnac$cont' value='$reg[nacionalidad]' size='2'>"; 
     $res_pais=pg_exec("SELECT pais,substr(nombre,1,15) as nombre FROM stzpaisr ORDER BY pais");
     $filas_res_pais=pg_numrows($res_pais); 
     $regpais = pg_fetch_array($res_pais);
     for($i=0;$i<$filas_res_pais;$i++) 
     {  if ($i==0) 
        {echo "<option value=' '> </option>"; } else  
        {echo "<option value=$regpais[pais]>$regpais[pais]-$regpais[nombre]</option>"; }
        $regpais = pg_fetch_array($res_pais);
     }
     echo "</select></font></td>";
     echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'><input type='text' name='vdom$cont' value=''></font></td>";
     echo "<input type='hidden' name='vtit$cont' value='$reg[titular]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN TITULAR ASOCIADO</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='submit' class='boton_blue' value='Cambiar Domicilio' name='eliminar' >
            <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   echo "</form>";
  }

 if ($vmod=='Ver')
  {$resultado=pg_exec("SELECT * FROM temptitu WHERE solicitud='$vsol' and tipo_mp='$vtip'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   echo "<p align='center'><b>TITULARES ASOCIADOS A LA SOLICITUD $vsol:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>CODIGO</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NOMBRE</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>NACIONALIDAD</font></td>";
   echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>DOMICILIO</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[titular]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre]</font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[nacionalidad]</font></td>";
     echo " <td width='30%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[domicilio]</font></td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN TITULAR ASOCIADO</p>";}
   echo "<p align='center'><font color='#0000FF'>";
   echo "<input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   exit;
  }

?>
</body>
</html>
