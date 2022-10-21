<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forsolpre" action="p_rptanual.php" method="POST">
  <div align="center">

<table width="69%" cellspacing="1" border="0">
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
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
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
        <input type="text" name="usuario" size="10" maxlength="10">
      </td>
    </tr>
  </tr>
</table></center>
<p></p>

<table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="p_rptpanual.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
</table>
	  
</div>  
</form>

</body>
</html>
