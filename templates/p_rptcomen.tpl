<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forcoment" action="p_rpcoment.php" method="POST">
  <div align="center">
  <br><br>
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod} <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcoment.vsol2)" onchange="Rellena(document.forcoment.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcoment.submit)" onchange="Rellena(document.forcoment.vsol2,6)">{$campoh}
<input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcoment.vsol2h)" onchange="Rellena(document.forcoment.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcoment.submit)" onchange="Rellena(document.forcoment.vsol2h,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        {$campod} 
        <input type="text" name="desdet" value='{$desdet|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forcoment.desdet)" onBlur="valagente(document.forcoment.desdet,document.forcoment.hastat)"> 
        <a href="javascript:showCal('Calendar79');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
        <input type="text" name="hastat" value='{$hastat|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forcoment.hastat)">
        <a href="javascript:showCal('Calendar80');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          {html_options values=$arrayestatus selected=$estatus output=$arraydescri1}
        </select>
      </td>
    </tr> 
 
  </table><!--</font>--></center>
  <br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_rptcomen.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>  
</form>

</body>
</html>
