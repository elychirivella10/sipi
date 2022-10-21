<?php /* Smarty version 2.6.8, created on 2021-05-09 14:25:59
         compiled from i_ingresolig.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'i_ingresolig.tpl', 74, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<?php if ($this->_tpl_vars['vopc'] == 3): ?>
<form name="formarcas1" action="i_ingresolig.php?vopc=4" method="POST">
<?php endif; ?>
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>  
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>

  <table>
  <tr> 
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td>	
      <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
        <!-- &nbsp;<input type="submit" value=" Nueva Solicitud " class="boton_blue"> -->
        &nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </form>
      <?php endif; ?> 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="i_ingresolig.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='vsol1a' value=<?php echo $this->_tpl_vars['vsol1a']; ?>
>
  <input type='hidden' name='vsol2a' value=<?php echo $this->_tpl_vars['vsol2a']; ?>
>
  <input type='hidden' name='vstring' value='<?php echo $this->_tpl_vars['vstring']; ?>
'>
  <input type='hidden' name='vstring1' value='<?php echo $this->_tpl_vars['vstring1']; ?>
'>
  <input type='hidden' name='vstring2' value='<?php echo $this->_tpl_vars['vstring2']; ?>
'>
  <input type='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>
  <input type='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type='hidden' name='vclase' value=<?php echo $this->_tpl_vars['vclase']; ?>
>
  <input type='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type='hidden' name='vcodpais' value=<?php echo $this->_tpl_vars['vcodpais']; ?>
>
  <input type='hidden' name='vcodage' value=<?php echo $this->_tpl_vars['vcodage']; ?>
>
  <input type='hidden' name='psoli' value=<?php echo $this->_tpl_vars['psoli']; ?>
>
  <input type='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>  
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>

  <table width="970px" cellspacing="1" border="1">
    <tr>
      <td class="izq-color" >Fecha de la Solicitud:</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
  size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
      <td class="izq-color" >Tipo de Solicitud:</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo2']; ?>
>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>   
  </table>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">1.- DATOS DEL SOLICITANTE:</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=I"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
    </table>

    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">2.- DATOS DEL REPRESENTANTE LEGAL:</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_verrepre.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=I"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut2" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui2" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browserepre(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut2,document.formarcas2.vtitui2)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue2" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browserepre(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut2,document.formarcas2.vtitue2)"> 
        <br>
    </td></tr> 
    </table>

    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">3.- DATOS DEL APODERADO:</td></tr>
    <tr>                        
      <td class="izq-color" >Poder:</td>
      <td class="der-color">
        <input type="text" name="vpod1" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod1']; ?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod2']; ?>
' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr>
    <tr><td colspan="2">
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=I&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color" colspan="2">
        <input type="text" name="vagent" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    <tr>
      <td class="izq-color" >Tramitante:</td>
      <td class="der-color">
        <input type="text" name="tramitante" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
      </td>
    </tr>
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">4.- INDICACION GEOGRAFICA (IG):</td></tr>
    <tr>
      <td class="izq-color" ><b>Nombre de la IG:</b></td>
      <td class="der-color">
         <textarea rows="2" name="nombreig" <?php echo $this->_tpl_vars['modo']; ?>
 cols="90" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombreig']; ?>
</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><b>Productos designados por la IG:</b></td>
      <td class="der-color">
         <textarea rows="2" name="productosig" <?php echo $this->_tpl_vars['modo']; ?>
 cols="90" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['productosig']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">5.- ZONA GEOGRAFICA:</td></tr>
    <tr>
      <td class="izq-color" ><b>Definici&oacute;n de la Zona Geogr&aacute;fica:</b></td>
      <td class="der-color">
         <textarea rows="4" name="zonag" <?php echo $this->_tpl_vars['modo']; ?>
 cols="90"><?php echo $this->_tpl_vars['zonag']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;     
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">6.- REGISTRO DE IG/DO EXTRANJERO:</td></tr>
    <tr><td colspan="2">
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=I"></iframe> 
    </td></tr>  
    <tr><td colspan="2"class="der-color">
        <input type="text" name="vprior" <?php echo $this->_tpl_vars['modo']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    <tr>
      <td class="izq-color" ><b>Tratado Internacional ratificado por Vzla:</b></td>
      <td class="der-color">
         <textarea rows="2" name="tratado" <?php echo $this->_tpl_vars['modo']; ?>
 cols="80"><?php echo $this->_tpl_vars['tratado']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">8.- DESCRIPCION DETALLADA DEL PRODUCTO DESIGNADO CON LA INDICACION GEOGRAFICA (IG):</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="distingue" <?php echo $this->_tpl_vars['modo']; ?>
 cols="115"><?php echo $this->_tpl_vars['distingue']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">9.- DESCRIPCION DE LA ZONA GEOGRAFICA:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="deszonag" <?php echo $this->_tpl_vars['modo']; ?>
 cols="115"><?php echo $this->_tpl_vars['deszonag']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">10.- VINCULO DEL PRODUCTO CON EL TERRITORIO:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="vinculo" <?php echo $this->_tpl_vars['modo']; ?>
 cols="115"><?php echo $this->_tpl_vars['vinculo']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">11.- OBSERVACIONES:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="observa" <?php echo $this->_tpl_vars['modo']; ?>
 cols="115"><?php echo $this->_tpl_vars['observa']; ?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
         <a href="i_ingresolig.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="i_ingresolig.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
         <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>




</form>
</div>  

</body>
</html>