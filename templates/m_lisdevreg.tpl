<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="devreg" action="m_lisdevreg1.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

<table >
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campod} <input type="text" name="fecsold" value='{$fecsold}' size='9' onChange="valFecha(document.foravzcri.fecsold)"> 
	{$campoh}
     <input type="text" name="fecsolh" value='{$fecsolh}' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
    </tr>
    <tr>
       <td class="izq-color">{$ltramite}</td>
       <td class="der-color">
            <select size="1" name="tramite" >
              {html_options values=$arrayvtrami selected=$tramite output=$arrayttrami}
            </select>
         </td>
    </tr>   
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="12" maxlength="13">
      </td>
    </tr>   


  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/buscar_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_lisdevreg.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>
