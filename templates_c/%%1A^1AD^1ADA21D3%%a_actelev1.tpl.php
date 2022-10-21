<?php /* Smarty version 2.6.8, created on 2020-10-27 09:35:32
         compiled from a_actelev1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'a_actelev1.tpl', 14, false),array('function', 'html_radios', 'a_actelev1.tpl', 71, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="document.forevento.input2.focus()">

  <div align="center">
  
  <table cellspacing="1" border="1">
  <form name="forevento" action="a_actelev2.php" method="POST">
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='fecha_venc' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecha_venc'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
'>
  <input type='hidden' name='modalidad' value=<?php echo $this->_tpl_vars['modalidad']; ?>
>
  <input type='hidden' name='tipo_marca' value=<?php echo $this->_tpl_vars['tipo_marca']; ?>
>
  <input type='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'> 

  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <!--<input type="text" name='anno' value='<?php echo $this->_tpl_vars['anno']; ?>
' readonly='readonly' align="right" size="3" maxlength="4">- -->
        <input type="text" name='numero' value='<?php echo $this->_tpl_vars['numero']; ?>
' readonly='readonly' align="right" size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
        <input type='text' name='fecha_solic' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' readonly='readonly' size='9'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type='text' name='vtipo_marca' value='<?php echo $this->_tpl_vars['vtipo_marca']; ?>
' readonly='readonly' size='61'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='67'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type='text' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
' readonly='readonly' size='3'>
        <input type='text' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' readonly='readonly' size='61'>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
         <input type='text' name='registro' value='<?php echo $this->_tpl_vars['registro']; ?>
' readonly='readonly' size='8'>
         &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo7']; ?>
&nbsp;&nbsp;
         <input type='text' name='fecha_regis' value='<?php echo $this->_tpl_vars['fecha_regis']; ?>
' readonly='readonly' size='9'>
      </td>
    </tr>     
  </table>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <div align="center">
  <table width="900" cellspacing="1" border="1">
    <tr>
      <td class="izq4-color" >Evento &nbsp;F. Evento &nbsp;&nbsp;&nbsp;F. Transac Secuencial E/Ant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comentario
      </td>
    </tr> 
    <tr>
      <td class="der1-color" >
        <?php echo smarty_function_html_radios(array('name' => 'secuencial','values' => $this->_tpl_vars['arrayevento'],'selected' => $this->_tpl_vars['secuencial'],'output' => $this->_tpl_vars['arraydescri'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </table>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <div align="center">
<!--  <table width="900">
    <tr>
      <td class="der-color" >C&oacute;digo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre del Titular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Domicilio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pa&iacute;s 
      </td>
    </tr> 
    <tr>
      <td class="der-color" >
        <?php echo smarty_function_html_radios(array('name' => 'titular','values' => $this->_tpl_vars['arraytitular'],'selected' => $this->_tpl_vars['titular'],'output' => $this->_tpl_vars['arraynombre'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </table>
-->
  &nbsp;
  <table width="200">
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_rojo.png"></td> 
    <td class="cnt"><a href="a_actelev.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

  </div>  
  
</body>
</html>