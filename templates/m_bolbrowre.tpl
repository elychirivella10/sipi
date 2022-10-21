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
        <form name="formarcas2" action="z_browreg.php?vopc=1&vtp=0" method="post"> 
        <input type="hidden" name="nveces" value="{$nveces}">
        <input type="hidden" name="nconexion" value="{$nconexion}"> 
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="v1" size="2" maxlength="3" 
	        onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.v2)" onchange="validbol(document.formarcas2.v1)">	
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
     <input type='hidden' name='tabladel'    value="{$tabladel}">
     <input type='hidden' name='condicion2'  value="{$condicion2}">
     <input type='hidden' name='tablains'    value="{$tablains}">
     <input type='hidden' name='camposins'   value="{$camposins}">
     <input type='hidden' name='valoresins'  value="{$valoresins}">
     <input type='hidden' name='new_windows' value="{$new_windows}">
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/edit_f2.png" value="Guardar">  Editar  </td> 
 <td class="cnt"><a href="m_bolbrowre.php?nveces={$nveces}&nconexion={$nconexion}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
 <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


