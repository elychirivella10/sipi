<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <br><br>
  <div align="center">
    <form name="formarcas1">
      <table cellspacing="1" border="1">
        <tr><td class="izq-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)"
		onchange="Rellena(document.formarcas1.vsol1,4);document.formarcas2.vsoli1.value=this.value;">-<input type="text" name="vsol2" size="6" maxlength="6" 
		onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.vsol3)" onchange="Rellena(document.formarcas1.vsol2,6);document.formarcas2.vsoli2.value=this.value;">hasta:<input type="text" name="vsol3" size="3" maxlength="4" 
	        onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol4)" onchange="Rellena(document.formarcas1.vsol3,4);document.formarcas2.vsoli3.value=this.value;">-<input type="text" name="vsol4" size="6" maxlength="6" 
		onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vcodeve)" onchange="Rellena(document.formarcas1.vsol4,6);document.formarcas2.vsoli4.value=this.value;"></td></tr>
	</form>
	<form name="formarcas2" action="m_reversoe.php?vopc=3" method="post" onsubmit=pregunta2()>
	<input type="hidden" name="vsoli1">
	<input type="hidden" name="vsoli2">
	<input type="hidden" name="vsoli3">
	<input type="hidden" name="vsoli4">
	<tr><td class="izq-color">{$levento}</td>
	    <td class="der-color"><input type="text" name="vcodeve" size="2" maxlength="3" 
	        value='{$vcodeve}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vfeceve)" onchange="valagente(document.formarcas2.vcodeve,document.formarcas2.vnomeve)">
	        <select size='1' name='vnomeve' onchange="valagente(document.formarcas2.vnomeve,document.formarcas2.vcodeve)">
                  {html_options values=$arraycodeve selected=$vcodeve output=$arraynomeve}
                </select></td></tr>
	<tr><td class="izq-color">{$lfechaevento}</td>
	    <td class="der-color"><input size="10" type="text" name="vfeceve" value='{$vfeceve}'  onkeyup="checkLength(event,this,10,document.formarcas2.vcodest)"
	    onchange="valFecha(this,document.formarcas2.vcodest)"><td>	
	<tr><td class="izq-color">{$lestatus}</td>
	    <td class="der-color"><input type="text" name="vcodest" size="2" maxlength="3" 
	        value='{$vcodest}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vbol)" onchange="valagente(document.formarcas2.vcodest,document.formarcas2.vnomest)">
	        <select size='1' name='vnomest' onchange="valagente(document.formarcas2.vnomest,document.formarcas2.vcodest)">
                  {html_options values=$arraycodest selected=$vcodest output=$arraynomest}
                </select></td></tr>
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="4" maxlength="6" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.procesar)" ></td></tr>
		
    </table>
     <br>
     <table width="210">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="m_reversoe.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br>
  </div>  
  </body>
</html>


