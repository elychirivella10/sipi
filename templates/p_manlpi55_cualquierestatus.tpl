<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="p_manlpi55_cualquierestatus.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='invnac' value={$invnac}> 
  
  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
      &nbsp;	 	     
      </td>	
      <td class="cnt">	 	
	 	<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="p_manlpi55_cualquierestatus.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='dirano' value={$dirano}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='vstring' value='{$vstring}'>
  <input type='hidden' name='vstring1' value='{$vstring1}'>
  <input type='hidden' name='vstring2' value='{$vstring2}'>
  <input type='hidden' name='campos' value='{$campos}'>
  <input type='hidden' name='modo' value={$vmodo}>
  <input type='hidden' name='accion' value={$accion}>
  <input type='hidden' name='auxnum' value={$auxnum}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='vcodpais' value={$vcodpais}>
  <input type='hidden' name='vcodage' value={$vcodage}>
  <input type='hidden' name='psoli' value={$psoli}>
  <input type='hidden' name='nameimage' value={$nameimage}>
  <input type='hidden' name='nroinv' value={$nroinv}>
  <input type='hidden' name='vder' value='{$vder}'> 

  <table cellspacing="1" border="1">
  <!--<tr>-->
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" maxlength="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" ></td>
      <td class="izq3-color" >{$campo5}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" {$modo2} >
          {html_options values=$arraytipom selected=$tipo_paten output=$arraynotip}
        </select>
      </td>
      
      <td class="der-color" rowspan="3" valign="top">
        <input name="ubicacion" {$modo2} type="file"  value='{$ubicacion}' size="28" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="272" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo} cols="57" maxlength="200" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" >
	     <textarea rows="13" name="resumen" {$modo} cols="57" maxlength="8000" onkeyup="this.value=this.value.toUpperCase()">{$resumen}</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" {$modo} value='{$pais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.distingue)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
        <select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$pais_resid output=$arraynompais}
        </select>
<!--      </td>
    </tr> -->
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" {$modo} value='{$tramitante}' size="50" maxlength="40" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
        &nbsp;&nbsp;&nbsp;&nbsp;Poder No.&nbsp;&nbsp;&nbsp; 
        <input type="text" name="vpod1" {$modo} value='{$vpod1}' align="right" size="3" maxlength="4" onchange="Rellena(document.formarcas.vpod1,2)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas2.vpod2)">-
        <input type="text" name="vpod2" {$modo} value='{$vpod2}' align="right" size="4" maxlength="5" onchange="Rellena(document.formarcas.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,2,document.formarcas2.agen_id)">

      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo18}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="anualidad" '{$vmodo}' value='{$anualidad}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.planilla)">
        &nbsp;&nbsp;{$campo19}&nbsp;
        <input type="text" name="planilla" '{$modo}' value='{$planilla}' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.tasa)">
        &nbsp;&nbsp;{$campo20}&nbsp;
        <input type="text" name="tasa" '{$modo}' value='{$tasa}' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.monto)">
        &nbsp;&nbsp;{$campo21}&nbsp;
        <input type="text" name="monto" '{$modo}' value='{$monto}' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.vagent)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
  </table>
 
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo12}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol={$vsol1}-{$vsol2}&pder=P&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
  </table>
  
  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo10}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;
    
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo17}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol={$vsol1}-{$vsol2}&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;

  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo9}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verinven.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vinv" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vinvi" {$modo2} onclick="browseinventorp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.vinvi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vinve" {$modo2} onclick="browseinventorp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.vinve)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;

  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo16}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_vercip.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vcip" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vcipe" {$modo2} onclick="browsecip(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vcip,document.formarcas2.vcipe)"> 
        <br>
    </td></tr> 
  </table>
  &nbsp;

  &nbsp;
  <table width="250" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <a href="p_manlpi55_cualquierestatus.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
    </td>      
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>
