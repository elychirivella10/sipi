<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="mueveReloj(); this.document.{$varfocus}.focus()">
<div align="center">

<form name="form_reloj">
<table width="960px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class="der">
      <div align="right">
        <I><font size="-1"><b>{$titulo}</b></font></I>
         &nbsp;&nbsp;<font face="Arial" size="2" > 
         <input type="text" name="reloj" size="15" style="background-color : Rich Blue; color : Black; font-family : Verdana, Arial, Helvetica; font-size : 8pt; text-align : center; font-weight: bold;" onfocus="window.document.form_reloj.reloj.blur()"><br/>
         </font>
      </div>
    </td>
  </tr>
</table>
</form>

{if $vopc eq 3}
  <form name="forboletin1" id="forboletin1" action="b_ingreso.php?vopc=4" method="post">
{/if}
{if $vopc eq 5}
  <form name="forboletin1" id="forboletin1" action="b_ingreso.php?vopc=6" method="post">
{/if} 
  <table>
  <tr> 
    <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
        <input type="text" name="nbol" size="3" maxlength="3" value='{$nbol}' {$modo} onKeyPress="return acceptChar(event,2, this)" onchange="Rellena(document.forboletin.nbol,3)">&nbsp;&nbsp;
        <select size="1" name="aplica" {$modo}>
          {html_options values=$apli_inf selected=$aplica output=$apli_def}
        </select> 
        &nbsp;
      </td>	
      
      {if $vopc eq 3}
        <td class="cnt">
          <input type="image" src="../imagenes/note_f2.png" width="32" height="24" value="Crear Boletin">Crear Boletin</td>
        </form>
      {/if}
      {if $vopc eq 5}
        <td class="cnt">
  	 	    <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">  
        </td>
        </form>
      {/if} 		  
      </td>
    </tr>
  </tr>
  </table>

<table width="960px">
<tr>

