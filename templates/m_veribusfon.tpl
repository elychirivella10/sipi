<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas2" action="z_browfon.php?vopc=1&vtp=0" method="POST">
  <input type ='hidden' name='camposquery' value='{$camposquery}'>
  <input type ='hidden' name='camposname'  value='{$camposname}'>
  <input type ='hidden' name='tablas'      value='{$tablas}'>
  <input type ='hidden' name='condicion'   value='{$condicion}'> 
  <input type ='hidden' name='orden'       value='{$orden}'>
  <input type ='hidden' name='modo'        value='{$modo}'> 
  <input type ='hidden' name='modoabr'     value='{$modoabr}'>
  <input type ='hidden' name='vurl'        value='{$vurl}'>
  <input type ='hidden' name='new_windows' value='{$new_windows}'>

<div align="center">
<br>
<table cellspacing="3" border="0">
  <tr>
    <tr><td></td><td></td></tr>
    <tr><td></td><td></td></tr>
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
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="recibo" size="7" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.planilla)" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color">
        <input type="text" name="pedido1" size="6" maxlength="6"> y 
        <input type="text" name="pedido2" size="6" maxlength="6">
        </td>	
    </tr>
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
         <input type="text" name="planilla" size="7" maxlength="8" onkeyup="checkLength(event,this,8,document.formarcas2.usuario)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color" ><select size='1' name='envio'>
                             {html_options values=$arrayplus selected=$envio output=$arraydesplus}
                             </select>
      </td>
    </tr>
  </tr>
</table></center>

 <br><br>
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td> 
    <td class="cnt">
      <a href="m_veribusfon.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>      
    <td class="cnt">
      <a href="m_panelfon.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
 
 <br><br><br><br><br><br><br><br><br><br>
 
</div>  
</form>

</body>
</html>
