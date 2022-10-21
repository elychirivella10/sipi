<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<form name="formarcas1" action="m_regsolm.php?vopc=1"method="POST">
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
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </tr>
  </tr>
  </table>
</form>
&nbsp;

<form name="formarcas2" action="m_regsolm.php?vopc=2" method="POST" onsubmit='return pregunta();'>
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
        <input type="text" name="tipo_m" value='{$tipo_m}' readonly="readonly" size="1">
        <input type="text" name="tipo" value='{$tipo}' readonly="readonly" size="30">
        &nbsp;&nbsp;&nbsp;<input type="text" name="modal" value='{$modal}' readonly="readonly" size="14">
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
      <td class="der-color">
        <input type="text" name="vclase" value='{$vclase}' readonly="readonly" align="right" size="1" >
        <input type="text" name="vindclase" value='{$vindclase}' readonly="readonly" size="14" >
      </td>
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
    <td class="izq5-color">{$campo11}</td>
	 <td class="der-color">
	   <input type="text" name="vfecvi" size="10" maxlength="10" value='{$vfecvi|date_format:"%d/%m/%G"}' {$vmodo} onchange="valFecha(this,this,document.formarcas2.pago)">
      &nbsp;&nbsp;
      <a href="javascript:showCal('Calendar55');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
	 </td>  
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td class="izq5-color">{$campo12}</td>
	 <td class="der-color">
	   <input type="text" name="pago" size="10" maxlength="10" value='{$pago}' {$vmodo} align="right">
	 </td>  
  </table>
  &nbsp;
  <table width="300">
  <tr>
    <td class="cnt"><a href="m_cronolo.php?vsol={$vsol1}-{$vsol2}">
    <input type="image" src="../imagenes/boton_cronologia_rojo.png"></a></td> 
    <td class="cnt"><input type="image" {$modo} src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="m_regsolm.php?nconexion={$nconexion}&nveces={$nveces}"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex={$nconexion}"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
  </div>  
</form>

</body>
</html>


