<?php /* Smarty version 2.6.8, created on 2020-11-23 13:06:14
         compiled from a_elisolda.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas1" action="a_elisolda.php?vopc=1" method="post">
  <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol" size="6" maxlength="6" 
	        value='<?php echo $this->_tpl_vars['vsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.vplan)" onchange="Rellena(document.formarcas1.vsol,6)">
       &nbsp;</td>
	    <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

</form>				  

  </table>
  &nbsp; 
  <table cellspacing="0">	
  <tr>   
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
	   <td class="der-color"><input size="9" type="text" name="vplan" value='<?php echo $this->_tpl_vars['vplan']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
	   <td class="der-color"><input size="9" type="text" name="vfec" value='<?php echo $this->_tpl_vars['vfec']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
	   <td class="der-color"><input size="72" type="text" name="vnom" value='<?php echo $this->_tpl_vars['vnom']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='<?php echo $this->_tpl_vars['vtipo']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
>-
                            <input size="30" type="text" name="vtip" value='<?php echo $this->_tpl_vars['vtip']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
	   <td class="der-color"><input size="72" type="text" name="vdesc" value='<?php echo $this->_tpl_vars['vdesc']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>
	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
	   <td class="der-color"><input size="20" type="text" name="vidioma" value='<?php echo $this->_tpl_vars['vidioma']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>

	 <tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>

	 <tr>
	    <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
>
	                <input size="63" type="text" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
></td>
    </tr>
  </tr>
  </table>		
</form>
&nbsp;     

<form name="formarcas3" action="a_elisolda.php?vopc=3" method="post" onsubmit='return pregunta1();'>
  <input type="hidden" name="vsol" value='<?php echo $this->_tpl_vars['vsol']; ?>
'>
  <input type="hidden" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
'>
  <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>

  <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_eliminar_rojo.png" value="Eliminar"></td> 
      <td class="cnt"><a href="a_elisolda.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>

