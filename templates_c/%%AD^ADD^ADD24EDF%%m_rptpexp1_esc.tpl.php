<?php /* Smarty version 2.6.8, created on 2021-09-26 13:52:46
         compiled from m_rptpexp1_esc.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()" >

  <div align="center">
 <fieldset>
      <input type ='hidden' name='varsol' value=<?php echo $this->_tpl_vars['varsol']; ?>
> 
      <input type ='hidden' name='clase' value=<?php echo $this->_tpl_vars['clase']; ?>
> 
      <input type ='hidden' name='nombre' value=<?php echo $this->_tpl_vars['nombre']; ?>
> 
      <input type ='hidden' name='varsol1' value=<?php echo $this->_tpl_vars['varsol1']; ?>
> 
      <input type ='hidden' name='varsol2' value=<?php echo $this->_tpl_vars['varsol2']; ?>
>      
      <input type ='hidden' name='vopc' value=<?php echo $this->_tpl_vars['vopc']; ?>
>    

<TABLE WIDTH=100%  BORDER=0 BORDERCOLOR="#000000" CELLPADDING=1 CELLSPACING=0>
<tr><td WIDTH=15%><font class='nota3'><b>Expediente No.:</font></b></td><td WIDTH=70%><font class='nota3'><b><?php echo $this->_tpl_vars['varsol1']; ?>
-<?php echo $this->_tpl_vars['varsol2']; ?>
</b></font></td>
  <?php if ($this->_tpl_vars['modalidad'] <> 'DENOMINATIVO'): ?>
  <td WIDTH=15% rowspan='5'><img width='90' heigth='80' src="../graficos/marcas/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.jpg"></td>
  <?php endif; ?>
</tr>
<tr><td WIDTH=15%><b>Nombre:</b></td><td><?php echo $this->_tpl_vars['nombre']; ?>
</td></tr> 
<tr><td><b>Clase:</b></td>    <td><b><?php echo $this->_tpl_vars['clase']; ?>
</b>-INTERNACIONAL</td></tr>
<tr><td><b>Estatus:</b></td>  <td><b><?php echo $this->_tpl_vars['estatus']-1000; ?>
</b>-<?php echo $this->_tpl_vars['des_estatus']; ?>
</td></tr>
<tr><td><b>Tipo Signo:</b></td><td><?php echo $this->_tpl_vars['modalidad']; ?>
</td></tr>
</table>    
<BR>
<TABLE WIDTH=100%  CLASS="CELDA6" BORDER=1 BORDERCOLOR="#000000" CELLPADDING=2 CELLSPACING=0>
	<TR VALIGN=TOP>
		<TD WIDTH=50%  > 
                <?php if ($this->_tpl_vars['fplanilla'] == 1): ?>
			<img src="../imagenes/accept.png" border="0">
                        <A HREF=  "../documentos/planilla/pl<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Planilla de Solicitud</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Planilla de Solicitud
                <?php endif; ?>
		</TD>
                <TD WIDTH=50%>
<form name='form1' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['planilla']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['ffonetica'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/fonetica/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'>  
                        B&uacute;squeda Fon&eacute;tica  </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Fon&eacute;tica 
                <?php endif; ?>
		</TD>
                <TD>
<form name='form2' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['fonetica']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fgrafica'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/grafica/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"    target='_blank'> 
                        B&uacute;squeda Gr&aacute;fica </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        B&uacute;squeda Gr&aacute;fica 
                <?php endif; ?>
		</TD>
                <TD>
<form name='form3' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['grafica']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fcedula'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/cedula/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        C&eacute;dula de Identidad </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        C&eacute;dula de Identidad
                <?php endif; ?>
		</TD>
                <TD>
<form name='form4' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['cedula']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['frif'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/rif/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Registro Informaci&oacute;n Fiscal</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Registro Informaci&oacute;n Fiscal
                <?php endif; ?>
		</TD>
                <TD>
<form name='form5' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['rif']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fpoder'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/poder/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"    target='_blank'> 
                        Poder </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Poder
                <?php endif; ?>
                </TD>
                <TD>
<form name='form6' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['poder']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fmercantil'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/mercantil/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'> 
                        Registro Mercantil </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Registro Mercantil
                <?php endif; ?>
		</TD>
                <TD>
<form name='form7' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['mercantil']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['freglamento'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/reglamento/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Reglamento de Uso de Marca </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Reglamento de Uso de Marca
                <?php endif; ?>
		</TD>
                <TD>
<form name='form8' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['reglamento']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fasamblea'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/asamblea/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Acta Ultima Asamblea  </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Acta Ultima Asamblea
                <?php endif; ?>
		</TD>
                <TD>
<form name='form9' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['asamblea']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fprioridad'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/prioridad/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'> 
                        Documento(s) de Prioridad Extranjera</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Documento(s) de Prioridad Extranjera
                <?php endif; ?>
		</TD>
                <TD>
<form name='form10' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['prioridad']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fescritos'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/escritos/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Oficio de Devolucion</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Oficio de Devolucion
                <?php endif; ?>
		</TD>
                <TD>
<form name='form11' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['escritos']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fescritos'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/escritos/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Escritos</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Escritos
                <?php endif; ?>
		</TD>
                <TD>
<form name='form11' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['escritos']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fcertificado'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/certificado/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'> 
                        Certificado de Registro</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Certificado de Registro
                <?php endif; ?>
		</TD>
                <TD>
<form name='form12' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['certificado']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['ftasa'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/tasa/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"   target='_blank'>  
                        Comprobante Pago de Tasa</A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Comprobante Pago de Tasa
                <?php endif; ?>
		</TD>
                <TD>
<form name='form13' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['tasa']; ?>
" method="POST">
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
                <?php if ($this->_tpl_vars['fotros'] == 1): ?>
                        <img src="../imagenes/accept.png" border="0">
			<A HREF="../documentos/otros/ef<?php echo $this->_tpl_vars['varsol1']; ?>
/<?php echo $this->_tpl_vars['varsol1'];  echo $this->_tpl_vars['varsol2']; ?>
.pdf"  target='_blank'> 
                        Otros </A>
                <?php else: ?>
			<img src="../imagenes/bullet_delete.png" border="0">
                        Otros
                <?php endif; ?>
		</TD>
                <TD>
<form name='form14' enctype="multipart/form-data" action="z_enviodoc_esc.php?vopc=2&vsol=<?php echo $this->_tpl_vars['varsol']; ?>
&vsub=<?php echo $this->_tpl_vars['otros']; ?>
" method="POST">
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
      
      <td class="cnt"><a  href="m_rptexp.php?varsol=<?php echo $this->_tpl_vars['varsol']; ?>
"><img src="../imagenes/folder_explore.png" border="0"></a>  Ver Expediente  </td>

    <td class="cnt"><a  href="../marcas/m_rptcronol.php?vsol1=<?php echo $this->_tpl_vars['varsol1']; ?>
&vsol2=<?php echo $this->_tpl_vars['varsol2']; ?>
" target="blank">
  <img src="../imagenes/boton_cronologia_rojo.png" alt="Cronologia" align="middle" name="cronologia" border="0"/></a></td>  
      
      <td class="cnt"><a href="m_rptpexp_esc.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" alt="Cancelar" align="middle" name="cancelar" border="0"/></a></td>

      <td class="cnt"><a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
"><img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0"/></a></td>
    </tr>
  </table>

  </div>  


</body>
</html>

