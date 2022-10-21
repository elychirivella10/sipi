<?php /* Smarty version 2.6.8, created on 2020-11-05 12:34:38
         compiled from m_datplanbus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_datplanbus.tpl', 56, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio de Solicitud de Búsqueda Fonetica/Gráfica</title>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../libjs/wforms.js"></script>  
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_rptplanilla.php?vopc=5" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='tipfon' value='F'> 
  <input type='hidden' name='prioridad1' value='<?php echo $this->_tpl_vars['prioridad1']; ?>
'>
  <input type='hidden' name='indole1' value='<?php echo $this->_tpl_vars['indole1']; ?>
'>
  <input type='hidden' name='tipfon' value='F'>
  <input type='hidden' name='tipgra' value='G'>

<div align="center">
<table width="752" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center' class='Estilo3'><strong><span>&nbsp;COMPLETE LOS DATOS DE LA FACTURA O EXONERACION&nbsp;</span></strong></legend>
  <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
         <input type="text" name="factura" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['factura']; ?>
' size="8" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.fechadep)" readonly>
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: F9999999 o E9999999</font> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fechadep" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fechadep']; ?>
' size="11" maxlength="11" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.montodep)" onchange="valFecha(this,document.formarcas2.montodep);" class="required">
         &nbsp;&nbsp;
         <!-- <a href="javascript:showCal('Calendar85');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> -->
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: dd/mm/aaaa</font> 
         <font class="obligatorio">*</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" <?php echo $this->_tpl_vars['modo1']; ?>
 class="required"> 
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['prioridad'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
        <font class="obligatorio">*</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
         <input tabindex="8" type="text" name="solicitant" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['solicitant']; ?>
' size="59" maxlength="80" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,80,document.formarcas2.indole)" class="required">
         <font class="obligatorio">*</font>
      </td>
    </tr> 
    <!-- <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
           <select size="1" name="indole" class="required">
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vindole_id'],'selected' => $this->_tpl_vars['indole'],'output' => $this->_tpl_vars['vindole_de']), $this);?>

           </select>
         <font class="obligatorio">*</font>
      </td>
    </tr>  -->
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <select size="1" name="lced" <?php echo $this->_tpl_vars['modo2']; ?>
 class="required">
           <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['lced_id'],'selected' => $this->_tpl_vars['lced'],'output' => $this->_tpl_vars['lced_de']), $this);?>

        </select>
        <input tabindex="9" type="text" name='nced' size="9" maxlength="9" value='<?php echo $this->_tpl_vars['nced']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)" class="required">
         <font class="obligatorio">*</font>
      </td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input tabindex="10" type="text" name='telefono' value='<?php echo $this->_tpl_vars['telefono']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="13" maxlength="14" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)" class="required"> 
        <small>Formato: (9999) 9999999</small>   
        <font class="obligatorio">*</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
         <select size="1" name="vsede" <?php echo $this->_tpl_vars['modo1']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodsede'],'selected' => $this->_tpl_vars['vsede'],'output' => $this->_tpl_vars['vnomsede']), $this);?>

         </select>
         <font class="obligatorio">*</font>
      </td>
    </tr>          
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
         <input type="text" id="nbusfon" name="nbusfon" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['nbusfon']; ?>
' size="2" maxlength="2" style="text-align: left" onKeyPress="return acceptChar(event,2, this)" onkeyup="valminimo(this.form);valcantidad(document.formarcas2.tipfon,this.form);" class="required"> 
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;M&aacute;x. Cantidad de b&uacute;squedas 99</font> 
         <font class="obligatorio">**</font>
      </td>
    </tr>  
   <!-- <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color">
         <input type="text" id="nbusgra" name="nbusgra" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['nbusgra']; ?>
' size="2" maxlength="2" style="text-align: left" onKeyPress="return acceptChar(event,2, this)" onkeyup="valminimo(this.form);valcantidad(document.formarcas2.tipgra,this.form);" class="required"> 
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;M&aacute;x. Cantidad de b&uacute;squedas 99</font> 
         <font class="obligatorio">**</font>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color">
        <select size='1' name='vplus' onchange="valenvio(this.form);">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['vplus'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

        </select>
         <font class="obligatorio">*</font>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);valenvio(this.form);">
	     <br><font size="1">Cuenta correo para el env&iacute;o de la B&uacute;squeda, por ejemplo: correo@ejemplo.com</font></br>
      </td>
    </tr> -->
    
  <tr>
  </table>

</td>

  <tr></tr> <tr></tr>
  <tr>
      <td>
	 <font class='obligatorio'>&nbsp;&nbsp;* Informaci&oacute;n obligatoria, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;** Dato Obligatorio cuyo valor m&iacute;nimo es Cero (0)</font>
      </td>
  </tr>
</table>
</fieldset>
  &nbsp;
 
  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="11" name="Continuar" type="image" src="../imagenes/boton_imprimir_rojo.png" value="Continuar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_ingfacbus.php?vopc=1"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
         <a><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 5): ?>
         <a href="m_ingfacbus.php?vopc=1"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 6 || $this->_tpl_vars['vopc'] == 8): ?>
         <a href="m_ingfacbus.php?vopc=1"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
  
</div>  
</form>
 </td>
 </tr>
</table>
<!-- </body>
</html> -->