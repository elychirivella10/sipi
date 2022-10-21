<?php /* Smarty version 2.6.8, created on 2020-10-20 11:28:49
         compiled from m_rptppoder.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_rptppoder.tpl', 32, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<!-- <h3> <?php echo $this->_tpl_vars['H3']; ?>
</h3> -->

<form name="forpoder" action="m_rptpoder.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <div align="center">
  <br>
  
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">

   <?php echo $this->_tpl_vars['campod']; ?>
<input type="text" name="desde1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpoder.desde2)" onchange="Rellena(document.forpoder.desde1,2)">-
        <input type="text" name="desde2" align="right" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpoder.submit)" onchange="Rellena(document.forpoder.desde2,4)">
<?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="hasta1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpoder.hasta2)" onchange="Rellena(document.forpoder.hasta1,2)">-
        <input type="text" name="hasta2" align="right" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.forpoder.submit)" onchange="Rellena(document.forpoder.hasta2,4)">
      </td>
    </tr>
   
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="desdet" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdet'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forpoder.desdet)"> 
	<?php echo $this->_tpl_vars['campoh']; ?>

     <input type="text" name="hastat" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastat'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forpoder.hastat)">
    </tr>

  </table><!--</font>--></center>
	<br>
    <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptppoder.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>