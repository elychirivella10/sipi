<?php /* Smarty version 2.6.8, created on 2022-05-29 13:33:41
         compiled from p_ofidevfondo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_ofidevfondo.tpl', 61, false),)), $this); ?>
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

<form name="formarcas1" action="p_ofidevfondo.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
  <input type='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>


  <table>
     <tr>
      <td class="izq5-color">Solicitud No.:</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	  &nbsp;&nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="p_ofidevfondo.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type='hidden' name='nameimage' value=<?php echo $this->_tpl_vars['nameimage']; ?>
>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>  

  <table cellspacing="1" border="1">
    <tr>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="right">
      </td>
      <td class="der-color" rowspan="6" valign="top">
        <input name="ubicacion" type="file" disabled value='<?php echo $this->_tpl_vars['ubicacion']; ?>
' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $this->_tpl_vars['nameimage']; ?>
' id="picture" width="270" height="270" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $this->_tpl_vars['modo1']; ?>
 onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arraytipom'],'selected' => $this->_tpl_vars['tipo_marca'],'output' => $this->_tpl_vars['arraynotip']), $this);?>

        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="3" name="nombre" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="500" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color">
	     <textarea rows="3" name="tramitante" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="500" onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['tramitante']; ?>
</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
	      <textarea rows="2" name="estatus" <?php echo $this->_tpl_vars['modo']; ?>
 cols="57" maxlength="500" ><?php echo $this->_tpl_vars['estatus']; ?>
</textarea>
      </td>
    </tr>
  </table>

    <p align="center"><b><font size="4" face="Tahoma">Resumen</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
    <tr>
      <td class="der-color">
        <textarea id="vresumen" name="vresumen" <?php echo $this->_tpl_vars['modo']; ?>
 rows="10" cols="116"  onchange="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['vresumen']; ?>
</textarea>
      </td>
    </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Inventor(es)</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">Nombre</b></font></td>
        <td class="columna-titulo">Domicilio</td>
      </tr>
      <tr>
        <?php unset($this->_sections['inventor']);
$this->_sections['inventor']['name'] = 'inventor';
$this->_sections['inventor']['loop'] = is_array($_loop=$this->_tpl_vars['custidinv']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['inventor']['show'] = true;
$this->_sections['inventor']['max'] = $this->_sections['inventor']['loop'];
$this->_sections['inventor']['step'] = 1;
$this->_sections['inventor']['start'] = $this->_sections['inventor']['step'] > 0 ? 0 : $this->_sections['inventor']['loop']-1;
if ($this->_sections['inventor']['show']) {
    $this->_sections['inventor']['total'] = $this->_sections['inventor']['loop'];
    if ($this->_sections['inventor']['total'] == 0)
        $this->_sections['inventor']['show'] = false;
} else
    $this->_sections['inventor']['total'] = 0;
if ($this->_sections['inventor']['show']):

            for ($this->_sections['inventor']['index'] = $this->_sections['inventor']['start'], $this->_sections['inventor']['iteration'] = 1;
                 $this->_sections['inventor']['iteration'] <= $this->_sections['inventor']['total'];
                 $this->_sections['inventor']['index'] += $this->_sections['inventor']['step'], $this->_sections['inventor']['iteration']++):
$this->_sections['inventor']['rownum'] = $this->_sections['inventor']['iteration'];
$this->_sections['inventor']['index_prev'] = $this->_sections['inventor']['index'] - $this->_sections['inventor']['step'];
$this->_sections['inventor']['index_next'] = $this->_sections['inventor']['index'] + $this->_sections['inventor']['step'];
$this->_sections['inventor']['first']      = ($this->_sections['inventor']['iteration'] == 1);
$this->_sections['inventor']['last']       = ($this->_sections['inventor']['iteration'] == $this->_sections['inventor']['total']);
?>
        <tr>
          <td ><?php echo $this->_tpl_vars['custidinv'][$this->_sections['inventor']['index']][0]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custidinv'][$this->_sections['inventor']['index']][1]; ?>
</td>
        </tr>
        <?php endfor; endif; ?>
      </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">C&oacute;digo</td>
        <td class="columna-titulo">Nombre</b></font></td>
        <td class="columna-titulo">Domicilio</td>
        <td class="columna-titulo">Pa&iacute;s de Domicilio</td>
        <td class="columna-titulo">Nacionalidad</td>
        <td class="columna-titulo">Identificaci&oacute;n</td>
      </tr>
      <tr>
        <?php unset($this->_sections['titular']);
$this->_sections['titular']['name'] = 'titular';
$this->_sections['titular']['loop'] = is_array($_loop=$this->_tpl_vars['custidtit']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['titular']['show'] = true;
$this->_sections['titular']['max'] = $this->_sections['titular']['loop'];
$this->_sections['titular']['step'] = 1;
$this->_sections['titular']['start'] = $this->_sections['titular']['step'] > 0 ? 0 : $this->_sections['titular']['loop']-1;
if ($this->_sections['titular']['show']) {
    $this->_sections['titular']['total'] = $this->_sections['titular']['loop'];
    if ($this->_sections['titular']['total'] == 0)
        $this->_sections['titular']['show'] = false;
} else
    $this->_sections['titular']['total'] = 0;
if ($this->_sections['titular']['show']):

            for ($this->_sections['titular']['index'] = $this->_sections['titular']['start'], $this->_sections['titular']['iteration'] = 1;
                 $this->_sections['titular']['iteration'] <= $this->_sections['titular']['total'];
                 $this->_sections['titular']['index'] += $this->_sections['titular']['step'], $this->_sections['titular']['iteration']++):
$this->_sections['titular']['rownum'] = $this->_sections['titular']['iteration'];
$this->_sections['titular']['index_prev'] = $this->_sections['titular']['index'] - $this->_sections['titular']['step'];
$this->_sections['titular']['index_next'] = $this->_sections['titular']['index'] + $this->_sections['titular']['step'];
$this->_sections['titular']['first']      = ($this->_sections['titular']['iteration'] == 1);
$this->_sections['titular']['last']       = ($this->_sections['titular']['iteration'] == $this->_sections['titular']['total']);
?>
        <tr>
          <td ><?php echo $this->_tpl_vars['custidtit'][$this->_sections['titular']['index']][0]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custidtit'][$this->_sections['titular']['index']][1]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custidtit'][$this->_sections['titular']['index']][2]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custidtit'][$this->_sections['titular']['index']][3]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custidtit'][$this->_sections['titular']['index']][4]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custidtit'][$this->_sections['titular']['index']][5]; ?>
</td>
        </tr>
        <?php endfor; endif; ?>
      </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Cronolog&iacute;a de Eventos</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
      <tr>
        <td class="columna-titulo">Fecha Evento</td>
        <td class="columna-titulo">Evento</b></font></td>
        <td class="columna-titulo">Descripci&oacute;n</td>
        <td class="columna-titulo">Fecha de Transacci&oacute;n</td>
        <td class="columna-titulo">Nro Documento</td>
        <td class="columna-titulo">Comentario</td>
      </tr>
      <tr>
        <?php unset($this->_sections['customer']);
$this->_sections['customer']['name'] = 'customer';
$this->_sections['customer']['loop'] = is_array($_loop=$this->_tpl_vars['custid']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['customer']['show'] = true;
$this->_sections['customer']['max'] = $this->_sections['customer']['loop'];
$this->_sections['customer']['step'] = 1;
$this->_sections['customer']['start'] = $this->_sections['customer']['step'] > 0 ? 0 : $this->_sections['customer']['loop']-1;
if ($this->_sections['customer']['show']) {
    $this->_sections['customer']['total'] = $this->_sections['customer']['loop'];
    if ($this->_sections['customer']['total'] == 0)
        $this->_sections['customer']['show'] = false;
} else
    $this->_sections['customer']['total'] = 0;
if ($this->_sections['customer']['show']):

            for ($this->_sections['customer']['index'] = $this->_sections['customer']['start'], $this->_sections['customer']['iteration'] = 1;
                 $this->_sections['customer']['iteration'] <= $this->_sections['customer']['total'];
                 $this->_sections['customer']['index'] += $this->_sections['customer']['step'], $this->_sections['customer']['iteration']++):
$this->_sections['customer']['rownum'] = $this->_sections['customer']['iteration'];
$this->_sections['customer']['index_prev'] = $this->_sections['customer']['index'] - $this->_sections['customer']['step'];
$this->_sections['customer']['index_next'] = $this->_sections['customer']['index'] + $this->_sections['customer']['step'];
$this->_sections['customer']['first']      = ($this->_sections['customer']['iteration'] == 1);
$this->_sections['customer']['last']       = ($this->_sections['customer']['iteration'] == $this->_sections['customer']['total']);
?>
        <tr>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][0]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][1]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][2]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][3]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][4]; ?>
</td>
          <td ><?php echo $this->_tpl_vars['custid'][$this->_sections['customer']['index']][5]; ?>
</td>
        </tr>
        <?php endfor; endif; ?>
      </tr>
    </table>

    <p align="center"><b><font size="4" face="Tahoma">Juicio del Evaluador:</font></b></p>
    <table width="960px" cellspacing="1" border="1" class="celda1">
    <tr>
      <td class="der-color">
        <textarea id="motivo" name="motivo" <?php echo $this->_tpl_vars['modo3']; ?>
 rows="15" cols="116"><?php echo $this->_tpl_vars['motivo']; ?>
</textarea>
      </td>
    </tr>
    </table>
   <br>
   <table>
   <tr>
     <tr>
       <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
       <td class="der-color">
         <input type="text" name="boletin" size="3" maxlength="3" value='<?php echo $this->_tpl_vars['boletin']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forcaduca.actualizar)">
       </td>
     </tr>   
   </table></center>
   <br><br><br>
  <table width="200">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $this->_tpl_vars['modo2']; ?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1): ?>
          <a href="p_ofidevfondo.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
          <a href="p_ofidevfondo.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a> 
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>