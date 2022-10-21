<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forlisbol" action="m_rptlisbol.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
  <br>
 <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod} <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlisbol.vsol2)" onchange="Rellena(document.forlisbol.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlisbol.vsol1h)" onchange="Rellena(document.forlisbol.vsol2,6)">{$campoh}
        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forlisbol.vsol2h)" onchange="Rellena(document.forlisbol.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlisbol.fecpub)" onchange="Rellena(document.forlisbol.vsol2h,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="4" maxlength="3"  onKeyPress="return acceptChar(event,2, this) onkeyup="checkLength(event,this,3,document.forlisbol.B1)">
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          {html_options values=$arraytipo selected=$tipo output=$arraytipo}
        </select>
      </td>
    </tr>
    
  </table><!--</font>--></center>
	<br><br>
	 
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptplisbol.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>
