<?php /* Smarty version 2.6.8, created on 2021-01-17 09:30:25
         compiled from p_perisol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_perisol.tpl', 28, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forcaduca" action="p_perpusol.php?vopc=2" method="POST">
  <div align="center">

  <br><br>
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
      <?php echo $this->_tpl_vars['campod']; ?>
 <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcaduca.vsol2)" onchange="Rellena(document.forcaduca.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcaduca.vsol1h)" onchange="Rellena(document.forcaduca.vsol2,6)"><?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcaduca.vsol2h)" onchange="Rellena(document.forcaduca.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcaduca.fecpub)" onchange="Rellena(document.forcaduca.vsol2h,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayestatus'],'selected' => $this->_tpl_vars['estatus'],'output' => $this->_tpl_vars['arraydescri1']), $this);?>

        </select>
      </td>
    </tr> 
  </table></center>
  <br><br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="actualizar" src="../imagenes/boton_procesar_azul.png"></td>
      <td class="cnt"><a href="p_perisol.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br>

</body>
</html>