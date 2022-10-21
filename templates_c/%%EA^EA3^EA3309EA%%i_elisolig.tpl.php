<?php /* Smarty version 2.6.8, created on 2021-05-09 10:31:09
         compiled from i_elisolig.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'i_elisolig.tpl', 58, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="i_elisolig.php?vopc=1" method="post">
  <table>
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
            </td>
	    <td class="cnt"><input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>

</form>				  

  </table>
  &nbsp; 
  <table cellspacing="0">	
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
>  
                            <input size="30" type="text" name="modal" value='<?php echo $this->_tpl_vars['modal']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color"><input size="1" type="text" name="vclase" value='<?php echo $this->_tpl_vars['vclase']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>-
                            <input size="20" type="text" name="vindcla" value='<?php echo $this->_tpl_vars['vindcla']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
	   <td class="der-color"><input size="72" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
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
	    <td class="der-color"><input size="72" type="text" name="vtrage" value="<?php echo $this->_tpl_vars['vtra']; ?>
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
	                <input size="63" type="text" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
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
	                <input size="67" type="text" name="vnadtit" value='<?php echo $this->_tpl_vars['vnadtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo17']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vdomtit" value='<?php echo $this->_tpl_vars['vdomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
      <?php if ($this->_tpl_vars['modal_id'] == 'G' || $this->_tpl_vars['modal_id'] == 'M'): ?>
        <td class="der-color" ></td>
      <?php endif; ?>
    </tr>
  </tr>
  </table>		
</form>
&nbsp;     

<form name="formarcas3" action="i_elisolig.php?vopc=3" method="post" onsubmit='return pregunta1();'>
  <input type="hidden" name="vsol1" value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
  <input type="hidden" name="vsol2" value='<?php echo $this->_tpl_vars['vsol2']; ?>
'>
  <input type="hidden" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
'>
  <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>

  <table width="225">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
      <td class="cnt"><a href="i_elisolig.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>

    </tr>
  </table>
</form>

</div>  
</body>
</html>

