<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_pbinfigu.php?vopc=1" method="post">
  <table>
        <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color">
               <input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,2)">-
               <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$modo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">&nbsp;
            </td>
            <td class="cnt"><input {$modo1} type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>

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
          <img border="-1" src={$nameimage} width="230" height="230">
        </td>
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
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='{$vfecreg}' {$vmodo}></td>
    </tr>
	 <tr>
	    <td class="izq-color">{$campo9}</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='{$vfecven}' {$vmodo}></td>
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
	    <td class="izq-color">{$campo15}</td>
	    <td class="der-color"><input size="72" type="text" name="vdomtit" value='{$vdomtit}' {$vmodo}></td>
      {if $modal_id eq "G" || $modal_id eq "M"}
        <td class="der-color" ></td>
      {/if}
    </tr>
  </tr>
  </table>		
</form>
&nbsp;     
<form name="formarcas3" action="z_browsef.php?vopc=0&vtp=1" method="post" >
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol1' value={$vsol}>
  <input type ='hidden' name='v1' value={$vsol}>
  <input type ='hidden' name='clase' value={$vclase}>
  <input type ='hidden' name='vindcla' value={$vindcla}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>

  <input type ='hidden' name='camposquery' value='{$camposquery}'>
  <input type ='hidden' name='camposname'  value='{$camposname}'>
  <input type ='hidden' name='tablas'      value='{$tablas}'>
  <input type ='hidden' name='condicion'   value='{$condicion}'> 
  <input type ='hidden' name='orden'       value='{$orden}'>
  <input type ='hidden' name='modo'        value='{$modo}'> 
  <input type ='hidden' name='modoabr'     value='{$modoabr}'>
  <input type ='hidden' name='vurl'        value='{$vurl}'>
  <input type ='hidden' name='new_windows' value='{$new_windows}'>

  <table>
  <tr>
    <td>
      <p align='center'><b><font class="nota4">Se verificaron '{$universo}' Solicitudes en Clase Internacional y sus clases asociadas.! </font></b></p>
    </td>
  </tr>
  </table>

  <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">{$lcviena}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}-{$vsol2}"></iframe>  
    </td></tr>
  </table>


  <table>
  <tr>
    <td>
      <p align='center'><b><font class="nota4">Se encontraron '{$subtotal}' Posibles Parecidos Graficos</font></b></p>
    </td>
  </tr>
  </table>

  <table cellpadding="0" cellspacing="0" border="1" width="960px">
  <tr>
   <td class="menudottedline">
     <div class="pathway">
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;m_pbinfigu.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Marcas que presenten los C&oacute;digos de Viena en la Clase Internacional de Niza especificada.</font>
     </div>	
   </td>
   
   <td class="menudottedline"></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a >
              <input type="image" {$modo3} src="../imagenes/boton_comparar_rojo.png" value="Comparar" border="0"></a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../marcas/m_pbinfigu.php?vopc=5">
	      <img src="../imagenes/boton_cancelar_rojo.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /></a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../index1.php">
	      <img src="../imagenes/boton_salir_rojo.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /></a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>
      </td>
   </td>
  </tr>
  </table>
  <p>&nbsp;</p>

</form>
</div>  
</body>
</html>
