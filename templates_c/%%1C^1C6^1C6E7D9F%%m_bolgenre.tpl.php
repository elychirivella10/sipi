<?php /* Smarty version 2.6.8, created on 2020-11-07 17:03:08
         compiled from m_bolgenre.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_bolgenre.tpl', 30, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forlisbol" action="m_genbolre.php" method="POST">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <div align="center">
  <br>
 <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <?php echo $this->_tpl_vars['campo2']; ?>
 <input type="text" name="desdet" size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(this,document.forlisbol.desdet)"> 
	     <?php echo $this->_tpl_vars['campo3']; ?>
 <input type="text" name="hastat" size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(this,document.forlisbol.hastat)">
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3"  onKeyPress="return acceptChar(event,2, this) onkeyup=checkLength(event,this,3,document.forlisbol.tipo)"> 
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipo'],'selected' => $this->_tpl_vars['tipo'],'output' => $this->_tpl_vars['arraytipo']), $this);?>

        </select>
      </td>
    </tr>
  </tr>
  </table><!--</font>--></center>
	<br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_bolgenre.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>