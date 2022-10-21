<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:08:08
  from '\var\www\apl\sipi\templates\m_rptpforfon.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634eeb8861bdc3_17799389',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '178a9ad6ff51b523c51598927620d54ecb77d3ce' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_rptpforfon.tpl',
      1 => 1627244824,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634eeb8861bdc3_17799389 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<html>
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

<form name="formarcas2" action="m_rptforfon.php" method="POST">
  <div align="center">
  <br>
  <table>
  <tr>
     <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campot']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campo9']->value;?>

        <input type="text" name="desdec" value='<?php echo $_smarty_tpl->tpl_vars['desdec']->value;?>
' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	<?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>

        <input type="text" name="hastac" value='<?php echo $_smarty_tpl->tpl_vars['hastac']->value;?>
' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo5']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayestatus']->value,'selected'=>$_smarty_tpl->tpl_vars['estatus']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri1']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo10']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_decision" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_marca']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>
  </table><!--</font>--></center>
  <br>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpforfon.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br>
</body>
</html>
<?php }
}
