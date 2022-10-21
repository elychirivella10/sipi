<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_verbusext.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>
  <input type ='hidden' name='name' value={$name}>

  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="v1" size="6" maxlength="6" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>
      <td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_verbusext.php?vopc=0" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='v1' value={$vsol1}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>
  <input type ='hidden' name='sede' value={$sede}>
  <input type ='hidden' name='envio' value={$envio}>
  <input type ='hidden' name='email' value={$email}>
  <input type ='hidden' name='name' value={$name}>
  
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right">
      </td>
      <td class="izq2-color" >{$campo7}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="prioridad" {$modo2} >
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <!--<input name="ubicacion" type="file" {$modo2} value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;"> -->
        <br><a href='{$nameimage}' target='_blank'><img border='0' src='{$nameimage}' width='270' height='270'></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input type="text" name="recibo" {$modo} value='{$recibo}' size="7" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	<textarea rows="2" name="solicitant" {$modo} cols="57" maxlength="80">{$solicitant}</textarea>
      </td>
    </tr> 
    {if $accion eq 1}
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input tabindex="2" type="text" name="clase" {$modo} value='{$clase}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">
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
         <input tabindex="6" type="text" name="planilla" {$modo} value='{$planilla}' size="8" maxlength="8" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>
    
    </table>
    &nbsp;

   <td class="menudottedline" ></td>
   <td class="menudottedline" align="right">

	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a href='{$name}' target='_blank'><img border='1' src='../imagenes/boton_verresultado_rojo.png'></a>
	      <!-- <a><input type="image" {$modo3} src="../imagenes/boton_verresultado_rojo.png" value="Ver PDF" border="0"></a> -->
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a href="../marcas/m_verbusext.php?vopc=5">
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
</form>
</div>  

</body>
</html>
