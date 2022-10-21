<html>
<head>
 <link REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
 <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
 <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript">  
 </script>
 <script language="javascript" src="../include/cal2.js"></script>
 <script language="javascript" src="../include/cal_conf2.js"></script>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">

{if $vopc eq 3}
<form name="foroobras" action="a_otrasobrnw.php?vopc=4&vpla={$vpla}" method="post">
{/if}
{if $vopc eq 7}
<form name="foroobras" action="a_otrasobrnw.php?vopc=8&vpla={$vpla}" method="post">
{/if}
  <table>
    <tr>
      <input type="hidden" name="nveces" value="{$nveces}">
      <input type="hidden" name="nconexion" value="{$nconexion}"> 
      <input type="hidden" name="npla" value="{$vpla}"> 
      <input type="hidden" name="nhora" value="{$vhora}"> 
      <td class="izq5-color">Planilla No.</td>
      <td class="der-color">
        <input type="text" name="vsol" size="4" maxlength="16" value='{$vsol}' {$modo} 
               onkeyup="checkLength (event,this,6,document.foroobras.vfechas)"
               onchange="Newsol(document.foroobras.vsol,6,document.foroobras.npla,document.foroobras.nhora)">
      </td>	
      {if $vopc eq 3}
      <td class="cnt">
          <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </td>
      {/if} 	
      {if $vopc eq 7}
      <td class="cnt">
  	  <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
      </td>
      {/if} 	  
      </td>
    </tr>
  </table>
</form>


<form name="forautor" id="forautor" enctype="multipart/form-data" 
      action="a_otrasobrnw.php?vopc={$accion}&vpla={$vpla}" 
      method="POST" onsubmit='return pregunta();'> 
  <input type ='hidden' name='vsol' value={$vsol}>
<table>
<tr>  
  <table>
  <tr>
    <input type="hidden" name="nveces" value="{$nveces}">
    <input type="hidden" name="nconexion" value="{$nconexion}"> 
    <td width="100%"><div><strong> </strong></div></td>
    <td align="rigth">
    <table>
    <tr>
      <td>
      {if $vopc eq 8 || $vopc eq 7}
      <a href="a_otrasobrnw.php?vopc=7&vpla={$vpla}&nveces={$nveces}&nconexion={$nconexion}" onmouseout="MM_swapImgRestore();"  
      {else}
      <a href="a_otrasobrnw.php?vopc=3&vpla={$vpla}&nveces={$nveces}&nconexion={$nconexion}" onmouseout="MM_swapImgRestore();"  
      {/if}
         onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	 <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
      </td>
      <td>&nbsp;</td>
      <td>
      {if $vopc eq 4 || $vopc eq 1 || $vopc eq 8}
      <input type="image" onmouseout="MM_swapImgRestore();" 
             onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" 
             src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" 
             onclick="validate();return returnVal;"/>
      {else}
      <a><img src="../imagenes/boton_guardar_rojo.png" onmouseout="MM_swapImgRestore();" 
              onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" alt="Save" 
              align="middle" name="save" border="0" /></a>
      {/if}
      </td>
      <td>&nbsp;</td>
      <td>
      <a href="../salir.php?nconex={$nconexion}" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_rojo.png',1);">
      <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>
      </td>
      <td>&nbsp;</td>
    </tr>
    </table>
  </tr>
  </table> 
 
<!--  <table align="center" border="2" cellspacing="3"> -->
  <tr>
  <div class="tab-page" id="modules-cpanel">
  <script type="text/javascript">
  var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
  </script> 
