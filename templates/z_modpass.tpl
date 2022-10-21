<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">

<form name="forusing1" action="z_modpass.php?vopc=2"method="POST">  
  <input type='hidden' name='vstring' value='{$vstring}'>
  <br>

  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type='password' name='passwant' value='{$passwant}' {$modo2} size="15" maxlength="10" tabindex="1" onKeyPress="return acceptChar(event,3, this)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type='password' name='passwd' value='{$passwd}' {$modo2} size='15' maxlength="10" tabindex="2" onKeyPress="return acceptChar(event,3, this)"><small>M&aacute;ximo 10 Caracteres</small></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type='password' name='rpasswd' value='{$rpasswd}' {$modo2} size='15' maxlength="10" tabindex="3" onKeyPress="return acceptChar(event,3, this)"><small>M&aacute;ximo 10 Caracteres</small></td>
    </tr>
  </tr>
  </table>
  <br>
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} tabindex="4" src="../imagenes/boton_guardar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      <a href="z_modpass.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br>
</div>  
</form>

</body>
</html>
