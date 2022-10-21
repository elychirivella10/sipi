<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <title>{$titulo}</title>
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" > 
  </head>
  <body onLoad="this.document.{$varfocus}.focus()">
  <!-- <H3>{$subtitulo}</H3> -->
  <br>
    <form name="formarcas1">
      <div align="center">
      <input type='hidden' name='nconex' value='{$n_conex}'>
      <table>
      
	</form>
	<form name="formarcas2" action="m_minbol.php?vopc=3" method="post">
	<input type="hidden" name="vsoli1">
	<input type="hidden" name="vsoli2">
	<input type="hidden" name="vsoli3">
	<input type="hidden" name="vsoli4">
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vtip)" >	
	
    </table>
    <br><br>
     <table width="225">
       <tr>

        <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Generar"></td>
        <td class="cnt"><a href="m_pminbol.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
       </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>
