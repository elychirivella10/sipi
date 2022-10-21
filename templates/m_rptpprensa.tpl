<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="foravzcri" action="m_rptprensa.php" method="POST">
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <div align="center">

<table width="48%">
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
      {$campod} <input type="text" name="vsol1" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2)" onchange="Rellena(document.foravzcri.vsol1,2)">-
        <input type="text" name="vsol2" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2,6)">{$campoh}
<input type="text" name="vsol1h" align="right" size="3" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.foravzcri.vsol2h)" onchange="Rellena(document.foravzcri.vsol1h,2)">-
        <input type="text" name="vsol2h" align="right" size="6" maxlength="6" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.foravzcri.submit)" onchange="Rellena(document.foravzcri.vsol2h,6)">
      </td>
    </tr>


    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        <select size='1' name='tipo_id'>
          {html_options values=$arraytipo selected=$tipo_id output=$arraytipo}
        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color" >
        <select size='1' name='modal_id'>
          {html_options values=$arraymodal selected=$modal_id output=$arraymodal}
        </select>
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name="boletin" size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)">
      </td>
    </tr>   


  </table><!--</font>--></center>
	<p></p>

   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/search_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_rptpprensa.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
	  
  </div>  
</form>

</body>
</html>
