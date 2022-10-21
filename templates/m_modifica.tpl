<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_modifica.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol' value={$vsol}>
  <input type='hidden' name='vreg' value='{$vreg}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>  
  <input type='hidden' name='conx' value='{$conx}'>  
  <input type='hidden' name='salir' value='{$salir}'>  
    
  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    

  <table>
     <tr>
      <td class="izq-color">{$campo1}</td>

	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
                      value='{$registro1}' {$vmodo} onKeyPress="return acceptChar(event,6, this)"  
                      onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		      onChange="this.value=this.value.toUpperCase()">-
            <input type="text" name="vreg2" size="6" maxlength="6" 
		      value='{$registro2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" 
                      onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
                      onchange="Rellena(document.formarcas1.vreg2,6)">
      <td class="cnt"><input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" 
          value="Buscar">Buscar</td>

      <td class="izq-color">Solicitud No.:</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	<input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>

  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_modifica.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='dirano' value={$dirano}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='vreg1' value='{$vreg1}'>
  <input type='hidden' name='vreg2' value='{$vreg2}'>
  <input type='hidden' name='vstring' value='{$vstring}'>
  <input type='hidden' name='vstring1' value='{$vstring1}'>
  <input type='hidden' name='vstring2' value='{$vstring2}'>
  <input type='hidden' name='campos' value='{$campos}'>
  <input type='hidden' name='modo' value={$vmodo}>
  <input type='hidden' name='accion' value={$accion}>
  <input type='hidden' name='auxnum' value={$auxnum}>
  <input type='hidden' name='vclase' value={$vclase}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='vcodpais' value={$vcodpais}>
  <input type='hidden' name='vcodage' value={$vcodage}>
  <input type='hidden' name='psoli' value={$psoli}>
  <input type='hidden' name='nameimage' value={$nameimage}>
  <input type='hidden' name='nconex' value='{$n_conex}'>  
  <input type='hidden' name='conx' value='{$conx}'>
  <input type='hidden' name='salir' value='{$salir}'>  
  <input type='hidden' name='vder' value='{$vder}'>  

  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    
        
  <table cellspacing="2">
    <tr>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.fecha_regis)" onchange="valFecha(this,document.formarcas2.fecha_regis)" ></td>
<td class="der-color" rowspan="6" valign="top">
        <input name="ubicacion" type="file" disabled value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="270" alt="vista previa"/></br>
        <!-- {if $accion neq 2}
          <img src="imagenes/sin_imagen.jpg" id="picture" width="270" height="270" alt="vista previa"/></br>
        {/if}
        {if $vopc eq 4}
          <img src={$nameimage} id="picture" width="270" height="270" alt="vista previa"/></br>
        {/if}
        <!-- {if $accion eq 2}
          <a href='{$nameimage}' target="_blank">
          <img src={$nameimage} id="picture" border="-1" width="270" height="270" alt="vista previa"/></br>
        {/if} -->
      </td>
</tr><tr>
      <td class="izq-color" >Fecha Registro:</td>
      <td class="der-color">
         <input type="text" name="fecha_regis" {$modo} value='{$fecha_regis}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.fecha_venc)" onchange="valFecha(this,document.formarcas2.fecha_venc)" >
         &nbsp;&nbsp;Vencimiento Reg.:&nbsp;
         <input type="text" name="fecha_venc" {$modo} value='{$fecha_venc}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      </td>
</tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" {$modo2} onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)">
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>
    </tr>
    
    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">
      <input type="text" name="vsol3" size="3" maxlength="4" value='{$vsol3}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol4)" onchange="Rellena(document.formarcas2.vsol3,4)">-	
      <input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vsol4,6)">&nbsp;&nbsp;&nbsp; o &nbsp;&nbsp;
        <input type="text" name="vreg1d" size="1" maxlength="1" value='{$vreg1d}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vreg2d" size="6" maxlength="6" value='{$vreg2d}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2d,6)">
      </td>
    </tr>
    
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo} cols="57" maxlength="120" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
       {if $accion neq 2}
        <select size="1" name="options" {$modo3} onchange="this.form.distingue.value=this.options[this.selectedIndex].value">
          {html_options values=$vnomclase output=$vnomclase|truncate:56}
        </select>
        {/if}
        {if $accion eq 2}
          <input type="text" name="vclase" {$modo} value='{$vclase}' size="1" maxlength="2" >
        {/if}
        &nbsp;&nbsp;
        <select size="1" name="clase_id" {$modo2} >
          {html_options values=$arrayvclase selected=$clase_id output=$arraytclase}
        </select>
        &nbsp;&nbsp;&nbsp;&nbsp;{$campo6}&nbsp;&nbsp;
        <select size="1" name="modalidad" {$modo2} onchange="habilitar(document.formarcas2.modalidad,document.formarcas2.nombre,document.formarcas2.etiqueta,document.formarcas2.vviena,document.formarcas2.vvienai,document.formarcas2.vvienae,document.formarcas2.ubicacion)">
          {html_options values=$arrayvmodal selected=$modalidad output=$arraytmodal}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo18}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="vcodest" {$vmodo} value='{$vcodest}' size="2" maxlength="3">
        <input type="text" name="vestatus" {$vmodo} value='{$vestatus}' size="94" maxlength="94">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" colspan="2">
	     <textarea rows="8" name="distingue" {$modo} cols="100">{$distingue}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color" colspan="2">
	     <textarea rows="8" name="etiqueta" {$modo} cols="100" maxlength="8000">{$etiqueta}</textarea>
	   </td>
      	   
    </tr>
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" {$modo} value='{$tramitante}' size="100" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
      </td>
    </tr>

    <tr>
<!--      <td class="izq-color" >{$campo7}</td> -->
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color" colspan="2">
        <input type="hidden" name="input2" {$modo} value='{$pais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.distingue)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">
<!--        -<select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$pais_resid output=$arraynompais}
        </select>
        &nbsp;&nbsp;{$campo11}&nbsp; -->
        <input type="text" name="vpod1" {$modo} value='{$vpod1}' align="right" size="3" maxlength="4" onchange="Rellena(document.formarcas.vpod1,2)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas2.vpod2)">-
        <input type="text" name="vpod2" {$modo} value='{$vpod2}' align="right" size="4" maxlength="5" onchange="Rellena(document.formarcas.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas2.agen_id)">
        
      </td>
    </tr>
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
    </table>
    
    &nbsp;
    <table width="85%">
    <tr><td class="izq2-color">{$campo12}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vageni" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" value="Buscar/Eliminar" name="vagene" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    </table>
  
    &nbsp;
    <table width="85%">
    <tr><td class="izq2-color">{$campo10}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vtitui" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" value="Buscar/Eliminar" name="vtitue" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;
    
    <table width="85%">
    <tr><td class="izq2-color">{$campo17}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

    <table width="85%">
    <tr><td class="izq2-color" colspan="2">{$campo14}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" {$modo} size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" value="Buscar/Incluir"  name="vvienai" {$modo2} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" value="Buscar/Eliminar" name="vvienae" {$modo2} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
    </table>
    &nbsp;

  <table width="180" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1}
          <a href="m_modifica.php?vopc=4&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
          <a href="m_modifica.php?vopc=3&nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>