<!--  &nbsp;
  </div></tr></table> -->
 
  <div class="tab-page" id="Obra"><h2 class="tab">Obra</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Obra" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="1">
         <tr>
           <td width="30%" class="izq-color">Fecha Solicitud:</td>
           <td width="70%">
           <input type="text" name="vfechas" {$modo1} value='{$vfechas}' size="10" align="left" 
                  onkeyup="checkLength(event,this,10,document.forautor.vnumpla)" 
                  onchange="valFecha(this,document.forautor.vnumpla)">
                  &nbsp;&nbsp;
                  <small><a href="javascript:showCal('Calendar3');" 
                     onMouseOver="window.status='Seleccionar fecha'; return true;" 
                     onMouseOut="window.status=''; return true; ">
                  <img src="../imagenes/calendar2.gif" align="middle" 
                       width=26 height=24 border=0></a>
                  </small>
           <input type="hidden" name="vnumpla" value="{$vnumpla}">                  
           </td>
           <!-- <td>
           <input type="hidden" name="vnumpla" value="{$vnumpla}">
           </td> -->
         </tr> 
         <tr>
           <td width="30%" class="izq-color">T&iacute;tulo:</td>
           <td width="70%"> <!-- colspan="3" -->
           <input type"text" name="vtitulo" {$modo1} value='{$vtitulo}' size="182" maxlength="300" onKeyup="this.value=this.value.toUpperCase()"> 
           </td>
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Pa&iacute;s de Origen:</td>
           <td width="70%">
           <input type="hidden" name="vpaisor" {$modo1} value='{$vpaisor}' size="2" maxlength="2" 
                  align="left" onKeyup="this.value=this.value.toUpperCase();
                  checkLength(event,this,2,document.forautor.vpaisor)" 
                  onchange="valagente(document.forautor.vpaisor,document.forautor.pais)">
           <select size="1" name="pais" {$modo1} 
                   onchange="this.form.vpaisor.value=this.options[this.selectedIndex].value">
                   {html_options values=$arraycodpais selected=$vpaisor output=$arraynompais}
           </select>
         </td>
         </tr>
         <tr>
         <td width="30%" class="izq-color">Idioma Original:</td>
         <td width="70%">  
           <input type="hidden" name="vidioma" {$modo1} value='{$vidioma}' size="2" maxlength="2" 
                  align="left" onKeyup="this.value=this.value.toUpperCase();
                  checkLength(event,this,2,document.forautor.vtraduc)" 
                  onchange="valagente(document.forautor.vidioma,document.forautor.idioma)">
           <select size="1" name="idioma" {$modo1} 
                   onchange="this.form.vidioma.value=this.options[this.selectedIndex].value">
                   {html_options values=$arraycodidiom selected=$vidioma output=$arraynomidiom}
           </select>
           </td>
         </tr>
         {if $vpla eq 'AV'}
         <tr>
           <td class="izq-color" >Genero:</td>
           <td> <!-- colspan="3" -->
              <input type="text" name="vgener2" {$modo1} value='{$vgener2}' size="175" maxlength="300" onKeyup="this.value=this.value.toUpperCase();">
           </td> 
         </tr>
         {/if} 
         <tr>
           <td width="30%" class="izq-color">Traducci&oacute;n:</td>
           <td width="70%" > <!-- colspan="3" -->
              <input type="text" name="vtraduc" {$modo1} value='{$vtraduc}' size="182" maxlength="300" onKeyup="this.value=this.value.toUpperCase();">
           </td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >A&ntilde;o Realizaci&oacute;n:</td>
           <td width="70%">
           <input type="text" name="vanorea" {$modo1} value='{$vanorea}' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vanoppu)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color">A&ntilde;o 1era Publicaci&oacute;n:</td> 
           <td width="70%"> 
           <input type="text" name="vanoppu" {$modo1} value='{$vanoppu}' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vdescri)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td>  
         </tr>
         {if $vpla neq 'OE'}
         <tr>
           <td width="30%" class="izq-color" >Descripci&oacute;n:</td>
           <td width="70%"> <!-- colspan="3" -->
             <textarea row="2" name="vdescri" {$modo1} value='{$vdescri}' cols="138" maxlength="300">{$vdescri}</textarea>
           </td> 
         </tr>
         {/if} 
        {if $vpla eq 'OM'}
        </table>
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="17%" class="izq-color" >Letra:</td>
           <td width="27">
           {html_radios name="vletra" values=$vletra_id 
                        selected=$vletra output=$vletra_de separator=""}
           </td> 
           <td width="5%" class="izq-color" >Genero:</td>
           <td width="23%">
           <input type="hidden" name="vgenero" {$modo1} value='{$vgenero}' size="25" 
                  maxlength="30" align="left" onKeyup="this.value=this.value.toUpperCase();
                  checkLength(event,this,2,document.forautor.ritmo)" 
                  onchange="valagente(document.forautor.vgenero,document.forautor.genero)">
           <select size="1" name="genero" {$modo1} 
                   onchange="this.form.vgenero.value=this.options[this.selectedIndex].value">
                   {html_options values=$arraycodgenero selected=$vgenero output=$arraynomgenero}
           </select>

           <td width="5%" class="izq-color" >Ritmo:</td>
           <td width="23%">
           <input type="text" name="vritmo" {$modo1} value='{$vritmo}' size="25" maxlength="30" onKeyup="this.value=this.value.toUpperCase();">
           </td> 
         </tr>
        </table>
        {/if}
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="17%" class="izq-color" >Clasificaci&oacute;n:</td>
           <td width="23%">
             {html_radios name="vclasif" values=$vclasif_id selected=$vclasif output=$vclasif_de separator=""}
           </td>
           <td width="25%">
             {html_radios name="vorigen" values=$vorigen_id selected=$vorigen output=$vorigen_de separator=""}
           </td>
           <td width="35%">
             {html_radios name="vforma" values=$vforma_id selected=$vforma output=$vforma_de separator=""}
           </td>
         </tr>
        </table>
        &nbsp;
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2" width="100%" class="izq3-color" >
            En caso de ser una obra derivada, Indicar:</td>
         </tr>
         <tr>
           <td width="30%" class="izq-color" >T&iacute;tulo Obra Originaria:</td>
           <td width="70%">
           <input type="text" name="vtit_oo" {$modo1} value='{$vtit_oo}' size="182" maxlength="300" 
                  onKeyup="this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Autor Obra Originaria:</td>
           <td width="70%">
           <input type="text" name="vaut_oo" {$modo1} value='{$vaut_oo}' size="182" maxlength="300" 
                  onKeyup="this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Tipo Obra Derivada:</td>
           <td width="70%">
           <select name="vtip_od" {$modo1} value='{$vtip_od}'>
	           {html_options values=$vtip_od_id selected=$vtip_od output=$vtip_od_de}
	        </select>
           </td>  
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >A&ntilde;o publicaci&oacute;n Obra Originaria:</td>
           <td width="70%">
           <input type="text" name="vano_oo" {$modo1} value='{$vano_oo}' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vdat_pf)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td>  
         </tr>         
        </table>
        &nbsp;
        {if $vpla eq 'OE'}
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >Tipo Obra Escenica:</td>
           <td width="70%">
             {html_radios name="vcla_oe" values=$vcla_oe_id selected=$vcla_oe output=$vcla_oe_de separator=""}
             <input type="text" name="votroto" {$modo1} value='{$votroto}' size="30" maxlength="60" onKeyup="this.value=this.value.toUpperCase();">
           </td>
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Breve descripci&oacute;n Argumento:</td>
           <td width="70%">
           <textarea row="2" name="vdesarg" {$modo1} value='{$vdesarg}' cols="138" maxlength="600">{$vdesarg}</textarea></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Breve descripci&oacute;n Musica:</td>
           <td width="70%">  
           <textarea row="2" name="vdesmus" {$modo1} value='{$vdesmus}' cols="138" maxlength="600">{$vdesmus}</textarea></td>  
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Breve descripci&oacute;n Movimientos:</td>
           <td width="70%">
           <textarea row="2" name="vdesmov" {$modo1} value='{$vdesmov}' cols="138" maxlength="600">{$vdesmov}</textarea></td>  
         </tr>
        </table>
        &nbsp;
        {/if}
        {if $vpla eq 'OM'}
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2" width="100%" class="izq3-color" >
            En caso de que la obra haya sido fijada con fines de distribuci&oacute;n comercial, Indicar:
           </td>
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Datos Productor Fonogr&aacute;fico:</td>
           <td width="70%">
           <input type="text" name="vdat_pf" {$modo1} value='{$vdat_pf}' size="182" maxlength="300" onKeyup="this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >A&ntilde;o de la Fijaci&oacute;n Sonora:</td>
           <td width="30%">
           <input type="text" name="vano_fs" {$modo1} value='{$vano_fs}' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vexhibi)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td>  
         </tr>
        </table> 
        &nbsp;
        {/if}
        {if $vpla eq 'AV'}
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >Esta Exhibida Permanentemente?:</td>
           <td width="08">
           {html_radios name="vexhibi" values=$vexhibi_id selected=$vexhibi output=$vexhibi_de separator=""}
           </td> 
           <td width="10%" class="izq-color" >Ubicaci&oacute;n:</td>
           <td width="50%">
           <input type="text" name="vubi_ex" {$modo1} value='{$vubi_ex}' size="110" maxlength="120"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >La Obra ha sido Publicada?:</td>
           <td width="08">
           {html_radios name="vpublic" values=$vpublic_id selected=$vpublic output=$vpublic_de separator=""}
           </td> 
           <td width="10%" class="izq-color" >Publicaci&oacute;n:</td>
           <td width="50%">
           <input type="text" name="vdat_pu" {$modo1} value='{$vdat_pu}' size="110" maxlength="120"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >La Obra ha sido Edificada?:</td>
           <td width="08">
           {html_radios name="vedific" values=$vedific_id selected=$vedific output=$vedific_de separator=""}
           </td> 
           <td width="10%" class="izq-color" >Ubicaci&oacute;n:</td>
           <td width="50%">
           <input type="text" name="vubi_ed" {$modo1} value='{$vubi_ed}' size="110" maxlength="120"></td> 
         </tr>
        </table>
        &nbsp;
        {/if} 
       </div>
  </div>

  {if $vpla neq 'AR'}
  <div class="tab-page" id="Autor"><h2 class="tab">Autor(es)</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Autor" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="autor" {$modo1} value='{$autor}' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_a" value="Natural" {$bmodo} onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.Nperson_a)">
          <input type="button" name="Jperson_a" value="Juridica" {$bmodo} onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.Jperson_a)">
          <input type="button" name="CorregirU" value="Corregir" {$bmodo} onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.CorregirU)">
          <input type="button" name="EliminarU" value="Eliminar" {$bmodo} onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.EliminarU)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol}&vtipo=Autor"></iframe>
          </td></tr>
          <!-- <tr>
          <td colspan="2"> 
          <iframe name='frameauto' id='frameauto' style='width:100%;height:120px' 
                 src="d_consoli.php?psol={$vsol}&vtipo=Autor"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
        </table>
       </div>
  </div>
  {/if}

  {if $vpla eq 'AR'}
  <div class="tab-page" id="Coautor"><h2 class="tab">Co-autor(es)</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Coautor" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td width="16%" class="izq-color">Nombre o Raz&oacute;n Social:</td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="coautor" {$modo1} value='{$coautor}' size="60" 
                maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_c" value="Natural" {$bmodo} 
                onclick="browsecoautor(document.forautor.vsol,document.forautor.coautor, 
                         document.forautor.Nperson_c)">
          <input type="button" name="Jperson_c" value="Juridica" {$bmodo} 
                 onclick="browsecoautor
                (document.forautor.vsol,document.forautor.coautor,document.forautor.Jperson_c)">
          </td></tr>
          <tr>
          <td class="izq-color">Director o Realizador: </td>
          <td class="der-color">
          <iframe name='framecoauto1' id='framecoauto1' style='width:100%;height:70px' 
                 src="d_consoli.php?psol={$vsol}&vtipo=Coautor1"></iframe></td></tr>
         </div>
         </td>
         </tr>
         <tr>
         <td class="izq-color">Autor del Argumento de la Adaptaci&oacute;n:</td>
         <td class="der-color">
         <div id="resultado">
          <iframe name='framecoauto2' id='framecoauto2' style='width:100%;height:70px' 
                 src="d_consoli.php?psol={$vsol}&vtipo=Coautor2"></iframe></td></tr>
         </div>
         </td>
         </tr>
         <tr>
         <td class="izq-color">Autor del Gui&oacute;n o de los Di&aacute;logos:</td>
         <td class="der-color">
         <div id="resultado">
          <iframe name='framecoauto3' id='framecoauto3' style='width:100%;height:70px' 
                 src="d_consoli.php?psol={$vsol}&vtipo=Coautor3"></iframe></td></tr>
         </div>
         </td>
         </tr>
         <tr>
         <td class="izq-color">Autor de la M&uacute;sica especialmente compuesta:</td>
         <td class="der-color">
         <div id="resultado">
          <iframe name='framecoauto4' id='framecoauto4' style='width:100%;height:70px' 
                 src="d_consoli.php?psol={$vsol}&vtipo=Coautor4"></iframe></td></tr>
         </div>
         </td>
         </tr>
        </table>
       </div> 
  </div>
  {/if}

  {if $vpla eq 'OE' or $vpla eq 'AR' or $vpla eq 'PC'}
  <div class="tab-page" id="Productor"><h2 class="tab">Productor(es)</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Productor" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="productor" {$modo1} value='{$productor}' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_p" value="Natural" {$bmodo} onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.Nperson_p)">
          <input type="button" name="Jperson_p" value="Juridica" {$bmodo} onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.Jperson_p)">
          <input type="button" name="CorregirP" value="Corregir" {$bmodo} onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.CorregirP)">
          <input type="button" name="EliminarP" value="Eliminar" {$bmodo} onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.EliminarP)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol}&vtipo=Productor"></iframe>
          </td></tr>
          <!-- <tr>
          <td colspan="2"> 
          <iframe name='frameproductor' id='frameproductor' style='width:100%;height:120px' 
                 src="d_consoli.php?psol={$vsol}&vtipo=Productor"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
        </table>
       </div>
  </div>
  {/if}

  {if $vpla neq 'OE'}
  <div class="tab-page" id="Titular"><h2 class="tab">Titular(es)</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Titular" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="titular" {$modo1} value='{$titular}' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_t" value="Natural" {$bmodo} onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.Nperson_t)">
          <input type="button" name="Jperson_t" value="Juridica" {$bmodo} onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.Jperson_t)">
          <input type="button" name="CorregirT" value="Corregir" {$bmodo} onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.CorregirT)">
          <input type="button" name="EliminarT" value="Eliminar" {$bmodo} onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.EliminarT)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol}&vtipo=Titular"></iframe>
          </td></tr>
          <!--<tr>
          <td colspan="2"> 
          <iframe name='frametitular' id='frametitular' style='width:100%;height:120px' src="d_consoli.php?psol={$vsol}&vtipo=Titular"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
        </table>
       </div>
  </div>
  {/if}

  {if $vpla eq 'OE'}
  <div class="tab-page" id="Fijacion"><h2 class="tab">Fijaci&oacute;n</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Fijacion" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >A&ntilde;o de Fijaci&oacute;n:</td>
           <td width="70%">
           <input type="text" name="vano_fi" {$modo1} value='{$vano_fi}' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vtip_fi)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td> 
         </tr>
         <tr> 
           <td class="izq-color" >Tipo de Fijaci&oacute;n:</td>
           <td>
           <select name="vtip_fi">
	        {html_options values=$vtip_fi_id selected=$vtip_fi output=$vtip_fi_de}
	    </select> 
           </td>  
         </tr> 
         <tr>
           <td class="izq-color" >Ficha T&eacute;cnica:</td>
           <td>
           <textarea rows="4" name="vobs_fi" {$modo1} value='{$vobs_fi}' cols="136" maxlength="300">{$vobs_fi}</textarea></td> 
         </tr>
        </table>   
       </div>
  </div>
  {/if}

  {if $vpla eq 'AR'}
  <div class="tab-page" id="Artistas"><h2 class="tab">Artista(s)</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Artistas" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre del Artista:</td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="atista" {$modo1} value='{$atista}' size="60" 
                maxlength="300" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_a" value="Incluir Artista" {$bmodo} 
                onclick="browseatista(document.forautor.vsol,document.forautor.atista, 
                         document.forautor.Nperson_a)">
          </td></tr>
          <tr>
          <td colspan="2"> 
          <iframe name='frameatista' id='frameatista' style='width:100%;height:160px' src="d_consoli.php?psol={$vsol}&vtipo=Atista"></iframe></td></tr>
         </div>
         </td>
         </tr>
 
        </table>
       </div>
  </div>
  {/if}

  <div class="tab-page" id="Transferencia"><h2 class="tab">Transferencia</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Transferencia" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="10%" class="izq-color" >Transferencia:</td>
           <td width="90%">
           <textarea rows="4" name="vtransf" {$modo1} value='{$vtransf}' cols="157" maxlength="300">{$vtransf}</textarea></td> 
         </tr>
        </table>
       </div>
  </div>
  
  {if $vpla eq 'OL' or $vpla eq 'PC'}
  <div class="tab-page" id="Editor"><h2 class="tab">Editor/Impresor</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Editor" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td width="20%" class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td colspan="3" class="der-color">
         <div id="resultado">
          <input type="text" name="editor" {$modo1} value='{$editor}' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_e" value="Natural" {$bmodo} onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.Nperson_e)">
          <input type="button" name="Jperson_e" value="Juridica" {$bmodo} onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.Jperson_e)">
          <input type="button" name="CorregirE" value="Corregir" {$bmodo} onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.CorregirE)">
          <input type="button" name="EliminarE" value="Eliminar" {$bmodo} onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.EliminarE)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol}&vtipo=Editor"></iframe>
          <!-- <iframe name='frameeditor' id='frameeditor' style='width:100%;height:90px' src="d_consoli.php?psol={$vsol}&vtipo=Editor"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
         <tr>
           <td class="izq-color" >Tipo:</td>
           <td>
           {html_radios name="vtipoed" values=$vtipoed_id selected=$vtipoed output=$vtipoed_de separator=""}
           </td> 
         </tr>
         <tr>
           <td class="izq-color" >A&ntilde;o de Publicaci&oacute;n:</td>
           <td>
           <input type="text" name="vanopue" {$modo1} value='{$vanopue}' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vnoedic)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >No. de Edici&oacute;n:</td>
           <td>
           <input type="text" name="vnoedic" {$modo1} value='{$vnoedic}' size="8" maxlength="10"
                  onkeyup="checkLength(event,this,3,document.forautor.vnoejem)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >No. de Ejemplares:</td>
           <td>
           <input type="text" name="vnoejem" {$modo1} value='{$vnoejem}' size="8" maxlength="10"
                  onkeyup="checkLength(event,this,3,document.forautor.vcar_ed)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >Caracter&iacute;sticas Edici&oacute;n:</td>
           <td colspan="3">
           <input type="text" name="vcar_ed" {$modo1} value='{$vcar_ed}' size="91" 
                  maxlength="300"></td> 
         </tr>
        </table>
       </div>
  </div>
  {/if}

  <div class="tab-page" id="solicitante"><h2 class="tab">Solicitante</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "solicitante" ) );
       </script>
       <div align="left">
       <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
        <tr>
         <td width="20%" class="izq-color">{$campo15}</td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="solicitante" {$modo1} value='{$solicitante}' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson" value="Natural" {$bmodo} onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Nperson)">
          <input type="button" name="Jperson" value="Juridica" {$bmodo} onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Jperson)">
          <input type="button" name="Corregir" value="Corregir" {$bmodo} onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Corregir)">
          <input type="button" name="Eliminar" value="Eliminar" {$bmodo} onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Eliminar)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol={$vsol}&vtipo=Solicitante"></iframe>                                
          <!-- <iframe name='framesoli' id='framesoli' style='width:100%;height:90px' src="d_consoli.php?psol={$vsol}&vtipo=Solicitante"></iframe> -->
         </div>
         </td>
        </tr> 
        <tr>
         <td class="izq-color">{$campo16}</td>
         <td class="der-color"><small>
            {html_radios name="tipo_caracter" values=$tipo_carac selected=$tipo_caracter output=$carac_def separator=""}</small>
         </td>
        </tr> 
        <tr>
         <td class="izq-color">{$campo17}</td>
         <td class="der-color">
         <input type="text" name="otro_caracter" {$modo1} value='{$otro_caracter}' size="85" maxlength="100" onKeyup="this.value=this.value.toUpperCase()">
         </td>
        </tr>
        <tr>
         <td class="izq-color">{$campo18}</td>
         <td class="der-color">
         <textarea rows="2" name="prueba_repres" {$modo1} cols="140" maxlength="1024" onKeyup="this.value=this.value.toUpperCase()">{$prueba_repres}</textarea>
         </td>
        </tr>
       </table>
       </div>
  </div>
   
  <div class="tab-page" id="Deposito"><h2 class="tab">Dep&oacute;sito</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Deposito" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >N&uacute;mero Ejemplares Depositados:</td>
           <td width="70%">
           <input type="text" name="vnum_ej" {$modo1} value='{$vnum_ej}' size="8" maxlength="10"
                  onkeyup="checkLength(event,this,3,document.forautor.vsop_de)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >Tipo de Soporte Material:</td>
           <td>
           <input type="text" name="vsop_de" {$modo1} value='{$vsop_de}' size="89" 
                  maxlength="100" onkeyup="checkLength(event,this,100,document.forautor.vobs_de);
                  this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr>
           <td class="izq-color" >Observaciones:</td>
           <td>
           <textarea rows="4" name="vobs_de" {$modo1} value='{$vobs_de}' cols="130" maxlength="300">{$vobs_de}</textarea></td> 
         </tr>
        </table>        
       </div>
   </div>

   <div class="tab-page" id="hoja_ad"><h2 class="tab">Hoja Adicional</h2>
       <script type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "hoja_ad" ) );
       </script>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >Incluye Hojas Adicionales?:</td>
           <td width="70%">
           {html_radios name="vhoj_ad" values=$vhoj_ad_id selected=$vhoj_ad output=$vhoj_ad_de separator=""}
           </td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >N&uacute;mero Hojas Adicionales Anexas:</td>
           <td width="70%">
           <input type="text" name="vnum_ho" {$modo1} value='{$vnum_ho}' size="3" maxlength="5"
                  onkeyup="checkLength(event,this,3,document.forautor.vamplia)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Datos que han sido ampliados en Hojas adicionales:</td>
           <td width="70%">
             <textarea rows="2" name="vamplia" {$modo1} value='{$vamplia}' cols="130" maxlength="300">{$vamplia}</textarea></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Datos Adicionales:</td>
           <td width="70%">
             <textarea rows="8" name="vadicio" {$modo1} value='{$vadicio}' cols="130" maxlength="30000">{$vadicio}</textarea></td> 
         </tr>
        </table>        
       </div>
  </div>
  </tr>
  </table>
  &nbsp;
</div>
</form>
</body>
</html>
