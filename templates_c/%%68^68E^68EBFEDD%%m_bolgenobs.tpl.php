<?php /* Smarty version 2.6.8, created on 2020-10-31 17:46:58
         compiled from m_bolgenobs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_bolgenobs.tpl', 22, false),)), $this); ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <div align="center">
  <br><br><br>
	<form name="formarcas2" action="m_bolgenobs.php?vopc=3" method="post">
   <table>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lboletin1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vbol1" size="2" maxlength="3" 
	        value='<?php echo $this->_tpl_vars['vbol1']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vbol2)" >	
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lboletin2']; ?>
</td>
	    <td class="der-color"><input type="text" name="vbol2" size="2" maxlength="3" 
	        value='<?php echo $this->_tpl_vars['vbol2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vtip)" >	
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der-color"><select size=1 name="vtip">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtipest'],'selected' => 1,'output' => $this->_tpl_vars['vtipsol']), $this);?>

	    </select></td></tr>  
    </table>
     &nbsp;
     <table width="210">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Guardar"></td> 
        <td class="cnt"><a href="m_bolgenobs.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>

