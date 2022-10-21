<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">
  
<div align="center">
<br>
<form name="formarcas2" action="m_acerbol.php?vopc=1" method="post">
   <table>
   <tr>
     <!-- <tr>
      <td class="izq-color">{$campo1}</td>
	   <td class="der-color">
        {$campo2}
        <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(this,document.formarcas.desdet)">
        {$campo3}
        <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(this,document.formarcas.hastat)">
		<td>
	  </tr> -->
     <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2}
        <input type="text" name="desdec" value='{$desdec}' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campo3}
        <input type="text" name="hastac" value='{$hastac}' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color" >
	     <input type="text" name="boletin" size="2" maxlength="3" value='{$boletin}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.formarcas2.fechabol)">
      </td>
    </tr>
    <!-- <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color" >
        <input type='text' name='fechabol' value='{$fechabol}' size='10' maxlength="10" onChange="valFecha(document.formarcas2.fechabol)">
      </td>
    </tr> -->
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
         <input size="9" maxlength="10" type="text" name="vfpub" value='{$vfpub}'>
         <a href="javascript:showCal('Calendar86');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
   </tr>
   </table>
   <br><br>
   <table width="225">
   <tr>
     <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_procesar_azul.png" value="Actualizar"></td>
      <td class="cnt"><a href="m_acerbol.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
   </tr>
   </table>
</form>
<br><br><br><br><br><br><br><br><br><br><br><br>
</div>  
</body>
</html>
