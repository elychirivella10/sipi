<?php
/* Smarty version 3.1.47, created on 2022-10-18 17:48:56
  from '\var\www\apl\sipi\templates\m_rptpavzcri.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ecae83a8c53_65195915',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ebe27f0d6c18453bbe83b7d2362017f57b7f6c6' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_rptpavzcri.tpl',
      1 => 1664554500,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ecae83a8c53_65195915 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
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

<form name="foravzcri" action="m_rptavzcri.php" method="POST">
  <div align="center">
  <br>
  
<table width="960px">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>

        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2)" onchange="Rellena(document.foravzcri.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)">
        <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2h)" onchange="Rellena(document.foravzcri.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2h,6)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color">
       <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>
 <input type="text" name="vreg1d" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.foravzcri.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2d" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2d,6)">   
       <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>
 <input type="text" name="vreg1h" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.foravzcri.vreg2h)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2h" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2h,6)">   
      </td>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo5']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>

        <input type="text" name="fecsold" value='<?php echo $_smarty_tpl->tpl_vars['fecsold']->value;?>
' size='9' onChange="valFecha(document.foravzcri.fecsold)" onBlur="valagente(document.foravzcri.fecsold,document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar73');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="fecsolh" value='<?php echo $_smarty_tpl->tpl_vars['fecsolh']->value;?>
' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar74');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>

        <input type="text" name="fecpubd" value='<?php echo $_smarty_tpl->tpl_vars['fecpubd']->value;?>
' size='9' onChange="valFecha(document.foravzcri.fecpubd)" onBlur="valagente(document.foravzcri.fecpubd,document.foravzcri.fecpubh)"> 
        <a href="javascript:showCal('Calendar75');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="fecpubh" value='<?php echo $_smarty_tpl->tpl_vars['fecpubh']->value;?>
' size='9' onChange="valFecha(document.foravzcri.fecpubh)">
        <a href="javascript:showCal('Calendar76');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo9']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>

        <input type="text" name="fecvend" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fecvend']->value,"%d/%m/%G");?>
' size='9' onChange="valFecha(document.foravzcri.fecvend)" onBlur="valagente(document.foravzcri.fecvend,document.foravzcri.fecvenh)"> 
        <a href="javascript:showCal('Calendar77');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>

        <input type="text" name="fecvenh" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fecvenh']->value,"%d/%m/%G");?>
' size='9' onChange="valFecha(document.foravzcri.fecvenh)">
        <a href="javascript:showCal('Calendar78');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo11']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayestatus']->value,'selected'=>$_smarty_tpl->tpl_vars['estatus']->value,'output'=>$_smarty_tpl->tpl_vars['arraydescri1']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo12']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipo']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo']->value,'output'=>$_smarty_tpl->tpl_vars['arraytipo']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo13']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campod']->value;?>
<input type="text" name="clase" size="2" maxlength="2" onKeyPress="return acceptChar(event,2, this)">
        &nbsp;&nbsp;
        <?php echo $_smarty_tpl->tpl_vars['campoh']->value;?>
<input type="text" name="clase2" size="2" maxlength="2" onKeyPress="return acceptChar(event,2, this)">
        &nbsp;&nbsp;
        <select size="1" name="clase_id" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayvclase']->value,'selected'=>$_smarty_tpl->tpl_vars['clase_id']->value,'output'=>$_smarty_tpl->tpl_vars['arraytclase']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo14']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='opelog'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayopelog']->value,'selected'=>$_smarty_tpl->tpl_vars['opelog']->value,'output'=>$_smarty_tpl->tpl_vars['arrayopelog']->value),$_smarty_tpl);?>

        </select>
        <select size='1' name='pais'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraypais']->value,'selected'=>$_smarty_tpl->tpl_vars['pais']->value,'output'=>$_smarty_tpl->tpl_vars['arraynombre']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 

    <!-- <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo15']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="nombre" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>    -->

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo16']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="titular" size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="poder1" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.foravzcri.poder2)">-
		  <input type="text" name="poder2" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.foravzcri.agente)" onchange="Rellena(document.foravzcri.poder2,4)">        
      </td>
    </tr>  

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo17']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="agente" size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>  

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo18']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="tramitante" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>    

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo19']->value;?>
</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayorden']->value,'selected'=>$_smarty_tpl->tpl_vars['orden']->value,'output'=>$_smarty_tpl->tpl_vars['arrayorden']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 

  </table><!--</font>--></center>
	<br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavzcri.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  </div>  
</form>

</body>
</html>
<?php }
}
