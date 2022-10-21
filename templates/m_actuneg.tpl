<html>
<head>
   <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<!-- <H3>{$subtitulo}</H3> -->
  
<div align="center">
<form name="formarcas" action="m_actuneg.php?vopc=1" method="post">
  
   <table>
   <tr>
     <tr>
      <td class="izq-color">{$campo1}</td>
	   <td class="der-color">
	      <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas.vsol2)" 
		    onchange="Rellena(document.formarcas.vsol1,2);document.formarcas.vsoli1.value=this.value;">-
		   <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas.vsol3)" 
		    onchange="Rellena(document.formarcas.vsol2,6);document.formarcas.vsoli2.value=this.value;">
		hasta:
         <input type="text" name="vsol3" size="3" maxlength="4" value='{$vsol3}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas.vsol4)" 
          onchange="Rellena(document.formarcas.vsol3,2);document.formarcas.vsoli3.value=this.value;">-
		   <input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas.articulo)" 
		    onchange="Rellena(document.formarcas.vsol4,6);document.formarcas.vsoli4.value=this.value;">
		<td>
	  </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
	     <input type="text" name="articulo" size="4" maxlength="4" value='{$articulo}'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color" >
	     <input type="text" name="literal" size="4" maxlength="4" value='{$literal}'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
	     <input type="text" name="boletin" size="4" maxlength="4" value='{$boletin}'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color" >
        <input type='text' name='fechabol' value='{$fechabol|date_format:"%d/%m/%G"}' size='10' onChange="valFecha(document.formarcas.fechabol)">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color" >
	     <input type="text" name="tomo" size="6" maxlength="6" value='{$tomo}'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color" >
	     <input type="text" name="pagina" size="6" maxlength="6" value='{$pagina}'>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo8}</td>
      <td class="der-color" >
	     <input type="text" name="resolucion" size="6" maxlength="6" value='{$resolucion}'>
      </td>
    </tr>
   </tr>
   </table>
   &nbsp;
   <table width="225">
   <tr>
     <tr>
      <!-- <td class="cnt"><input type="submit" name="grabar" value="Grabar"></td> 
  	   <td class="cnt"><input type="reset" name="cancelar" value="Cancelar"
	       onclick="location.href='m_actuneg.php'"></td>
	   <td class="cnt"><input type="button" name="salir" value="Salir"
	       onclick="location.href='index1.php'"></td> -->
      <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td>
      <td class="cnt"><a href="m_actuneg.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
     </tr>
   </tr>
   </table>
</form>

</div>  
</body>
</html>
