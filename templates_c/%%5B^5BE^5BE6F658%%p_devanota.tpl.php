<?php /* Smarty version 2.6.8, created on 2020-11-09 09:57:24
         compiled from p_devanota.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'p_devanota.tpl', 38, false),)), $this); ?>
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
    <form name="formarcas1" action="p_devanota.php?vopc=1" method="post">
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
	    <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">   Buscar  </td></p>
        </tr>
      </table>
    </form>			  
    <form name="formarcas2" action="p_devanota.php?vopc=3" method="post" onsubmit='return pregunta();'>
      <input type="hidden" name="vsolh" value='<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
'>
      <input type="hidden" name="vder" value='<?php echo $this->_tpl_vars['vder']; ?>
'>
      
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
	 <td class="der-color"><input size="9" type="text" name="vfechr" value='<?php echo $this->_tpl_vars['vfechr']; ?>
'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td>
       <td class="izq5-color"><?php echo $this->_tpl_vars['lnumtra']; ?>
</td>
	    <td class="der-color">
           <input type="text" name="vnumtram" size="9" maxlength="9" value='<?php echo $this->_tpl_vars['vnumtram']; ?>
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
	    <td class="der-color"><input size="85" type="text" name="vnom" value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>   </td>
	</tr>
	<tr><td class="izq-color"><?php echo $this->_tpl_vars['lctipop']; ?>
</td>
	   <td class="der-color">
	     <input size="30" type="text" name="vtipo" value='<?php echo $this->_tpl_vars['lctipo']; ?>
 - <?php echo $this->_tpl_vars['tipopaten']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
>
           </td>
        </tr>
	<tr>
         <td class="izq-color" ><?php echo $this->_tpl_vars['lestatus']; ?>
</td>
         <td class="der-color">
           <input size="80" name="vmod" '<?php echo $this->_tpl_vars['vmodo']; ?>
' value='<?php echo $this->_tpl_vars['vest']; ?>
 - <?php echo $this->_tpl_vars['vdest']; ?>
'>
         </td>
        </tr>
	<tr>
         <td class="izq-color" ><?php echo $this->_tpl_vars['ltramage']; ?>
</td>
         <td class="der-color">
           <input size="80" name="vtragen" '<?php echo $this->_tpl_vars['vmodo']; ?>
' value='<?php echo $this->_tpl_vars['vtragen']; ?>
'>
         </td>
        </tr>
      </table>
      <?php if ($this->_tpl_vars['vopc'] != 0): ?>
      <H3><?php echo $this->_tpl_vars['lcausadev']; ?>
</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['uno']; ?>
</td><td class="der-color"><input type="checkbox" name="causa1"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['luno']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dos']; ?>
</td><td class="der-color"><input type="checkbox" name="causa2"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldos']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['tres']; ?>
</td><td class="der-color"><input type="checkbox" name="causa3"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ltres']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['cuatro']; ?>
</td><td class="der-color"><input type="checkbox" name="causa4"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcuatro']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['cinco']; ?>
</td><td class="der-color"><input type="checkbox" name="causa5"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcinco']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['seis']; ?>
</td><td class="der-color"><input type="checkbox" name="causa6"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lseis']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['siete']; ?>
</td><td class="der-color"><input type="checkbox" name="causa7"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lsiete']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['ocho']; ?>
</td><td class="der-color"><input type="checkbox" name="causa8"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['locho']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['nueve']; ?>
</td><td class="der-color"><input type="checkbox" name="causa9"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lnueve']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['diez']; ?>
</td><td class="der-color"><input type="checkbox" name="causa10"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiez']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['once']; ?>
</td><td class="der-color"><input type="checkbox" name="causa11"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lonce']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['doce']; ?>
</td><td class="der-color"><input type="checkbox" name="causa12"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldoce']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['trece']; ?>
</td><td class="der-color"><input type="checkbox" name="causa13"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ltrece']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['catorce']; ?>
</td><td class="der-color"><input type="checkbox" name="causa14"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcatorce']; ?>
</td></tr><tr>
	 <?php if ($this->_tpl_vars['lquince'] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['quince']; ?>
</td><td class="der-color"><input type="checkbox" name="causa15"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lquince']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dieciseis']; ?>
</td><td class="der-color"><input type="checkbox" name="causa16" <?php echo $this->_tpl_vars['modo']; ?>
 ><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldieciseis']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['diecisiete']; ?>
</td><td class="der-color"><input type="checkbox" name="causa17" <?php echo $this->_tpl_vars['modo']; ?>
 ><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiecisiete']; ?>
</td> 
	 <td class="izq-color"><?php echo $this->_tpl_vars['dieciocho']; ?>
</td><td class="der-color"><input type="checkbox" name="causa18" disabled ><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldieciocho']; ?>
</td></tr><tr> 
	 <td class="izq-color"><?php echo $this->_tpl_vars['diecinueve']; ?>
</td><td class="der-color"><input type="checkbox" name="causa19" disabled ><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiecinueve']; ?>
</td> 
	 <td class="izq-color"><?php echo $this->_tpl_vars['veinte']; ?>
</td><td class="der-color"><input type="checkbox" name="causa20" disabled ><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lveinte']; ?>
</td></tr><tr>  
	 <!-- <td class="izq-color"><?php echo $this->_tpl_vars['veintiuno']; ?>
</td><td class="der-color"><input type="checkbox" name="causa21" <?php echo $this->_tpl_vars['modo']; ?>
 ><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lveintiuno']; ?>
</td> --> 

	 <?php endif; ?>
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['lotro']; ?>
</td><td class="der-color"><input size="90" type="text" name="otro" maxlength="500"><td>
	</tr>
	</table>
     </table>
     <?php endif; ?>
     &nbsp;

    <table width="315">
    <tr>
      <td class="der">
      <td class="cnt"><a href="p_rptcronol.php?vsol=<?php echo $this->_tpl_vars['solicitud1']; ?>
-<?php echo $this->_tpl_vars['solicitud2']; ?>
">
      <input type="image" src="../imagenes/folder_f2.png"></a>	 Cronologia 	</td> 
      <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar">	Guardar 	</td> 
      <td class="cnt"><a href="p_devanota.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar 	</td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir 	</td>
      </td>
    </tr>
    </table></center>

    </form>
  </div>  
  </body>
</html>
