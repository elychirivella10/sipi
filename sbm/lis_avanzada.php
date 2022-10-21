<?php 
// Programa PHP. Busqueda de Lista de Resultados de Consulta Avanzada
// (Lis_avanzada.php por Consulta Avanzada)
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
//include ("inc/conexion.inc");
include ("inc/constantes.inc");
$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

</head>

<?
//Conexion con la base de datos SAPI
require ("inc/NormalizaParametros.inc");

$sql       = new mod_db();
//Verificando conexion
$sql->connection();


// Realizando Consulta por Busqueda Avanzada
$valort = $_POST["titulo"];
$valort = normaliza_texto($valort);
$valorr = $_POST["resumen"];
$valorr = normaliza_texto($valorr);
$valorp = $_POST["prioridad"];
$valorp = normaliza_texto($valorp);
$valorf = $_POST["fecha"];
$valorf = normaliza_solicitud($valorf);
$valori = $_POST["inventor"];
$valori = normaliza_texto($valori);
$valore = $_POST["empresa"];
$valore = normaliza_texto($valore);
$valorc = $_POST["clasificacion"];
$valorc = normaliza_texto($valorc);
$valorl = $_POST["locarno"];
$valorl = normaliza_texto($valorl);

//if(empty($valort)) { echo "El campo esta vacio"; exit; }

$criterio= "Criterio= ";

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

$hiddenvars['valort'] = $valort;
$hiddenvars['inicio'] = $inicio;
$hiddenvars['cuanto'] = $cuanto;
$hiddenvars['total'] = $total;


//Opciones de busqueda 
//Borrado de la tabla temporal
//pg_exec("drop table consulta");
//pg_exec("drop table consulta1");
//pg_exec("drop table consulta2");

//Creando tabla temporal
pg_exec("CREATE TEMPORARY TABLE consulta (solicitud char(11))");
pg_exec("CREATE TEMPORARY TABLE consulta1 (solicitud char(11), cant char(3))");
pg_exec("CREATE TEMPORARY TABLE consulta2 (solicitud char(11), cant char(3))");

$ind=0;

if(!empty($valort)) { 
  $resul_titulo =pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE nombre LIKE '%$valort%'");
  $ind=$ind+1;
  $criterio=$criterio."T&iacute;tulo: ".$valort." "; 
}

