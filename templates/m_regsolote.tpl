<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<br><br>
<form name="formarcas1" action="m_regsolote.php?vopc=2" method="POST">
<div align="center">
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
	    <td class="der-color">
	      <input type="text" name="boletin" size="3" maxlength="4" value='{$boletin}' onKeyPress="return acceptChar(event,2, this)" align="right">
   	 </td>  
    </tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
	   <td class="der-color">
	     <input type="text" name="vfecvi" size="10" maxlength="10" value='{$vfecvi|date_format:"%d/%m/%G"}' onchange="valFecha(this,this,document.formarcas1.pago)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar56');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	   </td>  
    </tr>
    <tr>
      <td class="izq-color">{$campo3}</td>
	   <td class="der-color">
	     <input type="text" name="pago" size="10" maxlength="10" value='{$pago}' align="left">
	   </td>  
    </tr>
  </table>
  <br><br>
  <table width="180">
  <tr>
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_generar_azul.png" value="Generar"></td> 
      <td class="cnt"><a href="m_regsolote.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </tr>
  </table>
</div>  
</form>
<br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>


