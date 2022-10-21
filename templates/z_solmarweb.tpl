<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../include/js/wforms.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

&nbsp;
<div align="center">
{if $vopc eq 5}
  <form name="formarcas2" enctype="multipart/form-data" action="z_solmarweb.php?vopc=2"   
        method="POST" onsubmit='return pregunta();'>
{/if}
{if $vopc eq 3}
  <form name="formarcas3" enctype="multipart/form-data" action="z_solmarweb.php?vopc=3"   
        method="POST" onsubmit='return pregunta();'>
{/if}
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vreftra' value={$vreftra}>
  <input type ='hidden' name='vrefsol' value={$vrefsol}>
  <input type ='hidden' name='vnumsol' value={$vnumsol}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='auxnum' value={$auxnum}>
  <input type ='hidden' name='cosxmar' value={$cosxmar}>
  <input type ='hidden' name='vtipo_mp' value={$vtipo_mp}>
  <input type ='hidden' name='vtipper' value={$vtipper}>
  <input type ='hidden' name='vtipage' value={$vtipage}>
  <input type ='hidden' name='vcansol' value={$vcansol}>
  <input type ='hidden' name='vtipbus' value={$vtipbus}>
  <input type ='hidden' name='vtippro' value={$vtippro}>
  <input type ='hidden' name='vfecact' value={$vfecact}>
&nbsp;

<div align="center">
<table width="752" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td>
<fieldset>
   <legend align='center'>
      <strong><span class="Estilo3">CORRECCION DE DATOS - Ref_Tramite: {$vreftra} / Ref_Solicitud: {$vrefsol}</font></span><br></strong> 
   </legend>
   <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
   <tr><td class="izq9-color">DATOS DEL SOLICITANTE(S):</td></tr>
   <tr><td colspan=2 class="izq8-color">
          <label for="reg_part">INDOLE:</label>
          <input type="radio" name="rtipoper" value="1" checked 
                 onchange="visible_per(this.value);"> Persona Natural
          <input type="radio" name="rtipoper" value="2" 
                 onchange="visible_per(this.value);"> Cooperativa 
          <input type="radio" name="rtipoper" value="3" 
                 onchange="visible_per(this.value);"> Persona Jur&iacute;dica Nacional 
          <input type="radio" name="rtipoper" value="4" 
                 onchange="visible_per(this.value);"> Persona Jur&iacute;dica Extranjera
   </td></tr>
   <tr><td colspan=2 class="izq8-color">
          <p id="tpernat" STYLE="display:inline">C&eacute;dula:</p>
          <select size="1" name="lcedtit" id="lcedtit" STYLE="display:inline" class="required" onchange="visible_pas(this.value);">
             <option VALUE="V" selected>V</option>
             <option VALUE="E">E</option> 
             <option VALUE="P">P</option> 
          </select>
          <input type="text" name="vcedtit" size="8" maxlength="9" STYLE="display:inline" class="required" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">
          <input type="text" name="vpastit" size="14" maxlength="14" STYLE="display:none" class="required">    
          <p id="tperjurn" STYLE="display:none">Rif:</p>
          <select size="1" name="lriftit" id="lriftit" STYLE="display:none" class="required">
             <option VALUE="J" selected>J</option>
