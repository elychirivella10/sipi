<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <h3> {$H3}</h3> -->

<form name="forgenbol" action="m_rptgenbord.php" method="POST">
  <div align="center">

 <table>
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name='boletin' size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.forgenbol.tipo)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
        <select size='1' name='tipo'>
          {html_options values=$arraytipo selected=$tipo output=$arraytipo}
        </select>
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name='numero' size="15" maxlength="15"  >
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
        <input type="text" name='fechab' size="30" maxlength="35"  >
      </td>
    </tr> 

    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
        <input type="text" name='resolucion' size="4" maxlength="4" onKeyPress="return acceptChar(event,2, this)" >
      </td>
    </tr> 


    
  </table><!--</font>--></center>
	<p></p>
     <!--  <input type="submit" value="Buscar" name="B1">
      <input type="reset" value="Cancelar" name="cancelar" OnClick="location.href='m_rptpgenbolc.php'">
	   <input type="button" value="Salir" OnClick="location.href='index1.php';"> -->
   <table width="210">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/save_f2.png" value="Buscar">  Buscar  </td>
      <td class="cnt"><a href="m_rptpgenbord.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>

  </div>  
</form>

</body>
</html>
