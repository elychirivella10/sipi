<?php /* Smarty version 2.6.8, created on 2020-10-20 09:05:34
         compiled from m_solviena.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_solviena.tpl', 60, false),array('function', 'html_options', 'm_solviena.tpl', 130, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="m_solviena.php?vopc=1" method="post">
  <input type="hidden" name="etiqueta" value='<?php echo $this->_tpl_vars['etiqueta']; ?>
'>

  <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">&nbsp;
            </td>
            <td class="cnt"><input <?php echo $this->_tpl_vars['modo1']; ?>
 type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

</form>				  

  </table>
  &nbsp; 
  <table cellspacing="0" border="1">	
  <tr>   
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
	   <td class="der-color"><input size="9" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" rowspan="7" align="center">
          <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
          <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="193" height="205">
        </td>
      <?php endif; ?>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='<?php echo $this->_tpl_vars['vtipo']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>-
                            <input size="30" type="text" name="vtip" value='<?php echo $this->_tpl_vars['vtip']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>  
                            <input size="30" type="text" name="modal" value='<?php echo $this->_tpl_vars['modal']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color"><input size="1" type="text" name="vclase" value='<?php echo $this->_tpl_vars['vclase']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>-
                            <input size="20" type="text" name="vindcla" value='<?php echo $this->_tpl_vars['vindcla']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
	   <td class="der-color"><input size="72" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr><td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['vfecreg'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['vfecven'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vtrage" value="<?php echo $this->_tpl_vars['vtra']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="63" type="text" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
    <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='<?php echo $this->_tpl_vars['vnactit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vnadtit" value='<?php echo $this->_tpl_vars['vnadtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vdomtit" value='<?php echo $this->_tpl_vars['vdomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
  </tr>
  </table>		
</form>
&nbsp;     
<form name="formarcas3" action="m_solviena.php?vopc=5&vsol=<?php echo $this->_tpl_vars['vsol']; ?>
" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
  <input type="hidden" name="vsol2" value='<?php echo $this->_tpl_vars['vsol2']; ?>
'>
  <input type="hidden" name="vreg1" value='<?php echo $this->_tpl_vars['vreg1']; ?>
'>
  <input type="hidden" name="vreg2" value='<?php echo $this->_tpl_vars['vreg2']; ?>
'>
  <input type="hidden" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
'>
  <input type="hidden" name="vexist" value='<?php echo $this->_tpl_vars['vexist']; ?>
'>
  <input type="hidden" name="etiqueta" value='<?php echo $this->_tpl_vars['etiqueta']; ?>
'>

  <table cellspacing="0" border="1">	
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color">
         <textarea rows="6" name="etiqueta" <?php echo $this->_tpl_vars['modo']; ?>
 cols="101"><?php echo $this->_tpl_vars['etiqueta']; ?>
</textarea>
      </td>
    </tr>
  </table>

  <!--    <table>
      <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
          <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcpoder']; ?>
</td><td class="der-color"><?php echo $this->_tpl_vars['arr_ph1'][$this->_sections['cont']['index']]; ?>
</td>
	      <td class="izq-color"><?php echo $this->_tpl_vars['lnpoder']; ?>
</td><td class="der-color"><?php echo $this->_tpl_vars['arr_ph2'][$this->_sections['cont']['index']]; ?>
</td>
	      <?php if ($this->_tpl_vars['vopc'] == 4): ?>
	      <td class="cnt"><input type="image" src="../imagenes/delete.gif" name="accion" value="<?php echo $this->_tpl_vars['arr_ph1'][$this->_sections['cont']['index']]; ?>
">Borrar</td>
	      <?php endif; ?>
	      </tr>
      <?php endfor; endif; ?> 
      <?php if ($this->_tpl_vars['vopc'] == 4): ?> 
      <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcpoder']; ?>
</td><td class="der-color"><input size="5" type="text" name="vccv"     size="5" maxlength="6" onchange="valagente(document.formarcas3.vccv,document.formarcas3.vagenom)"></td>
	  <td class="izq-color"><?php echo $this->_tpl_vars['lnpoder']; ?>
</td><td class="der-color"><select size=1 name='vagenom' onchange="valagente(document.formarcas3.vagenom,document.formarcas3.vccv)">
	  <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodage'],'selected' => $this->_tpl_vars['codage'],'output' => $this->_tpl_vars['vnomage']), $this);?>

	  <select></td>        
       <td class="cnt"><input type="image" name="accion" src="../imagenes/tick.png" value="Incluir">Incluir</td>
      </tr>
      <?php endif; ?>	  
     </table> -->
     
  <table width="85%" cellspacing="0" border="1">
    <tr><td class="izq2-color" colspan="2"><?php echo $this->_tpl_vars['lcviena']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" <?php echo $this->_tpl_vars['modo3']; ?>
 size="20" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $this->_tpl_vars['modo3']; ?>
 onclick="gestionvienap(document.formarcas3.vsol1,document.formarcas3.vsol2,document.formarcas3.vviena,document.formarcas3.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $this->_tpl_vars['modo3']; ?>
 onclick="gestionvienap(document.formarcas3.vsol1,document.formarcas3.vsol2,document.formarcas3.vviena,document.formarcas3.vvienae)">
    </td></tr>
  </table>
  &nbsp;
     
     
     
  &nbsp;
  <table width="225">
    <tr>
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
      <td class="cnt"><a href="m_solviena.php?vopc=5&vsol=<?php echo $this->_tpl_vars['vsol']; ?>
"><img src="../imagenes/boton_editar_rojo.png" border="0"></a></td>
      <?php endif; ?> 
      <?php if ($this->_tpl_vars['vopc'] == 4): ?>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" name="accion" value="Guardar"></td> 
      <?php endif; ?> 
      <td class="cnt"><a href="m_solviena.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>