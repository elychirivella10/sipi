<?php /* Smarty version 2.6.8, created on 2021-01-06 10:18:09
         compiled from z_buspeticio.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_buspeticio.tpl', 22, false),)), $this); ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>    
  </head>
  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <div align="center">
  <table width="36%">
 <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="formarcas2" action="z_browspet.php?vopc=0" method="post"> 
   <br><br>     
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lcodigo']; ?>
</td>
	    <td class="der-color"><?php echo $this->_tpl_vars['vcodigo']; ?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['ltipobus']; ?>
</td>
      <td class="der-color">
        <select size="1" name="v5">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['v5'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lreferencia']; ?>
</td>
	<td class="der-color"><input type="text" name="v4" size="8" maxlength="8" 
          onchange="this.value=this.value.toUpperCase()"  onkeyup="checkLength(event,this,5,document.formarcas2.v4)">
      </td>
    </tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lpalabra']; ?>
</td>
	<td class="der-color"><input type="text" name="v3" size="8" maxlength="8" 
          onchange="this.value=this.value.toUpperCase()"  onkeyup="checkLength(event,this,5,document.formarcas2.v3)">
      </td>
   </tr>


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
     <input type='hidden' name='vpalabra'  value="<?php echo $this->_tpl_vars['vpalabra']; ?>
">
     <input type='hidden' name='v9'  value='C'>


     <br><br>  
     <table width="210">
        <tr>
      <td>
       <input type="image" src="../imagenes/boton_buscar_azul.png" value="buscar" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('buscar','','../imagenes/boton_buscar_azul.png',1);">
      </td>
      <td>	    
	    <a href="z_buspeticio.php" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	    <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a> 
      </td>      
      <td>
 	    <a href="../salir.php" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_azul.png',1);">
	    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>     
      </td>
        </tr>
     </table>
     <br><br><br><br><br><br><br><br><br><br><br><br><br>
    </form>
  </div>  
  </body>
</html>

