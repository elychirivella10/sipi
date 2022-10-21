<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">
<form name="form" action="m_reseditar3.php?a=2&p={$preresolucion}" method="POST">
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
      <td class="izq-color">{$campo1}</td>
      <td class="der-color"> 
      	<textarea rows="2" name="comentario" class="required" cols="57" maxlength="120" onkeyup="this.value=this.value.toUpperCase()"></textarea>
	   </td>
	 </tr>
  </table>
 
      
  <table width="700">
  <tr>
    <td class="cnt">
    <a href="javascript:history.back();"><input type="image" src="../imagenes/addedit.png" value="EDITAR"></a>VOLVER A EDITAR
	 <a href="../index1.php"><input type="image" src="../imagenes/salir_f2.png" value="EXAMINAR"></a>EXAMINAR LUEGO     
	 <input type="submit" src="../imagenes/apply_f2.png" value="ENVIAR AL COORDINADOR">
    </td>
  </tr>
  </table>
 </form>     
</div>
</body>
</html>
