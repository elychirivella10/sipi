<?php 
// Programa PHP. Pantalla de busquedad de Registro 
// (Lis_registro.php por Numero de registro)
// Realizado Por Ing. Karina P?rez
// Modificado por Ing. R?mulo Mendoza / Julio 2008 
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
include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");
$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

</head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
<tr><td>
<table width="100%" border="0" cellpadding="8" cellspacing="1">
<tr>
<td class="topbar" colspan="2">

<table border="0" width="100%">
  <tr>
    <td width="14%"><img border="0" src="../imagenes/SAPI_Logo.png" width="62" height="58"></td>
    <td width="71%"><div class="h1bar" align="center">Servicio Aut&oacute;nomo de la Propiedad Intelectual</div>
      <center><b>
<div class="subtitulo" align="center">Sistema de B&uacute;squeda T&eacute;cnica de Patentes</div>
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
 
   <p align="left"><font face="Tahoma" size="2"><b>B&uacute;squeda por N&uacute;mero de Registro </b></font></p>

   <table border="1" width="95%" height="89">
    <tr>
      <td width="100%" height="19" class="celda1">
       Coloque el n&uacute;mero de registro del documento que desea buscar: (A999999)
      </td>
    </tr>
	 <tr>
    <td width="100%" height="16" class="celda2"><p>
		<form method="POST" action="lis_registro.php">
		&nbsp;Registro:&nbsp;&nbsp;<input type="text" name="registro" size="10">
		<input type="submit" value="Buscar" name="B1" class="boton_blue">&nbsp;&nbsp;
		<input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
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
