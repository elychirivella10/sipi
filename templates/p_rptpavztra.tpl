<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="foravztra" action="p_rptavztra.php" method="POST">
  <div align="center">
<br>
  <table cellspacing="1" border="0">
  <tr>
     <tr>
      <td class="izq-color" >{$campot}</td>
      <td class="der-color">
        {$campo7}
        <input type="text" name="desdec" value='{$desdec}' size='9' onChange="valFecha(document.foravztra.desdec)" onBlur="valagente(document.foravztra.desdec,document.foravztra.hastac)"> 
        <a href="javascript:showCal('Calendar81');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campo8}
        <input type="text" name="hastac" value='{$hastac}' size='9' onChange="valFecha(document.foravztra.hastac)">
        <a href="javascript:showCal('Calendar82');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2} 
        <input type="text" name="desdet" value='{$desdet}' size='9' onChange="valFecha(document.foravztra.desdet)" onBlur="valagente(document.foravztra.desdet,document.foravztra.hastat)"> 
        <a href="javascript:showCal('Calendar83');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
        <input type="text" name="hastat" value='{$hastat}' size='9' onChange="valFecha(document.foravztra.hastat)">
        <a href="javascript:showCal('Calendar84');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" >
          {html_options values=$arraytipop selected=$tipo_paten output=$arraynotip}
        </select>
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
      <td class="izq-color" >Estatus Anterior:</td>
      <td class="der-color" >
        <select size='1' name='estatusant'>
          {html_options values=$arrayestatus selected=$estatusant output=$arraydescri1}
        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        DESDE:<input type="text" name="boletin1" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
        HASTA:<input type="text" name="boletin2" size="2" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <input type="text" name="locarno1" size="2" maxlength="2">-
        <input type="text" name="locarno2" size="2" maxlength="2">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo11}</td>
      <td class="der-color">
        <input type="text" name="cip1" size="15" maxlength="15">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color">
        <input type="text" name="palabras" size="80" maxlength="80">
      </td>
    </tr>
   <!--  <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color">
        <input type="text" name="cip2" size="15" maxlength="15">
      </td>
    </tr>
-->
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
      <td class="izq-color" >{$campo13}</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          {html_options values=$arrayorden selected=$orden output=$arrayorden}
        </select>
      </td>
    </tr> 
    
  </table></center>
  <br><br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_rptpavztra.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br>
</div>  
</form>

</body>
</html>
