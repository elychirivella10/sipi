<?php /* Smarty version 2.6.8, created on 2021-04-13 10:23:24
         compiled from m_amcamdomv.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip', 'm_amcamdomv.tpl', 65, false),array('function', 'html_options', 'm_amcamdomv.tpl', 119, false),)), $this); ?>
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
  <form name="formarcas1" action="m_amcamdomv.php?vopc=1" method="post">
     <table>
     <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
         <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	     value='<?php echo $this->_tpl_vars['solicitud1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
             onchange="Rellena(document.formarcas1.vsol1,4)">-
	                       <input type="text" name="vsol2" size="6" maxlength="6" 
	     value='<?php echo $this->_tpl_vars['solicitud2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
             onchange="Rellena(document.formarcas1.vsol2,6)">
	 <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </form>				  
  <form name="formarcas2" action="m_amcamdomv.php?vopc=2" method="post">
         <td><?php echo $this->_tpl_vars['espacios']; ?>
</td>
	 <td class="izq5-color"><?php echo $this->_tpl_vars['lregistro']; ?>
 </td>
	 <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	     value='<?php echo $this->_tpl_vars['registro1']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,6, this)" 
             onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
	     onChange="this.value=this.value.toUpperCase()">-
		               <input type="text" name="vreg2" size="6" maxlength="6" 
	     value='<?php echo $this->_tpl_vars['registro2']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,6,document.formarcas2.submit)" 
             onchange="Rellena(document.formarcas2.vreg2,6)">
	 <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
     </tr>
     </table>
     &nbsp; 
     <table width="970px" align="center" cellspacing="1" border="1">	
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecsol']; ?>
</td>
	 <td class="der-color"><input size="9" type="text" name="vfecsol" 
             value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
        </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecreg']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" 
                value='<?php echo $this->_tpl_vars['vfecreg']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   
        </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecven']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" 
                value='<?php echo $this->_tpl_vars['vfecven']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   
        </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lnombre']; ?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vnom" 
                value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   
        </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lclase']; ?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                          <input size="67" type="text" name="vdesest" 
                                         value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
        </td></tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['ltrage']; ?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vtrage" 
	        value="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtra'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp));  echo $this->_tpl_vars['vcodage']; ?>
.<?php echo $this->_tpl_vars['vnomage']; ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
>
        </td></tr>
     </table>		
     <!-- Titulares Actuales -->
     <table width="970px" align="center" cellspacing="1" border="1"> 
     <tr><td class="izq2-color"><?php echo $this->_tpl_vars['ltitular']; ?>
</td></tr>
     <tr><td class="izq2-color">
     <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
             src='exampletit.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
&ptip=I&pder=<?php echo $this->_tpl_vars['vderh']; ?>
'></iframe> 
     </td></tr>  
     </table>		
  </form>
  &nbsp;
  <form name="formarcas3" action="m_amcamdomv.php?vopc=3" method="post" 
        onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
'>
<!--     <input type="hidden" name="vcodtit" value='<?php echo $this->_tpl_vars['vcodtit']; ?>
'>
     <input type="hidden" name="vnomtit" value='<?php echo $this->_tpl_vars['vnomtit']; ?>
'> -->
     <input type="hidden" name="vfecven" value='<?php echo $this->_tpl_vars['vfecven']; ?>
'>
     <input type="hidden" name="vcodage" value='<?php echo $this->_tpl_vars['vcodage']; ?>
'>
     <input type="hidden" name="vnomage" value='<?php echo $this->_tpl_vars['vnomage']; ?>
'>
     <input type="hidden" name="vtra" value='<?php echo $this->_tpl_vars['vtra']; ?>
'>
     <table width="970px" align="center" cellspacing="1" border="1">
     <tr><td width="22%" class="izq-color"><?php echo $this->_tpl_vars['lfechaevento']; ?>
</td>
	 <td class="der-color"><input size="9" type="text" name="vfevh"  
             onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	     onchange="valFecha(this,document.formarcas3.vdoc);
                       valagente(document.formarcas3.vnacnew,document.formarcas3.pais)">
     </td></tr>
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldocumento']; ?>
</td>
	 <td class="der-color"><input size="9" type="text" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' 
             maxlength="9" onKeyPress="return acceptChar(event,2,this)" 
             onkeyup="checkLength(event,this,9,document.formarcas3.vnacnew)">
     </td></tr>
     </table>
     <!-- Titulares Finales--> 
     <table width="970px" align="center" cellspacing="1" border="1">
     <tr><td class="izq2-color"><?php echo $this->_tpl_vars['ltitular2']; ?>
</td></tr>
     <tr><td class="izq2-color">
     <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
             src='exampletit.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
&ptip=M'></iframe> 
     </td></tr>  
     <tr><td class="der-color">
     <input type="button" class="boton_blue" value="Cambiar Domicilio" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vtitue"          
            onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitue,document.formarcas3.vtitue)">  
     </td></tr>  
     </table>
     <!-- -->
     <table width="970px" align="center" cellspacing="1" border="1"> 
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['lagenew']; ?>
</td>
	 <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" 
             onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">
	 <select size=1 name="vnomagen" 
                 onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	         <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['vcodagenew'],'output' => $this->_tpl_vars['vnomagenew']), $this);?>

	 </select>
     </td></tr>        
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltranew']; ?>
</td>
	 <td class="der-color"><input size="75" type="text" name="vtranew"  
             onchange="this.value=this.value.toUpperCase()">
     </td></tr>      
     <tr><td class="izq-color"><?php echo $this->_tpl_vars['lcomenta']; ?>
</td>
	 <td class="der-color"><textarea rows="2" name="vcomenta" cols="76"></textarea>
     </td></tr> 
     </table>
     <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'>
     <input type="hidden" name="vderh" value='<?php echo $this->_tpl_vars['vderh']; ?>
'>  
     <input type="hidden" name="vregh" value='<?php echo $this->_tpl_vars['registro1'];  echo $this->_tpl_vars['registro2']; ?>
'>
     <br>
     
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
     
     <table width="240">
     <tr>
<!--        <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['solicitud1']; ?>
&vsol2=<?php echo $this->_tpl_vars['solicitud2']; ?>
&vreg1=<?php echo $this->_tpl_vars['registro1']; ?>
&vreg2=<?php echo $this->_tpl_vars['registro2']; ?>
"><input type="image" src="../imagenes/folder_f2.png"></a>Cronologia</td> -->
     <td class="cnt"><input type="image" src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
     <td class="cnt"><a href="m_amcamdomv.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
     <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
     </table>

    </form>
  </div>  
  </body>
</html>

