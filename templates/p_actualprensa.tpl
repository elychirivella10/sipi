<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forsolpre" action="p_actprensadig.php?vopc=2" method="POST">
  <div align="center">
  
  <br><br>
<table cellspacing="1" border="0">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name="fecsold" value='{$fecsold|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forsolpre.fecsold)" onBlur="valagente(document.forsolpre.fecsold,document.forsolpre.fecsolh)">
        <a href="javascript:showCal('Calendar58');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>&nbsp;
        <font class="textoayuda">Formato: dd/mm/aaaa</font>&nbsp;
      </td> 
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="ejemplar" {$modo} value='{$ejemplar}' size="6" maxlength="6" onkeyup="number_sindec(this);checkLength(event,this,3,document.forsolpre.buscar)">
      </td>
    </tr>
  </tr>
</table></center>
<br><br>
<table width="210">
    <tr>
      <td class="cnt"><input type="image" name="buscar" src="../imagenes/boton_procesar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_actualprensa.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <!-- <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td> -->
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
</table>
 
 </div>  
 <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</form>

</body>
</html>
