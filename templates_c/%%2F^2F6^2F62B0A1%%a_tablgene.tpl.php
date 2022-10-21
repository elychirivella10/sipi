<?php /* Smarty version 2.6.8, created on 2021-04-28 14:26:41
         compiled from a_tablgene.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<br>
<div align="center">

<form name="frmstatus1" action="a_tablgene.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='estatus' size="6" maxlength="6" value='<?php echo $this->_tpl_vars['estatus']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 
               onKeyup="this.value=this.value.toUpperCase();">&nbsp;
      </td>	
      <td class="cnt">
        <?php if ($this->_tpl_vars['vopc'] == 4): ?>
                <input type ='hidden' name='accion' value='Modificacion'>
	        <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
        <?php endif; ?>
        <?php if ($this->_tpl_vars['vopc'] == 3): ?>
                <input type ='hidden' name='accion' value='Ingreso'> 
	        <input type='image' src="../imagenes/boton_nuevo_azul.png" value="Nuevo">
        <?php endif; ?> 
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="a_tablgene.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='estatus' value=<?php echo $this->_tpl_vars['estatus']; ?>
>

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="50" maxlength="50" 
               onKeyPress="return acceptChar(event,4, this)" 
               onkeyup="this.value=this.value.toUpperCase()" >
      </td>
    </tr>
  </tr>
  </table></center>
  <br>
  <table width="200" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 2 ) || $this->_tpl_vars['vopc'] == 4): ?>
        <a href="a_tablgene.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      <?php endif; ?>    
      <?php if (( $this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['accion'] == 1 ) || $this->_tpl_vars['vopc'] == 3): ?>
        <a href="a_tablgene.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
      <?php endif; ?>    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
<br><br><br><br><br><br><br>
</form>
</div>  
</body>
</html>