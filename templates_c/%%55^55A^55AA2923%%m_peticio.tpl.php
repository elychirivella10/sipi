<?php /* Smarty version 2.6.8, created on 2020-10-20 11:33:00
         compiled from m_peticio.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <!-- <H3><?php echo $this->_tpl_vars['titulo']; ?>
</H3> -->
  
  <div align="center">

    <table width="30%">
 <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="formarcas2" action="z_browse.php?vopc=0" method="post"> 
 	  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lcodigo']; ?>
</td>
	    <td class="der-color"><?php echo $this->_tpl_vars['vcodigo']; ?>

	
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lpalabra']; ?>
</td>
	<td class="der-color"><input type="text" name="v3" size="8" maxlength="8" 
          onchange="this.value=this.value.toUpperCase()"  onkeyup="checkLength(event,this,5,document.formarcas2.v3)">


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
  
     <table width="210">
        <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Editar">  Buscar  </td>
      <td class="cnt"><a href="m_peticio.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

