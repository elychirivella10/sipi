<script language="javascript">
 function cerrarwindows2() {
   window.opener.frames[0].location.reload();
   window.close();
 }
</script>

<?php
  include ("../z_includes.php");
  // ************************************************************************************* 
  // Programa: adm_registros.php 
  // Realizado por el Analista de Sistema Romulo Mendoza 
  // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
  // Año: 2012 BD - Relacional 
  // *************************************************************************************
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Webpi - Sistema en L&iacute;nea de Propiedad Intelectual Caracas - Venezuela</title>
</head>
<body onload="centrarwindows();this.document.formclase.incluir.disabled=true;this.document.formclase.vtex.focus()" bgcolor="FFFFFF">   

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$login     = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$subtitulo = "Solicitud de B&uacute;squeda Fonetica y/o Gr&aacute;fica";
$sql = new mod_db();
$vsol=$_GET['vsol'];
$vmod=$_GET['vmod'];
//$vtex=$_GET['vtex'];
$vtip=$_GET['vtip'];
$tbus=$_GET['tbus'];
$vmon=$_GET['vmon'];
$vfon=$_GET['vfon'];
$vgra=$_GET['vgra'];

echo "<table align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>"; 
echo " <tr>";
echo "  <td width='78%' align='left'>";

//Verificando conexion
$sql->connection();

 <?php
 if ($vmod=='Buscar/Entregar' || $vmod=='Entregar') {
   echo "<table width='79%' align='center' border='0' cellpadding='0' cellspacing='1' bgcolor='#800000'>";
   echo "  <tr>";
   echo "    <td>";
   echo "     <div align='center'>";
   echo "     <font class='titulo1' size='1'><b>Solicitud de B&uacute;squeda Fonetica y/o Gr&aacute;fica</b></font><br />";
   echo "     </div>";
   echo "    </td>";
   echo "  </tr>";
   echo "</table>";

   $ruta = "../imagentemp/";
   //$ruta = $imagen_temp."/";
   $resultado=pg_exec("SELECT * FROM stmtmpbus WHERE nro_tramite='$vsol'");
   $reg=pg_fetch_array($resultado);
   $filas_found=pg_numrows($resultado);

   echo "<div align='center'>";
   echo "<table width='784' border='0' cellpadding='0' cellspacing='1' bgcolor='#FFFFFF'>";
   echo "<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>";
   echo "<tr>";
   echo "<td>";
   echo "<fieldset>";
   echo "<h5>";
   echo "<legend align='left' class='Estilo4'><strong><span>  Seleccione el Item que desea eliminar: </span><br /></strong></legend>";
   echo "</h5>";
   ?>
   <form action="../comun/m_gbclases.php" name="formtitular" method="post"> 
   <?php 
   echo "<input type='hidden' name='vsol' value='$vsol'>";
   echo "<input type='hidden' name='vmod' value='$vmod'>";
   echo "<input type='hidden' name='vder' value='$vder'>";
   echo "<input type='hidden' name='vfil' value='$filas_found'>";

   //echo "<p align='center'><b>Seleccione el Item que desea eliminar:</b></p>";
   echo "<div align='center'>";
   echo "<table border='1' cellpadding='0' cellspacing='0'>";
   echo "<tr><strong>";
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>Sel</font></strong></td>";   
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>No. Referencia</font></strong></td>";
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>Nombre</font></strong></td>";
   echo " <td bgcolor='#800000' bordercolorlight='#000000' align='center'><strong><font face='Time New Roman' color='#FFFFFF' size='2'>Clase</font></strong></td>";
   echo "</tr>";
   for($cont=0;$cont<$filas_found;$cont++) {
     echo "<tr>";
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='center'><font color='#0000FF'> <input type='checkbox' name='B$cont'></font></td>";
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='center'><font color='#0000FF'><input type='text' size='13' readonly value='$reg[nro_busqueda]' style='text-align: right'></font></td>";
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='left'><font color='#0000FF'>";
     $vtipo=$reg[tipo_bus];
     if ($vtipo=="F") { 
       echo " <input type='text' size='60' readonly value='$reg[denominacion]' style='text-align: left'></font></td>"; }
     if ($vtipo=="G") {
       $vden=$reg[denominacion];
       $nameimagen = $ruta.$vden;
       echo "<a href='$nameimagen' target='_blank'><img border='1' src='$nameimagen' width='80' height='80'></a>";
       echo "  Archivo=$vden  "; 
       echo "</font></td>";}
     echo " <td bgcolor='#FFFFFF' bordercolorlight='#000000' align='left'><font color='#0000FF'><input type='text' size='10' readonly value='$reg[clase]' style='text-align: left'></font></td>";
     echo "<input type='hidden' name='num$cont' value='$reg[nro_busqueda]'>";
     echo "<input type='hidden' name='den$cont' value='$reg[denominacion]'>";
     echo "<input type='hidden' name='cla$cont' value='$reg[clase]'>";
     echo "</tr>";
     $reg = pg_fetch_array($resultado);
     }
   echo "</table>"; 
   if ($filas_found==0){echo "<p align='center'>NINGUN ITEM ASOCIADO</p>";
      echo "<p align='center'><font color='#0000FF'>
            <input type='button' value='Aceptar' name='aceptar' onclick='cerrarwindows2()' class='botones'></font></p>";
   }
   else
   {  echo "<p align='center'><font color='#0000FF'>";

      echo "<input type='submit' value='Eliminar' name='eliminar' class='botones' >
            <input type='button' value='Salir' name='aceptar' onclick='cerrarwindows2()' class='botones'></font></p>";
   }
   echo "</form>";

   echo "</tr>";
   echo "</table>";   
   echo "</div>";

  }

//}

function encabezado_niza() {
  echo "<table width='784%' align='center' border='0' cellpadding='0' cellspacing='1'>"; 
  echo "<tr>"; 
  echo "  <td>";
  echo "    <div align='center'>";
  echo "    <strong>";
  echo "    <img src='../imagenes/logo_comercio.jpg' width='784' height='55'>"; 
  echo "    <img src='../imagenes/header2.png' width='784' height='130'>";
  echo "    </strong>";
  echo "    </div>";
  echo "  </td>";
  echo "</tr>";
  echo "</table>";   
}

?>

</body>
</html>
