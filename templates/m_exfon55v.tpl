<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas1" action="m_exfon55.php?vopc=1" method="post">
  <input type='hidden' name='usuario' value='{$usuario}'>
  <input type='hidden' name='vsol' value='{$vsol}'>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  
  <table>
     <tr>
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color"><input type="text" name="vsol1" size="4" maxlength="4" 
	        value='{$vsol1}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
	 	     value='{$vsol2}' {$vmodo1} onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)"> &nbsp;
      </td>
      <td class="cnt"><input tabindex="2" type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
  </tr>
  </table>
</form>				  
</div>				  

<form name="formarcas2" enctype="multipart/form-data" action="m_exfon55.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value={$usuario}>
  <input type='hidden' name='vsol1' value={$vsol1}>
  <input type='hidden' name='vsol2' value={$vsol2}>
  <input type='hidden' name='varsol' value={$varsol}>
  <input type='hidden' name='opcion' value={$opcion}>
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <input type='hidden' name='vder' value='{$vder}'>

<table>
<tr>
  <table>
  <tr>
    <td width="85%">
       <div><strong> </strong></div>
    </td>

    <td align="rigth">
      <table>
         <tr>
	 <td>
	   <a href="m_exfon55.php?nconex={$n_conex}&salir=1&conx=0" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	   <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
	 </td>
 	 <td>&nbsp;</td>
	 <td>
 	   <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_rojo.png',1);">
	   <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>
	 </td>
	 <td>&nbsp;</td>
	 </tr>
	</table>
    </td>
  </tr>
  </table>

 <tr>
   <div class="tab-page" id="modules-cpanel">
   <script type="text/javascript">
      var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
   </script>

  <div class="tab-page" id="module33"><h2 class="tab">Basico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module33" ) );
  </script>
  <table width="100%" cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color">{$campo2}</td>
      <td class="der-color" colspan="3" >
         <input type="text" name="fecha_solic" {$vmodo} value='{$fecha_solic}' size="10" align="right" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      {$campo3}&nbsp;&nbsp;&nbsp;
      <input type="text" name="tipo_marca" {$vmodo} value='{$tipo_marca}' size="1" maxlength="2" > - 
      <input type="text" name="tipomarca" {$vmodo} value='{$tipomarca}' size="28" maxlength="30" >
      </td>
      <td class="der-color" rowspan="5" valign="top">
        {$campo8}
        <!-- <br><a href='{$nameimage}' target='_blank'><img border='0' id="picture" src='{$nameimage}' width='270' height='270'></a></br> -->
        <br><a href='{$nameimage}' target="_blank"><img border="-1" src={$nameimage} width="250" height="250"></a></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo4}</td>
      <td class="der-color">
	<textarea rows="2" name="nombre" {$vmodo} cols="75" maxlength="120">{$nombre}</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo16}</td>
      <td class="der-color">
         <input type="text" name="estatus" {$vmodo} value='{$estatus}' size="2" maxlength="3"> - 
         <input type="text" name="nombest" {$vmodo} value='{$nombest}' size="60" maxlength="120">
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo6}</td>
      <td class="der-color">
       <input type="text" name="modalidad" {$vmodo} value='{$modalidad}' size="1" maxlength="2" > - 
       <input type="text" name="modal" {$vmodo} value='{$modal}' size="15" maxlength="15" >
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       {$campo5}&nbsp;&nbsp;&nbsp;
        <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > - 
        <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo7}</td>
      <td colspan="2" class="der-color">
        <input type="text" name="vcodpais" {$vmodo} value='{$vcodpais}' size="1" maxlength="2" > - 
        <input type="text" name="pais_resid" {$vmodo} value='{$pais_resid}' size="30" maxlength="30" >
      </td>
    </tr> 
    <tr>
      <td class="izq-color" >{$campo9}</td>
      <td class="der-color" colspan="4" >
        <input type="text" name="tramitante" {$vmodo} value='{$tramitante}' size="65"  maxlength="65">
        &nbsp;&nbsp;&nbsp;&nbsp;{$campo10}&nbsp;&nbsp;
        <input type="text" name="vpod1" {$vmodo} value='{$vpod1}' align="right" size="3" maxlength="4" > - 
        <input type="text" name="vpod2" {$vmodo} value='{$vpod2}' align="right" size="4" maxlength="5" >
      </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo12}</td>
      <td class="der-color" colspan="4" >
        <input type="text" name="vsol3" {$vmodo} value='{$vpod1}' align="right" size="3" maxlength="4" > - 
        <input type="text" name="vsol4" {$vmodo} value='{$vpod2}' align="right" size="6" maxlength="6" >
      </td>
    </tr>
  </tr>
  </table>

  <table width="100%" cellspacing="1" border="1">
  <tr><td class="izq4-color">{$campo11}</td></tr>
  <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="m_veragente.php?psol={$vsol1}-{$vsol2}&pder={$vder}"></iframe> 
  </td></tr>  
  </table>

  <table width="100%" cellspacing="1" border="1">
   <tr><td class="izq4-color">Titular(es)</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="m_vertitular.php?pder={$vder}"></iframe> 
   </td></tr>  
  </table>
  &nbsp;
  </div>

  <div class="tab-page" id="module19"><h2 class="tab">Distingue</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module19" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>
  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="100%" class="der-color" >
	    <textarea rows="18" name="distingue" {$vmodo} cols="117">{$distingue}</textarea>
      </td>
    </tr> 
  </tr> 
  </table>
  </div>
  </div>

  <div class="tab-page" id="module43"><h2 class="tab">Logotipo</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module43" ) );
  </script>
  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table border="1" cellspacing="1" >
  <tr>
    <tr>
      <td class="der-color" rowspan="5" valign="top">
        Descripci&oacute;n y Clasificaci&oacute;n de Logotipo
        <br><a href='{$nameimage}' target="_blank"><img border="-1" src={$nameimage} width="250" height="250"></a></br>
      </td>
    </tr>
    <tr>
      <td width="100%" class="der-color" valign="top">
	     <textarea rows="9" name="etiqueta" {$vmodo} cols="85">{$etiqueta}</textarea>
      </td>
    </tr> 
    &nbsp;
    <tr><td>    
      <iframe id='top' style='width:100%;height:115px;background-color: WHITE;' src="m_verccv.php?psol={$vsol1}-{$vsol2}"></iframe> 
    </td></tr>
  </tr>
  </table>
  </div>

  
  <div class="tab-page" id="module21"><h2 class="tab">Cronologia</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module21" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1" >
  <tr>
    <tr>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha
    Evento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Vencimiento
    Evento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Nro
    Documento</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Codigo del
    Evento</b></font></td>
      <td width="20%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Descripcion</b></font></td>
      <td width="10%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Fecha de
    Transaccion</b></font></td>
      <td width="30%" align="center" style="background-color: #015B9E; border: 1 solid #D8E6FF"><font face="MS Sans Serif" color="#FFFFFF"><b>Comentarios</b></font></td>
    </tr>
    {section name=cont loop=$vnumrows}
    <tr>
       <td class="der-color">{$arr_ph1[cont]}</td>
       <td class="der-color">{$arr_ph2[cont]}</td>
       <td class="der-color">{$arr_ph3[cont]}</td>
       <td class="der-color">{$arr_ph4[cont]}</td>
       <td class="der-color">{$arr_ph5[cont]}</td>
       <td class="der-color">{$arr_ph6[cont]}</td>
       <td class="der-color">{$arr_ph7[cont]}</td>
       <!-- <td class="der-color">{$arr_ph8[cont]}</td> -->
       </td>
    </tr>
    {/section} 
  </tr> 
  </table>
  </div>
  </div>

  <div class="tab-page" id="module32"><h2 class="tab">E.Electronico</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module32" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" class="celda6" border="1" bordercolor="000000" cellspacing="1" cellpadding=3>
  <COL WIDTH=115*>
  <COL WIDTH=117*>
  <tr>

    <TR VALIGN=TOP>
	<TD WIDTH=45%  >
	   <UL>
             <LI><A HREF=  "../documentos/planilla/pl{$varsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Planilla de Solicitud</A> 
	   </UL>
	</TD>
	<TD WIDTH=46%  >
	   <UL>
	     <LI><A HREF="../marcas/m_rptcronol.php?vsol1={$vsol1}&vsol2={$vsol2}" target='_blank'>Cronolog&iacute;a</A> 		
	   </UL>
	</TD>
    </TR>		
    <TR VALIGN=TOP>
	<TD WIDTH=45%>
	   <UL>
	     <LI><A HREF="../documentos/fonetica/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>B&uacute;squeda Fon&eacute;tica</A>         
           </UL>
	</TD>
	<TD WIDTH=46%>
	   <UL>
	     <LI><A HREF="../documentos/grafica/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>B&uacute;squeda Gr&aacute;fica</A> 
	   </UL>
	</TD>
    </TR>
    <TR VALIGN=TOP>
	<TD WIDTH=45%>
	   <UL>
	     <LI><A HREF="../documentos/cedula/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>C&eacute;dula de Identidad</A>
	   </UL>
	</TD>
	<TD WIDTH=46%>
  	   <UL>
	     <LI><A HREF="../documentos/rif/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Rif</A>
	   </UL>
	</TD>
    </TR>
    <TR VALIGN=TOP>
	<TD WIDTH=45%>
	   <UL>
	     <LI><A HREF="../documentos/poder/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Poder</A> 
	   </UL>
	</TD>
	<TD WIDTH=46%>
	   <UL>
	     <LI><A HREF="../documentos/mercantil/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Registro Mercantil</A> 
	   </UL>
	</TD>
    </TR>
    <TR VALIGN=TOP>
	<TD WIDTH=45%>
	   <UL>
	     <LI><A HREF="../documentos/reglamento/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Reglamento de Uso de Marca</A> 
	   </UL>
	</TD>
	<TD WIDTH=46%>
	   <UL>
	     <LI><A HREF="../documentos/asamblea/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Acta Ultima Asamblea</A> 	   
           </UL>
	</TD>
    </TR>
   <TR VALIGN=TOP>
        <TD WIDTH=45%>
	   <UL>
	     <LI><A HREF="../documentos/prioridad/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Documento(s) de Prioridad y Certificado de Registro Extranjero</A> 				
	   </UL>
	</TD>
	<TD WIDTH=46%>
	   <UL>
	     <LI><A HREF="../documentos/otros/ef{$vsol1}/{$vsol1}{$vsol2}.pdf" target='_blank'>Otros</A>
	   </UL>
	</TD>
    </TR>
  </tr> 
  </table>

  <table width="350">
    <tr>
      <td><a href="m_rptexp.php?varsol={$varsol}"><img src="../imagenes/folder_explore.png" border="0"></a>&nbsp;&nbsp;Ver Expediente Completo</td>
    </tr>
  </table>


  </div>
  </div>

  <div class="tab-page" id="module31"><h2 class="tab">B.Fonetica</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module31" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <p align="center"><font size="4" face="Tahoma">Antecedentes de Identidad en todas las Clases</font>

  <table width="100%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">Identidad</td></tr>
    <tr><td>    
    <iframe id='top1' style='width:99%;height:300px;background-color: WHITE;' src="m_verfoniden.php?psol={$vsol1}-{$vsol2}"></iframe>  
    </td></tr>
  </table>
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <td>
     <a href="../consultamarcas/indexgramatical.php" target='_blank'><font size="2" face="Tahoma"><b><i>&nbsp;&nbsp;Haga Clic aqui, si desea Realizar B&uacute;squeda Gramatical</i></b></font></a>
    </td>
  </tr> 
  </table>

  <p align="center"><font size="4" face="Tahoma">Antecedentes de Semejanza en la Clase Solicitada</font>
  <table width="100%" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">Semejanzas</td></tr>
    <tr><td>    
    <iframe id='top2' style='width:99%;height:300px;background-color: WHITE;' src="m_verfonsem.php?psol={$vsol1}-{$vsol2}"></iframe>  
    </td></tr>
  </table>
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <td>
     <a href="../consultamarcas/indexgramatical.php" target='_blank'><font size="2" face="Tahoma"><b><i>&nbsp;&nbsp;Haga Clic aqui, si desea Realizar B&uacute;squeda Gramatical</i></b></font></a>
    </td>
  </tr> 
  </table>

  </div>
  </div>

  <div class="tab-page" id="module28"><h2 class="tab">Devuelta</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module28" ) );
  </script>
  <div align="left">

  <table width="100%" border="3" cellspacing="1">
  <tr>
   <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTA?A CORRESPONDIENTE</b></font></small>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="3" cellspacing="1">
  <tr>
	<tr>
	 <td class="izq-color">{$codcausa[0]}</td><td class="der-color"><input type="checkbox" name="causa1"><td>
         <td class="der-color">{$descausa[0]}</td>
	 <td class="izq-color">{$codcausa[1]}</td><td class="der-color"><input type="checkbox" name="causa2"><td>
         <td class="der-color">{$descausa[1]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[2]}</td><td class="der-color"><input type="checkbox" name="causa3"><td>
	 <td class="der-color">{$descausa[2]}</td>
	 <td class="izq-color">{$codcausa[3]}</td><td class="der-color"><input type="checkbox" name="causa4"><td>
	 <td class="der-color">{$descausa[3]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[4]}</td><td class="der-color"><input type="checkbox" name="causa5"><td>
	 <td class="der-color">{$descausa[4]}</td>
	 <td class="izq-color">{$codcausa[5]}</td><td class="der-color"><input type="checkbox" name="causa6"><td>
	 <td class="der-color">{$descausa[5]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[6]}</td><td class="der-color"><input type="checkbox" name="causa7"><td>
	 <td class="der-color">{$descausa[6]}</td>
	 <td class="izq-color">{$codcausa[7]}</td><td class="der-color"><input type="checkbox" name="causa8"><td>
	 <td class="der-color">{$descausa[7]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[8]}</td><td class="der-color"><input type="checkbox" name="causa9"><td>
	 <td class="der-color">{$descausa[8]}</td>
	 <td class="izq-color">{$codcausa[9]}</td><td class="der-color"><input type="checkbox" name="causa10"><td>
	 <td class="der-color">{$descausa[9]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[10]}</td><td class="der-color"><input type="checkbox" name="causa11"><td>
	 <td class="der-color">{$descausa[10]}</td>
	 <td class="izq-color">{$codcausa[11]}</td><td class="der-color"><input type="checkbox" name="causa12"><td>
	 <td class="der-color">{$descausa[11]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[12]}</td><td class="der-color"><input type="checkbox" name="causa13"><td>
	 <td class="der-color">{$descausa[12]}</td>
	 <td class="izq-color">{$codcausa[13]}</td><td class="der-color"><input type="checkbox" name="causa14"><td>
	 <td class="der-color">{$descausa[13]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[14]}</td><td class="der-color"><input type="checkbox" name="causa15"><td>
	 <td class="der-color">{$descausa[14]}</td>
	 <td class="izq-color">{$codcausa[15]}</td><td class="der-color"><input type="checkbox" name="causa16"><td>
	 <td class="der-color">{$descausa[15]}</td></tr><tr>
	 <td class="izq-color">{$codcausa[16]}</td><td class="der-color"><input type="checkbox" name="causa17"><td>
	 <td class="der-color">{$descausa[16]}</td> 
{if $descausa[17] neq ''}
	 <td class="izq-color">{$codcausa[17]}</td><td class="der-color"><input type="checkbox" name="causa18"><td><td class="der-color">{$descausa[17]}</td></tr><tr>{/if}
{if $descausa[18] neq ''}
	 <td class="izq-color">{$codcausa[18]}</td><td class="der-color"><input type="checkbox" name="causa19"><td><td class="der-color">{$descausa[18]}</td>{/if}
{if $descausa[19] neq ''}
	 <td class="izq-color">{$codcausa[19]}</td><td class="der-color"><input type="checkbox" name="causa20"><td><td class="der-color">{$descausa[19]}</td></tr><tr>{/if}
{if $descausa[20] neq ''}
	 <td class="izq-color">{$codcausa[20]}</td><td class="der-color"><input type="checkbox" name="causa21"><td><td class="der-color">{$descausa[20]}</td>{/if}
{if $descausa[21] neq ''}
	 <td class="izq-color">{$codcausa[21]}</td><td class="der-color"><input type="checkbox" name="causa22"><td><td class="der-color">{$descausa[21]}</td></tr><tr>{/if}
{if $descausa[22] neq ''}
	 <td class="izq-color">{$codcausa[22]}</td><td class="der-color"><input type="checkbox" name="causa23"><td><td class="der-color">{$descausa[22]}</td>{/if}
{if $descausa[23] neq ''}
	 <td class="izq-color">{$codcausa[23]}</td><td class="der-color"><input type="checkbox" name="causa24"><td><td class="der-color">{$descausa[23]}</td></tr><tr>{/if}
{if $descausa[24] neq ''}
	 <td class="izq-color">{$codcausa[24]}</td><td class="der-color"><input type="checkbox" name="causa25"><td><td class="der-color">{$descausa[24]}</td></tr><tr>{/if}

	</tr>
  </tr>
  </table>
  <table>
  <tr>
    <td class="izq-color">{$lotro}</td><td class="der-color"><input type="text" name="otro" {$modo} size="148" ><td>
  </tr>
  </table>
  <table border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" {$vmodo} value="500" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento1" {$modo} value='{$fevento1}' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Devolver'" />
        {else}
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        {/if}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module25"><h2 class="tab">Concedida</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module25" ) );
  </script>
  <div align="left">
  <table width="100%" border="1" cellspacing="1">
  <tr>
    <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTA?A CORRESPONDIENTE</b></font></small>
    <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
    </tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3" >
        <input type="text" name="evento" {$vmodo} value="51" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento" {$modo} value='{$fevento}' size="10" maxlength="10" onkeyup="checkLength(event,this,10,document.formarcas2.save)" onchange="valFecha(this,document.formarcas2.save)" >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Conceder'" />
        {else}
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        {/if}
      </td>
    </tr>

  </tr> 
  </table>
  </div>
  </div>
  &nbsp;

  <div class="tab-page" id="module29"><h2 class="tab">Negada</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module29" ) );
  </script>
  <div align="left">

  <table width="100%" border="1" cellspacing="1">
  <tr>
   <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTA?A CORRESPONDIENTE</b></font></small>
   <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="75" maxlength="120">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
   </tr>
  </tr> 
  </table>

  <table width="100%" border="1" cellspacing="1">
  <input type ='hidden' name='vcomenta' value='{$vcom}'>
  <tr>
    <tr>
      <td class="izq-color">{$lcomentario}</td><td class="der-color">
        <textarea rows="2" name="comenta1" {$modo} cols="104" onchange="this.value=this.value.toUpperCase()"></textarea>
      </td>
    </tr>
  </tr>
  </table>	
  &nbsp;

     <table>	    
	<tr>
	 <td class="izq-color">{$lart}</td><td class="der-color"><input size="2" type="text" name="art" maxlength="2"  onKeyPress="return acceptChar(event,2, this)" onchange="validart56(this,document.formarcas2.lit1,document.formarcas2.vlit1reg11)" onkeyup="checkLength(event,this,2,document.formarcas2.lit1)">&nbsp;<td>
	 
	 <!-- Primer Literal - 1er. Registro -->	
	 <td class="izq-color">{$llit}</td><td class="der-color"><input size="1" type="text" name="lit1" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  
	 onkeyup="checkLength(event,this,2,document.formarcas2.vlit1reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit1reg11);">&nbsp;<td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg11" size="1" maxlength="1" 
	        value='{$lit1reg11}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg12" size="6" maxlength="6" 
		value='{$lit1reg12}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg21)" onchange="Rellena(document.formarcas2.vlit1reg12,6)">&nbsp;</td>
	<!-- <td rowspan="3">{$espacios}</td>	-->
	&nbsp;	
	 <!-- Segundo Literal - 1er. Registro -->	
	 <td class="izq-color">{$llit}</td><td class="der-color"><input size="1" type="text" name="lit2" maxlength="2" onKeyPress="return acceptChar(event,2, this)"  onkeyup="checkLength(event,this,2,document.formarcas2.vlit2reg11)"
