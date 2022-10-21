<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <div align="center">
    <form name="formarcas1" action="m_prorroga.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color">{$lsolicitud}</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)">
		<td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
    </form>			  

    <form name="formarcas2" action="m_prorroga.php?vopc=3" method="post" onsubmit='return pregunta();'>
      <input type="hidden" name="vsol1" value='{$vsol1}'>
      <input type="hidden" name="vsol2" value='{$vsol2}'>
      <input type="hidden" name="fecha_venc" value='{$fecha_venc}'>

      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color">{$lfechasolic}</td>
	    <td class="der-color"><input size="10" type="text" name="vfecsol" value='{$vfecsol}' {$modo}></td>
   {if ($vmod eq "G" || $vmod eq "M") }
	        <td class="der-color" rowspan="7" align="center" valign="top">
                <a href='{$nameimage}' target="_blank">
                <img border="-1" src={$nameimage} width="180"></td>
	    {/if}    
	</tr>
	<tr><td class="izq-color">{$lnombre}</td>
	    <td class="der-color"><input size="63" type="text" name="vnom" value='{$nombre}' {$modo}>   </td>
	</tr>
	<tr><td class="izq-color">{$lclase}</td>
	    <td class="der-color"><input size="1" type="text" name="vcla" value='{$clase}' {$modo}>
	                <input size="14" type="text" name="vindcla" value='{$ind_claseni}' {$modo}></td></tr>
	<tr>
      <td class="izq-color" >{$lmodal}</td>
      <td class="der-color">
        <input size="12" name="vmod" '{$modo}' value='{$vmodal}'></td></tr>

     <tr>
	    <td class="izq-color">{$lfechaevent}</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" value='{$vfevh}' {$modo1} onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
	    onchange="valFecha(this,document.formarcas2.otro)"><td>
     </tr>
	<tr><td class="izq-color">{$lboletin}</td>
	    <td class="der-color"><input size="3" type="text" name="vbol" value='{$vbol}' {$modo1}>   </td>
	</tr>

     <tr>
       <td class="izq-color" >{$campo1}</td>
       <td class="der-color">
         <select size="1" name="prorroga" {$modo2} >
           {html_options values=$arrayprom selected=$prorroga output=$arrayprop}
         </select>
       </td>
     </tr>
     </table>
     &nbsp;

     <input type="hidden" name="vsolh" value='{$vsol1}-{$vsol2}'>
     <input type="hidden" name="nderec" value='{$nderec}'>

  <table class="menubar2" cellpadding="0" cellspacing="0" border="1">
  <tr>
   <td class="menudottedline">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;m_prorroga.php<p></b></font>
     </div>	
   </td>
   
   <td class="menudottedline" width="9%"></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="m_rptcronol.php?vsol1={$solicitud1}&vsol2={$solicitud2}">
	      <img src="../imagenes/folder_f2.png" alt="&nbsp;Cronologia" name="Cronologia" title="Cronolog&iacute;a" align="left" border="0" /><br/>&nbsp;Cronolog&iacute;a</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" >
              <input type="image" {$modo3} src="../imagenes/database_save.png" value="Guardar" border="0">Guardar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../marcas/m_prorroga.php">
	      <img src="../imagenes/cancel_f2.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../index1.php">
	      <img src="../imagenes/salir_f2.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/>&nbsp;Salir</a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>
      </td>
   </td>
  </tr>
  </table>
  <p>&nbsp;</p>
  </center>

  </form>
  </div>  
  </body>
</html>

