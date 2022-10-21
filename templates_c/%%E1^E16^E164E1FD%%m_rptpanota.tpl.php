<?php /* Smarty version 2.6.8, created on 2021-05-25 10:19:17
         compiled from m_rptpanota.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_rptpanota.tpl', 20, false),array('function', 'html_options', 'm_rptpanota.tpl', 30, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forsolpre" action="m_rptanota.php" method="POST">
  <div align="center">
  <br>
<table width="69%">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="fecsold" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsold'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forsolpre.fecsold)" onBlur="valagente(document.forsolpre.fecsold,document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar58');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campoh']; ?>

	     <input type="text" name="fecsolh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsolh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar59');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
    </tr>
 	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
      <td class="der-color">
        <select size="1" name="v2">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvmodal'],'selected' => $this->_tpl_vars['modalidad'],'output' => $this->_tpl_vars['arraytmodal']), $this);?>

        </select>
      </td>  
	 </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="12" maxlength="15">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" value='<?php echo $this->_tpl_vars['boletin']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forsolpre.buscar)">
      </td>
    </tr>   
  </tr>
</table></center>
<br>

<table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpanota.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
</table>
	  
</div>  
</form>
<br><br><br><br><br><br><br><br><br>
</body>
</html>