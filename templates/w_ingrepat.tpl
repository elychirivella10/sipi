<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

{if $vopc eq 3 }
<form name="wingresol" id="w_ingresol" action="w_ingrepat.php?vopc=4" method="post">


  <input type='hidden' name='nconex' value='{$n_conex}'>

  <div align="center">

<table width="830" border="0" cellpadding="0" cellspacing="1" >

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
<tr>
<td>

  <table align="center" >
  <tr>
    <tr>
      <td class="izq-color" >{$campo1}</td>
      <td class="der-color">
        <input type="text" name="vtramt" align="right" size="6" maxlength="6" >
        
 {/if}   

      </td>
             
      {if $vopc eq 3}
       <td class="cnt">
         &nbsp;&nbsp;&nbsp;<input type="image" src="../imagenes/../imagenes/boton_buscar_azul.png" value="Buscar"></td>
       </form>
      {/if} 	
    </tr>
    </tr>

      </td>
  </table>
  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <p></p><p></p><p></p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 {if $vopc eq 5 }
 <fieldset>
      <input type ='hidden' name='vtramt' value={$vtramt}> 
      <input type ='hidden' name='vsol' value={$vsol}> 
      <input type ='hidden' name='vnumsol' value={$vnumsol}> 
      <input type ='hidden' name='vcansol' value={$vcansol}> 
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

{/if}
    
  </h5>
  <br>
   <table width="180" align="center" >
   
    <tr>
   
      <td>
  
       {if $vopc eq 5}
        
         <form name="wingresol" id="w_ingresol" action="w_ingrepat.php?vopc=6" method="post">
               <input type ='hidden' name='vtramt' value={$vtramt}> 
               <input type ='hidden' name='vsol' value={$vsol}> 
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="middle" name="save" border="0" "/>&nbsp;Ingresar&nbsp;&nbsp;
 
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar</a>

        </form>
      </td>
      {/if}      
      <td>
	    <a href="w_ingrepat.php?vopc=3" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	    <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a> 
      </td>      
      <td >
 	    <a href="../salir.php?nconex={$n_conex}" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_azul.png',1);">
	    <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>     
      </td>
    </tr>
  </table>

  </table>
  <br><br><br><br><br><br><br><br><br><br><br><br>
  </div>  

</body>
</html>
