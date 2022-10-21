<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forgenbol" action="m_lnegarlit.php" method="POST">
  <div align="center">

 <table>
  <tr>
    <!-- <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo5} <input type="text" name="desdet" value='{$desdet}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.forgenbol.desdet)" onChange="valFecha(this,document.forgenbol.desdet)"> 
	     {$campo6} <input type="text" name="hastat" value='{$hastat}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.forgenbol.hastat)" onChange="valFecha(this,document.forgenbol.hastat)">
    </tr> -->
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
    <!-- <tr>
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
    </tr> -->   
   
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='boletin' size="3" maxlength="3"  onkeyup="checkLength(event,this,3,document.forgenbol.b1)">
      </td>
    </tr>
  </table></center>
  <p></p>

  <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar" name="b1">  Buscar  </td>
      <td class="cnt"><a href="m_rpnegarlit.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

  </div>  
</form>

</body>
</html>
