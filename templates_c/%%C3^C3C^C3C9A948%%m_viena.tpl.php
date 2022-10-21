<?php /* Smarty version 2.6.8, created on 2021-06-08 16:07:56
         compiled from m_viena.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="frmstatus1" action="m_viena.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='ccv' size="6" maxlength="6" value='<?php echo $this->_tpl_vars['ccv']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.ccv,document.frmstatus2.ccv2)">&nbsp;
      </td>	
      <td class="cnt">
        <?php if ($this->_tpl_vars['vopc'] == 4): ?>
	        <input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
        <?php endif; ?>
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="m_viena.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value='<?php echo $this->_tpl_vars['accion']; ?>
'>
  <input type ='hidden' name='ccv' value='<?php echo $this->_tpl_vars['ccv']; ?>
'>
  <input type ='hidden' name='ccv2' value='<?php echo $this->_tpl_vars['ccv2']; ?>
'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <textarea rows="3" name="nombre" cols="80" onkeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
      </td>
    </tr>
      
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
        <a href="m_viena.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
        <a href="m_viena.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>