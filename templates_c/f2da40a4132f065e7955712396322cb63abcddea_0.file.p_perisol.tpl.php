<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:47:03
  from '\var\www\apl\sipi\templates\p_perisol.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef4a748a5a2_15476315',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f2da40a4132f065e7955712396322cb63abcddea' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_perisol.tpl',
      1 => 1610892020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef4a748a5a2_15476315 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<form name="forcaduca" action="p_perpusol.php?vopc=2" method="POST">
  <div align="center">

  <br><br>
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
      <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>
 <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcaduca.vsol2)" onchange="Rellena(document.forcaduca.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcaduca.vsol1h)" onchange="Rellena(document.forcaduca.vsol2,6)"><?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcaduca.vsol2h)" onchange="Rellena(document.forcaduca.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcaduca.fecpub)" onchange="Rellena(document.forcaduca.vsol2h,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayestatus']->value,'selected'=>$_smarty_tpl->tpl_vars['estatus']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri1']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 
  </table></center>
  <br><br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="actualizar" src="../imagenes/boton_procesar_azul.png"></td>
      <td class="cnt"><a href="p_perisol.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br>

</body>
</html>
<?php }
}
