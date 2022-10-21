<?php /* Smarty version 2.6.8, created on 2020-10-29 10:20:16
         compiled from z_ingobrol.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'z_ingobrol.tpl', 21, false),array('function', 'html_checkboxes', 'z_ingobrol.tpl', 31, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<form name="forobrol" action="z_ingobrol.php?vopc=2" method="POST"'>
  <input type ='hidden' name='rol_id' value=<?php echo $this->_tpl_vars['rol_id']; ?>
>
  <input type ='hidden' name='id_objeto' value=<?php echo $this->_tpl_vars['id_objeto']; ?>
>    
  <input type ='hidden' name='totalobj' value=<?php echo $this->_tpl_vars['totalobj']; ?>
>

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
        <?php echo smarty_function_html_checkboxes(array('name' => 'id_objeto','values' => $this->_tpl_vars['arrayobjeto'],'selected' => $this->_tpl_vars['objeto'],'output' => $this->_tpl_vars['arraydescob'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </table>
&nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="z_ingobrol.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>
</body>
</html>