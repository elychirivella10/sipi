<?php /* Smarty version 2.6.8, created on 2020-10-20 10:10:44
         compiled from m_apoderes.tpl */ ?>
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
    <form name="formarcas1" action="m_apoderes.php?vopc=1" method="post">
      <input type="hidden" name="vaccion" value='<?php echo $this->_tpl_vars['vaccion']; ?>
'>
      <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $this->_tpl_vars['vsol1']; ?>
' <?php echo $this->_tpl_vars['vmodo2']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
                onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="3" maxlength="4" 
		value='<?php echo $this->_tpl_vars['vsol2']; ?>
' <?php echo $this->_tpl_vars['vmodo2']; ?>
 onKeyPress="return acceptChar(event,2, this)" 
                onkeyup="checkLength(event,this,4,document.formarcas1.submit)" 
                onchange="Rellena(document.formarcas1.vsol2,4)">
		                  <input type=<?php echo $this->_tpl_vars['submitbutton']; ?>
 name='submit' class='boton_blue' value=<?php echo $this->_tpl_vars['vaccion']; ?>
></td>
      </table>
    </form>				  
    <form name="formarcas3" action="m_apoderes.php?vopc=5&vsol=<?php echo $this->_tpl_vars['vsol']; ?>
" method="post">
      <input type="hidden" name="vsol1" value='<?php echo $this->_tpl_vars['vsol1']; ?>
'>
      <input type="hidden" name="vsol2" value='<?php echo $this->_tpl_vars['vsol2']; ?>
'>
      <input type="hidden" name="vaccion" value='<?php echo $this->_tpl_vars['vaccion']; ?>
'>
      <!-- Fecha y Facultad --> 
      <table width="80%">	
          <tr><td width="25%" class="izq5-color"><?php echo $this->_tpl_vars['lfechapoder']; ?>
</td>
	  <td width="25%" class="der-color">
          <input size="9" type="text" name="vfecp" value='<?php echo $this->_tpl_vars['vfecp']; ?>
' 
              onkeyup="checkLength(event,this,10,document.formarcas3.vfac)"
	      onchange="valFecha(this,document.formarcas3.vfac)" <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
	  <td width="14%" class="izq5-color"><?php echo $this->_tpl_vars['lfacultad']; ?>
</td>
	  <td width="36%" class="der-color">
          <input size="1" type="text" name="vfac" value='<?php echo $this->_tpl_vars['vfac']; ?>
' maxlength="1"
	      onkeyup="javascript:this.value=this.value.toUpperCase(); valfacultad(this); checkLength(event,this,1,document.formarcas3.vtitut)" <?php echo $this->_tpl_vars['vmodo']; ?>
><?php echo $this->_tpl_vars['lfacultad2']; ?>
</td></tr>
      </table>	
      &nbsp; 
      <!-- Titulares --> 
      <table width="80%" cellspacing="1" border="1">
      <tr><td class="izq4-color"><?php echo $this->_tpl_vars['ltitular']; ?>
</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='exampletit.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
'></iframe> 
      </td></tr>  
      <!-- -->
      <?php if ($this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['vaccion'] == 'Actualizar'): ?>   
      <tr><td class="der-color">
      <input type="text" name="vtitut" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" 
             onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" value="Buscar/Incluir" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vtitui" 
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
      <input type="button" value="Buscar/Eliminar" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vtitue"          
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
      <?php endif; ?>
      </td></tr>	
      </table>	
      &nbsp;  
      <!-- Poder Habientes --> 
      <table width="80%" cellspacing="1" border="1">
      <tr><td class="izq4-color"><?php echo $this->_tpl_vars['lpoderhabi']; ?>
</td></tr>
      <tr><td class="izq2-color">
      <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
              src='examplepoh.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
'></iframe> 
      </td></tr>  
      <!-- --> 
      <?php if ($this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['vaccion'] == 'Actualizar'): ?>   
      <tr><td class="der-color">
      <input type="text" name="vpodet" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" 
          onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" value="Buscar/Incluir" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vpodei" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodei)">
      <input type="button" value="Buscar/Eliminar" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vpodee" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodee)"> 
      <?php endif; ?>
      </td></tr>	
      </table>
      &nbsp;
      <table width="80%">	
          <tr><td width="25%" class="izq5-color">Observación:</td>
	         <td width="75%" class="der-color"><input size="150" type="text" maxlength='512' name="vobs" value='<?php echo $this->_tpl_vars['vobs']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
	     </tr>
      </table>	
      &nbsp;
      <table width="225">
        <tr>
        <?php if ($this->_tpl_vars['vopc'] == 1 && $this->_tpl_vars['vaccion'] == 'Actualizar'): ?>  
        <td class="cnt"><input type="image" name="accion" src="../imagenes/boton_guardar_azul.png" value="Guardar"></td>
        <td class="cnt">
           <a href="m_apoderes.php?vopc=13"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
        </td> 
        <?php endif; ?>
        <?php if ($this->_tpl_vars['vopc'] != 1): ?>   
        <td class="cnt">
          <a href="m_apoderes.php?vopc=<?php echo $this->_tpl_vars['vopc']; ?>
"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
        </td>
        <?php endif; ?>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
     </table>
    </form>
  </div>  
  </body>
</html>

