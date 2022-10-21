<?php /* Smarty version 2.6.8, created on 2020-10-28 11:27:25
         compiled from z_elmrolus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_checkboxes', 'z_elmrolus.tpl', 21, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">

<form name="forrole1" action="z_elmrolus.php?vopc=2" method="POST" onsubmit="return pregunta1();" >  
  <input type="hidden" name="rol_id" value='<?php echo $this->_tpl_vars['rol_id']; ?>
'>
  <input type="hidden" name="nconex" value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type="hidden" name="na_conex" value='<?php echo $this->_tpl_vars['na_conex']; ?>
'>
  
  <?php if ($this->_tpl_vars['totalusr'] != 0): ?>
  <table width="900" >
  <tr>
    <tr>
      <td class="izq-color" width="150"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'idm_user','values' => $this->_tpl_vars['uarraylogins'],'selected' => $this->_tpl_vars['login_id'],'output' => $this->_tpl_vars['uarraynombre'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table>
  <?php endif; ?>    
  &nbsp;
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
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