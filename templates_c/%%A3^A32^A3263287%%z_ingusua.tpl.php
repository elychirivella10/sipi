<?php /* Smarty version 2.6.8, created on 2020-11-03 10:06:32
         compiled from z_ingusua.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_ingusua.tpl', 51, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forusing" action="z_gbuser.php" method="POST" onsubmit='return pregunta();'>
  <input type="hidden" name="usuario" value="<?php echo $this->_tpl_vars['login']; ?>
">
  <input type="hidden" name="nconex" value="<?php echo $this->_tpl_vars['n_conex']; ?>
">
  <input type="hidden" name="na_conex" value="<?php echo $this->_tpl_vars['na_conex']; ?>
">
  
  <div align="center">

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='cedula' size="8" maxlength="8" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,8,document.forusing.nombre)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' size="60" maxlength="60" onkeyup="checkLength(event,this,60,document.forusing.email)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color"><input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' size='50' maxlength="50"></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='cuenta' size="12" maxlength="12" onKeyPress="return acceptChar(event,3, this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color"><input type='password' name='passwd' size='8' maxlength="8" onKeyPress="return acceptChar(event,3, this)"></td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color"><input type='password' name='rpasswd' size='8' maxlength="8" onKeyPress="return acceptChar(event,3, this)"></td>
    </tr>
    <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='depto_id'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraydepto'],'selected' => $this->_tpl_vars['depto_id'],'output' => $this->_tpl_vars['arraynombre']), $this);?>

        </select>
    </td>
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="../comun/z_ingusua.php?conx=0&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../comun/z_usuarios.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  </div>  

</form>

</body>
</html>