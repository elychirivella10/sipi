<?php /* Smarty version 2.6.8, created on 2022-08-17 11:23:10
         compiled from m_escritos_ing.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <!-- <H3><?php echo $this->_tpl_vars['subtitulo']; ?>
</H3> -->
  
  <div align="center">
    <form name="formarcas1" action="m_escritos_ing.php?vopc=1" method="post">
     <table>
        <tr><td class="izq5-color">N&uacute;mero de Escrito:</td>
            <td class="der-color"><input type="text" name="vesc1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vesc1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vesc2)" onchange="Rellena(document.formarcas1.vesc1,4)">-<input type="text" name="vesc2" size="6" maxlength="6" 
	        value='<?php echo $this->_tpl_vars['vesc2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit1)" onchange="Rellena(document.formarcas1.vesc2,6)">
                <td class="cnt"><?php if ($this->_tpl_vars['vopc'] == 0): ?><input name='submit1' type='image' src="../imagenes/page_add.png" width="28" height="24" value="Buscar">  Ingresar<?php endif; ?></td></tr>
    </form>
    </table>
      &nbsp; 
    <form name="formarcas2" action="m_escritos_ing.php?vopc=2" method="post">
      <input type="hidden" name="vesc" value='<?php echo $this->_tpl_vars['vesc']; ?>
'>
      <input type="hidden" name="vesc1" value='<?php echo $this->_tpl_vars['vesc1']; ?>
'>
      <input type="hidden" name="vesc2" value='<?php echo $this->_tpl_vars['vesc2']; ?>
'>
      <table cellspacing="1">	
        <tr><td class="izq5-color">N&uacute;mero de Solicitud:</td>
            <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol2)" onchange="Rellena(document.formarcas2.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit2)" onchange="Rellena(document.formarcas2.vsol2,6)">
		<?php if ($this->_tpl_vars['vopc'] == 1): ?><input name='submit2' type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar <?php endif; ?></td> 
    </form>
    <form name="formarcas3" action="m_escritos_ing.php?vopc=3" method="post">
        <input type="hidden" name="vesc" value='<?php echo $this->_tpl_vars['vesc']; ?>
'>
        <td>&nbsp;    &nbsp;    &nbsp;    &nbsp;</td>
        <td class="izq5-color">N&uacute;mero de Registro:</td>
                <td class="der-color"><input type="text" name="vreg1" value='<?php echo $this->_tpl_vars['vreg1']; ?>
' size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['vreg1']; ?>
' <?php echo $this->_tpl_vars['vmodo1']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas3.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                      <input type="text" name="vreg2" value='<?php echo $this->_tpl_vars['vreg2']; ?>
' size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vreg2']; ?>
' <?php echo $this->_tpl_vars['vmodo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas3.submit3)" onchange="Rellena(document.formarcas3.vreg2,6)">
		<?php if ($this->_tpl_vars['vopc'] == 1): ?><input name='submit3' type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar <?php endif; ?></td></tr>
        </table>
    </form>
    <?php if ($this->_tpl_vars['vopc'] == 1): ?>
    <form name="formarcas4" action="m_escritos_ing.php?vopc=4" method="post">
        <table>
        <input type="hidden" name="vesc" value='<?php echo $this->_tpl_vars['vesc']; ?>
'>
        <input type="hidden" name="vesc1" value='<?php echo $this->_tpl_vars['vesc1']; ?>
'>
        <input type="hidden" name="vesc2" value='<?php echo $this->_tpl_vars['vesc2']; ?>
'>
        <tr><td class="izq5-color">Sin Identificaci&oacute;n:</td>
               <td class="der-color"><input name='submit4' type='image' src="../imagenes/search_f2_no.png" width="28" height="24" value="Buscar">  No Buscar  </td></tr>

    </form>
    </table>
    <?php endif; ?>
    &nbsp;
    &nbsp;
    <table>
    <form name="formarcas5" action="m_escritos_ing.php?vopc=5" method="post">
        <input type="hidden" name="vopcant" value='<?php echo $this->_tpl_vars['vopcant']; ?>
'> 
        <input type="hidden" name="vesc" value='<?php echo $this->_tpl_vars['vesc']; ?>
'>
        <input type="hidden" name="vesc1" value='<?php echo $this->_tpl_vars['vesc1']; ?>
'>
        <input type="hidden" name="vesc2" value='<?php echo $this->_tpl_vars['vesc2']; ?>
'>
        <input type="hidden" name="vsol1" value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
        <input type="hidden" name="vsol2" value='<?php echo $this->_tpl_vars['vsol2']; ?>
'>
        <input type="hidden" name="vreg1" value='<?php echo $this->_tpl_vars['vreg1']; ?>
'>
        <input type="hidden" name="vreg2" value='<?php echo $this->_tpl_vars['vreg2']; ?>
'>
	<tr><td class="izq-color">Nombre:</td>
	    <td class="der-color"><input size="88" type="text" name="vnom" maxlength="500" value='<?php echo $this->_tpl_vars['vnom']; ?>
' <?php echo $this->_tpl_vars['vmodo3']; ?>
>   </td></tr>
	<tr><td class="izq-color">Clase:</td>
	    <td class="der-color">
                        <?php if ($this->_tpl_vars['vopc'] > 1 && $this->_tpl_vars['vopc'] == 4): ?> 
                        <select size=1 name="vindcla" onchange= "this.form.vindcla.value=this.options[this.selectedIndex].value">
                            <option value='I'>Internacional</option> 
                            <option value='N'>Nacional</option>
	                </select>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['vopc'] > 1 && $this->_tpl_vars['vopc'] <> 4): ?> 
                            <input type="hidden" name="vindcla" value='<?php echo $this->_tpl_vars['vindcla']; ?>
'> 
                            <?php if ($this->_tpl_vars['vindcla'] == 'I'): ?> <input size="10" type="text" name="vindclavis" value='Internacional' <?php echo $this->_tpl_vars['vmodo3']; ?>
> <?php endif; ?>
                            <?php if ($this->_tpl_vars['vindcla'] == 'N'): ?> <input size="10" type="text" name="vindclavis" value='Nacional' <?php echo $this->_tpl_vars['vmodo3']; ?>
> <?php endif; ?>
                        <?php endif; ?>
	                <input size="2" type="text" name="vcla" value='<?php echo $this->_tpl_vars['vcla']; ?>
' maxlength="2" <?php echo $this->_tpl_vars['vmodo3']; ?>
>
            </td></tr> 
        <tr><td class="izq-color">Fecha:</td>
            <td class="der-color"><input size="9" <?php echo $this->_tpl_vars['vmodo2']; ?>
 type="text" name="vfecesc"  value='<?php echo $this->_tpl_vars['vfecesc']; ?>
' onkeyup="checkLength(event,this,10,document.formarcas5.vtipesc)"
	    onchange="valFecha(this,document.formarcas5.vsol1)"><td> </tr>
	<tr><td class="izq-color">Tipo de Escrito:</td>
            <td class="der-color"><input size="6" type="text" name="vtipesc" value='<?php echo $this->_tpl_vars['vtipesc']; ?>
' <?php echo $this->_tpl_vars['vmodo2']; ?>
 maxlength="3" onchange="valagente(document.formarcas5.vtipesc,document.formarcas5.vnomesc)">
                <select size=1 name="vnomesc" value='<?php echo $this->_tpl_vars['vnomesc']; ?>
' onchange= "this.form.vtipesc.value=this.options[this.selectedIndex].value; this.form.vnomesc.value='<?php echo $this->_tpl_vars['vnomescnew'][$this->_tpl_vars['key']]; ?>
'">
                <?php $_from = $this->_tpl_vars['vcodescnew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                     <?php if ($this->_tpl_vars['vnomescnew'][$this->_tpl_vars['key']] == $this->_tpl_vars['vnomesc']): ?> <option value='<?php echo $this->_tpl_vars['vcodescnew'][$this->_tpl_vars['key']]; ?>
' selected><?php echo $this->_tpl_vars['vnomescnew'][$this->_tpl_vars['key']]; ?>
</option> 
                     <?php else: ?> <option value='<?php echo $this->_tpl_vars['vcodescnew'][$this->_tpl_vars['key']]; ?>
'><?php echo $this->_tpl_vars['vnomescnew'][$this->_tpl_vars['key']]; ?>
</option> <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
	        </select></td></tr>
        <tr><td class="izq-color">N&uacute;mero de Boletin:</td>
	    <td class="der-color"><input size="3" type="text" <?php echo $this->_tpl_vars['vmodo2']; ?>
 name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' maxlength="3" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,3,document.formarcas5.vcom)"></td></tr>
        <tr><td class="izq-color">Comentario del Escrito:</td>
	    <td class="der-color"><textarea rows="2" name="vcom" <?php echo $this->_tpl_vars['vmodo2']; ?>
 cols="75" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['vcom']; ?>
</textarea></td></tr>
	<tr><td class="izq-color">C&oacute;digo del Agente:</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" value='<?php echo $this->_tpl_vars['vcodagen']; ?>
' <?php echo $this->_tpl_vars['vmodo2']; ?>
 maxlength="6" onchange="valagente(document.formarcas5.vcodagen,document.formarcas5.vnomagen);">	    
	    <select size=1 name="vnomagen" value='<?php echo $this->_tpl_vars['vnomagen']; ?>
' onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
                <?php $_from = $this->_tpl_vars['vcodagenew']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                     <?php if ($this->_tpl_vars['vnomagenew'][$this->_tpl_vars['key']] == $this->_tpl_vars['vnomagen']): ?> <option value='<?php echo $this->_tpl_vars['vcodagenew'][$this->_tpl_vars['key']]; ?>
' selected><?php echo $this->_tpl_vars['vnomagenew'][$this->_tpl_vars['key']]; ?>
</option> 
                     <?php else: ?> <option value='<?php echo $this->_tpl_vars['vcodagenew'][$this->_tpl_vars['key']]; ?>
'><?php echo $this->_tpl_vars['vnomagenew'][$this->_tpl_vars['key']]; ?>
</option> <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
	    </select>
            </td></tr> 
	    <tr><td class="izq-color">Tramitante:</td>
	    <td class="der-color"><input size="88" type="text" name="vtra" value='<?php echo $this->_tpl_vars['vtra']; ?>
' maxlength="120" <?php echo $this->_tpl_vars['vmodo2']; ?>
 onchange="this.value=this.value.toUpperCase()"></td></tr>      
         <tr><td class="izq-color">Motivos del Defecto:</td>
             <td><input type="checkbox" name="vmot1" <?php if ($this->_tpl_vars['vmot1']): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['vmodo2']; ?>
><font face="Arial" color="#000000" size=2>Faltan Timbres Fiscales</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot2" <?php if ($this->_tpl_vars['vmot2']): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['vmodo2']; ?>
><font face="Arial" color="#000000" size=2>Falta la Firma del interesado</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot3" <?php if ($this->_tpl_vars['vmot3']): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['vmodo2']; ?>
><font face="Arial" color="#000000" size=2>Falta Nro. de Inscripci&oacute;n o el mismo no coincide</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot4" <?php if ($this->_tpl_vars['vmot4']): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['vmodo2']; ?>
><font face="Arial" color="#000000" size=2>El nombre de la marca no coincide con el registrado en el sistema</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot5" <?php if ($this->_tpl_vars['vmot5']): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['vmodo2']; ?>
><font face="Arial" color="#000000" size=2>Presentado en Fotocopia</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot6" <?php if ($this->_tpl_vars['vmot6']): ?>checked<?php endif; ?> <?php echo $this->_tpl_vars['vmodo2']; ?>
><font face="Arial" color="#000000" size=2>No existen datos asociados al evento</font></td></tr> 
         <tr><td class="izq-color">Otro Motivo:</td>
	     <td class="der-color"><input size="88" type="text" name="vomot" value='<?php echo $this->_tpl_vars['vomot']; ?>
' maxlength="200" <?php echo $this->_tpl_vars['vmodo2']; ?>
></td>
         </tr> 
      </table>
      &nbsp;
     <table width="235">
        <tr>
       <?php if ($this->_tpl_vars['vopc'] > 1): ?><td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td><?php endif; ?> 
       <td class="cnt"><a href="m_escritos_ing.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar 	</td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>		Salir 	</td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


