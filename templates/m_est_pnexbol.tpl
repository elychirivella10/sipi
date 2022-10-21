<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forestanu" action="m_est_pnexbol.php?vopc=1" method="POST">
  <div align="center">

 <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod}
        <input type="text" name="bol" align="right" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)" >
      </td>
    </tr>
    
  </table><!--</font>--></center>
	<p></p>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/JpGraph_Logo_m.png" value="Buscar">  Graficar  </td>
      <td class="cnt"><a href="m_est_pnexbol.php?vopc=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

  </div>  
</form>

</body>
</html>
