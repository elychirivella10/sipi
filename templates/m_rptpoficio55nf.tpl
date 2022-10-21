<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas2" action="m_rptoficio55nf.php" method="POST">
  
 <div align="center">
 <br>
 <table width='30%'>
   <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol2)" onchange="Rellena(document.formarcas2.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vsol2,6)">
       </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol2h)" onchange="Rellena(document.formarcas2.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vsol2h,6)">
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <select size="1" name="tipoest">
          {html_options values=$arraytipod selected=$tipoest output=$arraydescd}
        </select>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	<input type="text" name="hastac" size='9' onChange="valFecha(document.formarcas2.hastac)">
        <a href="javascript:showCal('Calendar70');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp; 
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>

  </table></center>
	<br>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpoficio55nf.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  </div>  
<br><br><br><br><br><br><br><br><br><br><br><br>
</form>
</body>
</html>
