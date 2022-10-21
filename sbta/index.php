<?php 
// Programa PHP. Inicio del Sistema de Busqueda de Patentes
// (index.php)
// Realizado por Ing. Rómulo Mendoza / Enero 2014 
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

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

$usuario = $_SESSION['usuario_login'];
$usuario = trim($usuario);

$fecha   = trim(fechahoy());
$subtitulo = "B&uacute;squeda T&eacute;cnica de Derecho de Autor";

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

<?php
//Encabezados
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo',$subtitulo);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
?>

</td>
</tr>
<tr>
<td width="20%" class="bar" valign="top" nowrap="nowrap">
<center>
<br />
</center>
Menu
<?php
$mid->setMenuStructureFile("layersmenu-vertical-1.txt");
$mid->parseStructureForMenu("treemenu1");
print $mid->newTreeMenu("treemenu1");
?>
<br />
<br />
<center></center>
<br />
<center></center>
</td>

<td valign="top" bgcolor="#F9F9F9">

   <p style="line-height: 100%"> <font face="Tahoma" size="3" align="left"><u><b>TIPOS DE
      BUSQUEDAS</b></u></font></p>
      <table border="1" width="95%" height="97">
        <tr>
          <td width="100%" height="18" class="Estilo5">
            Por No. Solicitud de la Obra
          </td>
        </tr>
        <tr>
          <td width="100%" height="66" class="celda2">
            Introduzca el N&uacute;mero: (999999)
            <form name="forbusq" method="POST" action="listado.php">
                <p> &nbsp;              
		          <input type="text" name="vsol2" size="5" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forbusq.submit)" onchange="Rellena(document.forbusq.vsol2,6)">              
		          <input type='image' align="middle" src="../imagenes/boton_buscar_azul.png" value="Buscar" onclick="document.forbusq.vsol2.value='';">&nbsp;&nbsp;
                <a href='<? echo $vhomepage; ?>'><img align="middle" src="../imagenes/boton_limpiar_rojo.png" name="limpiar" onclick="document.forbusq.vsol2.value='';"></a>
		          </p>
            </form>
          </td>
        </tr>
      </table>
      <table border="1" width="95%" height="89">
        <tr>
          <td width="100%" height="18" class="Estilo5" > 
            En T&iacute;tulo de la Obra 
          </td>
        </tr>
        <tr>
          <td width="100%" height="61" class="celda2">
            Introduzca la palabra a buscar:
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
          <td width="100%" height="18" class="Estilo5">
            Por No. Registro de la Obra
          </td>
        </tr>
        <tr>
          <td width="100%" height="66" class="celda2">
            Introduzca el N&uacute;mero: (999999)
            <form name="forbusq" method="POST" action="listado_reg.php">
              <p style="line-height: 100%">&nbsp;
		          <input type="text" name="vsol2" size="5" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forbusq.submit)" onchange="Rellena(document.forbusq.vsol2,6)">              
		      <input type="submit" value="Buscar" name="B1" class="boton_blue">
		      <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
            </form>
          </td>
        </tr>
      </table>
      <table border="1" width="95%" height="77">
        <tr>
          <td width="100%" height="18" class="Estilo5">
            En Solicitante
          </td>
        </tr>
        <tr>
          <td width="100%" height="46" class="celda2" >
            Introduzca el nombre del Solicitante:
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
      <table border="1" width="95%" height="77">
        <tr>
          <td width="100%" height="18" class="Estilo5">
            En Autor
          </td>
        </tr>
        <tr>
          <td width="100%" height="46" class="celda2" >
            Introduzca el nombre del Autor:
		   <form method="POST" action="listado_autor.php">     
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
      <table border="1" width="95%" height="97">
        <tr>
          <td width="100%" height="18" class="Estilo5">
            Por No. Planilla
          </td>
        </tr>
        <tr>
          <td width="100%" height="66" class="celda2">
            Introduzca el N&uacute;mero: (999999)
            <form name="forbusq" method="POST" action="listado_planilla.php">
              <p style="line-height: 100%">&nbsp;
		          <input type="text" name="vsol2" size="5" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forbusq.submit)" onchange="Rellena(document.forbusq.vsol2,6)">              
		      <input type="submit" value="Buscar" name="B1" class="boton_blue">
		      <input type="reset" value="Limpiar" name="B2" class="boton_blue"></p>
            </form>
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
  $smarty->display('pie_pag5.tpl');   
?>

</body>
</html>

