<?php /* Smarty version 2.6.8, created on 2020-10-20 09:56:30
         compiled from m_exfon55.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>

<body onLoad="mueveReloj(); this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="form_reloj">
<table width="960px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class="der">
      <div align="right">
        <I><font size="-1"><b><?php echo $this->_tpl_vars['titulo']; ?>
</b></font></I>
         &nbsp;&nbsp;<font face="Arial" size="2" > 
         <input type="text" name="reloj" size="15" style="background-color : Rich Blue; color : Black; font-family : Verdana, Arial, Helvetica; font-size : 8pt; text-align : center; font-weight: bold;" onfocus="window.document.form_reloj.reloj.blur()"><br/>
         </font>
      </div>
    </td>
  </tr>
</table>
</form>

<form name="formarcas1" action="m_exfon55.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value='<?php echo $this->_tpl_vars['usuario']; ?>
'>
  <input type='hidden' name='vsol' value='<?php echo $this->_tpl_vars['vsol']; ?>
'>
  
  <table>
     <tr>
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='<?php echo $this->_tpl_vars['vsol2']; ?>
' id='vsol2' <?php echo $this->_tpl_vars['vmodo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)"> &nbsp;
      </td>
      <td class="cnt"><input tabindex="2" type='image' name='buscar' id='buscar' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  
</div>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_exfon55.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type='hidden' name='vsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
>
  <input type='hidden' name='vsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>
  <input type='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
>
  <input type='hidden' name='opcion' value=<?php echo $this->_tpl_vars['opcion']; ?>
>
  <input type='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
  <input type='hidden' name='varsol1' value=<?php echo $this->_tpl_vars['vsol1']; ?>
> 
  <input type='hidden' name='varsol2' value=<?php echo $this->_tpl_vars['vsol2']; ?>
>      
  <input type='hidden' name='fpoder' value=<?php echo $this->_tpl_vars['fpoder']; ?>
>
  <input type='hidden' name='facultad' value=<?php echo $this->_tpl_vars['facultad']; ?>
>
  
<table>
<tr>
  <table>
  <tr>
    <td width="85%">
       <div><strong> </strong></div>
    </td>

    <td align="rigth">
      <table>
         <tr>
	 <td>
	   <a href="m_exfon55.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	   <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	 </td>
 	 <td>&nbsp;</td>
	 <td>
 	   <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_rojo.png',1);">
	   <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>
	 </td>
	 <td>&nbsp;</td>
     </tr>
     </table>
    </td>
  </tr>
  </table>

 <tr>
   <div class="tab-page" id="modules-cpanel">
   <script type="text/javascript">
      var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
   </script>

  <div class="tab-page" id="module33"><h2 class="tab">Basico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module33" ) );
  </script>
  <table width="100%" cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color" colspan="3" >
         <input type="text" name="fecha_solic" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['fecha_solic']; ?>
' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $this->_tpl_vars['campo3']; ?>
&nbsp;&nbsp;&nbsp;
      <input type="text" name="tipo_marca" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['tipo_marca']; ?>
' size="1" maxlength="2" > - 
      <input type="text" name="tipomarca" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['tipomarca']; ?>
' size="28" maxlength="30" >
      </td>
      <td class="der-color" rowspan="5" valign="top">
        <br><a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank"><img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="250" height="250"></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 cols="75" maxlength="120"><?php echo $this->_tpl_vars['nombre']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo16']; ?>
</td>
      <td class="der-color">
         <input type="text" name="estatus" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['estatus']; ?>
' size="2" maxlength="3"> - 
         <input type="text" name="nombest" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombest']; ?>
' size="60" maxlength="120">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color">
       <input type="text" name="modalidad" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['modalidad']; ?>
' size="1" maxlength="2" > - 
       <input type="text" name="modal" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['modal']; ?>
' size="15" maxlength="15" >
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
        <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > - 
        <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td colspan="2" class="der-color">
        <input type="text" name="vcodpais" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vcodpais']; ?>
' size="1" maxlength="2" > - 
        <input type="text" name="pais_resid" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['pais_resid']; ?>
' size="30" maxlength="30" >
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color" colspan="4">
        <!-- <input type="text" name="tramitante" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size="160"  maxlength="140"> -->
	     <textarea rows="2" name="tramitante" <?php echo $this->_tpl_vars['vmodo']; ?>
 cols="120" maxlength="150"><?php echo $this->_tpl_vars['tramitante']; ?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color" colspan="4">
        <input type="text" name="vpod1" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vpod1']; ?>
' align="right" size="3" maxlength="4" > - 
        <input type="text" name="vpod2" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vpod2']; ?>
' align="right" size="4" maxlength="5" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo12']; ?>
</td>
      <td class="der-color" colspan="4">
        <input type="text" name="vsol3" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vsol3']; ?>
' align="right" size="3" maxlength="4" > - 
        <input type="text" name="vsol4" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vsol4']; ?>
' align="right" size="6" maxlength="6" >
      </td>
    </tr>
  </tr>
  </table>
  <!--  colspan="4"  -->
  
  <table width="100%" cellspacing="1" border="1">
  <tr><td class="izq4-color"><?php echo $this->_tpl_vars['campo11']; ?>
</td></tr>
  <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="m_veragente.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=<?php echo $this->_tpl_vars['vder']; ?>
"></iframe> 
  </td></tr>  
  </table>

  <table width="100%" cellspacing="1" border="1">
   <tr><td class="izq4-color">Titular(es)</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="m_vertitular.php?pder=<?php echo $this->_tpl_vars['vder']; ?>
"></iframe> 
   </td></tr>  
  </table>
  &nbsp;
  </div>
  
  <div class="tab-page" id="module19"><h2 class="tab">Distingue</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module19" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
  </tr> 
  </table>
  
  <table width="100%" border="1" cellspacing="1" >
    <tr>
      <td width="100%" >
	    <textarea rows="18" name="distingue" <?php echo $this->_tpl_vars['vmodo']; ?>
 cols="100"><?php echo $this->_tpl_vars['distingue']; ?>
</textarea>
      </td>
  </tr> 
  </table>
  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module43"><h2 class="tab">Logotipo</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module43" ) );
  </script>

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="30%" class="der-color" rowspan="5" valign="top">
        Descripci&oacute;n y Clasificaci&oacute;n de Logotipo
        <br><a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank"><img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="280" height="250"></a></br>
      </td>
    </tr>
    <tr>
      <td width="70%" class="der-color" valign="top">
	     <textarea rows="9" name="etiqueta" <?php echo $this->_tpl_vars['vmodo']; ?>
 cols="117"><?php echo $this->_tpl_vars['etiqueta']; ?>
</textarea>
      </td>
    </tr> 
    &nbsp;
    <tr><td>    
      <iframe id='top' style='width:100%;height:115px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe> 
    </td></tr>
  </tr>
  </table>
  </div>
  
  <div class="tab-page" id="module21"><h2 class="tab">Cronologia</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module21" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha
    Evento</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Vencimiento
    Evento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Nro
    Documento</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Codigo del
    Evento</b></font></td>
      <td width="30%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Descripcion</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha de
    Transaccion</b></font></td>
      <td width="30%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Comentarios</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Documento</b></font></td>
    </tr>
    <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
    <tr>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph1'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph2'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph3'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph4'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph5'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph6'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph7'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color">
       <?php if ($this->_tpl_vars['arr_ph4'][$this->_sections['cont']['index']] == 1122 && $this->_tpl_vars['arr_ph10'][$this->_sections['cont']['index']] == 1200 && $this->_tpl_vars['arr_ph3'][$this->_sections['cont']['index']] >= 587): ?>
         <a href=<?php echo $this->_tpl_vars['arr_ph8'][$this->_sections['cont']['index']]; ?>
 target='_blank'><img border='1' src=<?php echo $this->_tpl_vars['imagenresultado']; ?>
 width='40' height='40'></a>
       <?php endif; ?>
       </td>
    </tr>
    <?php endfor; endif; ?> 
  </tr> 
  </table>
  
  &nbsp;  
  </div>
  </div>

  <div class="tab-page" id="module82"><h2 class="tab">General</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module82" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>
  
  <table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
      <td class="celda-titulo">Solicitud:</td>  
        <td width='83' class='celda2'><b><?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
</b></td>
        <td width='22%' rowspan='7' align='center' style='background-color: #FFFFFF; border: 1 solid #C6DEF2'><a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target='_blank'><img border='0' src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width='220' height='140'></a></td> 
    </tr>
    <tr>
      <td class="celda-titulo">Fecha Solicitud:</td>
      <td width='83' class='celda2'><?php echo $this->_tpl_vars['fecha_solic']; ?>
</td> 
    </tr>
    <tr>
      <td class="celda-titulo">Tipo Marca:</td>
      <td width='83' class='celda2'><?php echo $this->_tpl_vars['tipo_marca']; ?>
-<?php echo $this->_tpl_vars['tipomarca']; ?>
</td>
    </tr>
    <tr>
      <td class="celda-titulo">Modalidad:</td>
      <td width='83' class='celda2'><?php echo $this->_tpl_vars['modalidad']; ?>
-<?php echo $this->_tpl_vars['modal']; ?>
</td>
    </tr>
    <tr>
      <td class="celda-titulo">Pais:</td>
      <td width='83' class='celda2'><?php echo $this->_tpl_vars['vcodpais']; ?>
-<?php echo $this->_tpl_vars['pais_resid']; ?>
</td>
    </tr>
    <tr>
      <td class="celda-titulo">Fecha Publicaci&oacute;n:</td>
      <td width='83' class='celda2'></td>
    </tr>
    <tr>
      <td class="celda-titulo">Estatus:</td>
      <td width='83%' colspan='2' class='celda2'><b><?php echo $this->_tpl_vars['estatus']; ?>
-<?php echo $this->_tpl_vars['nombest']; ?>
</b></td>
    </tr>
    <tr>
      <td class="celda-titulo">Distingue:</td>
      <td width='83%' colspan='2' class='celda2'><?php echo $this->_tpl_vars['distingue']; ?>
</td>
    </tr>
    <tr>
      <td class="celda-titulo">Etiqueta:</td>
      <td width='83%' colspan='2' class='celda2'><?php echo $this->_tpl_vars['etiqueta']; ?>
</td>
    </tr>
    <tr>
      <td class="celda-titulo">Tramitante/Agente:</td>
      <td width='83%' colspan='2' class='celda2'><?php echo $this->_tpl_vars['tramitante']; ?>
</td>   
    </tr>
    <tr>
      <td class="celda-titulo">Poder No.:</td>
      <td width='83%' colspan='2' class='celda2'><?php echo $this->_tpl_vars['vpod1']; ?>
-<?php echo $this->_tpl_vars['vpod2']; ?>
</td>
    </tr>
  </table>

  <p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="8%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Codigo</b></font></td>
      <td width="40%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Nombre</b></font></td>
      <td width="34%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Domicilio</b></font></td>
      <td width="4%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Pais</b></font></td>
      <td width="4%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Indole</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Identificacion</b></font></td>
    </tr>
    <?php unset($this->_sections['cont2']);
$this->_sections['cont2']['name'] = 'cont2';
$this->_sections['cont2']['loop'] = is_array($_loop=$this->_tpl_vars['vtitrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont2']['show'] = true;
$this->_sections['cont2']['max'] = $this->_sections['cont2']['loop'];
$this->_sections['cont2']['step'] = 1;
$this->_sections['cont2']['start'] = $this->_sections['cont2']['step'] > 0 ? 0 : $this->_sections['cont2']['loop']-1;
if ($this->_sections['cont2']['show']) {
    $this->_sections['cont2']['total'] = $this->_sections['cont2']['loop'];
    if ($this->_sections['cont2']['total'] == 0)
        $this->_sections['cont2']['show'] = false;
} else
    $this->_sections['cont2']['total'] = 0;
if ($this->_sections['cont2']['show']):

            for ($this->_sections['cont2']['index'] = $this->_sections['cont2']['start'], $this->_sections['cont2']['iteration'] = 1;
                 $this->_sections['cont2']['iteration'] <= $this->_sections['cont2']['total'];
                 $this->_sections['cont2']['index'] += $this->_sections['cont2']['step'], $this->_sections['cont2']['iteration']++):
$this->_sections['cont2']['rownum'] = $this->_sections['cont2']['iteration'];
$this->_sections['cont2']['index_prev'] = $this->_sections['cont2']['index'] - $this->_sections['cont2']['step'];
$this->_sections['cont2']['index_next'] = $this->_sections['cont2']['index'] + $this->_sections['cont2']['step'];
$this->_sections['cont2']['first']      = ($this->_sections['cont2']['iteration'] == 1);
$this->_sections['cont2']['last']       = ($this->_sections['cont2']['iteration'] == $this->_sections['cont2']['total']);
?>
    <tr>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_tph1'][$this->_sections['cont2']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_tph2'][$this->_sections['cont2']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_tph3'][$this->_sections['cont2']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_tph4'][$this->_sections['cont2']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_tph5'][$this->_sections['cont2']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_tph6'][$this->_sections['cont2']['index']]; ?>
</small></td>
    </tr>
    <?php endfor; endif; ?> 
  </tr> 
  </table>
  <p align="center"><b><font size="4" face="Tahoma">Cronolog&iacute;a</font></b></p>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha
    Evento</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Vencimiento
    Evento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Nro
    Documento</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Codigo del
    Evento</b></font></td>
      <td width="30%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Descripcion</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha de
    Transaccion</b></font></td>
      <td width="30%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Comentarios</b></font></td>
      <td width="06%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Documento</b></font></td>
    </tr>
    <?php unset($this->_sections['cont']);
$this->_sections['cont']['name'] = 'cont';
$this->_sections['cont']['loop'] = is_array($_loop=$this->_tpl_vars['vnumrows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cont']['show'] = true;
$this->_sections['cont']['max'] = $this->_sections['cont']['loop'];
$this->_sections['cont']['step'] = 1;
$this->_sections['cont']['start'] = $this->_sections['cont']['step'] > 0 ? 0 : $this->_sections['cont']['loop']-1;
if ($this->_sections['cont']['show']) {
    $this->_sections['cont']['total'] = $this->_sections['cont']['loop'];
    if ($this->_sections['cont']['total'] == 0)
        $this->_sections['cont']['show'] = false;
} else
    $this->_sections['cont']['total'] = 0;
if ($this->_sections['cont']['show']):

            for ($this->_sections['cont']['index'] = $this->_sections['cont']['start'], $this->_sections['cont']['iteration'] = 1;
                 $this->_sections['cont']['iteration'] <= $this->_sections['cont']['total'];
                 $this->_sections['cont']['index'] += $this->_sections['cont']['step'], $this->_sections['cont']['iteration']++):
$this->_sections['cont']['rownum'] = $this->_sections['cont']['iteration'];
$this->_sections['cont']['index_prev'] = $this->_sections['cont']['index'] - $this->_sections['cont']['step'];
$this->_sections['cont']['index_next'] = $this->_sections['cont']['index'] + $this->_sections['cont']['step'];
$this->_sections['cont']['first']      = ($this->_sections['cont']['iteration'] == 1);
$this->_sections['cont']['last']       = ($this->_sections['cont']['iteration'] == $this->_sections['cont']['total']);
?>
    <tr>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph1'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph2'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph3'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph4'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph5'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph6'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color"><small><?php echo $this->_tpl_vars['arr_ph7'][$this->_sections['cont']['index']]; ?>
</small></td>
       <td class="der-color">
       <?php if ($this->_tpl_vars['arr_ph4'][$this->_sections['cont']['index']] == 1122 && $this->_tpl_vars['arr_ph10'][$this->_sections['cont']['index']] == 1200 && $this->_tpl_vars['arr_ph3'][$this->_sections['cont']['index']] >= 587): ?>
         <a href=<?php echo $this->_tpl_vars['arr_ph8'][$this->_sections['cont']['index']]; ?>
 target='_blank'><img border='1' src=<?php echo $this->_tpl_vars['imagenresultado']; ?>
 width='40' height='40'></a>
       <?php endif; ?>
       </td>
       <!-- <td class="der-color"><?php echo $this->_tpl_vars['arr_ph9'][$this->_sections['cont']['index']]; ?>
</td> -->
       </td>
    </tr>
    <?php endfor; endif; ?> 
  </tr> 
  </table>

  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module83"><h2 class="tab">Datos Poder</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module83" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
      <td class="celda-titulo">Poder No.:</td>
      <td width='83%' colspan='2' class='celda2'><b><?php echo $this->_tpl_vars['vpod1']; ?>
-<?php echo $this->_tpl_vars['vpod2']; ?>
</b></td>
    </tr>
    <tr>
      <td class="celda-titulo">Fecha Poder:</td>
      <td width='83' class='celda2'><b><?php echo $this->_tpl_vars['fpoder']; ?>
</b></td> 
    </tr>
    <tr>
      <td class="celda-titulo">Facultad:</td>
      <td width='83' class='celda2'><b><?php echo $this->_tpl_vars['facultad']; ?>
</b>&nbsp;&nbsp;&nbsp;-/- (M)arcas (P)atentes (A)mbas</td> 
    </tr>
  </table>

  <p align="center"><b><font size="4" face="Tahoma">Titular(es)</font></b></p>
  <table width="100%" border="1" cellspacing="1" >
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['ltitular']; ?>
</td></tr>
    <tr><td class="izq2-color">
    <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' src='exampletit.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
'></iframe> 
    </td></tr>  
  </table>
  
  <p align="center"><b><font size="4" face="Tahoma">Poderhabiente(s)</font></b></p>
  <table width="100%" border="1" cellspacing="1" >
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['lpoderhabi']; ?>
</td></tr>
    <tr><td class="izq2-color">
    <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' src='examplepoh.php?psol=<?php echo $this->_tpl_vars['vpod1']; ?>
-<?php echo $this->_tpl_vars['vpod2']; ?>
'></iframe> 
    </td></tr>  
  </table>

  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module32"><h2 class="tab">E.Electronico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module32" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <TABLE WIDTH=100%  CLASS="CELDA6" BORDER=1 BORDERCOLOR="#000000" CELLPADDING=2 CELLSPACING=0>
   <COL WIDTH=115*>
   <COL WIDTH=117*>
	<TR VALIGN=TOP>
		<TD WIDTH=45%  > 
                <?php if ($this->_tpl_vars['fplanilla'] == 1): ?>
			<img src="../imagenes/accept.png" border="0">
                        <A HREF=  "../documentos/planilla/pl<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Planilla de Solicitud</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Planilla de Solicitud
                <?php endif; ?>
		</TD>
		<TD WIDTH=46%  >
                <?php if ($this->_tpl_vars['freglamento'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/reglamento/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Reglamento de Uso de Marca </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Reglamento de Uso de Marca
                <?php endif; ?>
		</TD>
	</TR>		
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['ffonetica'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/fonetica/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'>  
                        B&uacute;squeda Fon&eacute;tica  </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Fon&eacute;tica 
                <?php endif; ?>
		</TD>
		<TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fasamblea'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/asamblea/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Acta Ultima Asamblea  </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Acta Ultima Asamblea
                <?php endif; ?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['fgrafica'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/grafica/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"    target='_blank'> 
                        B&uacute;squeda Gr&aacute;fica </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Gr&aacute;fica 
                <?php endif; ?>
		</TD>
		<TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fprioridad'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/prioridad/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Documento(s) de Prioridad Extranjera</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Documento(s) de Prioridad Extranjera
                <?php endif; ?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['fcedula'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/cedula/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        C&eacute;dula de Identidad </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        C&eacute;dula de Identidad
                <?php endif; ?>
		</TD>
		<TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fescritos'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
                        <a  href="m_rptexp_escritos.php?varsol=<?php echo $this->_tpl_vars['varsol']; ?>
" target='_blank'>Escritos</A>
                   <!-- <A HREF="../documentos/escritos/marcas/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf" target='_blank'> 
                        Escritos</A>  -->
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Escritos
                <?php endif; ?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['frif'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/rif/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        R.I.F. (Registro Informaci&oacute;n Fiscal)</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        R.I.F. (Registro Informaci&oacute;n Fiscal)
                <?php endif; ?>
		</TD>
		<TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fcertificado'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/certificado/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Certificado de Registro</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Certificado de Registro
                <?php endif; ?>
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['fpoder'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/poder/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"    target='_blank'> 
                        Poder </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Poder
                <?php endif; ?>
                </TD>
		<TD WIDTH=46%>
                <?php if ($this->_tpl_vars['ftasa'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/tasa/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Comprobante Pago de Tasa</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Comprobante Pago de Tasa
                <?php endif; ?>
		</TD>
	</TR>
        <TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['fmercantil'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/mercantil/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'> 
                        Registro Mercantil </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Registro Mercantil
                <?php endif; ?>
                </TD>
		<!-- <TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fotros'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/otros/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'> 
                        Otros</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Otros
                <?php endif; ?>
		</TD> -->
                <TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fpub_prensa32'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="<?php echo $this->_tpl_vars['name32']; ?>
"  target='_blank'> 
                        Pub.Prensa Extemporaneo (Evento 32)</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Pub.Prensa Extemporaneo (Evento 32)
                <?php endif; ?>
		</TD>
	</TR>
        <TR VALIGN=TOP>
		<TD WIDTH=45%>
                <?php if ($this->_tpl_vars['fpub_prensa22'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="<?php echo $this->_tpl_vars['name22']; ?>
"  target='_blank'> 
                        Publicaci&oacute;n en Prensa (Evento 22)</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Publicaci&oacute;n en Prensa (Evento 22)
                <?php endif; ?>
                </TD>
                <TD WIDTH=46%>
                <?php if ($this->_tpl_vars['fpub_prensa33'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="<?php echo $this->_tpl_vars['name33']; ?>
"  target='_blank'> 
                        Pub.Prensa Defectuoso (Evento 33)</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Pub.Prensa Defectuoso (Evento 33)
                <?php endif; ?>
		</TD>
	</TR>
</TABLE>

  <table width="350">
    <tr>
      <td><a href="m_rptexp.php?varsol=<?php echo $this->_tpl_vars['varsol']; ?>
"><img src="../imagenes/folder_explore.png" border="0"></a>&nbsp;&nbsp;Ver Expediente Completo</td>
    </tr>
  </table>
  &nbsp;
  </div>
  </div>


  <div class="tab-page" id="module91"><h2 class="tab">Dev. Forma</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module91" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  
  &nbsp;  
  </div>
  </div>

  <div class="tab-page" id="module81"><h2 class="tab">Prensa</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module81" ) );
  </script>
  <div align="left">
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
    <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" colspan="3" >
        <input type="text" name="evento" <?php echo $this->_tpl_vars['vmodo']; ?>
 value="21" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;
        <input type="text" name="fevento4" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fevento4']; ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.formarcas2.save)" onchange="valFecha(this,document.formarcas2.save)" >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 1): ?>
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Prensa'" />
        <?php else: ?>
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        <?php endif; ?>
      </td>
    </tr>

  </tr> 
  </table>

  &nbsp;
  </div>
  </div>


  <div class="tab-page" id="module31"><h2 class="tab">B.Fonetica</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module31" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <p align="center"><font size="4" face="Tahoma">Antecedentes de Identidad en todas las Clases</font>

  <table width="100%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">Identidad</td></tr>
    <tr><td>    
    <iframe id='top1' style='width:99%;height:300px;background-color: WHITE;' src="m_verfoniden.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe>  
    </td></tr>
  </table>
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <td>
     <a href="../consultamarcas/indexgramatical.php" target='_blank'><font size="2" face="Tahoma"><b><i>&nbsp;&nbsp;Haga Clic aqui, si desea Realizar B&uacute;squeda Gramatical</i></b></font></a>
    </td>
  </tr> 
  </table>

  <p align="center"><font size="4" face="Tahoma">Antecedentes de Semejanza en la Clase Solicitada</font>
  <table width="100%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">Semejanzas</td></tr>
    <tr><td>    
    <iframe id='top2' style='width:99%;height:300px;background-color: WHITE;' src="m_verfonsem.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
"></iframe>  
    </td></tr>
  </table>
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <td>
     <a href="../consultamarcas/indexgramatical.php" target='_blank'><font size="2" face="Tahoma"><b><i>&nbsp;&nbsp;Haga Clic aqui, si desea Realizar B&uacute;squeda Gramatical</i></b></font></a>
    </td>
  </tr> 
  </table>

  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module28"><h2 class="tab">Dev.Fondo</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module28" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="3" cellspacing="1">
  <tr>
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][0]; ?>
</td><td class="der-color"><input type="checkbox" name="causa1"><td>
         <td class="der-color"><?php echo $this->_tpl_vars['descausa'][0]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][1]; ?>
</td><td class="der-color"><input type="checkbox" name="causa2"><td>
         <td class="der-color"><?php echo $this->_tpl_vars['descausa'][1]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][2]; ?>
</td><td class="der-color"><input type="checkbox" name="causa3"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][2]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][3]; ?>
</td><td class="der-color"><input type="checkbox" name="causa4"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][3]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][4]; ?>
</td><td class="der-color"><input type="checkbox" name="causa5"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][4]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][5]; ?>
</td><td class="der-color"><input type="checkbox" name="causa6"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][5]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][6]; ?>
</td><td class="der-color"><input type="checkbox" name="causa7"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][6]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][7]; ?>
</td><td class="der-color"><input type="checkbox" name="causa8"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][7]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][8]; ?>
</td><td class="der-color"><input type="checkbox" name="causa9"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][8]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][9]; ?>
</td><td class="der-color"><input type="checkbox" name="causa10"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][9]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][10]; ?>
</td><td class="der-color"><input type="checkbox" name="causa11"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][10]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][11]; ?>
</td><td class="der-color"><input type="checkbox" name="causa12"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][11]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][12]; ?>
</td><td class="der-color"><input type="checkbox" name="causa13"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][12]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][13]; ?>
</td><td class="der-color"><input type="checkbox" name="causa14"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][13]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][14]; ?>
</td><td class="der-color"><input type="checkbox" name="causa15"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][14]; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][15]; ?>
</td><td class="der-color"><input type="checkbox" name="causa16"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][15]; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][16]; ?>
</td><td class="der-color"><input type="checkbox" name="causa17"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['descausa'][16]; ?>
</td> 
<?php if ($this->_tpl_vars['descausa'][17] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][17]; ?>
</td><td class="der-color"><input type="checkbox" name="causa18"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][17]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][18] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][18]; ?>
</td><td class="der-color"><input type="checkbox" name="causa19"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][18]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][19] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][19]; ?>
</td><td class="der-color"><input type="checkbox" name="causa20"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][19]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][20] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][20]; ?>
</td><td class="der-color"><input type="checkbox" name="causa21"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][20]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][21] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][21]; ?>
</td><td class="der-color"><input type="checkbox" name="causa22"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][21]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][22] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][22]; ?>
</td><td class="der-color"><input type="checkbox" name="causa23"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][22]; ?>
</td><?php endif;  if ($this->_tpl_vars['descausa'][23] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][23]; ?>
</td><td class="der-color"><input type="checkbox" name="causa24"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][23]; ?>
</td></tr><tr><?php endif;  if ($this->_tpl_vars['descausa'][24] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['codcausa'][24]; ?>
</td><td class="der-color"><input type="checkbox" name="causa25"><td><td class="der-color"><?php echo $this->_tpl_vars['descausa'][24]; ?>
</td></tr><tr><?php endif; ?>

	</tr>
  </tr>
  </table>
  <table>
  <tr>
    <td class="izq-color"><?php echo $this->_tpl_vars['lotro']; ?>
</td><td class="der-color"><input type="text" name="otro" <?php echo $this->_tpl_vars['modo']; ?>
 size="148" ><td>
  </tr>
  </table>
  <table border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" <?php echo $this->_tpl_vars['vmodo']; ?>
 value="500" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;
        <input type="text" name="fevento1" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fevento1']; ?>
' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 1): ?>
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Devolver'" />
        <?php else: ?>
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        <?php endif; ?>
      </td>
    </tr>
  </tr>
  </table>

  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module29"><h2 class="tab">Negada</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module29" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTA\D1A CORRESPONDIENTE</b></font></small>
   <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1">
  <input type ='hidden' name='vcomenta' value='<?php echo $this->_tpl_vars['vcom']; ?>
'>
  <tr>
    <tr>
      <td class="izq-color"><?php echo $this->_tpl_vars['lcomentario']; ?>
</td><td class="der-color">
        <textarea rows="2" name="comenta1" <?php echo $this->_tpl_vars['modo']; ?>
 cols="104" onchange="this.value=this.value.toUpperCase()"></textarea>
      </td>
    </tr>
  </tr>
  </table>	
  &nbsp;

     <table>	    
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['lart']; ?>
</td><td class="der-color"><input size="2" type="text" name="art" maxlength="2"  onKeyPress="return acceptChar(event,2, this)" onchange="validart56(this,document.formarcas2.lit1,document.formarcas2.vlit1reg11)" onkeyup="checkLength(event,this,2,document.formarcas2.lit1)">&nbsp;<td>
	 
	 <!-- Primer Literal - 1er. Registro -->	
	 <td class="izq-color"><?php echo $this->_tpl_vars['llit']; ?>
</td><td class="der-color"><input size="1" type="text" name="lit1" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  
	 onkeyup="checkLength(event,this,2,document.formarcas2.vlit1reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit1reg11);">&nbsp;<td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lreg']; ?>
</td><td class="der-color">
	        <input type="text" name="vlit1reg11" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['lit1reg11']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg12" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['lit1reg12']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg21)" onchange="Rellena(document.formarcas2.vlit1reg12,6)">&nbsp;</td>
	<!-- <td rowspan="3"><?php echo $this->_tpl_vars['espacios']; ?>
</td>	-->
	&nbsp;	
	 <!-- Segundo Literal - 1er. Registro -->	
	 <td class="izq-color"><?php echo $this->_tpl_vars['llit']; ?>
</td><td class="der-color"><input size="1" type="text" name="lit2" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  onkeyup="checkLength(event,this,2,document.formarcas2.vlit2reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit2reg11);">&nbsp;<td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lreg']; ?>
</td><td class="der-color">
	        <input type="text" name="vlit2reg11" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['lit2reg11']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg12" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['lit2reg12']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg21)" onchange="Rellena(document.formarcas2.vlit2reg12,6)">&nbsp;</td></tr><tr>
 	 </tr><tr>
 	 
	 <!-- Primer Lireral - 2do. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lreg']; ?>
</td><td class="der-color">
	        <input type="text" name="vlit1reg21" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['lit1reg21']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg22" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['lit1reg22']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg31)" onchange="Rellena(document.formarcas2.vlit1reg22,6)">&nbsp;</td>
		<td></td><td><td>	
		
	 <!-- Segundo Lireral - 2do. Registro -->	
	 <td class="der-color"><?php echo $this->_tpl_vars['lreg']; ?>
</td><td class="der-color">
	        <input type="text" name="vlit2reg21" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['lit2reg21']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg22" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['lit2reg22']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg31)" onchange="Rellena(document.formarcas2.vlit2reg22,6)">&nbsp;</td>
		</tr><tr>
		
    <!-- Primer Lireral - 3er. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lreg']; ?>
</td><td class="der-color">
	        <input type="text" name="vlit1reg31" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['lit1reg31']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg32" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['lit1reg32']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.lit2)" onchange="Rellena(document.formarcas2.vlit1reg32,6)">&nbsp;</td>
		
      <td></td><td><td>
      	 	 	
    <!-- Segundo Lireral - 3er. Registro -->	
	 <td class="der-color"><?php echo $this->_tpl_vars['lreg']; ?>
</td><td class="der-color">
	        <input type="text" name="vlit2reg31" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['lit2reg31']; ?>
' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg32" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['lit2reg32']; ?>
' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.comenta)" onchange="Rellena(document.formarcas2.vlit2reg32,6)">&nbsp;</td></tr>			
     </table>
     &nbsp;
  
  <table border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" <?php echo $this->_tpl_vars['vmodo']; ?>
 value="225" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;
        <input type="text" name="fevento2" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fevento2']; ?>
' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 1): ?>
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Negar'" />
        <?php else: ?>
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        <?php endif; ?>
      </td>
    </tr>
  </tr>
  </table>

  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module30"><h2 class="tab">Detener</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module30" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
  <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
  <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="70" maxlength="100">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
  </tr>

  <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['lcomentario']; ?>
</td><td class="der-color">
       <textarea rows="2" name="comenta2" <?php echo $this->_tpl_vars['modo']; ?>
 cols="108" onchange="this.value=this.value.toUpperCase()"></textarea>
     </td>
  </tr>
  </tr>
  </table>	
  &nbsp;
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" <?php echo $this->_tpl_vars['vmodo']; ?>
 value="54" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;
        <input type="text" name="fevento3" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fevento3']; ?>
' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 1): ?>
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Detener'" />
        <?php else: ?>
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        <?php endif; ?>
      </td>
    </tr>
  </tr>
  </table>

  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module25"><h2 class="tab">Concedida</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module25" ) );
  </script>
  <div align="left">
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
    <tr>
     <td class="izq-color"><?php echo $this->_tpl_vars['campo4']; ?>
</td><td class="der-color">
       <input type="text" name="nombre" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['nombre']; ?>
' size="75" maxlength="120">
       &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo5']; ?>
&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclase']; ?>
' size="1" maxlength="2" > -
       <input type="text" name="indclase" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['indclase']; ?>
' size="15" maxlength="15" >
     </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo14']; ?>
</td>
      <td class="der-color" colspan="3" >
        <input type="text" name="evento" <?php echo $this->_tpl_vars['vmodo']; ?>
 value="51" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;<?php echo $this->_tpl_vars['campo15']; ?>
&nbsp;&nbsp;
        <input type="text" name="fevento" <?php echo $this->_tpl_vars['modo']; ?>
 value='<?php echo $this->_tpl_vars['fevento']; ?>
' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.formarcas2.save)" onchange="valFecha(this,document.formarcas2.save)" >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if ($this->_tpl_vars['vopc'] == 3 || $this->_tpl_vars['vopc'] == 1): ?>
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Conceder'" />
        <?php else: ?>
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        <?php endif; ?>
      </td>
    </tr>

  </tr> 
  </table>
  &nbsp;
  </div>
  </div>

</form>
</div>  
  &nbsp;
  &nbsp;

</body>
</html>