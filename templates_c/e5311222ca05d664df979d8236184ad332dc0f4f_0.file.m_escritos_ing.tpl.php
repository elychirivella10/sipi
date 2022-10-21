<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:39:54
  from '\var\www\apl\sipi\templates\m_escritos_ing.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d774a12f5b7_24348077',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5311222ca05d664df979d8236184ad332dc0f4f' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_escritos_ing.tpl',
      1 => 1331758734,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d774a12f5b7_24348077 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">
  
  <!-- <H3><?php echo $_smarty_tpl->tpl_vars['subtitulo']->value;?>
</H3> -->
  
  <div align="center">
    <form name="formarcas1" action="m_escritos_ing.php?vopc=1" method="post">
     <table>
        <tr><td class="izq5-color">N&uacute;mero de Escrito:</td>
            <td class="der-color"><input type="text" name="vesc1" size="3" maxlength="4" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vesc1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vesc2)" onchange="Rellena(document.formarcas1.vesc1,4)">-<input type="text" name="vesc2" size="6" maxlength="6" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vesc2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit1)" onchange="Rellena(document.formarcas1.vesc2,6)">
                <td class="cnt"><?php if ($_smarty_tpl->tpl_vars['vopc']->value == 0) {?><input name='submit1' type='image' src="../imagenes/page_add.png" width="28" height="24" value="Buscar">  Ingresar<?php }?></td></tr>
    </form>
    </table>
      &nbsp; 
    <form name="formarcas2" action="m_escritos_ing.php?vopc=2" method="post">
      <input type="hidden" name="vesc" value='<?php echo $_smarty_tpl->tpl_vars['vesc']->value;?>
'>
      <input type="hidden" name="vesc1" value='<?php echo $_smarty_tpl->tpl_vars['vesc1']->value;?>
'>
      <input type="hidden" name="vesc2" value='<?php echo $_smarty_tpl->tpl_vars['vesc2']->value;?>
'>
      <table cellspacing="1">	
        <tr><td class="izq5-color">N&uacute;mero de Solicitud:</td>
            <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo1']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol2)" onchange="Rellena(document.formarcas2.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo1']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit2)" onchange="Rellena(document.formarcas2.vsol2,6)">
		<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?><input name='submit2' type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar <?php }?></td> 
    </form>
    <form name="formarcas3" action="m_escritos_ing.php?vopc=3" method="post">
        <input type="hidden" name="vesc" value='<?php echo $_smarty_tpl->tpl_vars['vesc']->value;?>
'>
        <td>&nbsp;    &nbsp;    &nbsp;    &nbsp;</td>
        <td class="izq5-color">N&uacute;mero de Registro:</td>
                <td class="der-color"><input type="text" name="vreg1" value='<?php echo $_smarty_tpl->tpl_vars['vreg1']->value;?>
' size="1" maxlength="1" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vreg1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo1']->value;?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas3.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                      <input type="text" name="vreg2" value='<?php echo $_smarty_tpl->tpl_vars['vreg2']->value;?>
' size="6" maxlength="6" 
		value='<?php echo $_smarty_tpl->tpl_vars['vreg2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo1']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas3.submit3)" onchange="Rellena(document.formarcas3.vreg2,6)">
		<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?><input name='submit3' type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar <?php }?></td></tr>
        </table>
    </form>
    <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
    <form name="formarcas4" action="m_escritos_ing.php?vopc=4" method="post">
        <table>
        <input type="hidden" name="vesc" value='<?php echo $_smarty_tpl->tpl_vars['vesc']->value;?>
'>
        <input type="hidden" name="vesc1" value='<?php echo $_smarty_tpl->tpl_vars['vesc1']->value;?>
'>
        <input type="hidden" name="vesc2" value='<?php echo $_smarty_tpl->tpl_vars['vesc2']->value;?>
'>
        <tr><td class="izq5-color">Sin Identificaci&oacute;n:</td>
               <td class="der-color"><input name='submit4' type='image' src="../imagenes/search_f2_no.png" width="28" height="24" value="Buscar">  No Buscar  </td></tr>

    </form>
    </table>
    <?php }?>
    &nbsp;
    &nbsp;
    <table>
    <form name="formarcas5" action="m_escritos_ing.php?vopc=5" method="post">
        <input type="hidden" name="vopcant" value='<?php echo $_smarty_tpl->tpl_vars['vopcant']->value;?>
