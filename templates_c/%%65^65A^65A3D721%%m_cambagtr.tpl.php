<?php /* Smarty version 2.6.8, created on 2020-12-09 10:00:27
         compiled from m_cambagtr.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip', 'm_cambagtr.tpl', 46, false),)), $this); ?>
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
    <form name="formarcas1" action="m_cambagtr.php?vopc=1" method="post">
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
      </table>
      &nbsp; 
      <table width="95%" cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfecsol']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecsol" value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td>
	    <?php if ($this->_tpl_vars['vmod'] == 'G' || $this->_tpl_vars['vmod'] == 'M'): ?>
        <td class="der-color" rowspan="4" align="left" valign="top">
          <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target="_blank">
          <img border="-1" src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width="110">
        </td>
      <?php endif; ?></tr>
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
	    <td colspan="2" class="der-color"><input size="2" type="text" name="vest" value='<?php echo $this->_tpl_vars['vest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $this->_tpl_vars['vdesest']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
        
	<tr><td class="izq-color">Tramitante Actual:</td>
	    <td colspan="2" class="der-color"><input size="72" type="text" name="vtrage" 
                value="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtra'])) ? $this->_run_mod_handler('strip', true, $_tmp) : smarty_modifier_strip($_tmp)); ?>
" <?php echo $this->_tpl_vars['vmodo']; ?>
></td></tr>
      <tr><td class="izq-color">Agente(s) Actual(es):</td>
          <td class="izq2-color">
      <iframe id='center' style='width:100%;height:80px;background-color: WHITE;' 
              src='exampleage.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
&ptip=I&ptip2=M'></iframe> 
      </td></tr>
     </table>   
     </form>
     <form name="formarcas3" action="m_cambagtr.php?vopc=3" method="post" onsubmit='return pregunta();'>
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
     <table width="95%" cellspacing="1" border="1">
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechaevento']; ?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfevh"   onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	    onchange="valFecha(this,document.formarcas3.vdoc)"><td>  </tr>
	    <tr><td class="izq-color"><?php echo $this->_tpl_vars['ldocumento']; ?>
</td>
	    <td class="der-color"><input size="8" type="text" name="vdoc" value='<?php echo $this->_tpl_vars['vdoc']; ?>
' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,9,document.formarcas3.vcodagen)"></td></tr>
     &nbsp;
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltranew']; ?>
</td>
	    <td class="der-color"><input size="72" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      
        <tr><td class="izq-color" >Agente(s) Nuevo(s):</td>
      <td class="izq2-color">
      <iframe id='center' style='width:100%;height:80px;background-color: WHITE;' 
              src='exampleage.php?psol=<?php echo $this->_tpl_vars['vsol']; ?>
&ptip=M&ptip2=M'></iframe> 
      </td></tr><tr>
      <td class="izq-color"> </td>   
      <td class="der-color">
      <input type="text" name="vpodet" <?php echo $this->_tpl_vars['modo']; ?>
 size="35" 
          onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Buscar/Incluir" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vpodei" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodei)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" <?php echo $this->_tpl_vars['modo2']; ?>
 name="vpodee" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodee)"> 

      </table> 
      &nbsp;

      <legend align='center' class='Estilo3'><strong><span>&nbsp;&nbsp;INGRESE EL DATO DE FACTURACION&nbsp;&nbsp;</span></strong></legend>
      <table cellspacing="1" border="1">
	<tr>
	  <td class="izq-color"><?php echo $this->_tpl_vars['lfactura']; ?>
</td>
	  <td class="der-color">
	    <input size="7" type="text" name="vfactura" maxlength="7">	    
          </td>
	</tr>        
      </table>
      <br>

           <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'> 
           <input type="hidden" name="vregh" value='<?php echo $this->_tpl_vars['registro1'];  echo $this->_tpl_vars['registro2']; ?>
'>
           
     <table width="260">
        <tr> 
<!--   <td class="cnt"><a href="m_cronolo.php?vsol=<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
">  -->
       <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['solicitud1']; ?>
&vsol2=<?php echo $this->_tpl_vars['solicitud2']; ?>
">
        <input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="m_cambagtr.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>
