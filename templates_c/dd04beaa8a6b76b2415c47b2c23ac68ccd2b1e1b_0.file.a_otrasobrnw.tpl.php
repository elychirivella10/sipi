<?php
/* Smarty version 3.1.47, created on 2022-10-17 18:00:24
  from '\var\www\apl\sipi\templates\a_otrasobrnw.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d7c188a3eb4_07690459',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dd04beaa8a6b76b2415c47b2c23ac68ccd2b1e1b' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\a_otrasobrnw.tpl',
      1 => 1475602134,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d7c188a3eb4_07690459 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_radios.php','function'=>'smarty_function_html_radios',),));
?>
<html>
<head>
 <link REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
 <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
 <?php echo '<script'; ?>
 type="text/javascript" src="../include/js/tabs/tabpane.js"><?php echo '</script'; ?>
>
 <?php echo '<script'; ?>
 language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript">  
 <?php echo '</script'; ?>
>
 <?php echo '<script'; ?>
 language="javascript" src="../include/cal2.js"><?php echo '</script'; ?>
>
 <?php echo '<script'; ?>
 language="javascript" src="../include/cal_conf2.js"><?php echo '</script'; ?>
>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">
<div align="center">

<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
<form name="foroobras" action="a_otrasobrnw.php?vopc=4&vpla=<?php echo $_smarty_tpl->tpl_vars['vpla']->value;?>
" method="post">
<?php }
if ($_smarty_tpl->tpl_vars['vopc']->value == 7) {?>
<form name="foroobras" action="a_otrasobrnw.php?vopc=8&vpla=<?php echo $_smarty_tpl->tpl_vars['vpla']->value;?>
" method="post">
<?php }?>
  <table>
    <tr>
      <input type="hidden" name="nveces" value="<?php echo $_smarty_tpl->tpl_vars['nveces']->value;?>
">
      <input type="hidden" name="nconexion" value="<?php echo $_smarty_tpl->tpl_vars['nconexion']->value;?>
"> 
      <input type="hidden" name="npla" value="<?php echo $_smarty_tpl->tpl_vars['vpla']->value;?>
"> 
      <input type="hidden" name="nhora" value="<?php echo $_smarty_tpl->tpl_vars['vhora']->value;?>
"> 
      <td class="izq5-color">Planilla No.</td>
      <td class="der-color">
        <input type="text" name="vsol" size="4" maxlength="16" value='<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 
               onkeyup="checkLength (event,this,6,document.foroobras.vfechas)"
               onchange="Newsol(document.foroobras.vsol,6,document.foroobras.npla,document.foroobras.nhora)">
      </td>	
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
      <td class="cnt">
          <input type="image" src="../imagenes/boton_nuevasolicitud_azul.png" value="Nueva Solicitud">
      </td>
      <?php }?> 	
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 7) {?>
      <td class="cnt">
  	  <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar">
      </td>
      <?php }?> 	  
      </td>
    </tr>
  </table>
</form>


<form name="forautor" id="forautor" enctype="multipart/form-data" 
      action="a_otrasobrnw.php?vopc=<?php echo $_smarty_tpl->tpl_vars['accion']->value;?>
&vpla=<?php echo $_smarty_tpl->tpl_vars['vpla']->value;?>
" 
      method="POST" onsubmit='return pregunta();'> 
  <input type ='hidden' name='vsol' value=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
>
<table>
<tr>  
  <table>
  <tr>
    <input type="hidden" name="nveces" value="<?php echo $_smarty_tpl->tpl_vars['nveces']->value;?>
">
    <input type="hidden" name="nconexion" value="<?php echo $_smarty_tpl->tpl_vars['nconexion']->value;?>
"> 
    <td width="100%"><div><strong> </strong></div></td>
    <td align="rigth">
    <table>
    <tr>
      <td>
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 8 || $_smarty_tpl->tpl_vars['vopc']->value == 7) {?>
      <a href="a_otrasobrnw.php?vopc=7&vpla=<?php echo $_smarty_tpl->tpl_vars['vpla']->value;?>
&nveces=<?php echo $_smarty_tpl->tpl_vars['nveces']->value;?>
&nconexion=<?php echo $_smarty_tpl->tpl_vars['nconexion']->value;?>
" onmouseout="MM_swapImgRestore();"  
      <?php } else { ?>
      <a href="a_otrasobrnw.php?vopc=3&vpla=<?php echo $_smarty_tpl->tpl_vars['vpla']->value;?>
&nveces=<?php echo $_smarty_tpl->tpl_vars['nveces']->value;?>
&nconexion=<?php echo $_smarty_tpl->tpl_vars['nconexion']->value;?>
" onmouseout="MM_swapImgRestore();"  
      <?php }?>
         onmouseover="MM_swapImage('cancel','','../imagenes/boton_cancelar_rojo.png',1);">
	 <img src="../imagenes/boton_cancelar_rojo.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
      </td>
      <td>&nbsp;</td>
      <td>
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 4 || $_smarty_tpl->tpl_vars['vopc']->value == 1 || $_smarty_tpl->tpl_vars['vopc']->value == 8) {?>
      <input type="image" onmouseout="MM_swapImgRestore();" 
             onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" 
             src="../imagenes/boton_guardar_rojo.png" alt="Save" align="middle" name="save" border="0" 
             onclick="validate();return returnVal;"/>
      <?php } else { ?>
      <a><img src="../imagenes/boton_guardar_rojo.png" onmouseout="MM_swapImgRestore();" 
              onmouseover="MM_swapImage('save','','../imagenes/boton_guardar_rojo.png',1);" alt="Save" 
              align="middle" name="save" border="0" /></a>
      <?php }?>
      </td>
      <td>&nbsp;</td>
      <td>
      <a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['nconexion']->value;?>
" onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('salir','','../imagenes/boton_salir_rojo.png',1);">
      <img src="../imagenes/boton_salir_rojo.png" alt="Salir" align="middle" name="salir" border="0" /></a>
      </td>
      <td>&nbsp;</td>
    </tr>
    </table>
  </tr>
  </table> 
 
<!--  <table align="center" border="2" cellspacing="3"> -->
  <tr>
  <div class="tab-page" id="modules-cpanel">
  <?php echo '<script'; ?>
 type="text/javascript">
  var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
  <?php echo '</script'; ?>
> 
<!--  &nbsp;
  </div></tr></table> -->
 
  <div class="tab-page" id="Obra"><h2 class="tab">Obra</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Obra" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="1">
         <tr>
           <td width="30%" class="izq-color">Fecha Solicitud:</td>
           <td width="70%">
           <input type="text" name="vfechas" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vfechas']->value;?>
' size="10" align="left" 
                  onkeyup="checkLength(event,this,10,document.forautor.vnumpla)" 
                  onchange="valFecha(this,document.forautor.vnumpla)">
                  &nbsp;&nbsp;
                  <small><a href="javascript:showCal('Calendar3');" 
                     onMouseOver="window.status='Seleccionar fecha'; return true;" 
                     onMouseOut="window.status=''; return true; ">
                  <img src="../imagenes/calendar2.gif" align="middle" 
                       width=26 height=24 border=0></a>
                  </small>
           <input type="hidden" name="vnumpla" value="<?php echo $_smarty_tpl->tpl_vars['vnumpla']->value;?>
">                  
           </td>
           <!-- <td>
           <input type="hidden" name="vnumpla" value="<?php echo $_smarty_tpl->tpl_vars['vnumpla']->value;?>
">
           </td> -->
         </tr> 
         <tr>
           <td width="30%" class="izq-color">T&iacute;tulo:</td>
           <td width="70%"> <!-- colspan="3" -->
           <input type"text" name="vtitulo" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vtitulo']->value;?>
' size="182" maxlength="300" onKeyup="this.value=this.value.toUpperCase()"> 
           </td>
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Pa&iacute;s de Origen:</td>
           <td width="70%">
           <input type="hidden" name="vpaisor" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vpaisor']->value;?>
' size="2" maxlength="2" 
                  align="left" onKeyup="this.value=this.value.toUpperCase();
                  checkLength(event,this,2,document.forautor.vpaisor)" 
                  onchange="valagente(document.forautor.vpaisor,document.forautor.pais)">
           <select size="1" name="pais" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 
                   onchange="this.form.vpaisor.value=this.options[this.selectedIndex].value">
                   <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraycodpais']->value,'selected'=>$_smarty_tpl->tpl_vars['vpaisor']->value,'output'=>$_smarty_tpl->tpl_vars['arraynompais']->value),$_smarty_tpl);?>

           </select>
         </td>
         </tr>
         <tr>
         <td width="30%" class="izq-color">Idioma Original:</td>
         <td width="70%">  
           <input type="hidden" name="vidioma" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vidioma']->value;?>
' size="2" maxlength="2" 
                  align="left" onKeyup="this.value=this.value.toUpperCase();
                  checkLength(event,this,2,document.forautor.vtraduc)" 
                  onchange="valagente(document.forautor.vidioma,document.forautor.idioma)">
           <select size="1" name="idioma" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 
                   onchange="this.form.vidioma.value=this.options[this.selectedIndex].value">
                   <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraycodidiom']->value,'selected'=>$_smarty_tpl->tpl_vars['vidioma']->value,'output'=>$_smarty_tpl->tpl_vars['arraynomidiom']->value),$_smarty_tpl);?>

           </select>
           </td>
         </tr>
         <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'AV') {?>
         <tr>
           <td class="izq-color" >Genero:</td>
           <td> <!-- colspan="3" -->
              <input type="text" name="vgener2" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vgener2']->value;?>
' size="175" maxlength="300" onKeyup="this.value=this.value.toUpperCase();">
           </td> 
         </tr>
         <?php }?> 
         <tr>
           <td width="30%" class="izq-color">Traducci&oacute;n:</td>
           <td width="70%" > <!-- colspan="3" -->
              <input type="text" name="vtraduc" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vtraduc']->value;?>
' size="182" maxlength="300" onKeyup="this.value=this.value.toUpperCase();">
           </td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >A&ntilde;o Realizaci&oacute;n:</td>
           <td width="70%">
           <input type="text" name="vanorea" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vanorea']->value;?>
' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vanoppu)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color">A&ntilde;o 1era Publicaci&oacute;n:</td> 
           <td width="70%"> 
           <input type="text" name="vanoppu" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vanoppu']->value;?>
' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vdescri)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td>  
         </tr>
         <?php if ($_smarty_tpl->tpl_vars['vpla']->value != 'OE') {?>
         <tr>
           <td width="30%" class="izq-color" >Descripci&oacute;n:</td>
           <td width="70%"> <!-- colspan="3" -->
             <textarea row="2" name="vdescri" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vdescri']->value;?>
' cols="138" maxlength="300"><?php echo $_smarty_tpl->tpl_vars['vdescri']->value;?>
</textarea>
           </td> 
         </tr>
         <?php }?> 
        <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'OM') {?>
        </table>
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="17%" class="izq-color" >Letra:</td>
           <td width="27">
           <?php echo smarty_function_html_radios(array('name'=>"vletra",'values'=>$_smarty_tpl->tpl_vars['vletra_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vletra']->value,'output'=>$_smarty_tpl->tpl_vars['vletra_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td> 
           <td width="5%" class="izq-color" >Genero:</td>
           <td width="23%">
           <input type="hidden" name="vgenero" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vgenero']->value;?>
' size="25" 
                  maxlength="30" align="left" onKeyup="this.value=this.value.toUpperCase();
                  checkLength(event,this,2,document.forautor.ritmo)" 
                  onchange="valagente(document.forautor.vgenero,document.forautor.genero)">
           <select size="1" name="genero" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 
                   onchange="this.form.vgenero.value=this.options[this.selectedIndex].value">
                   <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['arraycodgenero']->value,'selected'=>$_smarty_tpl->tpl_vars['vgenero']->value,'output'=>$_smarty_tpl->tpl_vars['arraynomgenero']->value),$_smarty_tpl);?>

           </select>

           <td width="5%" class="izq-color" >Ritmo:</td>
           <td width="23%">
           <input type="text" name="vritmo" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vritmo']->value;?>
' size="25" maxlength="30" onKeyup="this.value=this.value.toUpperCase();">
           </td> 
         </tr>
        </table>
        <?php }?>
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="17%" class="izq-color" >Clasificaci&oacute;n:</td>
           <td width="23%">
             <?php echo smarty_function_html_radios(array('name'=>"vclasif",'values'=>$_smarty_tpl->tpl_vars['vclasif_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vclasif']->value,'output'=>$_smarty_tpl->tpl_vars['vclasif_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td>
           <td width="25%">
             <?php echo smarty_function_html_radios(array('name'=>"vorigen",'values'=>$_smarty_tpl->tpl_vars['vorigen_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vorigen']->value,'output'=>$_smarty_tpl->tpl_vars['vorigen_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td>
           <td width="35%">
             <?php echo smarty_function_html_radios(array('name'=>"vforma",'values'=>$_smarty_tpl->tpl_vars['vforma_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vforma']->value,'output'=>$_smarty_tpl->tpl_vars['vforma_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td>
         </tr>
        </table>
        &nbsp;
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2" width="100%" class="izq3-color" >
            En caso de ser una obra derivada, Indicar:</td>
         </tr>
         <tr>
           <td width="30%" class="izq-color" >T&iacute;tulo Obra Originaria:</td>
           <td width="70%">
           <input type="text" name="vtit_oo" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vtit_oo']->value;?>
' size="182" maxlength="300" 
                  onKeyup="this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Autor Obra Originaria:</td>
           <td width="70%">
           <input type="text" name="vaut_oo" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vaut_oo']->value;?>
' size="182" maxlength="300" 
                  onKeyup="this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Tipo Obra Derivada:</td>
           <td width="70%">
           <select name="vtip_od" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vtip_od']->value;?>
'>
	           <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vtip_od_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vtip_od']->value,'output'=>$_smarty_tpl->tpl_vars['vtip_od_de']->value),$_smarty_tpl);?>

	        </select>
           </td>  
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >A&ntilde;o publicaci&oacute;n Obra Originaria:</td>
           <td width="70%">
           <input type="text" name="vano_oo" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vano_oo']->value;?>
' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vdat_pf)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td>  
         </tr>         
        </table>
        &nbsp;
        <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'OE') {?>
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >Tipo Obra Escenica:</td>
           <td width="70%">
             <?php echo smarty_function_html_radios(array('name'=>"vcla_oe",'values'=>$_smarty_tpl->tpl_vars['vcla_oe_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vcla_oe']->value,'output'=>$_smarty_tpl->tpl_vars['vcla_oe_de']->value,'separator'=>''),$_smarty_tpl);?>

             <input type="text" name="votroto" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['votroto']->value;?>
' size="30" maxlength="60" onKeyup="this.value=this.value.toUpperCase();">
           </td>
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Breve descripci&oacute;n Argumento:</td>
           <td width="70%">
           <textarea row="2" name="vdesarg" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vdesarg']->value;?>
' cols="138" maxlength="600"><?php echo $_smarty_tpl->tpl_vars['vdesarg']->value;?>
</textarea></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Breve descripci&oacute;n Musica:</td>
           <td width="70%">  
           <textarea row="2" name="vdesmus" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vdesmus']->value;?>
' cols="138" maxlength="600"><?php echo $_smarty_tpl->tpl_vars['vdesmus']->value;?>
</textarea></td>  
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >Breve descripci&oacute;n Movimientos:</td>
           <td width="70%">
           <textarea row="2" name="vdesmov" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vdesmov']->value;?>
' cols="138" maxlength="600"><?php echo $_smarty_tpl->tpl_vars['vdesmov']->value;?>
</textarea></td>  
         </tr>
        </table>
        &nbsp;
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'OM') {?>
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2" width="100%" class="izq3-color" >
            En caso de que la obra haya sido fijada con fines de distribuci&oacute;n comercial, Indicar:
           </td>
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Datos Productor Fonogr&aacute;fico:</td>
           <td width="70%">
           <input type="text" name="vdat_pf" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vdat_pf']->value;?>
' size="182" maxlength="300" onKeyup="this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr> 
           <td width="30%" class="izq-color" >A&ntilde;o de la Fijaci&oacute;n Sonora:</td>
           <td width="30%">
           <input type="text" name="vano_fs" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vano_fs']->value;?>
' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vexhibi)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td>  
         </tr>
        </table> 
        &nbsp;
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'AV') {?>
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >Esta Exhibida Permanentemente?:</td>
           <td width="08">
           <?php echo smarty_function_html_radios(array('name'=>"vexhibi",'values'=>$_smarty_tpl->tpl_vars['vexhibi_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vexhibi']->value,'output'=>$_smarty_tpl->tpl_vars['vexhibi_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td> 
           <td width="10%" class="izq-color" >Ubicaci&oacute;n:</td>
           <td width="50%">
           <input type="text" name="vubi_ex" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vubi_ex']->value;?>
' size="110" maxlength="120"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >La Obra ha sido Publicada?:</td>
           <td width="08">
           <?php echo smarty_function_html_radios(array('name'=>"vpublic",'values'=>$_smarty_tpl->tpl_vars['vpublic_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vpublic']->value,'output'=>$_smarty_tpl->tpl_vars['vpublic_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td> 
           <td width="10%" class="izq-color" >Publicaci&oacute;n:</td>
           <td width="50%">
           <input type="text" name="vdat_pu" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vdat_pu']->value;?>
' size="110" maxlength="120"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >La Obra ha sido Edificada?:</td>
           <td width="08">
           <?php echo smarty_function_html_radios(array('name'=>"vedific",'values'=>$_smarty_tpl->tpl_vars['vedific_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vedific']->value,'output'=>$_smarty_tpl->tpl_vars['vedific_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td> 
           <td width="10%" class="izq-color" >Ubicaci&oacute;n:</td>
           <td width="50%">
           <input type="text" name="vubi_ed" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vubi_ed']->value;?>
' size="110" maxlength="120"></td> 
         </tr>
        </table>
        &nbsp;
        <?php }?> 
       </div>
  </div>

  <?php if ($_smarty_tpl->tpl_vars['vpla']->value != 'AR') {?>
  <div class="tab-page" id="Autor"><h2 class="tab">Autor(es)</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Autor" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="autor" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['autor']->value;?>
' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_a" value="Natural" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.Nperson_a)">
          <input type="button" name="Jperson_a" value="Juridica" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.Jperson_a)">
          <input type="button" name="CorregirU" value="Corregir" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.CorregirU)">
          <input type="button" name="EliminarU" value="Eliminar" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseautor(document.forautor.vsol,document.forautor.autor,document.forautor.EliminarU)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Autor"></iframe>
          </td></tr>
          <!-- <tr>
          <td colspan="2"> 
          <iframe name='frameauto' id='frameauto' style='width:100%;height:120px' 
                 src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Autor"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
        </table>
       </div>
  </div>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'AR') {?>
  <div class="tab-page" id="Coautor"><h2 class="tab">Co-autor(es)</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Coautor" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td width="16%" class="izq-color">Nombre o Raz&oacute;n Social:</td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="coautor" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['coautor']->value;?>
' size="60" 
                maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_c" value="Natural" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 
                onclick="browsecoautor(document.forautor.vsol,document.forautor.coautor, 
                         document.forautor.Nperson_c)">
          <input type="button" name="Jperson_c" value="Juridica" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 
                 onclick="browsecoautor
                (document.forautor.vsol,document.forautor.coautor,document.forautor.Jperson_c)">
          </td></tr>
          <tr>
          <td class="izq-color">Director o Realizador: </td>
          <td class="der-color">
          <iframe name='framecoauto1' id='framecoauto1' style='width:100%;height:70px' 
                 src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Coautor1"></iframe></td></tr>
         </div>
         </td>
         </tr>
         <tr>
         <td class="izq-color">Autor del Argumento de la Adaptaci&oacute;n:</td>
         <td class="der-color">
         <div id="resultado">
          <iframe name='framecoauto2' id='framecoauto2' style='width:100%;height:70px' 
                 src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Coautor2"></iframe></td></tr>
         </div>
         </td>
         </tr>
         <tr>
         <td class="izq-color">Autor del Gui&oacute;n o de los Di&aacute;logos:</td>
         <td class="der-color">
         <div id="resultado">
          <iframe name='framecoauto3' id='framecoauto3' style='width:100%;height:70px' 
                 src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Coautor3"></iframe></td></tr>
         </div>
         </td>
         </tr>
         <tr>
         <td class="izq-color">Autor de la M&uacute;sica especialmente compuesta:</td>
         <td class="der-color">
         <div id="resultado">
          <iframe name='framecoauto4' id='framecoauto4' style='width:100%;height:70px' 
                 src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Coautor4"></iframe></td></tr>
         </div>
         </td>
         </tr>
        </table>
       </div> 
  </div>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'OE' || $_smarty_tpl->tpl_vars['vpla']->value == 'AR' || $_smarty_tpl->tpl_vars['vpla']->value == 'PC') {?>
  <div class="tab-page" id="Productor"><h2 class="tab">Productor(es)</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Productor" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="productor" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['productor']->value;?>
' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_p" value="Natural" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.Nperson_p)">
          <input type="button" name="Jperson_p" value="Juridica" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.Jperson_p)">
          <input type="button" name="CorregirP" value="Corregir" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.CorregirP)">
          <input type="button" name="EliminarP" value="Eliminar" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseproductor(document.forautor.vsol,document.forautor.productor,document.forautor.EliminarP)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Productor"></iframe>
          </td></tr>
          <!-- <tr>
          <td colspan="2"> 
          <iframe name='frameproductor' id='frameproductor' style='width:100%;height:120px' 
                 src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Productor"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
        </table>
       </div>
  </div>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['vpla']->value != 'OE') {?>
  <div class="tab-page" id="Titular"><h2 class="tab">Titular(es)</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Titular" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="titular" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['titular']->value;?>
' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_t" value="Natural" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.Nperson_t)">
          <input type="button" name="Jperson_t" value="Juridica" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.Jperson_t)">
          <input type="button" name="CorregirT" value="Corregir" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.CorregirT)">
          <input type="button" name="EliminarT" value="Eliminar" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsetitular(document.forautor.vsol,document.forautor.titular,document.forautor.EliminarT)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Titular"></iframe>
          </td></tr>
          <!--<tr>
          <td colspan="2"> 
          <iframe name='frametitular' id='frametitular' style='width:100%;height:120px' src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Titular"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
        </table>
       </div>
  </div>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'OE') {?>
  <div class="tab-page" id="Fijacion"><h2 class="tab">Fijaci&oacute;n</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Fijacion" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >A&ntilde;o de Fijaci&oacute;n:</td>
           <td width="70%">
           <input type="text" name="vano_fi" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vano_fi']->value;?>
' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vtip_fi)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td> 
         </tr>
         <tr> 
           <td class="izq-color" >Tipo de Fijaci&oacute;n:</td>
           <td>
           <select name="vtip_fi">
	        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vtip_fi_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vtip_fi']->value,'output'=>$_smarty_tpl->tpl_vars['vtip_fi_de']->value),$_smarty_tpl);?>

	    </select> 
           </td>  
         </tr> 
         <tr>
           <td class="izq-color" >Ficha T&eacute;cnica:</td>
           <td>
           <textarea rows="4" name="vobs_fi" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vobs_fi']->value;?>
' cols="136" maxlength="300"><?php echo $_smarty_tpl->tpl_vars['vobs_fi']->value;?>
</textarea></td> 
         </tr>
        </table>   
       </div>
  </div>
  <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'AR') {?>
  <div class="tab-page" id="Artistas"><h2 class="tab">Artista(s)</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Artistas" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td class="izq-color">Nombre del Artista:</td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="atista" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['atista']->value;?>
' size="60" 
                maxlength="300" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_a" value="Incluir Artista" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 
                onclick="browseatista(document.forautor.vsol,document.forautor.atista, 
                         document.forautor.Nperson_a)">
          </td></tr>
          <tr>
          <td colspan="2"> 
          <iframe name='frameatista' id='frameatista' style='width:100%;height:160px' src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Atista"></iframe></td></tr>
         </div>
         </td>
         </tr>
 
        </table>
       </div>
  </div>
  <?php }?>

  <div class="tab-page" id="Transferencia"><h2 class="tab">Transferencia</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Transferencia" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="10%" class="izq-color" >Transferencia:</td>
           <td width="90%">
           <textarea rows="4" name="vtransf" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vtransf']->value;?>
' cols="157" maxlength="300"><?php echo $_smarty_tpl->tpl_vars['vtransf']->value;?>
</textarea></td> 
         </tr>
        </table>
       </div>
  </div>
  
  <?php if ($_smarty_tpl->tpl_vars['vpla']->value == 'OL' || $_smarty_tpl->tpl_vars['vpla']->value == 'PC') {?>
  <div class="tab-page" id="Editor"><h2 class="tab">Editor/Impresor</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Editor" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
         <td width="20%" class="izq-color">Nombre o Raz&oacute;n Social: </td>
         <td colspan="3" class="der-color">
         <div id="resultado">
          <input type="text" name="editor" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['editor']->value;?>
' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson_e" value="Natural" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.Nperson_e)">
          <input type="button" name="Jperson_e" value="Juridica" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.Jperson_e)">
          <input type="button" name="CorregirE" value="Corregir" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.CorregirE)">
          <input type="button" name="EliminarE" value="Eliminar" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browseeditor(document.forautor.vsol,document.forautor.editor,document.forautor.EliminarE)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Editor"></iframe>
          <!-- <iframe name='frameeditor' id='frameeditor' style='width:100%;height:90px' src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Editor"></iframe></td></tr> -->
         </div>
         </td>
         </tr>
         <tr>
           <td class="izq-color" >Tipo:</td>
           <td>
           <?php echo smarty_function_html_radios(array('name'=>"vtipoed",'values'=>$_smarty_tpl->tpl_vars['vtipoed_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vtipoed']->value,'output'=>$_smarty_tpl->tpl_vars['vtipoed_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td> 
         </tr>
         <tr>
           <td class="izq-color" >A&ntilde;o de Publicaci&oacute;n:</td>
           <td>
           <input type="text" name="vanopue" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vanopue']->value;?>
' size="3" maxlength="4"
                  onkeyup="checkLength(event,this,4,document.forautor.vnoedic)" 
                  onKeyPress="return acceptChar(event,2, this)"
                  onchange="valanno(this,document.forautor.vfechas)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >No. de Edici&oacute;n:</td>
           <td>
           <input type="text" name="vnoedic" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vnoedic']->value;?>
' size="8" maxlength="10"
                  onkeyup="checkLength(event,this,3,document.forautor.vnoejem)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >No. de Ejemplares:</td>
           <td>
           <input type="text" name="vnoejem" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vnoejem']->value;?>
' size="8" maxlength="10"
                  onkeyup="checkLength(event,this,3,document.forautor.vcar_ed)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >Caracter&iacute;sticas Edici&oacute;n:</td>
           <td colspan="3">
           <input type="text" name="vcar_ed" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vcar_ed']->value;?>
' size="91" 
                  maxlength="300"></td> 
         </tr>
        </table>
       </div>
  </div>
  <?php }?>

  <div class="tab-page" id="solicitante"><h2 class="tab">Solicitante</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "solicitante" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
       <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
        <tr>
         <td width="20%" class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo15']->value;?>
</td>
         <td class="der-color">
         <div id="resultado">
          <input type="text" name="solicitante" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['solicitante']->value;?>
' size="60" maxlength="150" onChange="javascript:this.value=this.value.toUpperCase();">
          <input type="button" name="Nperson" value="Natural" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Nperson)">
          <input type="button" name="Jperson" value="Juridica" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Jperson)">
          <input type="button" name="Corregir" value="Corregir" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Corregir)">
          <input type="button" name="Eliminar" value="Eliminar" <?php echo $_smarty_tpl->tpl_vars['bmodo']->value;?>
 onclick="browsesolicitante(document.forautor.vsol,document.forautor.solicitante,document.forautor.Eliminar)">
          <iframe name='framesoli' id='framesoli' style='width:100%;height:100px' src="d_vernatjur.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Solicitante"></iframe>                                
          <!-- <iframe name='framesoli' id='framesoli' style='width:100%;height:90px' src="d_consoli.php?psol=<?php echo $_smarty_tpl->tpl_vars['vsol']->value;?>
&vtipo=Solicitante"></iframe> -->
         </div>
         </td>
        </tr> 
        <tr>
         <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo16']->value;?>
</td>
         <td class="der-color"><small>
            <?php echo smarty_function_html_radios(array('name'=>"tipo_caracter",'values'=>$_smarty_tpl->tpl_vars['tipo_carac']->value,'selected'=>$_smarty_tpl->tpl_vars['tipo_caracter']->value,'output'=>$_smarty_tpl->tpl_vars['carac_def']->value,'separator'=>''),$_smarty_tpl);?>
</small>
         </td>
        </tr> 
        <tr>
         <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo17']->value;?>
</td>
         <td class="der-color">
         <input type="text" name="otro_caracter" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['otro_caracter']->value;?>
' size="85" maxlength="100" onKeyup="this.value=this.value.toUpperCase()">
         </td>
        </tr>
        <tr>
         <td class="izq-color"><?php echo $_smarty_tpl->tpl_vars['campo18']->value;?>
</td>
         <td class="der-color">
         <textarea rows="2" name="prueba_repres" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 cols="140" maxlength="1024" onKeyup="this.value=this.value.toUpperCase()"><?php echo $_smarty_tpl->tpl_vars['prueba_repres']->value;?>
</textarea>
         </td>
        </tr>
       </table>
       </div>
  </div>
   
  <div class="tab-page" id="Deposito"><h2 class="tab">Dep&oacute;sito</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "Deposito" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >N&uacute;mero Ejemplares Depositados:</td>
           <td width="70%">
           <input type="text" name="vnum_ej" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vnum_ej']->value;?>
' size="8" maxlength="10"
                  onkeyup="checkLength(event,this,3,document.forautor.vsop_de)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td class="izq-color" >Tipo de Soporte Material:</td>
           <td>
           <input type="text" name="vsop_de" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vsop_de']->value;?>
' size="89" 
                  maxlength="100" onkeyup="checkLength(event,this,100,document.forautor.vobs_de);
                  this.value=this.value.toUpperCase();"></td> 
         </tr>
         <tr>
           <td class="izq-color" >Observaciones:</td>
           <td>
           <textarea rows="4" name="vobs_de" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vobs_de']->value;?>
' cols="130" maxlength="300"><?php echo $_smarty_tpl->tpl_vars['vobs_de']->value;?>
</textarea></td> 
         </tr>
        </table>        
       </div>
   </div>

   <div class="tab-page" id="hoja_ad"><h2 class="tab">Hoja Adicional</h2>
       <?php echo '<script'; ?>
 type="text/javascript">
       tabPane1.addTabPage( document.getElementById( "hoja_ad" ) );
       <?php echo '</script'; ?>
>
       <div align="left">
        <table width="100%" bgcolor=#FFFFFF border="1" cellspacing="0" cellpadding="0">
         <tr>
           <td width="30%" class="izq-color" >Incluye Hojas Adicionales?:</td>
           <td width="70%">
           <?php echo smarty_function_html_radios(array('name'=>"vhoj_ad",'values'=>$_smarty_tpl->tpl_vars['vhoj_ad_id']->value,'selected'=>$_smarty_tpl->tpl_vars['vhoj_ad']->value,'output'=>$_smarty_tpl->tpl_vars['vhoj_ad_de']->value,'separator'=>''),$_smarty_tpl);?>

           </td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >N&uacute;mero Hojas Adicionales Anexas:</td>
           <td width="70%">
           <input type="text" name="vnum_ho" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vnum_ho']->value;?>
' size="3" maxlength="5"
                  onkeyup="checkLength(event,this,3,document.forautor.vamplia)" 
                  onKeyPress="return acceptChar(event,2, this)"></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Datos que han sido ampliados en Hojas adicionales:</td>
           <td width="70%">
             <textarea rows="2" name="vamplia" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vamplia']->value;?>
' cols="130" maxlength="300"><?php echo $_smarty_tpl->tpl_vars['vamplia']->value;?>
</textarea></td> 
         </tr>
         <tr>
           <td width="30%" class="izq-color" >Datos Adicionales:</td>
           <td width="70%">
             <textarea rows="8" name="vadicio" <?php echo $_smarty_tpl->tpl_vars['modo1']->value;?>
 value='<?php echo $_smarty_tpl->tpl_vars['vadicio']->value;?>
' cols="130" maxlength="30000"><?php echo $_smarty_tpl->tpl_vars['vadicio']->value;?>
</textarea></td> 
         </tr>
        </table>        
       </div>
  </div>
  </tr>
  </table>
  &nbsp;
</div>
</form>
</body>
</html>
<?php }
}
