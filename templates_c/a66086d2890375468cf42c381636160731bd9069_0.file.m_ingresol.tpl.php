<?php
/* Smarty version 3.1.47, created on 2022-10-20 19:44:29
  from '\var\www\apl\sipi\templates\m_ingresol.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_635188fd5d8574_16737183',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a66086d2890375468cf42c381636160731bd9069' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_ingresol.tpl',
      1 => 1518627543,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_635188fd5d8574_16737183 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\modifier.truncate.php','function'=>'smarty_modifier_truncate',),));
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
<form name="formarcas1" action="m_ingresol.php?vopc=4" method="POST">
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
<form name="formarcas2" enctype="multipart/form-data" action="m_ingresol.php?vopc=2" method="POST" onsubmit='return pregunta();'>
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

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['fecha_solic']->value;?>
' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_marca)" onchange="valFecha(this,document.formarcas2.tipo_marca)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq3-color" ><?php echo $_smarty_tpl->tpl_vars['campo15']->value;?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_marca" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onchange="habilema(document.formarcas2.tipo_marca,document.formarcas2.vsol3,document.formarcas2.vsol4,document.formarcas2.vreg1d,document.formarcas2.vreg2d)" >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_marca']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>

      <!-- <td class="der-color" rowspan="9" valign="top">
        <input name="ubicacion" type="file" value='<?php echo $_smarty_tpl->tpl_vars['ubicacion']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 size="27" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $_smarty_tpl->tpl_vars['nameimage']->value;?>
' id="picture" width="270" height="264" alt="vista previa"/></br>
      </td> -->

      <td class="der-color" rowspan="9" valign="top">

        <table width="100%" cellspacing="1" border="1">
          <tr><td>
            <iframe id='top' style='width:100%;height:250px;background-color: WHITE;' src="../comun/z_verimagen.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
"></iframe> 
          </td></tr>  
        </table>
        <?php echo $_smarty_tpl->tpl_vars['campo23']->value;?>

        <input type="text" name="planilla" size="5" maxlength="6" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.buscarimg)">&nbsp;
        <input type="button" class="boton_blue" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 value="Buscar" name="buscarimg" onclick="buscarimagen(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.planilla)">
        <input type="button" class="boton_blue" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 value="Eliminar" name="eliminaimg" onclick="limpiarplan(document.formarcas2.planilla);limpiarimagen(document.formarcas2.vsol1,document.formarcas2.vsol2)"">
      </td>

    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo16']->value;?>
</td>
      <td class="der-color">
        <?php echo $_smarty_tpl->tpl_vars['campo21']->value;?>

        <input type="text" name="vsol3" size="4" maxlength="4" value='<?php echo $_smarty_tpl->tpl_vars['vsol3']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vsol4)" onchange="Rellena(document.formarcas2.vsol3,4)">-	
        <input type="text" name="vsol4" size="6" maxlength="6" value='<?php echo $_smarty_tpl->tpl_vars['vsol4']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.vreg1d)" onchange="Rellena(document.formarcas2.vsol4,6)">&nbsp;&nbsp; o 
        <?php echo $_smarty_tpl->tpl_vars['campo22']->value;?>

        <input type="text" name="vreg1d" size="1" maxlength="1" value='<?php echo $_smarty_tpl->tpl_vars['vreg1d']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.formarcas2.vreg2d)" onChange="this.value=this.value.toUpperCase()">-
        <input type="text" name="vreg2d" size="6" maxlength="6" value='<?php echo $_smarty_tpl->tpl_vars['vreg2d']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.formarcas2.nombre)" onchange="Rellena(document.formarcas2.vreg2d,6)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="52" maxlength="200" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="modalidad" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onchange="habilitar(document.formarcas2.modalidad,document.formarcas2.nombre,document.formarcas2.etiqueta,document.formarcas2.vviena,document.formarcas2.vvienai,document.formarcas2.vvienae,document.formarcas2.ubicacion)">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arrayvmodal']->value,'selected'=>$_smarty_tpl->tpl_vars['modalidad']->value,'output'=>$_smarty_tpl->tpl_vars['arraytmodal']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> 
    <tr>
      <td class="izq-color" ><b><?php echo $_smarty_tpl->tpl_vars['campo9']->value;?>
</b></td>
      <td class="der-color">
         <textarea rows="6" name="etiqueta" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="52" maxlength="6000" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['etiqueta']->value;?>
</textarea>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo5']->value;?>
</td>
      <td class="der-color">
       <?php if ($_smarty_tpl->tpl_vars['accion']->value == 2) {?>
        <select size="1" name="options" <?php echo $_smarty_tpl->tpl_vars['modo3']->value;?>
  onchange="this.form.distingue.value=this.options[this.selectedIndex].value">
        <!-- <select size="1" name="options" <?php echo $_smarty_tpl->tpl_vars['modo3']->value;?>
 > -->
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vnomclase']->value,'output'=>smarty_modifier_truncate($_smarty_tpl->tpl_vars['vnomclase']->value,56)),$_smarty_tpl);?>

        </select>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['accion']->value != 2) {?>
          <input type="text" name="vclase" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vclase']->value;?>
' size="1" maxlength="2" >
        <?php }?>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo20']->value;?>
</td>
      <td class="der-color">
        <input type="text" name="vclnac" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vclnac']->value;?>
' size="1" maxlength="2" >
        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['campo21']->value;?>
&nbsp;&nbsp;
        <input type="text" name="planilla" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['planilla']->value;?>
' size="5" maxlength="6" > -->
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><b><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</b></td>
      <td class="der-color" colspan="2">
         <textarea rows="8" name="distingue" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="96" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['distingue']->value;?>
</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='VE' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">-
<!--        <select size="1" name="pais" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraycodpais']->value,'selected'=>$_smarty_tpl->tpl_vars['pais_resid']->value,'output'=>$_smarty_tpl->tpl_vars['arraynompais']->value),$_smarty_tpl);?>

        </select>
     </td>
    </tr>  -->
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo13']->value;?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['tramitante']->value;?>
' size="50" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
        &nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['campo11']->value;?>
&nbsp;
        <input type="text" name="vpod1" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vpod1']->value;?>
' align="left" size="4" maxlength="4" onchange="Rellena(document.formarcas.vpod1,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.vpod2)"> -
        <input type="text" name="vpod2" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vpod2']->value;?>
' align="left" size="4" maxlength="5" onchange="Rellena(document.formarcas2.vpod2,4)" onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.formarcas2.tramitante)">
      </td>
    </tr> 
    <tr>
      <td class="izq-color"></td>
      <td class="der-color" colspan="2"></td>
    </tr>
    <tr>
    </tr>
      
  </tr>
  </table></center>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo12']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=M&tper=1"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vagent" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="35" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vageni" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vageni)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vagene" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseagentep(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vagent,document.formarcas2.vagene)"> 
        <br>
    </td></tr> 
    </table>
  
    &nbsp;
    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo10']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=M"></iframe> 
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
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo17']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=M"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vprior" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();" onKeyPress="return acceptChar(event,12, this)">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vpriori" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriori)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vpriore" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseprioridp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vprior,document.formarcas2.vpriore)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

    <table width="960px" cellspacing="1" border="1">
    <tr><td class="izq4-color" colspan="2"><?php echo $_smarty_tpl->tpl_vars['campo14']->value;?>
</td></tr>
    <tr><td>    
    <iframe id='top' style='width:960px;height:90px;background-color: WHITE;' src="m_verccv.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
"></iframe> 
    </td></tr>
    <tr><td class="der-color">
        <input type="text" name="vviena" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="11" onkeyup="this.value=this.value.toUpperCase()">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vvienai" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienai)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vvienae" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="gestionvienap(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vviena,document.formarcas2.vvienae)">
    </td></tr>
    </table>
    &nbsp;

  <!-- <table align="center">
  <tr>
    <td class="cnt">
      <input type="submit" value=" GUARDAR " class="boton_azul"></td>
    <td class="cnt">
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><input type="button" value=" CANCELAR " class="boton_rojo"></a>
      <?php }?>    
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3 || $_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><input type="button" value=" CANCELAR " class="boton_rojo"></a>
      <?php }?>    
    </td>      
    <td class="cnt">
      <a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><input type="button" value=" SALIR " class="boton_azul"></td></a>
    </td>
  </tr>
  </table>-->

  <table width="180">
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php }?>    
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3 || $_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
         <a href="m_ingresol.php?vopc=3&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
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
