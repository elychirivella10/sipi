<?php
/* Smarty version 3.1.47, created on 2022-10-17 18:58:27
  from '\var\www\apl\sipi\templates\m_evelote.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d89b3658085_42270702',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ead09947cf083683536957fae4d73e836f312c47' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_evelote.tpl',
      1 => 1365521507,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d89b3658085_42270702 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<html>
<head>
   <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">
  
<div align="center">
<form name="forlotes" action="m_evelote1.php" method="post">
   <input type="hidden" name="vsola" value='<?php echo $_smarty_tpl->tpl_vars['vsola']->value;?>
'>
   <input type="hidden" name="vsolb" value='<?php echo $_smarty_tpl->tpl_vars['vsolb']->value;?>
'>
   <input type="hidden" name="role" value='<?php echo $_smarty_tpl->tpl_vars['role']->value;?>
'>
   <input type="hidden" name="usuario" value='<?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
'>
  
   <table cellspacing="1" border="1">
   <tr>
     <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
	   <td class="der-color">
	      <input type="text" name="vsol1" size="3" maxlength="4" value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol2)" 
		    onchange="Rellena(document.forlotes.vsol1,4);document.forlotes.vsoli1.value=this.value;">-
		   <input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vsol3)" 
		    onchange="Rellena(document.forlotes.vsol2,6);document.forlotes.vsoli2.value=this.value;">
		hasta:
         <input type="text" name="vsol3" size="3" maxlength="4" value='<?php echo $_smarty_tpl->tpl_vars['vsol3']->value;?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlotes.vsol4)" 
          onchange="Rellena(document.forlotes.vsol3,4);document.forlotes.vsoli3.value=this.value;">-
		   <input type="text" name="vsol4" size="6" maxlength="6" value='<?php echo $_smarty_tpl->tpl_vars['vsol4']->value;?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vbol)" 
		    onchange="Rellena(document.forlotes.vsol4,6);document.forlotes.vsoli4.value=this.value;">
		<td>
	  </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color" >
        <input type="text" name="input2" value='<?php echo $_smarty_tpl->tpl_vars['evento_id']->value;?>
' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.evento_id)" onchange="valagente(document.forlotes.input2,document.forlotes.evento_id)">-
        <select size="1" name="evento_id" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayevento']->value,'selected'=>$_smarty_tpl->tpl_vars['evento_id']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri']->value),$_smarty_tpl);?>

        </select>
        <!-- <select size='1' name='evento_id'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayevento']->value,'selected'=>$_smarty_tpl->tpl_vars['evento_id']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri']->value),$_smarty_tpl);?>

        </select> -->
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color" >
        <input type="text" name="input1" value='<?php echo $_smarty_tpl->tpl_vars['est_id1']->value;?>
' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.est_id1)" onchange="valagente(document.forlotes.input1,document.forlotes.est_id1)">-
        <select size='1' name='est_id1' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onchange="this.form.input1.value=this.options[this.selectedIndex].value">      
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayest1']->value,'selected'=>$_smarty_tpl->tpl_vars['est_id1']->value,'output'=>$_smarty_tpl->tpl_vars['arraynom1']->value),$_smarty_tpl);?>

        </select>
        <!-- <select size='1' name='est_id1' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayest1']->value,'selected'=>$_smarty_tpl->tpl_vars['est_id1']->value,'output'=>$_smarty_tpl->tpl_vars['arraynom1']->value),$_smarty_tpl);?>

        </select> -->
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color" >
        <input type="text" name="input3" value='<?php echo $_smarty_tpl->tpl_vars['est_id2']->value;?>
' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.est_id2)" onchange="valagente(document.forlotes.input3,document.forlotes.est_id2)" >-
        <select size='1' name='est_id2' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onchange="this.form.input3.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayest2']->value,'selected'=>$_smarty_tpl->tpl_vars['est_id2']->value,'output'=>$_smarty_tpl->tpl_vars['arraynom2']->value),$_smarty_tpl);?>

        </select>
        <!-- <select size='1' name='est_id2' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayest2']->value,'selected'=>$_smarty_tpl->tpl_vars['est_id2']->value,'output'=>$_smarty_tpl->tpl_vars['arraynom2']->value),$_smarty_tpl);?>

        </select> -->
      </td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo5']->value;?>
</td>
	    <td class="der-color">
	     <input type="text" name="vuser" size="10" maxlength="10" value='<?php echo $_smarty_tpl->tpl_vars['vuser']->value;?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
'>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color">
        <input type='text' name='fechat1' size="10" maxlength="10" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fechat1']->value,"%d/%m/%G");?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onChange="valFecha(document.forlotes.fechat1)">
        hasta:
        <input type='text' name='fechat2' size="10" maxlength="10" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fechat2']->value,"%d/%m/%G");?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onChange="valFecha(document.forlotes.fechat2)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
      <td class="der-color">
        <input type='text' name='fechaeven' size="10" maxlength="10" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fechaeven']->value,"%d/%m/%G");?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onChange="valFecha(document.forlotes.fechaeven)">
      </td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</td>
	    <td class="der-color">
	     <input type="text" name="vdoc" size="10" maxlength="10" value='<?php echo $_smarty_tpl->tpl_vars['vdoc']->value;?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
'>
      </td>
    </tr>
   </tr>
   </table>
   &nbsp;
   Datos Adicionales para Actualizar o Cargar:
   <table cellspacing="1" border="1">	
   <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo9']->value;?>
</td>
      <td class="der-color" >
        <input type="text" name="input4" value='<?php echo $_smarty_tpl->tpl_vars['evento2_id']->value;?>
' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forlotes.evento2_id)" onchange="valagente(document.forlotes.input4,document.forlotes.evento2_id)">-
        <select size="1" name="evento2_id" onchange="this.form.input4.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayevento']->value,'selected'=>$_smarty_tpl->tpl_vars['evento2_id']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri']->value),$_smarty_tpl);?>

        </select>
        <!-- <select size='1' name='evento2_id'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayevento']->value,'selected'=>$_smarty_tpl->tpl_vars['evento2_id']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri']->value),$_smarty_tpl);?>

        </select> -->
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo10']->value;?>
</td>
      <td class="der-color">
        <input type='text' name='fechapub' size="10" maxlength="10" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fechapub']->value,"%d/%m/%G");?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onChange="valFecha(document.forlotes.fechapub)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo11']->value;?>
</td>
      <td class="der-color">
        <input type='text' name='fechaven' size="10" maxlength="10" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fechaven']->value,"%d/%m/%G");?>
' '<?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
' onChange="valFecha(document.forlotes.fechaven)">
      </td>
    </tr>
   <tr>
   </table>
   &nbsp;
   <table width="200">
   <tr>
     <tr>
       <td class="cnt"><input type="image" src="../imagenes/boton_continuar_azul.png"></td> 
       <td class="cnt"><a href="m_evelote.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
<?php }
}
