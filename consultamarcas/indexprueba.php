<?
$lastupdate="05/10/2006 - 08:30am"; // Ultima fecha de Actualizaci�
require("lib/library.php");
?>

<html>

<head>
<title>Servicio Autónomo de la Propiedad Intelectual</title>
</head>

<body onLoad="this.document.formarcas.vsol1.focus()" bgcolor="#D8E6FF">

<?php

  // 1=Usuario Interno:  - Activa las Busquedas Avanzadas
  //                     - Las consultas por nombre son en todos los estatus
  // 2=Usuario Externo:  - No activa las Busquedas Avanzadas
  //                     - Las consultas por nombre son solo de Marcas Registradas (Estatus=555) 
  $vtipuser=1
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="18%"><a href="http://www.sapi.gov.ve"><img border="0" src="SAPI_Logo.jpg" width="75" height="66"></td></a>
    <td width="68%" valign="bottom">
      <p align="center" style="margin-top: -4"><b><font size="4" face="Tahoma">Servicio
      Autónomo de la Propiedad Intelectual</font></b></p>
      <p align="center" style="margin-top: -16; margin-bottom: 0"><b><font size="5" face="Tahoma">Bsqueda
      Registro SAPI</font></b>
    <td width="14%"><a href="http://www.mpc.gov.ve"><img border="0" src="MPC_Logo.jpg" width="122" height="57"></td></a>
  </tr>
  <tr>
    <td width="18%" valign="top">
      <p align="left" style="margin-left: 0; margin-top: 0; padding-top: 0"><font size="1">Servicio
      Autónomo de la Propiedad Intelectual</font></td>
    <td width="68%"></td>
    <td width="14%" valign="top">
      <p align="right"><font size="1">Ministerio de la Producción y el Comercio</font></td>
  </tr>
</table>
<hr>

<p align="center"><font size="4" face="Tahoma">Búsqueda por Número de Solicitud</font>
<?php echo "<form name='formarcas' action='busca_marcas_n.php?vopc=1&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; ?>
<p align="center"><font size="3" face="Tahoma">Nmero de Solicitud:  

<!--          
<input type="text" name="vsol1" size="2" maxlength="5" onKeypress="Only_num()" onkeyup="checkLength()" 
onchange="Rellena(document.formarcas.vsol1,4)" onkeydown="codigotecla(document.formarcas.vsol2)">-<input type="text" 
name="vsol2" size="6" maxlength="7" onKeypress="Only_num()" onkeyup="javascript:checkLength();" 
onchange="Rellena(document.formarcas.vsol2,6)" onkeydown="codigotecla(document.formarcas.buscar1)"></td>
--!>

<input type="text" name="vsol1" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas.vsol2)" onchange="Rellena(document.formarcas.vsol1,4)">-
<input type="text" name="vsol2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas.buscar1)" onchange="Rellena(document.formarcas.vsol2,6)">

          <input type="submit" value="Buscar" name="buscar1"></font>
</form>

<?php echo "<form action='busca_marcas_n.php?vopc=2&vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; ?>
<p align="center"><font size="4" face="Tahoma">Bsqueda por Nmero de Registro</font>
<p align="center"><font size="3" face="Tahoma">Nmero de Registro:  <input type="text" name="vreg" size="6" maxlength="7">  <input type="submit" value="Buscar" name="B2"></font>
</form>

<?php echo "<form action='busca_marcas_t.php?vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; ?>
<p align="center"><font size="4" face="Tahoma">Bsqueda por Nombre</font>
<p align="center"><font size="3" face="Tahoma">Solicitudes que <select size="1" name="vsel">
      <option value="1">comiencen por</option>
      <option value="2">el nombre exacto sea</option>
      <option value="3">contengan la porción de texto</option> 
      </select>  <input type="text" name="vtex" size="30">  <input type="submit" value="Buscar" name="B1"></p>
</form>

<?php
if ($vtipuser==1)
  {echo "<form action='busca_marcas_a.php?vusuario=$vtipuser&lastupdate=$lastupdate' method='POST'>"; 
   echo "<p align='center'><font size='1' face='Tahoma'><input type='submit' value='Busqueda Avanzada' name='B2'></font>";
   echo "</form>";
  }
?>
<div align="center">
      <font size="-2">Desarrollado por <b><a href="http://www.sapi.gov.ve" target="_new"><font color="blue">SAPI</font></a>&nbsp;Coordinación de INFORMATICA</b>&nbsp;&nbsp;Caracas, Venezuela - Versión del 10-11-2004 / GNU-LINUX - PostgreSQL - PHP</font><br /><br />
</div>

</body>
</html>
