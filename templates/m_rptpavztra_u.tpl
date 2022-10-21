<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas2" action="m_rptavztra_u.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
  <br>
  <table>
  <tr>
     <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo9}
        <input type="text" name="desdec" value='{$desdec}' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	{$campo8}
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
      <td class="izq-color" >{$campo51}</td>
      <td class="der-color" >
        <select size='1' name='estatusant'>
          {html_options values=$arrayestatus selected=$estatusant output=$arraydescri1}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        DESDE:<input type="text" name="boletin1" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
        HASTA:<input type="text" name="boletin2" size="4" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name="modalidad" size="3" maxlength="2">
      </td>
    </tr>   
    <tr>
      <td class="izq-color" >{$campo82}<select size='1' name='cplus'>
                             {html_options values=$arraycplus selected=$cplus output=$arraydescplus}
                             </select>
      </td>
      <td class="der-color">
        <input type="text" name="claseplus" size="3" maxlength="2">
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
  </table><!--</font>--></center>
  <br>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpavztra_u.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</div>  
</form>
<br><br>
</body>
</html>