<!--             <option VALUE="G">G</option> -->
          </select>
          <input type="text" name="vriftit" size="9" maxlength="9" STYLE="display:none" class="required" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">  
          <p id="tperjure" STYLE="display:none">Nombre de la Empresa:</p>
          <input type="text" name="vnomtit" size="30" STYLE="display:none" onkeyup="this.value=this.value.toUpperCase();" class="required">  
          <input type="button" value="Buscar"  name="vbuscartit" 
                 onclick="b_titular(document.all.vrefsol,document.all.vtipper,document.all.lcedtit, document.all.vcedtit,document.all.lriftit, document.all.vriftit,document.all.vnomtit,document.all.vtipo_mp,document.all.vreftra,document.all.vpastit)" class="boton_cream">
   </td></tr> 
   <tr><td>
      <iframe id='top' frameborder='0' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitulares.php?vtra={$vreftra}&vsol={$vrefsol}&vder={$vtipo_mp}"></iframe></td></tr>  
   </table>
   &nbsp;
   &nbsp;
   <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
   <tr><td class="izq9-color">DATOS DEL APODERADO / TRAMITANTE:</td></tr>
   <tr><td colspan=2 class="izq8-color">
          <label for="reg_part2">TIPO:</label>
          <input type="radio" name="rtipoage" value="1" checked 
                 onchange="visible_age(this.value);"> Agente de la P.I.
          <input type="radio" name="rtipoage" value="2" 
                 onchange="visible_age(this.value);"> Tramitante 
          <input type="radio" name="rtipoage" value="3" 
                 onchange="visible_age(this.value);"> Apoderado 
   </td></tr>
   <tr><td colspan=2 class="izq8-color">
          <p id="tperage" STYLE="display:inline">C&oacute;digo del Agente:</p>
          <input type="text" name="vcodage" size="8" maxlength="9" STYLE="display:inline" class="required" onkeyup="number_sindec(this);">
          <p id="tpertra" STYLE="display:none">C&eacute;dula:</p>
          <select size="1" name="lcedtra" id="lcedtra" STYLE="display:none" class="required" onchange="visible_cedtra(this.value);">
             <option VALUE="V" selected>V</option>
             <option VALUE="E">E</option> 
             <option VALUE="P">P</option> 
          </select>
          <input type="text" name="vcedtra" size="8" maxlength="9" STYLE="display:none" class="required" onkeyup="number_sindec(this);" onchange="for(var x=this.value.length;x<9;x++)
