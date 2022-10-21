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
  <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=5"  method="POST" >  
{/if} 		  
{if $vopc eq 4}
  <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=1"  method="POST" >  
{/if} 		  
{if $vopc eq 6}
  <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=7"  method="POST" >  
{/if} 		  

  <table>
     <tr>
      <td class="izq5-color">{$campo4}</td>
      <td class="der-color">
	      <input tabindex="1" type="text" name="nctrlcer" size="5" maxlength="5" value='{$nctrlcer}' readonly > 
      </td>
      {if $vopc eq 3}
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/boton_nuevo_rojo.png">
        </form>
      </td>
      {/if} 		  
      {if $vopc eq 4 || $vopc eq 6}
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png">
        </td>
      {/if}    
  </tr>
  </table>
  <br />
</form>				  

<br>
{if $vopc eq 1 || $vopc eq 5}
  <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=2"  method="POST" onsubmit='return pregunta();'>
{/if}    
<!-- <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=2"  method="POST" > -->
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="nctrlcer" value='{$nctrlcer}'>
   <input type="hidden" name="direccion" value='{$direccion}'>
     
   <table cellspacing="1" border="1">
   <tr>
     <!--<tr>
       <td class="izq-color">{$campo4}</td>
       <td class="der-color" >
	      <input type="text" name="nctrlcer" size="5" maxlength="5" value='{$nctrlcer}' readonly > 
       </td>
     </tr> -->

     <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <select size='1' name='tipo' {$modo1}>
           {html_options values=$arraytipo selected=$tipo output=$arraytipo}
        </select>
      <td>
     </tr>
     <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
         <input type="text" name="fechaper" {$modo} value='{$fechaper}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forlotes.vpag)" onchange="valFecha(this,document.forlotes.vpag)" >
         &nbsp;
         <a href="javascript:showCal('Calendar65');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    </table>

   &nbsp; <p></p>
   <font class='nota6'><b>SOLICITANTE:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der-color" >
	      <input type="text" name="solicitante" {$modo} size="70" maxlength="80" value='{$solicitante}' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der-color" >
          <select size="1" name="lced" {$modo2}>
            {html_options values=$lced_id selected=$lced output=$lced_de}
          </select>
	  <input type="text" name="cisolicita" {$modo} size="9" maxlength="9" value='{$cisolicita}' onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.forlotes.cisolicita,9)" onkeyup="checkLength(event,this,9,document.forlotes.telefono)">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo7}</td>
       <td class="der-color" >
	      <input type="text" name="telefono" {$modo} size="15" maxlength="15" value='{$telefono}'>
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo8}</td>
       <td class="der-color" >
	      <input type="text" name="correo" {$modo} size="70" maxlength="80" value='{$correo}'>
       </td>
     </tr>
    <!-- <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <select size="1" name="indole">
          {html_options values=$arrayvind selected=$indole output=$arraytind}
        </select>
      </td>
    </tr> -->  
    <tr>
      <td class="izq-color">{$campo9}</td>
      <td class="der-color">
        <!-- <input type="checkbox" name="gestor_pn" {$modo} onClick="habilagen(document.forlotes.agente,this)">Persona Natural Titular&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_pj" {$modo} onClick="habilagen(document.forlotes.agente,this)">Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>  
        <input type="checkbox" name="gestor_ap" {$modo} onClick="habilagen(document.forlotes.agente,this)">Apoderado&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_ag" {$modo} value='A' onClick="habilagen(document.forlotes.agente,document.forlotes.gestor_ag)">Agente de la Propiedad Industrial No.&nbsp;&nbsp; -->
        <input type="checkbox" name="gestor_pn" {$modo} >Persona Natural Titular&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_pj" {$modo} >Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>  
        <input type="checkbox" name="gestor_ap" {$modo} >Apoderado&nbsp;&nbsp;<br/>
        <input type="checkbox" name="gestor_ag" {$modo} onclick="agent(document.forlotes.gestor_ag,document.forlotes.agente);">Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        <input type="text" name='agente' size='6' maxlength="6" {$modo} onkeyup="checkLength(event,this,5,document.forlotes.indaut);fn(this.form,this);" onKeyPress="return acceptChar(event,2,this)"><br/> 
      </td>
    </tr> 
    </table>

   &nbsp; <p></p>
   <!-- <font class='nota6'><b>AUTORIZADO:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <select size="1" name="indaut" {$modo1}>
          {html_options values=$arrayvaut selected=$indaut output=$arraytaut}
        </select>
      </td>
     </tr> 
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der-color" >
	      <input type="text" name="autorizado" {$modo} size="70" maxlength="80" value='{$autorizado}' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der-color" >
          <select size="1" name="lced1" {$modo2}>
            {html_options values=$lced_id selected=$lced1 output=$lced_de}
          </select>
	  <input type="text" name="ciautorizado" {$modo} size="9" maxlength="9" value='{$ciautorizado}' onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.forlotes.ciautorizado,9)" onkeyup="checkLength(event,this,9,document.forlotes.vreg1)">

       </td>
     </tr>
    </table>
   &nbsp;  -->

   <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo5}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="m_verautoriza.php?pcod={$nctrlcer}"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
      &nbsp;<b>{$campo10}</b>
      <select size="1" id="indaut" name="indaut" {$modo1} onclick="aut(document.forlotes.indaut,document.forlotes.autorizado);">
          {html_options values=$arrayvaut selected=$indaut output=$arraytaut}
      </select>&nbsp;&nbsp; <I>Nombre Autorizado:&nbsp;</I>
      <input type="text" name="autorizado" {$modo3} size="55" onChange="javascript:this.value=this.value.toUpperCase();">
      <input type="button" class="boton_blue" value="Limpiar" name="limpiar1" {$modo2} onclick="document.forlotes.autorizado.value='';"> 
      <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vauti" {$modo2} onclick="browseautoriza(document.forlotes.nctrlcer,document.forlotes.autorizado,document.forlotes.vauti)">
      <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vaute" {$modo2} onclick="browseautoriza(document.forlotes.nctrlcer,document.forlotes.autorizado,document.forlotes.vaute)"> 
      <br>
    </td></tr> 
   </table>

   &nbsp; <p></p>
   <!-- <font class='nota6'><b>Expedientes a Solicitar:</b></font> -->
   &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo3}</td></tr>
    <tr><td>    
    <iframe id='top22' style='width:99%;height:180px;background-color: WHITE;' src="m_vercer.php?vcod={$nctrlcer}"></iframe> 
    </td></tr>
    <tr><td class="der-color"><b><I>N&uacute;mero Registro:&nbsp;</I></b>
        <input type="text" name="vreg1" {$modo} size="1" maxlength="1" value='{$vreg1}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forlotes.vreg2)" 
		    onchange="this.value=this.value.toUpperCase();document.forlotes.vreg1.value=this.value;">-
	     <input type="text" name="vreg2" {$modo} size="6" maxlength="6" value='{$vreg2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forlotes.vvienai1)"  
		    onchange="Rellena(document.forlotes.vreg2,6);document.forlotes.vreg2.value=this.value;">
        <input type="button" class="boton_blue" value="Limpiar" name="limpiar" {$modo2} onclick="document.forlotes.vreg1.value='';document.forlotes.vreg2.value='';"> 
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" {$modo2} onclick="cntrlcertificado(document.forlotes.vreg1,document.forlotes.vreg2,document.forlotes.vvienai,document.forlotes.nctrlcer)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" {$modo2} onclick="cntrlcertificado(document.forlotes.vreg1,document.forlotes.vreg2,document.forlotes.vvienae,document.forlotes.nctrlcer)">  
    </td></tr>
    </table>
    
   &nbsp;
   <table width="180">
    <tr>
     <tr>
      <td class="cnt"><input type="image" {$modo} src="../imagenes/boton_guardar_rojo.png"></td> 
      <td class="cnt"><a href="m_controlcert.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
    </tr>
   </table>
</form>

</div>  
</body>
</html>
