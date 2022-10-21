<?php /* Smarty version 2.6.8, created on 2020-10-29 13:23:08
         compiled from p_devoluci_mod.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <div align="center">
  <br>
    <form name="formarcas1" action="p_devoluci_mod.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['solicitud1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['solicitud2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
		<!--             <input type=<?php echo $this->_tpl_vars['submitbutton']; ?>
 name='submit' value='Buscar'></td> --> 
    </form>			  
    <form name="formarcas2" action="p_devoluci_mod.php?vopc=3" method="post" onsubmit='return pregunta();'>
    	    <td><?php echo $this->_tpl_vars['espacios']; ?>
</td>
	    <td class="izq5-color"><?php echo $this->_tpl_vars['lfechaevent']; ?>
</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" value='<?php echo $this->_tpl_vars['vfec']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td></tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechasolic']; ?>
</td>
	    <td class="der-color"><input size="10" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
   <?php if (( $this->_tpl_vars['vmod'] == 'G' || $this->_tpl_vars['vmod'] == 'M' )): ?>
	        <td class="der-color" rowspan="4" align="center" valign="top">
                <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
                <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="110"></td>
	    <?php endif; ?>    
	</tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lnombre']; ?>
</td>
	    <td class="der-color"><input size="63" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td>
	</tr>
	<tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['lmodal']; ?>
</td>
      <td class="der-color">
        <input size="20" name="vmod" '<?php echo $this->_tpl_vars['vmodo']; ?>
' value='<?php echo $this->_tpl_vars['vmodal']; ?>
'></td></tr> 
      </table>
      <?php if ($this->_tpl_vars['vopc'] != 0): ?>
      <H3><?php echo $this->_tpl_vars['lcausadev']; ?>
</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][0]; ?>
</td><td class="der-color"><input type="checkbox" name="causa1" <?php echo $this->_tpl_vars['ccausa1']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][0]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][1]; ?>
</td><td class="der-color"><input type="checkbox" name="causa2" <?php echo $this->_tpl_vars['ccausa2']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][1]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][2]; ?>
</td><td class="der-color"><input type="checkbox" name="causa3" <?php echo $this->_tpl_vars['ccausa3']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][2]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][3]; ?>
</td><td class="der-color"><input type="checkbox" name="causa4" <?php echo $this->_tpl_vars['ccausa4']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][3]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][4]; ?>
</td><td class="der-color"><input type="checkbox" name="causa5" <?php echo $this->_tpl_vars['ccausa5']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][4]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][5]; ?>
</td><td class="der-color"><input type="checkbox" name="causa6" <?php echo $this->_tpl_vars['ccausa6']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][5]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][6]; ?>
</td><td class="der-color"><input type="checkbox" name="causa7" <?php echo $this->_tpl_vars['ccausa7']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][6]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][7]; ?>
</td><td class="der-color"><input type="checkbox" name="causa8" <?php echo $this->_tpl_vars['ccausa8']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][7]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][8]; ?>
</td><td class="der-color"><input type="checkbox" name="causa9" <?php echo $this->_tpl_vars['ccausa9']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][8]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][9]; ?>
</td><td class="der-color"><input type="checkbox" name="causa10" <?php echo $this->_tpl_vars['ccausa10']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][9]; ?>
</td></tr><tr>
<?php if ($this->_tpl_vars['descausa'][10] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][10]; ?>
</td><td class="der-color"><input type="checkbox" name="causa11" <?php echo $this->_tpl_vars['ccausa11']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][10]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][11] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][11]; ?>
</td><td class="der-color"><input type="checkbox" name="causa12" <?php echo $this->_tpl_vars['ccausa12']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][11]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][12] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][12]; ?>
</td><td class="der-color"><input type="checkbox" name="causa13" <?php echo $this->_tpl_vars['ccausa13']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][12]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][13] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][13]; ?>
</td><td class="der-color"><input type="checkbox" name="causa14" <?php echo $this->_tpl_vars['ccausa14']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][13]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][14] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][14]; ?>
</td><td class="der-color"><input type="checkbox" name="causa15" <?php echo $this->_tpl_vars['ccausa15']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][14]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][15] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][15]; ?>
</td><td class="der-color"><input type="checkbox" name="causa16" <?php echo $this->_tpl_vars['ccausa16']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][15]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][16] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][16]; ?>
</td><td class="der-color"><input type="checkbox" name="causa17" <?php echo $this->_tpl_vars['ccausa17']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][16]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][17] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][17]; ?>
</td><td class="der-color"><input type="checkbox" name="causa18" <?php echo $this->_tpl_vars['ccausa18']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][17]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][18] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][18]; ?>
</td><td class="der-color"><input type="checkbox" name="causa19" <?php echo $this->_tpl_vars['ccausa19']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][18]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][19] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][19]; ?>
</td><td class="der-color"><input type="checkbox" name="causa20" <?php echo $this->_tpl_vars['ccausa20']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][19]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][20] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][20]; ?>
</td><td class="der-color"><input type="checkbox" name="causa21" <?php echo $this->_tpl_vars['ccausa21']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][20]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][21] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][21]; ?>
</td><td class="der-color"><input type="checkbox" name="causa22" <?php echo $this->_tpl_vars['ccausa22']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][21]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][22] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][22]; ?>
</td><td class="der-color"><input type="checkbox" name="causa23" <?php echo $this->_tpl_vars['ccausa23']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][22]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][23] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][23]; ?>
</td><td class="der-color"><input type="checkbox" name="causa24" <?php echo $this->_tpl_vars['ccausa24']; ?>
><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][23]; ?>
</td></tr><tr><?php endif; ?>
	</tr>
	</table>
	<table cellspacing="1" border="1">
	<tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['lotro']; ?>
</td><td class="der-color"><input size="90" type="text" name="otro" value='<?php echo $this->_tpl_vars['otro']; ?>
'><td>
	</tr>
	</table>
	<table cellspacing="1" border="1">
	<tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['lboletin']; ?>
</td><td class="der-color"><input size="4" type="text" name="vbol" value='<?php echo $this->_tpl_vars['vbol']; ?>
'><td>
	</tr>
	</table>
	
     </table>
     <?php endif; ?>
     &nbsp;
     <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'>
     <input type="hidden" name="nderec" value='<?php echo $this->_tpl_vars['nderec']; ?>
'>

    <table width="240">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="p_devoluci_mod.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
    </table></center>
    <br><br><br><br><br><br><br><br><br>
    </form>
  </div>  
  </body>
</html>
