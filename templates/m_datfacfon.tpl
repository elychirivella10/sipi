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

<form name="formarcas2" enctype="multipart/form-data" action="m_ingfonetica.php?vopc=5" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='tipfon' value='F'> 
  <input type='hidden' name='prioridad1' value='{$prioridad1}'>
  <input type='hidden' name='indole1' value='{$indole1}'>

<div align="center">
<br>
<table width="752" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center' class='Estilo3'><strong><span>&nbsp;COMPLETE LOS DATOS DE LA FACTURA&nbsp;</span></strong></legend>
  <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
         <input type="text" name="factura" {$modo} value='{$factura}' size="8" maxlength="8" onkeyup="number_sindec(this);checkLength(event,this,8,document.formarcas2.fechadep)" class="validate-integer required">
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: 99999999</font> 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fechadep" {$modo} value='{$fechadep}' size="11" maxlength="11" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.montodep)" onchange="valFecha(this,document.formarcas2.montodep);" class="required">
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar60');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         <font class="textoayuda">&nbsp;&nbsp;&nbsp;Formato: dd/mm/aaaa</font> 
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="prioridad" {$modo1}> 
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color">
         <input tabindex="8" type="text" name="solicitant" {$modo} value='{$solicitant}' size="70" maxlength="80" onkeyup="this.value=this.value.toUpperCase();checkLength(event,this,80,document.formarcas2.indole)" class="required">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
           <select size="1" name="indole" {$modo1}>
              {html_options values=$vindole_id selected=$indole output=$vindole_de}
           </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <select size="1" name="lced" {$modo2}>
           {html_options values=$lced_id selected=$lced output=$lced_de}
        </select>
        <input tabindex="9" type="text" name='nced' size="9" maxlength="9" value='{$nced}' {$modo3} 
onKeyPress="return acceptChar(event,3, this)" onchange="Rellena(document.formarcas2.nced,9)" onkeyup="checkLength(event,this,9,document.formarcas2.telefono)" class="required">
      </td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo7}</td>
      <td class="der-color" colspan="2"><small>V = Venezolano,&nbsp;&nbsp;&nbsp;E = Extranjero,&nbsp;&nbsp;&nbsp;P = Pasaporte,&nbsp;&nbsp;&nbsp;J = Juridico,&nbsp;&nbsp;&nbsp;G = Gobierno</small></td>
    </tr> 
    <tr>
      <td class="izq-color">{$campo8}</td>
      <td class="der-color">
        <input tabindex="10" type="text" name='telefono' value='{$telefono}' {$modo3} size="13" maxlength="14" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)" class="required"> 
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
         <select size="1" name="vsede" {$modo1} >
          {html_options values=$vcodsede selected=$vsede output=$vnomsede}
         </select>
      </td>
    </tr>          
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
         <input type="text" id="nbusfon" name="nbusfon" {$modo} value='{$nbusfon}' size="2" maxlength="2" style="text-align: left" onKeyPress="return acceptChar(event,2, this)" onkeyup="valminimo(this.form);valcantidad(document.formarcas2.tipfon,this.form);" class="required"> 
      </td>
    </tr>  
  <tr>
  </table>

</td>

  <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
  <tr>
  </tr>
</table>
</fieldset>
  &nbsp;
  
  <table width="255" >
  <tr>
    <td class="cnt"><input tabindex="11" name="Continuar" type="image" src="../imagenes/control_play_blue.png" value="Continuar">	Continuar 	</td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_ingfacfon.php?vopc=1"><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
         <a><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
      {if $vopc eq 5}
         <a href="m_ingfacfon.php?vopc=1"><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
      {if $vopc eq 6 || $vopc eq 8}
         <a href="m_ingfacfon.php?vopc=1"><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table>
  
</div>  
</form>

 </td>

 </tr>
</table>

<br>
<!-- </body>
</html> -->
