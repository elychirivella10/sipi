<?php /* Smarty version 2.6.8, created on 2020-11-17 13:09:43
         compiled from p_datostecj.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'p_datostecj.tpl', 81, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="p_datostecj.php?vopc=1" method="post">
  <table>
       <tr><td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  
<form name="formarcas2" action="p_datostecj.php?vopc=2" method="post">
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color"><?php echo $this->_tpl_vars['campo2']; ?>
 </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['vreg1']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vreg2']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  

  </table>
  &nbsp; 
</form>
&nbsp;     

<form name="formarcas3" action="p_datostecj.php?vopc=3" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
  <input type="hidden" name="vsol2" value='<?php echo $this->_tpl_vars['vsol2']; ?>
'>
  <input type="hidden" name="vreg1" value='<?php echo $this->_tpl_vars['vreg1']; ?>
'>
  <input type="hidden" name="vreg2" value='<?php echo $this->_tpl_vars['vreg2']; ?>
'>
  <input type="hidden" name="vsol" value='<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
'>
  <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>
  <input type="hidden" name="vnota_ant" value='<?php echo $this->_tpl_vars['vnota_ant']; ?>
'> 
  
  <table cellspacing="1" border="1">	
  <tr>   
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
	   <td class="der-color"><input size="9" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" rowspan="7" align="center">
          <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
          <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="193" height="205">
        </td>
      <?php endif; ?>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='<?php echo $this->_tpl_vars['vtipo']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>-
                            <input size="30" type="text" name="vtip" value='<?php echo $this->_tpl_vars['vtip']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    <!--</tr>
 	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
	   <td class="der-color"><input size="84" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
></td>
    </tr>-->
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <textarea rows="2" name="vnom" <?php echo $this->_tpl_vars['modo2']; ?>
 cols="84" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
      </td>
    </tr>

    <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="78" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr><td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['vfecreg'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['vfecven'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
	    <td class="der-color"><input size="84" type="text" name="vtrage" value="<?php echo $this->_tpl_vars['vtra']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
  </tr>
  </table>		

  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
        <textarea id="vresumen" name="vresumen" <?php echo $this->_tpl_vars['modo2']; ?>
 rows="15" cols="82"  onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['vresumen']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" >
        <input type="text" name="locarno1" <?php echo $this->_tpl_vars['modo3']; ?>
 value='<?php echo $this->_tpl_vars['locarno1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.locarno1)">-
        <input type="text" name="locarno2" <?php echo $this->_tpl_vars['modo3']; ?>
 value='<?php echo $this->_tpl_vars['locarno2']; ?>
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
      <td class="izq-color"><?php echo $this->_tpl_vars['campo18']; ?>
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
        1.&nbsp;<input type="text" name="c1l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c1l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c1l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c1n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c1n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c1n1)">
          <input type="text" name="c1l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c1l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c1l2)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c1n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c1n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c1n2)"> /
          <input type="text" name="c1n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c1n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c1n3)"> -
          <input type="text" name="t1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t1']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2.&nbsp;<input type="text" name="c2l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c2l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c2l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c2n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c2n1)">
          <input type="text" name="c2l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c2l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c2l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c2n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c2n2)"> /
          <input type="text" name="c2n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c2n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c2n3)"> -
          <input type="text" name="t2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t2']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        3.&nbsp;<input type="text" name="c3l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c3l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c3l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c3n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c3n1)">
          <input type="text" name="c3l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c3l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c3l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c3n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c3n2)"> /
          <input type="text" name="c3n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c3n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c3n3)"> -
          <input type="text" name="t3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t3']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        4.&nbsp;<input type="text" name="c4l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c4l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c4l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c4n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c4n1)">
          <input type="text" name="c4l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c4l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c4l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c4n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c4n2)"> /
          <input type="text" name="c4n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c4n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c4n3)"> -
          <input type="text" name="t4" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t4']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        5.&nbsp;<input type="text" name="c5l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c5l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c5l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c5n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c5n1)">
          <input type="text" name="c5l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c5l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c5l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c5n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c5n2)"> /
          <input type="text" name="c5n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c5n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c5n3)"> -
          <input type="text" name="t5" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t5']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        6.&nbsp;<input type="text" name="c6l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c6l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c6l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c6n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c6n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c6n1)">
          <input type="text" name="c6l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c6l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c6l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c6n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c6n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c6n2)"> /
          <input type="text" name="c6n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c6n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c6n3)"> -
          <input type="text" name="t6" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t6']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        7.&nbsp;<input type="text" name="c7l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c7l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c7l1)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c7n1" <?php echo $this->_tpl_vars['modo4']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c7n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c7n1)">
          <input type="text" name="c7l2" <?php echo $this->_tpl_vars['modo4']; ?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c7l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c7l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c7n2" <?php echo $this->_tpl_vars['modo4']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c7n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c7n2)"> /
          <input type="text" name="c7n3" <?php echo $this->_tpl_vars['modo4']; ?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c7n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c7n3)"> -
          <input type="text" name="t7" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t7']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        8.&nbsp;<input type="text" name="c8l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c8l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c8l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c8n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c8n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c8n1)">
          <input type="text" name="c8l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c8l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c8l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c8n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c8n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c8n2)"> /
          <input type="text" name="c8n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c8n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c8n3)"> -
          <input type="text" name="t8" <?php echo $this->_tpl_vars['modo4']; ?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t8']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        9.&nbsp;<input type="text" name="c9l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c9l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c9l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c9n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c9n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c9n1)">
          <input type="text" name="c9l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c9l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c9l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c9n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c9n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c9n2)"> /
          <input type="text" name="c9n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c9n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c9n3)"> -
          <input type="text" name="t9" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t9']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       10.&nbsp;<input type="text" name="c10l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c10l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c10l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c10n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c10n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c10n1)">
          <input type="text" name="c10l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c10l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c10l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c10n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c10n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c10n2)"> /
          <input type="text" name="c10n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c10n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c10n3)"> -
          <input type="text" name="t10" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t10']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;
       11.&nbsp;<input type="text" name="c11l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c11l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c11l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c11n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c11n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c11n1)">
          <input type="text" name="c11l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c11l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c11l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c11n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c11n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c11n2)"> /
          <input type="text" name="c11n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c11n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c11n3)"> -
          <input type="text" name="t11" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t11']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       12.&nbsp;<input type="text" name="c12l1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,7, this)" value='<?php echo $this->_tpl_vars['c12l1']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c12l1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c12n1" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c12n1']; ?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,3,document.formarcas3.c12n1)">
          <input type="text" name="c12l2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,5, this)" value='<?php echo $this->_tpl_vars['c12l2']; ?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas3.c12l2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c12n2" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c12n2']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c12n2)"> /
          <input type="text" name="c12n3" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,2, this)" value='<?php echo $this->_tpl_vars['c12n3']; ?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,3,document.formarcas3.c12n3)"> -
          <input type="text" name="t12" <?php echo $this->_tpl_vars['modo4']; ?>
 onKeyPress="return acceptChar(event,8, this)" value='<?php echo $this->_tpl_vars['t12']; ?>
' size="1" maxlength="1" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
    </tr>

    <tr>
      <td class="izq-color">&nbsp;&nbsp;</td>
      <td class="der-color">&nbsp;&nbsp;</td>
    </tr>  

    <!-- <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color" >
        <input type="text" name="edicion" '<?php echo $this->_tpl_vars['modo4']; ?>
' value='<?php echo $this->_tpl_vars['edicion']; ?>
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
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo18']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_vercip.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vcip" <?php echo $this->_tpl_vars['modo4']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vcipe" <?php echo $this->_tpl_vars['modo4']; ?>
 onclick="browsecip(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vcip,document.formarcas3.vcipe)"> 
        <br>
    </td></tr> 
  </table>

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo19']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verinven.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vinv" <?php echo $this->_tpl_vars['modo2']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vinvi" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseinventorp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vinv,document.formarcas3.vinvi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vinve" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseinventorp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vinv,document.formarcas3.vinve)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo23']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" <?php echo $this->_tpl_vars['modo2']; ?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vprior,document.formarcas3.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browseprioridp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vprior,document.formarcas3.vpriore)"> 
        <br>
    </td></tr> 
  </table>
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <!-- <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo4']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
        <input type="button" value="Buscar/Eliminar" name="vtitue" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
        <br> --> 
    </td></tr> 
  </table>
  &nbsp;

  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo26']; ?>
</td>
      <td class="der-color">
        <textarea id="vnotas" name="vnotas" <?php echo $this->_tpl_vars['modo2']; ?>
 rows="15" cols="82"  onChange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['vnotas']; ?>
</textarea> 
      </td>
    </tr>
  </table>
  &nbsp;
  
  <table width="40%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo25']; ?>
</td></tr>
    <tr><td>
      <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="p_verequiva.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe>
     
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vequiv" <?php echo $this->_tpl_vars['modo2']; ?>
 size="40" maxlength="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vequivi" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsequivap(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vequiv,document.formarcas3.vequivi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vequive" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsequivap(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vequiv,document.formarcas3.vequive)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;
  
  &nbsp;
  <table width="250">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="p_datostecj.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>