<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">
<div align="center">
{if $vopc eq 3}
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=5"  method="POST" >  
{/if} 		  
{if $vopc eq 4}
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=1"  method="POST" >  
{/if} 		  
{if $vopc eq 6}
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=7"  method="POST" >  
{/if} 		  

  <table>
     <tr>
      <td class="izq5-color">{$campo4}</td>
      <td class="der-color">
	      <input tabindex="1" type="text" name="nctrlcer" size="5" maxlength="5" value='{$nctrlcer}' {$modo3}> 
      </td>
      {if $vopc eq 3}
      <td class="cnt">
        &nbsp;&nbsp;<input type="image" src="../imagenes/folder_add_f2.png" width="32" height="24" value="Nueva Solicitud">Nueva Solicitud
        </form>
      </td>
      {/if} 		  
      {if $vopc eq 4 || $vopc eq 6}
        <td class="cnt">
          &nbsp;&nbsp;<input tabindex="2" type='image' src="../imagenes/boton_buscar_rojo.png" value="Buscar">  
        </td>
      {/if}    
  </tr>
  </table>
  <br />
</form>				  

<br>
{if $vopc eq 1 || $vopc eq 5}
  <form name="forlotes" enctype="multipart/form-data" action="m_entregacert.php?vopc=2"  method="POST" onsubmit='return pregunta();'>
{/if}    
<!-- <form name="forlotes" enctype="multipart/form-data" action="m_controlcert.php?vopc=2"  method="POST" > -->
   <input type="hidden" name="usuario" value='{$usuario}'>
   <input type="hidden" name="nctrlcer" value='{$nctrlcer}'>
  
   <table cellspacing="1" border="1">
   <tr>
     <!--<tr>
       <td class="izq-color">{$campo4}</td>
       <td class="der-color" >
	      <input type="text" name="nctrlcer" size="5" maxlength="5" value='{$nctrlcer}' readonly > 
       </td>
     </tr> -->

     <tr>
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
        <select size="1" name="tipo" value='{$tipo}' {$modo1}>
          {html_options values=$arrayltipo selected=$tipo output=$arraydtipo}
        </select>
      <td>
     </tr>
     <tr>
      <td class="izq-color" >{$campo2}</td>
      <td class="der-color" >
         <input type="text" name="fechaper" {$modo} value='{$fechaper}' size="10" maxlength="10" align="left" onkeyup="checkLength(event,this,10,document.forlotes.vpag)" onchange="valFecha(this,document.forlotes.vpag)" >
      </td>
    </tr>
    </table>

   &nbsp; <p></p>
   <font class='nota6'><b>SOLICITANTE:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der-color" >
	      <input type="text" name="solicitante" {$modo} size="70" maxlength="80" value='{$solicitante}' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der-color" >
	      <input type="text" name="cisolicita" {$modo} size="10" maxlength="10" value='{$cisolicita}'>
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo7}</td>
       <td class="der-color" >
	      <input type="text" name="telefono" {$modo} size="15" maxlength="15" value='{$telefono}'>
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo8}</td>
       <td class="der-color" >
	      <input type="text" name="correo" {$modo} size="70" maxlength="80" value='{$correo}'>
       </td>
     </tr>
    <!-- <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color">
        <select size="1" name="indole">
          {html_options values=$arrayvind selected=$indole output=$arraytind}
        </select>
      </td>
    </tr> -->  
    <tr>
      <td class="izq-color">{$campo9}</td>
      <td class="der-color">
        {if $gestor_pn eq 'X'}
          <input type="checkbox" name="gestor_pn" checked="checked" disabled>Persona Natural Titular&nbsp;&nbsp;<br/>
        {else}  
          <input type="checkbox" name="gestor_pn" disabled>Persona Natural Titular&nbsp;&nbsp;<br/>
        {/if}  
        {if $gestor_pj eq 'X'}
          <input type="checkbox" name="gestor_pj" checked="checked" disabled>Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>
        {else}  
          <input type="checkbox" name="gestor_pj" disabled>Rep. Persona Jur&iacute;dica Nacional&nbsp;&nbsp;<br/>
        {/if}  
        {if $gestor_ap eq 'X'}
          <input type="checkbox" name="gestor_ap" checked="checked" disabled>Apoderado&nbsp;&nbsp;<br/>
        {else}  
          <input type="checkbox" name="gestor_ap" disabled>Apoderado&nbsp;&nbsp;<br/>
        {/if}  
        {if $gestor_ag eq 'X'}
          <input type="checkbox" name="gestor_ag" checked="checked" disabled>Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        {else}  
          <input type="checkbox" name="gestor_ag" disabled>Agente de la Propiedad Industrial No.&nbsp;&nbsp;
        {/if}  
        <input type="text" name='agente' size='6' maxlength="6" {$modo} value='{$agente}'><br/> 
      </td>
    </tr> 
    </table>

   &nbsp; <p></p>
   <!-- <font class='nota6'><b>AUTORIZADO:</b></font>
   &nbsp;
   <table cellspacing="1" border="1">
     <tr>
      <td class="izq-color" >{$campo10}</td>
      <td class="der-color">
        <select size="1" name="indaut" value='{$indaut}' {$modo1}>
          {html_options values=$arrayvaut selected=$indaut output=$arraytaut}
        </select>
      </td>
     </tr> 
     <tr>
       <td class="izq-color">{$campo5}</td>
       <td class="der-color" >
	      <input type="text" name="autorizado" {$modo} size="70" maxlength="80" value='{$autorizado}' onkeyup="this.value=this.value.toUpperCase()">
       </td>
     </tr>
     <tr>
       <td class="izq-color">{$campo6}</td>
       <td class="der-color" >
	      <input type="text" name="ciautorizado" {$modo} size="10" maxlength="10" value='{$ciautorizado}'>
       </td>
     </tr>
    </table> -->

   <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color">{$campo5}</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="m_verautoriza.php?pcod={$nctrlcer}"></iframe> 
    </td></tr>  
   </table>

   &nbsp; <p></p>
   &nbsp;
    <table width="70%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="3">{$campo3}</td><td></td><td></td></tr>
    <tr><td>    

	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa1" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[0]}</td><td class="der-color" width="87%">{$descausa[0]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa2" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[1]}</td><td class="der-color" width="87%">{$descausa[1]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa3" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[2]}</td><td class="der-color" width="87%">{$descausa[2]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa4" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[3]}</td><td class="der-color" width="87%">{$descausa[3]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa5" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[4]}</td><td class="der-color" width="87%">{$descausa[4]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa6" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[5]}</td><td class="der-color" width="87%">{$descausa[5]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa7" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[6]}</td><td class="der-color" width="87%">{$descausa[6]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa8" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[7]}</td><td class="der-color" width="87%">{$descausa[7]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa9" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[8]}</td><td class="der-color" width="87%">{$descausa[8]}</td>
	</tr>
	<tr>
	 <td width="3%" class="der-color"><input type="checkbox" name="causa10" {$modo2}></td><td class="izq-color" width="10%">{$codcausa[9]}</td><td class="der-color" width="87%">{$descausa[9]}</td>
	</tr>
    <!-- {if $descausa[11] neq ''}
	   <td class="izq-color">{$codcausa[23]}</td><td class="der-color"><input type="checkbox" name="causa24"></td><td class="der-color">{$descausa[23]}</td>
	 {/if} --> 
    </td></tr>
    </table>
    
   &nbsp;
   <table width="180">
    <tr>
     <tr>
      <td class="cnt"><input type="image" {$modo} src="../imagenes/boton_procesar_rojo.png"></td> 
      <td class="cnt"><a href="m_entregacert.php?vopc=4"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
      <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
     </tr>
    </tr>
   </table>
</form>

</div>  
</body>
</html>
