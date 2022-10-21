<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<form name="forsolpre" action="mb_rptsolpre.php" method="POST">
 <br><br>
 <table width="69%">
  <tr>
    <!-- <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campod}
        <input type="text" name="fecsold" value='{$fecsold|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forsolpre.fecsold)" onBlur="valagente(document.forsolpre.fecsold,document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar58');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
	     {$campoh}<input type="text" name="fecsolh" value='{$fecsolh|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar59');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="10" maxlength="10">
      </td>
    </tr> -->
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campod} 
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forsolpre.vsol2)" onchange="Rellena(document.forsolpre.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.forsolpre.vsol2,6)">
        {$campoh}
        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forsolpre.vsol2h)" onchange="Rellena(document.forsolpre.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forsolpre.submit)" onchange="Rellena(document.forsolpre.vsol2h,6)">
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
       {$campod} 
       <input type="text" name="vreg1d" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forsolpre.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2d" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forsolpre.submit)" onchange="Rellena(document.forsolpre.vreg2d,6)">   
       {$campoh}
       <input type="text" name="vreg1h" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forsolpre.vreg2h)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2h" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forsolpre.submit)" onchange="Rellena(document.forsolpre.vreg2h,6)">   
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        <select size='1' name='estatus'>
          {html_options values=$arrayestatus selected=$estatus output=$arraydescri1}
        </select>
      </td>
    </tr> 
  </tr>
</table></center>
<br><br>

<table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="mb_rptpsolpre.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
</table>
<br><br><br><br><br><br><br><br><br><br><br>	  
</form>
</div>  

</body>
</html>
