<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="a_devoluci.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color">
            <input type="text" name="vsol" size="6" maxlength="6" value='{$vsol}' {$modo} 
                   onchange="Rellena(document.formarcas1.vsol,6)">
            <td class="cnt">
            &nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>			  
    <form name="formarcas2" action="a_devoluci.php?vopc=3" method="post" 
          onsubmit='return pregunta();'>
            &nbsp;&nbsp;<input type='hidden' name='vsol' value={$vsol}>
    	    <td>{$espacios}</td>
	    <td class="izq5-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" 
                value='{$vfec}' onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
                onchange="valFecha(this,document.formarcas2.otro)"><td></tr>
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
      {if $vopc neq 0}
      <H3>{$lcausadev}</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color">{$uno}</td><td class="der-color"><input type="checkbox" 
             name="causa1"><td>
	 <td class="der-color">{$luno}</td>
	 <td class="izq-color">{$dos}</td><td class="der-color"><input type="checkbox"  
             name="causa2"><td>
	 <td class="der-color">{$ldos}</td></tr><tr>
	 <td class="izq-color">{$tres}</td><td class="der-color"><input type="checkbox" 
             name="causa3"><td>
	 <td class="der-color">{$ltres}</td>
	 <td class="izq-color">{$cuatro}</td><td class="der-color"><input type="checkbox" 
             name="causa4"><td>
	 <td class="der-color">{$lcuatro}</td></tr><tr>
	 <td class="izq-color">{$cinco}</td><td class="der-color"><input type="checkbox"  
             name="causa5"><td>
	 <td class="der-color">{$lcinco}</td>
	 <td class="izq-color">{$seis}</td><td class="der-color"><input type="checkbox" 
             name="causa6"><td>
	 <td class="der-color">{$lseis}</td></tr><tr>
	 <td class="izq-color">{$siete}</td><td class="der-color"><input type="checkbox" 
             name="causa7"><td>
	 <td class="der-color">{$lsiete}</td>
	 <td class="izq-color">{$ocho}</td><td class="der-color"><input type="checkbox" 
             name="causa8"><td>
	 <td class="der-color">{$locho}</td></tr><tr>
	 <td class="izq-color">{$nueve}</td><td class="der-color"><input type="checkbox"  
             name="causa9"><td>
	 <td class="der-color">{$lnueve}</td>
	 <td class="izq-color">{$diez}</td><td class="der-color"><input type="checkbox" 
             name="causa10"><td>
	 <td class="der-color">{$ldiez}</td></tr><tr>
	 <td class="izq-color">{$once}</td><td class="der-color"><input type="checkbox" 
             name="causa11"><td>
	 <td class="der-color">{$lonce}</td>
	 <td class="izq-color">{$doce}</td><td class="der-color"><input type="checkbox" 
             name="causa12"><td>
	 <td class="der-color">{$ldoce}</td></tr><tr>
	 <td class="izq-color">{$trece}</td><td class="der-color"><input type="checkbox" 
             name="causa13"><td>
	 <td class="der-color">{$ltrece}</td>
	 <td class="izq-color">{$catorce}</td><td class="der-color"><input type="checkbox" 
             name="causa14"><td>
	 <td class="der-color">{$lcatorce}</td></tr><tr>
	 {if $lquince neq ''}
	 <td class="izq-color">{$quince}</td><td class="der-color"><input type="checkbox" 
             name="causa15"><td>
	 <td class="der-color">{$lquince}</td>
	 {/if}
         {if $ldieciseis neq ''}
	 <td class="izq-color">{$dieciseis}</td><td class="der-color"><input type="checkbox" 
             name="causa16"><td>
	 <td class="der-color">{$ldieciseis}</td>
	 {/if}
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color">{$lotro}</td><td class="der-color"><input size="90" type="text" 
               name="otro" maxlength="800"><td>
	</tr>
	</table>
     </table>
     {/if}

     <br>
     <table width="20%">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="a_devoluci.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
     </table>

    </form>
 <br> <br>
  </div>  
  </body>
</html>

