<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<script language=JavaScript>
function inicializa($valor)
{
 $valor.value = "";
}
</script>
<?php 
// Programa PHP. Pantalla de Búsqueda Avanzada
// (bcompleja.php por seleccion de campos de las patentes) 
// Realizado Por Ing. Rómulo Mendoza / Julio 2008

//Para trabajar con Operaciones de Bases de Datos
//include ("../z_includes.php");

 //Para trabajar con Operaciones de Bases de Datos
 include ("../setting.inc.php");
 //Para trabajar con Smarty 
 require ("$root_path/include.php");
 //LLamadas a funciones de Libreria 
 include ("$include_lib/library.php");
 // Cargar datos conexion y otras variables.
 require ("../aut_config.inc.php");

session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit();}

//Variables
$usuario = trim($_SESSION['usuario_login']);
//$usuario = trim($usuario);
$fecha   = trim(fechahoy());
$subtitulo = "B&uacute;squeda T&eacute;cnica de Patentes";

?>
<html>
<head>
 <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css"></link>
 <link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
 <link rel="shortcut icon" href="LOGOS/shortcut_icon_phplm.png"></link>
 <title>SIPI - Sistema de Informaci&oacute;n de Propiedad Intelectual</title>

<?php include ("libjs/layersmenu-browser_detection.js"); ?>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu-library.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layersmenu.js"></script>
<script language="JavaScript" type="text/javascript" src="libjs/layerstreemenu-cookies.js"></script>

<?php
include ("lib/template.inc.php");	// taken from PHPLib
include ("lib/layersmenu.inc.php");
include ("inc/constantes.inc");

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo',$subtitulo); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado3.tpl');

$mid = new LayersMenu();
$mid->setMenuStructureFile("layersmenu-horizontal-1.txt");
$mid->printHeader();

?>

</head>
<body>
<div align="center">

<table width="960px" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
<tr><td>
<table width="960px" border="0" cellpadding="8" cellspacing="1">
<tr>
<td class="topbar" colspan="2">

<!-- <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
        <img src="../imagenes/cintillo2015.png" width="100%" height="52">
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
    <td width="44%" class="subtitulo1">
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
  </table> -->

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
<!-- <td valign="top" bgcolor="#fffff8"> -->
<td valign="top" bgcolor="#F9F9F9">
 
	<p align="left"><font face="Tahoma" size="3"><b>B&uacute;squeda Combinada </b></font></p>

   <table border="1" width="100%" height="89">
    <tr>
      <td width="100%" height="19" class="Estilo5">
       Selecciones las Opciones que desea buscar 
      </td>
    </tr>
	 <tr>
    <td width="100%" height="16" class="celda2">
	    <form name="forbusqueda" method="POST" action="lis_compleja.php?vopc=1">
	 	 <!-- <p style="line-height: 100%"> -->
          &nbsp;<select name="modo1">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon1">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion1">
	       &nbsp;<input type="button" value="Limpiar" name="B1" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion1);" >
	       </p>
	       
          &nbsp;<select name="modo2">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon2">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion2">
	       &nbsp;<input type="button" value="Limpiar" name="B2" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion2);"></p>

          &nbsp;<select name="modo3">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon3">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion3">
	       &nbsp;<input type="button" value="Limpiar" name="B3" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion3);"></p>

          &nbsp;<select name="modo4">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon4">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion4">
	       &nbsp;<input type="button" value="Limpiar" name="B4" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion4);"></p>

          &nbsp;<select name="modo5">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon5">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion5">
	       &nbsp;<input type="button" value="Limpiar" name="B5" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion5);"></p>

          &nbsp;<select name="modo6">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon6">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion6">
	       &nbsp;<input type="button" value="Limpiar" name="B6" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion6);"></p>

          &nbsp;<select name="modo7">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon7">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion7">
	       &nbsp;<input type="button" value="Limpiar" name="B7" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion7);"></p>

          &nbsp;<select name="modo8">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon8">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion8">
	       &nbsp;<input type="button" value="Limpiar" name="B8" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion8);"></p>

          &nbsp;<select name="modo9">
	       <option value="<?= TITULO ?>">T&iacute;tulo</option>
	       <option value="<?= INVENTOR ?>">Inventor</option>
	       <option value="<?= TIPO ?>">Tipo de Patente</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= RESUMEN ?>">Resumen</option>
	       <option value="<?= OBSERVATITULORESUMEN ?>">T&iacute;tulo o Resumen u Observaci&oacute;n</option>
	       <option value="<?= EQUIVALENTE ?>">Equivalente</option>
	       <option value="<?= PRIORIDAD ?>">Prioridad</option>
	       <option value="<?= CLASIFICACION ?>">Clasificaci&oacute;n</option>
	       <option value="<?= LOCARNO ?>">Locarno</option>
	       <option value="<?= PAIS ?>">Pa&iacute;s</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= TRAMITANTE ?>">Tramitante</option>
	       <option value="<?= AGENTE ?>">Agente</option>
	       <option value="<?= PRESENTACION ?>">Fecha Presentaci&oacute;n</option>
	       <option value="<?= PUBLICACION ?>">Fecha Publicaci&oacute;n</option>
	       <option value="<?= VENCIMIENTO ?>">Fecha Vencimiento</option>
	       <option value="<?= BOLETIN ?>">Bolet&iacute;n</option>
	       <option value="<?= PALABRA ?>">Palabra Clave</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PODER ?>">Poder</option>
	       <option value="<?= TITULORESUMEN ?>">T&iacute;tulo o Resumen</option>
	       <option value="<?= EVENTO ?>">Evento</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon9">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion9">
	       &nbsp;<input type="button" value="Limpiar" name="B9" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion9);"></p>

	       <input type="hidden" name="inicio">
	       <input type="hidden" name="cuanto">
	       <input type="hidden" name="total">
	       <input type="hidden" name="adelante">
	       <input type="hidden" name="atras">
	       &nbsp;
               <font face="Tahoma" size="2"><b>Mostrar cada </b></font>
               <select name="modover">
	         <option value="<?= 20 ?>">20</option>
	         <option value="<?= 40 ?>">40</option>
	         <option value="<?= 60 ?>">60</option>
	         <option value="<?= 80 ?>">80</option>
	         <option value="<?= 100 ?>">100</option>
	       </select>
               <font face="Tahoma" size="2"><b>Registros &nbsp;&nbsp;&nbsp;</b></font>
	       <input type="submit" value="Buscar" name="B10" class="boton_blue">
	       <input type="reset" value="Limpiar" name="B11" class="boton_blue">
	       <p align="left">
	         <font face="Tahoma" size="1">
	           <b>Tipo Patente:   A = Invenci&oacute;n, B = Dibujo Industrial, C = Mejora, D = Introducci&oacute;n, E = Modelo Industrial, F = Modelo de Utilidad,  G = Dise&ntilde;o Industrial 
	           </b></font></p>
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
  $smarty->display('pie_pag.tpl');   
?>

</div>
</body>
</html>
