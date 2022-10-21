<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="a_elisolda.php?vopc=1" method="post">
  <table>
        <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol" size="6" maxlength="6" 
	        value='{$vsol}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.vplan)" onchange="Rellena(document.formarcas1.vsol,6)">
       &nbsp;</td>
	    <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

</form>				  

  </table>
  &nbsp; 
  <table cellspacing="0">	
  <tr>   
    <tr>
      <td class="izq-color">{$campo2}</td>
	   <td class="der-color"><input size="9" type="text" name="vplan" value='{$vplan}' {$modo}></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
	   <td class="der-color"><input size="9" type="text" name="vfec" value='{$vfec}' {$modo}></td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo5}</td>
	   <td class="der-color"><input size="72" type="text" name="vnom" value='{$vnom}' {$modo}></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='{$vtipo}' {$modo}>-
                            <input size="30" type="text" name="vtip" value='{$vtip}' {$modo}></td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo6}</td>
	   <td class="der-color"><input size="72" type="text" name="vdesc" value='{$vdesc}' {$modo}></td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo8}</td>
	   <td class="der-color"><input size="20" type="text" name="vidioma" value='{$vidioma}' {$modo}></td>
    </tr>

	 <tr>
	   <td class="izq-color">{$campo7}</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$modo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$modo}></td>
    </tr>

	 <tr>
	    <td class="izq-color">{$campo9}</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='{$vcodtit}' {$modo}>
	                <input size="63" type="text" name="vnomtit" value='{$vnomtit}' {$modo}></td>
    </tr>
  </tr>
  </table>		
</form>
&nbsp;     

<form name="formarcas3" action="a_elisolda.php?vopc=3" method="post" onsubmit='return pregunta1();'>
  <input type="hidden" name="vsol" value='{$vsol}'>
  <input type="hidden" name="vest" value='{$vest}'>
  <input type="hidden" name="vder" value='{$vder}'>

  <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_eliminar_rojo.png" value="Eliminar"></td> 
      <td class="cnt"><a href="a_elisolda.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>


