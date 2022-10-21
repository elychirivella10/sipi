<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="p_pbexdise.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='vsol' value={$vsol}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>

  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
         <input tabindex="1" type="text" name="v1" size="6" maxlength="6" value='{$vsol1}' {$modo1} onKeyPress="return acceptChar(event,2, this)">&nbsp;
      </td>
      <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  </td>
  </tr>
  </table>
</form>				  

<form name="formarcas2" enctype="multipart/form-data" action="p_pbexdis1.php?vopc=0" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='v1' value={$vsol1}>
  <input type ='hidden' name='accion' value={$accion}>
  <input type ='hidden' name='nameimage' value={$nameimage}>
  <input type ='hidden' name='sede' value={$sede}>
  
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color">
         <input type="text" name="fecharec" {$modo} value='{$fecharec}' size="10" align="right">
      </td>
      <td class="izq3-color" >{$campo7}</td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo3}</td>
      <td class="der-color">
        <select size="1" name="prioridad" {$modo2} >
          {html_options values=$arraytipom selected=$prioridad output=$arraynotip}
        </select>
      </td>
      <td class="der-color" rowspan="8" valign="top">
        <input name="ubicacion" type="file" {$modo2} value='{$ubicacion}' size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><a href='{$nameimage}' target='_blank'><img border='0' src='{$nameimage}' width='270' height='270'></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
         <input type="text" name="recibo" {$modo} value='{$recibo}' size="6" >
      </td>
    </tr>

    <tr>
      <td class="izq-color" >{$campo5}</td>
      <td class="der-color">
	<textarea rows="2" name="solicitant" {$modo} cols="57" maxlength="80">{$solicitant}</textarea>
      </td>
    </tr> 
     <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input tabindex="2" type="text" name="locarno1" {$modo} value='{$locarno1}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">-
        <input tabindex="2" type="text" name="locarno2" {$modo} value='{$locarno2}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr>

    <!-- {if $accion eq 1}
     <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
        <input tabindex="2" type="text" name="clase" {$modo3} value='{$clase}' size="1" maxlength="2" onKeyPress="return acceptChar(event,2,this)">
      </td>
    </tr> 
    {else}
    <tr>
      <td class="izq-color" ></td>
      <td class="der-color" colspan="2"></td>
    </tr> 
    {/if} -->
    </table>
    &nbsp;

  <!-- <table width="85%" border="1" cellspacing="1">
    <tr><td class="izq4-color" colspan="2">{$lcviena}</td></tr>
    <tr><td>    
    <iframe id='top' style='width:99%;height:90px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" {$modo3} size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" {$modo3} onclick="gestionvienap(document.formarcas2.v1,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" {$modo3} onclick="gestionvienap(document.formarcas2.v1,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
  </table> --> 

  <table class="menubar1" cellpadding="0" cellspacing="0" border="1">
  <tr>
   <td class="menudottedline" width="95%">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;p_pbexdise.php<p></b>Descripci&oacute;n: Rescata todas aquellas solicitudes de Patentes que presenta el Codigo de Locarno especificado.</font>
     </div>	
   </td>
   
   <td class="menudottedline" width="73%" ></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" >
              <input type="image" {$modo3} src="../imagenes/control_play_blue.png" value="Procesar" border="0">Procesar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../patentes/p_pbexdise.php?vopc=5">
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
  <p>&nbsp;</p>
  <p>&nbsp;</p>

</form>
</div>  

</body>
</html>
