<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:38:38
  from '\var\www\apl\sipi\templates\p_ingsol55.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d76fe936ce5_65662055',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fcf9094fe5726d2679d8c9103b31370c50190371' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\p_ingsol55.tpl',
      1 => 1518633005,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d76fe936ce5_65662055 (Smarty_Internal_Template $_smarty_tpl) {
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
<form name="formarcas1" action="p_ingsol55.php?vopc=4" method="POST">
<?php }?>
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
      &nbsp;<input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </form>
      <?php }?> 		  
      </td>
    </tr>
  </tr>
  </table>

&nbsp;	 	     
<form name="formarcas2" enctype="multipart/form-data" action="p_ingsol55.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value=<?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
>
  <input type ='hidden' name='dirano' value=<?php echo $_smarty_tpl->tpl_vars['dirano']->value;?>
>
  <input type ='hidden' name='vsol1' value=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
>
  <input type ='hidden' name='vsol2' value=<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
>
  <input type ='hidden' name='vsol1a' value=<?php echo $_smarty_tpl->tpl_vars['vsol1a']->value;?>
>
  <input type ='hidden' name='vsol2a' value=<?php echo $_smarty_tpl->tpl_vars['vsol2a']->value;?>
>
  <input type ='hidden' name='vstring' value='<?php echo $_smarty_tpl->tpl_vars['vstring']->value;?>
'>
  <input type ='hidden' name='vstring1' value='<?php echo $_smarty_tpl->tpl_vars['vstring1']->value;?>
'>
  <input type ='hidden' name='vstring2' value='<?php echo $_smarty_tpl->tpl_vars['vstring2']->value;?>
'>
  <input type ='hidden' name='campos' value='<?php echo $_smarty_tpl->tpl_vars['campos']->value;?>
'>
  <input type ='hidden' name='modo' value=<?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
>
  <input type ='hidden' name='accion' value=<?php echo $_smarty_tpl->tpl_vars['accion']->value;?>
>
  <input type ='hidden' name='auxnum' value=<?php echo $_smarty_tpl->tpl_vars['auxnum']->value;?>
>
  <input type ='hidden' name='varsol' value=<?php echo $_smarty_tpl->tpl_vars['varsol']->value;?>
>
  <input type ='hidden' name='vcodpais' value=<?php echo $_smarty_tpl->tpl_vars['vcodpais']->value;?>
>
  <input type ='hidden' name='vcodage' value=<?php echo $_smarty_tpl->tpl_vars['vcodage']->value;?>
>
  <input type ='hidden' name='psoli' value=<?php echo $_smarty_tpl->tpl_vars['psoli']->value;?>
>
  <input type ='hidden' name='nameimage' value=<?php echo $_smarty_tpl->tpl_vars['nameimage']->value;?>
>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color">
         <input type="text" name="fecha_solic" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['fecha_solic']->value;?>
' size="10" align="left" onkeyup="checkLength(event,this,10,document.formarcas2.tipo_paten)" onchange="valFecha(this,document.formarcas2.tipo_paten)" >
         &nbsp;&nbsp;
         <a href="javascript:showCal('Calendar7');"><img src="../imagenes/calendar2.gif" title="Haga Clic para Seleccionar la Fecha" align="middle" width="26" height="24" border="0"></a>
      </td>
      <td class="izq3-color" ><?php echo $_smarty_tpl->tpl_vars['campo5']->value;?>
</td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="tipo_paten" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraytipom']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_paten']->value,'output'=>$_smarty_tpl->tpl_vars['arraynotip']->value),$_smarty_tpl);?>

        </select>
      </td>
      <td class="der-color" rowspan="3" valign="top">
        <input name="ubicacion" type="file" value='<?php echo $_smarty_tpl->tpl_vars['ubicacion']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 size="20" onChange="javascript:document.formarcas2.picture.src = 'file:///'+ document.formarcas2.ubicacion.value;">
        <br><img src='<?php echo $_smarty_tpl->tpl_vars['nameimage']->value;?>
' id="picture" width="270" height="300" alt="vista previa"/></br>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color">
	     <textarea rows="2" name="nombre" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="57" maxlength="200" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
</textarea>
	   </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo8']->value;?>
</td>
      <td class="der-color" >
         <textarea rows="14" name="resumen" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 cols="57" maxlength="8000" onchange="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['resumen']->value;?>
</textarea>
      </td>
    </tr> 