'> 
        <input type="hidden" name="vesc" value='<?php echo $_smarty_tpl->tpl_vars['vesc']->value;?>
'>
        <input type="hidden" name="vesc1" value='<?php echo $_smarty_tpl->tpl_vars['vesc1']->value;?>
'>
        <input type="hidden" name="vesc2" value='<?php echo $_smarty_tpl->tpl_vars['vesc2']->value;?>
'>
        <input type="hidden" name="vsol1" value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
'>
        <input type="hidden" name="vsol2" value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
'>
        <input type="hidden" name="vreg1" value='<?php echo $_smarty_tpl->tpl_vars['vreg1']->value;?>
'>
        <input type="hidden" name="vreg2" value='<?php echo $_smarty_tpl->tpl_vars['vreg2']->value;?>
'>
	<tr><td class="izq-color">Nombre:</td>
	    <td class="der-color"><input size="88" type="text" name="vnom" maxlength="500" value='<?php echo $_smarty_tpl->tpl_vars['vnom']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo3']->value;?>
>   </td></tr>
	<tr><td class="izq-color">Clase:</td>
	    <td class="der-color">
                        <?php if ($_smarty_tpl->tpl_vars['vopc']->value > 1 && $_smarty_tpl->tpl_vars['vopc']->value == 4) {?> 
                        <select size=1 name="vindcla" onchange= "this.form.vindcla.value=this.options[this.selectedIndex].value">
                            <option value='I'>Internacional</option> 
                            <option value='N'>Nacional</option>
	                </select>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['vopc']->value > 1 && $_smarty_tpl->tpl_vars['vopc']->value <> 4) {?> 
                            <input type="hidden" name="vindcla" value='<?php echo $_smarty_tpl->tpl_vars['vindcla']->value;?>
'> 
                            <?php if ($_smarty_tpl->tpl_vars['vindcla']->value == 'I') {?> <input size="10" type="text" name="vindclavis" value='Internacional' <?php echo $_smarty_tpl->tpl_vars['vmodo3']->value;?>
> <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['vindcla']->value == 'N') {?> <input size="10" type="text" name="vindclavis" value='Nacional' <?php echo $_smarty_tpl->tpl_vars['vmodo3']->value;?>
> <?php }?>
                        <?php }?>
	                <input size="2" type="text" name="vcla" value='<?php echo $_smarty_tpl->tpl_vars['vcla']->value;?>
' maxlength="2" <?php echo $_smarty_tpl->tpl_vars['vmodo3']->value;?>
>
            </td></tr> 
        <tr><td class="izq-color">Fecha:</td>
            <td class="der-color"><input size="9" <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
 type="text" name="vfecesc"  value='<?php echo $_smarty_tpl->tpl_vars['vfecesc']->value;?>
' onkeyup="checkLength(event,this,10,document.formarcas5.vtipesc)"
	    onchange="valFecha(this,document.formarcas5.vsol1)"><td> </tr>
	<tr><td class="izq-color">Tipo de Escrito:</td>
            <td class="der-color"><input size="6" type="text" name="vtipesc" value='<?php echo $_smarty_tpl->tpl_vars['vtipesc']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
 maxlength="3" onchange="valagente(document.formarcas5.vtipesc,document.formarcas5.vnomesc)">
                <select size=1 name="vnomesc" value='<?php echo $_smarty_tpl->tpl_vars['vnomesc']->value;?>
