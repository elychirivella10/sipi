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

<form name="formarcas2" enctype="multipart/form-data" action="m_datfacfon.php?vopc=1" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='tipfon' value='F'>

<div align="center">
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="1">

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   
<tr>
<td>
 <fieldset>

  <legend align='center'><strong><span>&nbsp;INGRESE NUMERO DE LA FACTURA&nbsp;</span></strong></legend>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="1" >
  <tr>

    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
         <input type="text" name="factura" {$modo} value='{$factura}' size="8" maxlength="8" onkeyup="number_sindec(this);checkLength(event,this,8,document.formarcas2.continuar)" class="validate-integer required">
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
 
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" {$modo2} src="../imagenes/control_play_blue.png" value="Guardar"> Continuar </td> 
    <td class="cnt">
      {if $vopc eq 1}
         <a href="m_ingfacfon.php?vopc=1"><img src="../imagenes/cancel_f2.png" border="0"></a> Cancelar   
      {/if}    
    </td>      
    <td class="cnt">
        <a href="../salir.php"><img src="../imagenes/salir_f2.png" border="0"></a> Salir </td>
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
