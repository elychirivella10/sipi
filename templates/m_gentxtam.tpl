<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forlisbol" action="m_gentxtam.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

 <table>
  <tr>
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
	<p></p>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/newspaper_add.png" value="Buscar">  Generar  </td>
      <td class="cnt"><a href="m_gentxtam.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

  </div>  
</form>

</body>
</html>
