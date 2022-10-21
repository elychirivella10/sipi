<?php /* Smarty version 2.6.8, created on 2022-08-14 17:34:21
         compiled from z_ingevrol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_ingevrol.tpl', 25, false),array('function', 'html_checkboxes', 'z_ingevrol.tpl', 35, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forevrol" action="z_gbevrol.php" method="POST" onsubmit='return pregunta();'>
  <input type="hidden" name="totalevm" value='<?php echo $this->_tpl_vars['totalevm']; ?>
'>
  <input type="hidden" name="totalevp" value='<?php echo $this->_tpl_vars['totalevp']; ?>
'>  
  <input type="hidden" name="idm_even" value='<?php echo $this->_tpl_vars['idm_even']; ?>
'>    
  <input type="hidden" name="idp_even" value='<?php echo $this->_tpl_vars['idm_even']; ?>
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
        <?php echo smarty_function_html_checkboxes(array('name' => 'idm_even','values' => $this->_tpl_vars['marrayevento'],'selected' => $this->_tpl_vars['evento_m'],'output' => $this->_tpl_vars['marraydescev'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </table></center>
  &nbsp;
  <?php echo $this->_tpl_vars['campo3']; ?>

  <table>
    <tr>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'idp_even','values' => $this->_tpl_vars['parrayevento'],'selected' => $this->_tpl_vars['evento_p'],'output' => $this->_tpl_vars['parraydescev'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  <?php echo $this->_tpl_vars['campo4']; ?>

  <table>
    <tr>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'ida_even','values' => $this->_tpl_vars['aarrayevento'],'selected' => $this->_tpl_vars['evento_a'],'output' => $this->_tpl_vars['aarraydescev'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  <?php echo $this->_tpl_vars['campo5']; ?>

  <table>
    <tr>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'idi_even','values' => $this->_tpl_vars['iarrayevento'],'selected' => $this->_tpl_vars['evento_i'],'output' => $this->_tpl_vars['iarraydescev'],'separator' => "<br />"), $this);?>

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
      <a href="../comun/z_ingevrol.php?conx=0&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../comun/z_evenrol.php?conx=1&na_conex=<?php echo $this->_tpl_vars['na_conex']; ?>
&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=0"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>

</body>
</html>