<?php /* Smarty version 2.6.8, created on 2021-06-08 12:55:19
         compiled from m_dateven_ti.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'm_dateven_ti.tpl', 66, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../librerias/library.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

  <div align="center">
  <br>
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" nowrap="nowrap"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name='anno1' value='<?php echo $this->_tpl_vars['anno']; ?>
' align="right" readonly='readonly' size="3" maxlength="4">-
        <input type="text" name='numero1' value='<?php echo $this->_tpl_vars['numero']; ?>
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
      <td class="der-color"><input type='text' name='fecha_solic1' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' readonly='readonly' size='10'></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color"><input type='text' name='tipo_marca1' value='<?php echo $this->_tpl_vars['tipo_marca']; ?>
' readonly='readonly' size='30'></td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre1' value='<?php echo $this->_tpl_vars['nombre']; ?>
' readonly='readonly' size='83'>
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
        <input type='text' name='estatus1' value='<?php echo $this->_tpl_vars['estatus']; ?>
' align="right" readonly='readonly' size='3'>
        <input type='text' name='descripcion1' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' readonly='readonly' size='77'>
      </td>
    </tr> 
  </tr>

  </table></center>
  <p class= "cnt" >DATOS DEL DOCUMENTO Y EVENTO </p>

  <table border="1" cellspacing="1">
  <tr>
    <?php if ($this->_tpl_vars['escrito_asoc'] == 'S'): ?>
    <tr>
      <td class="izq-color">Documento:</td>
      <td class="der-color">
      <form name="forfile" enctype="multipart/form-data" action="z_enviodoc_ti.php?vopc=2&vsol=<?php echo $this->_tpl_vars['anno']; ?>
-<?php echo $this->_tpl_vars['numero']; ?>
"  method="POST">

        <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
        <input type ='hidden' name='role' value=<?php echo $this->_tpl_vars['role']; ?>
>
        <input type ='hidden' name='fecha_venc' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['fecha_venc'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%G") : smarty_modifier_date_format($_tmp, "%d/%m/%G")); ?>
'>
        <input type ='hidden' name='modalidad' value=<?php echo $this->_tpl_vars['modalidad']; ?>
>
        <input type ='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
        <input type ='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
        <input type ='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
        <input type ='hidden' name='anno' value='<?php echo $this->_tpl_vars['anno']; ?>
'>
        <input type ='hidden' name='numero' value='<?php echo $this->_tpl_vars['numero']; ?>
'>
        <input type ='hidden' name='fecha_solic' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
'>
        <input type ='hidden' name='tipo_marca' value='<?php echo $this->_tpl_vars['tipo_marca']; ?>
'>
        <input type ='hidden' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
'>
        <input type ='hidden' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
'>
        <input type ='hidden' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
'>
        <input type ='hidden' name='registro' value='<?php echo $this->_tpl_vars['registro']; ?>
'>
        <input type ='hidden' name='eventos_id' value='<?php echo $this->_tpl_vars['evento']; ?>
'>
        <input type ='hidden' name='input2' value='<?php echo $this->_tpl_vars['input2']; ?>
'>
        <input type ='hidden' name='cant_pag' value='<?php echo $this->_tpl_vars['cant_pag']; ?>
'>
        <input type ='hidden' name='fecha_evento' value='<?php echo $this->_tpl_vars['fecha_evento']; ?>
'>
        <input type ='hidden' name='comentario' value='<?php echo $this->_tpl_vars['comentario']; ?>
'>
        <input type ='hidden' name='documento' value='<?php echo $this->_tpl_vars['documento']; ?>
'>
        <?php if (file ( $this->_tpl_vars['documento_dig'] )): ?>
            <b>El Documento Digitalizado Ya fu&eacute; Cargado Correctamente.</b>
        <?php else: ?>
            <input type ='hidden' name='vname_new' value=<?php echo $this->_tpl_vars['usuario']; ?>
_<?php echo $this->_tpl_vars['anno'];  echo $this->_tpl_vars['numero']; ?>
>
            <input name="ubicacion" type="file" value=<?php echo $this->_tpl_vars['ubicacion']; ?>
 size="60" onchange="checkear(this);" >&nbsp;&nbsp; 
            <input name="enviar" type="submit" value="Cargar Archivo" class="botones">  
        <?php endif; ?>
      </form>

      </td>
    </tr>
    <?php endif; ?>
  <form name="fordatev" action="m_gbevind_ti.php" method="POST" onsubmit="return pregunta();">
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
    <input type ='hidden' name='escrito_asoc' value='<?php echo $this->_tpl_vars['escrito_asoc']; ?>
'>
    <input type ='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>  
    <input type ='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
    <input type ='hidden' name='anno' value='<?php echo $this->_tpl_vars['anno']; ?>
'>
    <input type ='hidden' name='numero' value='<?php echo $this->_tpl_vars['numero']; ?>
'>
    <input type ='hidden' name='fecha_solic' value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
'>
    <input type ='hidden' name='tipo_marca' value='<?php echo $this->_tpl_vars['tipo_marca']; ?>
'>
    <input type ='hidden' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
'>
    <input type ='hidden' name='estatus' value='<?php echo $this->_tpl_vars['estatus']; ?>
'>
    <input type ='hidden' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
'>

    <?php if ($this->_tpl_vars['escrito_asoc'] == 'S'): ?>
    <tr>
      <td class="izq-color">Cantidad de P&aacute;ginas:</td>
      <td class="der-color">
        <input type='text' name='cant_pag' value='<?php echo $this->_tpl_vars['cant_pag']; ?>
' maxlength="3" size='3' onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>
    <?php endif; ?>
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
' size="10" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
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
<!-- Realizado por: Nelson Gonzalez 10/02/2020 - Incorpora la Factura para evento 40 
    <?php if ($this->_tpl_vars['evento'] == 40): ?>
     <tr>
      <td class="izq-color" >NUMERO DE FACTURA:</td>
      <td class="der-color">
        <input type='text' name='num_fac' value='<?php echo $this->_tpl_vars['num_fac']; ?>
' size="10" maxlength="10" align="right" onKeyPress="return acceptChar(event,2,this)">
      </td>
     </tr>
    <?php endif; ?>
<!-- Fin Factura evento 40-->
  </tr>
  </table></center>
  &nbsp;

  <table width="248">
  <tr>
    <!-- <td class="der">
    <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['anno']; ?>
&vsol2=<?php echo $this->_tpl_vars['numero']; ?>
" target="blank">
    <input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> -->
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="m_eveind_ti.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_cerrar_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </tr>
  </table></form></center>
  &nbsp;

  <br><br><br><br><br><br><br><br><br><br> 
</div>  
</body>
</html>