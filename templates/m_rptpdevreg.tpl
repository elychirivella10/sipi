<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="devreg" action="m_rptdevreg.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

<table >
    <tr>
      <td class="izq-color" >REGISTRO INICIAL:</td>
      <td class="der-color">
        <input type="text" name="vsol1" align="right" size="1" maxlength="1" onKeyPress="return acceptChar(event,1, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vsol2)" onchange="Rellena(document.formarcas2.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vsol2,6)">
       </td>
    </tr>
    <tr>
      <td class="izq-color" >REGISTRO FINAL:</td>
      <td class="der-color">
        <input type="text" name="vsol1h" align="right" size="1" maxlength="1" onKeyPress="return acceptChar(event,1, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vsol2h)" onchange="Rellena(document.formarcas2.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vsol2h,6)">
    </tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        {$campod} <input type="text" name="fecsold" value='{$fecsold|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.foravzcri.fecsold)"> 
	{$campoh}
     <input type="text" name="fecsolh" value='{$fecsolh|date_format:"%d/%m/%G"}' size='9' onChange="valFecha(document.foravzcri.fecsolh)">
    </tr>


    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
        <input type="text" name="usuario" size="15" maxlength="16">
      </td>
    </tr>   


  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_rptpdevreg.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>
