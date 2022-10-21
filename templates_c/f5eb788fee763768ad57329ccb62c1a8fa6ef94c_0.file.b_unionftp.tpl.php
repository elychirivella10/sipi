<?php
/* Smarty version 3.1.47, created on 2022-10-18 20:23:53
  from '\var\www\apl\sipi\templates\b_unionftp.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634eef394edee5_86098521',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5eb788fee763768ad57329ccb62c1a8fa6ef94c' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\b_unionftp.tpl',
      1 => 1301062786,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634eef394edee5_86098521 (Smarty_Internal_Template $_smarty_tpl) {
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
  <form name="forboletin1" id="forboletin1" action="b_unionftp.php?vopc=2" method="post">
<?php }?>
   Archivo: <input name="archivo1" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo2" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo3" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo4" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo5" type="text" size="20" maxlength="20" >
      <br>   <br>   <br>
  <img src="../imagenes/Address.png" width="60" height="40" >
  <input type="submit" name="Submit" class="boton_blue" value="Concatenar!" />
  <br />
  <br />

 
</td> 
 <td width="15"> 
</td>
</td> 
 <td width="180" align="center"> 
  <br> Recuerde 
   <img src="../imagenes/search.png" border="0"></a>  <br>Numerar las Paginas!</td>
  <br />
  <br /> 
</td>
<td>
 &nbsp; &nbsp; 


  <br />
  <br />

</td> 
 &nbsp;
 
     <table width="210">
        <tr>
        <td class="cnt"><a href="b_unionftp.php?vopc=1&nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
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
