<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forsolpre" action="m_rptoficioam.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>

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
<br><br>
<table width="69%">
  <tr>
  <tr>
      <td class="izq-color" >Rango de Registros:</td>
      <td class="der-color">DESDE:
        <input type="text" name="vsol1" align="right" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forsolpre.vsol2)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forsolpre.vsol1h)" onchange="Rellena(document.forsolpre.vsol2,6)">
        HASTA:<input type="text" name="vsol1h" align="right" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forsolpre.vsol2h)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forsolpre.submit)" onchange="Rellena(document.forsolpre.fecsold,6)">
    </tr>
    <tr>
      <td class="izq-color" >Rango de {$campo1}</td>
      <td class="der-color">
        {$campod} <input type="text" name="fecsold" value='{$fecsold}' size='9' onChange="valFecha(document.forsolpre.fecsold)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar58');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	     {$campoh} <input type="text" name="fecsolh" value='{$fecsolh}' size='9' onChange="valFecha(document.forsolpre.fecsolh)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar59');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="10" maxlength="10">
      </td>
    </tr>
  </tr>
</table></center>
<br>

<table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptdevam.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
</table>
	  
</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>
