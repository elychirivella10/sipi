<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forestanu" action="p_est_rconpag.php?vopc=1" method="POST">
  <div align="center">
 <br>
 <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod}
        <input type="text" name="bol" align="right" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forestanu.bol2)">
      </td>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
      {$campod}
        <input type="text" name="bol2" align="right" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)" >
      </td>
    </tr>
    
  </table><!--</font>--></center>
	<br>
  <table>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size=1 name="pais">
          {html_options values=$pai_val selected=1 output=$pai_des}
        </select></td>
    </tr>
  </table> 
    <br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_graficar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_est_rconpag.php?vopc=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>
