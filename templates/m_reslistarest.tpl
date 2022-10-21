<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
</head>
<body onLoad="Inicializar()">
<div align="center">

  <table>
        <tr>
	      <td class="izq-color">{$tgrilla}</td>
	    </tr>
	<tr>
	      <td>{$grilla}</td>
	</tr>
</table>
	
  <table>
 <tr>
 {php}
	if ($_GET['est']==5){
 {/php}
 <td class="cnt">
 	<input type="image" src="../imagenes/bole.png" value="Publicar">
</td> 	
 <td class="cnt">
 	Enviar a<br>Boletin
</td> 	
 {php}
	} 
 {/php}
 
 <td class="cnt">
    <a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>Salir
    </td>
  </tr>

  </table>
</div>
</body>
</html>
	
