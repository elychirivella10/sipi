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
	<TR VALIGN=TOP>
		<TD WIDTH=50%  > 
                {if $fplanilla==1}
			<img src="../imagenes/accept.png" border="0">
                        <A HREF=  "../documentos/planilla/pl{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Planilla de Solicitud</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Planilla de Solicitud
                {/if}
		</TD>
                <TD WIDTH=50%>
<form name='form1' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$planilla}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
        </TR>	
        <TR VALIGN=TOP> 
		<TD>
                {if $ffonetica==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/fonetica/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'>  
                        B&uacute;squeda Fon&eacute;tica  </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Fon&eacute;tica 
                {/if}
		</TD>
                <TD>
<form name='form2' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$fonetica}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
        </TR>
        <TR VALIGN=TOP>
		<TD>
                {if $fgrafica==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/grafica/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"    target='_blank'> 
                        B&uacute;squeda Gr&aacute;fica </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Gr&aacute;fica 
                {/if}
		</TD>
                <TD>
<form name='form3' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$grafica}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
        </TR>
	<TR VALIGN=TOP> 
		<TD>
                {if $fcedula==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/cedula/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        C&eacute;dula de Identidad </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        C&eacute;dula de Identidad
                {/if}
		</TD>
                <TD>
<form name='form4' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$cedula}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
        </TR>		
	<TR VALIGN=TOP> 
		<TD>
                {if $frif==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/rif/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Registro Informaci&oacute;n Fiscal</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Registro Informaci&oacute;n Fiscal
                {/if}
		</TD>
                <TD>
<form name='form5' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$rif}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
        </TR>
	<TR VALIGN=TOP> 
		<TD>
                {if $fpoder==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/poder/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"    target='_blank'> 
                        Poder </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Poder
                {/if}
                </TD>
                <TD>
<form name='form6' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$poder}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
        </TR>	
	<TR VALIGN=TOP> 
		<TD>
                {if $fmercantil==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/mercantil/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'> 
                        Registro Mercantil </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Registro Mercantil
                {/if}
		</TD>
                <TD>
<form name='form7' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$mercantil}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
        </td>
	</TR>			
	<TR VALIGN=TOP> 
		<TD>
                {if $freglamento==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/reglamento/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Reglamento de Uso de Marca </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Reglamento de Uso de Marca
                {/if}
		</TD>
                <TD>
<form name='form8' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$reglamento}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>		
	<TR VALIGN=TOP> 
		<TD>
                {if $fasamblea==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/asamblea/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Acta Ultima Asamblea  </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Acta Ultima Asamblea
                {/if}
		</TD>
                <TD>
<form name='form9' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$asamblea}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>
	<TR VALIGN=TOP> 
		<TD>
                {if $fprioridad==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/prioridad/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'> 
                        Documento(s) de Prioridad Extranjera</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Documento(s) de Prioridad Extranjera
                {/if}
		</TD>
                <TD>
<form name='form10' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$prioridad}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>
	<TR VALIGN=TOP>
		<TD>
                {if $fescritos==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/escritos/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Oficio de Devolucion</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Oficio de Devolucion
                {/if}
		</TD>
                <TD>
<form name='form11' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$escritos}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>
	<TR VALIGN=TOP>
		<TD>
                {if $fescritos==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/escritos/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Escritos</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Escritos
                {/if}
		</TD>
                <TD>
<form name='form11' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$escritos}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>	
	<TR VALIGN=TOP>
		<TD>
                {if $fcertificado==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/certificado/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'> 
                        Certificado de Registro</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Certificado de Registro
                {/if}
		</TD>
                <TD>
<form name='form12' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$certificado}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>		
	<TR VALIGN=TOP>
		<TD>
                {if $ftasa==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/tasa/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"   target='_blank'>  
                        Comprobante Pago de Tasa</A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Comprobante Pago de Tasa
                {/if}
		</TD>
                <TD>
<form name='form13' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$tasa}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>	
	<TR VALIGN=TOP>
		<TD>
                {if $fotros==1}
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/otros/ef{$varsol1}/{$varsol1}{$varsol2}.pdf"  target='_blank'> 
                        Otros </A>
                {else}
			<img src="../imagenes/bullet_delete.png" border="0">
                        Otros
                {/if}
		</TD>
                <TD>
<form name='form14' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol={$varsol}&vsub={$otros}" method="POST">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr><td width="60%"><input name="ubicacion" type="file" size="50" onchange="checkear(this);" ></td>
          <td><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar">
          </td>
      </tr> 
     </table>
</form>
                </TD>
	</TR>
</TABLE>

<P><BR><BR>
</P>

   <table width="350">
    <tr>
      
      <td class="cnt"><a  href="m_rptexp.php?varsol={$varsol}"><img src="../imagenes/folder_explore.png" border="0"></a>  Ver Expediente  </td>

    <td class="cnt"><a  href="../marcas/m_rptcronol.php?vsol1={$varsol1}&vsol2={$varsol2}" target="blank">
  <img src="../imagenes/boton_cronologia_rojo.png" alt="Cronologia" align="middle" name="cronologia" border="0"/></a></td>  
      
      <td class="cnt"><a href="m_rptpexp_esc.php?nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" alt="Cancelar" align="middle" name="cancelar" border="0"/></a></td>

      <td class="cnt"><a href="../salir.php?nconex={$n_conex}"><img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0"/></a></td>
    </tr>
  </table>

  </div>  


</body>
</html>


