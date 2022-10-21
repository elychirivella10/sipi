<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forcaduca" action="m_peren588_837.php?vopc=2" method="POST">
  <div align="center">
  <br>
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" value='{$boletin}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forcaduca.actualizar)">
      </td>
    </tr>   
  </table></center>
	<br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="actualizar" src="../imagenes/boton_procesar_azul.png" value="Actualizar"></td>
      <td class="cnt"><a href="m_peren588_837.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div> 
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> 
</form>

</body>
</html>
