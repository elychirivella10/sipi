<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.{$varfocus}.focus()" >

  <div align="center">
 <fieldset>
      <input type ='hidden' name='varsol' value={$varsol}> 
      <input type ='hidden' name='clase' value={$clase}> 
      <input type ='hidden' name='nombre' value={$nombre}> 
      <input type ='hidden' name='varsol1' value={$varsol1}> 
      <input type ='hidden' name='varsol2' value={$varsol2}>      
      <input type ='hidden' name='vopc' value={$vopc}>    

<TABLE WIDTH=100%  BORDER=0 BORDERCOLOR="#000000" CELLPADDING=1 CELLSPACING=0>
<tr><td WIDTH=15%><font class='nota3'><b>Expediente No.:</font></b></td><td WIDTH=70%><font class='nota3'><b>{$varsol1}-{$varsol2}</b></font></td>
  {if $modalidad<>'DENOMINATIVO'}
  <td WIDTH=15% rowspan='5'><img width='90' heigth='80' src="../graficos/marcas/ef{$varsol1}/{$varsol1}{$varsol2}.jpg"></td>
  {/if}
</tr>
<tr><td WIDTH=15%><b>Nombre:</b></td><td>{$nombre}</td></tr> 
<tr><td><b>Clase:</b></td>    <td><b>{$clase}</b>-INTERNACIONAL</td></tr>
<tr><td><b>Estatus:</b></td>  <td><b>{$estatus-1000}</b>-{$des_estatus}</td></tr>
<tr><td><b>Tipo Signo:</b></td><td>{$modalidad}</td></tr>
</table>    
<BR>
<TABLE WIDTH=100%  CLASS="CELDA6" BORDER=1 BORDERCOLOR="#000000" CELLPADDING=2 CELLSPACING=0>
	<COL WIDTH=115*>
	<COL WIDTH=117*>
	<TR VALIGN=TOP>
		<TD WIDTH=45%  > 
                {if $fplanilla==1}
			<img src="../imagenes/accept.png" border="0">
                        <A HREF=  "../documentos/planilla/pl{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Planilla de Solicitud</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Planilla de Solicitud
                {/if}
		</TD>
		<TD WIDTH=46%  >
                {if $freglamento==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/reglamento/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Reglamento de Uso de Marca </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Reglamento de Uso de Marca
                {/if}
		</TD>
	</TR>		
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $ffonetica==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/fonetica/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'>  
                        B&uacute;squeda Fon&eacute;tica  </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Fon&eacute;tica 
                {/if}
		</TD>
		<TD WIDTH=46%>
                {if $fasamblea==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/asamblea/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Acta Ultima Asamblea  </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Acta Ultima Asamblea
                {/if}
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $fgrafica==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/grafica/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"    target='_blank'> 
                        B&uacute;squeda Gr&aacute;fica </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Gr&aacute;fica 
                {/if}
		</TD>
		<TD WIDTH=46%>
                {if $fprioridad==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/prioridad/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Documento(s) de Prioridad Extranjera</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Documento(s) de Prioridad Extranjera
                {/if}
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $fcedula==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/cedula/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        C&eacute;dula de Identidad </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        C&eacute;dula de Identidad
                {/if}
		</TD>
		<TD WIDTH=46%>
                {if $fescritos==1}
                        <img src="../imagenes/accept.png" border="0">
                        <a  href="m_rptexp_escritos.php?varsol={$varsol}" target='_blank'>Escritos</A>
                   <!-- <A HREF="../documentos/escritos/marcas/ef{$varsol1}/{$varsol1}{$varsol2}.pdf" target='_blank'> 
                        Escritos</A>  -->
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Escritos
                {/if}
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $frif==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/rif/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        R.I.F. (Registro Informaci&oacute;n Fiscal)</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        R.I.F. (Registro Informaci&oacute;n Fiscal)
                {/if}
		</TD>
		<TD WIDTH=46%>
                {if $fcertificado==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/certificado/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Certificado de Registro</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Certificado de Registro
                {/if}
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $fpoder==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/poder/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"    target='_blank'> 
                        Poder </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Poder
                {/if}
                </TD>
		<TD WIDTH=46%>
                {if $ftasa==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/tasa/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Comprobante Pago de Tasa</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Comprobante Pago de Tasa
                {/if}
		</TD>
	</TR>
        <TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $fmercantil==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/mercantil/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'> 
                        Registro Mercantil </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Registro Mercantil
                {/if}
                </TD>
		<!-- <TD WIDTH=46%>
                {if $fotros==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/otros/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'> 
                        Otros</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Otros
                {/if}
		</TD> -->
                <TD WIDTH=46%>
                {if $fpub_prensa32==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="{$name32}"  target='_blank'> 
                        Pub.Prensa Extemporaneo (Evento 32)</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Pub.Prensa Extemporaneo (Evento 32)
                {/if}
		</TD>
	</TR>
        <TR VALIGN=TOP>
		<TD WIDTH=45%>
                {if $fpub_prensa22==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="{$name22}"  target='_blank'> 
                        Publicaci&oacute;n en Prensa (Evento 22)</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Publicaci&oacute;n en Prensa (Evento 22)
                {/if}
                </TD>
                <TD WIDTH=46%>
                {if $fpub_prensa33==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="{$name33}"  target='_blank'> 
                        Pub.Prensa Defectuoso (Evento 33)</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Pub.Prensa Defectuoso (Evento 33)
                {/if}
		</TD>
	</TR>
</TABLE>

<P><BR><BR>
</P>

   <table width="350">
    <tr>
      
      <td class="cnt"><a  href="m_rptexp.php?varsol={$varsol}"><img src="../imagenes/boton_verexpediente_azul.png" border="0"></a></td>

    <td class="cnt"><a  href="../marcas/m_rptcronol.php?vsol1={$varsol1}&vsol2={$varsol2}" target="blank">
  <img src="../imagenes/boton_cronologia_rojo.png" alt="Cronologia" align="middle" name="cronologia" border="0"/></a></td>  
      
      <td class="cnt"><a href="m_rptpexp.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" alt="Cancelar" align="middle" name="cancelar" border="0"/></a></td>

      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0"/></a></td>
    </tr>

  </table>

  </div>  


</body>
</html>



