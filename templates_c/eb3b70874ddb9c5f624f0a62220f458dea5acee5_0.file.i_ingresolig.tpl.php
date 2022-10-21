<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:20:22
  from '\var\www\apl\sipi\templates\i_ingresolig.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d72b6cf77c5_91295346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb3b70874ddb9c5f624f0a62220f458dea5acee5' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\i_ingresolig.tpl',
      1 => 1620586541,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d72b6cf77c5_91295346 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php echo '<script'; ?>
 language="javascript" src="../include/cal2.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 language="javascript" src="../include/cal_conf2.js"><?php echo '</script'; ?>
>
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<div align="center">

<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
<form name="formarcas1" action="i_ingresolig.php?vopc=4" method="POST">
<?php }?>
  <input type='hidden' name='conx' value='<?php echo $_smarty_tpl->tpl_vars['conx']->value;?>
'>  
  <input type='hidden' name='salir' value='<?php echo $_smarty_tpl->tpl_vars['salir']->value;?>
'>

  <table>
  <tr> 
    <tr>
      <td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="vsol1" size="4" maxlength="4" value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas1.vsol2)" onchange="Rellena(document.formarcas1.vsol1,4)" onBlur="valagente(document.formarcas1.vsol1,document.formarcas2.vsol1a)">-
        <input type="text" name="vsol2" size="6" maxlength="6" value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas1.submit)" onchange="Rellena(document.formarcas1.vsol2,6)" onBlur="valagente(document.formarcas1.vsol2,document.formarcas2.vsol2a)">
        </td>	
      <td class="cnt">
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
        <!-- &nbsp;<input type="submit" value=" Nueva Solicitud " class="boton_blue"> -->
        &nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </form>
      <?php }?> 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="i_ingresolig.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type='hidden' name='usuario' value=<?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
>
  <input type='hidden' name='dirano' value=<?php echo $_smarty_tpl->tpl_vars['dirano']->value;?>
>
  <input type='hidden' name='vsol1' value=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
>
  <input type='hidden' name='vsol2' value=<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
>
  <input type='hidden' name='vsol1a' value=<?php echo $_smarty_tpl->tpl_vars['vsol1a']->value;?>
>
  <input type='hidden' name='vsol2a' value=<?php echo $_smarty_tpl->tpl_vars['vsol2a']->value;?>
>
  <input type='hidden' name='vstring' value='<?php echo $_smarty_tpl->tpl_vars['vstring']->value;?>
'>
  <input type='hidden' name='vstring1' value='<?php echo $_smarty_tpl->tpl_vars['vstring1']->value;?>
'>
  <input type='hidden' name='vstring2' value='<?php echo $_smarty_tpl->tpl_vars['vstring2']->value;?>
'>
  <input type='hidden' name='campos' value='<?php echo $_smarty_tpl->tpl_vars['campos']->value;?>
'>
  <input type='hidden' name='modo' value=<?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>
  <input type='hidden' name='accion' value=<?php echo $_smarty_tpl->tpl_vars['accion']->value;?>
>
  <input type='hidden' name='auxnum' value=<?php echo $_smarty_tpl->tpl_vars['auxnum']->value;?>
>
  <input type='hidden' name='vclase' value=<?php echo $_smarty_tpl->tpl_vars['vclase']->value;?>
>
  <input type='hidden' name='varsol' value=<?php echo $_smarty_tpl->tpl_vars['varsol']->value;?>
>
  <input type='hidden' name='vcodpais' value=<?php echo $_smarty_tpl->tpl_vars['vcodpais']->value;?>
>
  <input type='hidden' name='vcodage' value=<?php echo $_smarty_tpl->tpl_vars['vcodage']->value;?>
>
  <input type='hidden' name='psoli' value=<?php echo $_smarty_tpl->tpl_vars['psoli']->value;?>
>
  <input type='hidden' name='nameimage' value=<?php echo $_smarty_tpl->tpl_vars['nameimage']->value;?>
>
  <input type='hidden' name='conx' value='<?php echo $_smarty_tpl->tpl_vars['conx']->value;?>