onchange="validaliteral56(this,document.formarcas2.art,document.formarcas2.vlit2reg11);">&nbsp;<td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg11" size="1" maxlength="1" 
	        value='{$lit2reg11}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg12)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg12" size="6" maxlength="6" 
		value='{$lit2reg12}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg21)" onchange="Rellena(document.formarcas2.vlit2reg12,6)">&nbsp;</td></tr><tr>
 	 </tr><tr>
 	 
	 <!-- Primer Lireral - 2do. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg21" size="1" maxlength="1" 
	        value='{$lit1reg21}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg22" size="6" maxlength="6" 
		value='{$lit1reg22}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit1reg31)" onchange="Rellena(document.formarcas2.vlit1reg22,6)">&nbsp;</td>
		<td></td><td><td>	
		
	 <!-- Segundo Lireral - 2do. Registro -->	
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg21" size="1" maxlength="1" 
	        value='{$lit2reg21}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg22)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg22" size="6" maxlength="6" 
		value='{$lit2reg22}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vlit2reg31)" onchange="Rellena(document.formarcas2.vlit2reg22,6)">&nbsp;</td>
		</tr><tr>
		
    <!-- Primer Lireral - 3er. Registro -->	
	 <td></td><td><td>	
	 <td></td><td><td>
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit1reg31" size="1" maxlength="1" 
	        value='{$lit1reg31}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit1reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit1reg32" size="6" maxlength="6" 
		value='{$lit1reg32}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.lit2)" onchange="Rellena(document.formarcas2.vlit1reg32,6)">&nbsp;</td>
		
      <td></td><td><td>
      	 	 	
    <!-- Segundo Lireral - 3er. Registro -->	
	 <td class="der-color">{$lreg}</td><td class="der-color">
	        <input type="text" name="vlit2reg31" size="1" maxlength="1" 
	        value='{$lit2reg31}' onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vlit2reg32)"
		onChange="this.value=this.value.toUpperCase()">-
		<input type="text" name="vlit2reg32" size="6" maxlength="6" 
		value='{$lit2reg32}' onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.comenta)" onchange="Rellena(document.formarcas2.vlit2reg32,6)">&nbsp;</td></tr>			
     </table>
     &nbsp;
  
  <table border="3" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" {$vmodo} value="225" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento2" {$modo} value='{$fevento2}' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Negar'" />
        {else}
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        {/if}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  </div>
  </div>

  <div class="tab-page" id="module30"><h2 class="tab">Detener</h2>
  <script type="text/javascript">
     tabPane1.addTabPage( document.getElementById( "module30" ) );
  </script>
  <div align="left">
  <table width="100%" border="1" cellspacing="1">
  <tr>
  <small><font size="-2">NOTA:<b>PARA GRABAR LA ACCION DEBEN HACER CLIC SOBRE LA IMAGEN DEL DISKETTE EN LA PESTA?A CORRESPONDIENTE</b></font></small>
  <tr>
     <td class="izq-color">{$campo4}</td><td class="der-color">
       <input type="text" name="nombre" {$vmodo} value='{$nombre}' size="70" maxlength="100">
       &nbsp;&nbsp;{$campo5}&nbsp;&nbsp;&nbsp;
       <input type="text" name="vclase" {$vmodo} value='{$vclase}' size="1" maxlength="2" > -
       <input type="text" name="indclase" {$vmodo} value='{$indclase}' size="15" maxlength="15" >
     </td>
  </tr>

  <tr>
     <td class="izq-color">{$lcomentario}</td><td class="der-color">
       <textarea rows="2" name="comenta2" {$modo} cols="108" onchange="this.value=this.value.toUpperCase()"></textarea>
     </td>
  </tr>
  </tr>
  </table>	
  &nbsp;
  <table border="1" cellspacing="1">
  <tr>
    <tr>
      <td class="izq-color" >{$campo14}</td>
      <td class="der-color" colspan="3">
        <input type="text" name="evento" {$vmodo} value="54" size="2" maxlength="3" align="right">
        &nbsp;&nbsp;{$campo15}&nbsp;&nbsp;
        <input type="text" name="fevento3" {$modo} value='{$fevento3}' size="9">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {if $vopc eq 3 || $vopc eq 1}
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_azul.png',1);" src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" onclick="document.formarcas2.opcion.value='Detener'" />
        {else}
           <img src="../imagenes/boton_guardar_azul.png" alt="Save" align="middle" name="save" border="0" />
        {/if}
      </td>
    </tr>
  </tr>
  </table>
  &nbsp;
  </div>
  </div>

</form>
</div>  
  &nbsp;
  &nbsp;

</body>
</html>
