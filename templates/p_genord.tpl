<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <title>{$titulo}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
  </head>
  <body onLoad="this.document.{$varfocus}.focus()">
  <!-- <H3>{$subtitulo}</H3> -->

    <form name="formarcas1">
      <div align="center">
      <input type='hidden' name='nconex' value='{$n_conex}'>
      <table>
        <tr><td class="izq-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$solicitud1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)"
		onchange="Rellena(document.formarcas1.vsol1,2);document.formarcas2.vsoli1.value=this.value;">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.vsol3)" onchange="Rellena(document.formarcas1.vsol2,6);document.formarcas2.vsoli2.value=this.value;">
		hasta:
                <input type="text" name="vsol3" size="4" maxlength="4" 
	        value='{$solicitud3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol4)" onchange="Rellena(document.formarcas1.vsol3,2);document.formarcas2.vsoli3.value=this.value;">-
		                  <input type="text" name="vsol4" size="6" maxlength="6" 
		value='{$solicitud4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vbol)" onchange="Rellena(document.formarcas1.vsol4,6);document.formarcas2.vsoli4.value=this.value;"><td><tr>
	</form>
	<form name="formarcas2" action="p_genord.php?vopc=3" method="post">
	<input type="hidden" name="vsoli1">
	<input type="hidden" name="vsoli2">
	<input type="hidden" name="vsoli3">
	<input type="hidden" name="vsoli4">
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vtip)" >	
	
    </table>
     &nbsp;
     <table width="225">
       <tr>

        <td class="cnt"><input type="image" src="../imagenes/newspaper_add.png" value="Generar">  Generar  </td>
        <td class="cnt"><a href="p_genord.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
        <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
       </tr>
     </table>
    </form>
  </div>  
  </body>
</html>
