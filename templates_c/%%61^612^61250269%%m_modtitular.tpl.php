<?php /* Smarty version 2.6.8, created on 2020-12-10 15:08:46
         compiled from m_modtitular.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_modtitular.tpl', 111, false),array('modifier', 'truncate', 'm_modtitular.tpl', 127, false),)), $this); ?>
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

<form name="formarcas1" action="m_modtitular.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='depto' value=<?php echo $this->_tpl_vars['depto_id']; ?>
>
  <input type='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type='hidden' name='vreg' value=<?php echo $this->_tpl_vars['vreg']; ?>
>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>  
  <input type='hidden' name='conx' value='<?php echo $this->_tpl_vars['conx']; ?>
'>  
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>  
    
  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    

  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>

	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
                      value='<?php echo $this->_tpl_vars['registro1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,6, this)"  
                      onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		      onChange="this.value=this.value.toUpperCase()">-
            <input type="text" name="vreg2" size="6" maxlength="6" 
		      value='<?php echo $this->_tpl_vars['registro2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
                      onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
                      onchange="Rellena(document.formarcas1.vreg2,6)">
      <td class="cnt">&nbsp;&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

      <td class="izq5-color">Solicitud No.:</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	  &nbsp;&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_modtitular.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='depto' value=<?php echo $this->_tpl_vars['depto_id']; ?>
>
  <input type='hidden' name='dirano' value=<?php echo $this->_tpl_vars['dirano']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='vreg1' value=<?php echo $this->_tpl_vars['vreg1']; ?>
>
  <input type='hidden' name='vreg2' value=<?php echo $this->_tpl_vars['vreg2']; ?>
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
  <input type='hidden' name='salir' value='<?php echo $this->_tpl_vars['salir']; ?>
'>  
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>  

  <input type='hidden' name='nconexion' value='<?php echo $this->_tpl_vars['nconexion']; ?>
'>
  <input type='hidden' name='nveces' value='<?php echo $this->_tpl_vars['nveces']; ?>
'>    
        
  <table cellspacing="1" border="1">
    <tr>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.fecha_regis)" onchange="valFecha(this,document.formarcas2.fecha_regis)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="der-color" rowspan="6" valign="top">
        <input name="ubicacion" type="file" disabled value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="270" alt="vista previa"/></br>
      </td>
    </tr>
<tr>
      <td class="izq-color" >Fecha Registro:</td>
      <td class="der-color">
         <input type="text" name="fecha_regis" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_regis']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.fecha_venc)" onchange="valFecha(this,document.formarcas2.fecha_venc)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar52');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         &nbsp;&nbsp;Vencimiento Reg.:&nbsp;
         <input type="text" name="fecha_venc" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_venc']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar54');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
</tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>
    
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="120" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
       <?php if ($this->_tpl_vars['accion'] != 2): ?>
        <select size="1" name="options" <?php echo $this->_tpl_vars['modo3']; ?>
 onchange="this.form.distingue.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vnomclase'],'output' => ((is_array($_tmp=$this->_tpl_vars['vnomclase'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 56) : smarty_modifier_truncate($_tmp, 56))), $this);?>

        </select>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['accion'] == 2): ?>
          <input type="text" name="vclase" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" >
        <?php endif; ?>
        &nbsp;&nbsp;
        <select size="1" name="clase_id" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvclase'],'selected' => $this->_tpl_vars['clase_id'],'output' => $this->_tpl_vars['arraytclase']), $this);?>

        </select>
        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo6']; ?>
&nbsp;&nbsp;
        <select size="1" name="modalidad" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="habilitar(document.formarcas2.modalidad,document.formarcas2.nombre,document.formarcas2.etiqueta,document.formarcas2.vviena,document.formarcas2.vvienai,document.formarcas2.vvienae,document.formarcas2.ubicacion)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvmodal'],'selected' => $this->_tpl_vars['modalidad'],'output' => $this->_tpl_vars['arraytmodal']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Cronolog&iacute;a de Eventos</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">Fecha Evento</td>
        <td class="columna-titulo">Evento</b></font></td>
        <td class="columna-titulo">Descripci&oacute;n</td>
        <td class="columna-titulo">Fecha de Transacci&oacute;n</td>
        <td class="columna-titulo">Nro Documento</td>
        <td class="columna-titulo">Comentario</td>
      </tr>
      <tr>
        <?php unset($this->_sections['customer']);
$this->_sections['customer']['name'] = 'customer';
$this->_sections['customer']['loop'] = is_array($_loop=$this->_tpl_vars['custid']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['customer']['show'] = true;
$this->_sections['customer']['max'] = $this->_sections['customer']['loop'];
$this->_sections['customer']['step'] = 1;
$this->_sections['customer']['start'] = $this->_sections['customer']['step'] > 0 ? 0 : $this->_sections['customer']['loop']-1;
if ($this->_sections['customer']['show']) {
    $this->_sections['customer']['total'] = $this->_sections['customer']['loop'];
    if ($this->_sections['customer']['total'] == 0)
        $this->_sections['customer']['show'] = false;
} else
    $this->_sections['customer']['total'] = 0;
if ($this->_sections['customer']['show']):

            for ($this->_sections['customer']['index'] = $this->_sections['customer']['start'], $this->_sections['customer']['iteration'] = 1;
                 $this->_sections['customer']['iteration'] <= $this->_sections['customer']['total'];
                 $this->_sections['customer']['index'] += $this->_sections['customer']['step'], $this->_sections['customer']['iteration']++):
$this->_sections['customer']['rownum'] = $this->_sections['customer']['iteration'];
$this->_sections['customer']['index_prev'] = $this->_sections['customer']['index'] - $this->_sections['customer']['step'];
$this->_sections['customer']['index_next'] = $this->_sections['customer']['index'] + $this->_sections['customer']['step'];
$this->_sections['customer']['first']      = ($this->_sections['customer']['iteration'] == 1);
$this->_sections['customer']['last']       = ($this->_sections['customer']['iteration'] == $this->_sections['customer']['total']);
?>
        <tr>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][0]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][1]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][2]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][3]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][4]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][5]; ?>
</td>
        </tr>
        <?php endfor; endif; ?>
      </tr>
    </table>
    
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <input type="button" class="boton_blue" value="Modificar" name="vtitum" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitum)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

  <table width="200">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
          <a href="m_modtitular.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
          <a href="m_modtitular.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a> 
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>