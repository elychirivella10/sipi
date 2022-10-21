<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">
<br>
<form name="formarcas1" action="p_anualidad.php?vopc=1" method="post">
  <table>
       <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 </td>
		 <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  
<form name="formarcas2" action="p_anualidad.php?vopc=2" method="post">
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color">{$campo2} </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$vreg1}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$vreg2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		 </td>
		 <td class="cnt"><input type="image" src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  

  </table>
  &nbsp; 
</form>
&nbsp;     

<form name="formarcas3" action="p_anualidad.php?vopc=3" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='{$vsol1}'>
  <input type="hidden" name="vsol2" value='{$vsol2}'>
  <input type="hidden" name="vreg1" value='{$vreg1}'>
  <input type="hidden" name="vreg2" value='{$vreg2}'>
  <input type="hidden" name="vsol" value='{$vsol1}-{$vsol2}'>
  <input type="hidden" name="vder" value='{$vder}'>

  <table cellspacing="1" border="1">	
  <tr>   
    <tr>
      <td class="izq-color">{$campo3}</td>
	   <td class="der-color"><input size="9" type="text" name="vfecsol" value='{$vfecsol}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" rowspan="7" align="center">
          <a href='{$nameimage}' target="_blank">
          <img border="-1" src={$nameimage} width="193" height="205">
        </td>
      {/if}
    </tr>
    <tr>
      <td class="izq-color">{$campo4}</td>
      <td class="der-color"><input size="1" type="text" name="vtipo" value='{$vtipo}' {$vmodo}>-
                            <input size="30" type="text" name="vtip" value='{$vtip}' {$vmodo}></td>
    <tr>
      <td class="izq-color">{$campo6}</td>
      <td class="der-color">
        <textarea rows="2" name="vnom" {$modo2} cols="84" onkeyup="this.value=this.value.toUpperCase()">{$nombre}</textarea>
      </td>
    </tr>

    <tr>
	   <td class="izq-color">{$campo7}</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="78" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td>
    </tr>
	 <tr><td class="izq-color">{$campo8}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg|date_format:"%d/%m/%G"}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo9}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven|date_format:"%d/%m/%G"}' {$vmodo}></td>
    </tr>
<!--<tr>
	    <td class="izq-color">{$campo10}</td>
	    <td class="der-color"><input size="84" type="text" name="vtrage" value="{$vtra}" {$vmodo}></td>
    </tr>
    <tr>
	    <td class="izq-color">{$campo14}</td>
	    <td class="der-color"><input size="2" type="text" name="vultanual" value="{$vultanual}" {$vmodo}></td> 
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr> -->
  </tr>
  </table>		

<!--  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo11}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol={$vsol1}-{$vsol2}&pder=P"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
    </td></tr> 
  </table> -->

  &nbsp;
  <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$campo12}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:190px;background-color: WHITE;' src="p_veranual.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>
  </table>


  &nbsp;
  <table width="85%" cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo13}</td>
      <td class="der-color">
        <input type='text' name='fecha_evento' value='{$fecha_evento}' size='10' onChange="valFecha(document.formarcas3.fecha_evento)" onkeyup="checkLength(event,this,10,document.formarcas3.anuali1)"> 
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo18}</td>
      <td class="der-color" colspan="2">
        <input type="text" name="anuali1" '{$modo1}' value='{$anuali1}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,2,document.formarcas3.anuali2)" onchange="valagente(document.formarcas3.anuali1,document.formarcas3.anuali2)">
        &nbsp;&nbsp; al &nbsp;&nbsp;
        <input type="text" name="anuali2" '{$modo1}' value='{$anuali2}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)" onKeyup="checkLength(event,this,2,document.formarcas3.planilla)">
        &nbsp;&nbsp;{$campo19}&nbsp;
        <input type="text" name="planilla" '{$modo1}' value='{$planilla}' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas3.tasa)">
        &nbsp;&nbsp;{$campo20}&nbsp;
        <input type="text" name="tasa" '{$modo1}' value='{$tasa}' size="7" maxlength="7" onKeyup="checkLength(event,this,6,document.formarcas3.monto)"> 
        &nbsp;&nbsp;{$campo21}&nbsp;
        <input type="text" name="monto" '{$modo1}' value='{$monto}' size="15" maxlength="15" onKeyup="checkLength(event,this,15,document.formarcas3.vagent)">
      </td>
    </tr>
  </tr>
   <tr>
     <td class="izq-color">{$campo15}</td>
     <td class="der-color">
       {html_radios name="multa" values=$multa_opc selected=$multa output=$multa_def separator=""}
       &nbsp;&nbsp;&nbsp;&nbsp;{$campo16}&nbsp;&nbsp;
       <input type="text" name="monto_multa" {$modo1} value='{$monto_multa}' size="15" maxlength="15" onKeyup="checkLength(event,this,15,document.formarcas3.vagent)">
     </td>
   </tr>
  </table>
  &nbsp;
  
   <table width="210">
    <tr>
      <td class="cnt"><a href="p_rptcronol.php?vsol={$vsol1}-{$vsol2}" target="_blank"><img src="../imagenes/boton_cronologia_azul.png" border="0"></a></td> 
      <td class="cnt"><input type="image" src="../imagenes/boton_grabar_azul.png" value="Buscar"></td>
      <td class="cnt"><a href="p_anualidad.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>

</form>

</div>  
</body>
</html>
