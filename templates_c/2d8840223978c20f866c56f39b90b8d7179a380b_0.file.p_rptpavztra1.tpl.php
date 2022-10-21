<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:29:29
  from '\var\www\apl\sipi\templates\p_rptpavztra1.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef0898b3111_79035056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d8840223978c20f866c56f39b90b8d7179a380b' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_rptpavztra1.tpl',
      1 => 1613160159,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef0898b3111_79035056 (Smarty_Internal_Template $_smarty_tpl) {
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

<form name="foravztra" action="p_rptavztra1.php" method="POST">
  <div align="center">
<br>
  <table cellspacing="1" border="0">
  <tr>
     <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campot']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>

        <input type="text" name="desdec" value='<?php echo $_smarty_tpl->tpl_vars['desdec']->value;?>
' size='9' onChange="valFecha(document.foravztra.desdec)" onBlur="valagente(document.foravztra.desdec,document.foravztra.hastac)"> 
        <a href="javascript:showCal('Calendar81');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>

        <input type="text" name="hastac" value='<?php echo $_smarty_tpl->tpl_vars['hastac']->value;?>
' size='9' onChange="valFecha(document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar82');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
 
        <input type="text" name="desdet" value='<?php echo $_smarty_tpl->tpl_vars['desdet']->value;?>
' size='9' onChange="valFecha(document.foravztra.desdet)" onBlur="valagente(document.foravztra.desdet,document.foravztra.hastat)"> 
        <a href="javascript:showCal('Calendar83');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="hastat" value='<?php echo $_smarty_tpl->tpl_vars['hastat']->value;?>
' size='9' onChange="valFecha(document.foravztra.hastat)">
        <a href="javascript:showCal('Calendar84');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo9']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipop']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_paten']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

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
      <td class="izq-color" >Estatus Anterior:</td>
      <td class="der-color" >
        <select size='1' name='estatusant'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayestatus']->value,'selected'=>$_smarty_tpl->tpl_vars['estatusant']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri1']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color">
        DESDE:<input type="text" name="boletin1" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
        HASTA:<input type="text" name="boletin2" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><select size='1' name='vplus'>
                             <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayplus']->value,'selected'=>$_smarty_tpl->tpl_vars['vplus']->value,'output'=>$_smarty_tpl->tpl_vars['arraydesplus']->value),$_smarty_tpl);?>

                             </select><?php echo $_smarty_tpl->tpl_vars['campo72']->value;?>

      </td>
      <td class="der-color" >
        <select size='1' name='eventoplus'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayevento']->value,'selected'=>$_smarty_tpl->tpl_vars['evento']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>  
    
  </table></center>
  <br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_rptpavztra1.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br>
</div>  
</form>

</body>
</html>
<?php }
}
