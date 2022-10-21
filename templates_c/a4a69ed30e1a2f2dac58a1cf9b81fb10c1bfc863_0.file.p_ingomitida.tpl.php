<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:23:37
  from '\var\www\apl\sipi\templates\p_ingomitida.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d73791cdf99_06069119',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a4a69ed30e1a2f2dac58a1cf9b81fb10c1bfc863' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_ingomitida.tpl',
      1 => 1569025422,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d73791cdf99_06069119 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php echo '<script'; ?>
 language="javascript" src="../include/cal2.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 language="javascript" src="../include/cal_conf2.js"><?php echo '</script'; ?>
>

</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

 <form name="formarcas2" action="p_ingomitida.php?vopc=2" method="post">
 <div align="center">
 <br>
 
  <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol2)" onchange="Rellena(document.formarcas2.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vsol2,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['fecha_solic']->value;?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.buscar)" onchange="valFecha(this,document.formarcas2.buscar)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
   
  </table><!--</font>--></center>
	<br>
 </form>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_ingomitida.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
<br><br><br><br><br><br><br><br><br>
</body>
</html>
<?php }
}
