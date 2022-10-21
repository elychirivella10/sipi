<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forofcfor" action="a_genoficio.php?vopc=2" method="POST" onsubmit='return pregunta();'>
 <div align="center">
 <br>
 <table width='25%'>
   <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="6" maxlength="6" onkeyup="checkLength(event,this,6,document.forofcfor.vsol2)" onchange="Rellena(document.forofcfor.vsol1,6)"  >
       </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="vsol2" align="right" size="6" maxlength="6"  onkeyup="checkLength(event,this,6,document.forofcfor.vsol2h)" onchange="Rellena(document.forofcfor.vsol2,6)">

    </tr>
  </table></center>

  <br> <br>
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="a_genoficio.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  </div>  
  <br><br><br><br><br><br><br>
</form>
</body>
</html>
