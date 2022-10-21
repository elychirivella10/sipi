<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3> -->
  
  <div align="center">
    <table>    
        <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="forpatentes2" action="z_browse.php?vopc=0" method="post"> 
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="v2">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
     &nbsp;
     <input type='hidden' name='camposquery' value="{$camposquery}">
     <input type='hidden' name='camposname'  value="{$camposname}">
     <input type='hidden' name='tablas'      value="{$tablas}">
     <input type='hidden' name='condicion'   value="{$condicion}"> 
     <input type='hidden' name='orden'       value="{$orden}">
     <input type='hidden' name='modo'        value="{$modo}"> 
     <input type='hidden' name='modoabr'     value="{$modoabr}">
     <input type='hidden' name='vurl'        value="{$vurl}">
     <input type='hidden' name='new_windows' value="{$new_windows}">
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/edit_f2.png" value="Guardar">   Editar   </td> 
 <!-- <td class="cnt"><a href="p_bolveram.php"><img src="imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td> -->
 <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>   Salir   </td>
<!--         <td class="cnt"><input type="submit" name="editar" value="Editar"></td> 
	<td class="cnt"><input type="reset" name="cancelar" value="Cancelar"
	    onclick="location.href='p_bolveram.php'"></td>
	<td class="cnt"><input type="button" name="salir" value="Salir"
	    onclick="location.href='index1.php'"></td> -->
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


