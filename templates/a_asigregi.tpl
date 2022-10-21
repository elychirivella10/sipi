<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="a_asigregi.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color">
            <input type="text" name="vsol" size="6" maxlength="6" value='{$vsol}' {$modo} 
                   onKeyup="this.value=this.value.toUpperCase();"
                   onChange="Rellena(document.formarcas1.vsol,6)">
            <td class="cnt">
            <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>			  
    <form name="formarcas2" action="a_asigregi.php?vopc=3" method="post" 
          onsubmit='return pregunta();'>
            <input type ='hidden' name='vsol' value='{$vsol}'>
            <input type ='hidden' name='vder' value='{$vder}'>
    	</tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$ltipo}</td>
	    <td class="der-color"><input size="63" type="text" name="vtipo" 
                value='{$vtipo}' {$vmodo}></td>
        </tr>        
        <tr><td class="izq-color">{$ltitulo}</td>
	    <td class="der-color"><input size="63" type="text" name="vtitu"       
                value='{$vtitu}' {$vmodo}></td>
	</tr>
        <tr><td class="izq-color">{$lfechasolic}</td>
	    <td class="der-color"><input size="10" type="text" name="vfecsol" 
                value='{$vfecsol}' {$vmodo}></td>
   	</tr>
	<tr><td class="izq-color" >{$lsolicitante}</td>
            <td class="der-color"><input size="63" type="text" name="vsolt"  
                value='{$vsolt}' '{$vmodo}'></td>
        </tr> 
      </table>
     &nbsp;
     <table width="50%">
       <tr><td class="izq-color">{$lfechavig}</td>
	   <td class="der-color"><input size="10" type="text" name="vfechavig" 
                value='{$vfechavig}' '{$vmodo1}'  
                onkeyup="checkLength(event,this,10,document.formarcas2.vregistro)"
                onchange="valFecha(this,document.formarcas2.vregistro)"><td>
       
           <td class="izq-color">{$lregistro}</td>
	    <td class="der-color">
            <input type="text" name="vregistro" size="6" maxlength="6" 
                   value='{$vregistro}' {$vmodo1} 
                   onKeyup="this.value=this.value.toUpperCase();" >
       </tr>
     </table>
     &nbsp;
     <table width="210">
       <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="a_asigregi.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="a_rptcronol.php?vsol={$vsol}"><input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td>
	    </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

