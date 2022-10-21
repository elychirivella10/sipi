<?php /* Smarty version 2.6.8, created on 2020-10-20 10:44:24
         compiled from a_ingreven.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'a_ingreven.tpl', 15, false),array('function', 'html_options', 'a_ingreven.tpl', 52, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

  <div align="center">

  <table cellspacing="1" border="1">
  <form name="forevento" action="a_dateven1.php?salir=1&conx=0" method="POST">
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='role' value=<?php echo $this->_tpl_vars['role']; ?>
>
  <input type='hidden' name='fecha_venc' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecha_venc'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
'>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>

  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='vsol' value='<?php echo $this->_tpl_vars['vsol']; ?>
' readonly='readonly' align="right" size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color"><input type='text' name='fecha_solic' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color"><input type='text' name='tipo_obra' value='<?php echo $this->_tpl_vars['tipo_obra']; ?>
' readonly='readonly' size='40'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='66'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color"><input type='text' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
' readonly='readonly' size='3'><input type='text' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' readonly='readonly' size='60'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color"><input type='text' name='registro' value='<?php echo $this->_tpl_vars['registro']; ?>
' readonly='readonly' size='8'></td>
    </tr>
    <!-- <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color" >
        <select size='1' name='eventos_id'>
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['eventos_id'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type="text" name="input2" value='<?php echo $this->_tpl_vars['eventos_id']; ?>
' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.forevento.eventos_id)" onchange="valagente(document.forevento.input2,document.forevento.eventos_id)">-
        <select size="1" name="eventos_id" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['eventos_id'],'output' => $this->_tpl_vars['arraydescri']), $this);?>

        </select>
      </td>
    </tr>

  </tr>
  </table>
  &nbsp;
  <table width="200">
  <tr>
    <td class="cnt"><a href="a_rptcronol.php?vsol=<?php echo $this->_tpl_vars['vsol']; ?>
"><input type="image" src="../imagenes/boton_cronologia_rojo.png"></a></td>
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_rojo.png"></td>
    <td class="cnt"><a href="a_eveind.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

  </form>
  </div>
</body>
</html>