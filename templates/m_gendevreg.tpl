<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="gendevreg" action="m_gendevreg.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

 <table>

    <tr>
     <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campod} <input type="text" name="fecsold" value='{$fecsold|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.gendevreg.fecsold)"> 
	{$campoh}
     <input type="text" name="fecsolh" value='{$fecsolh|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.gendevreg.fecsolh)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16"  >
      </td>
    </tr> 
   </tr>
    
  </table><!--</font>--></center>
	<p></p>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/newspaper_add.png" value="Buscar">  Generar  </td>
      <td class="cnt"><a href="m_pgendevreg.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

  </div>  
</form>

</body>
</html>
