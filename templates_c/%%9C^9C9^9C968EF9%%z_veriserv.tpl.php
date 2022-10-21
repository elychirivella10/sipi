<?php /* Smarty version 2.6.8, created on 2022-04-30 20:30:24
         compiled from z_veriserv.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_veriserv.tpl', 38, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forsolpre" action="z_browser.php?vopc=1&vtp=0" method="POST">
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
      <td class="der7-color">
        <input type="text" name="control" value='<?php echo $this->_tpl_vars['control']; ?>
' size='9'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der7-color">
         <select size="1" name="escrito" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodser'],'selected' => $this->_tpl_vars['escrito'],'output' => $this->_tpl_vars['vnomser']), $this);?>

         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der7-color">
        <?php echo $this->_tpl_vars['campod']; ?>
<input type="text" name="fecdep1" value='<?php echo $this->_tpl_vars['fecdep1']; ?>
' size='9' onChange="valFecha(document.forsolpre.fecdep1);" onBlur="valagente(document.forsolpre.fecdep1,document.forsolpre.fecdep2)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar91');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     <?php echo $this->_tpl_vars['campoh']; ?>
<input type="text" name="fecdep2" value='<?php echo $this->_tpl_vars['fecdep2']; ?>
' size='9' onChange="valFecha(document.forsolpre.fecdep2)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar92');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
  </tr>
</table></center>

 <br><br>
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td> 
    <td class="cnt">
      <a href="z_veriserv.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
 
 <br><br><br><br><br><br><br><br><br><br>
 
</div>  
</form>

</body>
</html>