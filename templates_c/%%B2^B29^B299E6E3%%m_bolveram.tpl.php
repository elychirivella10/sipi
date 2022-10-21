<?php /* Smarty version 2.6.8, created on 2020-11-07 17:23:24
         compiled from m_bolveram.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_bolveram.tpl', 20, false),)), $this); ?>
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
    <table>    
        <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="formarcas2" action="z_browse.php?vopc=0" method="post"> 
        <input type="hidden" name="nveces" value="<?php echo $this->_tpl_vars['nveces']; ?>
">
        <input type="hidden" name="nconexion" value="<?php echo $this->_tpl_vars['nconexion']; ?>
">  
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der-color"><select size=1 name="v2">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vtipest'],'selected' => 1,'output' => $this->_tpl_vars['vtipsol']), $this);?>

	    </select></td></tr>  
    </table>
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
     <input type='hidden' name='new_windows' value="<?php echo $this->_tpl_vars['new_windows']; ?>
">
     <br>
     <table width="190">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_editar_azul.png" value="Guardar"></td> 
 <!-- <td class="cnt"><a href="m_bolveram.php?nveces=<?php echo $this->_tpl_vars['nveces']; ?>
&nconexion=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td> -->
 <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['nconexion']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>