<!--    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
      <td class="der-color" colspan="2"> -->
        <input type="hidden" name="input2" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='VE' size="1" maxlength="2" onKeyup="this.value=this.value.toUpperCase();checkLength(event,this,2,document.formarcas2.input1)" onchange="valagente(document.formarcas2.input2,document.formarcas2.pais)">
<!--        -<select size="1" name="pais" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onchange="this.form.input2.value=this.options[this.selectedIndex].value">
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraycodpais']->value,'selected'=>$_smarty_tpl->tpl_vars['pais_resid']->value,'output'=>$_smarty_tpl->tpl_vars['arraynompais']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr> -->

    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo13']->value;?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="tramitante" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['tramitante']->value;?>
' size="56" maxlength="100" onKeyUp="this.value=this.value.toUpperCase()" onchange="habil(document.formarcas2.tramitante,document.formarcas2.vpod1,document.formarcas2.vpod2,document.formarcas2.input1,document.formarcas2.vnomage)">
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
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo14']->value;?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="locarno1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['locarno1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.locarno2)">-
        <input type="text" name="locarno2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['locarno2']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.edicion)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo18']->value;?>
</td>
      <td class="der-color" colspan="2">
        <input type="text" name="anualidad" '<?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['anualidad']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.planilla)">
        &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['campo19']->value;?>
&nbsp;
        <input type="text" name="planilla" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['planilla']->value;?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.tasa)">
        &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['campo20']->value;?>
&nbsp;
        <input type="text" name="tasa" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['tasa']->value;?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.monto)">
        &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['campo21']->value;?>
&nbsp;
        <input type="text" name="monto" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['monto']->value;?>
' size="6" maxlength="6" onKeyup="checkLength(event,this,6,document.formarcas2.vagent)">
      </td>
    </tr>

    <tr>
    </tr>

  </tr>
  </table></center>

    &nbsp;
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo12']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_veragente.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=P&tper=1"></iframe> 
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
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo10']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:100px;background-color: WHITE;' src="../comun/z_vertitular.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=P"></iframe> 
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
    
    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo17']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="../comun/z_verpriorid.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
&pder=P"></iframe> 
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

    <table width="85%" cellspacing="1" border="1">
    <tr><td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td></tr>
    <tr><td>
    <iframe id='top' style='width:100%;height:90px;background-color: WHITE;' src="p_verinven.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
"></iframe> 
    </td></tr>  
    <tr><td class="der-color">
        <input type="text" name="vinv" <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="20" onChange="javascript:this.value=this.value.toUpperCase();">
        <input type="button" class="boton_blue" value="Buscar/Incluir"  name="vinvi" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseinventorp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.vinvi)">
        <input type="button" class="boton_blue" value="Buscar/Eliminar" name="vinve" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 onclick="browseinventorp(document.formarcas2.vsol1,document.formarcas2.vsol2,document.formarcas2.vinv,document.formarcas2.vinve)"> 
        <br>
    </td></tr> 
    </table>
    &nbsp;

    
  <table cellspacing="1" border="1">
	 <tr>
	 </tr>
	 <tr>
	 </tr>
	 <tr>
	 </tr>
    <tr>
    </tr>
    <tr>
      <td class="izq4-color"><?php echo $_smarty_tpl->tpl_vars['campo16']->value;?>
