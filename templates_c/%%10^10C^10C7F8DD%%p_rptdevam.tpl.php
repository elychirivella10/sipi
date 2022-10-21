<?php /* Smarty version 2.6.8, created on 2020-11-09 09:57:51
         compiled from p_rptdevam.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'p_rptdevam.tpl', 28, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forsolpre" action="z_browdev.php?vopc=1&vtp=0" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>

  <input type ='hidden' name='camposquery' value='<?php echo $this->_tpl_vars['camposquery']; ?>
'>
  <input type ='hidden' name='camposname'  value='<?php echo $this->_tpl_vars['camposname']; ?>
'>
  <input type ='hidden' name='tablas'      value='<?php echo $this->_tpl_vars['tablas']; ?>
'>
  <input type ='hidden' name='condicion'   value='<?php echo $this->_tpl_vars['condicion']; ?>
'> 
  <input type ='hidden' name='orden'       value='<?php echo $this->_tpl_vars['orden']; ?>
'>
  <input type ='hidden' name='modo'        value='<?php echo $this->_tpl_vars['modo']; ?>
'> 
  <input type ='hidden' name='modoabr'     value='<?php echo $this->_tpl_vars['modoabr']; ?>
'>
  <input type ='hidden' name='vurl'        value='<?php echo $this->_tpl_vars['vurl']; ?>
'>
  <input type ='hidden' name='new_windows' value='<?php echo $this->_tpl_vars['new_windows']; ?>
'>

<div align="center">

<table width="69%">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="fecsold" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsold'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forsolpre.fecsold)"> 
	<?php echo $this->_tpl_vars['campoh']; ?>
 <input type="text" name="fecsolh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsolh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forsolpre.fecsolh)">
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="10" maxlength="10">
      </td>
    </tr>
  </tr>
</table></center>
<p></p>

<table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="p_rptdevam.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
</table>
	  
</div>  
</form>

</body>
</html>