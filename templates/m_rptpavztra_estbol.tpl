<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<form name="foravztra" action="m_rptavztra_estbol.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
  <br>
  
  <table>
  <tr>
  </tr>
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          {html_options values=$arraytipo selected=$tipo output=$arraytipo}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" >
        <select size='1' name='orde'>
          {html_options values=$arrayorde selected=$orde output=$arrayorde}
        </select>
      </td>
    </tr> 

    </tr>   
  </table><!--</font>--></center>
  <br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavztra_estbol.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>
