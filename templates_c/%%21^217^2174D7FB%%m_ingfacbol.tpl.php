<?php /* Smarty version 2.6.8, created on 2020-10-22 10:51:05
         compiled from m_ingfacbol.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio de Solicitud de Búsqueda Fonetica</title>
  <script language="javascript" src="../libjs/wforms.js"></script>  
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_evepago.php?vopc=4" method="POST" onsubmit='return pregunta();'>

<div align="center">
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center'><strong><span>&nbsp;INGRESE DATOS DE FACTURA Y BOLETIN&nbsp;</span></strong></legend>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
         <input type="text" name="factura" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['factura']; ?>
' size="6" maxlength="6" onkeyup="number_sindec(this);checkLength(event,this,6,document.formarcas2.continuar)" class="validate-integer required">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="boletin" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['boletin']; ?>
' size="3" maxlength="3" onkeyup="number_sindec(this);checkLength(event,this,3,document.formarcas2.continuar)" class="validate-integer required">
      </td>
    </tr>
  <tr>
  </table>

</td>

  <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
  <tr>

  </tr>
</table>
</fieldset>
  &nbsp;
 
  <table width="210">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_buscar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
         <a href="m_ingfacbol.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
    </td>      
    <td class="cnt">
        <a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</div>  
</form>
 </td>

 </tr>
</table>

<br><br><br><br><br><br><br><br><br><br>
<!-- </body>
</html> -->