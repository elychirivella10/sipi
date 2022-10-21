<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">
<form name="form" action="#" method="POST">
  <table>
       <tr>
	    	<td class="izq-color">Pre-Resoluci&oacute;n N&uacute;mero: </td>
	    	<td class="der-color">{$preresolucion}</td>
		 </tr>
       <tr>
	    	<td class="izq-color">Resoluci&oacute;n N&uacute;mero: </td>
	    	<td class="der-color">{$nresolucion}</td>
		 </tr>	
       <tr>
	    	<td class="izq-color">Estatus: </td>
	    	<td class="der-color">{$estatus}</td>
		 </tr>
       <tr>
	    	<td class="izq-color">Boletin: </td>
	    	<td class="der-color">{$boletin}</td>
		 </tr>			
       <tr>
	    	<td class="izq-color">Evento: </td>
	    	<td class="der-color">{$evento}</td>
		 </tr>	
       <tr>
	    <td colspan='2'>{$resolucion}</td>
       </tr>
 </table>
<br><br>
  <table width="350" >
  <tr>
     <td class="cnt"><a href="javascript:window.history.back();"><img src="../imagenes/salir_f2.png" border="0"></a>	Volver</td>
     <td class="cnt"><a href="m_resimprimir.php?id={$id}"><img src="../imagenes/print_f2.png" border="0"></a>	Imprimir</td>
  </tr>
  </table>

 </form>
</div>
</body>
</html>
