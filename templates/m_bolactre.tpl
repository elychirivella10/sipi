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
   	<form name="formarcas2" action="m_bolactre.php?vopc=1" method="post">
        <input type="hidden" name="nveces" value="{$nveces}">
        <input type="hidden" name="nconexion" value="{$nconexion}">  
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input type="text" name="vbol" size="2" maxlength="3" 
	        value='{$vbol}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.vfbol)" >
	       	               
	<tr><td class="izq-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="8" type="text" name="vfbol" value='{$vfbol}'  onkeyup="checkLength(event,this,10,document.formarcas2.vfvig)"
	    onchange="valFecha(this,document.formarcas2.otro)"></td></tr>
        <tr><td class="izq-color">{$lfechavigen}</td>
	    <td class="der-color"><input size="8" type="text" name="vfvig" value='{$vfvig}'  onkeyup="checkLength(event,this,10,document.formarcas2.vtip)"
	    onchange="valFecha(this,document.formarcas2.otro)"></td></tr>	
	    
	<tr><td class="izq-color">{$ltomo}</td>
	    <td class="der-color"><input type="text" name="tomo" size="10" maxlength="15" 
	        value='{$vbol}'  >
	        	    	
	<tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><select size=1 name="vtip">
	        {html_options values=$vtipest selected=1 output=$vtipsol}
	    </select></td></tr>  
    </table>
     &nbsp;
     <table width="225">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Guardar">  Actualizar  </td> 
 <td class="cnt"><a href="m_bolactre.php?nveces={$nveces}&nconexion={$nconexion}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
 <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


