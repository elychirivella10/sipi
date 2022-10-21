<?php 
// Programa PHP. Busqueda de Lista de Resultados 
// (Listado_texto.php por Texto en el nombre de la patente)
// Realizado Por Ing. Karina Pérez
// Modificado por Ing. Rómulo Mendoza / Julio 2008 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
<html>
<head>

<link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css"></link>

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

// Realizando Consulta por texto
$valor1 = $_POST['texto'];
$valor1 = normaliza_texto($valor1);
$valor1 = quitar_blancos($valor1);
$modoconsulta = $_POST['modoconsulta'];

if(empty($valor1)) { echo "El campo esta vacio"; exit; }

$criterio="Criterio: T&iacute;tulo= ".$valor1; 

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
         $resultado=pg_exec("SELECT resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
			WHERE b.nombre LIKE '$valor1' 
			AND a.nro_derecho=b.nro_derecho 
			AND b.tipo_mp='P' 
			order by b.solicitud OFFSET $inicio LIMIT $cuanto ");
         $cantidad=pg_exec("SELECT * FROM stzderec WHERE nombre like '$valor1' AND tipo_mp='P'");       
	 $total=pg_numrows($cantidad);
       break;

     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
         $resultado=pg_exec("SELECT a.resumen,b.nro_derecho,b.solicitud,
                        b.Tipo_derecho as tipo_paten,b.Fecha_solic,b.tipo_mp,b.Nombre, b.Estatus,b.Registro,b.fecha_regis,b.Fecha_publi,b.Fecha_venc,b.Pais_resid,b.Poder,b.tramitante,
b.agente
                        FROM stppatee a, stzderec b 
			WHERE b.nombre LIKE '%$valor1%' 
			AND a.nro_derecho=b.nro_derecho 
			AND b.tipo_mp='P' 
			OFFSET $inicio LIMIT $cuanto ");
	 $cantidad=pg_exec("SELECT * FROM stzderec WHERE nombre like '%$valor1%' AND tipo_mp='P'");
	 $total=pg_numrows($cantidad);
       break;

     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
         $resultado=pg_exec("SELECT resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
			WHERE b.nombre LIKE '$valor1%' 
			AND a.nro_derecho=b.nro_derecho 
			AND b.tipo_mp='P' 
			OFFSET $inicio LIMIT $cuanto ");
	$cantidad=pg_exec("SELECT * FROM stzderec WHERE nombre like '$valor1%' AND tipo_mp='P'");	
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

<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
<tr><td>
<table width="100%" border="0" cellpadding="8" cellspacing="1">
<tr>
<td class="topbar" colspan="2">

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
      <font color="#ffffff" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/topenuevo2013.png" width="100%" height="52">
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
      <b><i><a href="http://www.sapi.gob.ve">Sapi</a></i></b> 
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://correo.sapi.gob.ve">Correo</a></i></b>
    </td>
    <td width="54%" class="subtitulo1">
		<MARQUEE><b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Impulsando el Software Libre como parte del Gobierno Electr&oacute;nico</i></b></MARQUEE>
    </td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class="der">
      <div align="right">
        <I><font size="-1"><b>SubSistema de B&uacute;squeda T&eacute;cnica de Patentes</b></font></I><br />
      </div>
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
<td valign="top" bgcolor="#ffffff">

    <p style="line-height: 100%">
      <font face="Tahoma" size="2"><u><b>Resultado de B&uacute;squeda</b></u></p>
       <b><font color="#00688b"><?php echo " $criterio "; ?></b></font>
      </font>
      <table border="1" width="100%" height="39">
        <tr>
          <td width="100%" height="16" bgcolor="#faf9de">
            <p style="line-height: 100%"><b><font face="Tahoma" size="2" color="#000000">Pulse
            en cualquiera de los n&uacute;meros de documentos siguientes para ver los
            detalles de la patente correspondiente</font></b></td>
        </tr>
      </table>
      <table border="1" width="100%" cellpadding="1" cellspacing="1" class="celda1">
        <tr>
          <td width="16%" align="center"><font face="Tahoma" size="2"><b>Documento</b></font></td>
          <td width="84%" align="center"><font face="Tahoma" size="2"><b>Titulo</b></font></td>
        </tr>
        <tr>

            <b><font face='Tahoma' size='2><p align='center'>
 		Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?>

		<?
            for($cont=0;$cont<$filas_resultado;$cont++) { 
               $sol=$registro['solicitud'];
		   echo "<td width='16%' class='celda2'>";
		   echo "<a href='detalle.php?num_sol=$sol'>";
		   echo $sol;
               echo "</a>";
		   echo "&nbsp;</td>";
	         echo "<td width='84%' class='celda2'>";
		   echo $registro['nombre'];
		   echo "<p></p>";
               echo "</td>";
        	   echo "</tr>";
               $registro = pg_fetch_array($resultado);
		}

	     ?>

<form method="POST" action="listado_texto.php">
<input type="hidden" name="texto" value="<?= $_POST['texto'] ?>">
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
         <input type="submit" name="atras" class="boton_blue" value="Previos <?= min($inicio, $cuanto) ?>" />
<?
}
else
{
   //espacio  &nbsp;
}

if($total - $inicio > $cuanto)
{
?>
         <input type='submit' name='adelante' class="boton_blue" value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
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
