<?php /* Smarty version 2.6.8, created on 2021-02-22 08:59:38
         compiled from m_rptpavzcri_neg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_rptpavzcri_neg.tpl', 40, false),array('function', 'html_options', 'm_rptpavzcri_neg.tpl', 73, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="foravzcri" action="m_rptavzcri_neg.php" method="POST">
  <div align="center">
  <br>
<table width="960px">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2)" onchange="Rellena(document.foravzcri.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)">
        <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2h)" onchange="Rellena(document.foravzcri.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2h,6)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
       <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="vreg1d" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.foravzcri.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2d" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2d,6)">   
       <?php echo $this->_tpl_vars['campoh']; ?>
 <input type="text" name="vreg1h" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.foravzcri.vreg2h)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2h" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vreg2h,6)">   
      </td>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="fecsold" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsold'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravzcri.fecsold)" onBlur="valagente(document.foravzcri.fecsold,document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar73');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="fecsolh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecsolh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
        <a href="javascript:showCal('Calendar74');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="fecpubd" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecpubd'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravzcri.fecpubd)" onBlur="valagente(document.foravzcri.fecpubd,document.foravzcri.fecpubh)"> 
        <a href="javascript:showCal('Calendar75');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="fecpubh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecpubh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravzcri.fecpubh)">
        <a href="javascript:showCal('Calendar76');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="fecvend" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecvend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravzcri.fecvend)" onBlur="valagente(document.foravzcri.fecvend,document.foravzcri.fecvenh)"> 
        <a href="javascript:showCal('Calendar77');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="fecvenh" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecvenh'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.foravzcri.fecvenh)">
        <a href="javascript:showCal('Calendar78');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayestatus'],'selected' => $this->_tpl_vars['estatus'],'output' => $this->_tpl_vars['arraydescri1']), $this);?>

        </select>
      </td>
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
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color">
        <input type="text" name="clase" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='pais'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraypais'],'selected' => $this->_tpl_vars['pais'],'output' => $this->_tpl_vars['arraynombre']), $this);?>

        </select>
      </td>
    </tr> 
 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo15']; ?>
</td>
      <td class="der-color">
        <input type="text" name="nombre" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>   

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
        <input type="text" name="titular" size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo17']; ?>
</td>
      <td class="der-color">
        <input type="text" name="agente" size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>  

    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo18']; ?>
</td>
      <td class="der-color">
        <input type="text" name="tramitante" size="65" maxlength="200" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>    

  </table><!--</font>--></center>
	<br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavzcri_neg.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  </div>  
</form>

</body>
</html>