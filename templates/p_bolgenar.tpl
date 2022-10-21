<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3> -->
  
  <div align="center">
  <br><br>
    <form name="forpatentes1">
      <table>
        <tr><td class="izq-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpatentes1.vsol2)"
		onchange="Rellena(document.forpatentes1.vsol1,4);document.forpatentes2.vsoli1.value=this.value;">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forpatentes1.vsol3)" onchange="Rellena(document.forpatentes1.vsol2,6);document.forpatentes2.vsoli2.value=this.value;">
		hasta:
                <input type="text" name="vsol3" size="3" maxlength="4" 
	        value='{$solicitud3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpatentes1.vsol4)" onchange="Rellena(document.forpatentes1.vsol3,4);document.forpatentes2.vsoli3.value=this.value;">-
		                  <input type="text" name="vsol4" size="6" maxlength="6" 
		value='{$solicitud4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forpatentes2.vbol)" onchange="Rellena(document.forpatentes1.vsol4,6);document.forpatentes2.vsoli4.value=this.value;"><td><tr>
	</form>
	<form name="forpatentes2" action="p_bolgenar.php?vopc=3" method="post">
	<input type="hidden" name="vsoli1">
	<input type="hidden" name="vsoli2">
	<input type="hidden" name="vsoli3">
	<input type="hidden" name="vsoli4">
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forpatentes2.vtip)" >
           <select size="1" name="aplica" >
             {html_options values=$apli_inf selected=$aplica output=$apli_def}
           </select> 
	        	
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="vtip">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
     <br><br>
     <table width="210">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Guardar"></td> 
        <td class="cnt"><a href="p_bolgenar.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
     <br><br><br><br><br><br><br><br><br>          
    </form>
  </div>  
  </body>
</html>


