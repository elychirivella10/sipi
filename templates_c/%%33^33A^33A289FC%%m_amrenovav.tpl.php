<?php /* Smarty version 2.6.8, created on 2020-11-10 09:31:52
         compiled from m_amrenovav.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip', 'm_amrenovav.tpl', 47, false),array('function', 'html_options', 'm_amrenovav.tpl', 73, false),)), $this); ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <!-- <H3><?php echo $this->_tpl_vars['subtitulo']; ?>
</H3> -->
  
  <div align="center">
    <form name="formarcas1" action="m_amrenovav.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['solicitud1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['solicitud2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>				  
    <form name="formarcas2" action="m_amrenovav.php?vopc=2" method="post">
	    <td><?php echo $this->_tpl_vars['espacios']; ?>
</td>
	    <td class="izq5-color"><?php echo $this->_tpl_vars['lregistro']; ?>
 </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $this->_tpl_vars['registro1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $this->_tpl_vars['registro2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
<!--		<td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td> -->
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecsol']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecreg']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='<?php echo $this->_tpl_vars['vfecreg']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecven']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='<?php echo $this->_tpl_vars['vfecven']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lnombre']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lclase']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltrage']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vtrage" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtra'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp));  echo $this->_tpl_vars['vcodage']; ?>
.<?php echo $this->_tpl_vars['vnomage']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
     </table>		

     </form>
     <form name="formarcas3" action="m_amrenovav.php?vopc=3" method="post" onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
'>
     <input type="hidden" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
'>
     <input type="hidden" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
'>
     <input type="hidden" name="vfecven" value='<?php echo $this->_tpl_vars['vfecven']; ?>
'>
     <input type="hidden" name="vcodage" value='<?php echo $this->_tpl_vars['vcodage']; ?>
'>
     <input type="hidden" name="vnomage" value='<?php echo $this->_tpl_vars['vnomage']; ?>
'>
     <input type="hidden" name="vtra" value='<?php echo $this->_tpl_vars['vtra']; ?>
'>
     <input type="hidden" name="vderh" value='<?php echo $this->_tpl_vars['vderh']; ?>
'>
     <table cellspacing="1" border="1">
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechaevento']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfevh"  onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	    onchange="valFecha(this,document.formarcas3.vdoc)"><td></tr>
<!-- 	    <td><?php echo $this->_tpl_vars['espacios']; ?>
</td> -->
	    <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldocumento']; ?>
</td>
	    <td class="der-color"><input size="7" type="text" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,7,document.formarcas3.input1)"></td></tr>
<!--       </table>
        &nbsp;     
     <table> -->
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lagenew']; ?>
</td> 
        <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">	    
	    <select size=1 name="vnomagen" onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodagenew'],'output' => $this->_tpl_vars['vnomagenew']), $this);?>

	    </select></td>
       <!--
	    <td class="der-color"><input size="30" type="text" name="input1" value="" onkeyup="this.value=this.value.toUpperCase();autoComplete(this,this.form.options,'value',true)" onchange="valagente(document.formarcas3.options,document.formarcas3.input1)">	    
	    <select size=1 name="options" onchange= "this.form.input1.value=this.options[this.selectedIndex].value">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vnomagenew'],'output' => $this->_tpl_vars['vnomagenew']), $this);?>

	    </select></td> -->
	    </tr>        	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltranew']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcomenta']; ?>
</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" cols="75" onchange="this.value=this.value.toUpperCase()"></textarea></td></tr>
      </table>
      &nbsp;
           <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'> 
           <input type="hidden" name="vregh" value='<?php echo $this->_tpl_vars['registro1'];  echo $this->_tpl_vars['registro2']; ?>
'>
      &nbsp;
     <legend align='center' class='Estilo3'><strong><span>&nbsp;&nbsp;INGRESE EL DATO DE FACTURACION&nbsp;&nbsp;</span></strong></legend>
      <table cellspacing="1" border="1"> 
  	    <tr>
	      <td class="izq-color"><?php echo $this->_tpl_vars['lfactura']; ?>
</td>
  	      <td class="der-color">
	        <input size="7" type="text" name="vfactura" maxlength="7" <?php echo $this->_tpl_vars['modo1']; ?>
>	    
         </td>
         <td width="25%" class="izq-color"><?php echo $this->_tpl_vars['lfechafactura']; ?>
</td>
         &nbsp;&nbsp;       
	      <td class="der-color">
	        <input size="9" type="text" name="fac_fecha"  onkeyup="checkLength(event,this,10,document.formarcas3.guardar)"
	    onchange="valFecha(this,document.formarcas3.guardar)" <?php echo $this->_tpl_vars['modo1']; ?>
>
	      </td>  
	    </tr>        
      </table>
      <br>
     <table width="235">
      <tr>
       <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['solicitud1']; ?>
&vsol2=<?php echo $this->_tpl_vars['solicitud2']; ?>
&vreg1=<?php echo $this->_tpl_vars['registro1']; ?>
&vreg2=<?php echo $this->_tpl_vars['registro2']; ?>
"><input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
       <td class="cnt"><a href="m_amrenovav.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

