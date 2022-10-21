<?php 
// Programa PHP. Busqueda de Lista de Resultados
//(listado_locar.php por Numero de Clasificacion locarno de las patentes)
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
include ("inc/constantes.inc");
$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

</head>

<?
//Conexion con la base de datos SAPI
require ("inc/NormalizaParametros.inc");
//Conexion con la base de datos SAPI
$sql       = new mod_db();
//Verificando conexion
$sql->connection();

// Incorporamos la función para normalizar los datos
//include "inc/NormalizaParametros.inc";

// Realizando Consulta por Clasificación
$valor1 = $_POST['locarno'];
$valor1 = normaliza_texto($valor1);
$modoconsulta = $_POST['modoconsulta'];

if(empty($valor1)) { echo "El campo esta vacio"; exit; }

$criterio="Criterio: Locarno= ".$valor1; 

//Paginación
if(strlen($_POST['adelante']) > 0)
  $adelante = "1";
if(strlen($_POST['atras']) > 0)
  $atras = "1";
$inicio = $_POST['inicio'];
$cuanto = $_POST['cuanto'];
$total = $_POST['total'];

if(empty($inicio) || ! is_numeric($inicio) || ($inicio < 0))
  $inicio = 0;

if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 5) || ($cuanto > 100))
  $cuanto = 10;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['valor1'] = $valor1;
$hiddenvars['inicio'] = $inicio;
$hiddenvars['cuanto'] = $cuanto;
$hiddenvars['total'] = $total;
$hiddenvars['modoconsulta'] = $modoconsulta;

//Opciones de busqueda por texto
  switch($modoconsulta)
   {
     case BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
	$resultado=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
			FROM stplocad, stzderec 
			WHERE stplocad.clasi_locarno = '$valor1' 
			AND stzderec.nro_derecho=stplocad.nro_derecho
		        AND stzderec.tipo_mp='P' OFFSET $inicio LIMIT $cuanto");
	 $cantidad=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
			FROM stplocad, stzderec 
			WHERE stplocad.clasi_locarno = '$valor1' 
			AND stzderec.nro_derecho=stplocad.nro_derecho
		        AND stzderec.tipo_mp='P' ");
	 $total=pg_numrows($cantidad);
       break;

     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
	 $resultado=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
			FROM stplocad, stzderec 
			WHERE stplocad.clasi_locarno like '%$valor1%' 
			AND stzderec.nro_derecho=stplocad.nro_derecho
		        AND stzderec.tipo_mp='P' OFFSET $inicio LIMIT $cuanto");
	 $cantidad=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
			FROM stplocad, stzderec 
			WHERE stplocad.clasi_locarno like '%$valor1%' 
			AND stzderec.nro_derecho=stplocad.nro_derecho
		        AND stzderec.tipo_mp='P'");
	 $total=pg_numrows($cantidad);
       break;

     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
	 $resultado=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
			FROM stplocad, stzderec 
			WHERE stplocad.clasi_locarno like '$valor1%' 
			AND stzderec.nro_derecho=stplocad.nro_derecho
		        AND stzderec.tipo_mp='P' OFFSET $inicio LIMIT $cuanto ");
	 $cantidad=pg_exec("SELECT *, stzderec.solicitud, stzderec.nombre 
			FROM stplocad, stzderec 
			WHERE stplocad.clasi_locarno like '$valor1%' 
			AND stzderec.nro_derecho=stplocad.nro_derecho
		        AND stzderec.tipo_mp='P' ");
	 $total=pg_numrows($cantidad);
       break;
   }

if (!$resultado) { echo "<b>Error de busqueda</b>"; exit; }
    $filas_resultado=pg_numrows($resultado); 
     	  
if ($filas_resultado==0) { echo "No se encontro ningun registro\n"; exit; } else {
   
   $registro = pg_fetch_array($resultado);
}
?>

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
      </table>
      <table border="1" width="100%" bgcolor="#669ec4">
        <tr>
          <td width="18%" align="center"><font face="Tahoma" size="2"><b>Documento</b></font></td>
          <td width="82%" align="center"><font face="Tahoma" size="2"><b>T&iacute;tulo</b></font></td>
        </tr>
        <tr>

            <b><font face='Tahoma' size='2><p align='center'>
 		Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?>

		<?
            for($cont=0;$cont<$filas_resultado;$cont++) { 
               $sol=$registro['solicitud'];
		   echo "<td width='18%'<font face='Tahoma' size='2'> <b>";
		   echo "<a href='detalle.php?num_sol=$sol'>";
		   echo $sol;
               echo "</a>";
		   echo "&nbsp;</td>";
	         echo "<td width='82%'<font face='Tahoma' size='2'>  <b>";
		   echo $registro['nombre'];
		   echo "<p></p>";
               echo "</td>";
        	   echo "</tr>";
               $registro = pg_fetch_array($resultado);
		}

	     ?>

<form method="POST" action="listado_locar.php">
<input type="hidden" name="locarno" value="<?= $_POST['locarno'] ?>">
<input type="hidden" name="adelante">
<input type="hidden" name="atras">

<?
foreach($hiddenvars as $var => $val)
{
?>
      <input type="hidden" name="<?= $var ?>" value="<?= $val ?>" />
<?
}
?>

<?
if($inicio > 0)
{
?>
         <input type="submit" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
<?
}
else
{
   //espacio  &nbsp;
}

if($total - $inicio > $cuanto)
{
?>
         <input type='submit' name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
<?
}
else
{
	//espacio    &nbsp;
}

?>

</td>
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
//  }
?>
</html>
