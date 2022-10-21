<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:24:08
  from '\var\www\apl\sipi\templates\b_genbole.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634eef489920f1_15719388',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '077e4b7d52c890b722f27744d047e7f867ad6e1e' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\b_genbole.tpl',
      1 => 1576780388,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634eef489920f1_15719388 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <?php echo '<script'; ?>
 type="text/javascript" src="../include/js/tabs/tabpane.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 language="javascript" src="../include/cal2.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 language="javascript" src="../include/cal_conf2.js"><?php echo '</script'; ?>
>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<div align="center">

<!-- <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
  <form name="forboletin1" id="forboletin1" action="b_genbol.php?vopc=4" method="post">
<?php }?>-->
<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 5) {?>
  <form name="forboletin1" id="forboletin1" action="b_genbole.php?vopc=4" method="post">
<?php }?> 
  <input type='hidden' name='nconex' value='<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
'>
  <table width="340">
  <tr> 
    <tr>
     <br >
     <br >
     <br >
     <br >
      <td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
         <input type="text" name="nbol" size="3" maxlength="3" >
       <!-- <input type="text" name="nbol" size="3" maxlength="3" value='<?php echo $_smarty_tpl->tpl_vars['nbol']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" >&nbsp;&nbsp; -->
      </td>	

        <td class="cnt">
          <input type="image" src="../imagenes/boletin.png" width="48" height="35" value="Generar Boletin">Generar Boletin</td>
      <!--  </form> -->
  
      </td>
    </tr>
  </tr>
  </table>

<!--<form name="forboletin2" id="forboletin2" enctype="multipart/form-data" action="b_genbol.php?vopc=2" method="POST" onsubmit='return pregunta();'> -->
  <br >
  <br >
  <table width="200">
   <tr>
     <td class="cnt"><a href="b_genbole.php?vopc=5"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
     <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
  </table>
  </td>
  </tr>
  </table>
  <br >
  <br >
  <br >
  <br >
  <br >
      </form>
</div>  
&nbsp;
</body>
</html>
<?php }
}
