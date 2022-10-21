<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

&nbsp;
&nbsp;
&nbsp;
&nbsp;

<!-- <table width="70%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" align='center'>
<!--  <tr><td>
  <fieldset>
  <legend align='center'>
  <strong>Documentos Anexos correspondientes al Tramite No. {$vreftra} - Solicitud No. {$vsol}</strong>
  </legend>
  {assign var="cont" value="1"}
  {foreach from=$vrefsol item=curr_id}
  {assign var="nomfor0" value="otrofor"}
  {assign var="nomfor1" value=$nomfor0|cat:$cont}
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" > -->
  <!--   <tr><td colspan=2 class="izq9-color">SOLICITUD: {$curr_id}</td></tr>
   <tr><td colspan=2>Nombre: {$vnomsol[$cont]}</td></tr>
   <tr><td colspan=2>Tipo: {$vtipder[$cont]}</td></tr> 
   <tr><td colspan=2>Clase Internacional: {$vclaint[$cont]}</td></tr> 
   <tr><td colspan=2 >Clase Nacional: {$vclanac[$cont]}</td></tr>
   <tr><td colspan=2><hr /></td></tr> --> 
<!--   <tr><td>
   {if $vcanane0[$cont]>0}
     {assign var="cont2" value="1"}
     {section name=seccion start=0 loop=$vcanane[$cont] step=1}
     {assign var="nomfor" value=$nomfor1|cat:$cont2}
<form name={$nomfor} enctype="multipart/form-data" action="z_enviodoc.php?vopc=2&vsol={$curr_id}&vreftra={$vreftra}&vcod={$vcodane[$cont][$cont2]}&vsub={$vsubdir[$cont][$cont2]}" onsubmit="document.{$nomfor}.enviar.style.display='none';document.{$nomfor}.imagenproc.style.display='inline';document.{$nomfor}.imagenproc.visibility='visible';" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      {if $vestane[$cont][$cont2]==0}
      <tr>
          <td width="25%">&nbsp;&nbsp;<img src="../imagenes/bullet_red.png">&nbsp;{$vdesane[$cont][$cont2]}</td> -->
      <!--          <td width="25%">&nbsp;&nbsp;<input align='center' type="checkbox" name={$recaudo} >&nbsp;{$vdesane[$cont][$cont2]}</td> -->
<!--          <td width="60%"><input name="ubicacion" type="file" size="60" onchange="checkear(this);" ></td>
          <td>&nbsp;&nbsp;<input name="enviar" type="submit" value="Cargar Archivo" class="botones">
                          </td></tr> -->
      <!-- <img name="imagenproc" src="../imagenes/procesando3.gif" STYLE="display:none"> 
      STYLE="display:inline"-->
<!--      {else}
      <tr><td width="25%">&nbsp;&nbsp;<img src="../imagenes/tick.png">&nbsp;{$vdesane[$cont][$cont2]}</td></tr>
      {/if}
     </table>
</form>
     {assign var="cont2" value=$cont2+1}
     {/section}
   {else}
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr valign='bottom'><td width='30%'>&nbsp;&nbsp;<img src='../imagenes/tick.png' />&nbsp;Todos los Documentos anexos requeridos para esta Solicitud ya fueron cargados.</td></tr>
     </table>
   {/if}
   {assign var="cont" value=$cont+1}
  {/foreach}
   </td></tr>
 </table>  -->

<!--
<TABLE WIDTH=100% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0>
	<COL WIDTH=115*>
	<COL WIDTH=13*>
	<COL WIDTH=117*>
	<COL WIDTH=11*>
	<TR VALIGN=TOP>

		<TD WIDTH=45%>
			<UL>
			  <LI> <A HREF="../graficos/docutemp/poder/{$vtramt}.pdf"   target='_blank'> Poder </A> 
			</UL>
		</TD>
		<TD WIDTH=5% align='center'>
			<input align='center' type="checkbox" name="recaud1" >		
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/asamblea/{$vtramt}.pdf"   target='_blank'>  Acta Ultima Asamblea  </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud2" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/reglamento/{$vtramt}.pdf"   target='_blank'> Reglamento de uso de Marca </A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud3" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI>  <A HREF="../graficos/docutemp/cedula/{$vtramt}.pdf"   target='_blank'> Cedula de Identidad </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud4" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/prioridad/{$vtramt}.pdf"   target='_blank'> Documento(s) de Prioridad y  Certificado de Registro Extranjero</A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud5" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/rif/{$vtramt}.pdf"   target='_blank'> Rif </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud6" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/mercantil/{$vtramt}.pdf"   target='_blank'> Registro Mercantil </A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud7" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/otros/{$vtramt}.pdf"   target='_blank'> Otros </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud8" >
		</TD>
	</TR>
	