</td>
      <td class="der1-color">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clasificaci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo&nbsp;
      </td>
    </tr>
	 <tr>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        1.&nbsp;<input type="text" name="c1l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c1n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c1n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c1l2)">
          <input type="text" name="c1l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c1n2)" onChange="this.value=this.value.toUpperCase()" >
          <input type="text" name="c1n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c1n3)"> /
          <input type="text" name="c1n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c1n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t1)"> -
          <input type="text" name="t1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c2l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        2.&nbsp;<input type="text" name="c2l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,3,document.formarcas2.c2n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c2l2)">
          <input type="text" name="c2l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c2n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c2n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c2n3)"> /
          <input type="text" name="c2n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c2n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t2)"> -
          <input type="text" name="t2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        3.&nbsp;<input type="text" name="c3l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c3l2)">
          <input type="text" name="c3l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c3n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c3n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c3n3)"> /
          <input type="text" name="c3n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c3n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t3)"> -
          <input type="text" name="t3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t3']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        4.&nbsp;<input type="text" name="c4l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c4l2)">
          <input type="text" name="c4l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c4n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c4n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c4n3)"> /
          <input type="text" name="c4n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c4n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t4)"> -
          <input type="text" name="t4" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t4']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5l1)" onChange="this.value=this.value.toUpperCase()">&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        5.&nbsp;<input type="text" name="c5l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5n1)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c5l2)">
          <input type="text" name="c5l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c5n2)" onChange="this.value=this.value.toUpperCase()">
          <input type="text" name="c5n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c5n3)"> /
          <input type="text" name="c5n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c5n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t5)"> -
          <input type="text" name="t5" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t5']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6l1)" >&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        6.&nbsp;<input type="text" name="c6l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6n1)">
          <input type="text" name="c6n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c6l2)">
          <input type="text" name="c6l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c6n2)">
          <input type="text" name="c6n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c6n3)"> /
          <input type="text" name="c6n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c6n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t6)"> -
          <input type="text" name="t6" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t6']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        7.&nbsp;<input type="text" name="c7l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7n1)">
          <input type="text" name="c7n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c7l2)">
          <input type="text" name="c7l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c7n2)">
          <input type="text" name="c7n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c7n3)"> /
          <input type="text" name="c7n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c7n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t7)"> -
          <input type="text" name="t7" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t7']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8l1)" >&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;
        8.&nbsp;<input type="text" name="c8l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8n1)">
          <input type="text" name="c8n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.c8l2)">
          <input type="text" name="c8l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c8n2)">
          <input type="text" name="c8n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.c8n3)"> /
          <input type="text" name="c8n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c8n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas2.t8)"> -
          <input type="text" name="t8" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t8']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas2.c9l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;&nbsp;&nbsp;
        9.&nbsp;<input type="text" name="c9l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c9n1)">
          <input type="text" name="c9n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c9l2)">
          <input type="text" name="c9l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c9n2)">
          <input type="text" name="c9n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c9n3)"> /
          <input type="text" name="c9n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c9n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t9)"> -
          <input type="text" name="t9" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t9']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10l1)" >&nbsp;&nbsp; 
        &nbsp;
       10.&nbsp;<input type="text" name="c10l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10n1)">
          <input type="text" name="c10n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c10l2)">
          <input type="text" name="c10l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c10n2)">
          <input type="text" name="c10n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c10n3)"> /
          <input type="text" name="c10n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c10n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t10)"> -
          <input type="text" name="t10" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t10']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11l1)" >&nbsp;&nbsp; 
      </td>
	 </tr>
	 <tr>
	   <td class="izq-color"></td>
      <td class="der-color" >
        &nbsp;
       11.&nbsp;<input type="text" name="c11l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11n1)">
          <input type="text" name="c11n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c11l2)">
          <input type="text" name="c11l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c11n2)">
          <input type="text" name="c11n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c11n3)"> /
          <input type="text" name="c11n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c11n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t11)"> -
          <input type="text" name="t11" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t11']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12l1)" >&nbsp;&nbsp; 
        &nbsp;
       12.&nbsp;<input type="text" name="c12l1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,7, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12l1']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12n1)">
          <input type="text" name="c12n1" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12n1']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas3.c12l2)">
          <input type="text" name="c12l2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,5, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12l2']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.c12n2)">
          <input type="text" name="c12n2" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12n2']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.c12n3)"> /
          <input type="text" name="c12n3" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,2, this)" value='<?php echo $_smarty_tpl->tpl_vars['c12n3']->value;?>
' size="3" maxlength="5" onKeyup="checkLength(event,this,5,document.formarcas3.t12)"> -
          <input type="text" name="t12" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' onKeyPress="return acceptChar(event,8, this)" value='<?php echo $_smarty_tpl->tpl_vars['t12']->value;?>
' size="1" maxlength="1" onKeyup="checkLength(event,this,1,document.formarcas3.vinveni)" >&nbsp;&nbsp; 
      </td>
	 </tr>
    <tr>
      <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo15']->value;?>
</td>
      <td class="der-color" colspan="2" >
        <input type="text" name="edicion" '<?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['edicion']->value;?>
' size="1" maxlength="2" onKeyup="checkLength(event,this,2,document.formarcas2.vnprior)">
      </td>
    </tr>
    <tr>
      <td class="izq-color"></td>
      <td class="der-color"></td>
    </tr>  
  </table>
  &nbsp;&nbsp;
  <table width="230" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt">
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
         <a href="p_ingsol55.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>   
      <?php }?>    
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3 || $_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
         <a href="p_ingsol55.php?vopc=3"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a>  
      <?php }?>    
    </td>      
    <td class="cnt">
         <a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>
<?php }
}
