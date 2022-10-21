<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../libjs/r_funciones.js"></script>
  <script type="text/javascript">

</script>
</head>
<body onLoad="Inicializar()">
<div align="center">
<form name='form' action='m_reseliminaabo2.php' method='POST'>
  <table width="600" >
  		<td colspan=4 class="izq-color">{$campo1}</td>
  </tr>
 
	 {section name=cont loop=$vnumrows}
	    <tr><td  class="izq-color">
 	    <input name="{$aboinput[cont]}" type="checkbox" value ="{$abologin[cont]}" />
 	    </td> 
	    <td class="der-color">
	    {$aboced[cont]}
	    </td>
	    <td class="der-color">
	    {$abonombre[cont]}
	    </td>
	    <td class="der-color">
	    {$abologin[cont]}
	    </td>	    	    
	    </tr>
	 {/section} 
	      
  
  <tr>
    <td class="cnt" colspan="2"><input type="image" src="../imagenes/save_f2.png" value="Guardar">
    	<br>Guardar
	 	<input  type="hidden" value="{$vnumrows}" name="num" />
	 	<input  type="hidden" value="{$est}" name="est" />
	 	<input  type="hidden" value="{$id}" name="res_preid" />    
    </td> 

    <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir</td>
  </tr>
  </table>
  
</form>

</div>
</body>
</html>
