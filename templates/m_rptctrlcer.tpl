<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas2" action="m_rptctrlcer1.php" method="POST">
  <div align="center">
 <br>
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campo2} <input type="text" name="desdec" value='{$desdec}' size='9' onChange="valFecha(document.formarcas2.desdec)" onBlur="valagente(document.formarcas2.desdec,document.formarcas2.hastac)"> 
        <a href="javascript:showCal('Calendar69');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	{$campo3} <input type="text" name="hastac" value='{$hastac}' size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <select size="1" name="prioridad">
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input type="text" name="control" size="7" maxlength="8">
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

  <br><br>
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptctrlcer.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br>
</div>  
</form>

</body>
</html>
