<?php /* Smarty version 2.6.8, created on 2022-03-15 10:25:49
         compiled from w_ingresol1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'w_ingresol1.tpl', 26, false),)), $this); ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

&nbsp;
&nbsp;
&nbsp;
&nbsp;

<!-- <table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" align='center'>
<!--  <tr><td>
  <fieldset>
  <legend align='center'>
  <strong>Documentos Anexos correspondientes al Tramite No. <?php echo $this->_tpl_vars['vreftra']; ?>
 - Solicitud No. <?php echo $this->_tpl_vars['vsol']; ?>
</strong>
  </legend>
  <?php $this->assign('cont', '1'); ?>
  <?php $_from = $this->_tpl_vars['vrefsol']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curr_id']):
?>
  <?php $this->assign('nomfor0', 'otrofor'); ?>
  <?php $this->assign('nomfor1', ((is_array($_tmp=$this->_tpl_vars['nomfor0'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['cont']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['cont']))); ?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" > -->
  <!--   <tr><td colspan=2 class="izq9-color">SOLICITUD: <?php echo $this->_tpl_vars['curr_id']; ?>
</td></tr>
   <tr><td colspan=2>Nombre: <?php echo $this->_tpl_vars['vnomsol'][$this->_tpl_vars['cont']]; ?>
</td></tr>
   <tr><td colspan=2>Tipo: <?php echo $this->_tpl_vars['vtipder'][$this->_tpl_vars['cont']]; ?>
</td></tr> 
   <tr><td colspan=2>Clase Internacional: <?php echo $this->_tpl_vars['vclaint'][$this->_tpl_vars['cont']]; ?>
</td></tr> 
   <tr><td colspan=2 >Clase Nacional: <?php echo $this->_tpl_vars['vclanac'][$this->_tpl_vars['cont']]; ?>
</td></tr>
   <tr><td colspan=2><hr /></td></tr> --> 
<!--   <tr><td>
   <?php if ($this->_tpl_vars['vcanane0'][$this->_tpl_vars['cont']] > 0): ?>
     <?php $this->assign('cont2', '1'); ?>
     <?php unset($this->_sections['seccion']);
$this->_sections['seccion']['name'] = 'seccion';
$this->_sections['seccion']['start'] = (int)0;
$this->_sections['seccion']['loop'] = is_array($_loop=$this->_tpl_vars['vcanane'][$this->_tpl_vars['cont']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['seccion']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['seccion']['show'] = true;
$this->_sections['seccion']['max'] = $this->_sections['seccion']['loop'];
if ($this->_sections['seccion']['start'] < 0)
    $this->_sections['seccion']['start'] = max($this->_sections['seccion']['step'] > 0 ? 0 : -1, $this->_sections['seccion']['loop'] + $this->_sections['seccion']['start']);
else
    $this->_sections['seccion']['start'] = min($this->_sections['seccion']['start'], $this->_sections['seccion']['step'] > 0 ? $this->_sections['seccion']['loop'] : $this->_sections['seccion']['loop']-1);
if ($this->_sections['seccion']['show']) {
    $this->_sections['seccion']['total'] = min(ceil(($this->_sections['seccion']['step'] > 0 ? $this->_sections['seccion']['loop'] - $this->_sections['seccion']['start'] : $this->_sections['seccion']['start']+1)/abs($this->_sections['seccion']['step'])), $this->_sections['seccion']['max']);
    if ($this->_sections['seccion']['total'] == 0)
        $this->_sections['seccion']['show'] = false;
} else
    $this->_sections['seccion']['total'] = 0;
if ($this->_sections['seccion']['show']):

            for ($this->_sections['seccion']['index'] = $this->_sections['seccion']['start'], $this->_sections['seccion']['iteration'] = 1;
                 $this->_sections['seccion']['iteration'] <= $this->_sections['seccion']['total'];
                 $this->_sections['seccion']['index'] += $this->_sections['seccion']['step'], $this->_sections['seccion']['iteration']++):
$this->_sections['seccion']['rownum'] = $this->_sections['seccion']['iteration'];
$this->_sections['seccion']['index_prev'] = $this->_sections['seccion']['index'] - $this->_sections['seccion']['step'];
$this->_sections['seccion']['index_next'] = $this->_sections['seccion']['index'] + $this->_sections['seccion']['step'];
$this->_sections['seccion']['first']      = ($this->_sections['seccion']['iteration'] == 1);
$this->_sections['seccion']['last']       = ($this->_sections['seccion']['iteration'] == $this->_sections['seccion']['total']);
?>
     <?php $this->assign('nomfor', ((is_array($_tmp=$this->_tpl_vars['nomfor1'])) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['cont2']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['cont2']))); ?>
<form name=<?php echo $this->_tpl_vars['nomfor']; ?>
 enctype="multipart/form-data" action="z_enviodoc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['curr_id']; ?>
&vreftra=<?php echo $this->_tpl_vars['vreftra']; ?>
&vcod=<?php echo $this->_tpl_vars['vcodane'][$this->_tpl_vars['cont']][$this->_tpl_vars['cont2']]; ?>
&vsub=<?php echo $this->_tpl_vars['vsubdir'][$this->_tpl_vars['cont']][$this->_tpl_vars['cont2']]; ?>
" onsubmit="document.<?php echo $this->_tpl_vars['nomfor']; ?>
.enviar.style.display='none';document.<?php echo $this->_tpl_vars['nomfor']; ?>
.imagenproc.style.display='inline';document.<?php echo $this->_tpl_vars['nomfor']; ?>
.imagenproc.visibility='visible';" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <?php if ($this->_tpl_vars['vestane'][$this->_tpl_vars['cont']][$this->_tpl_vars['cont2']] == 0): ?>
      <tr>
          <td width="25%">&nbsp;&nbsp;<img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['vdesane'][$this->_tpl_vars['cont']][$this->_tpl_vars['cont2']]; ?>
</td> -->
      <!--          <td width="25%">&nbsp;&nbsp;<input align='center' type="checkbox" name=<?php echo $this->_tpl_vars['recaudo']; ?>
 >&nbsp;<?php echo $this->_tpl_vars['vdesane'][$this->_tpl_vars['cont']][$this->_tpl_vars['cont2']]; ?>
</td> -->
<!--          <td width="60%"><input name="ubicacion" type="file" size="60" onchange="checkear(this);" ></td>
          <td>&nbsp;&nbsp;<input name="enviar" type="submit" value="Cargar Archivo" class="botones">
                          </td></tr> -->
      <!-- <img name="imagenproc" src="../imagenes/procesando3.gif" STYLE="display:none"> 
      STYLE="display:inline"-->
<!--      <?php else: ?>
      <tr><td width="25%">&nbsp;&nbsp;<img src="../imagenes/tick.png">&nbsp;<?php echo $this->_tpl_vars['vdesane'][$this->_tpl_vars['cont']][$this->_tpl_vars['cont2']]; ?>
</td></tr>
      <?php endif; ?>
     </table>
</form>
     <?php $this->assign('cont2', $this->_tpl_vars['cont2']+1); ?>
     <?php endfor; endif; ?>
   <?php else: ?>
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr valign='bottom'><td width='30%'>&nbsp;&nbsp;<img src='../imagenes/tick.png' />&nbsp;Todos los Documentos anexos requeridos para esta Solicitud ya fueron cargados.</td></tr>
     </table>
   <?php endif; ?>
   <?php $this->assign('cont', $this->_tpl_vars['cont']+1); ?>
  <?php endforeach; endif; unset($_from); ?>
   </td></tr>
 </table>  -->

<!--
<TABLE WIDTH=100% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0>
	<COL WIDTH=115*>
	<COL WIDTH=13*>
	<COL WIDTH=117*>
	<COL WIDTH=11*>
	<TR VALIGN=TOP>

		<TD WIDTH=45%>
			<UL>
			  <LI> <A HREF="../graficos/docutemp/poder/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Poder </A> 
			</UL>
		</TD>
		<TD WIDTH=5% align='center'>
			<input align='center' type="checkbox" name="recaud1" >		
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/asamblea/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'>  Acta Ultima Asamblea  </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud2" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/reglamento/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Reglamento de uso de Marca </A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud3" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI>  <A HREF="../graficos/docutemp/cedula/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Cedula de Identidad </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud4" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/prioridad/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Documento(s) de Prioridad y  Certificado de Registro Extranjero</A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud5" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/rif/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Rif </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud6" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/mercantil/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Registro Mercantil </A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud7" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/otros/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Otros </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud8" >
		</TD>
	</TR>
	
</TABLE>
-->
<form name="wingresol" id="w_grabar" action="w_ingresol.php?vopc=6" method="post">

  <TABLE WIDTH=70% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0 align='center'>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. TR&Aacute;MITE:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vtramt']; ?>
</br>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. REFERENCIA:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vsol']; ?>
</br>
  </font></br></td></tr>
  
  <tr><td WIDTH=30% class='izq-color'><b>Nombre / Logotipo:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vnsolsipi']; ?>
</br>

  <?php if (( file ( $this->_tpl_vars['nameimage'] ) )): ?>
      <td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #C6DEF2'>
         <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target='_blank'><img border='0' src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width='150' height='150'>
      </td></a>"; 
  <?php endif; ?>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Clase Internacional Niza:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vnclasipi']; ?>
</br>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Requisitos M&iacute;nimos Asociados a la Solicitud:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php if ($this->_tpl_vars['vdocanexoa'] == 'S'): ?><input align='center' type="checkbox" name="recaud1" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexoa']; ?>
</br><?php endif; ?>
      <?php if ($this->_tpl_vars['vdocanexob'] == 'S'): ?><input align='center' type="checkbox" name="recaud2" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexob']; ?>
</br><?php endif; ?> 
      <?php if ($this->_tpl_vars['vdocanexoc'] == 'S'): ?><input align='center' type="checkbox" name="recaud3" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexoc']; ?>
</br><?php endif; ?>
      <?php if ($this->_tpl_vars['vdocanexof'] == 'S'): ?><input align='center' type="checkbox" name="recaud4" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexof']; ?>
</br><?php endif; ?>
      <?php if ($this->_tpl_vars['vdocanexog'] == 'S'): ?><input align='center' type="checkbox" name="recaud5" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexog']; ?>
</br><?php endif; ?>
      <?php if ($this->_tpl_vars['vdocanexoh'] == 'S'): ?><input align='center' type="checkbox" name="recaud6" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexoh']; ?>
</br><?php endif; ?>
      <?php if ($this->_tpl_vars['vdocanexoi'] == 'S'): ?><input align='center' type="checkbox" name="recaud7" STYLE="display:none"><?php echo $this->_tpl_vars['vlitanexoi']; ?>
</br><?php endif; ?>
  </font></br></td></tr>
  <tr><td class='izq-color'><b>N&uacute;mero de SOLICITUD:</b>
     </td><td><input type='text' size='2' name='vsol1' maxlength='4' value='<?php echo $this->_tpl_vars['vsol1']; ?>
' onKeyPress="return acceptChar(event,2, this)"
onkeyup="checkLength(event,this,4,document.wingresol.vsol2);" onchange='for(var x=this.value.length;x<4;x++) this.value=0+this.value;'>-<input type='text' size='3' name='vsol2' maxlength='6' value='<?php echo $this->_tpl_vars['vsol2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.wingresol.vpod1);" onchange='for(var x=this.value.length;x<6;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (año-n&uacute;mero)</font>
  </td></tr>

  <tr><td class='izq-color'><b>Fecha de Presentaci&oacute;n:</b>
     </td><td>
       <!-- 
       <input type='text' name='fecha_pres' value='<?php echo $this->_tpl_vars['fecha_pres']; ?>
' size='10' onChange="valFecha(document.wingresol.fecha_pres)" onkeyup="checkLength(event,this,10,document.wingresol.vcarp)">
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar95');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
       -->
       <input type='text' name='fecha_pres' value='<?php echo $this->_tpl_vars['fecha_pres']; ?>
' size='10' readonly>
  </td></tr>

  <tr><td class='izq-color'><b>N&uacute;mero de CARPETA:</b>
     </td><td><input type='text' size='10' name='vcarp' maxlength='10' value='<?php echo $this->_tpl_vars['vcarp']; ?>
' onKeyPress="return acceptChar(event,2, this)"><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000000 (n&uacute;mero)</font>
  </td></tr>
  
<?php if ($this->_tpl_vars['vpedirpoder'] == 'S'): ?>
  <tr><td class='izq-color'><b>N&uacute;mero de Poder:</b>
     </td><td><input type='text' size='2' name='vpod1' maxlength='4' value='<?php echo $this->_tpl_vars['vpod1']; ?>
' onkeyup="checkLength(event,this,4,document.wingresol.vpod2);" onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<4;x++) this.value=0+this.value;'>-<input type='text' size='2' name='vpod2' maxlength='4' value='<?php echo $this->_tpl_vars['vpod2']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.wingresol.vfact);" onchange='for(var x=this.value.length;x<4;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000-0000 (año-n&uacute;mero)</font>
  </td></tr>
<?php endif; ?>
  <tr><td class='izq-color'><b>N&uacute;mero de FACTURA Pago de Tasa:</b>
     </td><td>F<input type='text' size='5' name='vfact' maxlength='7' value='<?php echo $this->_tpl_vars['vfact']; ?>
' onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<7;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000 (n&uacute;mero)</font>
  </td></tr>
  </table>

 </strong>
 </fieldset>
 </td></tr>
</table>
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<!-- <form name="wingresol" id="w_grabar" action="w_ingresol.php?vopc=6" method="post"> -->
<input type ='hidden' name='vtramt' value=<?php echo $this->_tpl_vars['vtramt']; ?>
> 
<input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
> 
<input type ='hidden' name='vfec_tram' value=<?php echo $this->_tpl_vars['vfec_tram']; ?>
> 
<input type ='hidden' name='vpedpod' value=<?php echo $this->_tpl_vars['vpedirpoder']; ?>
> 
<!-- <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr><td>
  <fieldset>
  <legend align='center'>
  <strong>Causales de Devoluci&oacute;n</strong>
  </legend>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr><td><input type="checkbox" name="causa1"></td><td><img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['descausa'][0]; ?>
</td></tr>
	<tr><td><input type="checkbox" name="causa2"></td><td><img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['descausa'][1]; ?>
</td></tr>
	<tr><td><input type="checkbox" name="causa3"></td><td><img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['descausa'][2]; ?>
</td></tr>
<?php if ($this->_tpl_vars['descausa'][3] != ''): ?><tr><td><input type="checkbox" name="causa4"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][3]; ?>
</td></tr><?php endif;  if ($this->_tpl_vars['descausa'][4] != ''): ?><tr><td><input type="checkbox" name="causa5"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][4]; ?>
</td></tr><?php endif;  if ($this->_tpl_vars['descausa'][5] != ''): ?><tr><td><input type="checkbox" name="causa6"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][5]; ?>
</td></tr><?php endif;  if ($this->_tpl_vars['descausa'][6] != ''): ?><tr><td><input type="checkbox" name="causa7"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][6]; ?>
</td></tr><?php endif; ?>
	<tr><td>Otro:</td><td><input size="120" type="text" name="otro"></td></tr>
 </table>  
 </strong>
 </fieldset>
 </td></tr>
</table> -->
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<table width="30%" align="center">
    <tr align="center">
      <td width="50%" align="center">
       <input type ='hidden' name='vaccion' value='0'>
<!--      <?php if ($this->_tpl_vars['vopc'] == 4): ?> -->
	  <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save" border="0" onclick="document.wingresol.vaccion.value='1'">
      </td><td width="50%" align="center">
<!--	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save2" border="0" onclick="document.wingresol.vaccion.value='2'"> 
     <?php else: ?>
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar y Aprobar Examen de Forma </a>  
      <?php endif; ?> -->
</form>
<!--      </td><td>&nbsp;</td> -->
      <!-- <td width="30%" align="center">
	 <a href="z_solmarweb.php?vopc=4&vreftra=<?php echo $this->_tpl_vars['vtramt']; ?>
&vrefsol=<?php echo $this->_tpl_vars['vsol']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/note_f2.png',1);">
	 <img src="../imagenes/note_f2.png" alt="Cancel" align="center" name="cancel" border="0" /></a>
      </td><td>&nbsp;</td>       
  &nbsp;&nbsp;    
      <td width="10%" align="center"> -->
 	 <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/salir_f2.png',1);">
	 <img src="../imagenes/salir_f2.png" alt="Salir" align="center" name="salir" border="0" /></a>    
      </td>
    </tr>
    <tr align="center"><td width="50%" align="center">Ingresar Solicitud</td><td width="50%" align="center">Salir</td>
    </tr>
</table>
&nbsp;
&nbsp;&nbsp;
&nbsp;
</body>
</html>

<!--

-->
