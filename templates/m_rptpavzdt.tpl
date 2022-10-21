<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<form name="formarcas2" action="m_rptavzdt.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  
  <div align="center">
  <br>
  <table>
  <tr>
     <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo2}
        <input type="text" name="desdec" value='{$desdec}' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
        <input type="text" name="hastac" value='{$hastac}' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2} 
        <input type="text" name="desdet" value='{$desdet}' size='9' onChange="valFecha(document.formarcas2.desdet)" onBlur="valagente(document.formarcas2.desdet,document.formarcas2.hastat)"> 
        <a href="javascript:showCal('Calendar71');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
        <input type="text" name="hastat" value='{$hastat}' size='9' onChange="valFecha(document.formarcas2.hastat)">
        <a href="javascript:showCal('Calendar72');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" >
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        <select size='1' name='evento'>
          {html_options values=$arrayevento selected=$evento output=$arraydescri}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          {html_options values=$arrayestatus selected=$estatus output=$arraydescri1}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" >
          {html_options values=$arraytipom selected=$tipo_marca output=$arraynotip}
        </select>
      </td>
    </tr>
    
    <!-- <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <input type="text" name="indole" size="1" maxlength="1" onkeyup="this.value=this.value.toUpperCase()">
      </td>
    </tr> -->      

    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <select size="1" name="indole" >
          {html_options values=$arrayindol selected=$indole output=$arraynoind}
        </select>
      </td>
    </tr>

  </table><!--</font>--></center>
	<p></p>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavzdt.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br>
</body>
</html>
