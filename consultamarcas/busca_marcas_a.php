<html>

<head>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>
<meta http-equiv="Content-Language" content="es">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="Bluefish 2.2.3" >
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>SIPI - Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>

<body bgcolor="#FFFFFF">

<?
$lastupdate=$_GET['lastupdate'];
?>

<div align="center"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="992" height="2">
      </div>
    </td>
  </tr> 
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
     <td width="100" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/cintillo2015.png" width="100%" height="52"> 
        <!-- <img src="../imagenes/topenuevo2013_02.png" width="100%" height="52"> 
        <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
      </font>
    </td>
  </tr>
</table>

<table width="100%" align="center" >
  <tr height="30" >
    <td width="5%" class="subtitulo2">
      <b><i><a href="">Inicio</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://www.sapi.gob.ve" target="blank">Sapi</a></i></b> 
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://correo.sapi.gob.ve" target="blank">Correo</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://sire.sapi.gob.ve/" target="blank">Sire</a></i></b> 
    </td>
    <td width="10%" class="subtitulo2">
      <b><i><a href="http://www.bicentenariobu.com" target="blank">Banco Bicentenario</a></i></b>
    </td>
    <td width="44%" class="subtitulo1">
		<MARQUEE><b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Impulsando el Software Libre como parte del Gobierno Electr&oacute;nico</i></b></MARQUEE>
    </td>
  </tr>
</table>

</div>    

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$urole   = trim($_SESSION['usuario_rol']);
$fecha   = trim(fechahoy());
$subtitulo = "Consulta Interna de Marcas";
$sql = new mod_db();

?>
  <table width="100%">
   <tr>
    <td width="30%" class="izq2-color">
      <font face="MS Sans Serif" size="-1">Usuario Interno: <?php echo $usuario ?> </font>
    </td>
    <td width="40%" class="cnt-color3">
      <font face="MS Sans Serif" size="-1"><?php echo $subtitulo ?> </font>
    </td>
    <td width="30%" class="der2-color">
      <font face="MS Sans Serif" size="-1"><?php echo $fecha ?> </font>
    </td>
    </tr>
  </table>

<?php
//Verificando conexion
$sql->connection();

$vtipuser=$_GET['vusuario'];
$vhomepage='indexfull.php';
$vhomereset='busca_marcas_a.php?vusuario=1';
  
//if ($vtipuser==1)
//    {$vhomepage='indexi.php';}
//if ($vtipuser==2)
//    {$vhomepage='indexmp.php';}

//$vtipuser=$_GET['vusuario'];

//echo "<form action='busca_marcas_t.php?vopc=1&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>";
echo "<form action='busca_marcas_t.php?vopc=1&vusuario=$vtipuser' method='POST'>";
?>
<p style="margin-top: -4"><font face="Tahoma"><b></b></font></p></font>

