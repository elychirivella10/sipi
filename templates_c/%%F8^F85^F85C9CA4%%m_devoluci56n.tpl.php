<?php /* Smarty version 2.6.8, created on 2020-10-20 10:25:45
         compiled from m_devoluci56n.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  <br>
    
  <div align="center">
    <form name="formarcas1" action="m_devoluci56n.php?vopc=1" method="post">
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
    <form name="formarcas2" action="m_devoluci56n.php?vopc=3" method="post" onsubmit='return pregunta();'>
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
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lclase']; ?>
</td>
	    <td class="der-color"><input size="1" type="text" name="vcla" value='<?php echo $this->_tpl_vars['clase']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="14" type="text" name="vindcla" value='<?php echo $this->_tpl_vars['ind_claseni']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	<tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['lmodal']; ?>
</td>
      <td class="der-color">
        <input size="12" name="vmod" '<?php echo $this->_tpl_vars['vmodo']; ?>
' value='<?php echo $this->_tpl_vars['vmodal']; ?>
'></td></tr> 
      </table>
      <?php if ($this->_tpl_vars['vopc'] != 0): ?>
      <H3><?php echo $this->_tpl_vars['lcausadev']; ?>
</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][0]; ?>
</td><td class="der-color"><td><td class="der-color"><b><?php echo $this->_tpl_vars['descausa'][0]; ?>
</b> <br> <input type="checkbox" name="subcausa1"><?php echo $this->_tpl_vars['dessubcausa'][0]; ?>
 <br> <input type="checkbox" name="subcausa2"><?php echo $this->_tpl_vars['dessubcausa'][1]; ?>
 <br> <input type="checkbox" name="subcausa3"><?php echo $this->_tpl_vars['dessubcausa'][2]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][1]; ?>
</td><td class="der-color"><td><td class="der-color"><b><?php echo $this->_tpl_vars['descausa'][1]; ?>
</b> <br> <input type="checkbox" name="subcausa4"><?php echo $this->_tpl_vars['dessubcausa'][3]; ?>
 <br> <input type="checkbox" name="subcausa5"><?php echo $this->_tpl_vars['dessubcausa'][4]; ?>
 </td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][2]; ?>
</td><td class="der-color"><td><td class="der-color"><b><?php echo $this->_tpl_vars['descausa'][2]; ?>
</b> <br> <input type="checkbox" name="subcausa6"><?php echo $this->_tpl_vars['dessubcausa'][5]; ?>
 <br> <input type="checkbox" name="subcausa7"><?php echo $this->_tpl_vars['dessubcausa'][6]; ?>
 <br> <input type="checkbox" name="subcausa8"><?php echo $this->_tpl_vars['dessubcausa'][7]; ?>
 </td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][3]; ?>
</td><td class="der-color"><input type="checkbox" name="causa4"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][3]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][4]; ?>
</td><td class="der-color"><input type="checkbox" name="causa5"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][4]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][5]; ?>
</td><td class="der-color"><input type="checkbox" name="causa6"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][5]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][6]; ?>
</td><td class="der-color"><input type="checkbox" name="causa7"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][6]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][7]; ?>
</td><td class="der-color"><input type="checkbox" name="causa8"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][7]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][8]; ?>
</td><td class="der-color"><input type="checkbox" name="causa9"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][8]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][9]; ?>
</td><td class="der-color"><input type="checkbox" name="causa10"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][9]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][10]; ?>
</td><td class="der-color"><input type="checkbox" name="causa11"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][10]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][11]; ?>
</td><td class="der-color"><input type="checkbox" name="causa12"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][11]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][12]; ?>
</td><td class="der-color"><td><td class="der-color"><b><?php echo $this->_tpl_vars['descausa'][12]; ?>
</b> <br> <input type="checkbox" name="subcausa9"><?php echo $this->_tpl_vars['dessubcausa'][8]; ?>
 <br> <input type="checkbox" name="subcausa10"><?php echo $this->_tpl_vars['dessubcausa'][9]; ?>
 <br> <input type="checkbox" name="subcausa11"><?php echo $this->_tpl_vars['dessubcausa'][10]; ?>
 <br> <input type="checkbox" name="subcausa12"><?php echo $this->_tpl_vars['dessubcausa'][11]; ?>
 <br> <input type="checkbox" name="subcausa13"><?php echo $this->_tpl_vars['dessubcausa'][12]; ?>
 <br> <input type="checkbox" name="subcausa14"><?php echo $this->_tpl_vars['dessubcausa'][13]; ?>
 <br> <input type="checkbox" name="subcausa15"><?php echo $this->_tpl_vars['dessubcausa'][14]; ?>
 <br> <input type="checkbox" name="subcausa16"><?php echo $this->_tpl_vars['dessubcausa'][15]; ?>
 </td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][13]; ?>
</td><td class="der-color"><input type="checkbox" name="causa14"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][13]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][14]; ?>
</td><td class="der-color"><input type="checkbox" name="causa15"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][14]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][15]; ?>
</td><td class="der-color"><input type="checkbox" name="causa16"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][15]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][16]; ?>
</td><td class="der-color"><input type="checkbox" name="causa17"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][16]; ?>
</td>
<?php if ($this->_tpl_vars['descausa'][17] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][17]; ?>
</td><td class="der-color"><input type="checkbox" name="causa18"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][17]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][18] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][18]; ?>
</td><td class="der-color"><input type="checkbox" name="causa19"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][18]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][19] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][19]; ?>
</td><td class="der-color"><input type="checkbox" name="causa20"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][19]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][20] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][20]; ?>
</td><td class="der-color"><input type="checkbox" name="causa21"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][20]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][21] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][21]; ?>
</td><td class="der-color"><input type="checkbox" name="causa22"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][21]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][22] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][22]; ?>
</td><td class="der-color"><input type="checkbox" name="causa23"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][22]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][23] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][23]; ?>
</td><td class="der-color"><input type="checkbox" name="causa24"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][23]; ?>
</td></tr><tr><?php endif; ?>
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['lotro']; ?>
</td><td class="der-color"><input size="90" type="text" name="otro"><td>
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

    <table width="260">
    <tr>
      <td class="der">
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="m_devoluci56n.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../consultamarcas/ver_marcas_fon.php?vnsol=<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
" target="_blank">
       <img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
      </td>
    </tr>
    </table></center>
    </form>
    <br><br><br><br><br>
  </div>  
  </body>
</html>
