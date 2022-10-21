<?php /* Smarty version 2.6.8, created on 2021-01-06 08:05:34
         compiled from p_pclaves.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <form name="forpatentes1" action="p_pclaves.php?vopc=1" method="post">
    <div align="center">

      <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['solicitud1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpatentes1.vsol2)" onchange="Rellena(document.forpatentes1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['solicitud2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forpatentes1.submit)" onchange="Rellena(document.forpatentes1.vsol2,6)">
		
		&nbsp;&nbsp;<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td></tr>
  </form>				  
  </div>  
    </table>
    
  <H3> <?php echo $this->_tpl_vars['vnompat']; ?>
 <H3>
  <form name="forpatentes3" action="p_pclaves.php?vopc=5&vsol=<?php echo $this->_tpl_vars['vsol']; ?>
&v1=1" method="post">
    <div align="center">
      &nbsp; 
      <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>
      <H3><?php echo $this->_tpl_vars['lpodhab']; ?>
</H3>
      <table>
      <?php if ($this->_tpl_vars['vopc'] == 4): ?> 
      <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcpoder']; ?>
</td><td class="der-color">
              <input size="5" <?php echo $this->_tpl_vars['vmodo']; ?>
 type="text" name="vagen" size="5" maxlength="6"></td>
	  <td class="izq-color"><?php echo $this->_tpl_vars['lnpoder']; ?>
</td><td class="der-color">
              <input size="30" type="text" name="vagenom" maxlength="40" onChange="javascript:this.value=this.value.toUpperCase();"></td>        
          <td class="cnt"><input type="image" name="accion" src="../imagenes/tick.png" value="Incluir">Incluir</td>
      </tr>
      <?php endif; ?>
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
     </table>

    <table width="180">
      <tr>
        <!-- <?php if ($this->_tpl_vars['vopc'] == 1): ?> -->
        <td class="cnt"><a href="p_pclaves.php?vopc=5&vsol=<?php echo $this->_tpl_vars['vsol']; ?>
&v1=0"><img src="../imagenes/boton_modificar_azul.png" border="0"></a></td>
        <!-- <?php endif; ?> -->
        <?php if ($this->_tpl_vars['vopc'] == 4): ?>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" name="accion" value="Guardar"></td> 
        <?php endif; ?> 
        <td class="cnt"><a href="p_pclaves.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
    </table>

<!-- 	<?php if ($this->_tpl_vars['vopc'] == 1): ?> 
	<td class="cnt"><input type="button" name="Motit" value="Modificar"
	    onclick="location.href='p_pclaves.php?vopc=4&vsol=<?php echo $this->_tpl_vars['vsol']; ?>
&v1=0'"></td>
	<?php endif; ?> 
	
	<?php if ($this->_tpl_vars['vopc'] == 4): ?> 
	 <td class="cnt"><input type="submit" name="accion" value="Guardar"> 
	<?php endif; ?> 
	<td class="cnt"><input type="reset" name="Cancelar" value="Cancelar"
	    onclick="location.href='p_pclaves.php'"></td>
	<td class="cnt"><input type="button" name="Salir" value="Salir"
	    onclick="location.href='index1.php'"></td>	--> 

    </div>  
    </form>


  </body>
</html>

