<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravztra" action="m_rptaudfac1.php" method="POST">
  <div align="center">

  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2}
        <input type="text" name="desdec" value='{$desdec|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdec)" onChange="valFecha(this,document.foravztra.desdec)" onBlur="valagente(document.foravztra.desdec,document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar81');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campo3}
        <input type="text" name="hastac" value='{$hastac|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastac)" onChange="valFecha(this,document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar82');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        {$campo2} 
        <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.desdet)" onChange="valFecha(document.foravztra.desdet)" onBlur="valagente(document.foravztra.desdet,document.foravztra.hastat)"> 
        <a href="javascript:showCal('Calendar83');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campo3}
        <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.foravztra.hastat)" onChange="valFecha(document.foravztra.hastat)">
        <a href="javascript:showCal('Calendar84');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <select tabindex="4" size="1" name="busqueda" {$modo2}>
          {html_options values=$arraybusqt selected=$busqueda output=$arraynobus}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="11" maxlength="12">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
         <select size="1" name="options">
          {html_options values=$vcodsede selected=$vsede output=$vnomsede|truncate:15}
         </select>
      </td>
    </tr>          
  </tr>
  </table></center>
  &nbsp;
  &nbsp;
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_rptaudfac.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
</div>  
</form>

</body>
</html>
