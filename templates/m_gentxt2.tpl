<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forgenbol" action="m_gentxt2.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

 <table>
  <tr>

    <tr>
      <td class="izq-color" >{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$solicitud1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forgenbol.vsol2)"
		onchange="Rellena(document.forgenbol.vsol1,4);document.forgenbol.vsoli1.value=this.value;">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forgenbol.vsol3)" onchange="Rellena(document.forgenbol.vsol2,6);document.forgenbol.vsoli2.value=this.value;">
		hasta:
                <input type="text" name="vsol3" size="4" maxlength="4" 
	        value='{$solicitud3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forgenbol.vsol4)" onchange="Rellena(document.forgenbol.vsol3,4);document.forgenbol.vsoli3.value=this.value;">-
		                  <input type="text" name="vsol4" size="6" maxlength="6" 
		value='{$solicitud4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forgenbol.articulo)" onchange="Rellena(document.forgenbol.vsol4,6);document.forgenbol.vsoli4.value=this.value;">
    <td></tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name='articulo' size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forgenbol.literal)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name='literal' size="2" maxlength="2"  onkeyup="checkLength(event,this,2,document.forgenbol.boletin)">
      </td>
    </tr> 
   
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='boletin' size="3" maxlength="3"  onkeyup="checkLength(event,this,3,document.forgenbol.b1)">
      </td>
    </tr>
  </table><!--</font>--></center>
	<p></p>
     <!-- <input type="submit" value="Buscar" name="B1">
     <input type="reset" value="Cancelar" name="cancelar" OnClick="location.href='m_pgentxt.php';">
	  <input type="button" value="Salir" OnClick="location.href='index1.php';"> -->

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/newspaper_add.png" value="Buscar" name="b1">  Generar  </td>
      <td class="cnt"><a href="m_pgentxt.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

  </div>  
</form>

</body>
</html>
