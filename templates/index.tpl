<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<h3> {$subtitulo}</h3>

<form name="foracceso" action="index.php?vopc=2" method="post">
  <div align="center">
  <table>
  <tr>
    <tr>
      <td class="th" >&nbsp;</td>
    </tr>
    <tr>
      <td class="th" >&nbsp;</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='login' value='{$login}' size="10" maxlength="12" onKeyPress="return acceptChar(event,3, this)">
      </td>
    </tr>
    <tr>
      <td class="th" >&nbsp;</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="password" name='passwd' value='{$passwd}' size="10" maxlength="12" onKeyPress="return acceptChar(event,3, this)" onkeyup="checkLength(event,this,8,document.foracceso.login)">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  <table >
  <tr>
    <td class="der">
      <input type="submit" value="Ingresar" name="Ingresar">
      <input type="reset" value="Cancelar" name="Cancelar" onclick="location.href='index.php'">
    </td>
  </tr>
  </table>
  </div>  
</form>

</body>
</html>
