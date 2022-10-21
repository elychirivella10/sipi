<?php /* Smarty version 2.6.8, created on 2020-10-21 09:47:45
         compiled from p_dateven.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

  <div align="center">

  <form name="fordatev" action="p_gbevind.php" method="POST" onsubmit='return pregunta();''>
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='fecha_venc' value='<?php echo $this->_tpl_vars['fecha_venc']; ?>
'>
  <input type ='hidden' name='tipo_evento' value='<?php echo $this->_tpl_vars['tipo_evento']; ?>
'>
  <input type ='hidden' name='plazo_ley' value='<?php echo $this->_tpl_vars['plazo_ley']; ?>
'>
  <input type ='hidden' name='tipo_plazo' value='<?php echo $this->_tpl_vars['tipo_plazo']; ?>
'>
  <input type ='hidden' name='mensa_automatico' value='<?php echo $this->_tpl_vars['mensa_automatico']; ?>
'>
  <input type ='hidden' name='aplica' value='<?php echo $this->_tpl_vars['aplica']; ?>
'>
  <input type ='hidden' name='inf_adicional' value='<?php echo $this->_tpl_vars['inf_adicional']; ?>
'>
  <input type ='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
    
  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" nowrap="nowrap"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='anno' value='<?php echo $this->_tpl_vars['anno']; ?>
' align="right" readonly='readonly' size="3" maxlength="4">-
        <input type="text" name='numero' value='<?php echo $this->_tpl_vars['numero']; ?>
' align="right" readonly='readonly' size="6" maxlength="6">
      </td>
      <?php if ($this->_tpl_vars['modalidad'] == 'G' || $this->_tpl_vars['modalidad'] == 'M'): ?>
          <td rowspan="5" align="center" valign="top">
            <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
            <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="180" height="205">
          </td>
      <?php endif; ?>

    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color"><input type='text' name='fecha_solic' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' readonly='readonly' size='10'></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color"><input type='text' name='tipo_paten' value='<?php echo $this->_tpl_vars['tipo_paten']; ?>
' readonly='readonly' size='30'></td>
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
        <input type='text' name='fecha_evento' value='<?php echo $this->_tpl_vars['fecha_evento']; ?>
' size='10' onChange="valFecha(document.fordatev.fecha_evento)" onkeyup="checkLength(event,this,10,document.fordatev.documento)">
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar6');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
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
' size='10' maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
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
        <textarea onkeyUp="max(this,600)" onkeyPress="max(this,600)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='7' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
'><?php echo $this->_tpl_vars['comentario']; ?>
</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>600</font>
      </td>
     </tr>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['inf_adicional'] == 'A'): ?>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input type='text' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
' size="10" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,600)" onkeyPress="max(this,600)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='7' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
'><?php echo $this->_tpl_vars['comentario']; ?>
</textarea>
      </td>
     </tr>
     <tr>
      <td class="izq-color" >  &nbsp;</td>
      <td class="der-color">
        <font id='Digitado' color='red'>0</font> Caracteres escritos / Restan <font id='Restante' color='red'>600</font>
      </td>
     </tr>
    <?php endif; ?>

  </tr>
  </table>
  &nbsp;
  <table width="248">
  <tr>
    <td class="der">
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="p_eveind.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>

  </tr>
  </table>
  </div>  
  
</body>
</html>