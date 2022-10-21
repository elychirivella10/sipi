<?php /* Smarty version 2.6.8, created on 2020-10-20 10:44:27
         compiled from a_dateven.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'a_dateven.tpl', 71, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

  <div align="center">

  <form name="fordatev" action="a_gbevind.php" method="POST" onsubmit='return pregunta();''>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='fecha_venc' value='<?php echo $this->_tpl_vars['fecha_venc']; ?>
'>
  <input type='hidden' name='tipo_evento' value='<?php echo $this->_tpl_vars['tipo_evento']; ?>
'>
  <input type='hidden' name='plazo_ley' value='<?php echo $this->_tpl_vars['plazo_ley']; ?>
'>
  <input type='hidden' name='tipo_plazo' value='<?php echo $this->_tpl_vars['tipo_plazo']; ?>
'>
  <input type='hidden' name='mensa_automatico' value='<?php echo $this->_tpl_vars['mensa_automatico']; ?>
'>
  <input type='hidden' name='aplica' value='<?php echo $this->_tpl_vars['aplica']; ?>
'>
  <input type='hidden' name='inf_adicional' value='<?php echo $this->_tpl_vars['inf_adicional']; ?>
'>
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" nowrap="nowrap"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='vsol' value='<?php echo $this->_tpl_vars['vsol']; ?>
' align="right" readonly='readonly' size="6" maxlength="6">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color"><input type='text' name='fecha_solic' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color"><input type='text' name='tipo_obra' value='<?php echo $this->_tpl_vars['tipo_obra']; ?>
' readonly='readonly' size='60'></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='83'>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type='text' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
' align="right" readonly='readonly' size='3'>
        <input type='text' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' readonly='readonly' size='77'>
      </td>
    </tr>
  </tr>

  </table></center>
  <p class= "cnt" >Datos del Evento</p>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type='text' name='evento' value='<?php echo $this->_tpl_vars['evento']; ?>
' align="right" readonly='readonly' size='3'>
        <input type='text' name='eve_nombre' value='<?php echo $this->_tpl_vars['eve_nombre']; ?>
' readonly='readonly' size='58'>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type='text' name='fecha_evento' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecha_evento'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
' size='9' onChange="valFecha(document.fordatev.fecha_evento)">
         <small><a href="javascript:showCal('Calendar6');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a></small>
      </td>
    </tr>
  </tr>
    <?php if ($this->_tpl_vars['inf_adicional'] == 'D'): ?>
     <input type ='hidden' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
'>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input type='text' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
' size='9' maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['inf_adicional'] == 'C'): ?>
     <input type ='hidden' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
'>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,255)" onkeyPress="max(this,255)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='4' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
'><?php echo $this->_tpl_vars['comentario']; ?>
</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>255</font>
      </td>
     </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['inf_adicional'] == 'A'): ?>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input type='text' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
' size="9" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,255)" onkeyPress="max(this,255)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='4' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
'><?php echo $this->_tpl_vars['comentario']; ?>
</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>255</font>
      </td>
     </tr>
    <?php endif; ?>

  </tr>
  </table></center>

  &nbsp;
  <table width="315">
  <tr>
    <td class="der">
    <td class="cnt"><a href="a_rptcronol.php?vsol=<?php echo $this->_tpl_vars['anno']; ?>
-<?php echo $this->_tpl_vars['numero']; ?>
"><input type="image" src="../imagenes/boton_cronologia_rojo.png"></a></td>
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td>
    <td class="cnt"><a href="a_eveind.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </tr>
  </table></center>

  </form>
  </div>
</body>
</html>