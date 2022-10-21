<?php 
// Programa PHP. Pantalla de Búsqueda por Numero de Prioridad
// (bprioridad.php por Numero de Prioridad de las patentes) 
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
include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");
include ("inc/constantes.inc");
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
 
	<p align="left"><font face="Tahoma" size="2"><b>B&uacute;squeda por Tramitante o Agente </b></font></p>

   <table border="1" width="95%" height="89">
    <tr>
      <td width="100%" height="19" class="celda1">
       Por Nombre de Tramitante 
      </td>
    </tr>
    <!--<tr>
     <td width="100%" height="19" bgcolor="#669999">
     <p style="line-height: 100%"><b><font face="Tahoma" size="2" color="#FFFFFF">Por Nombre de Tramitante</font></b></td>
    </tr>-->
	 <tr>
    <td width="100%" height="16" class="celda2">
      Coloque el Nombre del Tramitante que desea buscar 
	    <form method="POST" action="lis_tramitante.php">
	 	 <p style="line-height: 100%"> 
          &nbsp;<select name="modoconsulta">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contengan la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       <input type="text" name="tramitante">
	       <input type="hidden" name="inicio">
	       <input type="hidden" name="cuanto">
	       <input type="hidden" name="total">
	       <input type="hidden" name="adelante">
	       <input type="hidden" name="atras">
	       <input type="submit" value="Buscar" name="B1" class="boton_blue">
	       <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
		</form>
     </td>
     </tr>
    </table>
   <table border="1" width="95%" height="89">
    <tr>
     <td width="100%" height="19" class="celda1">
       Por Nombre de Agente de la Propiedad Industrial
     </td>
    </tr>
	 <tr>
    <td width="100%" height="16" class="celda2">
      Coloque el Nombre del Agente que desea buscar
	    <form method="POST" action="lis_agente.php">
	 	 <p style="line-height: 100%"> 
             &nbsp;<select name="modoconsulta">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contengan la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       <input type="text" name="agente">
	       <input type="hidden" name="inicio">
	       <input type="hidden" name="cuanto">
	       <input type="hidden" name="total">
	       <input type="hidden" name="adelante">
	       <input type="hidden" name="atras">
	       <input type="submit" value="Buscar" name="B1" class="boton_blue">
	       <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
		</form>
     </td>
     </tr>
    </table>
   <table border="1" width="95%" height="89">
    <tr>
     <td width="100%" height="19" class="celda1">
       Por C&oacute;digo de Agente de la Propiedad Industrial</td>
    </tr>
	 <tr>
    <td width="100%" height="16" class="celda2">
      Coloque el C&oacute;digo del Agente que desea buscar
	    <form method="POST" action="lis_nagente.php">
	 	 <p style="line-height: 100%"> 
             &nbsp;<select name="modoconsulta">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contengan la porci&oacute;n de n&uacute;mero</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea el n&uacute;mero exacto a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       <input type="text" name="agente">
	       <input type="hidden" name="inicio">
	       <input type="hidden" name="cuanto">
	       <input type="hidden" name="total">
	       <input type="hidden" name="adelante">
	       <input type="hidden" name="atras">
	       <input type="submit" value="Buscar" name="B1" class="boton_blue">
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
