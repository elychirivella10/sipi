<?php /* Smarty version 2.6.8, created on 2020-10-29 15:23:07
         compiled from z_modrol.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">

<form name="forrole" action="z_modrol.php?vopc=2" method="POST" onsubmit="return pregunta();">
  <input type="hidden" name="idrole" value='<?php echo $this->_tpl_vars['idrole']; ?>
'>
  <input type="hidden" name="usuario" value='<?php echo $this->_tpl_vars['login']; ?>
'>
  <input type="hidden" name="nconex" value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type="hidden" name="na_conex" value='<?php echo $this->_tpl_vars['na_conex']; ?>
'>
  <input type="hidden" name="conx" value=0>
  <input type="hidden" name="salir" value=0> 

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='60' maxlength="60" onkeyup="this.value=this.value.toUpperCase()" onKeyPress="return acceptChar(event,4,this)" >
      </td>
    </tr>
    <tr>
     <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
     <td class="der-color">
       <textarea onkeyUp="max(this,1000)" onkeyPress="max(this,1000)" onChange="Vacio(document.forrole.descripcion)" cols='72' rows='4' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
'><?php echo $this->_tpl_vars['descripcion']; ?>
</textarea>
     </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="../comun/z_roles.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
</div>  
</form>

</body>
</html>