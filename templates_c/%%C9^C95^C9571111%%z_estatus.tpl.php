<?php /* Smarty version 2.6.8, created on 2021-01-07 23:11:42
         compiled from z_estatus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'z_estatus.tpl', 20, false),array('function', 'html_options', 'z_estatus.tpl', 52, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="frmstatus1" action="z_estatus.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='estatus' size="3" maxlength="3" value='<?php echo $this->_tpl_vars['estatus']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.estatus,document.frmstatus2.estatus2)">&nbsp;
        <?php if ($this->_tpl_vars['vopc'] == 4): ?>
          <?php echo smarty_function_html_radios(array('name' => 'tipoder','values' => $this->_tpl_vars['tipo_der'],'selected' => $this->_tpl_vars['tipoder'],'output' => $this->_tpl_vars['dere_def']), $this);?>

        <?php endif; ?>    
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

<form name="frmstatus2" action="z_estatus.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>
  <input type ='hidden' name='estatus' value=<?php echo $this->_tpl_vars['estatus']; ?>
>
  <input type ='hidden' name='estatus2' value=<?php echo $this->_tpl_vars['estatus2']; ?>
>
  <input type ='hidden' name='vstring' value='<?php echo $this->_tpl_vars['vstring']; ?>
'>
  <input type ='hidden' name='campos' value='<?php echo $this->_tpl_vars['campos']; ?>
'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="90" maxlength="90" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmstatus2.publica)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="publica" <?php echo $this->_tpl_vars['modo2']; ?>
 >
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['apli_inf'],'selected' => $this->_tpl_vars['publica'],'output' => $this->_tpl_vars['apli_def']), $this);?>

        </select>
      </td>
    </tr>
    <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 1): ?>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_radios(array('name' => 'tipoder','values' => $this->_tpl_vars['tipo_der'],'selected' => $this->_tpl_vars['tipoder'],'output' => $this->_tpl_vars['dere_def'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
    <?php endif; ?>    
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
        <a href="z_estatus.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
        <a href="z_estatus.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
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