'>  
  <input type='hidden' name='salir' value='<?php echo $_smarty_tpl->tpl_vars['salir']->value;?>
'>

  <table width="970px" cellspacing="1" border="1">
    <tr>
      <td class="izq-color" >Fecha de la Solicitud:</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
  size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
    </tr>
    <tr>
      <td class="izq-color" >Tipo de Solicitud:</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
>
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_marca']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>   
  </table>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">1.- DATOS DEL SOLICITANTE:</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=I"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitui)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browsetitularp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut,document.formarcas2.vtitue)"> 
        <br>
    </td></tr> 
    </table>

    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color">2.- DATOS DEL REPRESENTANTE LEGAL:</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_verrepre.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=I"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vtitut2" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vtitui2" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browserepre(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut2,document.formarcas2.vtitui2)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vtitue2" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browserepre(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vtitut2,document.formarcas2.vtitue2)"> 
        <br>
    </td></tr> 
    </table>

    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">3.- DATOS DEL APODERADO:</td></tr>
    <tr>                        
      <td class="izq-color" >Poder:</td>
      <td class="der-color">
        <input type="text" name="vpod1" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vpod1']->value;?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vpod2']->value;?>
' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr>
    <tr><td colspan="2">
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=I&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color" colspan="2">
        <input type="text" name="vagent" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    <tr>
      <td class="izq-color" >Tramitante:</td>
      <td class="der-color">
        <input type="text" name="tramitante" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['tramitante']->value;?>
' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
      </td>
    </tr>
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">4.- INDICACION GEOGRAFICA (IG):</td></tr>
    <tr>
      <td class="izq-color" ><b>Nombre de la IG:</b></td>
      <td class="der-color">
         <textarea rows="2" name="nombreig" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="90" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['nombreig']->value;?>
</textarea>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><b>Productos designados por la IG:</b></td>
      <td class="der-color">
         <textarea rows="2" name="productosig" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="90" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['productosig']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">5.- ZONA GEOGRAFICA:</td></tr>
    <tr>
      <td class="izq-color" ><b>Definici&oacute;n de la Zona Geogr&aacute;fica:</b></td>
      <td class="der-color">
         <textarea rows="4" name="zonag" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="90"><?php echo $_smarty_tpl->tpl_vars['zonag']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;     
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">6.- REGISTRO DE IG/DO EXTRANJERO:</td></tr>
    <tr><td colspan="2">
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=I"></iframe> 
    </td></tr>  
    <tr><td colspan="2"class="der-color">
        <input type="text" name="vprior" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    <tr>
      <td class="izq-color" ><b>Tratado Internacional ratificado por Vzla:</b></td>
      <td class="der-color">
         <textarea rows="2" name="tratado" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="80"><?php echo $_smarty_tpl->tpl_vars['tratado']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">8.- DESCRIPCION DETALLADA DEL PRODUCTO DESIGNADO CON LA INDICACION GEOGRAFICA (IG):</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="distingue" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="115"><?php echo $_smarty_tpl->tpl_vars['distingue']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">9.- DESCRIPCION DE LA ZONA GEOGRAFICA:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="deszonag" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="115"><?php echo $_smarty_tpl->tpl_vars['deszonag']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">10.- VINCULO DEL PRODUCTO CON EL TERRITORIO:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="vinculo" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="115"><?php echo $_smarty_tpl->tpl_vars['vinculo']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
    <table width="970px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2">11.- OBSERVACIONES:</td></tr>
    <tr>
      <td class="der-color">
         <textarea rows="5" name="observa" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="115"><?php echo $_smarty_tpl->tpl_vars['observa']->value;?>
</textarea>
      </td>
    </tr> 
    </table>

    &nbsp;
  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
         <a href="i_ingresolig.php?vopc=3&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php }?>    
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3 || $_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
         <a href="i_ingresolig.php?vopc=3&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php }?>    
    </td>      
    <td class="cnt">
         <a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>




</form>
</div>  

</body>
</html>
<?php }
}
