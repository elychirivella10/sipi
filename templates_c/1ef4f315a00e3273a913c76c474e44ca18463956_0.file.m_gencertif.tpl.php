<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:47:18
  from '\var\www\apl\sipi\templates\m_gencertif.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef4b62a3383_41021781',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ef4f315a00e3273a913c76c474e44ca18463956' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_gencertif.tpl',
      1 => 1519310872,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef4b62a3383_41021781 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<form name="forobscon" action="m_gencertif.php?vopc=2" method="POST">
 <div align="center">
<br>

<table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
      <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>
 
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forobscon.vsol2)" onchange="Rellena(document.forobscon.vsol1,2);valagente(document.forobscon.vsol1,document.forobscon.vsol1h)" onblur="valagente(document.forobscon.vsol1,document.forobscon.vsol1h)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forobscon.vsol1h)" onchange="Rellena(document.forobscon.vsol2,6)"onblur="valagente(document.forobscon.vsol2,document.forobscon.vsol2h)">
      <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forobscon.vsol2h)" onchange="Rellena(document.forobscon.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forobscon.boletin)" onchange="Rellena(document.forobscon.vsol2h,6)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>

  </table><!--</font>--></center>
  <br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" value="Actualizar"></td>
      <td class="cnt"><a href="m_gencertif.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>
<?php }
}
