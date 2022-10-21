<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="javascript" src="../include/cal2.js"></script>
    <script language="javascript" src="../include/cal_conf2.js"></script>
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  <div align="center">
    <form name="formarcas1" action="m_actmargi.php?vopc=2" method="post">
      <table>
        <tr>
          <td class="izq5-color">{$lregistro}</td>
	       <td class="der-color">
             <input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$vreg1}' {$modo1} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
	          <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$vreg2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.tramite)" onchange="Rellena(document.formarcas1.vreg2,6)">&nbsp;&nbsp;</p>
        </tr>
        <tr>
	       <td class="izq5-color">{$ltramite}</td>
          <td class="der-color">
            <select size="1" name="tramite" {$modo1} >
              {html_options values=$arrayvtrami selected=$tramite output=$arrayttrami}
            </select>
          </td>
        </tr>
        <tr>
          <td class="izq5-color">{$lfecharen}</td>
	       <td class="der-color"><input size="9" type="text" name="vfechr" {$modo1} value='{$vfechr}' onkeyup="checkLength(event,this,10,document.formarcas1.vhora)"
	    onchange="valFecha(this,document.formarcas1.vhora)">
           &nbsp;&nbsp;
           <a href="javascript:showCal('Calendar61');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	       <td>
        </tr>
        <tr>
          <td class="izq5-color">{$lhora}</td>
	       <td class="der-color"><input size="7" type="text" name="vhora" {$modo1} value='{$vhora}' onkeyup="checkLength(event,this,8,document.formarcas1.vampm)">&nbsp;
            <select size="1" name="vampm" {$modo1} >
              {html_options values=$hora_id selected=$vampm output=$hora_de}
            </select>
          <td>
        </tr>
        <tr>
	       <td class="izq5-color">{$ldocumento}</td>
	       <td class="der-color">
	         <input size="10" type="text" name="vdoc" value='{$vdoc}' {$modo1} maxlength="10" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,10,document.formarcas1.vbol)">
	       </td>
        </tr>
        <tr>
          <td class="izq5-color">{$lboletin}</td>
	       <td class="der-color">
            <input size="3" type="text" name="vbol" value='{$vbol}' {$modo1} maxlength="3" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,3,document.formarcas1.buscar)">  
	       </td>
  	      <td class="cnt">
  	        <input type='image' name='buscar' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td></p>
        </tr>
      </table>
    </form>			  
    &nbsp;
    <form name="formarcas2" action="m_actmargi.php?vopc=3" method="post">
      <input type="hidden" name="vder" value='{$vder}'>
      <input type="hidden" name="tramite" value='{$tramite}'>
      <input type="hidden" name="vfechr" value='{$vfechr}'>
      <input type="hidden" name="vhora" value='{$vhora}'>
      <input type="hidden" name="vampm" value='{$vampm}'>
      <input type="hidden" name="vdoc" value='{$vdoc}'>
      <input type="hidden" name="vbol" value='{$vbol}'>
      <input type="hidden" name="vregh" value='{$vreg1}{$vreg2}'>
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lsolicitud}</td>
	     <td class="der-color">
	       <input size="10" type="text" name="vsolh" value='{$vsol1}-{$vsol2}' {$vmodo}>
	     </td>
	</tr>
        <tr><td class="izq-color">{$lfecsol}</td>
	       <td class="der-color">
	        <input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>
	        &nbsp;&nbsp;{$lfecreg}&nbsp;&nbsp;<input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}>
	        &nbsp;&nbsp;{$lfecven}&nbsp;&nbsp;<input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}>
	       </td>
	     </tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="73" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$ltipom}</td>
	    <td class="der-color"><input size="25" type="text" name="vtip" value='{$vtip}' {$vmodo}>   
	      &nbsp;{$lclase}<input size="1" type="text" name="vclas" value='{$vclas}' {$vmodo}>
         &nbsp;<input size="12" type="text" name="vindc" value='{$vindc}' {$vmodo}>	    
         &nbsp;{$lmodal}<input size="12" type="text" name="vmodal" value='{$vmodal}' {$vmodo}>	    
	    </td></tr>
	<tr><td class="izq-color">{$lest}</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ltitular}</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='{$vcodtit}' {$vmodo}>
	                <input size="63" type="text" name="vnomtit" value='{$vnomtit}' {$vmodo}></td></tr>
        <tr><td class="izq-color">{$lnacionalidad}</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='{$vnactit}' {$vmodo}>
	                <input size="67" type="text" name="vnadtit" value='{$vnadtit}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ldomicilio}</td>
	    <td class="der-color"><input size="73" type="text" name="vdomtit" value='{$vdomtit}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ltrage}</td>
	    <td class="der-color"><input size="73" type="text" name="vtrage" 
	    value="{$vtra|strip}{$vcodage}.{$vnomage}" {$vmodo}></td></tr>
	    
    </table>		
    &nbsp;
    <table cellspacing="1" border="1">
       <tr><td class="izq-color">{$lfechaven}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecv" {$vmodo}>&nbsp;&nbsp;&nbsp;
	    {$lclaseint}&nbsp;&nbsp;<input size="1" type="text" name="vclasint" {$vmodo} value='{$vclasint}'>
	    &nbsp;<font size="1">Vencimiento y Clase / Solo para Renovaciones</font>&nbsp;<td></tr>  
       <tr><td class="izq-color"></td>
	    <td class="der-color">
	    <font size="1">{$lfusion}</font>
       </td></tr> 

	    <tr><td class="izq-color">{$lcomenta}</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" {$vmodo} cols="92" onKeyup="this.value=this.value.toUpperCase()">{$vcomenta}</textarea></td></tr>

       <tr><td class="izq-color"></td>
	    <td class="der-color">
       </td></tr> 

       <tr><td class="izq-color">{$ldomant}</td>
	    <td class="der-color"><input size="92" type="text" name="vdomant" {$vmodo}  value='{$vdomant}'></td></tr>    
      </table>
      
    <br />
    <table width="85%">
      <tr><td class="izq4-color">{$lpropietario}</td>
    </table>
    <table width="85%" cellspacing="1" border="1">
     <tr><td class="izq-color">{$lnomtit}</td>
	 <td class="der-color"><textarea rows="2" name="vcomenta" cols="105" {$vmodo}>{$vnewtit}</textarea></td></tr>
     <tr><td class="izq-color"></td>
	 <td class="der-color">
     </td></tr> 
     <tr><td class="izq-color">{$ldomnew}</td>
	 <td class="der-color"><input size="105" type="text" name="vdomtit" {$vmodo} value='{$vdomtit}'></td></tr>    
     <tr><td class="izq-color">{$ltranew}</td>
         <td class="der-color"><input size="104" type="text" name="vtraf" {$vmodo} value='{$vtraf}'  onchange="this.value=this.value.toUpperCase()"></td></tr>      

    </table>
         
      &nbsp;
     <table width="255">
        <tr>
        <td class="cnt"><a href="m_rptcronol.php?vsol1={$vsol1}&vsol2={$vsol2}"><input type="image" name="vcrono" src="../imagenes/boton_cronologia_azul.png"></a></td>
        <td class="cnt"><input type="image" name="veliminar" src="../imagenes/boton_eliminar_rojo.png" value="Eliminar"></td> 
        <td class="cnt"><a href="m_actmargi.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


