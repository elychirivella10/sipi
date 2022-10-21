<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title>{$titulo}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.{$varfocus}.focus()">
  
  <!-- <H3>{$subtitulo}</H3> -->
  
  <div align="center">
    <form name="formarcas1" action="m_escritos_mod.php?vopc=1" method="post">
     <table>
        <tr><td class="izq5-color">N&uacute;mero de Escrito:</td>
<td class="der-color"><input type="text" name="vesc1" size="3" maxlength="4" 
	        value='{$vesc1}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vesc2)" onchange="Rellena(document.formarcas1.vesc1,4)">-<input type="text" name="vesc2" size="6" maxlength="6" 
	        value='{$vesc2}' {$vmodo} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit1)" onchange="Rellena(document.formarcas1.vesc2,6)">
                <td class="cnt">{if $vopc==0}<input name='submit1' type='image' src="../imagenes/page_edit.png" width="28" height="24" value="Buscar">  Buscar{/if}</td></tr>
    </form>
    </table>
      &nbsp; 
    <form name="formarcas2" action="m_escritos_mod.php?vopc=2" method="post">
      <input type="hidden" name="vesc" value='{$vesc}'>
      <input type="hidden" name="vesc1" value='{$vesc1}'>
      <input type="hidden" name="vesc2" value='{$vesc2}'>
      <table cellspacing="1">	
        <tr><td class="izq5-color">N&uacute;mero de Solicitud:</td>
            <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='{$vsol1}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol2)" onchange="Rellena(document.formarcas2.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='{$vsol2}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.submit2)" onchange="Rellena(document.formarcas2.vsol2,6)">
		{if $vopc==1}<input name='submit2' type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar {/if}</td> 
    </form>
    <form name="formarcas3" action="m_escritos_mod.php?vopc=3" method="post">
        <input type="hidden" name="vesc" value='{$vesc}'>
        <td>&nbsp;    &nbsp;    &nbsp;    &nbsp;</td>
        <td class="izq5-color">N&uacute;mero de Registro:</td>
                <td class="der-color"><input type="text" name="vreg1" value='{$vreg1}' size="1" maxlength="1" 
	        value='{$vreg1}' {$vmodo1} onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas3.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                      <input type="text" name="vreg2" value='{$vreg2}' size="6" maxlength="6" 
		value='{$vreg2}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas3.submit3)" onchange="Rellena(document.formarcas3.vreg2,6)">
		{if $vopc==1}<input name='submit3' type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar {/if}</td></tr>
        </table>
    </form>
    {if $vopc==1}
    <form name="formarcas4" action="m_escritos_mod.php?vopc=4" method="post">
        <table>
        <input type="hidden" name="vesc" value='{$vesc}'>
        <input type="hidden" name="vesc1" value='{$vesc1}'>
        <input type="hidden" name="vesc2" value='{$vesc2}'>
        <tr><td class="izq5-color">Sin Identificaci&oacute;n:</td>
               <td class="der-color"><input name='submit4' type='image' src="../imagenes/search_f2_no.png" width="28" height="24" value="Buscar">  No Buscar  </td></tr>

    </form>
    </table>
    {/if}
    &nbsp;
    &nbsp;
    <table>
    <form name="formarcas5" action="m_escritos_mod.php?vopc=5" method="post">
        <input type="hidden" name="vopcant" value='{$vopcant}'> 
        <input type="hidden" name="vesc" value='{$vesc}'>
        <input type="hidden" name="vesc1" value='{$vesc1}'>
        <input type="hidden" name="vesc2" value='{$vesc2}'>
        <input type="hidden" name="vsol1" value='{$vsol1}'>
        <input type="hidden" name="vsol2" value='{$vsol2}'>
        <input type="hidden" name="vreg1" value='{$vreg1}'>
        <input type="hidden" name="vreg2" value='{$vreg2}'>
	<tr><td class="izq-color">Nombre:</td>
	    <td class="der-color"><input size="88" type="text" name="vnom" maxlength="500" value='{$vnom}' {$vmodo3}>   </td></tr>
	<tr><td class="izq-color">Clase:</td>
	    <td class="der-color">
                        {if $vopc>1 && $vopc==4} 
                        <select size=1 name="vindcla" onchange= "this.form.vindcla.value=this.options[this.selectedIndex].value">
                            <option value='I'>Internacional</option> 
                            <option value='N'>Nacional</option>
	                </select>
                        {/if}
                        {if $vopc>1 && $vopc<>4} 
                            <input type="hidden" name="vindcla" value='{$vindcla}'> 
                            {if $vindcla=='I'} <input size="10" type="text" name="vindclavis" value='Internacional' {$vmodo3}> {/if}
                            {if $vindcla=='N'} <input size="10" type="text" name="vindclavis" value='Nacional' {$vmodo3}> {/if}
                        {/if}
	                <input size="2" type="text" name="vcla" value='{$vcla}' maxlength="2" {$vmodo3}>
            </td></tr> 
        <tr><td class="izq-color">Fecha:</td>
            <td class="der-color"><input size="9" {$vmodo2} type="text" name="vfecesc"  value='{$vfecesc}' onkeyup="checkLength(event,this,10,document.formarcas5.vtipesc)"
	    onchange="valFecha(this,document.formarcas5.vsol1)"><td> </tr>
	<tr><td class="izq-color">Tipo de Escrito:</td>
            <td class="der-color"><input size="6" type="text" name="vtipesc" value='{$vtipesc}' {$vmodo2} maxlength="3" onchange="valagente(document.formarcas5.vtipesc,document.formarcas5.vnomesc)">
                <select size=1 name="vnomesc" value='{$vnomesc}' onchange= "this.form.vtipesc.value=this.options[this.selectedIndex].value; this.form.vnomesc.value='{$vnomescnew[$key]}'">
                {foreach key=key item=item from=$vcodescnew}
                     {if $vnomescnew[$key]==$vnomesc} <option value='{$vcodescnew[$key]}' selected>{$vnomescnew[$key]}</option> 
                     {else} <option value='{$vcodescnew[$key]}'>{$vnomescnew[$key]}</option> {/if}
                {/foreach}
	        </select></td></tr>
        <tr><td class="izq-color">N&uacute;mero de Boletin:</td>
	    <td class="der-color"><input size="3" type="text" {$vmodo2} name="vdoc" value='{$vdoc}' maxlength="3" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,3,document.formarcas5.vcom)"></td></tr>
        <tr><td class="izq-color">Comentario del Escrito:</td>
	    <td class="der-color"><textarea rows="2" name="vcom" {$vmodo2} cols="75" onchange="this.value=this.value.toUpperCase()">{$vcom}</textarea></td></tr>
	<tr><td class="izq-color">C&oacute;digo del Agente:</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" value='{$vcodagen}' {$vmodo2} maxlength="6" onchange="valagente(document.formarcas5.vcodagen,document.formarcas5.vnomagen);">	    
	    <select size=1 name="vnomagen" value='{$vnomagen}' onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
                {foreach key=key item=item from=$vcodagenew}
                     {if $vnomagenew[$key]==$vnomagen} <option value='{$vcodagenew[$key]}' selected>{$vnomagenew[$key]}</option> 
                     {else} <option value='{$vcodagenew[$key]}'>{$vnomagenew[$key]}</option> {/if}
                {/foreach}
	    </select>
            </td></tr> 
	    <tr><td class="izq-color">Tramitante:</td>
	    <td class="der-color"><input size="88" type="text" name="vtra" value='{$vtra}' maxlength="120" {$vmodo2} onchange="this.value=this.value.toUpperCase()"></td></tr>      
         <tr><td class="izq-color">Motivos del Defecto:</td>
             <td><input type="checkbox" name="vmot1" {if $vmot1}checked{/if} {$vmodo2}><font face="Arial" color="#000000" size=2>Faltan Timbres Fiscales</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot2" {if $vmot2}checked{/if} {$vmodo2}><font face="Arial" color="#000000" size=2>Falta la Firma del interesado</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot3" {if $vmot3}checked{/if} {$vmodo2}><font face="Arial" color="#000000" size=2>Falta Nro. de Inscripci&oacute;n o el mismo no coincide</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot4" {if $vmot4}checked{/if} {$vmodo2}><font face="Arial" color="#000000" size=2>El nombre de la marca no coincide con el registrado en el sistema</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot5" {if $vmot5}checked{/if} {$vmodo2}><font face="Arial" color="#000000" size=2>Presentado en Fotocopia</font></td></tr>
         <tr><td></td>
             <td><input type="checkbox" name="vmot6" {if $vmot6}checked{/if} {$vmodo2}><font face="Arial" color="#000000" size=2>No existen datos asociados al evento</font></td></tr> 
         <tr><td class="izq-color">Otro Motivo:</td>
	     <td class="der-color"><input size="88" type="text" name="vomot" value='{$vomot}' maxlength="200" {$vmodo2}></td>
         </tr> 
      </table>
      &nbsp;
     <table width="235">
        <tr>
       {if $vopc>1}<td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td>{/if} 
       <td class="cnt"><a href="m_escritos_mod.php"><img src="../imagenes/cancel_f2.png" border="0"></a>	Cancelar 	</td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>		Salir 	</td>
        </tr>
     </table>
    </form>
  </div>  
  </body>
</html>

<!-- <tr>
                      <td><input type="checkbox" name="dc4"><font face="Arial" color="#000000" size=1>Direcci&oacute;n</font></td>
                      <td><input type="checkbox" name="dc5"><font face="Arial" color="#000000" size=1>DNDA</font></td>
                      <td><input type="checkbox" name="dc6"><font face="Arial" color="#000000" size=1>Finanza</font></td>
                    </tr>
-->

