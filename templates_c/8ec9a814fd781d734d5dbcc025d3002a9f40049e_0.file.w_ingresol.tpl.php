<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:23:38
  from '\var\www\apl\sipi\templates\w_ingresol.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634eef2a359ae2_15940025',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8ec9a814fd781d734d5dbcc025d3002a9f40049e' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\w_ingresol.tpl',
      1 => 1429206818,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634eef2a359ae2_15940025 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php echo '<script'; ?>
 language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"><?php echo '</script'; ?>
>
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
<form name="wingresol" id="w_ingresol" action="w_ingresol.php?vopc=4" method="post">


  <input type='hidden' name='nconex' value='<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
'>

  <div align="center">

<table width="830" border="0" cellpadding="0" cellspacing="1" >

<tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>   <tr></tr> <tr></tr><tr></tr> <tr></tr><tr></tr> <tr></tr>
<tr>
<td>

  <table align="center" >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="vtramt" align="right" size="6" maxlength="6" >
        
 <?php }?>   

      </td>
             
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
       <td class="cnt">
         &nbsp;&nbsp;&nbsp;<input type="image" src="../imagenes/../imagenes/boton_buscar_azul.png" value="Buscar"></td>
       </form>
      <?php }?> 	
    </tr>
    </tr>

      </td>
  </table>
  
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <p></p><p></p><p></p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 5) {?>
 <fieldset>
      <input type ='hidden' name='vtramt' value=<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
> 
      <input type ='hidden' name='vsol' value=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
> 
      <input type ='hidden' name='vnumsol' value=<?php echo $_smarty_tpl->tpl_vars['vnumsol']->value;?>
> 
      <input type ='hidden' name='vcansol' value=<?php echo $_smarty_tpl->tpl_vars['vcansol']->value;?>
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

		<TD WIDTH=45<?php echo '%>';?>

			<UL>
			  <LI> <A HREF="../graficos/docutemp/poder/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Poder </A> 
			</UL>
		</TD>
		<TD WIDTH=5% align='center'>
			<input align='center' type="checkbox" name="recaud1" >		
		</TD>
		<TD WIDTH=46<?php echo '%>';?>

			<UL>
				<LI> <A HREF="../graficos/docutemp/asamblea/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'>  Acta Ultima Asamblea  </A> 
			</UL>
		</TD>
		<TD WIDTH=4<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud2" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45<?php echo '%>';?>

			<UL>
				<LI> <A HREF="../graficos/docutemp/reglamento/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Reglamento de uso de Marca </A> 
			</UL>
		</TD>
		<TD WIDTH=5<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud3" >
		</TD>
		<TD WIDTH=46<?php echo '%>';?>

			<UL>
				<LI>  <A HREF="../graficos/docutemp/cedula/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Cedula de Identidad </A> 
			</UL>
		</TD>
		<TD WIDTH=4<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud4" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45<?php echo '%>';?>

			<UL>
				<LI> <A HREF="../graficos/docutemp/prioridad/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Documento(s) de Prioridad y  Certificado de Registro Extranjero</A> 
			</UL>
		</TD>
		<TD WIDTH=5<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud5" >
		</TD>
		<TD WIDTH=46<?php echo '%>';?>

			<UL>
				<LI> <A HREF="../graficos/docutemp/rif/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Rif </A> 
			</UL>
		</TD>
		<TD WIDTH=4<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud6" >
		</TD>
	</TR>
	<TR VALIGN=TOP>
		<TD WIDTH=45<?php echo '%>';?>

			<UL>
				<LI> <A HREF="../graficos/docutemp/mercantil/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Registro Mercantil </A> 
			</UL>
		</TD>
		<TD WIDTH=5<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud7" >
		</TD>
		<TD WIDTH=46<?php echo '%>';?>

			<UL>
				<LI> <A HREF="../graficos/docutemp/otros/<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
.pdf"   target='_blank'> Otros </A> 
			</UL>
		</TD>
		<TD WIDTH=4<?php echo '%>';?>

			<input align='center' type="checkbox" name="recaud8" >
		</TD>
	</TR>
	
</TABLE>

<?php }?>
    
  </h5>
  <br>
   <table width="180" align="center" >
   
    <tr>
   
      <td>
  
       <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 5) {?>
        
         <form name="wingresol" id="w_ingresol" action="w_ingresol.php?vopc=6" method="post">
               <input type ='hidden' name='vtramt' value=<?php echo $_smarty_tpl->tpl_vars['vtramt']->value;?>
> 
               <input type ='hidden' name='vsol' value=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
> 
	   <input type="image" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" src="../imagenes/folder_add_f2.png" alt="Save" align="middle" name="save" border="0" "/>&nbsp;Ingresar&nbsp;&nbsp;
 
          <a><img src="../imagenes/folder_add.png" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('save','','../imagenes/folder_add_f2.png',1);" alt="Save" align="middle" name="save" border="0" />Ingresar</a>

        </form>
      </td>
      <?php }?>      
      <td>
	    <a href="w_ingresol.php?vopc=3" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_azul.png',1);">
	    <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a> 
      </td>      
      <td >
 	    <a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
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
<?php }
}
