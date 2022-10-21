<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>    
  </head>
  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
  <table width="36%">
 <!--cuando es en ventana nueva debe incluirse en la siguiente linea despues del "post": target="_blank" -->
        <form name="formarcas2" action="z_browspet.php?vopc=0" method="post"> 
   <br><br>     
	<tr><td class="izq-color">{$lcodigo}</td>
	    <td class="der-color">{$vcodigo}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$ltipobus}</td>
      <td class="der-color">
        <select size="1" name="v5">
          {html_options values=$arraytipom selected=$v5 output=$arraynotip}
        </select>
      </td>
    </tr>
	<tr><td class="izq-color">{$lreferencia}</td>
	<td class="der-color"><input type="text" name="v4" size="8" maxlength="8" 
          onchange="this.value=this.value.toUpperCase()"  onkeyup="checkLength(event,this,5,document.formarcas2.v4)">
      </td>
    </tr>
	<tr><td class="izq-color">{$lpalabra}</td>
	<td class="der-color"><input type="text" name="v3" size="8" maxlength="8" 
          onchange="this.value=this.value.toUpperCase()"  onkeyup="checkLength(event,this,5,document.formarcas2.v3)">
      </td>
   </tr>


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
     <input type='hidden' name='vpalabra'  value="{$vpalabra}">
     <input type='hidden' name='v9'  value='C'>


     <br><br>  
     <table width="210">
        <tr>
      <td>
       <input type="image" src="../imagenes/boton_buscar_azul.png" value="buscar" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('buscar','','../imagenes/boton_buscar_azul.png',1);">
      </td>
      <td>	    
	    <a href="z_buspeticio.php" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	    <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a> 
      </td>      
      <td>
 	    <a href="../salir.php" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_azul.png',1);">
	    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>     
      </td>
        </tr>
     </table>
     <br><br><br><br><br><br><br><br><br><br><br><br><br>
    </form>
  </div>  
  </body>
</html>


