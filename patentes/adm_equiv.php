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
// Programa: adm_equiv.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 I Semestre, BD - Relacional 
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
$fecha   = fechahoy();

//Verificacion de Conexion 
$sql->connection($usuario);   

//Variable
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
$vtex=$_GET['vtex'];

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

echo "<p align='center'><b>Solicitud: $vsol</b></p>";
if ($vsol=='-') 
   {echo "<hr>";
   echo "<p align='center'><b>Introduzca primero el Numero de la Equivalencia que desea Incluir</b>";
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

       echo "<p align='center'><b>INGRESO DE NUEVA EQUIVALENCIA</p></b>"; 
       ?>
       <form action="p_gbequiv.php" name="formtitular" method="POST" >
       <?php
       echo "<input type='hidden' name='vsol' value='$vsol'>";
       echo "<input type='hidden' name='vmod' value='$vmod'>";
       echo "<input type='hidden' name='vfil' value='0'>";
       echo "<table align='center' border='0' cellpadding='0' cellspacing='0' width='960px'>";
       echo "<tr>";
       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>&nbsp;"; 
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";
       echo "<tr>";
       //echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #D8E6FF'>";
       echo "   <td width='23%' style='background-color: #015B9E; border: 1 solid #FFFFFF'>";
       echo "<p align='right' style='margin-top: 2; margin-bottom: 2'>";
       echo "<small><font color='#FFFFFF' face='MS Sans Serif'><b>* Numero:</b></font></small></td>";
       echo "   <td width='77%' style='background-color: #7AC0EF; border: 1 solid #D8E6FF'><font face='Tahoma'>";
       echo "      &nbsp;<input type='text' name='vnum' value='$vtex' size='60' maxlength='35' onkeydown='codigotecla(document.formtitular.vnac)'>Max 35 Caracteres </font></td>";
       echo "</tr>";
       echo "<tr><td></td></tr>";
       echo "<tr><td></td></tr>";
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";       
       echo "<tr><td></td></tr>";

       echo "<tr><td class='izq-color'></td>";
	    echo "<td class='der-color'>";
	    echo "<font size='1'> * Campos Obligatorios</font>";
       echo "</td></tr>"; 
       echo "<tr><td></td></tr>";
      
       echo "</table>";   
       echo "<br>";
       echo "<p align='center'><input type='image' name='salir' value='Incluir' src='../imagenes/boton_guardar_azul.png' alt='Save' align='middle' border='0' />&nbsp
                               <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/boton_salir_rojo.png' alt='Salir' align='middle' border='0' /></p>";
       
       echo "<p align='center'><input type='image' name='incluir' value='Incluir' src='../imagenes/save_f2.png' alt='Save' align='middle' border='0' />&nbsp;Grabar&nbsp;&nbsp;
                           <input type='image' name='salir' value='Salir' onclick='window.close()' src='../imagenes/salir_f2.png' alt='Salir' align='middle' border='0' />&nbsp;Salir&nbsp;&nbsp;</p>";
       echo "</form>";
       echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
       $smarty->display('pie_pag.tpl');
       exit;
   }
  }
?>

 <?php
 if ($vmod=='Buscar/Eliminar') {
   $resultado=pg_exec("SELECT * FROM stptmpeq WHERE solicitud='$vsol'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);
   ?>
   <form action="p_gbequiv.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";
   echo "<div align='center'>";
   echo "<p align='center'><b>Seleccione el Numero que desea eliminar:</b></p>";
   echo "<table border='1' cellpadding='0' cellspacing='0' width='960px'>";
   echo "<tr>";
   echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'></font>Sel</td>";   
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>N&uacute;mero</font></td>";
   echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#000000'>Equivalencia</font></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td width='1%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td width='10%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[numero]</font></td>";
     echo " <td width='15%' bgcolor='#CCCCCC' bordercolorlight='#FFFFFF' align='center'><font color='#0000FF'>$reg[equivalente]</font></td>";
     echo "<input type='hidden' name='num$cont' value='$reg[numero]'>";
     echo "<input type='hidden' name='eqv$cont' value='$reg[equivalente]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUNA EQUIVALENTE ASOCIADA</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";
     echo "<p align='center'>
           <input type='image' name='eliminar' value='Eliminar' src='../imagenes/boton_eliminar_rojo.png' align='middle' border='0' />&nbsp
           <input type='image' name='aceptar' value='Salir' onclick='cerrarwindows3()' src='../imagenes/boton_salir_rojo.png' align='middle' border='0' />
           </p>";
   }
   echo "</div>";   
   echo "</form>";
   echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
   $smarty->display('pie_pag.tpl');
  }

//Desconexion de la Base de Datos
$sql->disconnect();
  
?>
</body>
</html>
