<?php /* Smarty version 2.6.8, created on 2020-11-16 07:45:15
         compiled from p_bolediar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_bolediar.tpl', 21, false),)), $this); ?>
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
    <br><br>
    <table>    
        <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="forpatentes2" action="z_browse.php?vopc=0" method="post"> 
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lboletin']; ?>
</td>
	    <td class="der-color"><input type="text" name="v1" size="2" maxlength="3" 
	        onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forpatentes2.v2)" onchange="validbol(document.forpatentes2.v1)">
           <select size="1" name="v5" >
             <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['apli_inf'],'selected' => 1,'output' => $this->_tpl_vars['apli_def']), $this);?>

           </select> 
	        	
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der-color"><select size=1 name="v2">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtipest'],'selected' => 1,'output' => $this->_tpl_vars['vtipsol']), $this);?>

	    </select></td></tr>  
    </table>
     &nbsp;
     <input type='hidden' name='camposquery' value="<?php echo $this->_tpl_vars['camposquery']; ?>
">
     <input type='hidden' name='camposname'  value="<?php echo $this->_tpl_vars['camposname']; ?>
">
     <input type='hidden' name='tablas'      value="<?php echo $this->_tpl_vars['tablas']; ?>
">
     <input type='hidden' name='condicion'   value="<?php echo $this->_tpl_vars['condicion']; ?>
"> 
     <input type='hidden' name='orden'       value="<?php echo $this->_tpl_vars['orden']; ?>
">
     <input type='hidden' name='modo'        value="<?php echo $this->_tpl_vars['modo']; ?>
"> 
     <input type='hidden' name='modoabr'     value="<?php echo $this->_tpl_vars['modoabr']; ?>
">
     <input type='hidden' name='vurl'        value="<?php echo $this->_tpl_vars['vurl']; ?>
">
     <input type='hidden' name='tabladel'    value="<?php echo $this->_tpl_vars['tabladel']; ?>
">
     <input type='hidden' name='condicion2'  value="<?php echo $this->_tpl_vars['condicion2']; ?>
">
     <input type='hidden' name='tablains'    value="<?php echo $this->_tpl_vars['tablains']; ?>
">
     <input type='hidden' name='camposins'   value="<?php echo $this->_tpl_vars['camposins']; ?>
">
     <input type='hidden' name='valoresins'  value="<?php echo $this->_tpl_vars['valoresins']; ?>
">
     <input type='hidden' name='new_windows' value="<?php echo $this->_tpl_vars['new_windows']; ?>
">
     <br>
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_editar_azul.png" value="Guardar"></td> 
        <td class="cnt"><a href="p_bolediar.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
     <br><br><br><br><br><br><br><br><br><br><br><br><br>
    </form>
  </div>  
  </body>
</html>

