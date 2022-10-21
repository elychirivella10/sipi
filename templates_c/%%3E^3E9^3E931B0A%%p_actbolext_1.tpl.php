<?php /* Smarty version 2.6.8, created on 2020-11-10 19:27:10
         compiled from p_actbolext_1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_actbolext_1.tpl', 27, false),)), $this); ?>
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
  
  <div align="center">
   <table>
      <br><br><br>   
   	<form name="forpatentes2" action="p_actbolext_1.php?vopc=1" method="post">
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lboletin']; ?>
</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='<?php echo $this->_tpl_vars['vbol']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forpatentes2.vfbol)" >
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechaevent']; ?>
</td>
	    <td class="der-color"><input size="8" type="text" name="vfbol" value='<?php echo $this->_tpl_vars['vfbol']; ?>
'  onkeyup="checkLength(event,this,10,document.forpatentes2.vfvig)"
	    onchange="valFecha(this,document.forpatentes2.vfbol)"></td></tr>
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechavigen']; ?>
</td>
	    <td class="der-color"><input size="8" type="text" name="vfvig" value='<?php echo $this->_tpl_vars['vfvig']; ?>
'  onkeyup="checkLength(event,this,10,document.forpatentes2.vtip)"
	    onchange="valFecha(this,document.forpatentes2.vfvig)"></td></tr>		
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der-color"><select size=1 name="vtip">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtipest'],'selected' => 1,'output' => $this->_tpl_vars['vtipsol']), $this);?>

	    </select></td></tr>  
    </table>
    <br><br>
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" value="Guardar"></td> 
 <td class="cnt"><a href="p_actbolext_1.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
 <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>

