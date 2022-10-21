<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:47:09
  from '\var\www\apl\sipi\templates\z_estatus.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef4ade99590_30408518',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a8927aa1f84b3a9b04f90b40e86a7590cb638c9c' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\z_estatus.tpl',
      1 => 1300115467,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef4ade99590_30408518 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_radios.php','function'=>'smarty_function_html_radios',),1=>array('file'=>'C:\\xampp\\smarty\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus()">

<div align="center">

<form name="frmstatus1" action="z_estatus.php?vopc=1" method="POST">

  <table>
  <tr>
    <tr>
      <td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
      <td class="der-color">
        <input type="text" name='estatus' size="3" maxlength="3" value='<?php echo $_smarty_tpl->tpl_vars['estatus']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,3,document.frmstatus2.nombre)" onchange="valagente(document.frmstatus1.estatus,document.frmstatus2.estatus2)">&nbsp;
        <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
          <?php echo smarty_function_html_radios(array('name'=>"tipoder",'values'=>$_smarty_tpl->tpl_vars['tipo_der']->value,'selected'=>$_smarty_tpl->tpl_vars['tipoder']->value,'output'=>$_smarty_tpl->tpl_vars['dere_def']->value),$_smarty_tpl);?>

        <?php }?>    
      </td>	
      <td class="cnt">
        <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
	        <input type='image' src="../imagenes/search_f2.png" width="28" height="24" value="Buscar">  Buscar  
        <?php }?>
      </td>
    </tr>
  </tr>
  </table>
</form>				  

<form name="frmstatus2" action="z_estatus.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='accion' value=<?php echo $_smarty_tpl->tpl_vars['accion']->value;?>
>
  <input type ='hidden' name='estatus' value=<?php echo $_smarty_tpl->tpl_vars['estatus']->value;?>
>
  <input type ='hidden' name='estatus2' value=<?php echo $_smarty_tpl->tpl_vars['estatus2']->value;?>
>
  <input type ='hidden' name='vstring' value='<?php echo $_smarty_tpl->tpl_vars['vstring']->value;?>
'>
  <input type ='hidden' name='campos' value='<?php echo $_smarty_tpl->tpl_vars['campos']->value;?>
'>

  <table cellspacing="1" border="1">
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
</td>
      <td class="der-color">
        <input type="text" name='nombre' value='<?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['modo']->value;?>
 size="90" maxlength="90" onkeyup="this.value=this.value.toUpperCase()" onchange="checkLength(event,this,90,document.frmstatus2.publica)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color">
        <select size="1" name="publica" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 >
          <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['apli_inf']->value,'selected'=>$_smarty_tpl->tpl_vars['publica']->value,'output'=>$_smarty_tpl->tpl_vars['apli_def']->value),$_smarty_tpl);?>

        </select>
      </td>
    </tr>
    <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3 || $_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color" >
        <?php echo smarty_function_html_radios(array('name'=>"tipoder",'values'=>$_smarty_tpl->tpl_vars['tipo_der']->value,'selected'=>$_smarty_tpl->tpl_vars['tipoder']->value,'output'=>$_smarty_tpl->tpl_vars['dere_def']->value,'separator'=>"<br />"),$_smarty_tpl);?>

      </td>
    </tr>
    <?php }?>    
  </tr>
  </table></center>
  &nbsp;
  <table width="220" >
  <tr>
    <td class="cnt">
      <input type="image" <?php echo $_smarty_tpl->tpl_vars['modo2']->value;?>
 src="../imagenes/database_save.png" value="Guardar">  Guardar  </td> 
    <td class="cnt">
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1 || $_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
        <a href="z_estatus.php?vopc=4"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php }?>    
      <?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
        <a href="z_estatus.php?vopc=3"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php }?>    
    </td>      
    <td class="cnt">
      <a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0"></a>  Salir  </td>
    </td>
  </tr>
  </table>

</form>
</div>  
</body>
</html>
<?php }
}
