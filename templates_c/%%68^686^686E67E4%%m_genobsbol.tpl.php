<?php /* Smarty version 2.6.8, created on 2020-10-20 09:11:28
         compiled from m_genobsbol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_genobsbol.tpl', 39, false),)), $this); ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <!-- <H3><?php echo $this->_tpl_vars['subtitulo']; ?>
</H3> -->
  <br>
  <div align="center">
   <!-- <form name="formarcas1">
      <input type="hidden" name="nveces" value="<?php echo $this->_tpl_vars['nveces']; ?>
">
      <input type="hidden" name="nconexion" value="<?php echo $this->_tpl_vars['nconexion']; ?>
">
      <table>
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['solicitud1']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)"
		onchange="Rellena(document.formarcas1.vsol1,4);document.formarcas2.vsoli1.value=this.value;">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['solicitud2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.vsol3)" onchange="Rellena(document.formarcas1.vsol2,6);document.formarcas2.vsoli2.value=this.value;">
		hasta:
                <input type="text" name="vsol3" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['solicitud3']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol4)" onchange="Rellena(document.formarcas1.vsol3,4);document.formarcas2.vsoli3.value=this.value;">-
		                  <input type="text" name="vsol4" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['solicitud4']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vbol)" onchange="Rellena(document.formarcas1.vsol4,6);document.formarcas2.vsoli4.value=this.value;"><td><tr>
	</form> -->
	<table> 
	<form name="formarcas2" action="m_genobsbol.php?vopc=3" method="post">
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lboletin']; ?>
</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='<?php echo $this->_tpl_vars['vbol']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.ctip)" ></td></tr>	
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['cboletin']; ?>
</td>
	    <td class="der-color"><input type="text" name="cbol" size="2" maxlength="3" 
	        value='<?php echo $this->_tpl_vars['cbol']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vtip)" ></td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der-color"><select size=1 name="vtip">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtipest'],'selected' => 1,'output' => $this->_tpl_vars['vtipsol']), $this);?>

	    </select></td></tr>  
    </table>
    <br><br>
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Guardar"></td> 
        <td class="cnt"><a href="m_genobsbol.php?nveces=<?php echo $this->_tpl_vars['nveces']; ?>
&nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>

