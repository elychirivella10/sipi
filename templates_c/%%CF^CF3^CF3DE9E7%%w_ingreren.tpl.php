<?php /* Smarty version 2.6.8, created on 2020-10-19 15:49:56
         compiled from w_ingreren.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<?php if ($this->_tpl_vars['vopc'] == 3): ?>
<form name="wingresol" id="w_ingreren" action="w_ingreren.php?vopc=4" method="post">


  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>

  <div align="center">

<table width="830" border="0" cellpadding="0" cellspacing="1" >

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
<tr>
<td>

  <table align="center" >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
        <input type="text" name="vtramt" align="right" size="6" maxlength="6" >
        
 <?php endif; ?>   

      </td>
             
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
       <td class="cnt">
         &nbsp;&nbsp;&nbsp;<input type="image" src="../imagenes/../imagenes/boton_buscar_azul.png" value="Buscar"></td>
       </form>
      <?php endif; ?> 	
    </tr>
    </tr>

      </td>
  </table>
  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <p></p><p></p><p></p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 <?php if ($this->_tpl_vars['vopc'] == 5): ?>
 <fieldset>
      <input type ='hidden' name='vtramt' value=<?php echo $this->_tpl_vars['vtramt']; ?>
> 
      <input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
> 
      <input type ='hidden' name='vnumsol' value=<?php echo $this->_tpl_vars['vnumsol']; ?>
> 
      <input type ='hidden' name='vcansol' value=<?php echo $this->_tpl_vars['vcansol']; ?>
> 
  <h5>
    <legend align='center'><strong><span class="Estilo3">Recaudos Anexos a la Solicitud</span><br />
    </strong></legend>
<TABLE WIDTH=100% BORDER=1 BORDERCOLOR="#000000" CELLPADDING=3 CELLSPACING=0>
	<COL WIDTH=115*>
	<COL WIDTH=13*>
	<COL WIDTH=117*>
	<COL WIDTH=11*>
	<TR VALIGN=TOP>

		<TD WIDTH=45%>
			<UL>
			  <LI> <A HREF="../graficos/docutemp/poder/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Poder </A> 
			</UL>
		</TD>
		<TD WIDTH=5% align='center'>
			<input align='center' type="checkbox" name="recaud1" >		
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/asamblea/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'>  Acta Ultima Asamblea  </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud2" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/reglamento/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Reglamento de uso de Marca </A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud3" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI>  <A HREF="../graficos/docutemp/cedula/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Cedula de Identidad </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud4" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/prioridad/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Documento(s) de Prioridad y  Certificado de Registro Extranjero</A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud5" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/rif/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Rif </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud6" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/mercantil/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Registro Mercantil </A> 
			</UL>
		</TD>
		<TD WIDTH=5%>
			<input align='center' type="checkbox" name="recaud7" >
		</TD>
		<TD WIDTH=46%>
			<UL>
				<LI> <A HREF="../graficos/docutemp/otros/<?php echo $this->_tpl_vars['vtramt']; ?>
.pdf"   target='_blank'> Otros </A> 
			</UL>
		</TD>
		<TD WIDTH=4%>
			<input align='center' type="checkbox" name="recaud8" >
		</TD>
	</TR>
	
</TABLE>

<?php endif; ?>
    
  </h5>
  <br>
   <table width="180" align="center" >
   
    <tr>
   
      <td>
  
       <?php if ($this->_tpl_vars['vopc'] == 5): ?>
        
         <form name="wingresol" id="w_ingreren" action="w_ingreren.php?vopc=6" method="post">
               <input type ='hidden' name='vtramt' value=<?php echo $this->_tpl_vars['vtramt']; ?>
> 
               <input type ='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
> 
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="middle" name="save" border="0" "/>&nbsp;Ingresar&nbsp;&nbsp;
 
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar</a>

        </form>
      </td>
      <?php endif; ?>      
      <td>
	    <a href="w_ingreren.php?vopc=3" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	    <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a> 
      </td>      
      <td >
 	    <a href="../salir.php?nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_azul.png',1);">
	    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>     
      </td>
    </tr>
  </table>

  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  

</body>
</html>