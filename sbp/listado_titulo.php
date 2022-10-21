<?php 
// Programa PHP. Busqueda de Lista de Resultados de Consulta Avanzada
// (Lis_compleja.php por Consulta Avanzada)
// Realizado Por Ing. Romulo Mendoza Julio 2008 
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <link rel="stylesheet" href="layersmenu.css" type="text/css">
 <link rel="shortcut icon" href="LOGOS/shortcut_icon_phplm.png">
 <title>SIPI - Sistema de Informaci&oacute;n de Propiedad Intelectual</title>

<?php include ("libjs/layersmenu-browser_detection.js"); ?>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu-library.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layerstreemenu-cookies.js"></script>

<?php
include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");
include ("inc/constantes.inc");
include ("lis_funcion.php");
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$usuario = $_SESSION['usuario_login'];
$usuario = trim($usuario);

$fecha   = trim(fechahoy());
$subtitulo = "B&uacute;squeda T&eacute;cnica de Patentes";

$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

</head>

<?php
//Conexion con la base de datos 
require ("inc/NormalizaParametros.inc");
$sql = new mod_db();

//Verificando conexion
$sql->connection();

// Realizando Consulta por Busqueda Avanzada
$valor1 = $_POST['texto'];
$valor1 = normaliza_texto($valor1);
$valor1 = quitar_blancos($valor1);
$modoconsulta = $_POST['modoconsulta'];
$modover1 = $_POST["modover1"];

if(empty($valor1)) { 
 // echo "El campo esta vacio"; exit; 
?>

<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
 <tr><td>
 <table width="100%" border="0" cellpadding="8" cellspacing="1">
  <tr>
   <td class="topbar" colspan="2">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="2">
      </div>
    </td>
  </tr> 
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
     <td width="100%" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/topenuevo2014.jpg" width="100%" height="52"> 
        <!-- <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
      <b><i><a href="http://www.banfoandes.com.ve" target="blank">Banco Bicentenario</a></i></b>
    </td>
    <td width="40%" class="subtitulo1">
		<b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor - SIPI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></b>
    </td>
  </tr>
</table>

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
     <font face="Tahoma" size="3"><u><b>RESULTADO DE BUSQUEDA:</b></u></p>
        <b><font color="#00688b"><?php echo " $criterio "; ?></b></font>
       </font>

       <table border="1" width="100%" height="38">
         <tr>
           <td width="100%" height="16" bgcolor="#669999">
             <p style="line-height: 100%">
               <b><font face="Tahoma" size="2" color="#FFFFFF">
                 AVISO: No se encontro informaci&oacute;n alguna ...!!!
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
   //$mid->printFooter(); 
   $smarty->display('pie_pag.tpl');   
   exit();
}
  ?>
 
<?php

$criterio="Criterio: Titulo= ".$valor1; 

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
  
if(empty($cuanto) || ! is_numeric($cuanto) || ($cuanto < 0))
  $cuanto = $modover1;

if(!empty($adelante))
  $inicio += $cuanto;

if(!empty($atras))
  $inicio = max($inicio - $cuanto, 0);

