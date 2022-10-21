<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forpoder" action="m_rptpoder.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
  <br>
  
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">

   {$campod}<input type="text" name="desde1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpoder.desde2)" onchange="Rellena(document.forpoder.desde1,2)">-
        <input type="text" name="desde2" align="right" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpoder.submit)" onchange="Rellena(document.forpoder.desde2,4)">
{$campoh}
        <input type="text" name="hasta1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forpoder.hasta2)" onchange="Rellena(document.forpoder.hasta1,2)">-
        <input type="text" name="hasta2" align="right" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.forpoder.submit)" onchange="Rellena(document.forpoder.hasta2,4)">
      </td>
    </tr>
   
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        {$campod} <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forpoder.desdet)"> 
	{$campoh}
     <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forpoder.hastat)">
    </tr>

  </table><!--</font>--></center>
	<br>
    <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptppoder.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
</form>

</body>
</html>
