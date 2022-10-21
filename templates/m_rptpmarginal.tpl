<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forsolpre" action="m_rptmarginal.php" method="POST">
  <div align="center">
  <br>
<table width="69%">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campod}
        <input type="text" name="fecsold" value='{$fecsold|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forsolpre.fecsold)" onBlur="valagente(document.forsolpre.fecsold,document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar58');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}
	     <input type="text" name="fecsolh" value='{$fecsolh|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar59');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
    </tr>
 	 <tr>
	   <td class="izq-color">{$ltipo}</td>
      <td class="der-color">
        <select size="1" name="v2">
          {html_options values=$arrayvmodal selected=$modalidad output=$arraytmodal}
        </select>
      </td>  
	 </tr>  
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="12" maxlength="15">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="3" maxlength="3" value='{$boletin}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forsolpre.buscar)">
      </td>
    </tr>   
  </tr>
</table></center>
<br>

<table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/boton_buscar_rojo.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpmarginal.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
</table>
	  
</div>  
</form>
<br><br><br><br><br><br><br><br><br>
</body>
</html>
