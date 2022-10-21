<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
  <br><br><br>
	<form name="formarcas2" action="m_bolgenobs.php?vopc=3" method="post">
   <table>
	<tr><td class="izq-color">{$lboletin1}</td>
	    <td class="der-color"><input type="text" name="vbol1" size="2" maxlength="3" 
	        value='{$vbol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vbol2)" >	
	<tr><td class="izq-color">{$lboletin2}</td>
	    <td class="der-color"><input type="text" name="vbol2" size="2" maxlength="3" 
	        value='{$vbol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vtip)" >	
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="vtip">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
     &nbsp;
     <table width="210">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Guardar"></td> 
        <td class="cnt"><a href="m_bolgenobs.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>


