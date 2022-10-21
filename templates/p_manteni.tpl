<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="p_manteni.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='invnac' value={$invnac}> 
  
  <table>
     <tr>
      <td class="izq-color">{$campo1}</td>
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

<form name="formarcas2" enctype="multipart/form-data" action="p_manteni.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='dirano' value={$dirano}>
  <input type ='hidden' name='vsol1' value={$vsol1}>
  <input type ='hidden' name='vsol2' value={$vsol2}>
  <input type ='hidden' name='vstring' value='{$vstring}'>
  <input type ='hidden' name='vstring1' value='{$vstring1}'>
  <input type ='hidden' name='vstring2' value='{$vstring2}'>
  <input type ='hidden' name='campos' value='{$campos}'>
  <input type ='hidden' name='modo' value={$vmodo}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='varsol' value={$varsol}>
  <input type ='hidden' name='vcodpais' value={$vcodpais}>
  <input type ='hidden' name='vcodage' value={$vcodage}>
  <input type ='hidden' name='psoli' value={$psoli}>
  <input type ='hidden' name='nameimage' value={$nameimage}>
  <input type ='hidden' name='nroinv' value={$nroinv}>

  <table cellspacing="2">
  <!--<tr>-->
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" maxlength="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" ></td>
      <td class="izq2-color" >{$campo15}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" {$modo2} >
          {html_options values=$arraytipom selected=$tipo_paten output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="3" valign="top">
        <input name="ubicacion" {$modo2} type="file"  value='{$ubicacion}' size="20" onchange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="270" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" {$modo} cols="57" maxlength="200" onchange="this.value=this.value.toUpperCase()">{$nombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color" >
	     <textarea rows="13" name="resumen" {$modo} cols="57" maxlength="8000" onchange="this.value=this.value.toUpperCase()">{$resumen}</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="input2" {$modo} value='{$pais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.distingue)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
        <select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$pais_resid output=$arraynompais}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="input1" {$modo} value='{$vcodage}' size="5" maxlength="6" onKeypress="return acceptChar(even,2, this)" onchange="valagente(document.formarcas2.input1,document.formarcas2.vnomage)">-
        <select size="1" name="vnomage" {$modo2} onchange="this.form.input1.value=this.options[this.selectedIndex].value">
          {html_options values=$vcodagenew selected=$vcodage output=$vnomagenew}
        </select>
      </td>
    </tr> 
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
      <td class="izq-color" >{$campo17}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="vnprior" size="10" maxlength="10" 
	        value='{$vnprior}' {$modo} onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,15,document.formarcas2.vfechaprior)">&nbsp;&nbsp;&nbsp;de Fecha&nbsp;&nbsp;
	     <input type="text" name="vfechaprior" size="10" align="left" 
	 	     value='{$vfechaprior}' {$modo} onkeyup="checkLength(event,this,10,document.formarcas2.vpaisprior)" onchange="valFecha(this,document.formarcas2.vpaisprior)">&nbsp;&nbsp;&nbsp;Pais&nbsp;&nbsp;
        <input type="text" name="vpaisprior" {$modo} value='{$vpais_prior}' size="2" maxlength="2" onkeyup="this.value=this.value.toUpperCase()" onChange="valagente(document.formarcas2.vpaisprior,document.formarcas2.pais1)"> - 
        <select size="1" name="pais1" {$modo2} onchange="this.form.vpaisprior.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$vpais_prior output=$arraynompais}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
        <input type="text" name="vnprior1" size="10" maxlength="10" 
	        value='{$vnprior1}' {$modo} onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,15,document.formarcas2.v1fechaprior)">&nbsp;&nbsp;&nbsp;de Fecha&nbsp;&nbsp;
	     <input type="text" name="v1fechaprior" size="10" align="left" 
	 	     value='{$v1fechaprior}' {$modo} onkeyup="checkLength(event,this,10,document.formarcas2.v1paisprior)" onchange="valFecha(this,document.formarcas2.v1paisprior)">&nbsp;&nbsp;&nbsp;Pais&nbsp;&nbsp;
        <input type="text" name="v1paisprior" {$modo} value='{$v1pais_prior}' size="2" maxlength="2" onkeyup="this.value=this.value.toUpperCase()" onChange="valagente(document.formarcas2.v1paisprior,document.formarcas2.pais2)"> - 
        <select size="1" name="pais2" {$modo2} onchange="this.form.v1paisprior.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$v1pais_prior output=$arraynompais}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
        <input type="text" name="vnprior2" size="10" maxlength="10" 
	        value='{$vnprior2}' {$modo} onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,15,document.formarcas2.v2fechaprior)">&nbsp;&nbsp;&nbsp;de Fecha&nbsp;&nbsp;
	     <input type="text" name="v2fechaprior" size="10" align="left" 
	 	     value='{$v2fechaprior}' {$modo} onkeyup="checkLength(event,this,10,document.formarcas2.v2paisprior)" onchange="valFecha(this,document.formarcas2.v2paisprior)">&nbsp;&nbsp;&nbsp;Pais&nbsp;&nbsp;
        <input type="text" name="v2paisprior" {$modo} value='{$v2pais_prior}' size="2" maxlength="2" onkeyup="this.value=this.value.toUpperCase()" onChange="valagente(document.formarcas2.v2paisprior,document.formarcas2.pais3)"> - 
        <select size="1" name="pais3" {$modo2} onchange="this.form.v2paisprior.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$v2pais_prior output=$arraynompais}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
        <input type="text" name="vnprior3" size="10" maxlength="10" 
	        value='{$vnprior3}' {$modo} onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,15,document.formarcas2.v3fechaprior)">&nbsp;&nbsp;&nbsp;de Fecha&nbsp;&nbsp;
	     <input type="text" name="v3fechaprior" size="10" align="left" 
	 	     value='{$v3fechaprior}' {$modo} onkeyup="checkLength(event,this,10,document.formarcas2.v3paisprior)" onchange="valFecha(this,document.formarcas2.v3paisprior)">&nbsp;&nbsp;&nbsp;Pais&nbsp;&nbsp;
        <input type="text" name="v3paisprior" {$modo} value='{$v3pais_prior}' size="2" maxlength="2" onkeyup="this.value=this.value.toUpperCase()" onChange="valagente(document.formarcas2.v3paisprior,document.formarcas2.pais4)"> - 
        <select size="1" name="pais4" {$modo2} onchange="this.form.v3paisprior.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$v3pais_prior output=$arraynompais}
        </select>
      </td>
    </tr>

    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2">
      </td>
    </tr>
  </table>
    
  <!-- <table width="89%">
    <tr>
      <td class="izq-color">{$campo9}</td>
      <td class="der-color">
        <input type="text" name="inventor1" {$modo} value='{$inventor1}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac1" {$modo} value='{$paisinv1}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor2)" onchange="valagente(document.formarcas2.invnac1,document.formarcas2.invpais1)"> -
        <select size="1" name="invpais1" {$modo2} onchange="this.form.invnac1.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv1 output=$arraynompais}
        </select>
        <input type="text" name="inventor2" {$modo} value='{$inventor2}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac2" {$modo} value='{$paisinv2}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor3)" onchange="valagente(document.formarcas2.invnac2,document.formarcas2.invpais2)"> -
        <select size="1" name="invpais2" {$modo2} onchange="this.form.invnac2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv2 output=$arraynompais}
        </select>
        <input type="text" name="inventor3" {$modo} value='{$inventor3}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac3" {$modo} value='{$paisinv3}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor4)" onchange="valagente(document.formarcas2.invnac3,document.formarcas2.invpais3)"> -
        <select size="1" name="invpais3" {$modo2} onchange="this.form.invnac3.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv3 output=$arraynompais}
        </select>
        <input type="text" name="inventor4" {$modo} value='{$inventor4}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac4" {$modo} value='{$paisinv4}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor5)" onchange="valagente(document.formarcas2.invnac4,document.formarcas2.invpais4)"> -
        <select size="1" name="invpais4" {$modo2} onchange="this.form.invnac4.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv4 output=$arraynompais}
        </select>
        <input type="text" name="inventor5" {$modo} value='{$inventor5}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac5" {$modo} value='{$paisinv5}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor6)" onchange="valagente(document.formarcas2.invnac5,document.formarcas2.invpais5)"> -
        <select size="1" name="invpais5" {$modo2} onchange="this.form.invnac5.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv5 output=$arraynompais}
        </select>
        <input type="text" name="inventor6" {$modo} value='{$inventor6}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac6" {$modo} value='{$paisinv6}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor7)" onchange="valagente(document.formarcas2.invnac6,document.formarcas2.invpais6)"> -
        <select size="1" name="invpais6" {$modo2} onchange="this.form.invnac6.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv6 output=$arraynompais}
        </select>
        <input type="text" name="inventor7" {$modo} value='{$inventor7}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac7" {$modo} value='{$paisinv7}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor8)" onchange="valagente(document.formarcas2.invnac7,document.formarcas2.invpais7)"> -
        <select size="1" name="invpais7" {$modo2} onchange="this.form.invnac7.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv7 output=$arraynompais}
        </select>
        <input type="text" name="inventor8" {$modo} value='{$inventor8}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac8" {$modo} value='{$paisinv8}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor9)" onchange="valagente(document.formarcas2.invnac8,document.formarcas2.invpais8)"> -
        <select size="1" name="invpais8" {$modo2} onchange="this.form.invnac8.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv8 output=$arraynompais}
        </select>
        <input type="text" name="inventor9" {$modo} value='{$inventor9}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac9" {$modo} value='{$paisinv9}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor10)" onchange="valagente(document.formarcas2.invnac9,document.formarcas2.invpais9)"> -
        <select size="1" name="invpais9" {$modo2} onchange="this.form.invnac9.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv9 output=$arraynompais}
        </select>
        <input type="text" name="inventor10" {$modo} value='{$inventor10}' size="45" maxlength="45" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac10" {$modo} value='{$paisinv10}' size="2" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.vtitut)" onchange="valagente(document.formarcas2.invnac10,document.formarcas2.invpais10)"> -
        <select size="1" name="invpais10" {$modo2} onchange="this.form.invnac10.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv10 output=$arraynompais}
        </select>
      </td>
    </tr>
  </table>-->
  
  <table width="85%">
    <tr>
      <tr><td class="izq2-color">{$campo9}</td></tr>
      <td class="der-color">
        <div id="resultado">
        <input type="text" name="vinv" {$modo} value='{$inventor}' size="45" maxlength="50" onKeyup="this.value=this.value.toUpperCase()">&nbsp;&nbsp;
        <input type="text" name="invnac" {$modo} value='{$paisinv}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.inventor2)" onchange="valagente(document.formarcas2.invnac,document.formarcas2.invpais)"> -
        <select size="1" name="invpais" {$modo2} onchange="this.form.invnac.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$paisinv output=$arraynompais}
        </select>
        &nbsp;&nbsp;
        <input type="button" name="Inventor" {$modo2} value="Incluir Inventor" 
               onclick="browseinventor(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.invpais,document.formarcas2.Inventor)">
      </td>
      <tr>
        <td colspan="2"> 
          <iframe name='frameinventor' id='frameinventor' style='width:99%;height:160px' 
                  src="p_consoli.php?psol={$vsol1}-{$vsol2}&vtipo=Inventor"></iframe>
        </td>
      </tr>
      </div>
    </tr>
  </table> 
  
  &nbsp;
  <table width="100%">
     <tr>
     <td class="izq2-color">{$campo10}</td>  
     </tr>
     <tr>
     <td class="izq2-color">
     <iframe id='top' style='width:100%;height:120px' src='exampleb.php?psol={$psoli}'></iframe> 
     </td></tr>  
    <tr>
    <td class="der-color">
        <input type="text" name="vtitut" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar e Incluir Titular(es)" {$modo2} name="vtitui" onclick="browsetitular(document.formarcas2.auxnum,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" value="Buscar y Eliminar Titular(es)" {$modo2} name="vtitue" onclick="browsetitular(document.formarcas2.auxnum,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td> </tr> 
  </table>
  &nbsp;
    <!-- <table width="70%">
    <tr>
      <td class="izq2-color" colspan="2">{$campo14}</td>  
    </tr>
    <tr><td>    
     <iframe id='top' style='width:100%;height:100px' src='examplep.php?psol={$psoli}' scrolling="yes"></iframe> 
     </td></tr>
    <tr>
      <td class="der-color">
        <input type="text" name="vinventor" {$modo} size="25" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" value="Buscar e Incluir Inventor(es)" {$modo2} name="vinveni" onclick="browseinventor(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinventor,document.formarcas2.vinveni)">
        <input type="button" value="Buscar y Eliminar Inventor(es)" {$modo2} name="vinvene" onclick="browseinventor(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinventor,document.formarcas2.vinvene)">
    </td></tr>
       
  </table> --> 
  &nbsp;

  <table width="250" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <a href="p_manteni.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
    </td>      
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>
  
</form>
</div>  

</body>
</html>