<!-- <p style="margin-top: -4"><font face="Tahoma"><b>INGRESE UNO O VARIOS CRITERIOS DE BUSQUEDA:   <input type="reset" class="boton_blue" value="Limpiar" name="B2">  <input type="submit" class="boton_blue" value="Buscar" name="B2"></b></font></p></font> -->
<p style="margin-top: -4"><font face="Tahoma"><b>INGRESE UNO O VARIOS CRITERIOS DE BUSQUEDA:  </b></font></p></font>
<table align='center' border="0" cellpadding="0" cellspacing="0" width="94%">
  <tr>
    <td width="23%" height="15" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>No. Solicitud:</b></font></td>
    <td width="77%" height="15" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;DESDE: <input type="text" name="vsol1des" size="4" maxlength="4">-<input type="text" name="vsol2des" size="5" maxlength="6">  HASTA: <input type="text" name="vsol1has" size="4" maxlength="4">-<input type="text" name="vsol2has" size="5" maxlength="6"></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>No. Registro:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;DESDE: <input type="text" name="vregdes" size="6" maxlength="7">  HASTA: <input type="text" name="vreghas" size="6" maxlength="7"></font></td>
  </tr>
 <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Fecha Solicitud:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;DESDE: <input type="text" name="vfde" size="8" maxlength="10">  HASTA: <input type="text" name="vfha" size="8" maxlength="10"></font></td>
  </tr>
 <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Estatus:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<select size="1" name="vest">
      <option></option>
    <?php
      $res_estatus=pg_exec("SELECT estatus,descripcion FROM stzstder ORDER BY estatus");
      $filas_res_estatus=pg_numrows($res_estatus);
      $reg = pg_fetch_array($res_estatus);
      for($cont=0;$cont<$filas_res_estatus;$cont++) 
         { 
         $desest=substr($reg[descripcion],0,60);
         echo "<option value=$reg[estatus]>$reg[estatus]  $desest</option>";
         $reg = pg_fetch_array($res_estatus);
         }
    ?>
    </select></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      	<p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Tipo de Marca:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<select size="1" name="vtip">
      <option></option>
      <option value="M">MARCA DE PRODUCTO</option>
      <option value="N">NOMBRE COMERCIAL</option>
      <option value="L">LEMA COMERCIAL</option>
      <option value="S">MARCA DE SERVICIO</option>
      <option value="C">MARCA COLECTIVA</option>
      <option value="D">DENOMINACION COMERCIAL</option>
      <option value="O">DENOMINACION DE ORIGEN</option>
      </select></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Clase:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<input type="text" name="vcla" size="1" maxlength="2"></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Pa&iacute;s:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<select size="1" name="vpai">
      <option></option>
    <?php
      $res_pais=pg_exec("SELECT * FROM stzpaisr ORDER BY pais");
      $filas_res_pais=pg_numrows($res_pais);
      $reg = pg_fetch_array($res_pais);
      for($cont=0;$cont<$filas_res_pais;$cont++) 
         { 
         echo "<option>$reg[pais]$reg[nombre]</option>";
         $reg = pg_fetch_array($res_pais);
         }
    ?>
    </select></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Nombre:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<select size="1" name="vsel">
      <option value="1">comiencen por</option>
      <option value="2">el nombre exacto sea</option>
      <option value="3">contengan la porci&oacute;n de texto</option>
      </select>  <input type="text" name="vtex" size="30"></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>C&oacute;digo del Titular:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<input type="text" name="vcti" size="6" maxlength="6"></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>C&oacute;digo del Agente:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<input type="text" name="vcag" size="6" maxlength="6"></font></td>
  </tr>
  <tr>
    <td width="23%" style="background-color: #00688B; border: 1 solid #D8E6FF">
      <p align='right' style="margin-top: 2; margin-bottom: 2"><font color="#FFFFFF" face="MS Sans Serif"><b>Nombre Tramitante:</b></font></td>
    <td width="77%" style='background-color: #87cefa; border: 1 solid #D8E6FF'><font face='Tahoma'>
      <p style="margin-top: 2; margin-bottom: 2">&nbsp;<input type="text" name="vntr" size="30"></font></td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
  <tr><td>
  <p align='center'>
  <!-- <input type="submit" class="boton_blue" value="Buscar" name="B2">
  <input type="reset" class="boton_blue" value="Limpiar" name="B2">
  <a href='<? echo $vhomepage; ?>'><font face='Tahoma' ><input type='button' class='boton_blue' value='Regresar' name='B3'></font></a> -->
  <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">  
  <a href='<? echo $vhomereset; ?>'><img src="../imagenes/boton_limpiar_rojo.png" name="limpiar"></a>
  <a href='<? echo $vhomepage; ?>'><img src="../imagenes/boton_regresar_rojo.png" name="regresar"></a>
  <br>
  </td></tr>
</tabla>
&nbsp;
<br>
</form>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="70%" height="15">
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688B"><b>Los datos emitidos por la siguiente consulta son netamente informativos,</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688B"><b>la informaci&oacute;n contenida en la presente p&aacute;gina no obliga ni compromete la responsabilidad del SAPI.</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688B"><b>Por lo anterior, no reemplaza en ning&uacute;n caso los mecanismos legales de notificaci&oacute;n</font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688B"><b>y se constituye exclusivamente en una ayuda adicional para los usuarios de la misma. </font></b></td></tr>
   <tr><td><p align="center"><font face="Tahoma" font size="2" font color="#00688B"><b>La validez legal de las consultas se notifica a trav&eacute;s del bolet&iacute;n.</font></b></td></tr>
</table>

<br><br><br><br><br>
 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="987" height="4">
      </div>
    </td>
  </tr> 
 </table>

 <div align="center" class="pie1">
 <font size="-2"><I>Desarrollado por: <b>Coordinaci&oacute;n de Inform&aacute;tica - SAPI Rif: G-20008399-9<br/>
Sistema Versi&oacute;n 1.4, desarrollado con Smarty, CSS, HTML, PHP 5, JavaScript y PostgreSQL 9 <br/> 
  Caracas - Venezuela - CopyLeft 2005 - 2018 / Decreto No. 3.390 <I></font>
 </div> 

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="987" height="4">
      </div>
    </td>
  </tr> 
 </table>
 
</body>
</html>
