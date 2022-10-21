<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.opener.frames[1].location.reload();
   window.opener.frames[2].location.reload();
   window.opener.frames[3].location.reload();
   window.close();
 }
</script>

<?php
// ************************************************************************************* 
// Programa: adm_inventor.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head><body onload="centrarwindows()" bgcolor="F9F7ED">
   
<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();

//Verificacion de Conexion 
$sql->connection($usuario);   

//Variable
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];


$smarty->display('encabezado1.tpl');

echo "<p align='center'><b>Solicitud: $vsol</b></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>Introduzca primero el Nombre del Inventor que desea Incluir</b>";
   echo "<hr>";
   echo "<p align='center'><font color='#0000FF'><input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
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
  $cuanto = 12;

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
   $filas_resultado=0;
   if ($filas_resultado==0){
       echo "<p align='center'><b>INGRESO DE NUEVO INVENTOR</p></b>"; 
       ?>
       <form action="p_gbinven.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='99%'>";
       echo "<tr>";
       //echo "<tr><td class='izq-color'></td>";
	    //echo "<td class='der-color'>&nbsp;"; 
       //echo "</td></tr>"; 
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";
       echo "<tr>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>* Nombre:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "    <input type='text' name='vnom' value='$vtex' size='60' maxlength='120' onkeydown='codigotecla(document.formtitular.vnac)'></font></td>";
       echo "</tr>";
       //echo "<tr><td></td></tr>";
       $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
       $filas_res_pais=pg_numrows($res_pais);
       $reg = pg_fetch_array($res_pais);
       echo "<tr>";
       echo "<td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "<small><p align='right' style='margin-top: 2; margin-bottom: 2'><font color='#FFFFFF' face='MS Sans Serif'><b>* Pa&iacute;s:</b></font></small></td>";
       echo "<td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       //echo "<p style='margin-top: 2; margin-bottom: 2'><select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
       echo "<select size='1' name='vnac' onkeydown='codigotecla(document.formtitular.vdom)'>";
       for($cont=0;$cont<$filas_res_pais;$cont++) 
       { 
         echo "<option value=$reg[pais]>$reg[pais] $reg[nombre]</option>";
         $reg = pg_fetch_array($res_pais);
       }
       echo "</select></font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr><td></td></tr>";       
       //echo "<tr><td></td></tr>";       
       //echo "<tr><td></td></tr>";
       echo "<tr>";
       //<td class='izq-color'></td>";
	    //echo "<td class='der-color'>";
	    echo "<td>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       //echo "</td></tr>"; 
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       exit;
   }
  }
?>

 <?php
 if ($vmod=='Buscar/Eliminar') {
   $resultado=pg_exec("SELECT * FROM stptmpinv WHERE solicitud='$vsol'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="p_gbinven.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<p align='center'><b>Seleccione el Inventor que desea eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>N&uacute;mero</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Nombre</font></td>";
   echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Nacionalidad</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[numero]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nombre_inv]</font></td>";
     echo " <td width='40%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='left'><font color='#0000FF'>$reg[nacionalidad]</font></td>";
     echo "<input type='hidden' name='num$cont' value='$reg[numero]'>";
     echo "<input type='hidden' name='nom$cont' value='$reg[nombre_inv]'>";
     echo "<input type='hidden' name='pai$cont' value='$reg[nacionalidad]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN INVENTOR ASOCIADO</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      echo "<input type='submit' value='Eliminar' name='eliminar' >
            <input type='button' value='Salir' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   echo "</form>";
  }

//Desconexion de la Base de Datos
$sql->disconnect();
  
?>
</body>
</html>
