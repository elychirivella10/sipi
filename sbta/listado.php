<?php 
// Programa PHP. Busqueda de Lista de Resultados 
// (Listado.php por Numero de solicitud)
// Realizado Por Ing. Karina Pérez
// Modificado por Ing. Rómulo Mendoza / Julio 2008 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
<html>
<head>
<link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>

<style type="text/css">
</style>
<link rel="shortcut icon" href="LOGOS/shortcut_icon_phplm.png"></link>
<title>SIPI - Sistema de Informaci&oacute;n de Propiedad Intelectual</title>

<?php include ("libjs/layersmenu-browser_detection.js"); ?>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu-library.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layerstreemenu-cookies.js"></script>

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$usuario = $_SESSION['usuario_login'];
$usuario = trim($usuario);

$fecha   = trim(fechahoy());
$subtitulo = "B&uacute;squeda T&eacute;cnica de Patentes";

include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");
$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();
?>

<?
// Programa PHP. Busqueda de Lita de Resultados (Listado.php por Numero de Solicitud)
//Conexion con la base de datos SAPI
$sql = new mod_db();
//Verificando conexion
$sql->connection();

// Incorporamos la función para normalizar los datos
include "inc/NormalizaParametros.inc";

// Realizando Consulta por numero de solicitud
//$valor1 = $_POST["num_sol"];
$valor1 = $_POST["vsol1"]."-".$_POST["vsol2"];
$valor1 = normaliza_solicitud($valor1);

$criterio="Criterio: Solicitud= ".$valor1; 

//$resultado=pg_exec("SELECT * FROM stppatee WHERE solicitud='$valor1' and registro!=''");
//$resultado=pg_exec("SELECT * FROM stppatee WHERE solicitud='$valor1'");
 $resultado=pg_exec("SELECT  resumen,b.nro_derecho,solicitud,
                        Tipo_derecho as tipo_paten,Fecha_solic,Tipo_mp,Nombre,Estatus,Registro,
                        Fecha_regis,Fecha_publi,Fecha_venc,Pais_resid,Poder,Tramitante,b.agente
                        FROM stppatee a, stzderec b 
                        WHERE a.nro_derecho=b.nro_derecho
		        AND tipo_mp='P' 
		        AND b.solicitud= '$valor1' and b.solicitud!=''");

if (!$resultado) { echo "<b>Error de busqueda</b>"; exit; }
    $filas_resultado=pg_numrows($resultado); 

if ($filas_resultado==0) { //echo "No se encontro ningun registro\n"; 
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
        <img src="../imagenes/topenuevo2013_02.png" width="100%" height="52"> 
        <!--  <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
      <b><i><a href="http://www.bicentenariobu.com" target="blank">Banco Bicentenario</a></i></b>
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
  //$mid->printFooter(); 
  $smarty->display('pie_pag5.tpl');   
  exit();
 ?>
 
<?php
} else {
  $registro = pg_fetch_array($resultado);
?>
</head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#aa0000">
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
      <font color="#ffffff" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/topenuevo2013_02.png" width="100%" height="52"> 
        <!--  <img src="../imagenes/topesapiplano_2014.png" width="100%" height="200"> -->
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
        <font face="Tahoma" size="3"><u><b>RESULTADO DE BUSQUEDA</b></u></p>
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
      <!--<table border="1" width="100%" bgcolor="#ffe2b1">-->
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
//$mid->printFooter();
$smarty->display('pie_pag5.tpl');   
exit();
?>
</body>
<?
  }
?>
</html>
