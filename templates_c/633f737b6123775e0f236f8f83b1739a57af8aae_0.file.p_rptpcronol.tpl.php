<?php
/* Smarty version 3.1.47, created on 2022-10-18 18:16:04
  from '\var\www\apl\sipi\templates\p_rptpcronol.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ed144eeed42_47445759',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '633f737b6123775e0f236f8f83b1739a57af8aae' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_rptpcronol.tpl',
      1 => 1387398906,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ed144eeed42_47445759 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<!-- <h3> <?php echo $_smarty_tpl->tpl_vars['H3']->value;?>
</h3> -->

<form name="forcronol" action="p_rptcronol.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
'>
  <div align="center">

  <br><br>
  <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcronol.vsol2)" onchange="Rellena(document.forcronol.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcronol.submit)" onchange="Rellena(document.forcronol.vsol2,6)">
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color">
       <input type="text" name="vreg1" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forcronol.vreg2)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcronol.submit)" onchange="Rellena(document.forcronol.vreg2,6)">   
      </td>
    </tr>
   
  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_rptpcronol.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br>

  </div>  
</form>

</body>
</html>
<?php }
}
