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
        <form name="formarcas2" action="z_browse.php?vopc=0&nveces={$nveces}&nconexion={$nconexion}" method="post"> 
        <input type="hidden" name="nveces" value="{$nveces}">
        <input type="hidden" name="nconexion" value="{$nconexion}"> 
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="v1" size="2" maxlength="3" 
	        onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.v2)" onchange="validbol(document.formarcas2.v1)">
           <select size="1" name="aplica" >
             {html_options values=$apli_inf selected=$aplica output=$apli_def}
           </select> 
	        	
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
     <input type='hidden' name='tabladel'    value="{$tabladel}">
     <input type='hidden' name='condicion2'  value="{$condicion2}">
     <input type='hidden' name='tablains'    value="{$tablains}">
     <input type='hidden' name='camposins'   value="{$camposins}">
     <input type='hidden' name='valoresins'  value="{$valoresins}">
     <input type='hidden' name='new_windows' value="{$new_windows}">
     <br>
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_editar_azul.png" value="Guardar"></td> 
 <td class="cnt"><a href="m_bolediareg.php?nveces={$nveces}&nconexion={$nconexion}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
 <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>


