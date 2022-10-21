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

<div align="center"></div>

<table align='center' border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_grabarbus.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='accion' value='{$accion}'>
  <input type='hidden' name='prioridad1' value='{$prioridad1}'>
  <input type='hidden' name='indole1' value='{$indole1}'>
  <input type='hidden' name='lced1' value='{$lced}'>
  <input type='hidden' name='tipoh' value='H'>
  <input type='hidden' name='tipom' value='M'>  
  <input type='hidden' name='tipos' value='S'>
  <input type='hidden' name='tipfon' value='F'>

<div align="center">
<table width="752" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">

<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>   
<tr>
<td>
 <fieldset>
    <legend align='center' class='Estilo3'><strong><span>DATOS DE LA FACTURA</span></strong></legend>

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
          {html_options values=$arraytipom selected=$prioridad1 output=$arraynotip}
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
              {html_options values=$vindole_id selected=$indole1 output=$vindole_de}
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
        <input tabindex="10" type="text" name='telefono' value='{$telefono}' {$modo3} size="15" maxlength="15" onKeyPress="return acceptChar(event,9, this)" onkeyup="checkLength(event,this,15,document.formarcas2.Guardar)" class="required"> 
        <small>Formato: (9999) 9999999</small>   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
         <select size="1" name="vsede" {$modo1}>
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
 </fieldset>
 
</td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
</table>
<br>
<div align="center">
<table width="752" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td>
 <fieldset>
  <legend align='center'><strong></strong></legend>
  <table width="752" border="1" align="center" cellpadding="0" cellspacing="1" >

  <table width="784%">
    <tr>
      <td  height="10" class='Estilo2'>
      <p align='center' style="line-height: 100%"><b><font size="2">&nbsp;DATOS DE LAS BUSQUEDAS&nbsp;</font></b></td>
    </tr>

    <tr><td class="der7-color">
      TIPO:&nbsp;&nbsp;
      <input type="radio" name="rmodalidad" value="D" onClick="habilita(this.form,'D')" checked>Fon&eacute;tica&nbsp;&nbsp;&nbsp;
      <!-- <input type="radio" name="rmodalidad" value="G" onClick="deshabilita(this.form,'G')" >Gr&aacute;fica&nbsp;&nbsp; &nbsp;&nbsp; -->
        <input type="button" class="boton_blue" value="Incluir/Busqueda" name="vvienai" onclick="gestionclases(document.formarcas2.factura,document.formarcas2.vvienai,document.formarcas2.nbusfon)">
     </td>
    </tr>
    <tr><td class="izq7-color" ></td></tr>
    <tr><td class="izq7-color" ></td></tr>
    <tr><td>    
    <iframe id='top' style='width:100%;height:250px;background-color: WHITE;' src="m_verbus.php?vfac={$factura}"></iframe> 
    <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" onclick="gestionclases(document.formarcas2.factura,document.formarcas2.vvienae,document.formarcas2.nbusfon)">
    </td></tr>
  </table>
  &nbsp;

   </table>
</fieldset>

  &nbsp;
  <table width="300">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
      <td class="cnt"><a href="m_ingfacfon.php?vopc=1"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

</form>

 </td>

 </tr>
</table>



</div>  

</body>
</html>
