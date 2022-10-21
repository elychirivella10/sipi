<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_reclaintnac.php?vopc=1" method="post">
  <input type="hidden" name="etiqueta" value='{$etiqueta}'>

  <table>
        <tr><td class="izq5-color">{$campo1}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
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
                            <input size="1" type="text" name="vindc" value='{$vindc}' {$vmodo}>-
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
<form name="formarcas3" action="m_reclaintnac.php?vopc=5&vsol={$vsol}" method="post" onsubmit='return pregunta();'>
  <input type="hidden" name="vsol1" value='{$vsol1}'>
  <input type="hidden" name="vsol2" value='{$vsol2}'>
  <input type="hidden" name="vreg1" value='{$vreg1}'>
  <input type="hidden" name="vreg2" value='{$vreg2}'>
  <input type="hidden" name="vest" value='{$vest}'>
  <input type="hidden" name="vindc" value='{$vindc}'>  
  <input type="hidden" name="vexist" value='{$vexist}'>
  <input type="hidden" name="distingue" value='{$distingue}'>
  <input type="hidden" name="vder" value='{$vder}'>  
  <input type="hidden" name="vfecsol" value='{$vfecsol}'>
  
  <table cellspacing="1" border="1">	
    <tr>
      <td class="izq-color" >{$campo15}</td>
      <td class="der-color">
         <textarea rows="6" name="distingue" {$vmodo} cols="101">{$distingue}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color">{$campo13}</td>
      <td class="der-color">
        <input type='text' name='fecha_evento' value='{$fecha_evento}' size='10' onChange="valFecha(document.formarcas3.fecha_evento)">
        &nbsp;&nbsp;
        <a href="javascript:showCal('Calendar57');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
    </tr>
    <tr>
    </tr>
    <tr>
    </tr>
    <tr>
    </tr>
  </table>

      <table>
      {section name=cont loop=$vnumrows}
          <tr><td class="izq-color">{$lcpoder}</td><td class="der-color">{$arr_ph1[cont]}</td>
	      <td class="izq-color">{$lnpoder}</td><td class="der-color">{$arr_ph2[cont]}</td>
	      {if $vopc eq 4}
	      <td class="cnt"><input type="image" src="../imagenes/delete.gif" name="accion" value="{$arr_ph1[cont]}">Borrar</td>
	      {/if}
	      </tr>
      {/section} 
      {if $vopc eq 4} 
        <tr>
          <td class="izq-color">{$lcpoder}</td>
          <td class="der-color">
             <input size="2" type="text" name="vccv" size="2" maxlength="2" onKeyPress="return acceptChar(event,2, this)" onchange="valclase(document.formarcas1.vtipo,document.formarcas1.vindc,document.formarcas3.vccv,document.formarcas3.vagenom)"> 
          </td>
	       <td class="izq-color">{$lnpoder}</td>
	       <td class="der-color">
             <!-- <input size="78" name="vagenom" maxlength="200"> --> 
             <textarea rows="1" name="vagenom" cols="80">{$vagenom}</textarea>             
          <!--<select size=1 name='vagenom' onchange="valagente(document.formarcas3.vagenom,document.formarcas3.vccv)">
	  {html_options values=$vcodage selected=$codage output=$vnomage}
	  <select>-->
          </td>        
          <td class="cnt"><input type="image" name="accion" src="../imagenes/tick.png" value="Incluir">Incluir</td>
      </tr>
      {/if}	  
     </table>
  &nbsp;
  <table width="225">
    <tr>
      {if $vopc eq 1}
      <td class="cnt"><a href="m_reclaintnac.php?vopc=5&vsol={$vsol}"><img src="../imagenes/edit_f2.png" border="0"></a>  Reclasifica  </td>
      {/if} 
      {if $vopc eq 4}
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" name="accion" value="Guardar"></td> 
      {/if} 
      <td class="cnt"><a href="m_reclaintnac.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
    </tr>
  </table>
</form>

</div>  
</body>
</html>
