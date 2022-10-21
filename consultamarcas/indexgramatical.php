<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>

 <script type="text/javascript">

   function checkKey(evt) 
    {if (evt.keyCode == '17') 
    {alert("Comando No Permitido ...!!!"); 
     return false} 
   return true}

  </script>  
  
</head>
<header>

<body onkeydown="return checkKey(event)" onLoad="this.document.formarca.vsol1.focus()" bgcolor="#F9F9F9">

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
        <img src="../imagenes/encabezado.png" width="995px" height="52">
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
    <td width="40%" class="subtitulo1">
		<MARQUEE><b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Impulsando el Software Libre como parte del Gobierno Electr&oacute;nico</i></b></MARQUEE>
    </td>
  </tr>
</table>

<?php

include ("../setting.inc.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
include ("$include_lib/library.php");

$usuario = TRIM($_SESSION['usuario_login']);
$subtitulo = "Consulta Gramatical de Marcas";
$fecha   = trim(fechahoy());

?>

  <table width="100%">
   <tr>
    <td width="30%" class="izq2-color">
      <font face="MS Sans Serif" size="-1">Usuario: <?php echo $usuario ?> </font>
    </td>
    <td width="40%" class="cnt-color3">
      <font face="MS Sans Serif" size="-1"><?php echo $subtitulo ?> </font>
    </td>
    <td width="30%" class="der2-color">
      <font face="MS Sans Serif" size="-1"><?php echo $fecha ?> </font>
    </td>
    </tr>
  </table>

</div>    
</header>

<br /><br />
<?php echo "<form action='busca_marcas_g.php?vusuario=1' method='POST'>"; ?>
<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por Nombre</font>
<p align="center"><font size="3" face="Tahoma">Solicitudes que: <select size="1" name="vsel">
      <option value="1">comiencen por</option>
      <option value="2">el nombre exacto sea</option>
      <option value="3">contengan la porci&oacute;n de texto</option> 
      </select>  <input type="text" name="vtex" size="30">  <input type="submit" class="boton_blue" value="Buscar" name="B1"> <input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></p>
</form>
<br /><br />
<div align="center">
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>
    <input type='button' class='boton_blue' value='Cerrar' name='B3' onclick='window.close();'>
  </td>
  <br /><br /><br />
</div>
 </p>

 <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="987" height="4">
      </div>
    </td>
  </tr> 
 </table>

 <div align="center">
 <font size="-2"><I>Desarrollado por: <b>Coordinaci&oacute;n de Inform&aacute;tica - SAPI Rif: G-20008399-9<br/>
Sistema Versi&oacute;n 1.4, desarrollado con Smarty, CSS, HTML, PHP 5, JavaScript y PostgreSQL 8.3 <br/> 
  Caracas - Venezuela - CopyLeft 2005 - 2013 / Decreto No. 3.390 <I></font>
 </p>
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

