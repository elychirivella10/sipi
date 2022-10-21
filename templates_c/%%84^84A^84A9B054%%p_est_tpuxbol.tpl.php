<?php /* Smarty version 2.6.8, created on 2021-01-10 15:22:18
         compiled from p_est_tpuxbol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_est_tpuxbol.tpl', 27, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forestanu" action="p_est_tpuxbol.php?vopc=1" method="POST">
 <div align="center">
 <br><br>
 <table>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo']; ?>
</td>
      <td class="der-color"><input type="text" name="bol" align="right" size="3" maxlength="3" 
               onKeyPress="return acceptChar(event,2, this)" 
               onkeyup="checkLength(event,this,3,document.forestanu.bol2)">
      </td>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo0']; ?>
</td>
      <td class="der-color"><input type="text" name="bol2" align="right" size="3" maxlength="3" 
           onKeyPress="return acceptChar(event,2, this)" 
           onkeyup="checkLength(event,this,3,document.forestanu.v2)">
      </td>
    </tr>
    <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	<td colspan="3" class="der-color">
        <select size=1 name="v2">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtipest'],'selected' => 1,'output' => $this->_tpl_vars['vtipsol']), $this);?>

        </select></td>
    </tr>
</table>
&nbsp; 
<table>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <select size=1 name="estatus">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['est_val'],'selected' => ' ','output' => $this->_tpl_vars['est_des']), $this);?>

        </select></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size=1 name="pais">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['pai_val'],'selected' => 1,'output' => $this->_tpl_vars['pai_des']), $this);?>

        </select></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <select size=1 name="tipomarca">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['tip_val'],'selected' => 1,'output' => $this->_tpl_vars['tip_des']), $this);?>

        </select></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color"><input type="text" name="clase" align="right" size="15" maxlength="15" value="" onKeyup="this.value=this.value.toUpperCase();">(Colocar c&oacute;digo completo o parcial...)</td> 
    </tr>
    </table></center>
	<p></p>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_graficar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_est_tpuxbol.php?vopc=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>