</TABLE>
-->
<form name="wingresol" id="w_grabar" action="w_ingrefusm.php?vopc=6" method="post">

  <TABLE WIDTH=70% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0 align='center'>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. TR&Aacute;MITE:</b>
      </td><td></br><font face='Arial' size='4'>
      {$vtramt}</br>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. REFERENCIA:</b>
      </td><td></br><font face='Arial' size='4'>
      {$vnumref}</br>
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. Registro:</b>
      </td><td><font face='Arial' size='4'>
      {$vnregsipi}
  </font></br></td></tr>

  <tr><td WIDTH=30% class='izq-color'><b>Nombre / Logotipo:</b>
      </td><td></br><font face='Arial' size='4'>
      {$vnmarsipi}</br>

      {if (file($nameimage))}
         <td width='22%' rowspan='9' align='center' style='background-color: #FFFFFF; border: 1 solid #C6DEF2'>
            <a href='{$nameimage}' target='_blank'><img border='0' src={$nameimage} width='150' height='150'>
         </td></a>"; 
      {/if}
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Nro. Solicitud:</b>
      </td><td><font face='Arial' size='4'>
      {$vnsolsipi}
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Clase Internacional:</b>
      </td><td><font face='Arial' size='3'>
      {$vnclasint}
      <!-- <input type='text' size='2' name='$vnclasint' maxlength='2' value='{$vnclasint}' onkeyup="checkLength(event,this,2,document.wingresol.vnclasnac);" onKeyPress="return acceptChar(event,2, this)"></br> -->
  </font></br></td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Sobreviviente:</b>
      </td><td><font face='Arial' size='3'>
      {$vnclasnac}
      <!-- <input type='text' size='2' name='$vnclasnac' maxlength='2' value='{$vnclasnac}' onkeyup="checkLength(event,this,2,document.wingresol.vpod1);" onKeyPress="return acceptChar(event,2, this)"></br> -->
  </font></br></td></tr>
  {if $vpedirpoder=='S'}
    <tr><td WIDTH=30% class='izq-color'><b>N&uacute;mero de Poder:</b>
       </td><td><input type='text' size='3' name='vpod1' maxlength='4' value='{$vpod1}' onkeyup="checkLength(event,this,4,document.wingresol.vpod2);" onKeyPress="return acceptChar(event,2, this)">-<input type='text' size='3' name='vpod2' maxlength='4' value='{$vpod2}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.wingresol.vfact);"><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000-0000 (año-n&uacute;mero)</font>
    </td></tr>
  {/if}
  <tr><td class='izq-color'><b>N&uacute;mero de DOCUMENTO:</b>
     </td><td><input type='text' size='10' name='vdoc' maxlength='10' value='{$vdoc}' onKeyPress="return acceptChar(event,2, this)"><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000000 (n&uacute;mero)</font>
  </td></tr>
  <tr><td WIDTH=30% class='izq-color'><b>Requisitos M&iacute;nimos Asociados a la Solicitud:</b>
      </td><td></br><font face='Arial' size='4'>
      {if $vdocanexoa=='S'}<input align='center' type="checkbox" name="recaud1" STYLE="display:none">{$vlitanexoa}</br>{/if}
      {if $vdocanexob=='S'}<input align='center' type="checkbox" name="recaud2" STYLE="display:none">{$vlitanexob}</br>{/if} 
      {if $vdocanexoc=='S'}<input align='center' type="checkbox" name="recaud3" STYLE="display:none">{$vlitanexoc}</br>{/if}
      {if $vdocanexof=='S'}<input align='center' type="checkbox" name="recaud4" STYLE="display:none">{$vlitanexof}</br>{/if}
      {if $vdocanexog=='S'}<input align='center' type="checkbox" name="recaud5" STYLE="display:none">{$vlitanexog}</br>{/if}
      {if $vdocanexoh=='S'}<input align='center' type="checkbox" name="recaud6" STYLE="display:none">{$vlitanexoh}</br>{/if}
      {if $vdocanexoi=='S'}<input align='center' type="checkbox" name="recaud7" STYLE="display:none">{$vlitanexoi}</br>{/if}
  </font></br></td></tr>

  <tr><td class='izq-color'><b>Fecha de Presentaci&oacute;n:</b>
     </td><td>
        <!--
        <input type='text' name='fecha_reno' value='{$fecha_reno}' size='10' onChange="valFecha(document.wingresol.fecha_reno)" onkeyup="checkLength(event,this,10,document.wingresol.vcarp)">
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar94');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>        
        -->
        <input type='text' name='fecha_reno' value='{$fecha_reno}' size='10' readonly>
  </td></tr>

  <tr><td class='izq-color'><b>N&uacute;mero de CARPETA:</b>
     </td><td><input type='text' size='10' name='vcarp' maxlength='10' value='{$vcarp}' onKeyPress="return acceptChar(event,2, this)"><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000000 (n&uacute;mero)</font>
  </td></tr>

  <tr><td class='izq-color'><b>N&uacute;mero de FACTURA Pago de Tasa:</b>
     </td><td>F<input type='text' size='6' name='vfact' maxlength='7' value='{$vfact}' onKeyPress="return acceptChar(event,2, this)" onchange='for(var x=this.value.length;x<7;x++) this.value=0+this.value;'><font face='Arial' color='#800000' size='3' valign='up'>*</font><font face='Arial' color='#000000' size='1'>Formato: 0000000 (n&uacute;mero)</font>
  </td></tr>

  <tr><td class='izq-color'><b>Comentario Adicional de ser Necesario:</b>
     </td><td><input type='text' size='73' name='vcomadi' maxlength='100' value='{$vcomadi}'>
  </td></tr>

  </table>

 </strong>
 </fieldset>
 </td></tr>
