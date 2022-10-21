<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_elisolm.php?vopc=1" method="post">
  <table>
        <tr><td class="izq-color">{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
            </td>
	    <td class="cnt"><input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>

</form>				  

  </table>
  &nbsp; 
  <table cellspacing="0">	
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
                            <input size="30" type="text" name="vtip" value='{$vtip}' {$vmodo}>  
                            <input size="30" type="text" name="modal" value='{$modal}' {$vmodo}></td>
    </tr>
    <tr>
      <td class="izq-color">{$campo5}</td>
      <td class="der-color"><input size="1" type="text" name="vclase" value='{$vclase}' {$vmodo}>-
                            <input size="20" type="text" name="vindcla" value='{$vindcla}' {$vmodo}></td>
    </tr>
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

<form name="formarcas3" action="m_elisolm.php?vopc=3" method="post" onsubmit='return pregunta1();'>
  <input type="hidden" name="vsol1" value='{$vsol1}'>
  <input type="hidden" name="vsol2" value='{$vsol2}'>
  <input type="hidden" name="vest" value='{$vest}'>
  <input type="hidden" name="vder" value='{$vder}'>

  <table width="225">
    <tr>
      <td class="cnt"><input type="image" src="../imagenes/delete_f2.png" value="Eliminar">  Eliminar  </td> 
      <td class="cnt"><a href="m_elisolm.php"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>

    </tr>
  </table>
</form>

</div>  
</body>
</html>


