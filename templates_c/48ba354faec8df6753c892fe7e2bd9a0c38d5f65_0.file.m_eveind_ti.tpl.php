<?php
/* Smarty version 3.1.47, created on 2022-10-17 18:58:14
  from '\var\www\apl\sipi\templates\m_eveind_ti.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d89a6ae3ec3_89187046',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48ba354faec8df6753c892fe7e2bd9a0c38d5f65' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_eveind_ti.tpl',
      1 => 1377869934,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d89a6ae3ec3_89187046 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
</head>

<!-- <body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus();" oncontextmenu="return false" onkeydown="return false"> -->
<body onLoad="this.document.<?php echo $_smarty_tpl->tpl_vars['varfocus']->value;?>
.focus();">

<div align="center">

<form name="forevind1" action="m_ingreven_ti.php?vopc=1" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
>
  <input type ='hidden' name='role' value=<?php echo $_smarty_tpl->tpl_vars['role']->value;?>
>
  <input type ='hidden' name='anno' value=<?php echo $_smarty_tpl->tpl_vars['anno']->value;?>
>
  <input type ='hidden' name='numero' value=<?php echo $_smarty_tpl->tpl_vars['numero']->value;?>
>
  <input type ='hidden' name='nconex' value='<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
'>  
  <br><br>
  <table >
       <tr><td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo1']->value;?>
</td>
	    <td class="der-color"><input type="text" name="vsol1" size="3" maxlength="4" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vsol1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,4,document.forevind1.vsol2)">-
		                  <input type="text" name="vsol2" size="6" maxlength="6" 
		value='<?php echo $_smarty_tpl->tpl_vars['vsol2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forevind1.submit)" onchange="Rellena(document.forevind1.vsol2,6)">
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>				  
<form name="forevind2" action="m_ingreven_ti.php?vopc=2" method="post">
  <input type ='hidden' name='usuario' value=<?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
>
  <input type ='hidden' name='role' value=<?php echo $_smarty_tpl->tpl_vars['role']->value;?>
>
  <input type ='hidden' name='anno' value=<?php echo $_smarty_tpl->tpl_vars['anno']->value;?>
>
  <input type ='hidden' name='numero' value=<?php echo $_smarty_tpl->tpl_vars['numero']->value;?>
>
  <input type ='hidden' name='nconex' value='<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
'>  
  <input type ='hidden' name='vder' value=<?php echo $_smarty_tpl->tpl_vars['vder']->value;?>
>
  
	    <td>&nbsp;&nbsp;&nbsp;</td>
	    <td class="izq5-color"><?php echo $_smarty_tpl->tpl_vars['campo2']->value;?>
 </td>
	    <td class="der-color"><input type="text" name="vreg1" size="1" maxlength="1" 
	        value='<?php echo $_smarty_tpl->tpl_vars['vreg1']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,6, this)" onkeyup="checkLength(event,this,1,document.forevind2.vreg2)"
		onChange="this.value=this.value.toUpperCase()">-
		                  <input type="text" name="vreg2" size="6" maxlength="6" 
		value='<?php echo $_smarty_tpl->tpl_vars['vreg2']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['vmodo']->value;?>
 onKeyPress="return acceptChar(event,2, this)" onkeyup="checkLength(event,this,6,document.forevind2.submit)" onchange="Rellena(document.forevind2.vreg2,6)">
		 </td>
		<td class="cnt"><input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
</form>

  </table>
  &nbsp; 
  <table border="1" cellspacing="1">	

  <tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo3']->value;?>
</td>
      <td class="der-color"><input type='text' name='fecha_solic' readonly='readonly' size='8'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo4']->value;?>
</td>
      <td class="der-color"><input type='text' name='tipo_marca' readonly='readonly' size='30'></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo5']->value;?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
' readonly='readonly' size='80'>
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo6']->value;?>
</td>
      <td class="der-color"><input type='text' name='estatus' readonly='readonly' size='3'><input type='text' name='descripcion' readonly='readonly' size='75'></td>
    </tr> 
    <tr>
      <td class="izq-color" ><?php echo $_smarty_tpl->tpl_vars['campo7']->value;?>
</td>
      <td class="der-color">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
  </tr>
  </table></center>
  &nbsp;
  <table width="248" >
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
    <td class="cnt"><a href="m_eveind_ti.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
&conx=0"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
    <td class="cnt"><a href="../salir.php?nconex=<?php echo $_smarty_tpl->tpl_vars['n_conex']->value;?>
"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td> 
  </tr>
  </table>

  </div>  
</form>
<br><br><br><br><br><br>
</body>
</html>
<?php }
}
