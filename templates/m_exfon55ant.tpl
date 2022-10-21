<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_exfon55.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value='{$usuario}'>
  <input type='hidden' name='vsol' value='{$vsol}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  
  <table>
     <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)"> &nbsp;
      </td>
      <td class="cnt"><input tabindex="2" type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
  </tr>
  </table>
</form>				  
</div>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_exfon55.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='opcion' value={$opcion}>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='vder' value='{$vder}'>

<table>
<tr>
  <table>
  <tr>
    <td width="80%">
       <div><strong> </strong></div>
    </td>

    <td align="rigth">
      <table>
         <tr>
	 <td>
	   <a href="m_exfon55.php?nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/cancel_f2.png',1);">
	   <img src="../imagenes/cancel.png" alt="Cancel" align="middle" name="cancel" border="0" />		Cancelar		</a>
	 </td>
 	 <td>&nbsp;</td>
 	 <td>&nbsp;</td>
 	 <td>&nbsp;</td>
	 <td>
 	   <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/salir_f2.png',1);">
	   <img src="../imagenes/salir.png" alt="Salir" align="middle" name="salir" border="0" />		Salir		</a>
	 </td>
	 <td>&nbsp;</td>
	 </tr>
	</table>
    </td>
  </tr>
  </table>

 <tr>
   <div class="tab-page" id="modules-cpanel">
   <script type="text/javascript">
      var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
   </script>

  <div class="tab-page" id="module33"><h2 class="tab">Basico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module33" ) );
  </script>
  <table border="1" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color" colspan="3" >
         <input type="text" name="fecha_solic" {$vmodo} value='{$fecha_solic}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      {$campo3}&nbsp;&nbsp;&nbsp;
      <input type="text" name="tipo_marca" {$vmodo} value='{$tipo_marca}' size="1" maxlength="2" > - 
      <input type="text" name="tipomarca" {$vmodo} value='{$tipomarca}' size="28" maxlength="30" >
      </td>
      <td class="der-color" rowspan="5" valign="top">
        {$campo8}
        <br><a href='{$nameimage}' target='_blank'><img border='0' id="picture" src='{$nameimage}' width='270' height='270'></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	<textarea rows="2" name="nombre" {$vmodo} cols="75" maxlength="120">{$nombre}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">
         <input type="text" name="estatus" {$vmodo} value='{$estatus}' size="2" maxlength="3"> - 
         <input type="text" name="nombest" {$vmodo} value='{$nombest}' size="60" maxlength="120">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
       <input type="text" name="modalidad" {$vmodo} value='{$modalidad}' size="1" maxlength="2" > - 
       <input type="text" name="modal" {$vmodo} value='{$modal}' size="15" maxlength="15" >
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       {$campo5}&nbsp;&nbsp;&nbsp;
        <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > - 
        <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td colspan="2" class="der-color">
        <input type="text" name="vcodpais" {$vmodo} value='{$vcodpais}' size="1" maxlength="2" > - 
        <input type="text" name="pais_resid" {$vmodo} value='{$pais_resid}' size="30" maxlength="30" >
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color" colspan="4" >
        <input type="text" name="tramitante" {$vmodo} value='{$tramitante}' size="65"  maxlength="65">
        &nbsp;&nbsp;&nbsp;&nbsp;{$campo10}&nbsp;&nbsp;
        <input type="text" name="vpod1" {$vmodo} value='{$vpod1}' align="right" size="3" maxlength="4" > - 
        <input type="text" name="vpod2" {$vmodo} value='{$vpod2}' align="right" size="4" maxlength="5" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color" colspan="4" >
        <input type="text" name="vcodage" {$vmodo} value='{$vcodage}' size="5" maxlength="5"> - 
        <input type="text" name="nagente" {$vmodo} value='{$nagente}' size="56" maxlength="56">
        &nbsp;&nbsp;&nbsp;&nbsp;{$campo12}&nbsp;&nbsp;
        <input type="text" name="vsol3" {$vmodo} value='{$vpod1}' align="right" size="3" maxlength="4" > - 
        <input type="text" name="vsol4" {$vmodo} value='{$vpod2}' align="right" size="6" maxlength="6" >
      </td>
    </tr>
  </tr>
  </table>

  <p align="center"><b><font size="2" face="Tahoma">Titular(es)</font></b></p>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="10%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Codigo</b></font></td>
    <td width="30%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Nombre</b></font></td>
    <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Nacionalidad</b></font></td>
    <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Domicilio</b></font></td>
    <!-- <td width="20%" style="background-color: #015B9E; border: 1 solid #D8E6FF" align="center"><font color="#FFFFFF" face="MS Sans Serif"><b>Pais
      Residencia</b></font></td> --> 
  </tr>
  {section name=cont loop=$vnumtitu}
  <tr>
       <td class="der-color">{$arr_tit1[cont]}</td>
       <td class="der-color">{$arr_tit2[cont]}</td>
       <td class="der-color">{$arr_tit3[cont]}</td>
       <td class="der-color">{$arr_tit4[cont]}</td>
       <!-- <td class="der-color">{$arr_tit5[cont]}</td> --> 
  </tr>
  {/section} 
  </tr>
  </table>
  </div>

  <div class="tab-page" id="module19"><h2 class="tab">Distingue</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module19" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="100%" class="der-color" >
	     <textarea rows="18" name="distingue" {$vmodo} cols="132" maxlength="8000">
        {$distingue}
        </textarea>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>
  </div>
  
  <div class="tab-page" id="module21"><h2 class="tab">Cronologia</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module21" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha
    Evento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Vencimiento
    Evento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Nro
    Documento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Codigo del
    Evento</b></font></td>
      <td width="20%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Descripcion</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha de
    Transaccion</b></font></td>
      <td width="30%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Comentarios</b></font></td>
    </tr>
    {section name=cont loop=$vnumrows}
    <tr>
       <td class="der-color">{$arr_ph1[cont]}</td>
       <td class="der-color">{$arr_ph2[cont]}</td>
       <td class="der-color">{$arr_ph3[cont]}</td>
       <td class="der-color">{$arr_ph4[cont]}</td>
       <td class="der-color">{$arr_ph5[cont]}</td>
       <td class="der-color">{$arr_ph6[cont]}</td>
       <td class="der-color">{$arr_ph7[cont]}</td>
       <!-- <td class="der-color">{$arr_ph8[cont]}</td> -->
       </td>
    </tr>
    {/section} 
  </tr> 
  </table>
  </div>
  </div>

  <div class="tab-page" id="module25"><h2 class="tab">Concedida</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module25" ) );
  </script>
  <div align="left">
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
    <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3" >
        <input type="text" name="evento" {$vmodo} value="51" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento" {$modo} value='{$fevento}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.formarcas2.save)" onchange="valFecha(this,document.formarcas2.save)" >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/save_f2.png',1);" src="../imagenes/save_f2.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Conceder'" />&nbsp;Grabar&nbsp;&nbsp;
        {else}
           <img src="../imagenes/save.png" alt="Save" align="middle" name="save" border="0" />&nbsp;Grabar&nbsp;&nbsp;
        {/if}
      </td>
    </tr>

  </tr> 
  </table>
  </div>
  </div>
  &nbsp;

  <div class="tab-page" id="module29"><h2 class="tab">Negada</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module29" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1">
  <input type ='hidden' name='vcomenta' value='{$vcom}'>
  <tr>
    <tr>
      <td class="izq-color">{$lcomentario}</td><td class="der-color">
        <textarea rows="2" name="comenta1" {$modo} cols="117" onchange="this.value=this.value.toUpperCase()"></textarea>
      </td>
    </tr>
  </tr>
  </table>	
  &nbsp;
  
  <table>	    
	<tr>
	 <td class="izq-color">{$lart}</td>
	 <td class="der-color">
	    <input size="2" type="text" name="art" maxlength="2" onKeyPress="return acceptChar(event,2, this)" onchange="validart56(this,document.formarcas2.lit1,document.formarcas2.vlit1reg11)" onkeyup="checkLength(event,this,2,document.formarcas2.lit1)">
	 <td>
	 
	 <!-- Primer Literal - 1er. Registro -->	
	 <td class="izq-color">{$llit}</td><td class="der-color"><input size="1" type="text" name="lit1" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  
	 onkeyup="checkLength(event,this,2,document.formarcas2.vlit1reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit1reg11);"><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg11" size="1" maxlength="1" 
	        value='{$lit1reg11}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg12" size="6" maxlength="6" 
		value='{$lit1reg12}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg21)" onchange="Rellena(document.formarcas2.vlit1reg12,6)"></td>
	<!-- <td rowspan="3">{$espacios}</td>	-->
		
	 <!-- Segundo Literal - 1er. Registro -->	
	 <td class="izq-color">{$llit}</td><td class="der-color"><input size="1" type="text" name="lit2" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  onkeyup="checkLength(event,this,2,document.formarcas2.vlit2reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit2reg11);"><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg11" size="1" maxlength="1" 
	        value='{$lit2reg11}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg12" size="6" maxlength="6" 
		value='{$lit2reg12}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg21)" onchange="Rellena(document.formarcas2.vlit2reg12,6)"></td></tr><tr>
 	 </tr><tr>
 	 
	 <!-- Primer Lireral - 2do. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg21" size="1" maxlength="1" 
	        value='{$lit1reg21}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg22" size="6" maxlength="6" 
		value='{$lit1reg22}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg31)" onchange="Rellena(document.formarcas2.vlit1reg22,6)"></td>
		<td></td><td><td>	
		
	 <!-- Segundo Lireral - 2do. Registro -->	
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg21" size="1" maxlength="1" 
	        value='{$lit2reg21}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg22" size="6" maxlength="6" 
		value='{$lit2reg22}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg31)" onchange="Rellena(document.formarcas2.vlit2reg22,6)"></td>
		</tr><tr>
		
    <!-- Primer Lireral - 3er. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg31" size="1" maxlength="1" 
	        value='{$lit1reg31}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg32" size="6" maxlength="6" 
		value='{$lit1reg32}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.lit2)" onchange="Rellena(document.formarcas2.vlit1reg32,6)"></td>
		
      <td></td><td><td>
      	 	 	
    <!-- Segundo Lireral - 3er. Registro -->	
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg31" size="1" maxlength="1" 
	        value='{$lit2reg31}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg32" size="6" maxlength="6" 
		value='{$lit2reg32}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.comenta)" onchange="Rellena(document.formarcas2.vlit2reg32,6)"></td></tr>			
  </table>
  
  <table border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" {$vmodo} value="225" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento2" {$modo} value='{$fevento2}' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/save_f2.png',1);" src="../imagenes/save_f2.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Negar'" />&nbsp;Grabar&nbsp;&nbsp;
        {else}
           <img src="../imagenes/save.png" alt="Save" align="middle" name="save" border="0" />&nbsp;Grabar&nbsp;&nbsp;
        {/if}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module30"><h2 class="tab">Detener</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module30" ) );
  </script>
  <div align="left">
  <table width="100%" border="1" cellspacing="1">
  <tr>
  <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTAÑA CORRESPONDIENTE</b></font></small>
  <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="70" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
  </tr>

  <tr>
     <td class="izq-color">{$lcomentario}</td><td class="der-color">
       <textarea rows="2" name="comenta2" {$modo} cols="117" onchange="this.value=this.value.toUpperCase()"></textarea>
     </td>
  </tr>
  </tr>
  </table>	
  &nbsp;
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" {$vmodo} value="54" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento3" {$modo} value='{$fevento3}' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/save_f2.png',1);" src="../imagenes/save_f2.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Detener'" />&nbsp;Grabar&nbsp;&nbsp;
        {else}
           <img src="../imagenes/save.png" alt="Save" align="middle" name="save" border="0" />&nbsp;Grabar&nbsp;&nbsp;
        {/if}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  </div>
  </div>

</form>
</div>  
  &nbsp;
  &nbsp;

</body>
</html>
