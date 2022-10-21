<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:26:09
  from '\var\www\apl\sipi\templates\p_amcesion.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d74118a8c41_54177832',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '78dd7089a232f87ed84b24e0d126459a7a72d032' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_amcesion.tpl',
      1 => 1301066786,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d74118a8c41_54177832 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_radios.php','function'=>'smarty_function_html_radios',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">
  
  <!-- <H3><?php echo $_smarty_tpl->tpl_vars['subtitulo']->value;?>
</H3> -->
  
  <div align="center">
  <form name="formarcas1" action="p_amcesion.php?vopc=1" method="post">
     <table>
     <tr><td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['lsolicitud']->value;?>
</td>
         <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	     value='<?php echo $_smarty_tpl->tpl_vars['solicitud1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" 
             onchange="Rellena(document.formarcas1.vsol1,4)">-
	                       <input type="text" name="vsol2" size="6" maxlength="6" 
	     value='<?php echo $_smarty_tpl->tpl_vars['solicitud2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,6,document.formarcas1.submit)" 
             onchange="Rellena(document.formarcas1.vsol2,6)">
	 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" 
             height="24" value="Buscar">  Buscar  </td>
  </form>				  
  <form name="formarcas2" action="p_amcesion.php?vopc=2" method="post">
         <td><?php echo $_smarty_tpl->tpl_vars['espacios']->value;?>
</td>
	 <td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['lregistro']->value;?>
 </td>
	 <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	     value='<?php echo $_smarty_tpl->tpl_vars['registro1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,6, this)" 
             onkeyup="checkLength(event,this,1,document.formarcas2.vreg2)"
	     onChange="this.value=this.value.toUpperCase()">-
		               <input type="text" name="vreg2" size="6" maxlength="6" 
	     value='<?php echo $_smarty_tpl->tpl_vars['registro2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" 
             onkeyup="checkLength(event,this,6,document.formarcas2.submit)" 
             onchange="Rellena(document.formarcas2.vreg2,6)">
	 <td class="cnt"><input type='image' src="../imagenes/search_f2.png" width="28" 
             height="24" value="Buscar">  Buscar  </td>
     </tr>
     </table>  
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lfecsol']->value;?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecsol" value='<?php echo $_smarty_tpl->tpl_vars['vfecsol']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lfecreg']->value;?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecreg" value='<?php echo $_smarty_tpl->tpl_vars['vfecreg']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lfecven']->value;?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfecven" value='<?php echo $_smarty_tpl->tpl_vars['vfecven']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lnombre']->value;?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vnom" value='<?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>   </td></tr>
	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lclase']->value;?>
</td>
	    <td class="der-color"><input size="2" type="text" name="vest" value='<?php echo $_smarty_tpl->tpl_vars['vest']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>
	                <input size="67" type="text" name="vdesest" value='<?php echo $_smarty_tpl->tpl_vars['vdesest']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td></tr>

	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['ltrage']->value;?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vtrage" 
	    value="<?php echo preg_replace('!\s+!u', ' ',$_smarty_tpl->tpl_vars['vtra']->value);
echo $_smarty_tpl->tpl_vars['vcodage']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['vnomage']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
></td></tr>    
     </table>		
     <br />
     <!-- Titulares Actuales -->
     <table width="90%"> 
     <tr><td class="izq2-color"><?php echo $_smarty_tpl->tpl_vars['ltitular']->value;?>
</td></tr>
     <tr><td class="izq2-color">
     <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
             src='exampletit.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&ptip=I&pder=<?php echo $_smarty_tpl->tpl_vars['vderh']->value;?>
'></iframe> 
     </td></tr>  
     </table>		
     </form>
     <form name="formarcas3" action="p_amcesion.php?vopc=3" method="post" onsubmit='return pregunta();'>
     <input type="hidden" name="vest" value='<?php echo $_smarty_tpl->tpl_vars['vest']->value;?>
'>
     <input type="hidden" name="vcodtit" value='<?php echo $_smarty_tpl->tpl_vars['vcodtit']->value;?>
'>
     <input type="hidden" name="vnomtit" value='<?php echo $_smarty_tpl->tpl_vars['vnomtit']->value;?>
'>
     <input type="hidden" name="vnactit" value='<?php echo $_smarty_tpl->tpl_vars['vnactit']->value;?>
'>
     <input type="hidden" name="vdomtit" value='<?php echo $_smarty_tpl->tpl_vars['vdomtit']->value;?>
'>
     <input type="hidden" name="vcodage" value='<?php echo $_smarty_tpl->tpl_vars['vcodage']->value;?>
'>
     <input type="hidden" name="vnomage" value='<?php echo $_smarty_tpl->tpl_vars['vnomage']->value;?>
