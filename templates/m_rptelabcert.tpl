<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="foravztra" action="m_rptelabcert.php" method="POST">
  <div align="center">
  <br>
  <table>
  <tr>
 
    <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo7} <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(this,document.foravztra.desdet)"> 
	{$campo8}
     <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(this,document.foravztra.hastat)">
    </tr>
   


    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>

    </tr>   
  </table><!--</font>--></center>
	<br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpelabcert.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div> 
<br><br><br><br><br><br><br><br><br><br><br><br><br><br> 
</form>

</body>
</html>
