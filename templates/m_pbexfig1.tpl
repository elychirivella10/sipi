<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_pbexfigu.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='accion' value={$accion}>

  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
         <input type="text" name="v1" size="6" maxlength="6" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>
      <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="z_browsef.php?vopc=0" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='v1'      value={$vsol1}>
  <input type ='hidden' name='accion'  value={$accion}>
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
  <input type ='hidden' name='envio'  value='{$envio}'>
  <input type ='hidden' name='email'  value='{$email}'>
  

  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecharec" {$modo2} value='{$fecharec}' size="10" align="right">
      </td>
      <td class="izq2-color" >{$campo7}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="prioridad" {$modo1} >
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <!-- <input name="ubicacion" type="file" {$modo1} value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;"> -->
        <br><img src='{$nameimage}' id="picture" width="270" height="270" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input type="text" name="recibo" {$modo2} value='{$recibo}' size="6" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	<textarea rows="2" name="solicitant" {$modo2} cols="57" maxlength="80">{$solicitant}</textarea>
      </td>
    </tr> 
    {if $accion eq 1}
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input type="text" name="clase" {$modo2} value='{$clase}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr> 
    {else}
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr> 
    {/if}
    <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
         <input tabindex="6" type="text" name="planilla" {$modo2} value='{$planilla}' size="8" maxlength="8" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    </table>

  <table>
  <tr>
    <td>
      <p align='center'><b><font size='2' face='Tahoma'>Se encontraron '{$subtotal}' Posibles Parecidos Graficos</font></b></p>
    </td>
  </tr>
  </table>

  <table width="960px" border="1" cellspacing="1">
    <tr><td class="izq4-color" colspan="2">{$lcviena}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}&vfac={$recibo}&vplan={$planilla}"></iframe> 
    </td></tr>
  </table>

  <table cellpadding="0" cellspacing="0" border="1" width="960px">
  <tr>
   <td class="menudottedline">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;m_pbinfigu.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Marcas que presenten los C&oacute;digos de Viena en la Clase Internacional de Niza especificada.</font>
     </div>	
   </td>
   
   <td class="menudottedline" ></td>
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
	      <a href="../marcas/m_pbexfigu.php?vopc=5">
	      <img src="../imagenes/boton_cancelar_rojo.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/></a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../index1.php">
	      <img src="../imagenes/boton_salir_rojo.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/></a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>
      </td>
   </td>
  </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

</form>
</div>  

</body>
</html>
