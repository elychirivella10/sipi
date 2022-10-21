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
<form name='form' action='m_reselimsol2.php' method='POST'>
  <table width="400" align= "center">
  <tr>
  		<td colspan=3 class="izq-color">{$campo1}</td>
  </tr>
 
	 {section name=cont loop=$vnumrows}
	    <tr><td  class="izq-color">
 	    <input name="{$nsol[cont]}" id="solicitudes" type="checkbox" value ="{$solicitud[cont]}" />
 	    </td> 
	    <td class="der-color">
	    {$solicitud[cont]}
	    </td>
	    <td class="der-color">
	    {$marca[cont]}
	    </td>	    
	    </tr>
	 {/section} 
	      
  
  <tr>
  <td> </td>
    <td class="cnt"><input type="image" src="../imagenes/delete_f2.png" value="Guardar">
    	<br>Eliminar
    	<input  type="hidden" value="{$plantid}" name="plantid" />
	 	<input  type="hidden" value="{$cont1}" name="num" />
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
