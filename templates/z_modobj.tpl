<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>  

<body onLoad="this.document.{$varfocus}.focus()">

<h3> {$subtitulo}</h3>

<form name="forobjeto" action="z_modobj.php?vopc=1" method="POST">
<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
       <td class="der-color" >
        <select size='1' name='obj_id'>
          {html_options values=$arrayobjeto selected=$obj_id output=$arraynombre}
        </select>
        <input type='{$submitbutton}' name='submit' value='Buscar'>
       </td>
      </td>
    </tr>
  </tr>
  </table>
</form>
<form name="forobjeto1" action="z_modobj.php?vopc=2" method="POST">  
  <input type='hidden' name='obj_id' value='{$obj_id}'>
    
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type='text' name='nombre' value='{$nombre}' {$modo2} size='70' maxlength="70" onKeyPress="return acceptChar(event,4,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name='nivel' value='{$nivel}' size="2" maxlength="2" onKeyPress="return acceptChar(event,4,this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='nomencla' value='{$nomencla}' size="80" maxlength="80" onKeyPress="return acceptChar(event,4, this)">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table >
  <tr>
    <td class="der">
      <input type='{$submitbutton1}' name="Grabar" value="Grabar" name="Grabar">
      <input type="reset" name="Cancelar" value="Cancelar" onclick="location.href='z_modobj.php'">
      <input type="button" name="Salir" value="Salir" onclick="location.href='../index.php'">
    </td>
  </tr>
  </table>
</div>  
</form>

</body>
</html>
