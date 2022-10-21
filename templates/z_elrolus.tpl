<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forusrol" action="z_elrolus.php?vopc=1"method="POST">
<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
       <td class="der-color" >
        <select size='1' name='usuario' '{$modo2}'>
          {html_options values=$arraycuenta selected=$usuario output=$arrayusuers}
        </select>
       </td>
      </td>
      <td class="cnt">
        <input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>        
    </tr>
  </tr>
  </table>
</form>
<form name="forusrol1" action="z_elrolus.php?vopc=2"method="POST">  
  <input type='hidden' name='usuario' value='{$usuario}'>
  <input type='hidden' name='role' value='{$role}'>
    
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' {$modo2} size='60' maxlength="60">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
    <td class="cnt">
      <a href="z_elrolus.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
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
