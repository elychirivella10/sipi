<?php 
// Programa PHP. Busqueda de Lista de Resultados de Consulta Avanzada
// (Lis_compleja.php por Consulta Avanzada)
// Realizado Por Ing. Romulo Mendoza Julio 2008 
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
//include ("inc/conexion.inc");
include ("inc/constantes.inc");
include ("lis_funcion.php");
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

</head>

<?php
//Conexion con la base de datos SAPI
require ("inc/NormalizaParametros.inc");
//$conexion = conectar_db();
$sql       = new mod_db();

//Verificando conexion
$sql->connection();

//Comparacion de conexion
//if (!$conexion) {
//   echo("Error al intentar abrir la base de datos SAPI."); exit(); }

// Incorporamos la funci�n para normalizar los datos
//include "inc/NormalizaParametros.inc";

// Realizando Consulta por Busqueda Avanzada
$opcion1 = $_POST["opcion1"];
$opcion1 = normaliza_texto($opcion1);
$opcion2 = $_POST["opcion2"];
$opcion2 = normaliza_texto($opcion2);
$opcion3 = $_POST["opcion3"];
$opcion3 = normaliza_texto($opcion3);
$opcion4 = $_POST["opcion4"];
$opcion4 = normaliza_texto($opcion4);
$opcion5 = $_POST["opcion5"];
$opcion5 = normaliza_texto($opcion5);
$opcion6 = $_POST["opcion6"];
$opcion6 = normaliza_texto($opcion6);
$opcion7 = $_POST["opcion7"];
$opcion7 = normaliza_texto($opcion7);
$opcion8 = $_POST["opcion8"];
$opcion8 = normaliza_texto($opcion8);
$opcion9 = $_POST["opcion9"];
$opcion9 = normaliza_texto($opcion9);

//$opcion4 = normaliza_solicitud($opcion4);

$modocon1= $_POST["modocon1"];
$modocon2= $_POST["modocon2"];
$modocon3= $_POST["modocon3"];
$modocon4= $_POST["modocon4"];
$modocon5= $_POST["modocon5"];
$modocon6= $_POST["modocon6"];
$modocon7= $_POST["modocon7"];
$modocon8= $_POST["modocon8"];
$modocon9= $_POST["modocon9"];
$modo1   = $_POST["modo1"];
$modo2   = $_POST["modo2"];
$modo3   = $_POST["modo3"];
$modo4   = $_POST["modo4"];
$modo5   = $_POST["modo5"];
$modo6   = $_POST["modo6"];
$modo7   = $_POST["modo7"];
$modo8   = $_POST["modo8"];
$modo9   = $_POST["modo9"];

//Paginaci�n
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

$hiddenvars['opcion1'] = $opcion1;
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

//pg_exec("CREATE TABLE consulta (solicitud char(11))");
//pg_exec("CREATE TABLE consulta1 (solicitud char(11), cant char(3))");
//pg_exec("CREATE TABLE consulta2 (solicitud char(11), cant char(3))");

$ind=0;
$criterio= "Criterio= ";

if(!empty($opcion1)) {
  $ind=$ind+1;
  $criterio=$criterio.$modo1.": ".$opcion1." "; 
  $resulopc1 = sqlcompara($modo1,$modocon1,$opcion1);  
}  

if(!empty($opcion2)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo2.": ".$opcion2." "; 
  $resulopc1 = sqlcompara($modo2,$modocon2,$opcion2);
}

if(!empty($opcion3)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo3.": ".$opcion3." "; 
  $resulopc1 = sqlcompara($modo3,$modocon3,$opcion3);
}

if(!empty($opcion4)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo4.": ".$opcion4." "; 
  $resulopc1 = sqlcompara($modo4,$modocon4,$opcion4);
}

if(!empty($opcion5)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo5.": ".$opcion5." "; 
  $resulopc1 = sqlcompara($modo5,$modocon5,$opcion5);
}

if(!empty($opcion6)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo6.": ".$opcion6." "; 
  $resulopc1 = sqlcompara($modo6,$modocon6,$opcion6);
}

if(!empty($opcion7)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo7.": ".$opcion7." "; 
  $resulopc1 = sqlcompara($modo7,$modocon7,$opcion7);
}

if(!empty($opcion8)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo8.": ".$opcion8." "; 
  $resulopc1 = sqlcompara($modo8,$modocon8,$opcion8);
}

if(!empty($opcion9)) {
  $ind=$ind+1;
  $criterio=$criterio.", ".$modo9.": ".$opcion9." "; 
  $resulopc1 = sqlcompara($modo9,$modocon9,$opcion9);
}