<form name="forboletin" id="forboletin" enctype="multipart/form-data" action="b_ingreso.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='nbol' value='{$nbol}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='accion' value='{$accion}'>
  <input type='hidden' name='string' value='{$string}'>
  <input type='hidden' name='campos' value='{$campos}'>
  <input type='hidden' name='aplica' value='{$aplica}'>
  
  <table width="960px">
  <tr>
    <td> 
       <div><strong> </strong></div>
    </td>

  <table>
  <tr>
    <td width="100%"> 
       <div><strong> </strong></div>
    </td>

    <td align="rigth">
    <table>
     <tr>
	   <td>
	     {if $accion eq 'I' || $vopc eq 4}
	       <a href="b_ingreso.php?vopc=3&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}
	     {if $accion eq 'M' || $vopc eq 6}
	       <a href="b_ingreso.php?vopc=5&nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	       <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	     {/if}  
	   </td>
 	   <td>&nbsp;</td>
      <td>
        {if $vopc eq 4 || $vopc eq 6}
	       <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" onclick="validate();return returnVal;"/>
        {else}
          <a><img src="../imagenes/boton_guardar_rojo.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" alt="Save" align="middle" name="save" border="0" /></a>
        {/if}
      </td>
 	   <td>&nbsp;</td>
	   <td>
 	     <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_azul.png',1);">
	     <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>
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

   <div class="tab-page" id="modac01"><h2 class="tab">Inf.General</h2>
   <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac01" ) );
   </script>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="20%" class="izq-color">{$campo2}</td>
      <td width="80%" class="der-color" >
         <input type="text" name="fecha_pub" {$modo1} value='{$fecha_pub}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fecha_ven)" onchange="valFecha(this,document.forboletin.fecha_ven)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar9');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         </div>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
         <input type="text" name="anoi" {$modo1} value='{$anoi}' size="3" maxlength="3" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,3,document.forboletin.anof)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color" >
         <input type="text" name="anof" {$modo1} value='{$anof}' size="3" maxlength="3" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,3,document)" >
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo12}</td>
      <td class="der-color" >
         <input type="text" name="anor" {$modo1} value='{$anor}' size="3" maxlength="3" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,3,document)" >
      </td>
    </tr>
  </tr>
  </table>
  </div>

  <div class="tab-page" id="modac03"><h2 class="tab">Marcas</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac03" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
   <tr>
    <td colspan="2" width="100%" class="izq3-color" > <b> {$campo6}</b> {$campo8}</td>
   </tr>
      
    <tr>
     <td width="100%" colspan="1"> 
      <p> </p>
      <p style="margin: 0 5"><FONT COLOR=2B547E><b><i>- Solicitadas       	
      <p style="margin: 0 25" > <input type="text" name="tit_soli" value='{$tit_soli}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fec_soli" {$modo1} value='{$fec_soli}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_soli)" >
      <a href="javascript:showCal('Calendar11');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Orden de Publicación<br>
      <p style="margin: 0 25" > <input type="text" name="tit_orden" value='{$tit_orden}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_orde" {$modo1} value='{$fec_orde}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_orde)"  >
      <a href="javascript:showCal('Calendar12');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Devueltas por Forma<br>
      <p style="margin: 0 25" ><input type="text" name="tit_devu" value='{$tit_devu}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_devu" {$modo1} value='{$fec_devu}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)" >
      <a href="javascript:showCal('Calendar14');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Notificación de Solicitudes de Marcas con Oposición<br>
      <p style="margin: 0 25" ><input type="text" name="tit_obse" value='{$tit_obse}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_obse" {$modo1} value='{$fec_obse}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar15');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">  
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Oposiciones sin Contestación Desistidas por Ley<br> 
      <p style="margin: 0 25" ><input type="text" name="tit_obse_scon" value='{$tit_obse_scon}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_obse_scon" {$modo1} value='{$fec_obse_scon}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar16');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Concedidas<br>    
      <p style="margin: 0 25" > <input type="text" name="tit_conc" value='{$tit_conc}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_conc" {$modo1} value='{$fec_conc}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar13');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">      	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida<br>
      <p style="margin: 0 25" ><input type="text" name="tit_prio" value='{$tit_prio}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_prio" {$modo1} value='{$fec_prio}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar17');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>    
    </tr>
    <tr>
     <td width="100%" colspan="1">      	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b> <i>- Prioridad Extinguida Extemporánea<br>
      <p style="margin: 0 25" ><input type="text" name="tit_prio_exte" value='{$tit_prio_exte}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_prio_exte" {$modo1} value='{$fec_prio_exte}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar18');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">  
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Prioridad Extinguida Defectuosa<br>
      <p style="margin: 0 25" ><input type="text" name="tit_prio_defe" value='{$tit_prio_defe}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_prio_defe" {$modo1} value='{$fec_prio_defe}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar19');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>    	 
    </tr>
    <tr>
     <td width="100%" colspan="1">      	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Perimidas por no Publicación en Prensa<br>
      <p style="margin: 0 25" ><input type="text" name="tit_peri" value='{$tit_peri}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_peri" {$modo1} value='{$fec_peri}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar20');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>  
    </tr>
    </tr>
     <td width="100%" colspan="1">     	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Caducas<br>
      <p style="margin: 0 25" ><input type="text" name="tit_cadu" value='{$tit_cadu}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_cadu" {$modo1} value='{$fec_cadu}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar21');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Desistidas<br>      
      <p style="margin: 0 25" ><input type="text" name="tit_desi" value='{$tit_desi}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_desi" {$modo1} value='{$fec_desi}' size="10" maxlength="10" align="left"  onkeyup="checkLength(event,this,10,document.forboletin.anoi)">
      <a href="javascript:showCal('Calendar22');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>	
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Desistimiento de Oposiciones<br>      
      <p style="margin: 0 25" ><input type="text" name="tit_desi_obse" value='{$tit_desi_obse}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_desi_obse" {$modo1} value='{$fec_desi_obse}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar49');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>	
    </tr>
    <tr>
     <td width="100%" colspan="1">        
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Desistimiento de Oposiciones Mejor Derecho<br>
      <p style="margin: 0 25" ><input type="text" name="tit_desi_mejo" value='{$tit_desi_mejo}' size="90" maxlength="200" align="left"   {$modo1}  > 
