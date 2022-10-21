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

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

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

<table>
<tr>

<form name="forboletin" id="forboletin" enctype="multipart/form-data" action="b_ingreso.php?vopc=2" method="POST" onsubmit='return pregunta();'> 
  <input type='hidden' name='nbol' value='{$nbol}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='accion' value='{$accion}'>
  <input type='hidden' name='string' value='{$string}'>
  <input type='hidden' name='campos' value='{$campos}'>
  
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
      <p style="margin: 0 2"><FONT COLOR=2B547E><b><i>- Patentes Sin Efecto x Falto de Pago<br>  
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

   </td>
  </tr> 
  </table>
  </div>

</tr>
</table>

</form>
</div>  
&nbsp;
