<?php /* Smarty version 2.6.8, created on 2020-10-20 11:41:53
         compiled from a_ingresol1.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

&nbsp;
&nbsp;
&nbsp;
&nbsp;

<form name="wingresol" id="w_grabar" action="a_ingresol.php?vopc=6" method="post">

  <TABLE WIDTH=70% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0 align='center'>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. TR&Aacute;MITE:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vtramt']; ?>
</br>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. REFERENCIA:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vsol']; ?>
</br>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Titulo de la Obra:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vnsolsipi']; ?>
</br>

  <?php if (( file ( $this->_tpl_vars['nameimage'] ) )): ?>
      <td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #C6DEF2'>
         <a href='<?php echo $this->_tpl_vars['nameimage']; ?>
' target='_blank'><img border='0' src=<?php echo $this->_tpl_vars['nameimage']; ?>
 width='150' height='150'>
      </td></a>"; 
  <?php endif; ?>

  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Tipo de Obra:</b>
      </td><td></br><font face='Arial' size='4'>
      <?php echo $this->_tpl_vars['vntipobra']; ?>
</br>
  </font></br></td></tr>
  <tr><td class='izq-color'><b>N&uacute;mero de FACTURA Pago de Tasa:</b>
     </td><td>F<input type='text' size='5' name='vfact' maxlength='7' value='<?php echo $this->_tpl_vars['vfact']; ?>
' onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<7;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000 (n&uacute;mero)</font>
  </td></tr>
  </table>

 </strong>
 </fieldset>
 </td></tr>
</table>
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<!-- <form name="wingresol" id="w_grabar" action="a_ingresol.php?vopc=6" method="post"> -->
<input type ='hidden' name='vtramt' value=<?php echo $this->_tpl_vars['vtramt']; ?>
> 
<input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
> 
<input type ='hidden' name='vpedpod' value=<?php echo $this->_tpl_vars['vpedirpoder']; ?>
> 
<!-- <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr><td>
  <fieldset>
  <legend align='center'>
  <strong>Causales de Devoluci&oacute;n</strong>
  </legend>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr><td><input type="checkbox" name="causa1"></td><td><img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['descausa'][0]; ?>
</td></tr>
	<tr><td><input type="checkbox" name="causa2"></td><td><img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['descausa'][1]; ?>
</td></tr>
	<tr><td><input type="checkbox" name="causa3"></td><td><img src="../imagenes/bullet_red.png">&nbsp;<?php echo $this->_tpl_vars['descausa'][2]; ?>
</td></tr>
<?php if ($this->_tpl_vars['descausa'][3] != ''): ?><tr><td><input type="checkbox" name="causa4"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][3]; ?>
</td></tr><?php endif;  if ($this->_tpl_vars['descausa'][4] != ''): ?><tr><td><input type="checkbox" name="causa5"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][4]; ?>
</td></tr><?php endif;  if ($this->_tpl_vars['descausa'][5] != ''): ?><tr><td><input type="checkbox" name="causa6"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][5]; ?>
</td></tr><?php endif;  if ($this->_tpl_vars['descausa'][6] != ''): ?><tr><td><input type="checkbox" name="causa7"></td><td><img src="../imagenes/bullet_red.png"><?php echo $this->_tpl_vars['descausa'][6]; ?>
</td></tr><?php endif; ?>
	<tr><td>Otro:</td><td><input size="120" type="text" name="otro"></td></tr>
 </table>  
 </strong>
 </fieldset>
 </td></tr>
</table> -->
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<table width="30%" align="center">
    <tr align="center">
      <td width="50%" align="center">
       <input type ='hidden' name='vaccion' value='0'>
<!--      <?php if ($this->_tpl_vars['vopc'] == 4): ?> -->
	  <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save" border="0" onclick="document.wingresol.vaccion.value='1'">
      </td><td width="50%" align="center">
<!--	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save2" border="0" onclick="document.wingresol.vaccion.value='2'"> 
     <?php else: ?>
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar y Aprobar Examen de Forma </a>  
      <?php endif; ?> -->
</form>
<!--      </td><td>&nbsp;</td> -->
      <!-- <td width="30%" align="center">
	 <a href="z_solmarweb.php?vopc=4&vreftra=<?php echo $this->_tpl_vars['vtramt']; ?>
&vrefsol=<?php echo $this->_tpl_vars['vsol']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/note_f2.png',1);">
	 <img src="../imagenes/note_f2.png" alt="Cancel" align="center" name="cancel" border="0" /></a>
      </td><td>&nbsp;</td>       
  &nbsp;&nbsp;    
      <td width="10%" align="center"> -->
 	 <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/salir_f2.png',1);">
	 <img src="../imagenes/salir_f2.png" alt="Salir" align="center" name="salir" border="0" /></a>    
      </td>
    </tr>
    <tr align="center"><td width="50%" align="center">Ingresar Solicitud</td><td width="50%" align="center">Salir</td>
    </tr>
</table>
&nbsp;
&nbsp;&nbsp;
&nbsp;
</body>
</html>

<!--

-->
