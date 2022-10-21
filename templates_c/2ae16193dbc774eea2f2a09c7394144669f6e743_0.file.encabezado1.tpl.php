<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:20:10
  from '\var\www\apl\sipi\templates\encabezado1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d72aa76bf99_10502758',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ae16193dbc774eea2f2a09c7394144669f6e743' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\encabezado1.tpl',
      1 => 1602517692,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d72aa76bf99_10502758 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
  <title><?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
</title>
  <?php echo '<script'; ?>
 language="javascript" src="../libjs/wforms.js"><?php echo '</script'; ?>
> 
</head>

<header>

<!-- <body onload="mueveReloj()"> -->

<div align="center">

<!-- <table width="960px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td valign="top">
      <div align="left">
       <img src="../imagenes/cinta_azul.png" width="999" height="2">
      </div>
    </td>
  </tr> 
</table> -->

<table width="960px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr> 
    <td  width="100" valign="top">
      <font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">
      <strong>
      <img src="../imagenes/header_sapi20.png" width="100%" height="100"> 
      </strong>
      </font>
    </td>
  </tr>
</table>

<table width="960px" align="center" >
  <tr height="30" >
    <td width="5%" class="subtitulo2">
      <b><i><a href="">Inicio</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://www.sapi.gob.ve" target="blank">Sapi</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://correo.sapi.gob.ve" target="blank">Correo</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://sire.sapi.gob.ve/" target="blank">Sire</a></i></b> 
    </td>
    <td width="10%" class="subtitulo2">
      <b><i><a href="http://www.bancodevenezuela.com/" target="blank">Banco de Venezuela</a></i></b>
    </td>
    <td width="40%" class="subtitulo1">
		<b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor - SIPI</i></b>
    </td>
  </tr>
</table>

  <table width="960px">
   <tr>
    <td width="30%" class="izq2-color">
      <font face="MS Sans Serif" color="#000000" size="-1">Usuario: <?php echo $_smarty_tpl->tpl_vars['login']->value;?>
</font>
    </td>
    <td width="40%" class="cnt-color3">
      <font face="MS Sans Serif" color="#000000" size="-1"><?php echo $_smarty_tpl->tpl_vars['subtitulo']->value;?>
</font>
    </td>
    <td width="30%" class="der2-color">
      <font face="MS Sans Serif" color="#000000" size="-1"><?php echo $_smarty_tpl->tpl_vars['fechahoy']->value;?>
</font>
    </td>
    </tr>
  </table>

<!-- <form name="form_reloj">
<table width="960px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class="der">
      <div align="right">
        <I><font size="-1"><b><?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
</b></font></I>
         &nbsp;&nbsp;<font face="Arial" size="2" > 
         <input type="text" name="reloj" size="15" style="background-color : Rich Blue; color : Black; font-family : Verdana, Arial, Helvetica; font-size : 8pt; text-align : center; font-weight: bold;" onfocus="window.document.form_reloj.reloj.blur()"><br/>
         </font>
      </div>
    </td>
  </tr>
</table>

</form> -->
</div>
</header>

</body>
</html>
<?php }
}
