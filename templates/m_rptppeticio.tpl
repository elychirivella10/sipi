<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forpeticio" action="m_rptpetic.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">
  <table >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name="recibo" align="right" size="6" maxlength="6" onkeyup="checkLength(event,this,2,document.forpeticio.vsol2)"">
      </td>
    </tr>
     <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="fecha" value='{$fecsold|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.forpeticio.fecha)"> 
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="numpet" size="5" maxlength="5" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name="titular" size="65" maxlength="100" onchange="this.value=this.value.toUpperCase()">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input type="text" name="solicit" size="65" maxlength="100" onchange="this.value=this.value.toUpperCase()">
      </td>
   </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="tipo" size="1" maxlength="1" onchange="this.value=this.value.toUpperCase()">
      </td>
    <tr>
    </tr>
     
  </table><!--</font>--></center>
	<p></p>
     <!-- <input type="submit" value="Buscar" name="B1">
     <input type="reset" value="Cancelar" name="cancelar">
	  <input type="button" value="Salir" OnClick="location.href='index1.php';"> -->

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/printmgr.png" value="Buscar">  Imprimir  </td>
      <td class="cnt"><a href="m_rptppeticio.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>


  </div>  
</form>

</body>
</html>
