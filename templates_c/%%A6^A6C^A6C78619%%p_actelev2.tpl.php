<?php /* Smarty version 2.6.8, created on 2022-09-06 11:32:41
         compiled from p_actelev2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_actelev2.tpl', 37, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

  <div align="center">

  <form name="fordatev" action="p_actelev3.php?vopc=1" method="POST" onsubmit='return pregunta();''>
    <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
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
' readonly='readonly' size='9'></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_paten">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_paten'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
        &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;&nbsp;
        <input type='text' name='fecha_publi' value='<?php echo $this->_tpl_vars['fecha_publi']; ?>
' size='10' maxlength="10" onChange="valFecha(document.fordatev.fecha_publi)" onkeyup="checkLength(event,this,10,document.fordatev.estatus)">         
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='83' maxlength="400" onkeyup="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type='text' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
' align="right" size='3' maxlength="3" onKeyPress="return acceptChar(event,2,this)" >
        <input type='text' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' readonly='readonly' size='77'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
         <input type='text' name='registro' value='<?php echo $this->_tpl_vars['registro']; ?>
' readonly='readonly' size='8'>
         &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo17']; ?>
&nbsp;&nbsp;&nbsp;
         <input type='text' name='fecha_regis' value='<?php echo $this->_tpl_vars['fecha_regis']; ?>
' size='9'>
         &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['campo18']; ?>
&nbsp;&nbsp;&nbsp;
         <input type='text' name='fecha_venci' value='<?php echo $this->_tpl_vars['fecha_venci']; ?>
' size='10' maxlength="10" onChange="valFecha(document.fordatev.fecha_venci)" onkeyup="checkLength(event,this,10,document.fordatev.evento)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo19']; ?>
</td>
      <td class="der-color">
         <input type='text' name='poder' value='<?php echo $this->_tpl_vars['poder']; ?>
' readonly='readonly' size='9'>
         &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo20']; ?>
&nbsp;&nbsp;
         <input type='text' name='agente' value='<?php echo $this->_tpl_vars['agente']; ?>
' readonly='readonly' size='9'>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo21']; ?>
</td>
      <td class="der-color">
        <input type='text' name='tramitante' value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size='70' maxlength="100" onkeyup="this.value=this.value.toUpperCase()" >
      </td>
    </tr> 
  </tr>
  </table>
  <p class= "cnt" >Datos del Evento</p>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
        <input type='text' name='evento' value='<?php echo $this->_tpl_vars['evento']; ?>
' align="left" size='3' onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type='text' name='esta_ant' value='<?php echo $this->_tpl_vars['esta_ant']; ?>
' align="left" size='3' onKeyPress="return acceptChar(event,2,this)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
        <input type='text' name='fecha_event' value='<?php echo $this->_tpl_vars['fecha_event']; ?>
' size="10" maxlength="10" onChange="valFecha(document.fordatev.fecha_evento)" onkeyup="checkLength(event,this,10,document.fordatev.fecha_trans)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <input type='text' name='fecha_venc' value='<?php echo $this->_tpl_vars['fecha_venc']; ?>
' size="10" maxlength="10" onChange="valFecha(document.fordatev.fecha_trans)" onkeyup="checkLength(event,this,10,document.fordatev.comentario)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <input type='text' name='fecha_trans' value='<?php echo $this->_tpl_vars['fecha_trans']; ?>
' size="10" maxlength="10" onChange="valFecha(document.fordatev.fecha_trans)" onkeyup="checkLength(event,this,10,document.fordatev.comentario)">
      </td>
    </tr>
  </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo11']; ?>
</td>
      <td class="der-color">
        <input type='text' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
' size="10" maxlength="10" align="left" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color">
        <textarea onkeyUp="max(this,600)" onkeyPress="max(this,600)" onChange="Vacio(document.fordatev.comentario)" cols='72' rows='4' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
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
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo13']; ?>
</td>
      <td class="der-color">
        <input type='text' name='usuario' value='<?php echo $this->_tpl_vars['usuario']; ?>
' size="10" maxlength="12" align="left" onKeyPress="return acceptChar(event,3,this)" >
      </td>
     </tr>
     <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color">
        <input type='text' name='secuencial' value='<?php echo $this->_tpl_vars['secuencial']; ?>
' size="15" maxlength="15" readonly='readonly' align="left">
      </td>
     </tr>

  </tr>
  </table>

  <p class= "cnt" >DATOS DEL TITULAR O PROPIETARIO</p>
  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo24']; ?>
</td>
      <td class="der-color">
        <input type='text' name='tnombre' value='<?php echo $this->_tpl_vars['tnombre']; ?>
' size='74' maxlength="150" >
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo25']; ?>
</td>
      <td class="der-color">
        <input type='text' name='tdomicilio' value='<?php echo $this->_tpl_vars['tdomicilio']; ?>
' size='74' maxlength="100" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo26']; ?>
</td>
      <td class="der-color">
        <input type="text" name="input2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['tpais_resid']; ?>
' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.fordatev.botonname)" onchange="valagente(document.fordatev.input2,document.fordatev.pais)">-
        <select size="1" name="pais" <?php echo $this->_tpl_vars['modo2']; ?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraycodpais'],'selected' => $this->_tpl_vars['tpais_resid'],'output' => $this->_tpl_vars['arraynompais']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo27']; ?>
</td>
      <td class="der-color">
        <input type='text' name='titular' value='<?php echo $this->_tpl_vars['titular']; ?>
' size="7" maxlength="7" readonly='readonly' align="left">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table width="220">
  <tr>
    <td class="der">
    <td class="cnt"><input type="image" name='botonname' value="Guardar" src="../imagenes/boton_grabar_rojo.png"></td>
    <?php if ($this->_tpl_vars['secuencial'] != 0): ?>    
       <td class="cnt"><input type="image" name='botonname' value="Eliminar" src="../imagenes/boton_eliminar_rojo.png"></td>
    <?php endif; ?>
    <td class="cnt"><a href="p_actelev.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>

</div>  
</body>
</html>