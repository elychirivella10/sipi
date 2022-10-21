<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3>  -->
  
  <div align="center">
    <form name="formarcas1" action="m_devoluci.php?vopc=1" method="post">
      <table>
        <tr><td class="izq-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
		<!--             <input type={$submitbutton} name='submit' value='Buscar'></td> --> 
    </form>			  
    <form name="formarcas2" action="m_devoluci.php?vopc=3" method="post" onsubmit='return pregunta();'>
    	    <td>{$espacios}</td>
	    <td class="izq-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" value='{$vfec}'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td></tr>
      </table>
      &nbsp; 
      <table>	
        <tr><td class="izq-color">{$lfechasolic}</td>
	    <td class="der-color"><input size="10" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}></td>
   {if ($vmod eq "G" || $vmod eq "M") }
	        <td class="der-color" rowspan="4" align="center" valign="top">
                <a href='{$nameimage}' target="_blank">
                <img border="-1" src={$nameimage} width="110"></td>
	    {/if}    
	</tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="63" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td>
	</tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td class="der-color"><input size="1" type="text" name="vcla" value='{$clase}' {$vmodo}>
	                <input size="14" type="text" name="vindcla" value='{$ind_claseni}' {$vmodo}></td></tr>
	<tr>
      <td class="izq-color" >{$lmodal}</td>
      <td class="der-color">
        <input size="12" name="vmod" '{$vmodo}' value='{$vmodal}'></td></tr> 
      </table>
      {if $vopc neq 0}
      <H3>{$lcausadev}</H3>
      <table>	    
	<tr>
	 <td class="izq-color">{$uno}</td><td class="der-color"><input type="checkbox" name="causa1"><td>
	 <td class="der-color">{$luno}</td>
	 <td class="izq-color">{$dos}</td><td class="der-color"><input type="checkbox" name="causa2"><td>
	 <td class="der-color">{$ldos}</td></tr><tr>
	 <td class="izq-color">{$tres}</td><td class="der-color"><input type="checkbox" name="causa3"><td>
	 <td class="der-color">{$ltres}</td>
	 <td class="izq-color">{$cuatro}</td><td class="der-color"><input type="checkbox" name="causa4"><td>
	 <td class="der-color">{$lcuatro}</td></tr><tr>
	 <td class="izq-color">{$cinco}</td><td class="der-color"><input type="checkbox" name="causa5"><td>
	 <td class="der-color">{$lcinco}</td>
	 <td class="izq-color">{$seis}</td><td class="der-color"><input type="checkbox" name="causa6"><td>
	 <td class="der-color">{$lseis}</td></tr><tr>
	 <td class="izq-color">{$siete}</td><td class="der-color"><input type="checkbox" name="causa7"><td>
	 <td class="der-color">{$lsiete}</td>
	 <td class="izq-color">{$ocho}</td><td class="der-color"><input type="checkbox" name="causa8"><td>
	 <td class="der-color">{$locho}</td></tr><tr>
	 <td class="izq-color">{$nueve}</td><td class="der-color"><input type="checkbox" name="causa9"><td>
	 <td class="der-color">{$lnueve}</td>
	 <td class="izq-color">{$diez}</td><td class="der-color"><input type="checkbox" name="causa10"><td>
	 <td class="der-color">{$ldiez}</td></tr><tr>
	 <td class="izq-color">{$once}</td><td class="der-color"><input type="checkbox" name="causa11"><td>
	 <td class="der-color">{$lonce}</td>
	 <td class="izq-color">{$doce}</td><td class="der-color"><input type="checkbox" name="causa12"><td>
	 <td class="der-color">{$ldoce}</td></tr><tr>
	 <td class="izq-color">{$trece}</td><td class="der-color"><input type="checkbox" name="causa13"><td>
	 <td class="der-color">{$ltrece}</td>
	 <td class="izq-color">{$catorce}</td><td class="der-color"><input type="checkbox" name="causa14"><td>
	 <td class="der-color">{$lcatorce}</td></tr><tr>
	 {if $lquince neq ''}
	 <td class="izq-color">{$quince}</td><td class="der-color"><input type="checkbox" name="causa15"><td>
	 <td class="der-color">{$lquince}</td>
	 <td class="izq-color">{$dieciseis}</td><td class="der-color"><input type="checkbox" name="causa16" {$modo} ><td>
	 <td class="der-color">{$ldieciseis}</td></tr><tr>
	 <td class="izq-color">{$diecisiete}</td><td class="der-color"><input type="checkbox" name="causa17" {$modo} ><td>
	 <td class="der-color">{$ldiecisiete}</td> 
	 {/if}
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color">{$lotro}</td><td class="der-color"><input size="90" type="text" name="otro"><td>
	</tr>
	</table>
     </table>
     {/if}
     &nbsp;
     <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'>

    <table width="315">
    <tr>
      <td class="der">
      <td class="cnt"><a href="m_cronolo.php?vsol={$solicitud1}-{$solicitud2}">
      <input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> 
      <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Guardar">			Guardar 			</td> 
      <td class="cnt"><a href="m_devoluci.php"><img src="../imagenes/cancel_f2.png" border="0"></a>			Cancelar 			</td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>			Salir 			</td>
      </td>
    </tr>
    </table></center>

    </form>
  </div>  
  </body>
</html>

