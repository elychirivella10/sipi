<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas2" action="z_actcanbol600.php?vopc=2" method="POST">
  <div align="center">
  <br><br>
  <br>

  <table>
	<tr>
	  <td class="izq-color">{$lboletin}</td>
	  <td class="der-color"><input type="text" name="boletin" size="3" maxlength="4" 
	        onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.actualizar)" >	
     <td>
   </tr>
  </table>
  <br><br>
  
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="actualizar" src="../imagenes/boton_procesar_azul.png" value="Actualizar"></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>
