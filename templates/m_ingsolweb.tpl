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
<form name="formarcas1" action="m_ingsolweb.php?vopc=4" method="POST">
{/if}

  <table>
  <tr> 
    <tr>
      <!-- <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td> -->	
      <td class="cnt">
      {if $vopc eq 3}
      &nbsp;<input type="image" src="../imagenes/folder_add_f2.png" width="32" height="24" value="Nueva Solicitud">Nueva Solicitud
      </form>
      {/if} 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="m_ingsolweb.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='dirano' value={$dirano}>
  <input type='hidden' name='vexp' value={$vexp}>
  <input type='hidden' name='vsol1' value={$vsol1}>
 <!-- <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='vsol1a' value={$vsol1a}>
  <input type='hidden' name='vsol2a' value={$vsol2a}> -->
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
  <input type='hidden' name='vtipper' value={$vtipper}> 
  <input type='hidden' name='vtipage' value='{$vtipage}'> 

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
      <td class="der-color" rowspan="9" valign="top">
        <input name="ubicacion" type="file" value='{$ubicacion}' {$modo2} size="25" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="286" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">

      <input type="text" name="vsol3" size="4" maxlength="4" value='{$vsol3}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol4)" onchange="Rellena(document.formarcas2.vsol3,4)">-	
      <input type="text" name="vsol4" size="6" maxlength="6" value='{$vsol4}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vreg1d)" onchange="Rellena(document.formarcas2.vsol4,6)">&nbsp;&nbsp;&nbsp; o &nbsp;&nbsp;

        <input type="text" name="vreg1d" size="1" maxlength="1" value='{$vreg1d}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vreg2d" size="6" maxlength="6" value='{$vreg2d}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.nombre)" onchange="Rellena(document.formarcas2.vreg2d,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo} cols="57" maxlength="200" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
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
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
         <textarea rows="6" name="etiqueta" {$modo} cols="57" maxlength="6000">{$etiqueta}</textarea>
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
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Asociar Clase Nacional" name="vbusdat" onclick="b_busqueda(document.all.vsol1,document.all.options,document.all.tipo_marca)" class="boton_blue">
      </td>
    </tr>
   <!-- <tr>
      <td class="izq-color" >{$campo20}</td>
      <td class="der-color">
        <input type="text" name="vclnac" {$modo} value='{$vclnac}' size="1" maxlength="2" >
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" >{$campo20}</td>
      <td class="der-color">
       <iframe id='top' frameborder='0' style='width:100%;height:40px;background-color:WHITE;' src="../comun/z_verbusqueda.php?psol={$vsol1}"></iframe>
      </td>
    </tr>

    <!--<tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" colspan="2">
         <textarea rows="3" name="distingue" {$modo} cols="97">{$distingue}</textarea>
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" colspan="2">
        <iframe name='productos' frameborder='0' style='width:100%;height:160px;background-color:WHITE;' src="../comun/z_verproductos.php?psol={$vsol1}"></iframe>
      </td>
    </tr> 
    <!-- <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name="input2" {$modo} value='{$pais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
        <select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$pais_resid output=$arraynompais}
        </select>
      </td>
    </tr> --> 
    <tr>
      <td class="izq-color" >{$campo21}</td>
      <td class="der-color" colspan="2">
          <input type="radio" name="group3" value="Nacional" {$modo2} onchange="visible_pai(this.value);" {$checkpaisn}>Nacional
          <input type="radio" name="group3" value="Extranjero" {$modo2} onchange="visible_pai(this.value);" {$checkpaise}>Extranjero
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAIS:
          <select size="1" name="vpap" STYLE="{$checkdespaise}"
                  onchange="this.form.vpap.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$vpaisor output=$arraynompais}
          </select>
          <input type='text' name='vpav' size='20' STYLE="{$checkdespaisn}" value="VENEZUELA" readonly="readonly">
      </td>
    </tr>
    <!-- <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="vpod1" {$modo} value='{$vpod1}' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas2.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" {$modo} value='{$vpod2}' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr>  
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" colspan="2"></td>
    </tr> -->
    <tr>
    </tr>
      
  </tr>
  </table></center>

   &nbsp;
    <table width="86%" border="1">
    <tr><td class="izq4-color">{$campo13}</td></tr>
    <tr><td class="der-color">
          <label for="reg_part2">TIPO:</label>
          <input type="radio" name="rtipoage" value="2" 
                 onchange="visible_age(this.value);" onclick="valagente(this,document.formarcas2.vtipage);"> Tramitante 
          <input type="radio" name="rtipoage" value="3" 
                 onchange="visible_age(this.value);" onclick="valagente(this,document.formarcas2.vtipage);"> Apoderado 
          &nbsp;&nbsp;C&eacute;dula:
          <select size="1" name="lcedtra" id="lcedtra" onchange="visible_cedtra(this.value);">
             <option VALUE="V" selected>V</option>
             <option VALUE="E">E</option> 
             <option VALUE="P">P</option> 
          </select>
          <input type="text" name="vcedtra" size="8" maxlength="9" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">
          <input type="text" name="vpastra" size="14" maxlength="14" STYLE="display:none">   
        <input type="button" class="boton_blue" value="Buscar" name="vtrami" {$modo2} onclick="browsetramitante(document.formarcas2.vsol1,document.formarcas2.vtipage,document.formarcas2.lcedtra,document.formarcas2.vcedtra,document.formarcas2.vpastra)">
        <br>
    </td></tr> 
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol={$vsol1}&pder=M"></iframe>  
    </td></tr>  
    </table>
  
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo12}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol={$vsol1}&pder=M&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar"  name="vageni" {$modo2} onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vagent,document.formarcas2.vageni)">
        <br>
    </td></tr> 
    </table>
  
    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo10}</td></tr>
   <tr><td colspan="2" class="izq8-color">
          <label for="reg_part">INDOLE:</label>
          <input type="radio" name="rtipoper" value="1" checked  
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Persona Natural 
          <input type="radio" name="rtipoper" value="2" 
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Cooperativa 
          <input type="radio" name="rtipoper" value="3" 
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Persona Jur&iacute;dica Nacional 
          <input type="radio" name="rtipoper" value="4" 
                 onchange="visible_per(this.value);" onclick="valagente(this,document.formarcas2.vtipper);"> Persona Jur&iacute;dica Extranjera
   </td></tr>

   <tr><td colspan="2" class="izq8-color">
          <p id="tpernat" STYLE="display:inline">C&eacute;dula:</p>
          <select size="1" name="lcedtit" id="lcedtit" STYLE="display:inline" onchange="visible_pas(this.value);">
             <option VALUE="V" selected>V</option>
             <option VALUE="E">E</option> 
             <option VALUE="P">P</option> 
          </select>
          <input type="text" name="vcedtit" size="8" maxlength="9" STYLE="display:inline" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">
          <input type="text" name="vpastit" size="14" maxlength="14" STYLE="display:none">    
          <p id="tperjurn" STYLE="display:none">Rif:</p>
          <select size="1" name="lriftit" id="lriftit" STYLE="display:none">
             <option VALUE="J" selected>J</option>
          </select>
          <input type="text" name="vriftit" size="9" maxlength="9" STYLE="display:none" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">  
          <p id="tperjure" STYLE="display:none">Nombre de la Empresa:</p>
          <input type="text" name="vnomtit" size="35" STYLE="display:none" onkeyup="this.value=this.value.toUpperCase();">  
          <input type="button" class="boton_blue" value="Buscar"  name="vtitui" {$modo2} onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vtipper,document.formarcas2.lcedtit,document.formarcas2.vcedtit,document.formarcas2.vpastit,document.formarcas2.lriftit,document.formarcas2.vriftit,document.formarcas2.vnomtit,document.formarcas2.vtitui)">
   </td></tr> 
   
    
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}&pder=M"></iframe> 
    </td></tr>  
    </table>
    &nbsp;
    
    <!-- <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo17}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol={$vsol1}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp; -->

    <!-- <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo14}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" {$modo} size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" {$modo2} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" {$modo2} onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
    </table>
    &nbsp; -->

  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingsolweb.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3 || $vopc eq 4}
         <a href="m_ingsolweb.php?vopc=3&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt">
         <a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
