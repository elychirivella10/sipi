<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="javascript" src="../include/cal2.js"></script>
    <script language="javascript" src="../include/cal_conf2.js"></script>
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="m_devanota.php?vopc=1" method="post">
      <table>
        <tr>
            <td class="izq5-color">{$lregistro}</td>
	    <td class="der-color">
              <input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$vreg1}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas1.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
	      <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$vreg2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vreg2,6)">&nbsp;&nbsp;
	    <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td></p>
        </tr>
      </table>
    </form>			  
    <form name="formarcas2" action="m_devanota.php?vopc=3" method="post" onsubmit='return pregunta();'>
      <input type="hidden" name="vsolh" value='{$solicitud1}-{$solicitud2}'>
      <input type="hidden" name="vder" value='{$vder}'>
      <input type="hidden" name="vopcpod" value=0>
      <input type="hidden" name="vreg1" value={$vreg1}>
      <input type="hidden" name="vreg2" value={$vreg2}>
            
      <table>
       <tr>
         <!-- <td class="izq-color">{$lfechaevent}</td>
	 <td class="der-color"><input size="9" type="text" name="vfevh" value='{$vfec}'  onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td>
    	 <td>{$espacios}&nbsp;&nbsp;</td>-->
	 <td class="izq5-color">{$ltramite}</td>
         <td class="der-color">
            <select size="1" name="tramite" >
              {html_options values=$arrayvtrami selected=$tramite output=$arrayttrami}
            </select>
         </td>
    	 <td>{$espacios}&nbsp;&nbsp;</td>
         <td class="izq5-color">{$lfecharen}</td>
	      <td class="der-color">
	         <input size="9" type="text" name="vfechr" value='{$vfechr}' onkeyup="checkLength(event,this,10,document.formarcas2.vnumtram)"
	    onchange="valFecha(this,document.formarcas2.vnumtram)">
            &nbsp;&nbsp;
            <a href="javascript:showCal('Calendar51');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	      <td>
       <td class="izq5-color">{$lnumtra}</td>
	    <td class="der-color">
           <input type="text" name="vnumtram" size="10" maxlength="10" value='{$vnumtram}'>
       </td>
       </tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lsolicitud}</td>
	    <td class="der-color">
              <input type="text" name="vsol1" size="3" maxlength="4" value='{$vsol1}' {$vmodo}>-
              <input type="text" name="vsol2" size="6" maxlength="6" value='{$vsol2}' {$vmodo}>             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$lfechasolic}&nbsp;
              <input size="10" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}>
            </td>
          {if ($vmod eq "G" || $vmod eq "M") }
	        <td class="der-color" rowspan="6" align="center" valign="top">
                <a href='{$nameimage}' target="_blank">
                <img border="-1" src={$nameimage} width="156"></td>
	    {/if}    
	</tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="63" type="text" name="vnom" value='{$nombre}' {$vmodo}>   </td>
	</tr>
	<tr><td class="izq-color">{$lclase}</td>
	   <td class="der-color">
             <input size="1" type="text" name="vcla" value='{$clase}' {$vmodo}>
	     <input size="14" type="text" name="vindcla" value='{$ind_claseni}' {$vmodo}>
             &nbsp;&nbsp;{$lctipom}
	     <input size="30" type="text" name="vtipo" value='{$lctipo} - {$tipomarca}' {$vmodo}>
           </td>
        </tr>
	<tr>
         <td class="izq-color" >{$lmodal}</td>
         <td class="der-color">
           <input size="15" name="vmod" {$vmodo} value='{$vmod} - {$vmodal}'>
         </td>
        </tr>
	<tr>
         <td class="izq-color" >{$lestatus}</td>
         <td class="der-color">
           <input size="63" name="ves" {$vmodo} value='{$vest} - {$vdest}'>
         </td>
        </tr>
      </table>
    &nbsp;

   <table cellspacing="1" border="1">
   <tr><td class="izq4-color" colspan="2">Datos del Poder / Agente / Tramitante:</td>
       <td class="izq4-color" colspan="2">(Llenar &uacute;nicamente cuando los datos esten desactualizados)</td>
   </tr>
   <tr>
       <td class="izq-color" >Tramitante Actual:</td>
       <td class="der-color">
           <input type="text" name="vtramita" value='{$vtramita}' size="50" readonly="readonly">
       </td>
       <td class="izq3-color" >Nuevo Tramitante:</td>
       <td class="der-color">
           <input type="text" name="tramitante" value='{$tramitante}' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
       </td>
   </tr>
   <tr>
       <td class="izq-color" >Poder Actual:</td>
       <td class="der-color">
           <input size="50" name="vpoder" {$vmodo} value='{$vpoder}'>
       </td>
       <td class="izq3-color" >Nuevo Poder:</td>
       <td class="der-color">
           <input type="text" name="vpod1" value='{$vpod1}' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas2.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
           <input type="text" name="vpod2" value='{$vpod2}' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.busca)">&nbsp;&nbsp;
           <input type='image' name='busca' src="../imagenes/find.png" value="Buscar"  onclick="document.formarcas2.vopcpod.value=1;">
       </td>
    </tr> 
    <tr>
      <td class="izq-color" >Agente(s):</td>
      <td class="der-color">
          <textarea rows="2" readonly="readonly" name="vtragen" cols="60">{$vtragen}</textarea>
      </td>
      <td class="izq3-color" >Agente(s):</td>
      <td class="der-color">
          <textarea rows="2" readonly="readonly" name="poderhabi" cols="60">{$poderhabi}</textarea>
      </td>
    </tr>
    </table>
    &nbsp;

      {if $vopc neq 0}
      <H3>{$lcausadev}</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color">{$uno}</td><td class="der-color"><input type="checkbox" name="causa1" {$ck_causa1}><td>
	 <td class="der-color">{$luno}</td>
	 <td class="izq-color">{$dos}</td><td class="der-color"><input type="checkbox" name="causa2" {$ck_causa2}><td>
	 <td class="der-color">{$ldos}</td></tr><tr>
	 <td class="izq-color">{$tres}</td><td class="der-color"><input type="checkbox" name="causa3" {$ck_causa3}><td>
	 <td class="der-color">{$ltres}</td>
	 <td class="izq-color">{$cuatro}</td><td class="der-color"><input type="checkbox" name="causa4" {$ck_causa4}><td>
	 <td class="der-color">{$lcuatro}</td></tr><tr>
	 <td class="izq-color">{$cinco}</td><td class="der-color"><input type="checkbox" name="causa5" {$ck_causa5}><td>
	 <td class="der-color">{$lcinco}</td>
	 <td class="izq-color">{$seis}</td><td class="der-color"><input type="checkbox" name="causa6" {$ck_causa6}><td>
	 <td class="der-color">{$lseis}</td></tr><tr>
	 <td class="izq-color">{$siete}</td><td class="der-color"><input type="checkbox" name="causa7" {$ck_causa7}><td>
	 <td class="der-color">{$lsiete}</td>
	 <td class="izq-color">{$ocho}</td><td class="der-color"><input type="checkbox" name="causa8" {$ck_causa8}><td>
	 <td class="der-color">{$locho}</td></tr><tr>
	 <td class="izq-color">{$nueve}</td><td class="der-color"><input type="checkbox" name="causa9" {$ck_causa9}><td>
	 <td class="der-color">{$lnueve}</td>
	 <td class="izq-color">{$diez}</td><td class="der-color"><input type="checkbox" name="causa10" {$ck_causa10}><td>
	 <td class="der-color">{$ldiez}</td></tr><tr>
	 <td class="izq-color">{$once}</td><td class="der-color"><input type="checkbox" name="causa11" {$ck_causa11}><td>
	 <td class="der-color">{$lonce}</td>
	 <td class="izq-color">{$doce}</td><td class="der-color"><input type="checkbox" name="causa12" {$ck_causa12}><td>
	 <td class="der-color">{$ldoce}</td></tr><tr>
	 <td class="izq-color">{$trece}</td><td class="der-color"><input type="checkbox" name="causa13" {$ck_causa13}><td>
	 <td class="der-color">{$ltrece}</td>
	 <td class="izq-color">{$catorce}</td><td class="der-color"><input type="checkbox" name="causa14" {$ck_causa14}><td>
	 <td class="der-color">{$lcatorce}</td></tr><tr>
	 <td class="izq-color">{$quince}</td><td class="der-color"><input type="checkbox" name="causa15" {$ck_causa15}><td>
	 <td class="der-color">{$lquince}</td>
	 <td class="izq-color">{$dieciseis}</td><td class="der-color"><input type="checkbox" name="causa16" {$ck_causa16}><td>
	 <td class="der-color">{$ldieciseis}</td></tr><tr>
	 <td class="izq-color">{$diecisiete}</td><td class="der-color"><input type="checkbox" name="causa17" {$ck_causa17}><td>
	 <td class="der-color">{$ldiecisiete}</td> 
	 {if $ldieciocho neq ''}
	 <td class="izq-color">{$dieciocho}</td><td class="der-color"><input type="checkbox" name="causa18" {$ck_causa18}><td>
	 <td class="der-color">{$ldieciocho}</td></tr><tr> 
	 <td class="izq-color">{$diecinueve}</td><td class="der-color"><input type="checkbox" name="causa19" {$ck_causa19}><td>
	 <td class="der-color">{$ldiecinueve}</td> 
	 <td class="izq-color">{$veinte}</td><td class="der-color"><input type="checkbox" name="causa20" {$ck_causa20}><td>
	 <td class="der-color">{$lveinte}</td></tr><tr>  
	 <td class="izq-color">{$veintiuno}</td><td class="der-color"><input type="checkbox" name="causa21" {$ck_causa21}><td>
	 <td class="der-color">{$lveintiuno}</td> 

	 {/if}
	</tr>
	</table>
	<table cellspacing="1" border="1">
	<tr>
	   <td class="izq-color">{$lotro}</td><td class="der-color"><input size="90" type="text" name="otro" value='{$otro}' maxlength="500" ><td>
	</tr>
	</table>
     </table>
     {/if}
     &nbsp;

    <table width="315">
    <tr>
      <td class="der">
      <td class="cnt"><a href="../consultamarcas/busca_marcas_n.php?vnsol={$vsol1}-{$vsol2}&vopc=2&vusuario=7" target="_blank">
      <img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
      <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
      <td class="cnt"><a href="m_devanota.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
      </td>
    </tr>
    </table></center>

    </form>
  </div>  
  </body>
</html>

