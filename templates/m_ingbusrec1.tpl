<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_datfacbus.php?vopc=1" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='tipfon' value='F'>

<div align="center">
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center'><strong><span>&nbsp;DATOS DE LA FACTURA&nbsp;</span></strong></legend>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
         <input type="text" name="factura" {$modo} value='{$factura}' size="6" maxlength="6" onfocus="document.formarcas2.clave.value=''" onkeypress="document.formarcas2.clave.value='';" onkeyup="number_sindec(this);checkLength(event,this,8,document.formarcas2.continuar);">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color">
         <input tabindex="3" type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.prioridad)" onchange="valFecha(this,document.formarcas2.prioridad)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar53');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
         <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp;         
      </td>	
    </tr>
  <tr>
  </table>
  <font face='Time New Roman Bold' size="1"><b>Formato:&nbsp;&nbsp;999999</b></font>
</td>

  <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
  <tr>

  </tr>
</table>
 <font face='Time New Roman Bold' size="2"><b>RECUERDE: Ud. es Responsable de que la Cantidad indicada en la Factura,</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>coincida con la cantidad exacta de Planillas B&uacute;squedas entregadas,</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>as&iacute; como que cada Planilla Busqueda, tenga su respectiva Clase ... !!</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>Si es por correo la busqueda, debe verificar que se entienda correctamente el Correo.</b></font>
</fieldset>
  &nbsp;
  <br><br> 
  <table width="230">
  <tr>
    <td class="cnt"><input type="image" {$modo2} src="../imagenes/boton_continuar_azul.png" value="Continuar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingbusrec1.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
    </td>      
    <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
        
  </tr>
  </table>
  
</div>  
</form>

 </td>

 </tr>
</table>
  <br><br><br><br><br><br><br>
<br>
<!-- </body>
</html> -->
