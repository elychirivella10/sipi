<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio de Solicitud de Búsqueda Fonetica/Gráfica</title>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../libjs/wforms.js"></script>  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_gbfbusdia.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='tipfon' value='F'>
  <input type='hidden' name='tipgra' value='G'>

<div align="center">
<table width="752" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center' class='Estilo3'><strong><span>&nbsp;DATOS DE LA FACTURA&nbsp;</span></strong></legend>
  <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
         <input type="text" name="factura" {$modo} value='{$factura}' size="8" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.fechadep)" readonly>
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: F9999999 o E9999999</font> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fechadep" {$modo} value='{$fechadep}' size="11" maxlength="11" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.montodep)" onchange="valFecha(this,document.formarcas2.montodep);" class="required">
         &nbsp;&nbsp;
         <!-- <a href="javascript:showCal('Calendar85');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a> -->
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: dd/mm/aaaa</font> 
         <font class="obligatorio">*</font>
      </td>
    </tr>
    <!--<tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" {$modo1} class="required"> 
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
        <font class="obligatorio">*</font>
      </td>
    </tr> -->
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color">
         <input tabindex="8" type="text" name="solicitant" {$modo} value='{$solicitant}' size="59" maxlength="80" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,80,document.formarcas2.indole)" class="required">
         <font class="obligatorio">*</font>
      </td>
    </tr> 
    <!-- <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
           <select size="1" name="indole" class="required">
              {html_options values=$vindole_id selected=$indole output=$vindole_de}
           </select>
         <font class="obligatorio">*</font>
      </td>
    </tr>  -->
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <select size="1" name="lced" {$modo2} >
           {html_options values=$lced_id selected=$lced output=$lced_de}
        </select>
        <input tabindex="9" type="text" name='nced' size="9" maxlength="9" value='{$nced}' {$modo} 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)" class="required">
         <font class="obligatorio">*</font>
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <!-- <tr>
      <td class="izq-color">{$campo8}</td>
      <td class="der-color">
        <input tabindex="10" type="text" name='telefono' value='{$telefono}' {$modo} size="13" maxlength="14" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)" class="required"> 
        <small>Formato: (9999) 9999999</small>   
        <font class="obligatorio">*</font>
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
         <select size="1" name="vsede" {$modo1} >
          {html_options values=$vcodsede selected=$vsede output=$vnomsede}
         </select>
         <font class="obligatorio">*</font>
      </td>
    </tr>          
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
         <input type="text" id="nbusfon" name="nbusfon" {$modo} value='{$nbusfon}' size="2" maxlength="2" style="text-align: left" onKeyPress="return acceptChar(event,2, this)" onkeyup="valminimo(this.form);valcantidad(document.formarcas2.tipfon,this.form);" class="required"> 
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;M&aacute;x. Cantidad de b&uacute;squedas 99</font> 
         <font class="obligatorio">**</font>
      </td>
    </tr>  
   <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color">
         <input type="text" id="nbusgra" name="nbusgra" {$modo} value='{$nbusgra}' size="2" maxlength="2" style="text-align: left" onKeyPress="return acceptChar(event,2, this)" onkeyup="valminimo(this.form);valcantidad(document.formarcas2.tipgra,this.form);" class="required"> 
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;M&aacute;x. Cantidad de b&uacute;squedas 99</font> 
         <font class="obligatorio">**</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color">
         <input type="text" name="fecharec" {$modo} value='{$fecharec}' size="11" maxlength="11" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.vplus)" onchange="valFecha(this,document.formarcas2.vplus);">
         &nbsp;&nbsp;
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: dd/mm/aaaa</font> 
         <font class="obligatorio">*</font>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color">
        <select size='1' name='vplus' onchange="valenvio(this.form);">
          {html_options values=$arrayplus selected=$vplus output=$arraydesplus}
        </select>
         <font class="obligatorio">*</font>
      </td>
    </tr>  
   <!-- <tr>
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color">
        <input type='text' name='email' value='{$email}' size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);valenvio(this.form);">
	     <br><font size="1">Cuenta correo para el env&iacute;o de la B&uacute;squeda, por ejemplo: correo@ejemplo.com</font></br>
      </td>
    </tr> -->
    
  <tr>
  </table>

</td>

  <tr></tr> <tr></tr>
  <tr>
    <td>
	   <font class='obligatorio'>&nbsp;&nbsp; NOTA:&nbsp;&nbsp;Debe VERIFICAR que la CANTIDAD DE BUSQUEDAS COINCIDA con el NUMERO DE PLANILLAS ENTREGADAS para ACEPTAR la FACTURA.</font>
    </td>
  </tr>
</table>
</fieldset>
  &nbsp;
 
  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="11" name="Continuar" type="image" src="../imagenes/boton_grabar_azul.png" value="Continuar"></td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_ingbusrec1.php?vopc=1"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
      {if $vopc eq 3}
         <a><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
      {if $vopc eq 5}
         <a href="m_ingbusrec1.php?vopc=1"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
      {if $vopc eq 6 || $vopc eq 8}
         <a href="m_ingbusrec1.php?vopc=1"><img tabindex="12" src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
  
</div>  
</form>
 </td>
 </tr>
</table>
<!-- </body>
</html> -->
