<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<br>
<form name="formarcas2" action="m_rptbuspen1.php" method="POST">
  <div align="center">

  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
	<input type="text" name="hastac" value='{$hastac}' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <select size="1" name="tipobusq">
          {html_options values=$arraytipob selected=$tipobusq output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" ><select size='1' name='vplus'>
                             {html_options values=$arrayplus selected=$vplus output=$arraydesplus}
                             </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="recibo" size="7" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.planilla)" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
  </tr>
  </table></center>
  
  <br><br>
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptbuspen.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br>
  
</div>  
</form>

</body>
</html>
