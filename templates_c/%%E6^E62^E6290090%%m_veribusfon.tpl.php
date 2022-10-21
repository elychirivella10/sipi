<?php /* Smarty version 2.6.8, created on 2020-11-17 12:09:28
         compiled from m_veribusfon.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_veribusfon.tpl', 60, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="formarcas2" action="z_browfon.php?vopc=1&vtp=0" method="POST">
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
<br>
<table cellspacing="3" border="0">
  <tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo2']; ?>
 <input type="text" name="desdec" value='<?php echo $this->_tpl_vars['desdec']; ?>
' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	<?php echo $this->_tpl_vars['campo3']; ?>
 <input type="text" name="hastac" value='<?php echo $this->_tpl_vars['hastac']; ?>
' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="recibo" size="7" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.planilla)" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type="text" name="pedido1" size="6" maxlength="6"> y 
        <input type="text" name="pedido2" size="6" maxlength="6">
        </td>	
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
         <input type="text" name="planilla" size="7" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.usuario)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" ><select size='1' name='envio'>
                             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['envio'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

                             </select>
      </td>
    </tr>
  </tr>
</table></center>

 <br><br>
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td> 
    <td class="cnt">
      <a href="m_veribusfon.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>      
    <td class="cnt">
      <a href="m_panelfon.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
 
 <br><br><br><br><br><br><br><br><br><br>
 
</div>  
</form>

</body>
</html>