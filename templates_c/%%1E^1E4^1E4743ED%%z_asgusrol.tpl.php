<?php /* Smarty version 2.6.8, created on 2020-10-28 11:33:26
         compiled from z_asgusrol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_asgusrol.tpl', 23, false),array('function', 'html_checkboxes', 'z_asgusrol.tpl', 33, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forevrol" action="z_gbrolus.php" method="POST" onsubmit='return pregunta();'>
  <input type="hidden" name="totalusr" value='<?php echo $this->_tpl_vars['totalusr']; ?>
'>
  <input type="hidden" name="rol_user" value='<?php echo $this->_tpl_vars['rol_user']; ?>
'>    
  <input type="hidden" name="usuario" value='<?php echo $this->_tpl_vars['login']; ?>
'>
  <input type="hidden" name="nconex" value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type="hidden" name="na_conex" value='<?php echo $this->_tpl_vars['na_conex']; ?>
'>
      
  <div align="center">
  <table>
  <tr>  
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='rol_id'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayrole'],'selected' => $this->_tpl_vars['rol_id'],'output' => $this->_tpl_vars['arraynombre']), $this);?>

        </select>
      </td>
    </tr>
  </table></center>
  &nbsp;
  <?php echo $this->_tpl_vars['campo2']; ?>

  <table>
    <tr>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'rol_user','values' => $this->_tpl_vars['arraylogin'],'selected' => $this->_tpl_vars['user_r'],'output' => $this->_tpl_vars['arrayusuario'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </table></center>
  &nbsp;
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td>
    <td class="cnt">
      <a href="../comun/z_asgusrol.php?conx=0&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../comun/z_asigrol.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>

</body>
</html>