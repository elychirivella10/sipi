<?php /* Smarty version 2.6.8, created on 2021-02-12 15:38:21
         compiled from p_rptpavztrar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'p_rptpavztrar.tpl', 21, false),array('function', 'html_options', 'p_rptpavztrar.tpl', 43, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="foravztra" action="p_rptavztrar.php" method="POST">
  <div align="center">
  <br>
  
  <table cellspacing="1" border="0">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campot']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo7']; ?>

        <input type="text" name="desdec" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdec'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravztra.desdec)" onBlur="valagente(document.foravztra.desdec,document.foravztra.hastac)"> 
        <a href="javascript:showCal('Calendar81');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campo8']; ?>

        <input type="text" name="hastac" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastac'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar82');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo2']; ?>
 
        <input type="text" name="desdet" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdet'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravztra.desdet)" onBlur="valagente(document.foravztra.desdet,document.foravztra.hastat)"> 
        <a href="javascript:showCal('Calendar83');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="hastat" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastat'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravztra.hastat)">
        <a href="javascript:showCal('Calendar84');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipop'],'selected' => $this->_tpl_vars['tipo_paten'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='evento'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['evento'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayestatus'],'selected' => $this->_tpl_vars['estatus'],'output' => $this->_tpl_vars['arraydescri1']), $this);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        DESDE:<input type="text" name="boletin1" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
        HASTA:<input type="text" name="boletin2" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   
    
  </table></center>
  <br>
  
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_rptpavztrar.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br>
  
</div>  
</form>

</body>
</html>