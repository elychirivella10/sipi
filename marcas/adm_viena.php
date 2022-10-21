<script language="javascript">
function cerrarwindows3() {
  window.opener.frames[1].location.reload();
  window.close();
}
</script>

<?php
// ************************************************************************************* 
// Programa: adm_viena.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body onload="centrarwindows()" > 

<?php
//bgcolor="#F9F7ED" 
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=trim($_GET['vtex']);

echo "<p align='center'><font class='nota5'><I><b>SOLICITUD: $vsol</b></I></font></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><font class='nota3'><b>INTRODUZCA PRIMERO EL NUMERO DE SOLICITUD</b></font>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   exit;
   }

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

 if ($vmod=='Buscar/Incluir') {
   $vtex1c = substr($vtex,0,1);
   $vtexag = substr($vtex,1);
   if ($vtex1c=='-') {
     $resultado=pg_exec("SELECT * FROM stmviena WHERE ccv = '$vtexag' OFFSET $inicio LIMIT $cuanto");
     $cantidad =pg_exec("SELECT * FROM stmviena WHERE ccv = '$vtexag'");
   } else {
       $resultado=pg_exec("SELECT * FROM stmviena WHERE descripcion like '%$vtex%' OFFSET $inicio LIMIT $cuanto");
       $cantidad =pg_exec("SELECT * FROM stmviena WHERE descripcion like '%$vtex%'"); }
  
   //$resultado=pg_exec("SELECT * FROM stmviena WHERE descripcion like '%$vtex%' OFFSET $inicio LIMIT $cuanto");
   //$cantidad =pg_exec("SELECT * FROM stmviena WHERE descripcion like '%$vtex%'");
   $total=pg_numrows($cantidad);
   $reg=pg_fetch_array($resultado);
   $filas_resultado=pg_numrows($resultado);
   
   if ($filas_resultado==0){
       echo "<p align='center'><font class='nota3'><b>NO EXISTE EL Codigo de Viena Buscado ...!!!</b></font></p>"; 
       ?>
       <form action="updatitular.php" name="formtitular" method="POST" >
       <?php
//       echo "<input type='hidden' name='vsol' value='$vsol'>";
//       echo "<input type='hidden' name='vmod' value='$vmod'>";
//       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='1' cellpadding='0' cellspacing='1' width='94%'>";
       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "      <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>NOMBRE:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "      <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vnom' value='$vtex' size='56' onkeydown='codigotecla(document.formtitular.vpai)'></font></td>";
//       echo "</tr>";
//            $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
//            $filas_res_pais=pg_numrows($res_pais);
//            $reg = pg_fetch_array($res_pais);
//       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>PAIS RESIDENCIA:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vpai' onkeydown='codigotecla(document.formtitular.vnac)'>";
//             for($cont=0;$cont<$filas_res_pais;$cont++) 
//             { 
//             echo "<option value=$reg[pais]>$reg[pais]$reg[nombre]</option>";
//             $reg = pg_fetch_array($res_pais);
//             }
//       echo "      </select></font></td>";
//       echo "</tr>";
//            $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
//            $filas_res_pais=pg_numrows($res_pais);
//            $reg = pg_fetch_array($res_pais);
//       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>NACIONALIDAD:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
//             for($cont=0;$cont<$filas_res_pais;$cont++) 
//             { 
//             echo "<option value=$reg[pais]>$reg[pais]$reg[nombre]</option>";
//             $reg = pg_fetch_array($res_pais);
//             }
//       echo "      </select></font></td>";
//       echo "</tr>";
//       echo "<tr>";
//       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
//       echo "       <p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>DOMICILIO:</b></font></td>";
//       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
//       echo "       <p style='margin-top: 2; margin-bottom: 2'>&nbsp;<input type='text' name='vdom' size='56'</font></td>";
       echo "</tr>";
       echo "</table>";   
       echo "<p align='center'>
               &nbsp;<input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       echo "</form>";
////       echo "<form method='POST' action='act_titular.php?vsol=$vsol&vmod=$vmod&vtex=$vtex'>"; 
       exit;
   }
//   ?>
   <p align='center'><b><font class='nota4'>Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b></p>
   <?php
   echo "<p align='center'><font class='nota3'><b>SELECCIONE LOS CODIGOS DE VIENA QUE DESEA ASOCIAR:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='' width='100%'>";
   echo "<tr>";
   echo " <td width='1%'  class='celda4'><small>Sel</small></td>";   
   echo " <td width='10%' class='celda4'><small>Codigo</small></td>";
   echo " <td width='40%' class='celda4'><small>Descripcion</small></td>";
   echo "</tr>";
   echo "<form name='formti' method='POST' action='m_gbviena.php'>"; 
   for($cont=0;$cont<$filas_resultado;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda3'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda3'><small>$reg[ccv]</small></td>";
     echo " <td width='40%' class='celda3'><small>$reg[descripcion]</small></td>";
     echo "</tr>";
     $titacum[$cont]=$reg[ccv];
     $nomacum[$cont]=utf8_decode($reg[descripcion]);
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
      echo "<p align='center'><font color='#0000FF'>";

      //echo "<input type='submit' value='Incluir' name='incluir'>
      //      <input type='button' value='Salir' name='salir' onclick='cerrarwindows3()'></font></p>"; 

      echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/boton_guardar_rojo.png' alt='Save' align='middle' border='0' />
                              <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";

   echo "</form>";
   echo "<form method='POST' action='adm_viena.php?vsol=$vsol&vmod=$vmod&vtex=$vtex'>"; 
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
 
 if ($vmod=='Buscar/Eliminar')
  {$resultado=pg_exec("SELECT * FROM stmtmpccv,stmviena WHERE solicitud='$vsol' and stmtmpccv.ccv=stmviena.ccv");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="m_gbviena.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><font class='nota3'><b>SELECCIONE LOS CODIGOS QUE DESEA ELIMINAR:</b></font></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%'  class='celda4'>Sel</td>";   
   echo " <td width='10%' class='celda4'>CODIGO</td>";
   echo " <td width='40%' class='celda4'>DESCRIPCION</td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%'  class='celda3'><input type='checkbox' name='B$cont'></td>";
     echo " <td width='10%' class='celda3'><small>$reg[ccv]</small></td>";
     echo " <td width='40%' class='celda3'><small>$reg[descripcion]</small></td>";
     echo "<input type='hidden' name='tit$cont' value='$reg[ccv]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[descripcion]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'><font class='nota3'>NINGUN CODIGO VIENA ASOCIADO</p></font>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' class='boton_blue' value='Aceptar' name='aceptar' onclick='cerrarwindows3()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
      //echo "<input type='submit' class='boton_blue' value='Eliminar' name='eliminar' >
      //      <input type='button' class='boton_blue' value='Salir' name='aceptar' onclick='cerrarwindows3()'></font></p>";
      echo "<input type='image' src='../imagenes/boton_eliminar_rojo.png' value='Eliminar'>
            <input type='image' src='../imagenes/boton_salir_rojo.png' value='Salir' onclick='cerrarwindows3()'></p>";
   }
   echo "</form>";
//   echo "<form method='POST' action='act_viena.php?vsol=$vsol&vmod=$vmod&vtex=$vtex'>"; 
   
  }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>