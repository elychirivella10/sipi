<?php /* Smarty version 2.6.8, created on 2020-11-05 13:55:55
         compiled from m_abfontxt.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_abfontxt.tpl', 52, false),array('modifier', 'truncate', 'm_abfontxt.tpl', 60, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/wforms.js"></script>  
  <script language="javascript" src="../libjs/r_funciones.js"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>  
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<form name="formarcas2" enctype="multipart/form-data" action="m_abfontxt2.php" method="POST">
  <br><br>
  <table>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="pedido1" size="6" maxlength="6"> y 
        <input type="text" name="pedido2" size="6" maxlength="6">
        </td>	
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecharec']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp;         
      </td>	
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="desdec" value='<?php echo $this->_tpl_vars['desdec']; ?>
' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     hasta <input type="text" name="hastac" value='<?php echo $this->_tpl_vars['hastac']; ?>
' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type="text" name="usuario" size="11" maxlength="12">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color" ><select size='1' name='vplus'>
                             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['vplus'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

                             </select><?php echo $this->_tpl_vars['campo72']; ?>

      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">    
         <select size="1" name="options">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodsede'],'selected' => $this->_tpl_vars['vsede'],'output' => ((is_array($_tmp=$this->_tpl_vars['vnomsede'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 15) : smarty_modifier_truncate($_tmp, 15))), $this);?>

         </select>                
        </td>	
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <select size="1" name="procesada">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipop'],'selected' => $this->_tpl_vars['procesada'],'output' => $this->_tpl_vars['arraydescp']), $this);?>

        </select>
      </td>
    </tr>
   
  </tr>
  </table>
  &nbsp;
  &nbsp;
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png"></td>
      <td class="cnt"><a href="m_abfontxt.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="m_panelfon.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
 </form>
</div>
</body>
</html>