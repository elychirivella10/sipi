<?php /* Smarty version 2.6.8, created on 2020-10-20 08:34:21
         compiled from m_rptpaubex.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_rptpaubex.tpl', 22, false),array('function', 'html_options', 'm_rptpaubex.tpl', 39, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="formarcas2" action="m_rptaubex.php" method="POST">
  <div align="center">
  <br><br><br>
  
  <table>
  <tr>
    <tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo2']; ?>

        <input type="text" name="desdec" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['desdec'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="hastac" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['hastac'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
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
      <td class="der-color">
         <select size="1" name="vsede">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodsede'],'selected' => $this->_tpl_vars['vsede'],'output' => $this->_tpl_vars['vnomsede']), $this);?>

         </select>
      </td>
    </tr>          
  </table></center>
  <br><br>
  <table width="248" >
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td> 
    <td class="cnt"><a href="m_rptpaubex.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>  
  </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br>
  
</div>  
</form>

</body>
</html>