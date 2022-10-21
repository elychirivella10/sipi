<?php /* Smarty version 2.6.8, created on 2021-09-28 15:18:28
         compiled from p_anualidad.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'p_anualidad.tpl', 75, false),array('function', 'html_radios', 'p_anualidad.tpl', 141, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<br>
<form name="formarcas1" action="p_anualidad.php?vopc=1" method="post">
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
		 <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  
<form name="formarcas2" action="p_anualidad.php?vopc=2" method="post">
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
		 <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  

  </table>
  &nbsp; 
</form>
&nbsp;     

<form name="formarcas3" action="p_anualidad.php?vopc=3" method="post" onsubmit='return pregunta();'>
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
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <textarea rows="2" name="vnom" <?php echo $this->_tpl_vars['modo2']; ?>
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
<!--<tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
	    <td class="der-color"><input size="84" type="text" name="vtrage" value="<?php echo $this->_tpl_vars['vtra']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
    <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo14']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vultanual" value="<?php echo $this->_tpl_vars['vultanual']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td> 
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr> -->
  </tr>
  </table>		

<!--  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
    </td></tr> 
  </table> -->

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $this->_tpl_vars['campo12']; ?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:190px;background-color: WHITE;' src="p_veranual.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>
  </table>


  &nbsp;
  <table width="85%" cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color">
        <input type='text' name='fecha_evento' value='<?php echo $this->_tpl_vars['fecha_evento']; ?>
' size='10' onChange="valFecha(document.formarcas3.fecha_evento)" onkeyup="checkLength(event,this,10,document.formarcas3.anuali1)"> 
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo18']; ?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="anuali1" '<?php echo $this->_tpl_vars['modo1']; ?>
' value='<?php echo $this->_tpl_vars['anuali1']; ?>
' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,2,document.formarcas3.anuali2)" onchange="valagente(document.formarcas3.anuali1,document.formarcas3.anuali2)">
        &nbsp;&nbsp; al &nbsp;&nbsp;
        <input type="text" name="anuali2" '<?php echo $this->_tpl_vars['modo1']; ?>
' value='<?php echo $this->_tpl_vars['anuali2']; ?>
' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,2,document.formarcas3.planilla)">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo19']; ?>
&nbsp;
        <input type="text" name="planilla" '<?php echo $this->_tpl_vars['modo1']; ?>
' value='<?php echo $this->_tpl_vars['planilla']; ?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas3.tasa)">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo20']; ?>
&nbsp;
        <input type="text" name="tasa" '<?php echo $this->_tpl_vars['modo1']; ?>
' value='<?php echo $this->_tpl_vars['tasa']; ?>
' size="7" maxlength="7" onKeyup="checkLength(event,this,6,document.formarcas3.monto)"> 
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo21']; ?>
&nbsp;
        <input type="text" name="monto" '<?php echo $this->_tpl_vars['modo1']; ?>
' value='<?php echo $this->_tpl_vars['monto']; ?>
' size="15" maxlength="15" onKeyup="checkLength(event,this,15,document.formarcas3.vagent)">
      </td>
    </tr>
  </tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo15']; ?>
</td>
     <td class="der-color">
       <?php echo smarty_function_html_radios(array('name' => 'multa','values' => $this->_tpl_vars['multa_opc'],'selected' => $this->_tpl_vars['multa'],'output' => $this->_tpl_vars['multa_def'],'separator' => ""), $this);?>

       &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo16']; ?>
&nbsp;&nbsp;
       <input type="text" name="monto_multa" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['monto_multa']; ?>
' size="15" maxlength="15" onKeyup="checkLength(event,this,15,document.formarcas3.vagent)">
     </td>
   </tr>
  </table>
  &nbsp;
  
   <table width="210">
    <tr>
      <td class="cnt"><a href="p_rptcronol.php?vsol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
" target="_blank"><img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
      <td class="cnt"><input type="image" src="../imagenes/boton_grabar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_anualidad.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

</form>

</div>  
</body>
</html>