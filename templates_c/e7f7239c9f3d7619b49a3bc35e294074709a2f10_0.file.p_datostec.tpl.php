<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:20:59
  from '\var\www\apl\sipi\templates\p_datostec.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d72db9413f8_41611666',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7f7239c9f3d7619b49a3bc35e294074709a2f10' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_datostec.tpl',
      1 => 1496850143,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d72db9413f8_41611666 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<div align="center">

<form name="formarcas1" action="p_datostec.php?vopc=1" method="post">
  <table>
       <tr><td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  
<form name="formarcas2" action="p_datostec.php?vopc=2" method="post">
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
 </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vreg1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $_smarty_tpl->tpl_vars['vreg2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  

  </table>
  &nbsp; 
</form>
&nbsp;     

<form name="formarcas3" action="p_datostec.php?vopc=3" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
'>
  <input type="hidden" name="vsol2" value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
'>
  <input type="hidden" name="vreg1" value='<?php echo $_smarty_tpl->tpl_vars['vreg1']->value;?>
'>
  <input type="hidden" name="vreg2" value='<?php echo $_smarty_tpl->tpl_vars['vreg2']->value;?>
'>
  <input type="hidden" name="vsol" value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
'>
  <input type="hidden" name="vder" value='<?php echo $_smarty_tpl->tpl_vars['vder']->value;?>
'>
  <input type="hidden" name="vnota_ant" value='<?php echo $_smarty_tpl->tpl_vars['vnota_ant']->value;?>
'> 

  <table cellspacing="1" border="1">	
  <tr>   
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
	   <td class="der-color"><input size="9" type="text" name="vfecsol" value='<?php echo $_smarty_tpl->tpl_vars['vfecsol']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td>
      <?php if ($_smarty_tpl->tpl_vars['modal_id']->value == "G" || $_smarty_tpl->tpl_vars['modal_id']->value == "M") {?>
        <td class="der-color" rowspan="7" align="center">
          <a href='<?php echo $_smarty_tpl->tpl_vars['nameimage']->value;?>
' target="_blank">
          <img border="-1" src=<?php echo $_smarty_tpl->tpl_vars['nameimage']->value;?>
 width="193" height="205">
        </td>
      <?php }?>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='<?php echo $_smarty_tpl->tpl_vars['vtipo']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>-
                            <input size="30" type="text" name="vtip" value='<?php echo $_smarty_tpl->tpl_vars['vtip']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color">
        <textarea rows="2" name="vnom" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 cols="84" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
</textarea>
      </td>
    </tr>

    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="vtipo">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['vtipo']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>




    <tr>
	   <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $_smarty_tpl->tpl_vars['vest']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>
	                <input size="78" type="text" name="vdesest" value='<?php echo $_smarty_tpl->tpl_vars['vdesest']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td>
    </tr>
	 <tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='<?php echo $_smarty_tpl->tpl_vars['vfecreg']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo9']->value;?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vfecven']->value,"%d/%m/%G");?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo10']->value;?>
</td>
	    <td class="der-color"><input size="84" type="text" name="vtrage" value="<?php echo $_smarty_tpl->tpl_vars['vtra']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td>
      <?php if ($_smarty_tpl->tpl_vars['modal_id']->value == "G" || $_smarty_tpl->tpl_vars['modal_id']->value == "M") {?>
        <td class="der-color" ></td>
      <?php }?>
    </tr>
  </tr>
  </table>		

  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo16']->value;?>
</td>
      <td class="der-color">
        <textarea id="vresumen" name="vresumen" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 rows="15" cols="82"  onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['vresumen']->value;?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo14']->value;?>
</td>
      <td class="der-color" >
        <input type="text" name="locarno1" <?php echo $_smarty_tpl->tpl_vars['modo3']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['locarno1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.locarno1)">-
        <input type="text" name="locarno2" <?php echo $_smarty_tpl->tpl_vars['modo3']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['locarno2']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.locarno2)">
      </td>
    </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
    <tr>
    </tr>

    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo18']->value;?>
