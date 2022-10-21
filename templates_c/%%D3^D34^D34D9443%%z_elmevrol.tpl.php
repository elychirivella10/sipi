<?php /* Smarty version 2.6.8, created on 2020-10-28 21:52:15
         compiled from z_elmevrol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_elmevrol.tpl', 18, false),array('function', 'html_checkboxes', 'z_elmevrol.tpl', 46, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
<div align="center">

<!-- <form name="forrole" action="z_elmevrol.php?vopc=1" method="POST">
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
        <input type='<?php echo $this->_tpl_vars['submitbutton']; ?>
' name='submit' value='Buscar'>
       </td>
    </tr>
  </tr>
  </table>
</form>    -->   

<form name="forrole1" action="z_elmevrol.php?vopc=2" method="POST" onsubmit="return pregunta1();" >  
  <input type='hidden' name='rol_id' value='<?php echo $this->_tpl_vars['rol_id']; ?>
'>
  <input type="hidden" name="nconex" value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type="hidden" name="na_conex" value='<?php echo $this->_tpl_vars['na_conex']; ?>
'>

  <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='rol' value='<?php echo $this->_tpl_vars['rol_id']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="13" maxlength="13">&nbsp;-&nbsp; 
        <input type="text" name='nbrol' value='<?php echo $this->_tpl_vars['nbrol']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 size="73" maxlength="73">
      </td>
  </tr>

  <?php if ($this->_tpl_vars['totalevm'] != 0): ?>
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'idm_even','values' => $this->_tpl_vars['marrayevento'],'selected' => $this->_tpl_vars['evento_m'],'output' => $this->_tpl_vars['marraydescev'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table>
  <?php endif; ?>    
  &nbsp;
  <?php if ($this->_tpl_vars['totalevp'] != 0): ?>
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'idp_even','values' => $this->_tpl_vars['parrayevento'],'selected' => $this->_tpl_vars['evento_p'],'output' => $this->_tpl_vars['parraydescev'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table>
  <?php endif; ?>    
  &nbsp;
  <?php if ($this->_tpl_vars['totaleva'] != 0): ?>
  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_checkboxes(array('name' => 'ida_even','values' => $this->_tpl_vars['aarrayevento'],'selected' => $this->_tpl_vars['evento_a'],'output' => $this->_tpl_vars['aarraydescev'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </tr>
  </table>
  <?php endif; ?>    
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
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