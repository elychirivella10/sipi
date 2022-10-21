<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3> -->
  <br>
  <div align="center">
    <table>    
        <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="formarcas2" action="z_browse.php?vopc=0" method="post"> 
        <input type="hidden" name="nveces" value="{$nveces}">
        <input type="hidden" name="nconexion" value="{$nconexion}">  
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="v2">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
     <input type='hidden' name='camposquery' value="{$camposquery}">
     <input type='hidden' name='camposname'  value="{$camposname}">
     <input type='hidden' name='tablas'      value="{$tablas}">
     <input type='hidden' name='condicion'   value="{$condicion}"> 
     <input type='hidden' name='orden'       value="{$orden}">
     <input type='hidden' name='modo'        value="{$modo}"> 
     <input type='hidden' name='modoabr'     value="{$modoabr}">
     <input type='hidden' name='vurl'        value="{$vurl}">
     <input type='hidden' name='new_windows' value="{$new_windows}">
     <br>
     <table width="190">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_editar_azul.png" value="Guardar"></td> 
 <!-- <td class="cnt"><a href="m_bolveram.php?nveces={$nveces}&nconexion={$nconexion}"><img src="imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td> -->
 <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>


