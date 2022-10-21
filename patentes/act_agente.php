<script language="javascript">
function cerrarwindows2(){
window.opener.frames[1].location.reload();
window.close();}
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
<body onload="centrarwindows();" bgcolor="#F9F9F9"> 
<?php

//Variable
//$usuario = $_SESSION['usuario_login'];
//$login = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
//bgcolor="#D8E6FF" 
$sql = new mod_db();
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];
$vtipo=$_GET['vtipo'];

echo "<p align='center'><font class='nota5'><b>Solicitud: $vsol</b></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>Introduzca primero el numero de Solicitud que desea Incluir</b></font></p>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
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
  $cuanto = 12;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['vsol']=$vsol;
$hiddenvars['vmod']=$vmod;
$hiddenvars['vtex']=$vtex;
$hiddenvars['vtipo']=$vtipo;
$hiddenvars['inicio']=$inicio;
$hiddenvars['cuanto']=$$cuanto;
$hiddenvars['total']=$total;

 if ($vmod=='Buscar/Incluir' || $vmod=='Buscar')
  {
   $vtex1c=substr($vtex,0,1);
   $vtextit=substr($vtex,1);
   if ($vtex1c=='-') {
     $resultado=pg_exec("SELECT * FROM stzagenr WHERE agente=$vtextit ORDER BY 
                       nombre OFFSET $inicio LIMIT $cuanto"); 
     $cantidad =pg_exec("SELECT * FROM stzagenr WHERE agente=$vtextit");  
   } else {
     $resultado=pg_exec("SELECT * FROM stzagenr WHERE nombre like '$vtex%' ORDER BY 
                       nombre OFFSET $inicio LIMIT $cuanto");
     $cantidad =pg_exec("SELECT * FROM stzagenr WHERE nombre like '$vtex%'"); 
   }
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
      echo "<p align='center'><font class='nota3'>El nombre que esta buscando no corresponde a ningun Agente de la Propiedad Industrial registrado en nuestro Sistema. Este modulo solo permite incluir a Poderhabientes registrados.</font></p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
       exit;
   }
   echo "<p align='center'><font class='nota3'><b>Seleccione el Agente que desea incluir:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%'  class='celda4'>Sel</font></td>";   
   echo " <td width='10%' class='celda4'>>CODIGO</font></td>";
   echo " <td width='40%' class='celda4'>>NOMBRE</font></td>";
   echo "</tr>";
   echo "<form name='formti' method='POST' action='updagente.php'>"; 
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda3'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' class='celda3'>$reg[agente]</font></td>";
     echo " <td width='40%' class='celda3'>$reg[nombre]</font></td>";
     echo "</tr>";
     $titacum[$cont]=$reg[agente];
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
      echo "<input type='hidden' name='vtipo' value='$vtipo'>";
      echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='submit' class='boton_blue' value='Incluir' name='incluir'>
            <input type='button' class='boton_blue' value='Salir' name='salir' onclick='cerrarwindows2()'></font></p>"; 
   echo "</form>";
echo "<form method='POST' action='act_agente.php?vsol=$vsol&vmod=$vmod&vtex=$vtex&vtipo=$vtipo'>"; 
?>
   <p align='center'><I><b><font class='nota4'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> ocurrencias encontradas </font></b></I></p>
<div align="center">
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
</div>
   <?
   }
   else
   {
   //espacio    &nbsp;
   }
   echo "</form>";
  }
 
 if ($vmod=='Buscar/Eliminar'  || $vmod=='Eliminar')
  {$resultado=pg_exec("SELECT * FROM tmpagenr WHERE solicitud='$vsol' and tipo_mp='$vtipo'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="updagente.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vtipo' value='$vtipo'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><font class='nota3'><b>Selecciones los Agentes que desea eliminar:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%'  class='celda4'>Sel</font></td>";   
   echo " <td width='10%' class='celda4'>CODIGO</font></td>";
   echo " <td width='40%' class='celda4'>NOMBRE</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda3'><input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' class='celda3'>$reg[agente]</font></td>";
     echo " <td width='40%' class='celda3'>$reg[nombre]</font></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[agente]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'><font class='nota3'>AVISO: NINGUN AGENTE ASOCIADO</font></p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      echo "<input type='submit' value='Eliminar' name='eliminar' >
            <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   echo "</form>";
  }

 if ($vmod=='Ver')
  {$resultado=pg_exec("SELECT * FROM tmpagenr WHERE solicitud='$vsol' and tipo_mp='$vtipo'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   echo "<p align='center'><font class='nota3'><b>AGENTES ASOCIADOS A LA SOLICITUD $vsol:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='10%' class='celda4'>CODIGO</font></td>";
   echo " <td width='40%' class='celda4'>NOMBRE</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='10%' class='celda3'>$reg[agente]</font></td>";
     echo " <td width='40%' class='celda3'>$reg[nombre]</font></td>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'><font class='nota3'>AVISO: NINGUN AGENTE ASOCIADO</font></p>"; }
   echo "<p align='center'><font color='#0000FF'>";
   echo "<input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   exit;
  }

?>
</body>
</html>
