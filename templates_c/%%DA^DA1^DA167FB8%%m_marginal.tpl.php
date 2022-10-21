<?php /* Smarty version 2.6.8, created on 2020-10-20 09:06:32
         compiled from m_marginal.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip', 'm_marginal.tpl', 63, false),array('function', 'html_radios', 'm_marginal.tpl', 82, false),array('function', 'html_options', 'm_marginal.tpl', 157, false),)), $this); ?>
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
    <form name="formarcas1" action="m_marginal.php?vopc=1" method="post">
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
    <form name="formarcas2" action="m_marginal.php?vopc=2" method="post">
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
      </table>
      
      &nbsp; 
      <table cellspacing="1" border="1">	
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
	    <td class="der-color"><input size="72" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
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
	    <td class="der-color"><input size="72" type="text" name="vdomtit" value='<?php echo $this->_tpl_vars['vdomtit']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltrage']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vtrage" 
	    value="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtra'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp));  echo $this->_tpl_vars['vcodage']; ?>
.<?php echo $this->_tpl_vars['vnomage']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
	    
     </table>		

     </form>
     <form name="formarcas3" action="m_marginal.php?vopc=3" method="post" onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
'>
     <input type="hidden" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
'>
     <input type="hidden" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
'>
     <input type="hidden" name="vnactit" value='<?php echo $this->_tpl_vars['vnactit']; ?>
'>
     <input type="hidden" name="vdomtit" value='<?php echo $this->_tpl_vars['vdomtit']; ?>
'>
     <input type="hidden" name="vcodage" value='<?php echo $this->_tpl_vars['vcodage']; ?>
'>
     <input type="hidden" name="vnomage" value='<?php echo $this->_tpl_vars['vnomage']; ?>
'>
     <input type="hidden" name="vtra" value='<?php echo $this->_tpl_vars['vtra']; ?>
'>
     <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>
     
     <table cellspacing="1" border="1">
       <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der1-color">
	        <?php echo smarty_function_html_radios(array('name' => 'vtipo','values' => $this->_tpl_vars['vtipo_id'],'selected' => $this->_tpl_vars['vtipo'],'output' => $this->_tpl_vars['vtipo_de'],'separator' => ""), $this);?>

	    </td></tr>
	    
	    <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldocumento']; ?>
</td>
	    <td class="der-color">
          <?php echo smarty_function_html_radios(array('name' => 'vseldoc','values' => $this->_tpl_vars['vdoc_id'],'selected' => $this->_tpl_vars['vseldoc'],'output' => $this->_tpl_vars['vdoc_de'],'separator' => ""), $this);?>
&nbsp;&nbsp;	    
	       <input size="10" type="text" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' maxlength="10" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,10,document.formarcas3.vfecv)">
	    </td></tr>

       <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechaven']; ?>
</td>
	    <td class="der-color">
	    <input size="9" type="text" name="vfecv"  onkeyup="checkLength(event,this,10,document.formarcas3.vclasint)"
	    onchange="valFecha(this,document.formarcas3.vclasint)">
       &nbsp;&nbsp;
       <a href="javascript:showCal('Calendar60');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	    
	    &nbsp;&nbsp;&nbsp;
	    <?php echo $this->_tpl_vars['lclaseint']; ?>
&nbsp;&nbsp;<input size="1" type="text" name="vclasint" value='<?php echo $this->_tpl_vars['vclasint']; ?>
' onkeyup="checkLength(event,this,2,document.formarcas3.vcomenta)">
	    &nbsp;<font size="1">Vencimiento y Clase / Solo para Renovaciones</font>&nbsp;<td></tr>  
       <tr><td class="izq-color"></td>
	    <td class="der-color">
	    <font size="1"><?php echo $this->_tpl_vars['lfusion']; ?>
</font>
       </td></tr> 

	    <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcomenta']; ?>
</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" cols="92" onKeyup="this.value=this.value.toUpperCase()"></textarea></td></tr>

       <tr><td class="izq-color"></td>
	    <td class="der-color">
	    <font size="1">De tenerlo el Documento, favor colocar el Domicilio y el Pa&iacute;s</font>
       </td></tr> 

       <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldomant']; ?>
</td>
	    <td class="der-color"><input size="92" type="text" name="vdomant"  onchange="this.value=this.value.toUpperCase()"></td></tr>    
      </table>
        
    <!-- <table width="85%">
    <tr><td class="izq2-color"><?php echo $this->_tpl_vars['lpropietario']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
        <input type="button" value="Buscar/Eliminar" name="vtitue" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
        <br>
    </td></tr> 
    </table> --> 

    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['lpropietario']; ?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $this->_tpl_vars['vsol1']; ?>
-<?php echo $this->_tpl_vars['vsol2']; ?>
&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" <?php echo $this->_tpl_vars['modo2']; ?>
 onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
        <br>
    </td></tr> 
    </table>


         
     <table cellspacing="1" border="1">
	    <!-- <td class="der-color">
	    <font size="1">Domicilio del Licenciatario, del Sobreviviente o Actual</font>
       </td></tr> 
       <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldomnew']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vdomnew"  onchange="this.value=this.value.toUpperCase()"></td></tr>    
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lnacnew']; ?>
</td>
	     <td colspan="2" class="der-color">
        <input type="text" name="input2" value='<?php echo $this->_tpl_vars['pais_resid']; ?>
' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas3.vcodagen)" onchange="valagente(document.formarcas3.input2,document.formarcas3.pais)">-
        <select size="1" name="pais" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodpai'],'selected' => $this->_tpl_vars['pais_resid'],'output' => $this->_tpl_vars['vnompai']), $this);?>

        </select>
      </td>
	    </tr> -->          


	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lagenew']; ?>
</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">	    
	    <select size=1 name="vnomagen" onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	        <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodagenew'],'output' => $this->_tpl_vars['vnomagenew']), $this);?>

	    <select></td>
	    </tr>        
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltranew']; ?>
</td>
	    <td class="der-color"><input size="104" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      

        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lpub']; ?>
</td>
	    <td class="der-color">
	       <?php echo smarty_function_html_radios(array('name' => 'vpub','values' => $this->_tpl_vars['vpub_id'],'selected' => $this->_tpl_vars['vpub'],'output' => $this->_tpl_vars['vpub_de'],'separator' => ""), $this);?>

	       &nbsp;&nbsp;<?php echo $this->_tpl_vars['lboletin']; ?>
&nbsp;&nbsp;<input size="3" type="text" name="vbol" value='<?php echo $this->_tpl_vars['vbol']; ?>
' maxlength="3" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,3,document.formarcas3.vcrono)">  
	    </td></tr>
      </table>
      &nbsp;
           <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'> 
           <input type="hidden" name="vregh" value='<?php echo $this->_tpl_vars['registro1'];  echo $this->_tpl_vars['registro2']; ?>
'>
     <table width="255">
        <tr>
        <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['solicitud1']; ?>
&vsol2=<?php echo $this->_tpl_vars['solicitud2']; ?>
"><input type="image" name="vcrono" src="../imagenes/boton_cronologia_azul.png"></a></td>
        <td class="cnt"><input type="image" name="vgrabar" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="m_marginal.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