this.value='0'+this.value;">
          <input type="text" name="vpastra" size="14" maxlength="14" STYLE="display:none" class="required">   
          <input type="button" value="Buscar"  name="vbuscarage" 
                 onclick="b_agente(document.all.vrefsol,document.all.vtipage,document.all.lcedtra, document.all.vcedtra,document.all.vpastra, document.all.vcodage,document.all.vtipo_mp,document.all.vreftra)" class="boton_cream"> 
   </td></tr>
   <tr><td>
      <iframe id='top' frameborder='0' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragentes.php?vtra={$vreftra}&vsol={$vrefsol}&vder={$vtipo_mp}"></iframe></td></tr>  
   </table>
   &nbsp;
   &nbsp;
   <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
   <tr><td class="izq9-color">DATOS DE PRIORIDAD EXTRANJERA:</td></tr>
   <tr><td class="izq8-color">PRIORIDAD:
          <input type="text" name="vpri" size="60" maxlength='120' class="required">
          <input type="button" value="Buscar"  name="vbuscarpri" 
                 onclick="b_prioridad(document.all.vrefsol,document.all.vpri,document.all.vtipo_mp,document.all.vreftra)" class="boton_cream"><br></td></tr> 
   <tr><td>
       <iframe id='top' frameborder='0' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_verprioridad.php?vtra={$vreftra}&vsol={$vrefsol}&vder={$vtipo_mp}"></iframe></td></tr>  
   </td></tr>  
   </table>
   &nbsp;
   &nbsp;
   <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
   <tr><td colspan=2 class="izq9-color">DATOS DEL SIGNO:</td></tr>
   <tr><td colspan=2 class="izq8-color">
          <label for="reg_part">TIPO DE SIGNO:</label>
          <input type="radio" name="group2" value="1" {$checksigno1} 
                 onchange="visible_ref(this.value);"> Nominativo
          <input type="radio" name="group2" value="2" {$checksigno2}
                 onchange="visible_ref(this.value);"> Gr&aacute;fico
          <input type="radio" name="group2" value="3" {$checksigno3}
                 onchange="visible_ref(this.value);"> Mixto
   </td></tr>
   <tr><td colspan=2 class="izq8-color"><p id="tbusfon" align='left' STYLE="{$checkreffon}">Referencia B&uacute;squeda Fon&eacute;tica:</p>
          <input type="text" name="vbusfon" value="{$vbusfon}" size="10" STYLE="{$checkreffon}" class="required">  
          <p id="tbusgra" STYLE="{$checkrefgra}">Referencia B&uacute;squeda Gr&aacute;fica:</p>
          <input type="text" name="vbusgra" value="{$vbusgra}" size="10" STYLE="{$checkrefgra}" class="required"> 
          <input type="button" value="Buscar" name="vbusdat" onclick="b_busqueda(document.all.vrefsol,document.all.vtipbus,document.all.vbusfon,document.all.vbusgra, document.all.vtipo_mp,document.all.vreftra)" class="boton_cream"> </strong></td></tr>
   <tr><td colspan=2>
       <iframe id='top' frameborder='0' style='width:100%;height:110px;background-color:WHITE;' src="../comun/z_verbusqueda.php?vtra={$vreftra}&vsol={$vrefsol}&vder={$vtipo_mp}"></iframe>
   </td></tr>
   <tr valign='top'><td class="izq8-color" valign='top'><p valign='top' id="teti" STYLE="{$checkrefgra}">Descripci&oacute;n de la Etiqueta:</p></td><td>
       <textarea id='veti' name="veti" cols="75" rows="2" STYLE="{$checkrefgra}" class="required" onchange='isetivalida(this);'>{$veti}</textarea>
   </td></tr>
   </table>
   &nbsp;
   &nbsp;
   <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
   <tr><td colspan=2 class="izq9-color">PRODUCTO(S) O SERVICIO(S) QUE SE DISTINGUE(N):</td></tr>
   <tr><td width='50%' class="izq8-color">TIPO DE PRODUCTO:
          <input type="radio" name="group3" value="Nacional" onchange="visible_pai(this.value);" {$checkpaisn}>Nacional
          <input type="radio" name="group3" value="Extranjero" onchange="visible_pai(this.value);" {$checkpaise}>Extranjero</td>
       <td width='50%' class="izq8-color">PAIS:
          <select size="1" name="vpap" class="required" STYLE="{$checkdespaise}"
                  onchange="this.form.vpap.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodpais selected=$vpaisor output=$arraynompais}
          </select>
          <input type='text' name='vpav' size='20' STYLE="{$checkdespaisn}" class="required" value="VENEZUELA" readonly>
    </td></tr>
    <tr><td COLSPAN='2' class="izq8-color">DISTINGUE LA LISTA DE PRODUCTO(S) O SERVICIO(S):</td></tr>
    <tr><td colspan='2'>
        <iframe name='productos' frameborder='0' style='width:100%;height:150px;background-color:WHITE;' src="../comun/z_verproductos.php?vtra={$vreftra}&vsol={$vrefsol}&vder={$vtipo_mp}"></iframe>
    </td>  
    </tr> 
    </table>
   &nbsp;
   &nbsp;
</fieldset>
</td></tr>
</table>

&nbsp;
<table align="center">
<tr>
    <td class="cnt">
       <img src="../imagenes/arrow_left_white.png" />&nbsp;<input name="tramite" type=submit value="Guardar Datos de la Solicitud" class="botones"> 
       &nbsp;&nbsp;&nbsp;</td>
    </td> 
    <td class="cnt">
    {if $vmodo eq 'update'}
      <img src="../imagenes/arrow_left_white.png" />&nbsp;<a href="javascript:history.back()"><input type=button value=" Cancelar " class="botones"></a>
    {else} 
      <img src="../imagenes/arrow_left_white.png" />&nbsp;<a href="../index1.php"><input type=button value=" Salir " class="botones"></a>
    {/if}
    </td>
</tr>
</table>
&nbsp;
&nbsp;

</form>
</div>  
</body>
</html>