</table>
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<!-- <form name="wingresol" id="w_grabar" action="w_ingresol.php?vopc=6" method="post"> -->
<input type ='hidden' name='vtramt' value={$vtramt}> 
<input type ='hidden' name='vsol' value={$vsol}> 
<input type ='hidden' name='vfec_tram' value={$vfec_tram}> 
<input type ='hidden' name='vpedpod' value={$vpedirpoder}> 

<!-- <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr><td>
  <fieldset>
  <legend align='center'>
  <strong>Causales de Devoluci&oacute;n</strong>
  </legend>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr><td><input type="checkbox" name="causa1"></td><td><img src="../imagenes/bullet_red.png">&nbsp;{$descausa[0]}</td></tr>
	<tr><td><input type="checkbox" name="causa2"></td><td><img src="../imagenes/bullet_red.png">&nbsp;{$descausa[1]}</td></tr>
	<tr><td><input type="checkbox" name="causa3"></td><td><img src="../imagenes/bullet_red.png">&nbsp;{$descausa[2]}</td></tr>
{if $descausa[3] neq ''}<tr><td><input type="checkbox" name="causa4"></td><td><img src="../imagenes/bullet_red.png">{$descausa[3]}</td></tr>{/if}
{if $descausa[4] neq ''}<tr><td><input type="checkbox" name="causa5"></td><td><img src="../imagenes/bullet_red.png">{$descausa[4]}</td></tr>{/if}
{if $descausa[5] neq ''}<tr><td><input type="checkbox" name="causa6"></td><td><img src="../imagenes/bullet_red.png">{$descausa[5]}</td></tr>{/if}
{if $descausa[6] neq ''}<tr><td><input type="checkbox" name="causa7"></td><td><img src="../imagenes/bullet_red.png">{$descausa[6]}</td></tr>{/if}
	<tr><td>Otro:</td><td><input size="120" type="text" name="otro"></td></tr>
 </table>  
 </strong>
 </fieldset>
 </td></tr>
</table> -->
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<table width="30%" align="center">
    <tr align="center">
      <td width="50%" align="center">
       <input type ='hidden' name='vaccion' value='0'>
<!--      {if $vopc eq 4} -->
	  <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save" border="0" onclick="document.wingresol.vaccion.value='1'">
      </td><td width="50%" align="center">
<!--	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="center" name="save2" border="0" onclick="document.wingresol.vaccion.value='2'"> 
     {else}
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar y Aprobar Examen de Forma </a>  
      {/if} -->
</form>
<!--      </td><td>&nbsp;</td> -->
      <!-- <td width="30%" align="center">
	 <a href="z_solmarweb.php?vopc=4&vreftra={$vtramt}&vrefsol={$vsol}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/note_f2.png',1);">
	 <img src="../imagenes/note_f2.png" alt="Cancel" align="center" name="cancel" border="0" /></a>
      </td><td>&nbsp;</td>       
  &nbsp;&nbsp;    
      <td width="10%" align="center"> -->
 	 <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/salir_f2.png',1);">
	 <img src="../imagenes/salir_f2.png" alt="Salir" align="center" name="salir" border="0" /></a>    
      </td>
    </tr>
    <tr align="center"><td width="50%" align="center">Ingresar Fusi&oacute;n</td><td width="50%" align="center">Salir</td>
    </tr>
</table>
&nbsp;
&nbsp;&nbsp;
&nbsp;
</body>
</html>

<!--

-->

