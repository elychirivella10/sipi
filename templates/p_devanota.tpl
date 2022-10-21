<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="p_devanota.php?vopc=1" method="post">
      <table>
        <tr>
            <td class="izq5-color">{$lregistro}</td>
	    <td class="der-color">
              <input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$vreg1}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
	      <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$vreg2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vreg2,6)">&nbsp;&nbsp;
	    <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">   Buscar  </td></p>
        </tr>
      </table>
    </form>			  
    <form name="formarcas2" action="p_devanota.php?vopc=3" method="post" onsubmit='return pregunta();'>
      <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'>
      <input type="hidden" name="vder" value='{$vder}'>
      
      <table>
       <tr>
         <!-- <td class="izq-color">{$lfechaevent}</td>
	 <td class="der-color"><input size="9" type="text" name="vfevh" value='{$vfec}'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td>
    	 <td>{$espacios}&nbsp;&nbsp;</td>-->
	 <td class="izq5-color">{$ltramite}</td>
         <td class="der-color">
            <select size="1" name="tramite" >
              {html_options values=$arrayvtrami selected=$tramite output=$arrayttrami}
            </select>
         </td>
    	 <td>{$espacios}&nbsp;&nbsp;</td>
         <td class="izq5-color">{$lfecharen}</td>
	 <td class="der-color"><input size="9" type="text" name="vfechr" value='{$vfechr}'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td>
       <td class="izq5-color">{$lnumtra}</td>
	    <td class="der-color">
           <input type="text" name="vnumtram" size="9" maxlength="9" value='{$vnumtram}'>
       </td>
       </tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lsolicitud}</td>
	    <td class="der-color">
              <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' {$vmodo}>-
              <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' {$vmodo}>             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$lfechasolic}&nbsp;
              <input size="10" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>
            </td>
          {if ($vmod eq "G" || $vmod eq "M") }
	        <td class="der-color" rowspan="6" align="center" valign="top">
                <a href='{$nameimage}' target="_blank">
                <img border="-1" src={$nameimage} width="156"></td>
	    {/if}    
	</tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="85" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td>
	</tr>
	<tr><td class="izq-color">{$lctipop}</td>
	   <td class="der-color">
	     <input size="30" type="text" name="vtipo" value='{$lctipo} - {$tipopaten}' {$vmodo}>
           </td>
        </tr>
	<tr>
         <td class="izq-color" >{$lestatus}</td>
         <td class="der-color">
           <input size="80" name="vmod" '{$vmodo}' value='{$vest} - {$vdest}'>
         </td>
        </tr>
	<tr>
         <td class="izq-color" >{$ltramage}</td>
         <td class="der-color">
           <input size="80" name="vtragen" '{$vmodo}' value='{$vtragen}'>
         </td>
        </tr>
      </table>
      {if $vopc neq 0}
      <H3>{$lcausadev}</H3>
      <table cellspacing="1" border="1">	    
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
	 <td class="izq-color">{$dieciocho}</td><td class="der-color"><input type="checkbox" name="causa18" disabled ><td>
	 <td class="der-color">{$ldieciocho}</td></tr><tr> 
	 <td class="izq-color">{$diecinueve}</td><td class="der-color"><input type="checkbox" name="causa19" disabled ><td>
	 <td class="der-color">{$ldiecinueve}</td> 
	 <td class="izq-color">{$veinte}</td><td class="der-color"><input type="checkbox" name="causa20" disabled ><td>
	 <td class="der-color">{$lveinte}</td></tr><tr>  
	 <!-- <td class="izq-color">{$veintiuno}</td><td class="der-color"><input type="checkbox" name="causa21" {$modo} ><td>
	 <td class="der-color">{$lveintiuno}</td> --> 

	 {/if}
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color">{$lotro}</td><td class="der-color"><input size="90" type="text" name="otro" maxlength="500"><td>
	</tr>
	</table>
     </table>
     {/if}
     &nbsp;

    <table width="315">
    <tr>
      <td class="der">
      <td class="cnt"><a href="p_rptcronol.php?vsol={$solicitud1}-{$solicitud2}">
      <input type="image" src="../imagenes/folder_f2.png"></a>	 Cronologia 	</td> 
      <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar">	Guardar 	</td> 
      <td class="cnt"><a href="p_devanota.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar 	</td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir 	</td>
      </td>
    </tr>
    </table></center>

    </form>
  </div>  
  </body>
</html>

