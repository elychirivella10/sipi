<?php /* Smarty version 2.6.8, created on 2022-08-09 13:03:53
         compiled from i_eveind.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus();">

<div align="center">

<form name="forevind1" action="i_ingreven.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='role' value=<?php echo $this->_tpl_vars['role']; ?>
>
  <input type ='hidden' name='anno' value=<?php echo $this->_tpl_vars['anno']; ?>
>
  <input type ='hidden' name='numero' value=<?php echo $this->_tpl_vars['numero']; ?>
>
  <input type ='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>  
  <br><br>
  <table >
       <tr><td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forevind1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forevind1.submit)" onchange="Rellena(document.forevind1.vsol2,6)">
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  
<form name="forevind2" action="i_ingreven.php?vopc=2" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='role' value=<?php echo $this->_tpl_vars['role']; ?>
>
  <input type ='hidden' name='anno' value=<?php echo $this->_tpl_vars['anno']; ?>
>
  <input type ='hidden' name='numero' value=<?php echo $this->_tpl_vars['numero']; ?>
>
  <input type ='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>  
  <input type ='hidden' name='vder' value=<?php echo $this->_tpl_vars['vder']; ?>
>
  
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color"><?php echo $this->_tpl_vars['campo2']; ?>
 </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['vreg1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forevind2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vreg2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forevind2.submit)" onchange="Rellena(document.forevind2.vreg2,6)">
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>

  </table>
  &nbsp; 
  <table border="1" cellspacing="1">	

  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color"><input type='text' name='fecha_solic' readonly='readonly' size='8'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color"><input type='text' name='tipo_marca' readonly='readonly' size='30'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='80'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color"><input type='text' name='estatus' readonly='readonly' size='3'><input type='text' name='descripcion' readonly='readonly' size='75'></td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  <table width="248" >
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="i_eveind.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>  
  </tr>
  </table>

  </div>  
</form>
<br><br><br><br><br><br><br><br><br>
</body>
</html>