if(!empty($valorr)) {
  $resul_res =pg_exec("INSERT INTO consulta SELECT stpresud.solicitud
  			    FROM stpresud, stppatee WHERE stpresud.resumen like '%$valorr%' 
			    AND stpresud.solicitud=stppatee.solicitud ");
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Resumen: ".$valorr." "; }
  else { $criterio=$criterio."Resumen: ".$valorr." "; } 
} 

if(!empty($valorp)) { 
  $resul_pri =pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			    FROM stppatee, stppriod WHERE stppriod.prioridad='$valorp'
			    AND stppriod.solicitud = stppatee.solicitud"); 
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Prioridad: ".$valorp." "; }
  else { $criterio=$criterio."Prioridad: ".$valorp." "; } 
}

if(!empty($valorf)) { 
  $resul_fec =pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE fecha_publi like '$valorf' "); 
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Publicaci&oacute;n: ".$valorf." "; }
  else { $criterio=$criterio."Publicaci&oacute;n: ".$valorf." "; } 
}

if(!empty($valori)) { 
  $resul_inv =pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			    FROM stppatee, stpinved WHERE stpinved.nombre_inv like'%$valori%' 
			    AND stppatee.solicitud=stpinved.solicitud"); 
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Inventor: ".$valori." "; }
  else { $criterio=$criterio."Inventor: ".$valori." "; } 
}

if(!empty($valore)) { 
  $resul_emp =pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			    FROM stpottid, stztitur,stppatee WHERE stztitur.nombre like '%$valore%' 
			    AND stpottid.titular=stztitur.titular
			    AND stppatee.solicitud=stpottid.solicitud "); 
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Titular: ".$valore." "; }
  else { $criterio=$criterio."Titular: ".$valore." "; } 
}

if(!empty($valorc)) { 
  $resul_cla =pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			    FROM stppatee, stpclsfd  WHERE stpclsfd.clasificacion like '%$valorc%'
			    AND stpclsfd.solicitud = stppatee.solicitud "); 
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Clasificaci&oacute;n: ".$valorc." "; }
  else { $criterio=$criterio."Clasificaci&oacute;n: ".$valorc." "; } 
}

if(!empty($valorl)) { 
  $resul_loc =pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			    FROM stppatee, stplocad  WHERE stplocad.clasi_locarno like '%$valorl%'
			    AND stplocad.solicitud = stppatee.solicitud "); 
  $ind=$ind+1;
  if (strlen($criterio)>10) { $criterio=$criterio.", "."Locarno: ".$valorl." "; }
  else { $criterio=$criterio."Locarno: ".$valorl." "; } 
}

// Seleccionar resultado de los diferentes select
$cantidad=pg_exec("INSERT INTO consulta1 SELECT solicitud,count(*)
			   FROM consulta GROUP BY solicitud ORDER BY solicitud "); 

$respuesta =pg_exec("INSERT INTO consulta2 SELECT solicitud 
			   FROM consulta1 WHERE cant='$ind'");

$resultado=pg_exec("SELECT consulta2.solicitud, stppatee.nombre FROM consulta2, stppatee WHERE consulta2.solicitud=stppatee.solicitud OFFSET $inicio LIMIT $cuanto");
$cantidad=pg_exec("SELECT consulta2.solicitud, stppatee.nombre FROM consulta2, stppatee WHERE consulta2.solicitud=stppatee.solicitud ");
$total=pg_numrows($cantidad);


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
      <font face="Tahoma" size="2">
       <u><b>Resultado de B&uacute;squeda:</b></u></p>
       <b><font color="#CC0000"><?php echo " $criterio "; ?></b></font> 
       </font>
      <table border="1" width="100%" height="39">
        <tr>
          <td width="100%" height="16" bgcolor="#669999">
            <p style="line-height: 100%"><b><font face="Tahoma" size="2" color="#FFFFFF">Pulse
            en cualquiera de los n&uacute;meros de documentos siguientes para ver los
            detalles de la patente correspondiente</font></b></td>
        </tr>
        <!--<tr>
          <td width="100%" height="11">
            <p style="line-height: 100%"></p>
          </td>
        </tr>-->
      </table>
      <table border="1" width="100%" bgcolor="#669ec4">
        <tr>
          <td width="16%" align="center"><font face="Tahoma" size="2"><b>Documento</b></font></td>
          <td width="84%" align="center"><font face="Tahoma" size="2"><b>T&iacute;tulo</b></font></td>
        </tr>
        <tr>

            <b><font face='Tahoma' size='2><p align='center'>
 		Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?>

		<?
            for($cont=0;$cont<$filas_resultado;$cont++) { 
               $sol=$registro['solicitud'];
		   echo "<td width='16%'<font face='Tahoma' size='2'> <b>";
		   echo "<a href='detalle.php?num_sol=$sol'>";
		   echo $sol;
               echo "</a>";
		   echo "&nbsp;</td>";
	         echo "<td width='84%'<font face='Tahoma' size='2'>  <b>";
		   echo $registro['nombre'];
		   echo "<p></p>";
               echo "</td>";
        	   echo "</tr>";
               $registro = pg_fetch_array($resultado);
		}

	     ?>

<form method="POST" action="lis_avanzada.php">
<input type="hidden" name="titulo" value="<?= $_POST["titulo"]; ?>">
<input type="hidden" name="resumen" value="<?= $_POST["resumen"]; ?>">
<input type="hidden" name="prioridad" value="<?= $_POST["prioridad"]; ?>">
<input type="hidden" name="fecha" value="<?= $_POST["fecha"];?>">
<input type="hidden" name="inventor" value="<?= $_POST["inventor"]; ?>">
<input type="hidden" name="empresa" value="<?= $_POST["empresa"]; ?>">
<input type="hidden" name="clasificacion" value="<?= $_POST["clasificacion"]; ?>">
<input type="hidden" name="locarno" value="<?= $_POST["locarno"]; ?>">
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
