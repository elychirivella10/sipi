<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>
</head>
<header>

<body onLoad="this.document.formarca.vsol1.focus()" bgcolor="#F9F9F9">

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
        <!--  <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
$subtitulo = "Consulta Interna de Indicaciones Geograficas";
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

<div align="center">
<br /><br />
<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por N&uacute;mero de Solicitud</font>
<?php 
  //require("../../librerias/library.php"); 
  $vtipuser=5; 
  //$lastupdate="12/08/2008 - 08:30am"; 
  echo "<form name='formarca' action='busca_indicacionesg_n.php?vopc=1&vusuario=$vtipuser' method='POST'>"; 
?>
<p align="center"><font size="3" face="Tahoma">N&uacute;mero de Solicitud:</font>
<input type="text" name="vsol1" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.formarca.vsol1,4)" onkeyup="checkLength(event,this,4,document.formarca.vsol2)">-
<input type="text" name="vsol2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.formarca.vsol2,6)" onkeyup="checkLength(event,this,6,document.formarca.buscar1)">
<input type="submit" class="boton_blue" value="Buscar" name="buscar1">
<input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></font>
</form>
<br /><br />
<?php $vtipuser=5; echo "<form action='busca_indicacionesg_n.php?vopc=2&vusuario=$vtipuser' method='POST'>";  ?>
<p align="center"><font size="4" face="Tahoma">B&uacute;squeda por N&uacute;mero de Registro</font>
<p align="center"><font size="3" face="Tahoma">N&uacute;mero de Registro:  <input type="text" name="vreg" size="6" maxlength="7">  <input type="submit" class="boton_blue" value="Buscar" name="B2"> <input type="reset" class="boton_blue" value="Limpiar" name="limpiar"></font>
</form>
<br /><br />
<br /><br />
<?php
?>
  <td>&nbsp;</td>
  <td>
    <a href="../salir.php">
    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" />
    <font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></a>
  </td>
  <br /><br /><br /><br />

 
</div>
 <br><br><br><br><br><br><br><br><br><br><br><br>
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
Sistema Versi&oacute;n 1.4, desarrollado con Smarty, CSS, HTML, PHP 5, JavaScript y PostgreSQL 8.3 <br/> 
  Caracas - Venezuela - CopyLeft 2005 - 2013 / Decreto No. 3.390 <I></font>
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

