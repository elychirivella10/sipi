<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

{if $vopc eq 3}
<form name="formarcas1" action="m_ingresol.php?vopc=4" method="POST">
{/if}
  <input type='hidden' name='conx' value='{$conx}'>  
  <input type='hidden' name='salir' value='{$salir}'>

  <table>
  <tr> 
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td>	
      <td class="cnt">
      {if $vopc eq 3}
        <!-- &nbsp;<input type="submit" value=" Nueva Solicitud " class="boton_blue"> -->
        &nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </form>
      {/if} 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="m_ingresol.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='dirano' value={$dirano}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='vsol1a' value={$vsol1a}>
  <input type='hidden' name='vsol2a' value={$vsol2a}>
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
  <input type='hidden' name='conx' value='{$conx}'>  
  <input type='hidden' name='salir' value='{$salir}'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq3-color" >{$campo15}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" {$modo2} onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)" >
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>

      <!-- <td class="der-color" rowspan="9" valign="top">
        <input name="ubicacion" type="file" value='{$ubicacion}' {$modo2} size="27" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="264" alt="vista previa"/></br>
      </td> -->

      <td class="der-color" rowspan="9" valign="top">

        <table width="100%" cellspacing="1" border="1">
          <tr><td>
            <iframe id='top' style='width:100%;height:250px;background-color: WHITE;' src="../comun/z_verimagen.php?psol={$vsol1}-{$vsol2}"></iframe> 
          </td></tr>  
        </table>
        {$campo23}
        <input type="text" name="planilla" size="5" maxlength="6" {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.buscarimg)">&nbsp;
        <input type="button" class="boton_blue" {$modo2} value="Buscar" name="buscarimg" onclick="buscarimagen(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.planilla)">
        <input type="button" class="boton_blue" {$modo2} value="Eliminar" name="eliminaimg" onclick="limpiarplan(document.formarcas2.planilla);limpiarimagen(document.formarcas2.vsol1,document.formarcas2.vsol2)"">
      </td>

    </tr>
    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">
        {$campo21}
        <input type="text" name="vsol3" size="4" maxlength="4" value='{$vsol3}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol4)" onchange="Rellena(document.formarcas2.vsol3,4)">-	
        <input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vreg1d)" onchange="Rellena(document.formarcas2.vsol4,6)">&nbsp;&nbsp; o 
        {$campo22}
        <input type="text" name="vreg1d" size="1" maxlength="1" value='{$vreg1d}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vreg2d" size="6" maxlength="6" value='{$vreg2d}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.nombre)" onchange="Rellena(document.formarcas2.vreg2d,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo} cols="52" maxlength="200" onchange="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <select size="1" name="modalidad" {$modo2} onchange="habilitar(document.formarcas2.modalidad,document.formarcas2.nombre,document.formarcas2.etiqueta,document.formarcas2.vviena,document.formarcas2.vvienai,document.formarcas2.vvienae,document.formarcas2.ubicacion)">
          {html_options values=$arrayvmodal selected=$modalidad output=$arraytmodal}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><b>{$campo9}</b></td>
      <td class="der-color">
         <textarea rows="6" name="etiqueta" {$modo} cols="52" maxlength="6000" onchange="this.value=this.value.toUpperCase()">{$etiqueta}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
       {if $accion eq 2}
        <select size="1" name="options" {$modo3}  onchange="this.form.distingue.value=this.options[this.selectedIndex].value">
        <!-- <select size="1" name="options" {$modo3} > -->
          {html_options values=$vnomclase output=$vnomclase|truncate:56}
        </select>
        {/if}
        {if $accion neq 2}
          <input type="text" name="vclase" {$modo} value='{$vclase}' size="1" maxlength="2" >
        {/if}
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo20}</td>
      <td class="der-color">
        <input type="text" name="vclnac" {$modo} value='{$vclnac}' size="1" maxlength="2" >
        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$campo21}&nbsp;&nbsp;
        <input type="text" name="planilla" {$modo} value='{$planilla}' size="5" maxlength="6" > -->
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><b>{$campo8}</b></td>
      <td class="der-color" colspan="2">
         <textarea rows="8" name="distingue" {$modo} cols="96" onchange="this.value=this.value.toUpperCase()">{$distingue}</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" {$modo} value='VE' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
<!--        <select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$pais_resid output=$arraynompais}
        </select>
     </td>
    </tr>  -->
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" {$modo} value='{$tramitante}' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
        &nbsp;&nbsp;&nbsp;{$campo11}&nbsp;
        <input type="text" name="vpod1" {$modo} value='{$vpod1}' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" {$modo} value='{$vpod2}' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" colspan="2"></td>
    </tr>
    <tr>
    </tr>
      
  </tr>
  </table></center>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo12}</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol={$vsol1}-{$vsol2}&pder=M&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    </table>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo10}</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;
    
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo17}</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo14}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" {$modo} size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" {$modo2} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" {$modo2} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
    </table>
    &nbsp;

  <!-- <table align="center">
  <tr>
    <td class="cnt">
      <input type="submit" value=" GUARDAR " class="boton_azul"></td>
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingresol.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><input type="button" value=" CANCELAR " class="boton_rojo"></a>
      {/if}    
      {if $vopc eq 3 || $vopc eq 4}
         <a href="m_ingresol.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><input type="button" value=" CANCELAR " class="boton_rojo"></a>
      {/if}    
    </td>      
    <td class="cnt">
      <a href="../salir.php?nconex={$n_conex}"><input type="button" value=" SALIR " class="boton_azul"></td></a>
    </td>
  </tr>
  </table>-->

  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingresol.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 3 || $vopc eq 4}
         <a href="m_ingresol.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
    </td>      
    <td class="cnt">
         <a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>




</form>
</div>  

</body>
</html>
