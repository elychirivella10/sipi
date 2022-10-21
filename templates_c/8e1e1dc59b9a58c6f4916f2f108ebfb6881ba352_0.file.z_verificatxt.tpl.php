<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:44:15
  from '\var\www\apl\sipi\templates\z_verificatxt.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef3ff107fe7_24540911',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e1e1dc59b9a58c6f4916f2f108ebfb6881ba352' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\z_verificatxt.tpl',
      1 => 1507815703,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef3ff107fe7_24540911 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<div align="center">
<form name="forsolpre" action="z_verificatxt.php?vopc=2" method="POST" onsubmit='return confirmar();'> 

&nbsp;
 <table width="190">
   <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_verificar_azul.png"></td> 
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
   </tr>
 </table>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</form>
</div>

</body>
</html>
<?php }
}
