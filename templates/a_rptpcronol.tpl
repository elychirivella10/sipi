<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">


<form name="forcronol" action="a_rptcronol.php" method="POST">
  <div align="center">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <br> <br> 
  <table >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
	<input type="text" name="vsol1" align="right" size="6" maxlength="6" onkeyup="checkLength(event,this,6,document.forcronol.submit)" onchange="Rellena(document.forcronol.vsol1,6)"  >
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
       <input type="text" name="vreg1" size="6" maxlength="6" onKeyPress="return acceptChar(event,3, this)" onkeyup="checkLength(event,this,1,document.forcronol.vreg2)">
  
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="planilla" size="6" maxlength="6" >
      </td>
    </tr> 
   
  </table></center>
  <br> <br>
  <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="a_rptpcronol.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

  </div>  
</form>
 <br> <br> <br> <br> <br><br><br><br><br>
</body>
</html>
