<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:47:52
  from '\var\www\apl\sipi\templates\b_numimp.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634ef4d8eed3e5_52393691',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3d63fca44081e7f28e172681f2fbfcd948b22a24' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\b_numimp.tpl',
      1 => 1301062849,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634ef4d8eed3e5_52393691 (Smarty_Internal_Template $_smarty_tpl) {
?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</style>
</head>

<body>
<div align="center">
<table>
<tr>
<td>
<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 1) {?>
  <form name="forboletin1" id="forboletin1" action="b_numimp.php?vopc=2" method="post">
<?php }?>

  <div align="center">
  <span class="style1"><b>Orden de Numeros de Paginas a Imprimir </b> </span><br />
 <br />
  <br />

  <br>
  Pag. Inicial: <input name="pag_ini" type="text" size="4" maxlength="4" >
    <br>
  Pag. Final: <input name="pag_fin" type="text" size="4" maxlength="4" >
    <br>
  <br />
  <br />
  
  <img src="../imagenes/library.png" width="60" height="40" >
  <input type="submit" name="Submit" class="boton_blue" value="Calcular!" />
  <br />
  <br />

</td> 

  <br />
  <br />

     <table width="210">
        <tr>
        <td class="cnt"><a href="b_numimp.php?vopc=1&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>
</form>				  
</div>  


</body>
</html>
<?php }
}
