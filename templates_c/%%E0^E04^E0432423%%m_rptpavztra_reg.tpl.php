<?php /* Smarty version 2.6.8, created on 2021-02-12 15:55:07
         compiled from m_rptpavztra_reg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_rptpavztra_reg.tpl', 21, false),array('function', 'html_options', 'm_rptpavztra_reg.tpl', 43, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="foravztra" action="m_rptavztra_reg.php" method="POST">
  <div align="center">
  <br>
  
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campot']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo7']; ?>

        <input type="text" name="desdec" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdec'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdec)" onChange="valFecha(this,document.foravztra.desdec)" onBlur="valagente(document.foravztra.desdec,document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar81');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campo8']; ?>

        <input type="text" name="hastac" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastac'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastac)" onChange="valFecha(this,document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar82');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo2']; ?>
 
        <input type="text" name="desdet" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdet'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(document.foravztra.desdet)" onBlur="valagente(document.foravztra.desdet,document.foravztra.hastat)"> 
        <a href="javascript:showCal('Calendar83');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="hastat" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastat'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(document.foravztra.hastat)">
        <a href="javascript:showCal('Calendar84');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
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
  </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

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
      <td class="izq-color" ><select size='1' name='vplus'>
                             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['vplus'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

                             </select><?php echo $this->_tpl_vars['campo72']; ?>

      </td>
      <td class="der-color" >
        <select size='1' name='eventoplus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['evento'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo19']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayorden'],'selected' => $this->_tpl_vars['orden'],'output' => $this->_tpl_vars['arrayorden']), $this);?>

        </select>
      </td>
    </tr> 
    </tr>   
  </table><!--</font>--></center>
  <br>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavztra_reg.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br><br><br>
</body>
</html>