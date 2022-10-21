<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="foravztra" action="m_rptlispet.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

  <table>
  <tr>
 
    <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo7} <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.foravztra.desdet)"> 
	{$campo8}
     <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.foravztra.hastat)">
    </tr>
    

    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2} <input type="text" name="desde" value='{$desde|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.foravztra.desde)"> 
	{$campoh}
     <input type="text" name="hasta" value='{$hasta|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.foravztra.hasta)">

    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="tipo" size="1" maxlength="1">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>
 
  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/printmgr.png" value="Buscar">  Imprimir  </td>
      <td class="cnt"><a href="m_rptplispet.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
</div>  
</form>

</body>
</html>