&nbsp; {$campof}
      <input type="text" name="fec_desi_mejo" {$modo1} value='{$fec_desi_mejo}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar23');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">          	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Negadas<br>
      <p style="margin: 0 25" ><input type="text" name="tit_nega" value='{$tit_nega}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_nega" {$modo1} value='{$fec_nega}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar31');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Certificados Elaborados<br>
      <p style="margin: 0 25" > <input type="text" name="tit_cert" value='{$tit_cert}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_cert" {$modo1} value='{$fec_cert}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar32');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">           	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Notificación de Cancelación<br>
      <p style="margin: 0 25" > <input type="text" name="tit_noti" value='{$tit_noti}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_noti" {$modo1} value='{$fec_noti}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar50');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">          	 		
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Anotaciones Marginales<br>
      <p style="margin: 0 25" > <input type="text" name="tit_anot" value='{$tit_anot}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_anot" {$modo1} value='{$fec_anot}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar33');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">          	 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Devoluciones de Registros a Públicar <br> 	
      <p style="margin: 0 25" ><input type="text" name="tit_devo_regi" value='{$tit_devo_regi}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_devo_regi" {$modo1} value='{$fec_devo_regi}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar29');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Reingresos de Devoluciones de Anotaciones Marginales<br>
      <p style="margin: 0 25" ><input type="text" name="tit_rein_devam" value='{$tit_rein_devam}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_rein_devam" {$modo1} value='{$fec_rein_devam}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar30');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    <tr>
     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Desistimiento de Anotaciones Marginales <br> 
      <p style="margin: 0 25" ><input type="text" name="tit_desi_anom" value='{$tit_desi_anom}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_desi_anom" {$modo1} value='{$fec_desi_anom}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
     <a href="javascript:showCal('Calendar28');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>   
    </tr>
    <tr>
     <td width="100%" colspan="1">       
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Registros no renovados<br>
      <p style="margin: 0 25" ><input type="text" name="tit_regi" value='{$tit_regi}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_regi" {$modo1} value='{$fec_regi}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar26');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>     
    </tr>
    <tr>
     <td width="100%" colspan="1">      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Caducas por No Renovación<br>    
      <p style="margin: 0 25" ><input type="text" name="tit_cadu_nren" value='{$tit_cadu_nren}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_cadu_nren" {$modo1} value='{$fec_cadu_nren}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar25');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>       
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Devueltas por Fondo<br>
      <p style="margin: 0 25" ><input type="text" name="tit_fondo" value='{$tit_fondo}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fec_fondo" {$modo1} value='{$fec_fondo}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)" >
      <a href="javascript:showCal('Calendar68');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
   </td>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac04"><h2 class="tab">Patentes</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac04" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
  <tr>
   <tr>
     <td colspan="2" width="100%" class="izq3-color" > <b> {$campo7}</b>  {$campo8}</td>
   </tr>
   
   <tr>
     <td width="50%" colspan="1"> 
     <p> </p>
     <div id="resultado">

      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Solicitadas<br>
      <p style="margin: 0 25" > <input type="text" name="titp_soli" value='{$titp_soli}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_soli" {$modo1} value='{$fecp_soli}' size="10" maxlength="10" align="left"   onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar34');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
    
     <td width="100%" colspan="1">        	      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Orden de Publicación<br>
      <p style="margin: 0 25" ><input type="text" name="titp_orden" value='{$titp_orden}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof} 
      <input type="text" name="fecp_orde" {$modo1} value='{$fecp_orde}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar35');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
  
     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Devueltas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_devu" value='{$titp_devu}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_devu" {$modo1} value='{$fecp_devu}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar37');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">  
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Concedidas<br>    
      <p style="margin: 0 25" ><input type="text" name="titp_conc" value='{$titp_conc}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_conc" {$modo1} value='{$fecp_conc}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar36');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">           	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida<br>
	   <p style="margin: 0 25" ><input type="text" name="titp_prio" value='{$titp_prio}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_prio" {$modo1} value='{$fecp_prio}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar38');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">      	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida Extemporánea<br>
    	<p style="margin: 0 25" ><input type="text" name="titp_prio_exte" value='{$titp_prio_exte}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_prio_exte" {$modo1} value='{$fecp_prio_exte}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar39');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Prioridad Extinguida Defectuosa<br>
      <p style="margin: 0 25" ><input type="text" name="titp_prio_defe" value='{$titp_prio_defe}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_prio_defe" {$modo1} value='{$fecp_prio_defe}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar40');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>
 
     <td width="100%" colspan="1">       
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Perimidas por no Publicación en Prensa<br>
      <p style="margin: 0 25" ><input type="text" name="titp_peri" value='{$titp_peri}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_peri" {$modo1} value='{$fecp_peri}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar41');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
 
     <td width="100%" colspan="1">      	     	      	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i> - Denegadas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_dene" value='{$titp_dene}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_dene" {$modo1} value='{$fecp_dene}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar42');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    
     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Desistidas<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_desi" value='{$titp_desi}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_desi" {$modo1} value='{$fecp_desi}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar43');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Abandonadas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_aban" value='{$titp_aban}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_aban" {$modo1} value='{$fecp_aban}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar44');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">          	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Oposiciones<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_opos" value='{$titp_opos}' size="90" maxlength="200" align="left"   {$modo1}  > 
  &nbsp;{$campof}
      <input type="text" name="fecp_opos" {$modo1} value='{$fecp_opos}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar46');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes en Rehabilitacion<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_reha" value='{$titp_reha}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_reha" {$modo1} value='{$fecp_reha}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar47');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">     	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Titulos de Patentes<br>  	
      <p style="margin: 0 25" ><input type="text" name="titp_titu" value='{$titp_titu}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_titu" {$modo1} value='{$fecp_titu}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar48');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Falto de Pago de Anualidad<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_sefp" value='{$titp_sefp}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_sefp" {$modo1} value='{$fecp_sefp}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar66');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Vencimiento de Termino<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_sevt" value='{$titp_sevt}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_sevt" {$modo1} value='{$fecp_sevt}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar67');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1">          	       	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Negadas<br>
      <p style="margin: 0 25" ><input type="text" name="titp_nega" value='{$titp_nega}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof} 
      <input type="text" name="fecp_nega" {$modo1} value='{$fecp_nega}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)" >
      <a href="javascript:showCal('Calendar45');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> 
    </tr>

     <td width="100%" colspan="1">         	 	
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Falto de Pago de Concesion<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_derp" value='{$titp_derp}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_derp" {$modo1} value='{$fecp_derp}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar93');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">            
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Devueltas por Fondo<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_devfon" value='{$titp_devfon}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_devfon" {$modo1} value='{$fecp_devfon}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar96');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1">            
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Prioridades Extinguidas por Fondo<br>  
      <p style="margin: 0 25" ><input type="text" name="titp_priofon" value='{$titp_priofon}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fecp_priofon" {$modo1} value='{$fecp_priofon}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.anoi)"  >
      <a href="javascript:showCal('Calendar97');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

   </td>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac05"><h2 class="tab">Recursos M</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac05" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
   <tr>
    <td colspan="2" width="100%" class="izq3-color" > <b> {$campo9}</b> {$campo8}</td>
   </tr>
      
    <tr>
     <td width="100%" colspan="1"> 
      <p> </p>
      <p style="margin: 0 5"><FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Marcas - Estatus 800<br>       	
      <p style="margin: 0 25" > <input type="text" name="tit_800" value='{$tit_800}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="fec_800" {$modo1} value='{$fec_800}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_800)" >
      <a href="javascript:showCal('Calendar101');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Negadas Marcas - Estatus 801<br>
      <p style="margin: 0 25" > <input type="text" name="tit_801" value='{$tit_801}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_801" {$modo1} value='{$fec_801}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_801)"  >
      <a href="javascript:showCal('Calendar102');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Resolución a Observaciones Marcas - Estatus 802<br>
      <p style="margin: 0 25" > <input type="text" name="tit_802" value='{$tit_802}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_802" {$modo1} value='{$fec_802}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_802)"  >
      <a href="javascript:showCal('Calendar103');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Procedimiento Marcas - Estatus 803<br>
      <p style="margin: 0 25" > <input type="text" name="tit_803" value='{$tit_803}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_803" {$modo1} value='{$fec_803}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_803)"  >
      <a href="javascript:showCal('Calendar104');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Publicacion Extemporanea Marcas - Estatus 804<br>
      <p style="margin: 0 25" > <input type="text" name="tit_804" value='{$tit_804}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_804" {$modo1} value='{$fec_804}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_804)"  >
      <a href="javascript:showCal('Calendar105');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Procedimiento Orden de Publicacion Prensa Marcas - Estatus 805<br>
      <p style="margin: 0 25" > <input type="text" name="tit_805" value='{$tit_805}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_805" {$modo1} value='{$fec_805}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_805)"  >
      <a href="javascript:showCal('Calendar106');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Marcas Caduca - Estatus 806<br>
      <p style="margin: 0 25" > <input type="text" name="tit_806" value='{$tit_806}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_806" {$modo1} value='{$fec_806}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_806)"  >
      <a href="javascript:showCal('Calendar138');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Desistidas por Ley Marcas - Estatus 807<br>
      <p style="margin: 0 25" > <input type="text" name="tit_807" value='{$tit_807}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_807" {$modo1} value='{$fec_807}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_807)"  >
      <a href="javascript:showCal('Calendar107');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Prioridad Extinguida Publicacion Defectuosa Marcas - Estatus 808<br>
      <p style="margin: 0 25" > <input type="text" name="tit_808" value='{$tit_808}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_808" {$modo1} value='{$fec_808}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_808)"  >
      <a href="javascript:showCal('Calendar108');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Nulidad a la Concesión pendiente de Notificación Marcas - Estatus 809<br>
      <p style="margin: 0 25" > <input type="text" name="tit_809" value='{$tit_809}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_809" {$modo1} value='{$fec_809}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_809)"  >
      <a href="javascript:showCal('Calendar109');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud en Tramite con Petición de Nulidad del Acto Administrativo Marcas - Estatus 821<br>
      <p style="margin: 0 25" > <input type="text" name="tit_821" value='{$tit_821}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_821" {$modo1} value='{$fec_821}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_821)"  >
      <a href="javascript:showCal('Calendar110');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Nulidad del Acto Administrativo de Oficio Marcas - Estatus 822<br>
      <p style="margin: 0 25" > <input type="text" name="tit_822" value='{$tit_822}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_822" {$modo1} value='{$fec_822}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_822)"  >
      <a href="javascript:showCal('Calendar111');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud en Tramite con Petición de Nulidad del Acto Administrativo de Oficio Notificada Marcas - Estatus 823<br>
      <p style="margin: 0 25" > <input type="text" name="tit_823" value='{$tit_823}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_823" {$modo1} value='{$fec_823}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_823)"  >
      <a href="javascript:showCal('Calendar112');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud con Nulidad del Acto Administrativo de Oficio Notificada Marcas - Estatus 824<br>
      <p style="margin: 0 25" > <input type="text" name="tit_824" value='{$tit_824}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_824" {$modo1} value='{$fec_824}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_824)"  >
      <a href="javascript:showCal('Calendar113');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Nulidad a la Concesión Notificada Marcas - Estatus 825<br>
      <p style="margin: 0 25" > <input type="text" name="tit_825" value='{$tit_825}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_825" {$modo1} value='{$fec_825}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_825)"  >
      <a href="javascript:showCal('Calendar114');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Solicitud de Cancelación Pendiente de Notificar Marcas - Estatus 830<br>
      <p style="margin: 0 25" > <input type="text" name="tit_830" value='{$tit_830}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_830" {$modo1} value='{$fec_830}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_830)"  >
      <a href="javascript:showCal('Calendar115');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Solicitud de Cancelación Notificada Marcas - Estatus 831<br>
      <p style="margin: 0 25" > <input type="text" name="tit_831" value='{$tit_831}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_831" {$modo1} value='{$fec_831}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_831)"  >
      <a href="javascript:showCal('Calendar116');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Reconsideración - Disposición Administrativa que afecta al Registro Marcas - Estatus 833<br>
      <p style="margin: 0 25" > <input type="text" name="tit_833" value='{$tit_833}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_833" {$modo1} value='{$fec_833}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_833)"  >
      <a href="javascript:showCal('Calendar117');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Marca con Solicitud de Nulidad, pendiente de Notificar - Estatus 835<br>
      <p style="margin: 0 25" > <input type="text" name="tit_835" value='{$tit_835}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_835" {$modo1} value='{$fec_835}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_835)"  >
      <a href="javascript:showCal('Calendar118');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Marca con Solicitud de Nulidad Notificada - Estatus 836<br>
      <p style="margin: 0 25" > <input type="text" name="tit_836" value='{$tit_836}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_836" {$modo1} value='{$fec_836}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_836)"  >
      <a href="javascript:showCal('Calendar119');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Nulidad por Disposición Administrativa Marcas - Estatus 837<br>
      <p style="margin: 0 25" > <input type="text" name="tit_837" value='{$tit_837}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_837" {$modo1} value='{$fec_837}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_837)"  >
      <a href="javascript:showCal('Calendar120');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Reconsideración - Disposición Administrativa de Nulidad de Registro Marcas - Estatus 838<br>
      <p style="margin: 0 25" > <input type="text" name="tit_838" value='{$tit_838}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="fec_838" {$modo1} value='{$fec_838}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.fec_838)"  >
      <a href="javascript:showCal('Calendar121');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>

   </td>
  </tr> 
  </table>
  </div>

  <div class="tab-page" id="modac06"><h2 class="tab">Recursos P</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "modac06" ) );
  </script>

  <table width="100%" border="3" cellspacing="1" >
   <tr>
    <td colspan="2" width="100%" class="izq3-color" > <b> {$campo9}</b> {$campo8}</td>
   </tr>
      
    <tr>
     <td width="100%" colspan="1"> 
      <p> </p>
      <p style="margin: 0 5"><FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Patentes - Estatus 800<br>       	
      <p style="margin: 0 25" > <input type="text" name="ptit_800" value='{$ptit_800}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp;{$campof}
      <input type="text" name="pfec_800" {$modo1} value='{$pfec_800}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_800)" >
      <a href="javascript:showCal('Calendar122');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Negadas Patentes - Estatus 801<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_801" value='{$ptit_801}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_801" {$modo1} value='{$pfec_801}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_801)"  >
      <a href="javascript:showCal('Calendar123');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Denegada Patentes - Estatus 802<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_802" value='{$ptit_802}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_802" {$modo1} value='{$pfec_802}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_802)"  >
      <a href="javascript:showCal('Calendar124');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Prioridad Extinguida Publicacion Defectuosa Patentes - Estatus 804<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_804" value='{$ptit_804}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_804" {$modo1} value='{$pfec_804}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_804)"  >
      <a href="javascript:showCal('Calendar125');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Perencion de Procedimiento Orden de Publicacion Prensa Patentes - Estatus 805<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_805" value='{$ptit_805}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_805" {$modo1} value='{$pfec_805}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_805)"  >
      <a href="javascript:showCal('Calendar126');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Abandonada Patentes - Estatus 806<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_806" value='{$ptit_806}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_806" {$modo1} value='{$pfec_806}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_806)"  >
      <a href="javascript:showCal('Calendar127');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Nulidad a la Concesión pendiente de Notificación Patentes - Estatus 809<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_809" value='{$ptit_809}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_809" {$modo1} value='{$pfec_809}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_809)"  >
      <a href="javascript:showCal('Calendar128');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Solicitud en Tramite con Petición de Nulidad del Acto Administrativo Patentes - Estatus 821<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_821" value='{$ptit_821}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_821" {$modo1} value='{$pfec_821}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_821)"  >
      <a href="javascript:showCal('Calendar129');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Recurso de Reconsideración - Disposición Administrativa que afecta al Registro Patentes - Estatus 833<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_833" value='{$ptit_833}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_833" {$modo1} value='{$pfec_833}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_833)"  >
      <a href="javascript:showCal('Calendar130');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Patente con Solicitud de Nulidad, pendiente de Notificar - Estatus 835<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_835" value='{$ptit_835}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_835" {$modo1} value='{$pfec_835}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_835)"  >
      <a href="javascript:showCal('Calendar131');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Solicitud de Nulidad Notificada - Estatus 836<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_836" value='{$ptit_836}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_836" {$modo1} value='{$pfec_836}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_836)"  >
      <a href="javascript:showCal('Calendar132');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Registro con Nulidad por Disposición Administrativa - Estatus 837<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_837" value='{$ptit_837}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_837" {$modo1} value='{$pfec_837}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_837)"  >
      <a href="javascript:showCal('Calendar135');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración Disposición Administrativa de Nulidad de Registro Patentes - Estatus 838<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_838" value='{$ptit_838}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_838" {$modo1} value='{$pfec_838}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_838)"  >
      <a href="javascript:showCal('Calendar133');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración - Solicitud Desistida Patentes - Estatus 840<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_840" value='{$ptit_840}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_840" {$modo1} value='{$pfec_840}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_840)"  >
      <a href="javascript:showCal('Calendar134');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración - Patente Sin Efecto por Falta de Pago de Anualidad Publicada - Estatus 921<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_921" value='{$ptit_921}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_921" {$modo1} value='{$pfec_921}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_921)"  >
      <a href="javascript:showCal('Calendar136');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
     <td width="100%" colspan="1"> 
      <p style="margin: 0 2"> <FONT COLOR=2B547E><b><i>- Reconsideración - Patente Sin Efecto por Vencimiento de Termino Publicada - Estatus 922<br>
      <p style="margin: 0 25" > <input type="text" name="ptit_922" value='{$ptit_922}' size="90" maxlength="200" align="left"   {$modo1}  >&nbsp; {$campof}
      <input type="text" name="pfec_922" {$modo1} value='{$pfec_922}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forboletin.pfec_922)"  >
      <a href="javascript:showCal('Calendar137');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
   </td>
  </tr> 
  </table>
  </div>

  </form>
  </tr> 
  </table>

</tr>
</table>


</div>  
&nbsp;

