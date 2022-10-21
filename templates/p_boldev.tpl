<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">

<form name="formarcas1" action="p_boldev.php?vopc=1"method="POST">
  <table>
  <tr>
    <tr>
      <td class="izq5-color" >{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 &nbsp;
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
    </tr>
  </tr>
  </table>
</form>
&nbsp;

<form name="formarcas2" action="p_boldev.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='fechasolic' value={$fechasolic}>
  <input type ='hidden' name='vder' value='{$vder}'>

  <table cellspacing="2">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fechasolic" value='{$fechasolic}' readonly="readonly" size="9" align="right">
      </td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" rowspan="8" align="center">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="195" height="225">
        </td>
      {/if}
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <input type="text" name="tipo_p" value='{$tipo_p}' readonly="readonly" size="1">
        <input type="text" name="tipo" value='{$tipo}' readonly="readonly" size="30">
        &nbsp;&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="vnombre" readonly="readonly" cols="70" maxlength="80">{$vnombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color"></td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="vest1" value='{$vest1}' size="3" readonly="readonly" > - 
        <input type="text" name="vest2" value='{$vest2}' size="63" readonly="readonly" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td class="der-color">
        <input type="text" name="vnomtit" value='{$vnomtit}' readonly="readonly" size="70" maxlength="80">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo8}</td>
      <td class="der-color">
        <input type="text" name="vnactit" value='{$vnactit}' size="1" readonly="readonly" align="right"> - 
        <input type="text" name="vnadtit" value='{$vnadtit}' size="20" readonly="readonly">
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <input type="text" name="vtra" value='{$vtra}' size="70" maxlength="80" readonly="readonly">
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  
  <table>
  <tr>
    <td class="izq-color">{$campo11}</td>
	 <td class="der-color">
	   <input type="text" name="vdocumento" size="10" maxlength="10" value='{$vdocumento}' {$vmodo}>
	 </td>  
  </tr>
  </table>
  
  &nbsp;
  <table width="300">
  <tr>
    <td class="cnt"><a href="p_rptcronol.php?vsol={$vsol1}-{$vsol2}">
    <input type="image" src="../imagenes/folder_f2.png"></a>  Cronologia  </td> 
    <td class="cnt"><input type="image" name="guardar" src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt"><a href="p_boldev.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
  </tr>
  </table>

</form>

</div>  
</body>
</html>
