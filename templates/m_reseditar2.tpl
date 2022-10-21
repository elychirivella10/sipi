<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">
<form name="form" action="m_reseditar3.php?p={$preresolucion}" method="POST">
  <table>
       <tr>
	    <td class="izq-color">Pre-Resoluci&oacute;n N&uacute;mero: </td>
	    <td class="der-color">{$preresolucion}</td>
	</tr>
    <tr>
	    <td>{$resolucion}</td>
	</tr>
 </table>
  <table>
    <tr>
      <td class="izq-color">Comentario:</td>
      <td class="der-color"> 
      	<textarea rows="2" name="comentario" class="required" cols="57" maxlength="120" onkeyup="this.value=this.value.toUpperCase()"></textarea>
	   </td>
	 </tr>
  </table>
 <table width="700">
  <tr>
    <td class="cnt">
    <a href="javascript:history.back();"><input type="image" src="../imagenes/addedit.png" value="EDITAR" height="24px" width="24px"></a>Editar
    <a href="../index1.php"><input type="image" src="../imagenes/salir_f2.png" value="EXAMINAR" height="24px" width="24px"></a>Examinar Luego
    </br>
    <input type="image" value="submit" name="Aprobar" src="../imagenes/apply_f2.png">Aprobar
    <input type="image" value="submit" name="Detener" src="../imagenes/exit.png">Detener
    <input type="image" value="submit" name="Rechazar" src="../imagenes/papelera.png">Rechazar
   <!--<input type="submit" src="../imagenes/apply_f2.png"  value="Aprobar" height="24px" width="24px">Aprobar
   <input type="submit" src="../imagenes/exit.png" value="Detener" height="24px" width="24px">Detener 
   <input type="submit" src="../imagenes/papelera.png" value="Rechazar" height="24px" width="24px">Rechazar
   -->
	      
    </td>
  </tr>
  </table>

</div>
</body>
</html>
