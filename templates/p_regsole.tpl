<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas1" action="p_regsole.php?vopc=1"method="POST">
 <input type='hidden' name='nconexion' value='{$nconexion}'>
 <input type='hidden' name='nveces' value='{$nveces}'>    

<div align="center">
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

<form name="formarcas2" action="p_regsole.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='vsol' value={$vsol}>
  <input type='hidden' name='vest1' value={$vest1}>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='tnumera' value={$tnumera}>
  <input type='hidden' name='letrareg' value={$letrareg}>
  <input type='hidden' name='fechasolic' value={$fechasolic}>
  <input type='hidden' name='nconexion' value='{$nconexion}'>
  <input type='hidden' name='nveces' value='{$nveces}'>    
  <input type='hidden' name='vder' value='{$vder}'>

  <div align="center">

  <table cellspacing="1" border="1">
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
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	     <textarea rows="2" name="vnombre" readonly="readonly" cols="70" maxlength="80">{$vnombre}</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="vest1" value='{$vest1}' size="3" readonly="readonly" > - 
        <input type="text" name="vest2" value='{$vest2}' size="70" readonly="readonly" >
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
	   <input type="text" name="vfecvi" size="10" maxlength="10" value='{$vfecvi|date_format:"%d/%m/%G"}' {$vmodo} onchange="valFecha(this,this,document.formarcas2.pago)" onKeyUp="checkLength(event,this,10,document.formarcas2.vfecvi)" >
	 </td>  
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td class="izq-color">{$campo12}</td>
	 <td class="der-color">
	   <input type="text" name="pago" size="10" maxlength="10" value='{$pago}' {$vmodo} align="right">
	 </td>
	 <td>&nbsp;&nbsp;&nbsp;</td> 
    <td class="izq-color">{$campo13}</td>
	 <td class="der-color">
	   <input type="text" name="letra" size="1" maxlength="1" value='{$letra}' {$vmodo} align="right" onKeyUp="this.value=this.value.toUpperCase();checkLength(event,this,1,document.formarcas2.numereg)" onKeyPress="return acceptChar(event,4, this)">-
	   <input type="text" name="numereg" size="6" maxlength="6" value='{$numereg}' {$vmodo} align="right" onchange="Rellena(document.formarcas1.numereg,6)">
	 </td>
  </tr>
  </table>
  &nbsp;
  <table width="300">
  <tr>
    <td class="cnt"><a href="p_cronolo.php?vsol={$vsol1}-{$vsol2}">
    <input type="image" src="../imagenes/folder_f2.png"></a>		Cronologia 		</td> 
    <td class="cnt"><input type="image" {$modo} src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt"><a href="p_regsole.php?nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
    <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
  </tr>
  </table>
  </div>  
</form>

</body>
</html>