' onchange= "this.form.vtipesc.value=this.options[this.selectedIndex].value; this.form.vnomesc.value='<?php echo $_smarty_tpl->tpl_vars['vnomescnew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
'">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['vcodescnew']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
                     <?php if ($_smarty_tpl->tpl_vars['vnomescnew']->value[$_smarty_tpl->tpl_vars['key']->value] == $_smarty_tpl->tpl_vars['vnomesc']->value) {?> <option value='<?php echo $_smarty_tpl->tpl_vars['vcodescnew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
' selected><?php echo $_smarty_tpl->tpl_vars['vnomescnew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
</option> 
                     <?php } else { ?> <option value='<?php echo $_smarty_tpl->tpl_vars['vcodescnew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
'><?php echo $_smarty_tpl->tpl_vars['vnomescnew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
</option> <?php }?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	        </select></td></tr>
        <tr><td class="izq-color">N&uacute;mero de Boletin:</td>
	    <td class="der-color"><input size="3" type="text" <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
 name="vdoc" value='<?php echo $_smarty_tpl->tpl_vars['vdoc']->value;?>
' maxlength="3" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,3,document.formarcas5.vcom)"></td></tr>
        <tr><td class="izq-color">Comentario del Escrito:</td>
	    <td class="der-color"><textarea rows="2" name="vcom" <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
 cols="75" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['vcom']->value;?>
</textarea></td></tr>
	<tr><td class="izq-color">C&oacute;digo del Agente:</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" value='<?php echo $_smarty_tpl->tpl_vars['vcodagen']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
 maxlength="6" onchange="valagente(document.formarcas5.vcodagen,document.formarcas5.vnomagen);">	    
	    <select size=1 name="vnomagen" value='<?php echo $_smarty_tpl->tpl_vars['vnomagen']->value;?>
' onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['vcodagenew']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
                     <?php if ($_smarty_tpl->tpl_vars['vnomagenew']->value[$_smarty_tpl->tpl_vars['key']->value] == $_smarty_tpl->tpl_vars['vnomagen']->value) {?> <option value='<?php echo $_smarty_tpl->tpl_vars['vcodagenew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
' selected><?php echo $_smarty_tpl->tpl_vars['vnomagenew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
</option> 
                     <?php } else { ?> <option value='<?php echo $_smarty_tpl->tpl_vars['vcodagenew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
'><?php echo $_smarty_tpl->tpl_vars['vnomagenew']->value[$_smarty_tpl->tpl_vars['key']->value];?>
</option> <?php }?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	    </select>
            </td></tr> 
	    <tr><td class="izq-color">Tramitante:</td>
	    <td class="der-color"><input size="88" type="text" name="vtra" value='<?php echo $_smarty_tpl->tpl_vars['vtra']->value;?>
' maxlength="120" <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
 onchange="this.value=this.value.toUpperCase()"></td></tr>      
         <tr><td class="izq-color">Motivos del Defecto:</td>
             <td><input type="checkbox" name="vmot1" <?php if ($_smarty_tpl->tpl_vars['vmot1']->value) {?>checked<?php }?> <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
><font face="Arial" color="#000000" size=2>Faltan Timbres Fiscales</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot2" <?php if ($_smarty_tpl->tpl_vars['vmot2']->value) {?>checked<?php }?> <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
><font face="Arial" color="#000000" size=2>Falta la Firma del interesado</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot3" <?php if ($_smarty_tpl->tpl_vars['vmot3']->value) {?>checked<?php }?> <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
><font face="Arial" color="#000000" size=2>Falta Nro. de Inscripci&oacute;n o el mismo no coincide</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot4" <?php if ($_smarty_tpl->tpl_vars['vmot4']->value) {?>checked<?php }?> <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
><font face="Arial" color="#000000" size=2>El nombre de la marca no coincide con el registrado en el sistema</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot5" <?php if ($_smarty_tpl->tpl_vars['vmot5']->value) {?>checked<?php }?> <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
><font face="Arial" color="#000000" size=2>Presentado en Fotocopia</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot6" <?php if ($_smarty_tpl->tpl_vars['vmot6']->value) {?>checked<?php }?> <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
><font face="Arial" color="#000000" size=2>No existen datos asociados al evento</font></td></tr> 
         <tr><td class="izq-color">Otro Motivo:</td>
	     <td class="der-color"><input size="88" type="text" name="vomot" value='<?php echo $_smarty_tpl->tpl_vars['vomot']->value;?>
' maxlength="200" <?php echo $_smarty_tpl->tpl_vars['vmodo2']->value;?>
></td>
         </tr> 
      </table>
      &nbsp;
     <table width="235">
        <tr>
       <?php if ($_smarty_tpl->tpl_vars['vopc']->value > 1) {?><td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td><?php }?> 
       <td class="cnt"><a href="m_escritos_ing.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar 	</td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>		Salir 	</td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>



<?php }
}
