<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forobrol" action="z_ingobrol.php?vopc=2" method="POST"'>
  <input type ='hidden' name='rol_id' value={$rol_id}>
  <input type ='hidden' name='id_objeto' value={$id_objeto}>    
  <input type ='hidden' name='totalobj' value={$totalobj}>

  <div align="center">
  <table>
  <tr>  
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color" >
        <select size='1' name='rol_id'>
          {html_options values=$arrayrole selected=$rol_id output=$arraynombre}
        </select>
      </td>
    </tr>
  </table></center>
  &nbsp;
  {$campo2}
  <table>
    <tr>
      <td class="der-color" >
        {html_checkboxes name="id_objeto" values=$arrayobjeto selected=$objeto output=$arraydescob separator="<br />"}
      </td>
    </tr>
  </table>
&nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="z_ingobrol.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

  </div>  
</form>
</body>
</html>
