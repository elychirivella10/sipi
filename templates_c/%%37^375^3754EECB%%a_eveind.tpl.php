<?php /* Smarty version 2.6.8, created on 2020-10-20 10:44:19
         compiled from a_eveind.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus();" >

<div align="center">
 <br>
<form name="forevind1" action="a_ingreven.php?vopc=1&salir=1&conx=0" method="post">
  <input type='hidden' name='usuario' value='<?php echo $this->_tpl_vars['usuario']; ?>
'>
  <input type='hidden' name='role' value='<?php echo $this->_tpl_vars['role']; ?>
'>
  <input type='hidden' name='vsol' value='<?php echo $this->_tpl_vars['vsol']; ?>
'>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>

  <table>
       <tr><td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 
                onkeyup="checkLength(event,this,6,document.forevind1.vreg1)"
                onchange="Rellena(document.forevind1.vsol1,6)">
		 </td>
	    <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>
<form name="forevind2" action="a_ingreven.php?vopc=2&salir=1&conx=0" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='role' value=<?php echo $this->_tpl_vars['role']; ?>
>
  <input type ='hidden' name='anno' value=<?php echo $this->_tpl_vars['anno']; ?>
>
  <input type ='hidden' name='numero' value=<?php echo $this->_tpl_vars['numero']; ?>
>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>

	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color"><?php echo $this->_tpl_vars['campo2']; ?>
 </td>
	    <td class="der-color"><input type="text" name="vreg1" size="6" maxlength="6"
	        value='<?php echo $this->_tpl_vars['vreg1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forevind2.vreg1)"
		onChange="this.value=this.value.toUpperCase()">
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>

  </table>
  &nbsp;
  <table cellspacing="1" border="1">

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
  <table width="200" >
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td>
    <td class="cnt"><a href="a_eveind.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

  </div>
</form>
</body>
</html>