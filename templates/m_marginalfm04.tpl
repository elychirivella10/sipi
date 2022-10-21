<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="javascript" src="../include/cal2.js"></script>
    <script language="javascript" src="../include/cal_conf2.js"></script>
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <br> 
  <div align="center">
    <form name="formarcas1" action="m_marginalfm04.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>				  
    <form name="formarcas2" action="m_marginalfm04.php?vopc=2" method="post">
	    <td>{$espacios}</td>
	    <td class="izq5-color">{$lregistro} </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$registro1}' {$vmodo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$registro2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      </table>
      
      &nbsp; 

    <table align="center" width="60%" cellspacing="1" border="0">	
     <tr>
      <td>
      <fieldset>
      <legend align='center' class='Estilo3'><strong><span>DATOS DEL EXPEDIENTE</span></strong></legend>
      
      <table align="center" cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lfecsol}</td>
	       <td class="der-color">
	        <input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>
	        &nbsp;&nbsp;{$lfecreg}&nbsp;&nbsp;<input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}>
	        &nbsp;&nbsp;{$lfecven}&nbsp;&nbsp;<input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}>
	       </td>
	     </tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="90" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$ltipom}</td>
	    <td class="der-color"><input size="25" type="text" name="vtip" value='{$vtip}' {$vmodo}>   
	      &nbsp;{$lclase}<input size="3" type="text" name="vclas" value='{$vclas}' {$vmodo}>
         &nbsp;<input size="15" type="text" name="vindc" value='{$vindc}' {$vmodo}>	    
         &nbsp;{$lmodal}<input size="15" type="text" name="vmodal" value='{$vmodal}' {$vmodo}>	    
	    </td></tr>
	<tr><td class="izq-color">{$lest}</td>
	    <td class="der-color"><input size="3" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="84" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ltitular}</td>
	    <td class="der-color"><input size="7" type="text" name="vcodtit" value='{$vcodtit}' {$vmodo}>
	                <input size="80" type="text" name="vnomtit" value='{$vnomtit}' {$vmodo}></td></tr>
        <tr><td class="izq-color">{$lnacionalidad}</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='{$vnactit}' {$vmodo}>
	                <input size="89" type="text" name="vnadtit" value='{$vnadtit}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ldomicilio}</td>
	    <td class="der-color"><input size="89" type="text" name="vdomtit" value='{$vdomtit}' {$vmodo}></td></tr>
	<tr><td class="izq-color">{$ltrage}</td>
	    <td class="der-color"><input size="89" type="text" name="vtrage" 
	    value="{$vtra|strip}{$vcodage}.{$vnomage}" {$vmodo}></td></tr>
     </table>
     		
     </fieldset>
      </td>
     </tr>
    </table>
     </form>
     
     
     <form name="formarcas3" action="m_marginalfm04.php?vopc=3" method="post" onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='{$vest}'>
     <input type="hidden" name="vcodtit" value='{$vcodtit}'>
     <input type="hidden" name="vnomtit" value='{$vnomtit}'>
     <input type="hidden" name="vnactit" value='{$vnactit}'>
     <input type="hidden" name="vdomtit" value='{$vdomtit}'>
     <input type="hidden" name="vcodage" value='{$vcodage}'>
     <input type="hidden" name="vnomage" value='{$vnomage}'>
     <input type="hidden" name="vtra" value='{$vtra}'>
     <input type="hidden" name="vder" value='{$vder}'>

     <br>

    <table align="center" width="60%" cellspacing="1" border="0">	
     <tr>
      <td>
      <fieldset>
      <legend align='center' class='Estilo3'><strong><span>DATOS DE LA RENOVACION</span></strong></legend>

          
     <table width="100%" cellspacing="1" border="1">
       <tr>
	     <tr>
          <td class="izq-color">{$ldocumento}</td>
	       <td class="der-color">
             <!-- {html_radios name="vseldoc" values=$vdoc_id selected=$vseldoc output=$vdoc_de separator=""}&nbsp;&nbsp; -->
	          <input size="15" type="text" name="vdoc" value='{$vdoc}' maxlength="10" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,10,document.formarcas3.vfecv)">
	       </td>
        </tr>
        <tr>
          <td class="izq-color">{$lfechaven}</td>
	       <td class="der-color">
	         <input size="10" type="text" name="vfecv" onkeyup="checkLength(event,this,10,document.formarcas3.vclasint)" onchange="valFecha(this,document.formarcas3.vclasint)">
            &nbsp;&nbsp;
            <a href="javascript:showCal('Calendar60');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
          </td>
        </tr>
        <tr>
          <td class="izq-color">{$lclaseint}</td>
	       <td class="der-color">
            <input size="2" type="text" name="vclasint" value='{$vclas}' onkeyup="checkLength(event,this,2,document.formarcas3.vcomenta)">
          </td>
        </tr>  
      </table>
        
    &nbsp;
    <table width="100%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$lpropietario}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" {$modo2} onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" {$modo2} onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
        <br>
    </td></tr> 
    </table>


         
     <table cellspacing="1" border="1">
	    <!-- <td class="der-color">
	    <font size="1">Domicilio del Licenciatario, del Sobreviviente o Actual</font>
       </td></tr> 
       <tr><td class="izq-color">{$ldomnew}</td>
	    <td class="der-color"><input size="72" type="text" name="vdomnew"  onchange="this.value=this.value.toUpperCase()"></td></tr>    
	<tr><td class="izq-color">{$lnacnew}</td>
	     <td colspan="2" class="der-color">
        <input type="text" name="input2" value='{$pais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas3.vcodagen)" onchange="valagente(document.formarcas3.input2,document.formarcas3.pais)">-
        <select size="1" name="pais" onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$vcodpai selected=$pais_resid output=$vnompai}
        </select>
      </td>
	    </tr> -->          


	<tr><td class="izq-color">{$lagenew}</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">	    
	    <select size=1 name="vnomagen" onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	        {html_options values=$vcodagenew output=$vnomagenew}
	    <select></td>
	    </tr>        
        <tr><td class="izq-color">{$ltranew}</td>
	    <td class="der-color"><input size="104" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      

        <tr><td class="izq-color">{$lpub}</td>
	    <td class="der-color">
	       {html_radios name="vpub" values=$vpub_id selected=$vpub output=$vpub_de separator=""}
	       &nbsp;&nbsp;{$lboletin}&nbsp;&nbsp;<input size="3" type="text" name="vbol" value='{$vbol}' maxlength="3" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,3,document.formarcas3.vcrono)">  
	    </td></tr>
      </table>
      &nbsp;
           <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'> 
           <input type="hidden" name="vregh" value='{$registro1}{$registro2}'>

     </fieldset>
      </td>
     </tr>
    </table>



     <table width="255">
        <tr>
        <td class="cnt"><a href="m_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}"><input type="image" name="vcrono" src="../imagenes/boton_cronologia_azul.png"></a></td>
        <td class="cnt"><input type="image" name="vgrabar" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="m_marginalfm04.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>


