<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravztra" action="m_rptcantxt.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

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
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>

    </tr>   
  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/newspaper_add.png" value="Generar">  Generar  </td>
      <td class="cnt"><a href="m_rptcancela.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
</div>  
</form>

</body>
</html>
