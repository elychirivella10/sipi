<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<!-- <H3>{$subtitulo}</H3> -->

<div align="center">

<form name="formarcas1" action="p_evcomat.php?vopc=1" method="post">
  <table>
       <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
</form>				  
<form name="formarcas2" action="p_evcomat.php?vopc=2" method="post">
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color">{$campo2} </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='{$vreg1}' {$modo} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='{$vreg2}' {$modo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit)" onchange="Rellena(document.formarcas2.vreg2,6)">
		 </td>
		 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
</form>				  

  </table>
  &nbsp; 
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
                            <!-- <input size="30" type="text" name="modal" value='{$modal}' {$vmodo}></td> -->
    </tr>
    <!-- <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color"><input size="1" type="text" name="vclase" value='{$vclase}' {$vmodo}>-
                            <input size="20" type="text" name="vindcla" value='{$vindcla}' {$vmodo}></td>
    </tr> -->
	 <tr>
	   <td class="izq-color">{$campo6}</td>
	   <td class="der-color"><input size="72" type="text" name="vnom" value='{$nombre}' {$vmodo}></td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo7}</td>
	   <td class="der-color"><input size="2" type="text" name="vest" value='{$vest}' {$vmodo}>
	                <input size="67" type="text" name="vdesest" value='{$vdesest}' {$vmodo}></td>
    </tr>
	 <tr><td class="izq-color">{$campo8}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg|date_format:"%d/%m/%G"}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo9}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven|date_format:"%d/%m/%G"}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo10}</td>
	    <td class="der-color"><input size="72" type="text" name="vtrage" value="{$vtra}" {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
	 <tr>
	    <td class="izq-color">{$campo11}</td>
	    <td class="der-color"><input size="6" type="text" name="vcodtit" value='{$vcodtit}' {$vmodo}>
	                <input size="63" type="text" name="vnomtit" value='{$vnomtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
    <tr>
       <td class="izq-color">{$campo12}</td>
	    <td class="der-color"><input size="2" type="text" name="vnactit" value='{$vnactit}' {$vmodo}>
	                <input size="67" type="text" name="vnadtit" value='{$vnadtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
	 <tr>
	    <td class="izq-color">{$campo17}</td>
	    <td class="der-color"><input size="72" type="text" name="vdomtit" value='{$vdomtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
  </tr>
  </table>		
</form>
&nbsp;     
<form name="formarcas3" action="p_evcomat.php?vopc=3" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='{$vsol1}'>
  <input type="hidden" name="vsol2" value='{$vsol2}'>
  <input type="hidden" name="vreg1" value='{$vreg1}'>
  <input type="hidden" name="vreg2" value='{$vreg2}'>
  <input type="hidden" name="vest" value='{$vest}'>
  <input type="hidden" name="vder" value='{$vder}'>

  <table>	
    <tr>
      <td class="izq-color">{$campo14}</td>
      <td class="der-color" >
        <input type="text" name="input1" '{$modo2}' value='{$estatus_id}' size="3" maxlength="3" onKeyup="checkLength(event,this,3,document.formarcas3.estatus_id)" onchange="valagente(document.formarcas3.input1,document.formarcas3.estatus_id)">-
        <select size='1' name='estatus_id' '{$modo2}' onchange="this.form.input1.value=this.options[this.selectedIndex].value">
          {html_options values=$arraycodest selected=$estatus_id output=$arraynombre}
        </select>
        <!-- <select size='1' name='estatus_id' '{$modo2}'>
          {html_options values=$arraycodest selected=$estatus_id output=$arraynombre}
        </select> -->
      </td>
    </tr>
	 <tr>
	   <td class="izq-color">{$campo16}</td>
	   <td class="der-color"><textarea rows="2" name="vcomenta" '{$modo2}' cols="80" onchange="this.value=this.value.toUpperCase()"></textarea></td>
	 </tr>
  </table>
  &nbsp;
  <table width="300">
    <tr>
      <td class="cnt"><a href="p_cronolo.php?vsol={$vsol1}-{$vsol2}">
      <input type="image" src="../imagenes/folder_f2.png"></a>  Cronologia  </td> 
      <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
      <td class="cnt"><a href="p_evcomat.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>
