<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:08:49
  from '\var\www\apl\sipi\templates\m_rptpavzda.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634eebb109c709_91622335',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0af78621c9cb93d9ec104ca4a1f6a71d4a79e381' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_rptpavzda.tpl',
      1 => 1613165642,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634eebb109c709_91622335 (Smarty_Internal_Template $_smarty_tpl) {
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
<form name="formarcas2" action="m_rptavzda.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
'>
  
  <div align="center">
  <br>
  <table>
  <tr>
     <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campot']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>

        <input type="text" name="desdec" value='<?php echo $_smarty_tpl->tpl_vars['desdec']->value;?>
' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="hastac" value='<?php echo $_smarty_tpl->tpl_vars['hastac']->value;?>
' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
 
        <input type="text" name="desdet" value='<?php echo $_smarty_tpl->tpl_vars['desdet']->value;?>
' size='9' onChange="valFecha(document.formarcas2.desdet)" onBlur="valagente(document.formarcas2.desdet,document.formarcas2.hastat)"> 
        <a href="javascript:showCal('Calendar71');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="hastat" value='<?php echo $_smarty_tpl->tpl_vars['hastat']->value;?>
' size='9' onChange="valFecha(document.formarcas2.hastat)">
        <a href="javascript:showCal('Calendar72');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo10']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_marca']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='evento'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayevento']->value,'selected'=>$_smarty_tpl->tpl_vars['evento']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
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
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_marca']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>
    
    <!-- <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="indole" size="1" maxlength="1" onkeyup="this.value=this.value.toUpperCase()">
      </td>
    </tr> -->      

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="indole" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayindol']->value,'selected'=>$_smarty_tpl->tpl_vars['indole']->value,'output'=>$_smarty_tpl->tpl_vars['arraynoind']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>

  </table><!--</font>--></center>
	<p></p>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavzda.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br>
</body>
</html>
<?php }
}
