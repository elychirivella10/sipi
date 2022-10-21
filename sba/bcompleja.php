<script language=JavaScript>
function inicializa($valor)
{
 $valor.value = "";
}
</script>
<?php 
// Programa PHP. Pantalla de Búsqueda Avanzada
// (bcompleja.php por seleccion de campos de derecho de autor) 
// Realizado Por Ing. Karina Perez

?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="layersmenu.css" type="text/css"></link>
  <link rel="shortcut icon" href="LOGOS/shortcut_icon_phplm.png"></link>
  <title>Servicio Aut&oacute;nomo de la Propiedad Intelectual</title>

<?php// include ("libjs/layersmenu-browser_detection.js"); ?>
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

<body>

<td valign="top" bgcolor="#F9F9F9">
 
   <table border="1" width="100%" height="89">
    <tr>
      <td width="100%" height="19" class="celda1">
        <p style="line-height: 100%"><b>
          B&uacute;squeda de Derecho de Autor: Selecciones las Opciones que desea consultar
        </b></p>
      </td>
    </tr>
	 <tr>
    <td width="100%" height="16" class="celda2"><p>
	    <form name="forbusqueda" method="POST" action="lis_compleja.php">
	 	    <br />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo1">
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo;</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon1">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	     &nbsp;<input type="text" name="opcion1">
	       &nbsp;<input type="button" value="Limpiar" name="B1" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion1);"></p>   
	       
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo2">
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon2">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion2">
	       &nbsp;<input type="button" value="Limpiar" name="B2" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion2);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo3">
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon3">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion3">
	       &nbsp;<input type="button" value="Limpiar" name="B3" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion3);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo4">
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon4">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion4">
	       &nbsp;<input type="button" value="Limpiar" name="B4" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion4);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo5">
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon5">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion5">
	       &nbsp;<input type="button" value="Limpiar" name="B5" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion5);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo6">
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon6">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion6">
	       &nbsp;<input type="button" value="Limpiar" name="B6" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion6);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo7">
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon7">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion7">
	       &nbsp;<input type="button" value="Limpiar" name="B7" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion7);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo8">
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon8">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion8">
	       &nbsp;<input type="button" value="Limpiar" name="B8" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion8);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo9">
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon9">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion9">
	       &nbsp;<input type="button" value="Limpiar" name="B9" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion9);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo10">
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon10">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion10">
	       &nbsp;<input type="button" value="Limpiar" name="B10" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion10);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo11">
	       <option value="<?= PLANILLA ?>">Planilla</option>
	       <option value="<?= SOLICITUD ?>">Solicitud</option>
	       <option value="<?= REGISTRO ?>">Registro</option>
	       <option value="<?= FECHA ?>">Fecha Solicitud</option>
	       <option value="<?= ESTATUS ?>">Estatus</option>
	       <option value="<?= TIPO ?>">Tipo de Obra</option>
	       <option value="<?= PAIS ?>">Pais</option>
	       <option value="<?= TITULO ?>">Titulo</option>
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= DESCRIPCION ?>">Descripci&oacute;n</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       </select>
          &nbsp;&nbsp;<select name="modocon11">
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA ?>">contenga la porci&oacute;n de texto</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS ?>">sea exactamente igual a</option>
	       <option value="<?= BÚSQUEDA_NOMBRE_COMIENCE_POR ?>">que comiencen por</option>
	       </select>
	       &nbsp;<input type="text" name="opcion11">
	       &nbsp;<input type="button" value="Limpiar" name="B11" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion11);"></p>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="modo12">
	       <option value="<?= DOCUMENTO     ?>">Documento    </option>
	       </select>
      	     &nbsp;&nbsp;<select name="modocon12">
	       <option value="<?= AUTOR ?>">Autor</option>
	       <option value="<?= SOLICITANTE ?>">Solicitante</option>
	       <option value="<?= ARTISTA ?>">Artista</option>
	       <option value="<?= PRODUCTOR ?>">Productor</option>
	       <option value="<?= TITULAR ?>">Titular</option>
	       <option value="<?= REPRESENTANTE ?>">Representante</option>
	       </select>
	       &nbsp;<input type="text" name="opcion12">
	       &nbsp;<input type="button" value="Limpiar" name="B12" class="boton_cream" onclick="inicializa(document.forbusqueda.opcion12);"></p>   

	       <input type="hidden" name="inicio">
	       <input type="hidden" name="cuanto">
	       <input type="hidden" name="total">
	       <input type="hidden" name="adelante">
	       <input type="hidden" name="atras">
	       <br />
	       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Buscar" name="B13" class="boton_blue">
	       <input type="reset" value="Limpiar" name="B14" class="boton_blue">
	       <input type="button" value="Salir" name="B15" class="boton_blue" onclick='window.close()'>
	       <br />
	       <font class="estilo1">
		    <p>Nota: La opcion de consulta por Documento, no puede ser combinada con el resto de las opciones </p></font>
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    <font class="estilo2">
          <b>Tipo de Obra:   OL = LITERARIAS,  AV = ARTE VISUAL, OE = ESCENICAS, OM = MUSICALES, AR = AUDIOVISUALES Y RADIOFONICAS, PC = PROGRAMAS DE COMPUTACION Y BASE DE DATOS,  PF = PRODUCIONES FONOGRAFICAS,  IE = INTERPRETACIONES Y EJECUCIONES ARTISTICAS, AC = ACTOS Y CONTRATOS</b>
          </font></p>
          <br />
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
$mid->printFooter();
?>

</body>
</html>
