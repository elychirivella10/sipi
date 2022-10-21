<?php /* Smarty version 2.6.8, created on 2021-06-19 08:25:51
         compiled from m_actrenbol.tpl */ ?>
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
  <br>
   <table>
   	<form name="formarcas2" action="m_actrenbol.php?vopc=2" method="post">
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lboletin']; ?>
</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='<?php echo $this->_tpl_vars['vbol']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.Guardar)" >
	<!--<tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechaevent']; ?>
</td>
	    <td class="der-color"><input size="8" type="text" name="vfbol" value='<?php echo $this->_tpl_vars['vfbol']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas2.vtip)"
	    onchange="valFecha(this,document.formarcas2.otro)"></td></tr> -->	
    </table>
    <br><br>
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" name="Guardar" value="Guardar"></td> 
        <td class="cnt"><a href="m_actrenbol.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>

