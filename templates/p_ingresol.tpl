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
<form name="formarcas1" action="p_ingresol.php?vopc=4" method="POST">
{/if}
  <table>
  <tr> 
    <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td>	
      <td class="cnt">
      {if $vopc eq 3}
      <input type="image" src="../imagenes/new_f2.png" width="32" height="24" value="Nueva Solicitud">Nueva Solicitud
      </form>
      {/if} 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="p_ingresol.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='dirano' value={$dirano}>
  <input type ='hidden' name='vsol1' value={$vsol1}>
  <input type ='hidden' name='vsol2' value={$vsol2}>
  <input type ='hidden' name='vsol1a' value={$vsol1a}>
  <input type ='hidden' name='vsol2a' value={$vsol2a}>
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

  <table cellspacing="2">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" {$modo} value='{$fecha_solic}' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_paten)" onchange="valFecha(this,document.formarcas2.tipo_paten)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq2-color" >{$campo5}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" {$modo2} >
          {html_options values=$arraytipom selected=$tipo_paten output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="4" valign="top">
        <input name="ubicacion" type="file" value='{$ubicacion}' {$modo2} size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='{$nameimage}' id="picture" width="270" height="270" alt="vista previa"/></br>
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
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name="input2" {$modo} value='{$pais_resid}' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
        <select size="1" name="pais" {$modo2} onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$pais_resid output=$arraynompais}
        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td colspan="3" class="der-color">
        <input type="text" name="tramitante" {$modo} value='{$tramitante}' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
        &nbsp;&nbsp;&nbsp;{$campo11}&nbsp;
        <input type="text" name="vpod1" {$modo} value='{$vpod1}' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" {$modo} value='{$vpod2}' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr> 
    
    <tr>
      <td class="izq-color">{$campo14}</td>
      <td class="der-color" colspan="2" >
        <input type="text" name="locarno1" '{$modo}' value='{$locarno1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.locarno2)">-
        <input type="text" name="locarno2" '{$modo}' value='{$locarno2}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.edicion)">
      </td>
    </tr>
    <tr>
    </tr>

  </tr>
  </table></center>

    &nbsp;
    <table width="85%">
    <tr><td class="izq2-color">{$campo12}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="z_veragente.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
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
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
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
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="z_verpriorid.php?psol={$vsol1}-{$vsol2}&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" {$modo} size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar/Incluir"  name="vpriori" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" value="Buscar/Eliminar" name="vpriore" {$modo2} onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;




    
  <table width="90%">
    <tr><td class="izq2-color">{$campo10}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:120px' src="exampleb.php?psol={$vsol1}-{$vsol2}" name="top" scrolling= "yes"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" {$modo} size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" value="Buscar e Incluir Titular(es)"  name="vtitui" {$modo2} onclick="browsetitular(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" value="Buscar y Eliminar Titular(es)" name="vtitue" {$modo2} onclick="browsetitular(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
  </table>
  

  <table>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
    <tr>
    </tr>
    <tr>
      <td class="izq-color">{$campo16}</td>
      <td class="der-color">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;
      </td>
    </tr>
	 <tr>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        1.&nbsp;<input type="text" name="c1l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c1l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c1n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c1n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c1n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c1l2)">
          <input type="text" name="c1l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c1l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c1n2)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c1n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c1n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c1n3)"> /
          <input type="text" name="c1n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c1n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t1)"> -
          <input type="text" name="t1" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c2l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        2.&nbsp;<input type="text" name="c2l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c2l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas2.c2n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c2n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c2l2)">
          <input type="text" name="c2l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c2l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c2n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c2n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c2n3)"> /
          <input type="text" name="c2n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c2n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t2)"> -
          <input type="text" name="t2" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        3.&nbsp;<input type="text" name="c3l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c3l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c3n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c3l2)">
          <input type="text" name="c3l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c3l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c3n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c3n3)"> /
          <input type="text" name="c3n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c3n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t3)"> -
          <input type="text" name="t3" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t3}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        4.&nbsp;<input type="text" name="c4l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c4l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c4n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c4l2)">
          <input type="text" name="c4l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c4l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c4n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c4n3)"> /
          <input type="text" name="c4n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c4n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t4)"> -
          <input type="text" name="t4" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t4}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        5.&nbsp;<input type="text" name="c5l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c5l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c5n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c5l2)">
          <input type="text" name="c5l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c5l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c5n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c5n3)"> /
          <input type="text" name="c5n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c5n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t5)"> -
          <input type="text" name="t5" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t5}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6l1)" >&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        6.&nbsp;<input type="text" name="c6l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c6l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6n1)">
          <input type="text" name="c6n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c6n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c6l2)">
          <input type="text" name="c6l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c6l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6n2)">
          <input type="text" name="c6n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c6n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c6n3)"> /
          <input type="text" name="c6n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c6n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t6)"> -
          <input type="text" name="t6" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t6}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        7.&nbsp;<input type="text" name="c7l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c7l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7n1)">
          <input type="text" name="c7n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c7n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c7l2)">
          <input type="text" name="c7l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c7l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7n2)">
          <input type="text" name="c7n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c7n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c7n3)"> /
          <input type="text" name="c7n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c7n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t7)"> -
          <input type="text" name="t7" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t7}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8l1)" >&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        8.&nbsp;<input type="text" name="c8l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c8l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8n1)">
          <input type="text" name="c8n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c8n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c8l2)">
          <input type="text" name="c8l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c8l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8n2)">
          <input type="text" name="c8n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c8n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c8n3)"> /
          <input type="text" name="c8n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c8n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t8)"> -
          <input type="text" name="t8" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t8}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c9l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        9.&nbsp;<input type="text" name="c9l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c9l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c9n1)">
          <input type="text" name="c9n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c9n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c9l2)">
          <input type="text" name="c9l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c9l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c9n2)">
          <input type="text" name="c9n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c9n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c9n3)"> /
          <input type="text" name="c9n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c9n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t9)"> -
          <input type="text" name="t9" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t9}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10l1)" >&nbsp;&nbsp; 
        &nbsp;
       10.&nbsp;<input type="text" name="c10l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c10l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10n1)">
          <input type="text" name="c10n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c10n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c10l2)">
          <input type="text" name="c10l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c10l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10n2)">
          <input type="text" name="c10n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c10n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c10n3)"> /
          <input type="text" name="c10n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c10n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t10)"> -
          <input type="text" name="t10" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t10}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;
       11.&nbsp;<input type="text" name="c11l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c11l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11n1)">
          <input type="text" name="c11n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c11n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c11l2)">
          <input type="text" name="c11l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c11l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11n2)">
          <input type="text" name="c11n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c11n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c11n3)"> /
          <input type="text" name="c11n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c11n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t11)"> -
          <input type="text" name="t11" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t11}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12l1)" >&nbsp;&nbsp; 
        &nbsp;
       12.&nbsp;<input type="text" name="c12l1" '{$modo}' onKeyPress="return acceptChar(event,7, this)" value='{$c12l1}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12n1)">
          <input type="text" name="c12n1" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c12n1}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c12l2)">
          <input type="text" name="c12l2" '{$modo}' onKeyPress="return acceptChar(event,5, this)" value='{$c12l2}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12n2)">
          <input type="text" name="c12n2" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c12n2}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c12n3)"> /
          <input type="text" name="c12n3" '{$modo}' onKeyPress="return acceptChar(event,2, this)" value='{$c12n3}' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t12)"> -
          <input type="text" name="t12" '{$modo}' onKeyPress="return acceptChar(event,8, this)" value='{$t12}' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.vinveni)" >&nbsp;&nbsp; 
      </td>
	 </tr>
    <tr>
      <td class="izq-color">{$campo15}</td>
      <td class="der-color" colspan="2" >
        <input type="text" name="edicion" '{$modo}' value='{$edicion}' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.vnprior)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"></td>
      <td class="der-color"></td>
    </tr>  
  </table>
  &nbsp;&nbsp;
  <table width="230" >
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/save_f2.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="p_ingresol.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3 || $vopc eq 4}
         <a href="p_ingresol.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt">
         <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>
