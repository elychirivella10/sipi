<?php 
//  Programa PHP. Pantalla de Busqueda Avanzada de Patentes
// (bavanzada.php por Diferentes campos) 
// Realizado Por Ing. Karina Pérez
// Modificado por Ing. Rómulo Mendoza / Julio 2008 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

<html>
<head>

<link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
<style type="text/css">
</style>
<link rel="shortcut icon" href="LOGOS/shortcut_icon_phplm.png"></link>
<title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>

<?php include ("libjs/layersmenu-browser_detection.js"); ?>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu-library.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layerstreemenu-cookies.js"></script>

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");

$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

</head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#aa0000">
<tr><td>
<table width="100%" border="0" cellpadding="8" cellspacing="1">
<tr>
<td class="topbar" colspan="2">

<table border="0" width="100%">
  <tr>
    <td width="14%"><img border="0" src="../imagenes/SAPI_Logo.png" width="62" height="58"></td>
    <td width="71%"><div class="h1bar" align="center">Servicio Aut&oacute;nomo de la Propiedad Intelectual</div>
      <center><b>
Sistema de B&uacute;squeda de Patentes
</b>
</center>
    </td>
    <td width="15%"><b></b>
    </td>
</tr>
</table>

</td>
</tr>
<tr>
<td width="20%" class="bar" valign="top" nowrap="nowrap">
<center>
<br />
</center>
<br />
Menu
<?php
$mid->setMenuStructureFile("layersmenu-vertical-1.txt");
$mid->parseStructureForMenu("treemenu1");
print $mid->newTreeMenu("treemenu1");
?>
<br />
<br />
<center>
</center>
<br />
<center>
</center>
<br />
<center>
</center>
</td>
<td valign="top" bgcolor="#fffff8">
 
		<p align="left"><font face="Tahoma" size="2"><b>B&uacute;squeda Combinada de Criterios</b></font></p>

   <table border="1" width="95%" height="89">
    <tr>
      <td width="100%" height="19" bgcolor="#CC0000">
       <p style="line-height: 100%"><b><font face="Tahoma" size="2" color="#FFFFFF">Utilice el formulario para introducir sus criterios de b&uacute;squeda</font></b></td>
    </tr>
	 <tr>
    <td width="100%" height="16" bgcolor="#669ec4"><p>
       <!--<p align="left"><font face="Tahoma" size="2"> Utilice el formulario para introducir sus criterios de b&uacute;squeda</font></p>-->
	    <form method="POST" action="lis_avanzada.php">
	 	 <p style="line-height: 100%"> 
          	 <p align="left"><font face="Tahoma" size="2">
             <p style="line-height: 100%">&nbsp;T&iacute;tulo: <input type="text" name="titulo" size= "70" onKeyPress="javascript:this.value=this.value.toUpperCase();">
 		 <p style="line-height: 100%">&nbsp;Resumen: <input type="text" name="resumen" size="70" onKeyPress="javascript:this.value=this.value.toUpperCase();">
             <p style="line-height: 100%">&nbsp;Nro. Prioridad: <input type="text" name="prioridad" size="10" >
             <p style="line-height: 100%">&nbsp;Fecha de Publicaci&oacute;n: <input type="text" name="fecha" size="10" > Formato: dd/mm/yyyy
             <p style="line-height: 100%">&nbsp;Inventor: <input type="text" name="inventor" size="70" onKeyPress="javascript:this.value=this.value.toUpperCase();">
             <p style="line-height: 100%">&nbsp;Empresa: <input type="text" name="empresa"  size="70" onKeyPress="javascript:this.value=this.value.toUpperCase();">
             <p style="line-height: 100%">&nbsp;Clas. Internacional: <input type="text" name="clasificacion" size="15" onKeyPress="javascript:this.value=this.value.toUpperCase();">
             <p style="line-height: 100%">&nbsp;Clas. Locarno: <input type="text" name="locarno" size="5" onKeyPress="javascript:this.value=this.value.toUpperCase();"> Formato: 99-99
	       <input type="hidden" name="inicio">
	       <input type="hidden" name="cuanto">
	       <input type="hidden" name="total">
	       <input type="hidden" name="adelante">
	       <input type="hidden" name="atras">
		 <p>
	       <input type="submit" value="Buscar" name="B1">
	       <input type="reset" value="Limpiar" name="B2"></p>
		</form>
     </td>
     </tr>
    </table>
</td>
</tr>
</table>
</td></tr>
</table>

<?php
$mid->printFooter();
?>

</body>
</html>
