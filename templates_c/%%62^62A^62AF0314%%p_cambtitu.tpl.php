<?php /* Smarty version 2.6.8, created on 2020-11-03 14:06:41
         compiled from p_cambtitu.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  <div align="center">
    <form name="formarcas1" action="p_cambtitu.php?vopc=1" method="post">
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
	  <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" 
                                   height="24" value="Buscar">  Buscar  </td></tr>
      </table>
    </form>				  
    <form name="formarcas3" action="p_cambtitu.php?vopc=3" method="post" 
          onsubmit='return pregunta();'>
    &nbsp; 
    <table  width="90%" cellspacing="1" border="1">	
    <tr><td width="20%" class="izq-color"><?php echo $this->_tpl_vars['lfecsol']; ?>
</td>
	<td class="der-color"><input size="9" type="text" name="vfecsol" 
            value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td>
	<?php if ($this->_tpl_vars['vmod'] == 'G' || $this->_tpl_vars['vmod'] == 'M'): ?>
        <td class="der-color" rowspan="3" align="left" valign="top">
          <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
          <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="100">
        </td> 
        <?php endif; ?>
    </tr>
    <tr><td class="izq-color"><?php echo $this->_tpl_vars['lnombre']; ?>
</td>
	<td class="der-color">
        <input size="73" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
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
    </table>
    <!-- Titulares Actuales--> 
    <table width="90%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $this->_tpl_vars['ltitular']; ?>
</td></tr>
    <tr><td class="izq2-color">
    <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='exampletit.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
&ptip=I&pder=<?php echo $this->_tpl_vars['vderh']; ?>
'></iframe> 
    </td></tr>  
    </table>		
    &nbsp;
    <input type="hidden" name="vfecven" value='<?php echo $this->_tpl_vars['vfecven']; ?>
'>
    <input type="hidden" name="vmodo" value='Incluir'>
    &nbsp;     
    <table width="90%" cellspacing="1" border="1">	
    <tr>
       <td width="25%" class="izq-color"><?php echo $this->_tpl_vars['lfechaevento']; ?>
</td>
<td class="der-color"><input size="9" type="text" name="vfevh"   onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	   onchange="valFecha(this,document.formarcas3.vdoc)"></td>
       </tr>
       <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldocumento']; ?>
</td>
	  <td class="der-color"><input size="9" type="text" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,9,document.formarcas3.vtitut)"></td></tr>
      </table>
      <!-- Titulares Finales--> 
      <table width="90%" cellspacing="1" border="1">
      <tr><td class="izq4-color"><?php echo $this->_tpl_vars['ltitular2']; ?>
</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='exampletit.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
&ptip=P'></iframe> 
      </td></tr>  
      </table>
      <!-- -->
      <table width="90%" cellspacing="1" border="1">	
      <tr><td class="der-color">
      <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" 
             onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Buscar/Incluir" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vtitui" 
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vtitue"          
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
      <!--  -->
      </td></tr>	
      </table>
      &nbsp;
      
      <legend align='center' class='Estilo3'><strong><span>&nbsp;&nbsp;INGRESE EL DATO DE FACTURACION&nbsp;&nbsp;</span></strong></legend>
      <table cellspacing="1" border="1">
	    <tr>
	      <td class="izq-color"><?php echo $this->_tpl_vars['lfactura']; ?>
</td>
	      <td class="der-color">
	        <input size="7" type="text" name="vfactura" maxlength="7" <?php echo $this->_tpl_vars['modo2']; ?>
>	    
         </td>
	    </tr>        
      </table>
      <br>
      
      <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['vsolh']; ?>
'>
      <input type="hidden" name="vderh" value='<?php echo $this->_tpl_vars['vderh']; ?>
'>
      <br/ >  
     <table width="225">
        <tr>
<!--        <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['solicitud1']; ?>
&vsol2=<?php echo $this->_tpl_vars['solicitud2']; ?>
&vreg1=<?php echo $this->_tpl_vars['registro1']; ?>
&vreg2=<?php echo $this->_tpl_vars['registro2']; ?>
"><input type="image" src="../imagenes/folder_f2.png"></a>Cronologia</td> -->
        <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td> 
    <td class="cnt"><a href="p_cambtitu.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar </td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

