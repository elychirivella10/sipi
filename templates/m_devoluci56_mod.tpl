<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  <br>
    
  <div align="center">
    <form name="formarcas1" action="m_devoluci56_mod.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
		<!--             <input type={$submitbutton} name='submit' value='Buscar'></td> --> 
    </form>			  
    <form name="formarcas2" action="m_devoluci56_mod.php?vopc=3" method="post" onsubmit='return pregunta();'>
    	    <td>{$espacios}</td>
	    <td class="izq5-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" value='{$vfec}'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td></tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
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
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color">{$codcausa[0]}</td><td class="der-color"><input type="checkbox" name="causa1" {$ccausa1}><td><td class="der-color">{$descausa[0]}</td>
	 <td class="izq-color">{$codcausa[1]}</td><td class="der-color"><input type="checkbox" name="causa2" {$ccausa2}><td><td class="der-color">{$descausa[1]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[2]}</td><td class="der-color"><input type="checkbox" name="causa3" {$ccausa3}><td><td class="der-color">{$descausa[2]}</td>
	 <td class="izq-color">{$codcausa[3]}</td><td class="der-color"><input type="checkbox" name="causa4" {$ccausa4}><td><td class="der-color">{$descausa[3]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[4]}</td><td class="der-color"><input type="checkbox" name="causa5" {$ccausa5}><td><td class="der-color">{$descausa[4]}</td>
	 <td class="izq-color">{$codcausa[5]}</td><td class="der-color"><input type="checkbox" name="causa6" {$ccausa6}><td><td class="der-color">{$descausa[5]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[6]}</td><td class="der-color"><input type="checkbox" name="causa7" {$ccausa7}><td><td class="der-color">{$descausa[6]}</td>
	 <td class="izq-color">{$codcausa[7]}</td><td class="der-color"><input type="checkbox" name="causa8" {$ccausa8}><td><td class="der-color">{$descausa[7]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[8]}</td><td class="der-color"><input type="checkbox" name="causa9" {$ccausa9}><td><td class="der-color">{$descausa[8]}</td>
	 <td class="izq-color">{$codcausa[9]}</td><td class="der-color"><input type="checkbox" name="causa10" {$ccausa10}><td><td class="der-color">{$descausa[9]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[10]}</td><td class="der-color"><input type="checkbox" name="causa11" {$ccausa11}><td><td class="der-color">{$descausa[10]}</td>
	 <td class="izq-color">{$codcausa[11]}</td><td class="der-color"><input type="checkbox" name="causa12" {$ccausa12}><td><td class="der-color">{$descausa[11]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[12]}</td><td class="der-color"><input type="checkbox" name="causa13" {$ccausa13}><td><td class="der-color">{$descausa[12]}</td>
	 <td class="izq-color">{$codcausa[13]}</td><td class="der-color"><input type="checkbox" name="causa14" {$ccausa14}><td><td class="der-color">{$descausa[13]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[14]}</td><td class="der-color"><input type="checkbox" name="causa15" {$ccausa15}><td><td class="der-color">{$descausa[14]}</td>
	 <td class="izq-color">{$codcausa[15]}</td><td class="der-color"><input type="checkbox" name="causa16" {$ccausa16}><td><td class="der-color">{$descausa[15]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[16]}</td><td class="der-color"><input type="checkbox" name="causa17" {$ccausa17}><td><td class="der-color">{$descausa[16]}</td>
{if $descausa[17] neq ''}
	 <td class="izq-color">{$codcausa[17]}</td><td class="der-color"><input type="checkbox" name="causa18" {$ccausa18}><td><td class="der-color">{$descausa[17]}</td></tr><tr>{/if}
{if $descausa[18] neq ''}
	 <td class="izq-color">{$codcausa[18]}</td><td class="der-color"><input type="checkbox" name="causa19" {$ccausa19}><td><td class="der-color">{$descausa[18]}</td>{/if}
{if $descausa[19] neq ''}
	 <td class="izq-color">{$codcausa[19]}</td><td class="der-color"><input type="checkbox" name="causa20" {$ccausa20}><td><td class="der-color">{$descausa[19]}</td></tr><tr>{/if}
{if $descausa[20] neq ''}
	 <td class="izq-color">{$codcausa[20]}</td><td class="der-color"><input type="checkbox" name="causa21" {$ccausa21}><td><td class="der-color">{$descausa[20]}</td>{/if}
{if $descausa[21] neq ''}
	 <td class="izq-color">{$codcausa[21]}</td><td class="der-color"><input type="checkbox" name="causa22" {$ccausa22}><td><td class="der-color">{$descausa[21]}</td></tr><tr>{/if}
{if $descausa[22] neq ''}
	 <td class="izq-color">{$codcausa[22]}</td><td class="der-color"><input type="checkbox" name="causa23" {$ccausa23}><td><td class="der-color">{$descausa[22]}</td>{/if}
{if $descausa[23] neq ''}
	 <td class="izq-color">{$codcausa[23]}</td><td class="der-color"><input type="checkbox" name="causa24" {$ccausa24}><td><td class="der-color">{$descausa[23]}</td></tr><tr>{/if}
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color">{$lotro}</td><td class="der-color"><input size="90" type="text" name="otro" value='{$otro}'><td>
	</tr>
	</table>
     </table>
     {/if}
     &nbsp;
     <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'>
     <input type="hidden" name="nderec" value='{$nderec}'>

    <table width="260">
    <tr>
      <td class="der">
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="m_devoluci56_mod.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../consultamarcas/ver_marcas_fon.php?vnsol={$solicitud1}-{$solicitud2}" target="_blank">
       <img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
      </td>
    </tr>
    </table></center>
    </form>
    <br><br><br><br><br>
  </div>  
  </body>
</html>

