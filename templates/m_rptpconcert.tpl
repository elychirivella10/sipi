<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forcertif" action="m_rptconcert.php" method="POST">
  <div align="center">
 <br>
 <table>
   <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
       <input type="text" name="vreg1d" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forcertif.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2d" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcertif.vreg1h)" onchange="Rellena(document.forcertif.vreg2d,6)">   

       </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
       <input type="text" name="vreg1h" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forcertif.vreg2h)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2h" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcertif.submit)" onchange="Rellena(document.forcertif.vreg2h,6)">   
 
      </tr>

  </table><!--</font>--></center>

	<br>
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="m_rptpconcert.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
  </div>  
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</form>
</body>
</html>
