<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

&nbsp;
&nbsp;
&nbsp;
&nbsp;
<form name="wingresol" id="w_grabar" action="w_ingreren.php?vopc=6" method="post">

  <TABLE WIDTH=70% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0 align='center'>
  <!--<tr><td WIDTH=30% class='izq-color'><b>Requisitos M&iacute;nimos Asociados a la Solicitud:</b>
      </td><td></br><font face='Arial' size='4'>
      {if $vdocanexoa=='S'}<input align='center' type="checkbox" name="recaud1" STYLE="display:none">{$vlitanexoa}</br>{/if}
      {if $vdocanexob=='S'}<input align='center' type="checkbox" name="recaud2" STYLE="display:none">{$vlitanexob}</br>{/if} 
      {if $vdocanexoc=='S'}<input align='center' type="checkbox" name="recaud3" STYLE="display:none">{$vlitanexoc}</br>{/if}
      {if $vdocanexof=='S'}<input align='center' type="checkbox" name="recaud4" STYLE="display:none">{$vlitanexof}</br>{/if}
      {if $vdocanexog=='S'}<input align='center' type="checkbox" name="recaud5" STYLE="display:none">{$vlitanexog}</br>{/if}
      {if $vdocanexoh=='S'}<input align='center' type="checkbox" name="recaud6" STYLE="display:none">{$vlitanexoh}</br>{/if}
      {if $vdocanexoi=='S'}<input align='center' type="checkbox" name="recaud7" STYLE="display:none">{$vlitanexoi}</br>{/if}
  </font></br></td></tr> 
  <tr><td class='izq-color'><b>N&uacute;mero de Solicitud:</b> 
     </td><td><input type='text' size='2' name='vsol1' maxlength='4' value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)"
onkeyup="checkLength(event,this,4,document.wingresol.vsol2);" onchange='for(var x=this.value.length;x<4;x++) this.value=0+this.value;'>-<input type='text' size='3' name='vsol2' maxlength='6' value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.wingresol.vpod1);" onchange='for(var x=this.value.length;x<6;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000-000000 (a??o-n&uacute;mero)</font>
  </td></tr>
{if $vpedirpoder=='S'}
  <tr><td class='izq-color'><b>N&uacute;mero de Poder:</b>
     </td><td><input type='text' size='2' name='vpod1' maxlength='4' value='{$vpod1}' onkeyup="checkLength(event,this,4,document.wingresol.vpod2);" onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<4;x++) this.value=0+this.value;'>-<input type='text' size='2' name='vpod2' maxlength='4' value='{$vpod2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.wingresol.vfact);" onchange='for(var x=this.value.length;x<4;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000-0000 (a??o-n&uacute;mero)</font>
  </td></tr>
{/if} -->
  <tr><td class='izq-color'><b>N&uacute;mero de Factura Pago de Tasa:</b>
     </td><td>F<input type='text' size='5' name='vfact' maxlength='7' value='{$vfact}' onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<7;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000 (n&uacute;mero)</font>
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
<!-- <form name="wingresol" id="w_grabar" action="w_ingresol.php?vopc=6" method="post"> -->
<input type ='hidden' name='vtramt' value={$vtramt}> 
<input type ='hidden' name='vsol' value={$vsol}> 
<input type ='hidden' name='vpedpod' value={$vpedirpoder}> 
<!-- <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr><td>
  <fieldset>
  <legend align='center'>
  <strong>Causales de Devoluci&oacute;n</strong>
  </legend>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr><td><input type="checkbox" name="causa1"></td><td><img src="../imagenes/bullet_red.png">&nbsp;{$descausa[0]}</td></tr>
	<tr><td><input type="checkbox" name="causa2"></td><td><img src="../imagenes/bullet_red.png">&nbsp;{$descausa[1]}</td></tr>
	<tr><td><input type="checkbox" name="causa3"></td><td><img src="../imagenes/bullet_red.png">&nbsp;{$descausa[2]}</td></tr>
{if $descausa[3] neq ''}<tr><td><input type="checkbox" name="causa4"></td><td><img src="../imagenes/bullet_red.png">{$descausa[3]}</td></tr>{/if}
{if $descausa[4] neq ''}<tr><td><input type="checkbox" name="causa5"></td><td><img src="../imagenes/bullet_red.png">{$descausa[4]}</td></tr>{/if}
{if $descausa[5] neq ''}<tr><td><input type="checkbox" name="causa6"></td><td><img src="../imagenes/bullet_red.png">{$descausa[5]}</td></tr>{/if}
{if $descausa[6] neq ''}<tr><td><input type="checkbox" name="causa7"></td><td><img src="../imagenes/bullet_red.png">{$descausa[6]}</td></tr>{/if}
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
<!--      {if $vopc eq 4} -->
	  <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save" border="0" onclick="document.wingresol.vaccion.value='1'">
      </td><td width="50%" align="center">
<!--	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save2" border="0" onclick="document.wingresol.vaccion.value='2'"> 
     {else}
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar y Aprobar Examen de Forma </a>  
      {/if} -->
</form>
<!--      </td><td>&nbsp;</td> -->
      <!-- <td width="30%" align="center">
	 <a href="z_solmarweb.php?vopc=4&vreftra={$vtramt}&vrefsol={$vsol}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/note_f2.png',1);">
	 <img src="../imagenes/note_f2.png" alt="Cancel" align="center" name="cancel" border="0" /></a>
      </td><td>&nbsp;</td>       
  &nbsp;&nbsp;    
      <td width="10%" align="center"> -->
 	 <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/salir_f2.png',1);">
	 <img src="../imagenes/salir_f2.png" alt="Salir" align="center" name="salir" border="0" /></a>    
      </td>
    </tr>
    <tr align="center"><td width="50%" align="center">Ingresar Renovacion</td><td width="50%" align="center">Salir</td>
    </tr>
</table>
&nbsp;
&nbsp;&nbsp;
&nbsp;
</body>
</html>

<!--

-->

