<?php /* Smarty version 2.6.8, created on 2020-10-21 12:36:47
         compiled from z_agentes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_agentes.tpl', 60, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<?php if ($this->_tpl_vars['vopc'] == 3): ?>
<form name="frmagente1" action="z_agentes.php?vopc=5" method="POST">
<?php endif;  if ($this->_tpl_vars['vopc'] == 4): ?>
<form name="frmagente1" action="z_agentes.php?vopc=1" method="POST">
<?php endif; ?>
  <table>
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='agente' size="5" maxlength="5" value='<?php echo $this->_tpl_vars['agente']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,5,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.agente,document.frmstatus2.agente2)">&nbsp;
      </td>	
      <td class="cnt">
        <?php if ($this->_tpl_vars['vopc'] == 3): ?>
           <input type='image' src="../imagenes/boton_nuevo_azul.png" value="Nuevo">
        <?php endif; ?>
        <?php if ($this->_tpl_vars['vopc'] == 4): ?>
	        <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">  
        <?php endif; ?>
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmagente2" action="z_agentes.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='agente' value=<?php echo $this->_tpl_vars['agente']; ?>
>
  <input type ='hidden' name='agente2' value=<?php echo $this->_tpl_vars['agente2']; ?>
>
  <input type ='hidden' name='vstring' value='<?php echo $this->_tpl_vars['vstring']; ?>
'>
  <input type ='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="90" maxlength="90" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmagente2.domicilio)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <!--<select size='1' name='lced' value='<?php echo $this->_tpl_vars['lced']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
>";
         <option value='V'>V</option>
         <option value='E'>E</option>
         <option value='P'>P</option>
        </select>-->
        <select size="1" name="lced" <?php echo $this->_tpl_vars['modo1']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['doc_inf'],'selected' => $this->_tpl_vars['lced'],'output' => $this->_tpl_vars['doc_def']), $this);?>

        </select>
        <input type="text" name="cedula" value='<?php echo $this->_tpl_vars['cedula']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="14" maxlength="14" onkeyup="checkLength(event,this,14,document.frmagente2.nombre);fn(this.form,this);">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type="text" name='domicilio' value='<?php echo $this->_tpl_vars['domicilio']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="90" maxlength="120" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmagente2.profesion)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <select size="1" name="profesion" <?php echo $this->_tpl_vars['modo1']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['apli_inf'],'selected' => $this->_tpl_vars['profesion'],'output' => $this->_tpl_vars['apli_def']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <input type="text" name='codcolegio' value='<?php echo $this->_tpl_vars['codcolegio']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color">
        <input type="text" name='inpre' value='<?php echo $this->_tpl_vars['inpre']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type="text" name='celular' value='<?php echo $this->_tpl_vars['celular']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="13" maxlength="12" onkeyup="number_tel(this);fn(this.form,this);">
        <small>Formato: 0000-0000000 (c&oacute;digo-n&uacute;mero)</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type="text" name='telefonoh' value='<?php echo $this->_tpl_vars['telefonoh']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="13" maxlength="12" onkeyup="number_tel(this);fn(this.form,this);">
        <small>Formato: 0000-0000000 (c&oacute;digo area-n&uacute;mero)</small>   
        <font face="Arial" color="#800000" size="2">*</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="69" maxlength="90" onkeyup="number_mail(this);fn(this.form,this);" onchange="isEmail2(document.forusing.email.value,this.form);" >
	<br><font face='Time New Roman Bold' size="1">Por ejemplo: nombre@ejemplo.com</font></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email2' value='<?php echo $this->_tpl_vars['email2']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="69" maxlength="90" onkeyup="number_mail(this);fn(this.form,this);" onchange="isEmail2(document.forusing.email2.value,this.form);">
	<br><font face='Time New Roman Bold' size="1">Por ejemplo: nombre@ejemplo.com</font></br>
      </td>
    </tr>
      
  </tr>
  </table></center>
  &nbsp;
  
  <table width="210">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_grabar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 5): ?>
         <a href="z_agentes.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="z_agentes.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
      
    </td>      
    <td class="cnt">
        <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
  
  
  <!-- <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 5): ?>
        <a href="z_agentes.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
        <a href="z_agentes.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php endif; ?>    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table> -->

</form>
</div>  
</body>
</html>