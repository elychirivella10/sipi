<?php 
// Programa PHP. Busqueda de Lista de Resultados 
// (Lis_registro.php por Numero de registro)
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

<?
//Conexion con la base de datos SAPI
$sql       = new mod_db();
//Verificando conexion
$sql->connection();

// Incorporamos la función para normalizar los datos
include "inc/NormalizaParametros.inc";

// Realizando Consulta por numero de solicitud
$valor1 = $_POST["registro"];
$valor1 = normaliza_solicitud($valor1);

$criterio="Criterio: Registro= ".$valor1; 

$resultado=pg_exec("SELECT  solicitud, nombre
                        FROM  stzderec  
                        WHERE tipo_mp='P' 
		        AND registro= '$valor1' and registro!=''");

if (!$resultado) { echo "<b>Error de busqueda</b>"; exit; }
    $filas_resultado=pg_numrows($resultado); 

if ($filas_resultado==0) { echo "No se encontro ningun registro\n"; exit; } else {
   
$registro = pg_fetch_array($resultado);

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
    <!--<td width="15%"><b><img border="0" src="logo-mpc-trans.gif" width="66" height="34" align="right">
</b>
    </td>-->
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
<td valign="top" bgcolor="#ffffff">

      <p style="line-height: 100%">
      <font face="Tahoma" size="2"><u><b>Resultado de B&uacute;squeda</b></u></p>
        <b><font color="#CC0000"><?php echo " $criterio "; ?></b></font>      
      </font>
      <table border="1" width="100%" height="39">
        <tr>
          <td width="100%" height="16" bgcolor="#669999">
            <p style="line-height: 100%"><b><font face="Tahoma" size="2" color="#FFFFFF">Pulse
            en cualquiera de los n&uacute;meros de documentos siguientes para ver los
            detalles de la patente correspondiente</font></b></td>
        </tr>
        <tr>
          <td width="100%" height="11">
            <p style="line-height: 100%"></p>
          </td>
        </tr>
      </table>
      <table border="1" width="100%" bgcolor="#669ec4">
        <tr>
          <td width="18%" align="center"><font face="Tahoma" size="2"><b>Documento</b></font></td>
          <td width="82%" align="center"><font face="Tahoma" size="2"><b>T&iacute;tulo</b></font></td>
        </tr>

        <tr>
          <td width="18%"<font face="Tahoma" size="2"> <b> 
			<?
				 for($cont=0;$cont<$filas_resultado;$cont++) { 
			  
             $sol=$registro['solicitud'];
				 echo "<a href='detalle.php?num_sol=$sol'>";
				 echo $sol;
             echo "</a>";
		      }
			?>
			&nbsp;</td>
          <td width="82%"<font face="Tahoma" size="2">  <b>
	      <?
				 for($cont=0;$cont<$filas_resultado;$cont++) { 
			    echo $registro['nombre'];
		       $registro = pg_fetch_array($resultado);
			    }
			?>
			&nbsp;</td>
        </tr>
      </table>
    </td>
       
</td>
</tr>
</table>
</td></tr>
</table>

<?php
$mid->printFooter();
?>

</body>
<?
  }
?>
</html>