</td>
      <td class="der-color">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;
      </td>
    </tr>

	 <tr>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        1.&nbsp;<input type="text" name="c1l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c1l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c1n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c1n1)">
          <input type="text" name="c1l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c1l2)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c1n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c1n2)"> /
          <input type="text" name="c1n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c1n3)"> -
          <input type="text" name="t1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t1']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2.&nbsp;<input type="text" name="c2l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c2l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c2n1)">
          <input type="text" name="c2l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c2l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c2n2)"> /
          <input type="text" name="c2n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c2n3)"> -
          <input type="text" name="t2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t2']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        3.&nbsp;<input type="text" name="c3l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c3l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c3n1)">
          <input type="text" name="c3l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c3l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c3n2)"> /
          <input type="text" name="c3n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c3n3)"> -
          <input type="text" name="t3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t3']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        4.&nbsp;<input type="text" name="c4l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c4l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c4n1)">
          <input type="text" name="c4l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c4l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c4n2)"> /
          <input type="text" name="c4n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c4n3)"> -
          <input type="text" name="t4" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t4']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        5.&nbsp;<input type="text" name="c5l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c5l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c5n1)">
          <input type="text" name="c5l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c5l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c5n2)"> /
          <input type="text" name="c5n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c5n3)"> -
          <input type="text" name="t5" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t5']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        6.&nbsp;<input type="text" name="c6l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c6l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c6n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c6n1)">
          <input type="text" name="c6l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c6l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c6n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c6n2)"> /
          <input type="text" name="c6n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c6n3)"> -
          <input type="text" name="t6" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t6']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        7.&nbsp;<input type="text" name="c7l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c7l1)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c7n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c7n1)">
          <input type="text" name="c7l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c7l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c7n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c7n2)"> /
          <input type="text" name="c7n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c7n3)"> -
          <input type="text" name="t7" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t7']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        8.&nbsp;<input type="text" name="c8l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c8l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c8n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c8n1)">
          <input type="text" name="c8l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c8l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c8n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c8n2)"> /
          <input type="text" name="c8n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c8n3)"> -
          <input type="text" name="t8" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t8']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        9.&nbsp;<input type="text" name="c9l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c9l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c9n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c9n1)">
          <input type="text" name="c9l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c9l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c9n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c9n2)"> /
          <input type="text" name="c9n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c9n3)"> -
          <input type="text" name="t9" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t9']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       10.&nbsp;<input type="text" name="c10l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c10l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c10n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c10n1)">
          <input type="text" name="c10l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c10l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c10n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c10n2)"> /
          <input type="text" name="c10n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c10n3)"> -
          <input type="text" name="t10" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t10']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;
       11.&nbsp;<input type="text" name="c11l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c11l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c11n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c11n1)">
          <input type="text" name="c11l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c11l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c11n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c11n2)"> /
          <input type="text" name="c11n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c11n3)"> -
          <input type="text" name="t11" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t11']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       12.&nbsp;<input type="text" name="c12l1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c12l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c12n1" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c12n1)">
          <input type="text" name="c12l2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c12l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c12n2" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c12n2)"> /
          <input type="text" name="c12n3" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c12n3)"> -
          <input type="text" name="t12" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t12']->value;?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
    </tr>

    <tr>
      <td class="izq-color">&nbsp;&nbsp;</td>
      <td class="der-color">&nbsp;&nbsp;</td>
    </tr>  

    <!-- <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo15']->value;?>
</td>
      <td class="der-color" >
        <input type="text" name="edicion" '<?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['edicion']->value;?>
' size="4" maxlength="4" onKeyup="checkLength(event,this,3,document.formarcas3.edicion)">
      </td>
    </tr> -->  

    <tr>
      <td class="izq-color"></td>
      <td class="der-color"></td>
    </tr>  

  </table>

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo18']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_vercip.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vcip" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vcipe" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browsecip(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vcip,document.formarcas3.vcipe)"> 
        <br>
    </td></tr> 
  </table>

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo19']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verinven.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
    </td></tr> 
  </table>
  &nbsp;
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo23']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
    </td></tr> 
  </table>
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo11']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
    </td></tr> 
  </table>
  &nbsp;
  
  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo26']->value;?>
</td>
      <td class="der-color">
        <textarea id="vnotas" name="vnotas" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 rows="15" cols="82"  onChange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['vnotas']->value;?>
</textarea> 
      </td>
    </tr>
  </table>
  &nbsp;

  <table width="40%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo25']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src='p_verequiva.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
'></iframe>  
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vequiv" <?php echo $_smarty_tpl->tpl_vars['modo4']->value;?>
 size="40" maxlength="35" onChange="javascript:this.value=this.value.toUpperCase();"> 
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vequivi" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browsequivap(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vequiv,document.formarcas3.vequivi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vequive" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browsequivap(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vequiv,document.formarcas3.vequive)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;
  
  &nbsp;
  <table width="250">
    <tr>
      <!-- <td class="cnt"><a href="p_rptcronol.php?vsol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
"><input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> --> 
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="p_datostec.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>
<?php }
}
