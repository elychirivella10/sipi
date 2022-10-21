<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas2" action="m_rptestfon8.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
  <br><br><br>
  <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        DESDE:<input type="text" name="boletin1" size="3" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
        HASTA:<input type="text" name="boletin2" size="4" maxlength="3" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr> 
   <!-- <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        <select size='1' name='orden'>
          {html_options values=$arrayorden selected=$orden output=$arrayorden}
        </select>
      </td>
    </tr> --> 
  </table><!--</font>--></center>
  <br><br>

   <table width="200">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpestfon8.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br>
</div>  
</form>
<br><br>
</body>
</html>
