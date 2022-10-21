<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="p_cambagtr.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$solicitud1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$solicitud2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
		
    </form>				  
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lfecsol}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>   </td>
	    {if $vmod eq "G" || $vmod eq "M"}
        <td class="der-color" rowspan="4" align="left" valign="top">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="110">
        </td>
      {/if}</tr>
	<tr><td class="izq-color">{$lfecreg}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lfecven}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="72" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td></tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td colspan="2" class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td></tr>
        <tr><td class="izq-color">Tramitante Actual:</td>
	    <td colspan="2" class="der-color"><input size="72" type="text" name="vtrage" 
                value="{$vtra|strip}" {$vmodo}></td></tr>
      <tr><td class="izq-color">Agente(s) Actual(es):</td>
          <td class="izq2-color">
      <iframe id='center' style='width:100%;height:80px;background-color: WHITE;' 
              src='exampleage.php?psol={$vsol}&ptip=I&ptip2=P'></iframe> 
      </td></tr>   
      </table> 
     </form>
     <form name="formarcas3" action="p_cambagtr.php?vopc=3" method="post" onsubmit='return pregunta();'>
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
	    <td class="der-color"><input size="9" type="text" name="vfevh"   onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	    onchange="valFecha(this,document.formarcas3.vdoc)"><td>  </tr>
	    <tr><td class="izq-color">{$ldocumento}</td>
	    <td class="der-color"><input size="8" type="text" name="vdoc" value='{$vdoc}' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,9,document.formarcas3.vcodagen)"></td></tr>
     &nbsp; 
<tr><td class="izq-color">{$ltranew}</td>
	    <td class="der-color"><input size="72" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      
        <tr><td class="izq-color" >Agente(s) Nuevo(s):</td>
      <td class="izq2-color">
      <iframe id='center' style='width:100%;height:80px;background-color: WHITE;' 
              src='exampleage.php?psol={$vsol}&ptip=P&ptip2=P'></iframe> 
      </td></tr><tr>
      <td class="izq-color"> </td>   
      <td class="der-color">
      <input type="text" name="vpodet" {$modo} size="35" 
          onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Buscar/Incluir" {$modo2} name="vpodei" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodei)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" {$modo2} name="vpodee" 
          onclick="browsepoderhabi(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vpodet,document.formarcas3.vpodee)"> 
      </table>     
      &nbsp;
           <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'> 
           <input type="hidden" name="vregh" value='{$registro1}{$registro2}'>
     <br/>
     <table width="225">
        <tr> 
<!--   <td class="cnt"><a href="m_cronolo.php?vsol={$solicitud1}-{$solicitud2}">  -->
       <td class="cnt"><a href="p_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}">
        <input type="image" src="../imagenes/folder_f2.png"></a> Cronologia </td>
        <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td> 
    <td class="cnt"><a href="p_cambagtr.php"><img src="../imagenes/cancel_f2.png" border="0"></a> Cancelar </td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>	Salir </td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

