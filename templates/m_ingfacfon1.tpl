<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio de Solicitud de Búsqueda Fon&eacute;tica y/o Gr&aacute;fica</title>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_datfacfon1.php?vopc=1" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='tipfon' value='F'>

<div align="center">
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center'><strong><span>&nbsp;EN CASO DE SER FACTURADO&nbsp;</span></strong></legend>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>

    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
         <input type="text" name="factura" {$modo} value='{$factura}' size="6" maxlength="6" onfocus="document.formarcas2.clave.value=''" onkeypress="document.formarcas2.clave.value='';" onkeyup="number_sindec(this);checkLength(event,this,8,document.formarcas2.continuar);">
      </td>
    </tr>
  <tr>
  </table>
  <font face='Time New Roman Bold' size="1"><b>Formato:&nbsp;&nbsp;999999</b></font>
</td>

  <br><br><br><br>

<td>
 <fieldset>

 <legend align='center'><strong><span>&nbsp;EN CASO DE SER EXONERADO&nbsp;</span></strong></legend>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>

    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="password" name="clave" {$modo} value='{$clave}' size="10" maxlength="8" onkeypress="document.formarcas2.factura.value='';" onkeyup="checkLength(event,this,8,document.formarcas2.continuar);">
      </td>
    </tr>
  <tr>
  </table>
  <small><font face='Time New Roman Bold' size="1"><b>Formato:&nbsp;&nbsp;8 caracteres m&aacute;ximo en letras y/o n&uacute;meros</b></font></small>



</td>

  <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
  <tr>

  </tr>
</table>
<br>
 <font face='Time New Roman Bold' size="2"><b>RECUERDE: Ud. es Responsable de que la Cantidad indicada en la Factura,</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>coincida con la cantidad exacta de Planillas B&uacute;squedas recibidas de Informaci&oacute;n,</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>as&iacute; como que cada Planilla B&uacute;squeda, tenga su respectiva Clase ... !!</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>Al finalizar de cargar las B&uacute;squeda, es su responsabilidad obtener un listado de lo cargado</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>y verificar que este correcto el Nombre de la Marca, Clase y Correo</b><br></font>
 <font face='Time New Roman Bold' size="2"><b>contra la Factura y Planilla B&uacute;squeda a fin de evitar ERRORES y RECLAMOS de los USUARIOS...!!!</b></font>
<br>
</fieldset>
  &nbsp;
  <br> 
  <table width="230">
  <tr>
    <td class="cnt"><input type="image" {$modo2} src="../imagenes/boton_continuar_azul.png" value="Continuar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingfacfon1.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
    </td>      
    <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    <td class="cnt"> <a href="documentos/digitalizacion.pdf" target="_blank"><img src="../imagenes/boton_ayuda_azul.png" border="0"> </a></td>
        
  </tr>
  </table>
  
</div>  
</form>

 </td>

 </tr>
</table>
  <br><br><br><br>
<br>
<!-- </body>
</html> -->