$hiddenvars['opcion1'] = $opcion1;
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
			ORDER BY b.solicitud OFFSET $inicio LIMIT $cuanto ");
         $cantidad = pg_exec("SELECT * FROM stzderec WHERE nombre like '$valor1' AND tipo_mp='P'");       
	      $total = pg_numrows($cantidad);
       break;

     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
         $resultado = pg_exec("SELECT a.resumen,b.nro_derecho,b.solicitud,
                        b.Tipo_derecho as tipo_paten,b.Fecha_solic,b.tipo_mp,b.Nombre, b.Estatus,b.Registro,b.fecha_regis,b.Fecha_publi,b.Fecha_venc,b.Pais_resid,b.Poder,b.tramitante,
b.agente
                        FROM stppatee a, stzderec b 
			WHERE b.nombre LIKE '%$valor1%' 
			AND a.nro_derecho=b.nro_derecho 
			AND b.tipo_mp='P' ORDER BY b.solicitud OFFSET $inicio LIMIT $cuanto ");
	      $cantidad = pg_exec("SELECT * FROM stzderec WHERE nombre like '%$valor1%' AND tipo_mp='P'");
	      $total = pg_numrows($cantidad);
       break;

     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
         $resultado = pg_exec("SELECT resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
			WHERE b.nombre LIKE '$valor1%' 
			AND a.nro_derecho=b.nro_derecho 
			AND b.tipo_mp='P' ORDER BY b.solicitud OFFSET $inicio LIMIT $cuanto ");
	      $cantidad = pg_exec("SELECT * FROM stzderec WHERE nombre like '$valor1%' AND tipo_mp='P'");	
	      $total = pg_numrows($cantidad);
      break;
   }

if (!$resultado) { echo "<b>Error de busqueda</b>"; exit; }
$filas_resultado = pg_numrows($resultado); 
     	  
if ($filas_resultado==0) { // echo "No se encontro ningun registro\n";
?>

<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
 <tr><td>
 <table width="100%" border="0" cellpadding="8" cellspacing="1">
  <tr>
   <td class="topbar" colspan="2">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="2">
      </div>
    </td>
  </tr> 
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
     <td width="100%" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/topenuevo2014.jpg" width="100%" height="52"> 
        <!-- <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
      <b><i><a href="http://www.banfoandes.com.ve" target="blank">Banco Bicentenario</a></i></b>
    </td>
    <td width="40%" class="subtitulo1">
		<b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor - SIPI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></b>
    </td>
  </tr>
</table>

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
     <font face="Tahoma" size="3"><u><b>RESULTADO DE BUSQUEDA:</b></u></p>
        <b><font color="#00688b"><?php echo " $criterio "; ?></b></font>
       </font>

       <table border="1" width="100%" height="38">
         <tr>
           <td width="100%" height="16" bgcolor="#669999">
             <p style="line-height: 100%">
               <b><font face="Tahoma" size="2" color="#FFFFFF">
                 AVISO: No se encontro informaci&oacute;n alguna ...!!!
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

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="100%" height="2">
      </div>
    </td>
  </tr> 
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
     <td width="100" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/topenuevo2014.jpg" width="100%" height="52"> 
        <!-- <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
      <b><i><a href="http://www.banfoandes.com.ve" target="blank">Banco Bicentenario</a></i></b>
    </td>
    <td width="40%" class="subtitulo1">
		<b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor - SIPI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></b>
    </td>
  </tr>
</table>

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

    <font face="Tahoma" size="3"><u><b>RESULTADO DE BUSQUEDA:</b></u></p>
         <b><font color="#00688b"><?php echo " $criterio "; ?></b></font> 
      </font>
      <table border="1" width="100%" height="38">
        <tr>
          <td width="100%" height="16" bgcolor="#faf9de">
            <b><font face="Tahoma" size="2" color="#000000">Pulse
            en cualquiera de los n&uacute;meros de documentos siguientes para ver los
            detalles de la patente correspondiente</font></b></td>
        </tr>
      </table>

<b><font class='navega1' >Mostrando <?= $inicio + 1 ?>-<?= min($inicio + $cuanto, $total) ?> de <?= $total?> Solicitudes Encontradas </font></b>&nbsp;
<? echo "<a href='listado_index.php?opcion=1&valor1=$valor1&modoconsulta=$modoconsulta&criterio=$criterio'>"; ?><input type="button" class="boton_blue" name="Listado" value="Listado " /></a>&nbsp;
<? echo "<a href='index_listado_xls.php?opcion=1&valor1=$valor1&modoconsulta=$modoconsulta&criterio=$criterio'>"; ?><input type="button" class="boton_blue" name="exportar" value="Exportar Excel" /></a>&nbsp;


<table border="0" width="100%" class="celda1">

  <tr>
    <td width="12%" class='celda3' ><b>Solicitud</b></td>
    <td width="88%" class='celda3' ><b>T&iacute;tulo</b></td>
  </tr>

  <?php    

   for($cont=0;$cont<$filas_resultado;$cont++) 
     { 
      echo "<tr>";
      $sol=$registro['solicitud'];
      echo "<td width='12%' class='celda2'><a href='detalle.php?num_sol=$sol'><font color='#00688b'>$sol</font></a></td>";
      $nombre=$registro['nombre'];
      echo "<td width='88%' class='celda2' >$nombre</td>";
      echo "</tr>";
      $registro = pg_fetch_array($resultado);
     }
    ?>

</table>

<form method="POST" action="listado_titulo.php">
<input type="hidden" name="texto" value="<?= $_POST['texto'] ?>"> 
<input type="hidden" name="modover1" value="<?= $_POST['modover1']; ?>"> 
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

<? echo "<a href='listado_index.php?opcion=1&valor1=$valor1&modoconsulta=$modoconsulta&criterio=$criterio'>"; ?><input type="button" class="boton_blue" name="Listado" value="Listado " /></a>&nbsp;
<? echo "<a href='index_listado_xls.php?opcion=1&valor1=$valor1&modoconsulta=$modoconsulta&criterio=$criterio'>"; ?><input type="button" class="boton_blue" name="exportar" value="Exportar Excel" /></a>&nbsp;

<?
if($inicio > 0)
{
?>
         <input type="submit"  class="boton_blue" name="atras" value="Previos <?= min($inicio, $cuanto) ?>" />
<?
}
else
{
   //espacio  &nbsp;
}

if($total - $inicio > $cuanto)
{
?>
         <input type='submit'  class="boton_blue" name='adelante' value='Siguientes <?= min(($total - ($inicio + $cuanto)), $cuanto)?>' />
<?
}
else
{
	//espacio    &nbsp;
}

?>

</tabla>  

    </td>
</td>
</tr>
</table>
</td></tr>
</table>

<?php
  $smarty->display('pie_pag.tpl');   
?>

</body>
</html>
