<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<h3> {$subtitulo}</h3>

<form name="forobjeto" action="z_elimobj.php?vopc=1" method="POST">
<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
       <td class="der-color" >
        <select size='1' name='obj_id'>
          {html_options values=$arrayobjeto selected=$obj_id output=$arraynombre}
        </select>
       </td>
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table >
  <tr>
    <td class="der">
      <input type='{$submitbutton}' name="Eliminar" value="Eliminar" name="Eliminar">
      <input type="reset" name="Cancelar" value="Cancelar" onclick="location.href='z_elimobj.php'">
      <input type="button" name="Salir" value="Salir" onclick="location.href='../index.php'">
    </td>
  </tr>
  </table>
</div>  
</form>

</body>
</html>
