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
      <br><br><br>   
   	<form name="forpatentes2" action="p_actbolext_1.php?vopc=1" method="post">
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forpatentes2.vfbol)" >
	<tr><td class="izq-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="8" type="text" name="vfbol" value='{$vfbol}'  onkeyup="checkLength(event,this,10,document.forpatentes2.vfvig)"
	    onchange="valFecha(this,document.forpatentes2.vfbol)"></td></tr>
        <tr><td class="izq-color">{$lfechavigen}</td>
	    <td class="der-color"><input size="8" type="text" name="vfvig" value='{$vfvig}'  onkeyup="checkLength(event,this,10,document.forpatentes2.vtip)"
	    onchange="valFecha(this,document.forpatentes2.vfvig)"></td></tr>		
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="vtip">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
    <br><br>
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" value="Guardar"></td> 
 <td class="cnt"><a href="p_actbolext_1.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
 <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
    <br><br><br><br><br><br><br><br><br>
  </div>  
  </body>
</html>


