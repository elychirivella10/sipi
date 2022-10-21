<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravztra" action="m_rptfonpro1.php" method="POST">
  <div align="center">

  <table>
  <tr>
    <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2} <input type="text" name="desde" value='{$desde}' size='9' onChange="valFecha(document.foravztra.desde)"> 
	{$campo3} <input type="text" name="hasta" value='{$hasta}' size='9' onChange="valFecha(document.foravztra.hasta)">
      </td>
    </tr>
   
  </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="11" maxlength="12">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
         <select size="1" name="options">
          {html_options values=$vcodsede selected=$vsede output=$vnomsede|truncate:15}
         </select>
      </td>
    </tr>          
  </table></center>
  &nbsp;
  &nbsp;
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_rptfonpro.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
</div>  
</form>

</body>
</html>
