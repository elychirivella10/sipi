<?php /* Smarty version 2.6.8, created on 2021-07-28 11:16:22
         compiled from m_actenvgra.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_actenvgra.tpl', 54, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>
<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">
<?php if ($this->_tpl_vars['vopc'] == 4): ?>
  <form name="formarcas1" action="m_actenvgra.php?vopc=1" method="post">
<?php endif; ?> 		  
  <input type ='hidden' name='login' value=<?php echo $this->_tpl_vars['login']; ?>
>
  <input type ='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='vfiltro' value=<?php echo $this->_tpl_vars['vfiltro']; ?>
>
    
  <table>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input tabindex="1" type="text" name="recibo" size="7" maxlength="8" value='<?php echo $this->_tpl_vars['recibo']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onkeyup="checkLength(event,this,8,document.formarcas1.vsol1)" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input tabindex="2" type="text" name="vsol1" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)">
      </td>
      <td class="cnt">
         &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png" value="Buscar">  
      </td>
    </tr>
  </table>
</form>				  

<?php if ($this->_tpl_vars['vopc'] == 1): ?>
<form name="formarcas2" enctype="multipart/form-data" action="m_actenvgra.php?vopc=2" method="POST" onsubmit='return pregunta();'>
<?php endif; ?>    
  <input type ='hidden' name='login' value=<?php echo $this->_tpl_vars['login']; ?>
>
  <input type ='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type ='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='auxnum' value=<?php echo $this->_tpl_vars['auxnum']; ?>
>
  <input type ='hidden' name='vfiltro' value=<?php echo $this->_tpl_vars['vfiltro']; ?>
>
  <input type ='hidden' name='recibo' value=<?php echo $this->_tpl_vars['recibo']; ?>
>

  <table border="1" cellspacing="1">
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size='1' name='vplus' onchange="valenvio(this.form);" <?php echo $this->_tpl_vars['modo4']; ?>
>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayplus'],'selected' => $this->_tpl_vars['vplus'],'output' => $this->_tpl_vars['arraydesplus']), $this);?>

        </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);">
	     <br><font size="1">Cuenta correo para el env&iacute;o de la B&uacute;squeda, por ejemplo: correo@ejemplo.com</font></br>
      </td>
    </tr>
  </table>
  &nbsp;
  &nbsp;

  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="11" name="Guardar" type="image" src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_actenvgra.php?vopc=4"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>