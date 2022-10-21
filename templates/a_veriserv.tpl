<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forsolpre" action="a_browser.php?vopc=1&vtp=0" method="POST">
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
      <td class="der7-color">
        <input type="text" name="control" value='{$control}' size='9'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der7-color">
         <select size="1" name="escrito" {$modo2} >
          {html_options values=$vcodser selected=$escrito output=$vnomser}
         </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der7-color">
        <input type="text" name="fecdep1" value='{$fecdep1}' size='9' onChange="valFecha(document.forsolpre.fecdep1);" onBlur="valagente(document.forsolpre.fecdep1,document.forsolpre.fecdep2)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar11');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	    <font class="columna6">{$campoh}&nbsp;</font><input type="text" name="fecdep2" value='{$fecdep2}' size='9' onChange="valFecha(document.forsolpre.fecdep2)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar12');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
  </tr>
</table></center>
<p></p>

 <br>
 <table align="center">
    <tr>
      <td class="cnt"><input type='image' src="../imagenes/boton_buscar_rojo.png" name="buscar" value="Buscar"></td>
      <td class="cnt"><a href="a_veriserv.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
 </table>
 <br><br><br><br><br>
 
</div>  
</form>

</body>
</html>
