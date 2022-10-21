<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravztra" action="m_rptavztra_reg.php" method="POST">
  <div align="center">
  <br>
  
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo7}
        <input type="text" name="desdec" value='{$desdec|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdec)" onChange="valFecha(this,document.foravztra.desdec)" onBlur="valagente(document.foravztra.desdec,document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar81');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campo8}
        <input type="text" name="hastac" value='{$hastac|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastac)" onChange="valFecha(this,document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar82');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2} 
        <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(document.foravztra.desdet)" onBlur="valagente(document.foravztra.desdet,document.foravztra.hastat)"> 
        <a href="javascript:showCal('Calendar83');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
        <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(document.foravztra.hastat)">
        <a href="javascript:showCal('Calendar84');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        <select size='1' name='evento'>
          {html_options values=$arrayevento selected=$evento output=$arraydescri}
        </select>
      </td>
    </tr>
  </tr>
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          {html_options values=$arraytipo selected=$tipo output=$arraytipo}
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
      <td class="izq-color" ><select size='1' name='vplus'>
                             {html_options values=$arrayplus selected=$vplus output=$arraydesplus}
                             </select>{$campo72}
      </td>
      <td class="der-color" >
        <select size='1' name='eventoplus'>
          {html_options values=$arrayevento selected=$evento output=$arraydescri}
        </select>
      </td>
    </tr>  
    <tr>
      <td class="izq-color" >{$campo19}</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          {html_options values=$arrayorden selected=$orden output=$arrayorden}
        </select>
      </td>
    </tr> 
    </tr>   
  </table><!--</font>--></center>
  <br>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavztra_reg.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br><br><br><br><br><br>
</body>
</html>
