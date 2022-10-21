<?php /* Smarty version 2.6.8, created on 2020-10-21 12:16:20
         compiled from p_actelev1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'p_actelev1.tpl', 88, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="document.forevento.input2.focus()">

  <div align="center">
  
  <table cellspacing="1" border="1">
  <form name="forevento" action="p_actelev2.php" method="POST">
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='fecha_venc' value='<?php echo $this->_tpl_vars['fecha_venc']; ?>
'>
  <input type='hidden' name='tipo_paten' value='<?php echo $this->_tpl_vars['tipo_paten']; ?>
'>
  <input type='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>

  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='anno' value='<?php echo $this->_tpl_vars['anno']; ?>
' readonly='readonly' align="right" size="3" maxlength="4">-
        <input type="text" name='numero' value='<?php echo $this->_tpl_vars['numero']; ?>
' readonly='readonly' align="right" size="6" maxlength="6">
	     <?php if ($this->_tpl_vars['modalidad'] == 'G' || $this->_tpl_vars['modalidad'] == 'M'): ?>
          <td rowspan="7" align="center" valign="top">
            <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
            <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="180" height="205">
          </td>
        <?php endif; ?>
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
      <td class="der-color">
        <input type='text' name='vtipo_paten' value='<?php echo $this->_tpl_vars['vtipo_paten']; ?>
' readonly='readonly' size='30'>
        &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo9']; ?>
&nbsp;&nbsp;&nbsp;
        <input type='text' name='fecha_publi' value='<?php echo $this->_tpl_vars['fecha_publi']; ?>
' readonly='readonly' size='9'>         
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='81'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color"><input type='text' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
' readonly='readonly' size='3'><input type='text' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' readonly='readonly' size='75'></td>
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
         &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo8']; ?>
&nbsp;&nbsp;
         <input type='text' name='fecha_venci' value='<?php echo $this->_tpl_vars['fecha_venci']; ?>
' readonly='readonly' size='9'>         
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
         <input type='text' name='poder' value='<?php echo $this->_tpl_vars['poder']; ?>
' readonly='readonly' size='9'>
         &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo11']; ?>
&nbsp;&nbsp;
         <input type='text' name='agente' value='<?php echo $this->_tpl_vars['agente']; ?>
' readonly='readonly' size='9'>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color"><input type='text' name='tramitante' value='<?php echo $this->_tpl_vars['tramitante']; ?>
' readonly='readonly' size='70'></td>
    </tr> 
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
  <table width="900" cellspacing="1" border="1">
    <tr>
      <td class="izq4-color" >C&oacute;digo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre del Titular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Domicilio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pa&iacute;s 
      </td>
    </tr> 
    <tr>
      <td class="der-color" >
        <?php echo smarty_function_html_radios(array('name' => 'titular','values' => $this->_tpl_vars['arraytitular'],'selected' => $this->_tpl_vars['titular'],'output' => $this->_tpl_vars['arraynombre'],'separator' => "<br />"), $this);?>

      </td>
    </tr>
  </table>

  &nbsp;
  <table width="210">
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_azul.png"></td> 
    <td class="cnt"><a href="p_actelev.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

  </div>  
  
</body>
</html>