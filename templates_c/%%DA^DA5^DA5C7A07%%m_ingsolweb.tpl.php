<?php /* Smarty version 2.6.8, created on 2022-03-09 13:57:34
         compiled from m_ingsolweb.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_ingsolweb.tpl', 75, false),array('modifier', 'truncate', 'm_ingsolweb.tpl', 120, false),)), $this); ?>
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
<form name="formarcas1" action="m_ingsolweb.php?vopc=4" method="POST">
<?php endif; ?>

  <table>
  <tr> 
    <tr>
      <!-- <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td> -->	
      <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
      &nbsp;<input type="image" src="../imagenes/folder_add_f2.png" width="32" height="24" value="Nueva Solicitud">Nueva Solicitud
      </form>
      <?php endif; ?> 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="m_ingsolweb.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type='hidden' name='vexp' value=<?php echo $this->_tpl_vars['vexp']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
 <!-- <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='vsol1a' value=<?php echo $this->_tpl_vars['vsol1a']; ?>
>
  <input type='hidden' name='vsol2a' value=<?php echo $this->_tpl_vars['vsol2a']; ?>
> -->
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
  <input type='hidden' name='vtipper' value=<?php echo $this->_tpl_vars['vtipper']; ?>
> 
  <input type='hidden' name='vtipage' value='<?php echo $this->_tpl_vars['vtipage']; ?>
'> 

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq3-color" ><?php echo $this->_tpl_vars['campo15']; ?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)" >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
      <td class="der-color" rowspan="9" valign="top">
        <input name="ubicacion" type="file" value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size="25" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="286" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">

      <input type="text" name="vsol3" size="4" maxlength="4" value='<?php echo $this->_tpl_vars['vsol3']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol4)" onchange="Rellena(document.formarcas2.vsol3,4)">-	
      <input type="text" name="vsol4" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol4']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vreg1d)" onchange="Rellena(document.formarcas2.vsol4,6)">&nbsp;&nbsp;&nbsp; o &nbsp;&nbsp;

        <input type="text" name="vreg1d" size="1" maxlength="1" value='<?php echo $this->_tpl_vars['vreg1d']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vreg2d" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vreg2d']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.nombre)" onchange="Rellena(document.formarcas2.vreg2d,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="200" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <select size="1" name="modalidad" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilitar(document.formarcas2.modalidad,document.formarcas2.nombre,document.formarcas2.etiqueta,document.formarcas2.vviena,document.formarcas2.vvienai,document.formarcas2.vvienae,document.formarcas2.ubicacion)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvmodal'],'selected' => $this->_tpl_vars['modalidad'],'output' => $this->_tpl_vars['arraytmodal']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
         <textarea rows="6" name="etiqueta" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="6000"><?php echo $this->_tpl_vars['etiqueta']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
       <?php if ($this->_tpl_vars['accion'] == 2): ?>
        <select size="1" name="options" <?php echo $this->_tpl_vars['modo3']; ?>
  onchange="this.form.distingue.value=this.options[this.selectedIndex].value">
        <!-- <select size="1" name="options" <?php echo $this->_tpl_vars['modo3']; ?>
 > -->
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vnomclase'],'output' => ((is_array($_tmp=$this->_tpl_vars['vnomclase'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 56) : smarty_modifier_truncate($_tmp, 56))), $this);?>

        </select>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['accion'] != 2): ?>
          <input type="text" name="vclase" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" >
        <?php endif; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Asociar Clase Nacional" name="vbusdat" onclick="b_busqueda(document.all.vsol1,document.all.options,document.all.tipo_marca)" class="boton_blue">
      </td>
    </tr>
   <!-- <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo20']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vclnac" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vclnac']; ?>
' size="1" maxlength="2" >
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo20']; ?>
</td>
      <td class="der-color">
       <iframe id='top' frameborder='0' style='width:100%;height:40px;background-color:WHITE;' src="../comun/z_verbusqueda.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
"></iframe>
      </td>
    </tr>

    <!--<tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" colspan="2">
         <textarea rows="3" name="distingue" <?php echo $this->_tpl_vars['modo']; ?>
 cols="97"><?php echo $this->_tpl_vars['distingue']; ?>
</textarea>
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color" colspan="2">
        <iframe name='productos' frameborder='0' style='width:100%;height:160px;background-color:WHITE;' src="../comun/z_verproductos.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
"></iframe>
      </td>
    </tr> 
    <!-- <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type="text" name="input2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['pais_resid']; ?>
' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
        <select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['pais_resid'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

        </select>
      </td>
    </tr> --> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo21']; ?>
</td>
      <td class="der-color" colspan="2">
          <input type="radio" name="group3" value="Nacional" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="visible_pai(this.value);" <?php echo $this->_tpl_vars['checkpaisn']; ?>
>Nacional
          <input type="radio" name="group3" value="Extranjero" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="visible_pai(this.value);" <?php echo $this->_tpl_vars['checkpaise']; ?>
>Extranjero
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAIS:
          <select size="1" name="vpap" STYLE="<?php echo $this->_tpl_vars['checkdespaise']; ?>
"
                  onchange="this.form.vpap.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['vpaisor'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

          </select>
          <input type='text' name='vpav' size='20' STYLE="<?php echo $this->_tpl_vars['checkdespaisn']; ?>
" value="VENEZUELA" readonly="readonly">
      </td>
    </tr>
    <!-- <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="vpod1" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod1']; ?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas2.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vpod2']; ?>
' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr>  
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" colspan="2"></td>
    </tr> -->
    <tr>
    </tr>
      
  </tr>
  </table></center>

   &nbsp;
    <table width="86%" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo13']; ?>
</td></tr>
    <tr><td class="der-color">
          <label for="reg_part2">TIPO:</label>
          <input type="radio" name="rtipoage" value="2" 
                 onchange="visible_age(this.value);" onclick="valagente(this,document.formarcas2.vtipage);"> Tramitante 
          <input type="radio" name="rtipoage" value="3" 
                 onchange="visible_age(this.value);" onclick="valagente(this,document.formarcas2.vtipage);"> Apoderado 
          &nbsp;&nbsp;C&eacute;dula:
          <select size="1" name="lcedtra" id="lcedtra" onchange="visible_cedtra(this.value);">
             <option VALUE="V" selected>V</option>
             <option VALUE="E">E</option> 
             <option VALUE="P">P</option> 
          </select>
          <input type="text" name="vcedtra" size="8" maxlength="9" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">
          <input type="text" name="vpastra" size="14" maxlength="14" STYLE="display:none">   
        <input type="button" class="boton_blue" value="Buscar" name="vtrami" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetramitante(document.formarcas2.vsol1,document.formarcas2.vtipage,document.formarcas2.lcedtra,document.formarcas2.vcedtra,document.formarcas2.vpastra)">
        <br>
    </td></tr> 
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&pder=M"></iframe>  
    </td></tr>  
    </table>
  
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&pder=M&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar"  name="vageni" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vagent,document.formarcas2.vageni)">
        <br>
    </td></tr> 
    </table>
  
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td></tr>
   <tr><td colspan="2" class="izq8-color">
          <label for="reg_part">INDOLE:</label>
          <input type="radio" name="rtipoper" value="1" checked  
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Persona Natural 
          <input type="radio" name="rtipoper" value="2" 
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Cooperativa 
          <input type="radio" name="rtipoper" value="3" 
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Persona Jur&iacute;dica Nacional 
          <input type="radio" name="rtipoper" value="4" 
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Persona Jur&iacute;dica Extranjera
   </td></tr>

   <tr><td colspan="2" class="izq8-color">
          <p id="tpernat" STYLE="display:inline">C&eacute;dula:</p>
          <select size="1" name="lcedtit" id="lcedtit" STYLE="display:inline" onchange="visible_pas(this.value);">
             <option VALUE="V" selected>V</option>
             <option VALUE="E">E</option> 
             <option VALUE="P">P</option> 
          </select>
          <input type="text" name="vcedtit" size="8" maxlength="9" STYLE="display:inline" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">
          <input type="text" name="vpastit" size="14" maxlength="14" STYLE="display:none">    
          <p id="tperjurn" STYLE="display:none">Rif:</p>
          <select size="1" name="lriftit" id="lriftit" STYLE="display:none">
             <option VALUE="J" selected>J</option>
          </select>
          <input type="text" name="vriftit" size="9" maxlength="9" STYLE="display:none" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">  
          <p id="tperjure" STYLE="display:none">Nombre de la Empresa:</p>
          <input type="text" name="vnomtit" size="35" STYLE="display:none" onkeyup="this.value=this.value.toUpperCase();">  
          <input type="button" class="boton_blue" value="Buscar"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vtipper,document.formarcas2.lcedtit,document.formarcas2.vcedtit,document.formarcas2.vpastit,document.formarcas2.lriftit,document.formarcas2.vriftit,document.formarcas2.vnomtit,document.formarcas2.vtitui)">
   </td></tr> 
   
    
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&pder=M"></iframe> 
    </td></tr>  
    </table>
    &nbsp;
    
    <!-- <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" <?php echo $this->_tpl_vars['modo']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp; -->

    <!-- <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['campo14']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" <?php echo $this->_tpl_vars['modo']; ?>
 size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
    </table>
    &nbsp; -->

  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
         <a href="m_ingsolweb.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_ingsolweb.php?vopc=3&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
         <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>