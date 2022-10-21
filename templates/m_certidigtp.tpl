<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="forcronol" action="m_certdigt.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

  <br>
  <table >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forcronol.vsol2)" onchange="Rellena(document.forcronol.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcronol.submit)" onchange="Rellena(document.forcronol.vsol2,6)">
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
       <input type="text" name="vreg1" size="1" maxlength="1" onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forcronol.vreg2)" onChange="this.value=this.value.toUpperCase()">-
       <input type="text" name="vreg2" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forcronol.submit)" onchange="Rellena(document.forcronol.vreg2,6)">   
      </td>
    </tr>
   
  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_certdigtp.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

  </div>  
</form>

</body>
</html>
