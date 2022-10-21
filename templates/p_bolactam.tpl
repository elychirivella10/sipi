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
   	<form name="forpatentes2" action="p_bolactam.php?vopc=1" method="post">
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forpatentes2.vfbol)" >
	<tr><td class="izq-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="8" type="text" name="vfbol" value='{$vfbol}'  onkeyup="checkLength(event,this,10,document.forpatentes2.vtip)"
	    onchange="valFecha(this,document.forpatentes2.otro)"></td></tr>	
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="vtip">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
     &nbsp;
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar">  Actualizar </td> 
 <td class="cnt"><a href="p_bolactam.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
 <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir </td>
<!--         <td class="cnt"><input type="submit" name="generar" value="Actualizar"></td> 
	<td class="cnt"><input type="reset" name="cancelar" value="Cancelar"
	    onclick="location.href='p_bolactam.php'"></td>
	<td class="cnt"><input type="button" name="salir" value="Salir"
	    onclick="location.href='index1.php'"></td> -->
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


