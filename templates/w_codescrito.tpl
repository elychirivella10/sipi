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

<form name="wcodescrito1" id="w_grabar" action="w_codescrito1.php?vopc=6" method="post">

  <TABLE WIDTH=70% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0 align='center'>
  <tr><td class='izq-color'><b>N&uacute;mero de Solicitud:</b>
     </td><td><input type='text' size='10' name='vsol' maxlength='4' value='{$vsol}' readonly="readonly">
  </td></tr>
  <tr><td class='izq-color'><b>N&uacute;mero de C&oacute;digo Control:</b>
     </td><td><input type='text' size='6' name='vcode' maxlength='7' value='{$vcode}' onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<7;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000 (n&uacute;mero)</font>
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
<input type ='hidden' name='vtramt' value={$vtramt}> 
<input type ='hidden' name='vsol' value={$vsol}> 
<input type ='hidden' name='vtipe' value={$vtipe}> 
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<table width="30%" align="center">
    <tr align="center">
      <td width="50%" align="center">
       <input type ='hidden' name='vaccion' value='0'>
	  <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save" border="0" onclick="document.wcodescrito1.vaccion.value='1'">
      </td><td width="50%" align="center">
</form>
 	 <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/salir_f2.png',1);">
	 <img src="../imagenes/salir_f2.png" alt="Salir" align="center" name="salir" border="0" /></a>    
      </td>
    </tr>
    <tr align="center"><td width="50%" align="center">Ingresar Escrito</td><td width="50%" align="center">Salir</td>
    </tr>
</table>
&nbsp;
&nbsp;&nbsp;
&nbsp;
</body>
</html>
