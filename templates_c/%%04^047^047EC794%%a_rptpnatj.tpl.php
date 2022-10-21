<?php /* Smarty version 2.6.8, created on 2020-11-30 14:12:30
         compiled from a_rptpnatj.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'a_rptpnatj.tpl', 27, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<br>

<form name="forestanu" action="a_rptnatj.php" method="POST">
 <div align="center">
 <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
      <?php echo $this->_tpl_vars['campod']; ?>

        <input type="text" name="anod" align="right" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forestanu.anoh)" >
      <?php echo $this->_tpl_vars['campoh']; ?>

        <input type="text" name="anoh" align="right" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forestanu.tipo)" >
        
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

        </select>
      </td>
    </tr>
    
  </table></center>
  <br>
   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="a_rptpnatj.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>