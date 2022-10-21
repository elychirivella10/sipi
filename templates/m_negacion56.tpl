<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  <br>
   
  <div align="center">
    <form name="formarcas1" action="m_negacion56.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>			  
    <form name="formarcas2" action="m_negacion56.php?vopc=3" method="post" onsubmit='return pregunta();'>
            <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'>
    	    <td> </td>
	    <td class="izq5-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" value='{$vfec}' {$vmodo}><td></tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="63" type="text" name="vnom" value='{$nombre}' {$vmodo}></td>
	    {if $vmod eq "G" || $vmod eq "M"}
        <td rowspan="3" align="center" valign="top">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="100">
        </td>
      {/if}</tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td class="der-color"><input size="1" type="text" name="vcla" value='{$clase}' {$vmodo}>
	                <input size="14" type="text" name="vindcla" value='{$ind_claseni}' {$vmodo}></td></tr>
        <tr><td class="izq-color">{$ltramitante}</td>
	    <td class="der-color"><input size="63" type="text" name="vtra" value='{$tramitante}' {$vmodo}></td></tr>			
	<tr>
	   <td class="izq-color">{$lcomentario}</td><td colspan="2" class="der-color">
	       <textarea rows="2" name="comenta" cols="91" onchange="this.value=this.value.toUpperCase()"></textarea></td></tr>
     </table>	
      &nbsp;
     <table>	    
	<tr>
	 <td class="izq-color">{$lart}</td><td class="der-color"><input size="2" type="text" name="art" maxlength="2"  onKeyPress="return acceptChar(event,2, this)" onchange="validart56(this,document.formarcas2.lit1,document.formarcas2.vlit1reg11)" onkeyup="checkLength(event,this,2,document.formarcas2.lit1)">&nbsp;<td>
	 
	 <!-- Primer Literal - 1er. Registro -->	
	 <td class="izq-color">{$llit}</td><td class="der-color"><input size="1" type="text" name="lit1" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  
	 onkeyup="checkLength(event,this,2,document.formarcas2.vlit1reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit1reg11);">&nbsp;<td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg11" size="1" maxlength="1" 
	        value='{$lit1reg11}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg12" size="6" maxlength="6" 
		value='{$lit1reg12}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg21)" onchange="Rellena(document.formarcas2.vlit1reg12,6)">&nbsp;</td>
	<!-- <td rowspan="3">{$espacios}</td>	-->
	&nbsp;	
	 <!-- Segundo Literal - 1er. Registro -->	
	 <td class="izq-color">{$llit}</td><td class="der-color"><input size="1" type="text" name="lit2" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  onkeyup="checkLength(event,this,2,document.formarcas2.vlit2reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit2reg11);">&nbsp;<td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg11" size="1" maxlength="1" 
	        value='{$lit2reg11}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg12" size="6" maxlength="6" 
		value='{$lit2reg12}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg21)" onchange="Rellena(document.formarcas2.vlit2reg12,6)">&nbsp;</td></tr><tr>
 	 </tr><tr>
 	 
	 <!-- Primer Lireral - 2do. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg21" size="1" maxlength="1" 
	        value='{$lit1reg21}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg22" size="6" maxlength="6" 
		value='{$lit1reg22}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg31)" onchange="Rellena(document.formarcas2.vlit1reg22,6)">&nbsp;</td>
		<td></td><td><td>	
		
	 <!-- Segundo Lireral - 2do. Registro -->	
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg21" size="1" maxlength="1" 
	        value='{$lit2reg21}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg22" size="6" maxlength="6" 
		value='{$lit2reg22}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg31)" onchange="Rellena(document.formarcas2.vlit2reg22,6)">&nbsp;</td>
		</tr><tr>
		
    <!-- Primer Lireral - 3er. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg31" size="1" maxlength="1" 
	        value='{$lit1reg31}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg32" size="6" maxlength="6" 
		value='{$lit1reg32}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.lit2)" onchange="Rellena(document.formarcas2.vlit1reg32,6)">&nbsp;</td>
		
      <td></td><td><td>
      	 	 	
    <!-- Segundo Lireral - 3er. Registro -->	
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg31" size="1" maxlength="1" 
	        value='{$lit2reg31}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg32" size="6" maxlength="6" 
		value='{$lit2reg32}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.comenta)" onchange="Rellena(document.formarcas2.vlit2reg32,6)">&nbsp;</td></tr>			
     </table>
     &nbsp;
     <input type="hidden" name="nderec" value='{$nderec}'>

     <table width="270">
        <tr>
        <td class="cnt"><a href="m_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}"><input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="m_negacion56.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>
