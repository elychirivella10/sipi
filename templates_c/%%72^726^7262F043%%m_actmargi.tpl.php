<?php /* Smarty version 2.6.8, created on 2020-10-21 09:42:03
         compiled from m_actmargi.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'm_actmargi.tpl', 27, false),array('modifier', 'strip', 'm_actmargi.tpl', 107, false),)), $this); ?>
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
    <form name="formarcas1" action="m_actmargi.php?vopc=2" method="post">
      <table>
        <tr>
          <td class="izq5-color"><?php echo $this->_tpl_vars['lregistro']; ?>
</td>
	       <td class="der-color">
             <input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['vreg1']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
	          <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['vreg2']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.tramite)" onchange="Rellena(document.formarcas1.vreg2,6)">&nbsp;&nbsp;</p>
        </tr>
        <tr>
	       <td class="izq5-color"><?php echo $this->_tpl_vars['ltramite']; ?>
</td>
          <td class="der-color">
            <select size="1" name="tramite" <?php echo $this->_tpl_vars['modo1']; ?>
 >
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['arrayvtrami'],'selected' => $this->_tpl_vars['tramite'],'output' => $this->_tpl_vars['arrayttrami']), $this);?>

            </select>
          </td>
        </tr>
        <tr>
          <td class="izq5-color"><?php echo $this->_tpl_vars['lfecharen']; ?>
</td>
	       <td class="der-color"><input size="9" type="text" name="vfechr" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['vfechr']; ?>
' onkeyup="checkLength(event,this,10,document.formarcas1.vhora)"
	    onchange="valFecha(this,document.formarcas1.vhora)">
           &nbsp;&nbsp;
           <a href="javascript:showCal('Calendar61');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       <td>
        </tr>
        <tr>
          <td class="izq5-color"><?php echo $this->_tpl_vars['lhora']; ?>
</td>
	       <td class="der-color"><input size="7" type="text" name="vhora" <?php echo $this->_tpl_vars['modo1']; ?>
 value='<?php echo $this->_tpl_vars['vhora']; ?>
' onkeyup="checkLength(event,this,8,document.formarcas1.vampm)">&nbsp;
            <select size="1" name="vampm" <?php echo $this->_tpl_vars['modo1']; ?>
 >
              <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['hora_id'],'selected' => $this->_tpl_vars['vampm'],'output' => $this->_tpl_vars['hora_de']), $this);?>

            </select>
          <td>
        </tr>
        <tr>
	       <td class="izq5-color"><?php echo $this->_tpl_vars['ldocumento']; ?>
</td>
	       <td class="der-color">
	         <input size="10" type="text" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 maxlength="10" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,10,document.formarcas1.vbol)">
	       </td>
        </tr>
        <tr>
          <td class="izq5-color"><?php echo $this->_tpl_vars['lboletin']; ?>
</td>
	       <td class="der-color">
            <input size="3" type="text" name="vbol" value='<?php echo $this->_tpl_vars['vbol']; ?>
' <?php echo $this->_tpl_vars['modo1']; ?>
 maxlength="3" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,3,document.formarcas1.buscar)">  
	       </td>
  	      <td class="cnt">
  	        <input type='image' name='buscar' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td></p>
        </tr>
      </table>
    </form>			  
    &nbsp;
    <form name="formarcas2" action="m_actmargi.php?vopc=3" method="post">
      <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>
      <input type="hidden" name="tramite" value='<?php echo $this->_tpl_vars['tramite']; ?>
'>
      <input type="hidden" name="vfechr" value='<?php echo $this->_tpl_vars['vfechr']; ?>
'>
      <input type="hidden" name="vhora" value='<?php echo $this->_tpl_vars['vhora']; ?>
'>
      <input type="hidden" name="vampm" value='<?php echo $this->_tpl_vars['vampm']; ?>
'>
      <input type="hidden" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
'>
      <input type="hidden" name="vbol" value='<?php echo $this->_tpl_vars['vbol']; ?>
'>
      <input type="hidden" name="vregh" value='<?php echo $this->_tpl_vars['vreg1'];  echo $this->_tpl_vars['vreg2']; ?>
'>
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	     <td class="der-color">
	       <input size="10" type="text" name="vsolh" value='<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	     </td>
	</tr>
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecsol']; ?>
</td>
	       <td class="der-color">
	        <input size="9" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	        &nbsp;&nbsp;<?php echo $this->_tpl_vars['lfecreg']; ?>
&nbsp;&nbsp;<input size="9" type="text" name="vfecreg" value='<?php echo $this->_tpl_vars['vfecreg']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	        &nbsp;&nbsp;<?php echo $this->_tpl_vars['lfecven']; ?>
&nbsp;&nbsp;<input size="9" type="text" name="vfecven" value='<?php echo $this->_tpl_vars['vfecven']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	       </td>
	     </tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lnombre']; ?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipom']; ?>
</td>
	    <td class="der-color"><input size="25" type="text" name="vtip" value='<?php echo $this->_tpl_vars['vtip']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   
	      &nbsp;<?php echo $this->_tpl_vars['lclase']; ?>
<input size="1" type="text" name="vclas" value='<?php echo $this->_tpl_vars['vclas']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
         &nbsp;<input size="12" type="text" name="vindc" value='<?php echo $this->_tpl_vars['vindc']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>	    
         &nbsp;<?php echo $this->_tpl_vars['lmodal']; ?>
<input size="12" type="text" name="vmodal" value='<?php echo $this->_tpl_vars['vmodal']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>	    
	    </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lest']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltitular']; ?>
</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="63" type="text" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lnacionalidad']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='<?php echo $this->_tpl_vars['vnactit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vnadtit" value='<?php echo $this->_tpl_vars['vnadtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ldomicilio']; ?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vdomtit" value='<?php echo $this->_tpl_vars['vdomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltrage']; ?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vtrage" 
	    value="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtra'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp));  echo $this->_tpl_vars['vcodage']; ?>
.<?php echo $this->_tpl_vars['vnomage']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	    
    </table>		
    &nbsp;
    <table cellspacing="1" border="1">
       <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechaven']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecv" <?php echo $this->_tpl_vars['vmodo']; ?>
>&nbsp;&nbsp;&nbsp;
	    <?php echo $this->_tpl_vars['lclaseint']; ?>
&nbsp;&nbsp;<input size="1" type="text" name="vclasint" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vclasint']; ?>
'>
	    &nbsp;<font size="1">Vencimiento y Clase / Solo para Renovaciones</font>&nbsp;<td></tr>  
       <tr><td class="izq-color"></td>
	    <td class="der-color">
	    <font size="1"><?php echo $this->_tpl_vars['lfusion']; ?>
</font>
       </td></tr> 

	    <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcomenta']; ?>
</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" <?php echo $this->_tpl_vars['vmodo']; ?>
 cols="92" onKeyup="this.value=this.value.toUpperCase()"><?php echo $this->_tpl_vars['vcomenta']; ?>
</textarea></td></tr>

       <tr><td class="izq-color"></td>
	    <td class="der-color">
       </td></tr> 

       <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldomant']; ?>
</td>
	    <td class="der-color"><input size="92" type="text" name="vdomant" <?php echo $this->_tpl_vars['vmodo']; ?>
  value='<?php echo $this->_tpl_vars['vdomant']; ?>
'></td></tr>    
      </table>
      
    <br />
    <table width="85%">
      <tr><td class="izq4-color"><?php echo $this->_tpl_vars['lpropietario']; ?>
</td>
    </table>
    <table width="85%" cellspacing="1" border="1">
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['lnomtit']; ?>
</td>
	 <td class="der-color"><textarea rows="2" name="vcomenta" cols="105" <?php echo $this->_tpl_vars['vmodo']; ?>
><?php echo $this->_tpl_vars['vnewtit']; ?>
</textarea></td></tr>
     <tr><td class="izq-color"></td>
	 <td class="der-color">
     </td></tr> 
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldomnew']; ?>
</td>
	 <td class="der-color"><input size="105" type="text" name="vdomtit" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vdomtit']; ?>
'></td></tr>    
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltranew']; ?>
</td>
         <td class="der-color"><input size="104" type="text" name="vtraf" <?php echo $this->_tpl_vars['vmodo']; ?>
 value='<?php echo $this->_tpl_vars['vtraf']; ?>
'  onchange="this.value=this.value.toUpperCase()"></td></tr>      

    </table>
         
      &nbsp;
     <table width="255">
        <tr>
        <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['vsol1']; ?>
&vsol2=<?php echo $this->_tpl_vars['vsol2']; ?>
"><input type="image" name="vcrono" src="../imagenes/boton_cronologia_azul.png"></a></td>
        <td class="cnt"><input type="image" name="veliminar" src="../imagenes/boton_eliminar_rojo.png" value="Eliminar"></td> 
        <td class="cnt"><a href="m_actmargi.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

