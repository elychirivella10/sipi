<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">
<form name="form" action="m_resnueva4.php?p={$preresolucion}" method="POST">
  <table>
       <tr>
	    <td class="izq-color">Pre-Resoluci&oacute;n N&uacute;mero: </td>
	    <td class="der-color">{$preresolucion}</td>
	</tr>
        <tr>
	    <td>{$resolucion}</td>
	</tr>
 </table>
<br><br>
  <table>
    <tr>
      <td class="izq-color">Comentario:</td>
      <td class="der-color"> 
      	<textarea rows="2" name="comentario" class="required" cols="57" maxlength="120" onkeyup="this.value=this.value.toUpperCase()"></textarea>
	   </td>
	 </tr>
  </table>
  <table width="350" >
  <tr>
    <td class="cnt"><input type="image" value="submit" name="Enviar" src="../imagenes/move_f2.png">Enviar al Registrador</td>
    <td class="cnt"><input type="image" src="../imagenes/salir_f2.png" value="submit" name="Salir">Salir</td>   
  </tr>
  </table>

 </form>
</div>
</body>
</html>
