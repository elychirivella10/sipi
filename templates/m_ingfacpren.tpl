<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio de Solicitud de Búsqueda Fonetica</title>
  <script language="javascript" src="../libjs/wforms.js"></script>  
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<table align='center' border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td width="79%" align="left">

<form name="formarcas2" enctype="multipart/form-data" action="m_eveprensa.php?vopc=4" method="POST" onsubmit='return pregunta();'>

<div align="center">
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center'><strong><span>&nbsp;INGRESE DATOS DE FACTURA Y BOLETIN&nbsp;</span></strong></legend>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
         <input type="text" name="factura" {$modo} value='{$factura}' size="6" maxlength="6" onkeyup="number_sindec(this);checkLength(event,this,6,document.formarcas2.boletin)" class="validate-integer required">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="boletin" {$modo} value='{$boletin}' size="3" maxlength="3" onkeyup="number_sindec(this);checkLength(event,this,3,document.formarcas2.mcantidad)" class="validate-integer required">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
         <input type="text" name="mcantidad" {$modo} value='{$mcantidad}' size="3" maxlength="3" onkeyup="number_sindec(this);checkLength(event,this,3,document.formarcas2.pcantidad)" class="validate-integer required">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input type="text" name="pcantidad" {$modo} value='{$pcantidad}' size="3" maxlength="3" onkeyup="number_sindec(this);checkLength(event,this,3,document.formarcas2.continuar)" class="validate-integer required">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input type='text' id='email' name='email' value='{$email}' size="70" maxlength="80" onkeyup="checkLength(event,this,80,document.formarcas2.passwd)" onchange="isEmail2(document.formarcas2.email.value,this.form);validar(this.form);" class="validate-email required"> 
	     <br><font size="1">Cuenta correo para el env&iacute;o de lo cargado, por ejemplo: correo@ejemplo.com</font></br>
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
 
  <table width="210">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/boton_buscar_azul.png" value="Guardar"></td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingfacpren.php?vopc=1"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      {/if}    
    </td>      
    <td class="cnt">
        <!-- <a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td> -->
        <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</div>  
</form>
 </td>

 </tr>
</table>

<br><br><br><br><br><br><br><br><br><br>
<!-- </body>
</html> -->
