<?php 
// Programa PHP. Inicio del Sistema de Busqueda de Patentes
// (index.php)
// Realizado Por Ing. Karina Pérez
// Modificado por Ing. Rómulo Mendoza / Julio 2008 
?>

<html>
<head>
  <link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
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

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$usuario = $_SESSION['usuario_login'];
$usuario = trim($usuario);

$fecha   = trim(fechahoy());
$subtitulo = "B&uacute;squeda T&eacute;cnica de Marcas";

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
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <img src="../imagenes/encabezado.png" width="995px" height="52">
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
    <td width="10%" class="subtitulo2">
      <b><i><a href="http://www.banfoandes.com.ve">Banco Bicentenario</a></i></b>
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

<td valign="top" bgcolor="#F9F9F9">

   <p style="line-height: 100%"> <font face="Tahoma" size="2"><u><b>Tipos de
      B&uacute;squedas</b></u></font></p>
      <table border="1" width="95%" height="89">
        <tr>
          <td width="100%" height="18" class="celda1" > 
            Por Nombre del Documento 
          </td>
        </tr>
        <tr>
          <!-- <td width="100%" height="66" bgcolor="#ffe2b1">-->
          <td width="100%" height="61" class="celda2">
            Introduzca la palabra a Buscar:
   		  <form method="POST" action="listado_titulo.php">     
		     <p style="line-height: 100%"> 
             &nbsp;<select name="modoconsulta">
		       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contengan la porci&oacute;n de texto</option>
		       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
		       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
		      </select>
		     <input type="text" name="texto" onKeyPress="javascript:this.value=this.value.toUpperCase();">
		     <input type="hidden" name="inicio">
		     <input type="hidden" name="cuanto">
		     <input type="hidden" name="total">
		     <input type="hidden" name="adelante">
		     <input type="hidden" name="atras">
	        &nbsp;
           <font face="Tahoma" size="2">Mostrar cada </font>
           <select name="modover1">
	         <option value="<?= 20 ?>">20</option>
	         <option value="<?= 40 ?>">40</option>
	         <option value="<?= 60 ?>">60</option>
	         <option value="<?= 80 ?>">80</option>
	         <option value="<?= 100 ?>">100</option>
	        </select>
           <font face="Tahoma" size="2">Registros &nbsp;&nbsp;&nbsp;</font>
		     <input type="submit" value="Buscar" class="boton_blue">
		     <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
		 </form>

          </td>
        </tr>
      </table>
      <table border="1" width="95%" height="97">
        <tr>
          <td width="100%" height="18" class="celda1">
            Por No. Solicitud del Documento
          </td>
        </tr>
        <tr>
          <td width="100%" height="66" class="celda2">
            Introduzca el n&uacute;mero: (9999-999999)
            <form name="forbusq" method="POST" action="listado.php">
              <p style="line-height: 100%">&nbsp;
              <input type="text" name="vsol1" size="2" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forbusq.vsol2)">-
		        <input type="text" name="vsol2" size="5" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forbusq.submit)" onchange="Rellena(document.forbusq.vsol2,6)">              
             
		      <input type="submit" value="Buscar" name="B1" class="boton_blue">
		      <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
            </form>
          </td>
        </tr>
      </table>
      <table border="1" width="95%" height="77">
        <tr>
          <td width="100%" height="18" class="celda1">
            Por Empresa o Titular o Solicitante
          </td>
        </tr>
        <tr>
          <td width="100%" height="46" class="celda2" >
            Introduzca la palabra a Buscar:
		   <form method="POST" action="listado_titular.php">     
		      <p style="line-height: 100%"> 
             &nbsp;<select name="modoempresa">
		       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contengan la porci&oacute;n de texto</option>
		       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
		       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
		      </select>
		     <input type="text" name="nom_emp" onKeyPress="javascript:this.value=this.value.toUpperCase();">
		     <input type="hidden" name="inicio">
		     <input type="hidden" name="cuanto">
		     <input type="hidden" name="total">
		     <input type="hidden" name="adelante">
		     <input type="hidden" name="atras">
	        &nbsp;
           <font face="Tahoma" size="2">Mostrar cada </font>
           <select name="modover2">
	         <option value="<?= 20 ?>">20</option>
	         <option value="<?= 40 ?>">40</option>
	         <option value="<?= 60 ?>">60</option>
	         <option value="<?= 80 ?>">80</option>
	         <option value="<?= 100 ?>">100</option>
	        </select>
           <font face="Tahoma" size="2">Registros &nbsp;&nbsp;&nbsp;</font>
		     <input type="submit" value="Buscar" class="boton_blue">
		     <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
		 </form>
          </td>
        </tr>
      </table>
      <!-- <table border="1" width="95%" height="97">
        <tr>
          <td width="100%" height="18" class="celda1">
            Por Clasificaci&oacute;n Internacional del Documento
          </td>
        </tr>
        <tr>
          <td width="100%" height="66" class="celda2">
            Introduzca el n&uacute;mero de clasificaci&oacute;n:
		    <form method="POST" action="listado_ipc.php">     
		      <p style="line-height: 100%"> 
             &nbsp;<select name="modoconsulta">
		       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contengan la porci&oacute;n de texto</option>
		       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
		       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
		      </select>
		     <input type="text" name="clasificacion" onKeyPress="javascript:this.value=this.value.toUpperCase();">
		     <input type="hidden" name="inicio">
		     <input type="hidden" name="cuanto">
		     <input type="hidden" name="total">
		     <input type="hidden" name="adelante">
		     <input type="hidden" name="atras">
	        &nbsp;
           <font face="Tahoma" size="2">Mostrar cada </font>
           <select name="modover3">
	         <option value="<?= 20 ?>">20</option>
	         <option value="<?= 40 ?>">40</option>
	         <option value="<?= 60 ?>">60</option>
	         <option value="<?= 80 ?>">80</option>
	         <option value="<?= 100 ?>">100</option>
	        </select>
           <font face="Tahoma" size="2">Registros &nbsp;&nbsp;&nbsp;</font>
		     <input type="submit" value="Buscar" class="boton_blue">
		     <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
		 </form>

            </td>
       
</td>
</tr>
</table> -->
</td></tr>
</table>

</tabla>  

    </td>
</td>
</tr>
</table>
</td></tr>
</table>

<?php
  $smarty->display('pie_pag5.tpl');   
?>

</body>
</html>

