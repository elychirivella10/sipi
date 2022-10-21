<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:28:46
  from '\var\www\apl\sipi\templates\m_ev30bol.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef05e23da66_54843859',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60f32d7e8a8ae9e955fb9a4f3fee5d9f174839f3' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_ev30bol.tpl',
      1 => 1387809289,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef05e23da66_54843859 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">
<br>
<form name="forcaduca" action="m_act30bol.php?vopc=2" method="POST">
  <div align="center">

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" value='<?php echo $_smarty_tpl->tpl_vars['boletin']->value;?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forcaduca.actualizar)">
      </td>
    </tr>   
  </table></center>
  <br><br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="actualizar" src="../imagenes/boton_procesar_azul.png"></td>
      <td class="cnt"><a href="m_ev30bol.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>
<?php }
}
