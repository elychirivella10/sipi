<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forobscon" action="m_gendevolfon.php?vopc=2" method="POST">
 <div align="center">
<br>

<table >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod} 
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forobscon.vsol2)" onchange="Rellena(document.forobscon.vsol1,2);valagente(document.forobscon.vsol1,document.forobscon.vsol1h)" onblur="valagente(document.forobscon.vsol1,document.forobscon.vsol1h)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forobscon.vsol1h)" onchange="Rellena(document.forobscon.vsol2,6)"onblur="valagente(document.forobscon.vsol2,document.forobscon.vsol2h)">
      {$campoh}
        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forobscon.vsol2h)" onchange="Rellena(document.forobscon.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forobscon.boletin)" onchange="Rellena(document.forobscon.vsol2h,6)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>

  </table><!--</font>--></center>
  <br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" value="Actualizar"></td>
      <td class="cnt"><a href="m_gendevolfon.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>
