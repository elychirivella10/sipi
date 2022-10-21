<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3> -->
  
  <div align="center">
    <form name="formarcas1" action="m_amrenova_original.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>				  
    <form name="formarcas2" action="m_amrenova_original.php?vopc=2" method="post">
	    <td>{$espacios}</td>
	    <td class="izq5-color">{$lregistro} </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$registro1}' {$vmodo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$registro2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
<!--		<td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td> -->
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lfecsol}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lfecreg}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lfecven}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="72" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ltrage}</td>
	    <td class="der-color"><input size="72" type="text" name="vtrage" value="{$vtra|strip}{$vcodage}.{$vnomage}" {$vmodo}></td></tr>
     </table>		

     </form>
     <form name="formarcas3" action="m_amrenova_original.php?vopc=3" method="post" onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='{$vest}'>
     <input type="hidden" name="vcodtit" value='{$vcodtit}'>
     <input type="hidden" name="vnomtit" value='{$vnomtit}'>
     <input type="hidden" name="vfecven" value='{$vfecven}'>
     <input type="hidden" name="vcodage" value='{$vcodage}'>
     <input type="hidden" name="vnomage" value='{$vnomage}'>
     <input type="hidden" name="vtra" value='{$vtra}'>
     <input type="hidden" name="vderh" value='{$vderh}'>
     <table cellspacing="1" border="1">
        <tr><td class="izq-color">{$lfechaevento}</td>
	    <td class="der-color"><input size="9" type="text" name="vfevh"  onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	    onchange="valFecha(this,document.formarcas3.vdoc)"><td></tr>
<!-- 	    <td>{$espacios}</td> -->
	    <tr><td class="izq-color">{$ldocumento}</td>
	    <td class="der-color"><input size="7" type="text" name="vdoc" value='{$vdoc}' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,7,document.formarcas3.input1)"></td></tr>
<!--       </table>
        &nbsp;     
     <table> -->
        <tr><td class="izq-color">{$lagenew}</td> 
        <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">	    
	    <select size=1 name="vnomagen" onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	        {html_options values=$vcodagenew output=$vnomagenew}
	    </select></td>
       <!--
	    <td class="der-color"><input size="30" type="text" name="input1" value="" onkeyup="this.value=this.value.toUpperCase();autoComplete(this,this.form.options,'value',true)" onchange="valagente(document.formarcas3.options,document.formarcas3.input1)">	    
	    <select size=1 name="options" onchange= "this.form.input1.value=this.options[this.selectedIndex].value">
	        {html_options values=$vnomagenew output=$vnomagenew}
	    </select></td> -->
	    </tr>        	
        <tr><td class="izq-color">{$ltranew}</td>
	    <td class="der-color"><input size="72" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      
        <tr><td class="izq-color">{$lcomenta}</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" cols="75" onchange="this.value=this.value.toUpperCase()"></textarea></td></tr>
      </table>
      &nbsp;
           <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'> 
           <input type="hidden" name="vregh" value='{$registro1}{$registro2}'>
      <br>
     <table width="235">
      <tr>
       <td class="cnt"><a href="m_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}&vreg1={$registro1}&vreg2={$registro2}"><input type="image" src="../imagenes/boton_cronologia_azul.png"></a></td>
       <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
       <td class="cnt"><a href="m_amrenova_original.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
       <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


