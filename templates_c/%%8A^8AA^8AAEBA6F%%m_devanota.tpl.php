<?php /* Smarty version 2.6.8, created on 2021-03-24 16:53:37
         compiled from m_devanota.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_devanota.tpl', 43, false),)), $this); ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="javascript" src="../include/cal2.js"></script>
    <script language="javascript" src="../include/cal_conf2.js"></script>
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <div align="center">
    <form name="formarcas1" action="m_devanota.php?vopc=1" method="post">
      <table>
        <tr>
            <td class="izq5-color"><?php echo $this->_tpl_vars['lregistro']; ?>
</td>
	    <td class="der-color">
              <input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['vreg1']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
	      <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vreg2']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vreg2,6)">&nbsp;&nbsp;
	    <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td></p>
        </tr>
      </table>
    </form>			  
    <form name="formarcas2" action="m_devanota.php?vopc=3" method="post" onsubmit='return pregunta();'>
      <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'>
      <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>
      <input type="hidden" name="vopcpod" value=0>
      <input type="hidden" name="vreg1" value=<?php echo $this->_tpl_vars['vreg1']; ?>
>
      <input type="hidden" name="vreg2" value=<?php echo $this->_tpl_vars['vreg2']; ?>
>
            
      <table>
       <tr>
         <!-- <td class="izq-color"><?php echo $this->_tpl_vars['lfechaevent']; ?>
</td>
	 <td class="der-color"><input size="9" type="text" name="vfevh" value='<?php echo $this->_tpl_vars['vfec']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td>
    	 <td><?php echo $this->_tpl_vars['espacios']; ?>
&nbsp;&nbsp;</td>-->
	 <td class="izq5-color"><?php echo $this->_tpl_vars['ltramite']; ?>
</td>
         <td class="der-color">
            <select size="1" name="tramite" >
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvtrami'],'selected' => $this->_tpl_vars['tramite'],'output' => $this->_tpl_vars['arrayttrami']), $this);?>

            </select>
         </td>
    	 <td><?php echo $this->_tpl_vars['espacios']; ?>
&nbsp;&nbsp;</td>
         <td class="izq5-color"><?php echo $this->_tpl_vars['lfecharen']; ?>
</td>
	      <td class="der-color">
	         <input size="9" type="text" name="vfechr" value='<?php echo $this->_tpl_vars['vfechr']; ?>
' onkeyup="checkLength(event,this,10,document.formarcas2.vnumtram)"
	    onchange="valFecha(this,document.formarcas2.vnumtram)">
            &nbsp;&nbsp;
            <a href="javascript:showCal('Calendar51');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	      <td>
       <td class="izq5-color"><?php echo $this->_tpl_vars['lnumtra']; ?>
</td>
	    <td class="der-color">
           <input type="text" name="vnumtram" size="10" maxlength="10" value='<?php echo $this->_tpl_vars['vnumtram']; ?>
'>
       </td>
       </tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color">
              <input type="text" name="vsol1" size="3" maxlength="4" value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>-
              <input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['lfechasolic']; ?>
&nbsp;
              <input size="10" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
            </td>
          <?php if (( $this->_tpl_vars['vmod'] == 'G' || $this->_tpl_vars['vmod'] == 'M' )): ?>
	        <td class="der-color" rowspan="6" align="center" valign="top">
                <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
                <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="156"></td>
	    <?php endif; ?>    
	</tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lnombre']; ?>
</td>
	    <td class="der-color"><input size="63" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td>
	</tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lclase']; ?>
</td>
	   <td class="der-color">
             <input size="1" type="text" name="vcla" value='<?php echo $this->_tpl_vars['clase']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	     <input size="14" type="text" name="vindcla" value='<?php echo $this->_tpl_vars['ind_claseni']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
             &nbsp;&nbsp;<?php echo $this->_tpl_vars['lctipom']; ?>

	     <input size="30" type="text" name="vtipo" value='<?php echo $this->_tpl_vars['lctipo']; ?>
 - <?php echo $this->_tpl_vars['tipomarca']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
           </td>
        </tr>
	<tr>
         <td class="izq-color" ><?php echo $this->_tpl_vars['lmodal']; ?>
</td>
         <td class="der-color">
           <input size="15" name="vmod" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vmod']; ?>
 - <?php echo $this->_tpl_vars['vmodal']; ?>
'>
         </td>
        </tr>
	<tr>
         <td class="izq-color" ><?php echo $this->_tpl_vars['lestatus']; ?>
</td>
         <td class="der-color">
           <input size="63" name="ves" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vest']; ?>
 - <?php echo $this->_tpl_vars['vdest']; ?>
'>
         </td>
        </tr>
      </table>
    &nbsp;

   <table cellspacing="1" border="1">
   <tr><td class="izq4-color" colspan="2">Datos del Poder / Agente / Tramitante:</td>
       <td class="izq4-color" colspan="2">(Llenar &uacute;nicamente cuando los datos esten desactualizados)</td>
   </tr>
   <tr>
       <td class="izq-color" >Tramitante Actual:</td>
       <td class="der-color">
           <input type="text" name="vtramita" value='<?php echo $this->_tpl_vars['vtramita']; ?>
' size="50" readonly="readonly">
       </td>
       <td class="izq3-color" >Nuevo Tramitante:</td>
       <td class="der-color">
           <input type="text" name="tramitante" value='<?php echo $this->_tpl_vars['tramitante']; ?>
' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
       </td>
   </tr>
   <tr>
       <td class="izq-color" >Poder Actual:</td>
       <td class="der-color">
           <input size="50" name="vpoder" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vpoder']; ?>
'>
       </td>
       <td class="izq3-color" >Nuevo Poder:</td>
       <td class="der-color">
           <input type="text" name="vpod1" value='<?php echo $this->_tpl_vars['vpod1']; ?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas2.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
           <input type="text" name="vpod2" value='<?php echo $this->_tpl_vars['vpod2']; ?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.busca)">&nbsp;&nbsp;
           <input type='image' name='busca' src="../imagenes/find.png" value="Buscar"  onclick="document.formarcas2.vopcpod.value=1;">
       </td>
    </tr> 
    <tr>
      <td class="izq-color" >Agente(s):</td>
      <td class="der-color">
          <textarea rows="2" readonly="readonly" name="vtragen" cols="60"><?php echo $this->_tpl_vars['vtragen']; ?>
</textarea>
      </td>
      <td class="izq3-color" >Agente(s):</td>
      <td class="der-color">
          <textarea rows="2" readonly="readonly" name="poderhabi" cols="60"><?php echo $this->_tpl_vars['poderhabi']; ?>
</textarea>
      </td>
    </tr>
    </table>
    &nbsp;

      <?php if ($this->_tpl_vars['vopc'] != 0): ?>
      <H3><?php echo $this->_tpl_vars['lcausadev']; ?>
</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['uno']; ?>
</td><td class="der-color"><input type="checkbox" name="causa1" <?php echo $this->_tpl_vars['ck_causa1']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['luno']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dos']; ?>
</td><td class="der-color"><input type="checkbox" name="causa2" <?php echo $this->_tpl_vars['ck_causa2']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldos']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['tres']; ?>
</td><td class="der-color"><input type="checkbox" name="causa3" <?php echo $this->_tpl_vars['ck_causa3']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ltres']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['cuatro']; ?>
</td><td class="der-color"><input type="checkbox" name="causa4" <?php echo $this->_tpl_vars['ck_causa4']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcuatro']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['cinco']; ?>
</td><td class="der-color"><input type="checkbox" name="causa5" <?php echo $this->_tpl_vars['ck_causa5']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcinco']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['seis']; ?>
</td><td class="der-color"><input type="checkbox" name="causa6" <?php echo $this->_tpl_vars['ck_causa6']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lseis']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['siete']; ?>
</td><td class="der-color"><input type="checkbox" name="causa7" <?php echo $this->_tpl_vars['ck_causa7']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lsiete']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['ocho']; ?>
</td><td class="der-color"><input type="checkbox" name="causa8" <?php echo $this->_tpl_vars['ck_causa8']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['locho']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['nueve']; ?>
</td><td class="der-color"><input type="checkbox" name="causa9" <?php echo $this->_tpl_vars['ck_causa9']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lnueve']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['diez']; ?>
</td><td class="der-color"><input type="checkbox" name="causa10" <?php echo $this->_tpl_vars['ck_causa10']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiez']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['once']; ?>
</td><td class="der-color"><input type="checkbox" name="causa11" <?php echo $this->_tpl_vars['ck_causa11']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lonce']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['doce']; ?>
</td><td class="der-color"><input type="checkbox" name="causa12" <?php echo $this->_tpl_vars['ck_causa12']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldoce']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['trece']; ?>
</td><td class="der-color"><input type="checkbox" name="causa13" <?php echo $this->_tpl_vars['ck_causa13']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ltrece']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['catorce']; ?>
</td><td class="der-color"><input type="checkbox" name="causa14" <?php echo $this->_tpl_vars['ck_causa14']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcatorce']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['quince']; ?>
</td><td class="der-color"><input type="checkbox" name="causa15" <?php echo $this->_tpl_vars['ck_causa15']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lquince']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dieciseis']; ?>
</td><td class="der-color"><input type="checkbox" name="causa16" <?php echo $this->_tpl_vars['ck_causa16']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldieciseis']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['diecisiete']; ?>
</td><td class="der-color"><input type="checkbox" name="causa17" <?php echo $this->_tpl_vars['ck_causa17']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiecisiete']; ?>
</td> 
	 <?php if ($this->_tpl_vars['ldieciocho'] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dieciocho']; ?>
</td><td class="der-color"><input type="checkbox" name="causa18" <?php echo $this->_tpl_vars['ck_causa18']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldieciocho']; ?>
</td></tr><tr> 
	 <td class="izq-color"><?php echo $this->_tpl_vars['diecinueve']; ?>
</td><td class="der-color"><input type="checkbox" name="causa19" <?php echo $this->_tpl_vars['ck_causa19']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiecinueve']; ?>
</td> 
	 <td class="izq-color"><?php echo $this->_tpl_vars['veinte']; ?>
</td><td class="der-color"><input type="checkbox" name="causa20" <?php echo $this->_tpl_vars['ck_causa20']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lveinte']; ?>
</td></tr><tr>  
	 <td class="izq-color"><?php echo $this->_tpl_vars['veintiuno']; ?>
</td><td class="der-color"><input type="checkbox" name="causa21" <?php echo $this->_tpl_vars['ck_causa21']; ?>
><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lveintiuno']; ?>
</td> 

	 <?php endif; ?>
	</tr>
	</table>
	<table cellspacing="1" border="1">
	<tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['lotro']; ?>
</td><td class="der-color"><input size="90" type="text" name="otro" value='<?php echo $this->_tpl_vars['otro']; ?>
' maxlength="500" ><td>
	</tr>
	</table>
     </table>
     <?php endif; ?>
     &nbsp;

    <table width="315">
    <tr>
      <td class="der">
      <td class="cnt"><a href="../consultamarcas/busca_marcas_n.php?vnsol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&vopc=2&vusuario=7" target="_blank">
      <img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="m_devanota.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </td>
    </tr>
    </table></center>

    </form>
  </div>  
  </body>
</html>
