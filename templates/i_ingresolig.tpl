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
<form name="formarcas1" action="i_ingresolig.php?vopc=4" method="POST">
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
<form name="formarcas2" enctype="multipart/form-data" action="i_ingresolig.php?vopc=2" method="POST" onsubmit='return pregunta();'>
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

  <table width="970px" cellspacing="1" border="1">
    <tr>
      <td class="izq-color" >Fecha de la Solicitud:</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo}  size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
      <td class="izq-color" >Tipo de Solicitud:</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" {$modo2}>
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>
    </tr>   
  </table>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">1.- DATOS DEL SOLICITANTE:</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=I"></iframe> 
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
    <tr><td class="izq4-color">2.- DATOS DEL REPRESENTANTE LEGAL:</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_verrepre.php?psol={$vsol1}-{$vsol2}&pder=I"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut2" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui2" {$modo2} onclick="browserepre(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut2,document.formarcas2.vtitui2)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue2" {$modo2} onclick="browserepre(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut2,document.formarcas2.vtitue2)"> 
        <br>
    </td></tr> 
    </table>

    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">3.- DATOS DEL APODERADO:</td></tr>
    <tr>                        
      <td class="izq-color" >Poder:</td>
      <td class="der-color">
        <input type="text" name="vpod1" {$modo} value='{$vpod1}' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" {$modo} value='{$vpod2}' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr>
    <tr><td colspan="2">
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol={$vsol1}-{$vsol2}&pder=I&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color" colspan="2">
        <input type="text" name="vagent" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    <tr>
      <td class="izq-color" >Tramitante:</td>
      <td class="der-color">
        <input type="text" name="tramitante" {$modo} value='{$tramitante}' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
      </td>
    </tr>
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">4.- INDICACION GEOGRAFICA (IG):</td></tr>
    <tr>
      <td class="izq-color" ><b>Nombre de la IG:</b></td>
      <td class="der-color">
         <textarea rows="2" name="nombreig" {$modo} cols="90" onchange="this.value=this.value.toUpperCase()">{$nombreig}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><b>Productos designados por la IG:</b></td>
      <td class="der-color">
         <textarea rows="2" name="productosig" {$modo} cols="90" onchange="this.value=this.value.toUpperCase()">{$productosig}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">5.- ZONA GEOGRAFICA:</td></tr>
    <tr>
      <td class="izq-color" ><b>Definici&oacute;n de la Zona Geogr&aacute;fica:</b></td>
      <td class="der-color">
         <textarea rows="4" name="zonag" {$modo} cols="90">{$zonag}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;     
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">6.- REGISTRO DE IG/DO EXTRANJERO:</td></tr>
    <tr><td colspan="2">
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol={$vsol1}-{$vsol2}&pder=I"></iframe> 
    </td></tr>  
    <tr><td colspan="2"class="der-color">
        <input type="text" name="vprior" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    <tr>
      <td class="izq-color" ><b>Tratado Internacional ratificado por Vzla:</b></td>
      <td class="der-color">
         <textarea rows="2" name="tratado" {$modo} cols="80">{$tratado}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">8.- DESCRIPCION DETALLADA DEL PRODUCTO DESIGNADO CON LA INDICACION GEOGRAFICA (IG):</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="distingue" {$modo} cols="115">{$distingue}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">9.- DESCRIPCION DE LA ZONA GEOGRAFICA:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="deszonag" {$modo} cols="115">{$deszonag}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">10.- VINCULO DEL PRODUCTO CON EL TERRITORIO:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="vinculo" {$modo} cols="115">{$vinculo}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">11.- OBSERVACIONES:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="observa" {$modo} cols="115">{$observa}</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="i_ingresolig.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 3 || $vopc eq 4}
         <a href="i_ingresolig.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
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
