<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<h3> {$subtitulo}</h3>

<form name="forrole" action="z_elmobrol.php?vopc=1" method="POST">
<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
       <td class="der-color" >
        <select size='1' name='rol_id'>
          {html_options values=$arrayrole selected=$rol_id output=$arraynombre}
        </select>
        <input type='{$submitbutton}' name='submit' value='Buscar'>
       </td>
    </tr>
  </tr>
  </table>
</form>
<form name="forrole1" action="z_elmobrol.php?vopc=2" method="POST">  
  <input type='hidden' name='rol_id' value='{$rol_id}'>
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        {html_checkboxes name="id_obj" values=$arrayobjeto selected=$objeto_id output=$arraynomobj separator="<br />"}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table>
  <tr>
    <td class="der">
      <input type='{$submitbutton1}' name="Eliminar" value="Eliminar" name="Eliminar">
      <input type="reset" name="Cancelar" value="Cancelar" onclick="location.href='z_elmobrol.php'">
      <input type="button" name="Salir" value="Salir" onclick="location.href='../index.php'">
    </td>
  </tr>
  </table>
</div>  
</form>

</body>
</html>