'>
     <input type="hidden" name="vtra" value='<?php echo $_smarty_tpl->tpl_vars['vtra']->value;?>
'>
     <table width="90%">
        <tr><td width="25%" class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lfechaevento']->value;?>
</td>
	    <td class="der-color"><input size="9" type="text" name="vfevh"  onkeyup="checkLength(event,this,10,document.formarcas3.vdoc)"
	    onchange="valFecha(this,document.formarcas3.vdoc)"><td></tr>  
	    <tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['ldocumento']->value;?>
</td>
	    <td class="der-color"><input size="7" type="text" name="vdoc" value='<?php echo $_smarty_tpl->tpl_vars['vdoc']->value;?>
' maxlength="9" onKeyPress="return acceptChar(event,2,this)" onkeyup="checkLength(event,this,7,document.formarcas3.vtipo)"></td></tr>
        <tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['ltipo']->value;?>
</td>
	    <td class="der-color">
	        <?php echo smarty_function_html_radios(array('name'=>"vtipo",'values'=>$_smarty_tpl->tpl_vars['vtipo_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vtipo']->value,'output'=>$_smarty_tpl->tpl_vars['vtipo_de']->value,'separator'=>''),$_smarty_tpl);?>

	</td></tr>
        </table>
     <!-- Titulares Finales--> 
     <table width="90%">
     <tr><td class="izq2-color"><?php echo $_smarty_tpl->tpl_vars['ltitular2']->value;?>
</td></tr>
     <tr><td class="izq2-color">
     <iframe id='center' style='width:100%;height:111px;background-color: WHITE;' 
             src='exampletit.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&ptip=P'></iframe> 
     </td></tr>  
     <table width="90%">	
     <tr><td class="der-color">
     <input type="text" name="vtitut" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="35" 
             onChange="javascript:this.value=this.value.toUpperCase();">
     <input type="button" value="Buscar/Incluir" class="boton_blue" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 name="vtitui" 
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitui)">
     <input type="button" value="Buscar/Eliminar" class="boton_blue" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 name="vtitue"          
             onclick="browsetitularp(document.formarcas1.vsol1,document.formarcas1.vsol2,document.formarcas3.vtitut,document.formarcas3.vtitue)"> 
     <!--  -->
     </td></tr>	
     </table>
        <table width="90%">
	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lagenew']->value;?>
</td>
	    <td class="der-color"><input size="6" type="text" name="vcodagen" maxlength="6" onchange="valagente(document.formarcas3.vcodagen,document.formarcas3.vnomagen)">	    
	    <select size=1 name="vnomagen" onchange= "this.form.vcodagen.value=this.options[this.selectedIndex].value">
	        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vcodagenew']->value,'output'=>$_smarty_tpl->tpl_vars['vnomagenew']->value),$_smarty_tpl);?>

	    </select></td>
	    </tr>        
        <tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['ltranew']->value;?>
</td>
	    <td class="der-color"><input size="73" type="text" name="vtranew"  onchange="this.value=this.value.toUpperCase()"></td></tr>      
	<tr><td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['lcomenta']->value;?>
</td>
	    <td class="der-color"><textarea rows="2" name="vcomenta" cols="73" onchange="this.value=this.value.toUpperCase()"></textarea></td></tr>
      </table>
     &nbsp;
           <input type="hidden" name="vsolh" value='<?php echo $_smarty_tpl->tpl_vars['solicitud1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['solicitud2']->value;?>
'>
           <input type="hidden" name="vderh" value='<?php echo $_smarty_tpl->tpl_vars['vderh']->value;?>
'>  
           <input type="hidden" name="vregh" value='<?php echo $_smarty_tpl->tpl_vars['registro1']->value;
echo $_smarty_tpl->tpl_vars['registro2']->value;?>
'>

     <table width="225">
     <tr>
<!--        <td class="cnt"><a href="m_rptcronol.php?vsol1=<?php echo $_smarty_tpl->tpl_vars['solicitud1']->value;?>
&vsol2=<?php echo $_smarty_tpl->tpl_vars['solicitud2']->value;?>
&vreg1=<?php echo $_smarty_tpl->tpl_vars['registro1']->value;?>
&vreg2=<?php echo $_smarty_tpl->tpl_vars['registro2']->value;?>
"><input type="image" src="../imagenes/folder_f2.png"></a>Cronologia</td> -->
     <td class="cnt"><input type="image" src="../imagenes/database_save.png" value="Guardar"> Guardar </td> 
     <td class="cnt"><a href="p_amcesion.php"><img src="../imagenes/cancel_f2.png" border="0">
     </a>  Cancelar  </td>
     <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
     </a> Salir </td>
     </tr>
     </table>

    </form>
  </div>  
  </body>
</html>


<?php }
}
