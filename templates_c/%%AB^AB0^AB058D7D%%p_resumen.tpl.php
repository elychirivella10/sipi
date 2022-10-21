<?php /* Smarty version 2.6.8, created on 2022-02-01 11:45:41
         compiled from p_resumen.tpl */ ?>
<html>

<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="p_resumen.php?vopc=1" method="post">
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
<form name="formarcas2" action="p_resumen.php?vopc=2" method="post">
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

<form name="formarcas3" action="p_resumen.php?vopc=3" method="post" onsubmit='return pregunta();'>
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
        <textarea rows="2" name="vnom" <?php echo $this->_tpl_vars['vmodo']; ?>
 cols="84" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
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
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='<?php echo $this->_tpl_vars['vfecreg']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='<?php echo $this->_tpl_vars['vfecven']; ?>
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
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="74" type="text" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
    <tr>
       <td class="izq-color"><?php echo $this->_tpl_vars['campo12']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='<?php echo $this->_tpl_vars['vnactit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="78" type="text" name="vnadtit" value='<?php echo $this->_tpl_vars['vnadtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td>
	    <td class="der-color"><input size="84" type="text" name="vdomtit" value='<?php echo $this->_tpl_vars['vdomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
  </tr>
  </table>		
  &nbsp; 


  <table cellspacing="1" border="1">	

    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
        <textarea id="vresumen" name="vresumen" <?php echo $this->_tpl_vars['modo2']; ?>
 rows="15" cols="82"  onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['vresumen']; ?>
</textarea> 
        <!-- <textarea id="vresumen" name="vresumen" <?php echo $this->_tpl_vars['modo2']; ?>
 rows="15" cols="82"><?php echo $this->_tpl_vars['vresumen']; ?>
</textarea> --> 
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
    </tr>
	 <tr>
	 </tr>

  </table>
  &nbsp;

  <table width="250">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="p_resumen.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      <!-- <td class="cnt"><a href="p_rptcronol.php?vsol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
">
      <input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td> --> 
    </tr>
  </table>
</form>

</div>  
</body>
</html>