// Seleccionar resultado de los diferentes select
$cantidad=pg_exec("INSERT INTO consulta1 SELECT solicitud,count(*)
			   FROM consulta GROUP BY solicitud ORDER BY solicitud "); 

$respuesta =pg_exec("INSERT INTO consulta2 SELECT solicitud FROM consulta1 WHERE cant='$ind'");

$resultado=pg_exec("SELECT consulta2.solicitud, stzderec.nombre FROM consulta2, stzderec WHERE consulta2.solicitud=stzderec.solicitud AND stzderec.tipo_mp='P' OFFSET $inicio LIMIT $cuanto");
$cantidad=pg_exec("SELECT consulta2.solicitud, stzderec.nombre FROM consulta2, stzderec WHERE consulta2.solicitud=stzderec.solicitud AND stzderec.tipo_mp='P'");
$total=pg_numrows($cantidad);

if (!$resultado) { echo "<b>Error de busqueda</b>"; exit; }
    $filas_resultado=pg_numrows($resultado); 
     	  
//if ($filas_resultado==0) { echo "No se encontro ningun registro\n"; exit; } 
//else {$registro = pg_fetch_array($resultado); }

if ($filas_resultado==0) { // echo "No se encontro ningun registro\n";
?>
  <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
   <tr><td>
   <table width="100%" border="0" cellpadding="8" cellspacing="1">
   <tr>
   <td class="topbar" colspan="2">
   <table border="0" width="100%">
    <tr>
     <td width="14%"><img border="0" src="../imagenes/addusers.png" width="62" height="58"></td>
     <td width="71%"><div class="h1bar" align="center">Servicio Aut&oacute;nomo de la Propiedad Intelectual</div>
       <div class="subtitulo" align="center">Sistema de B&uacute;squeda T&eacute;cnica de Patentes</div>
     </td>
     <td width="15%"><b></b></td>
    </tr>
   </table>
   </td>
   </tr>
   <tr>
    <td width="20%" class="bar" valign="top" nowrap="nowrap">
     <center><br /></center>
     <br />
     Menu
     <?php
       $mid->setMenuStructureFile("layersmenu-vertical-1.txt");
       $mid->parseStructureForMenu("treemenu1");
       print $mid->newTreeMenu("treemenu1");
     ?>
     <br /><br />
     <center></center>
     <br />
     <center></center>
     <br />
     <center></center>
    </td>
    <td valign="top" bgcolor="#ffffff">
     <p style="line-height: 100%"><font face="Tahoma" size="2">
       <u><b>Resultado de B&uacute;squeda:</b></u></p>
          <b><font color="#00688b"><?php echo " $criterio "; ?></b></font></p> 
       </font>
       <table border="1" width="100%" height="38">
         <tr>
           <td width="100%" height="16" bgcolor="#669999">
             <p style="line-height: 100%">
               <b><font face="Tahoma" size="2" color="#FFFFFF">
                 No se encontro informaci&oacute;n alguna ...!!!
               </font></b>
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
  <?php
    exit; } 
    else { $registro = pg_fetch_array($resultado); }
  ?>

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
       <div class="subtitulo" align="center">Sistema de B&uacute;squeda T&eacute;cnica de Patentes</div>
    </td>
    <td width="15%"><b>
    <!-- <img border="0" src="logo-mpc-trans.gif" width="66" height="34" align="right"> -->
</b>
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

    <p style="line-height: 100%"><font face="Tahoma" size="2">
      <u><b>Resultado de B&uacute;squeda:</b></u></p>
         <b><font color="#00688b"><?php echo " $criterio "; ?></b></font> 
      </font>
      <table border="1" width="100%" height="38">
        <tr>
          <td width="100%" height="16" bgcolor="#faf9de">
            <p style="line-height: 100%"><b><font face="Tahoma" size="2" color="#000000">Pulse
            en cualquiera de los n&uacute;meros de documentos siguientes para ver los
            detalles de la patente correspondiente</font></b></td>
        </tr>
      </table>
      <table border="0" width="100%" class="celda1">
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

<form method="POST" action="lis_compleja.php">
<input type="hidden" name="opcion1" value="<?= $_POST["opcion1"]; ?>">
<input type="hidden" name="modocon1" value="<?= $_POST["modocon1"]; ?>">
<input type="hidden" name="modo1" value="<?= $_POST["modo1"]; ?>">
<input type="hidden" name="opcion2" value="<?= $_POST["opcion2"]; ?>">
<input type="hidden" name="modocon2" value="<?= $_POST["modocon2"]; ?>">
<input type="hidden" name="modo2" value="<?= $_POST["modo2"]; ?>">
<input type="hidden" name="opcion3" value="<?= $_POST["opcion3"]; ?>">
<input type="hidden" name="modocon3" value="<?= $_POST["modocon3"]; ?>">
<input type="hidden" name="modo3" value="<?= $_POST["modo3"]; ?>">
<input type="hidden" name="opcion4" value="<?= $_POST["opcion4"]; ?>">
<input type="hidden" name="modocon4" value="<?= $_POST["modocon4"]; ?>">
<input type="hidden" name="modo4" value="<?= $_POST["modo4"]; ?>">
<input type="hidden" name="opcion5" value="<?= $_POST["opcion5"]; ?>">
<input type="hidden" name="modocon5" value="<?= $_POST["modocon5"]; ?>">
<input type="hidden" name="modo5" value="<?= $_POST["modo5"]; ?>">
<input type="hidden" name="opcion6" value="<?= $_POST["opcion6"]; ?>">
<input type="hidden" name="modocon6" value="<?= $_POST["modocon6"]; ?>">
<input type="hidden" name="modo6" value="<?= $_POST["modo6"]; ?>">
<input type="hidden" name="opcion7" value="<?= $_POST["opcion7"]; ?>">
<input type="hidden" name="modocon7" value="<?= $_POST["modocon7"]; ?>">
<input type="hidden" name="modo7" value="<?= $_POST["modo7"]; ?>">
<input type="hidden" name="opcion8" value="<?= $_POST["opcion8"]; ?>">
<input type="hidden" name="modocon8" value="<?= $_POST["modocon8"]; ?>">
<input type="hidden" name="modo8" value="<?= $_POST["modo8"]; ?>">
<input type="hidden" name="opcion9" value="<?= $_POST["opcion9"]; ?>">
<input type="hidden" name="modocon9" value="<?= $_POST["modocon9"]; ?>">
<input type="hidden" name="modo9" value="<?= $_POST["modo9"]; ?>">

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
         <input type="submit" class='boton_blue' name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
<?
}
else
{
   //espacio  &nbsp;
}

if($total - $inicio > $cuanto)
{
?>
         <input type='submit' class='boton_blue' name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
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